<?php
require_once('ApiBaseController.php');

/**
 * Class ServerCombineAdviceController
 * 查询指定条件的合服建议
 */
class ServerCombineAdviceController extends ApiBaseController {

    public $platform;

    public $data;

    public $dbName;

    public $result = array();

    /**
     * @var PDO result服务器
     */
    public $pdoResult;

    public function init() {
        parent::init();
        $this->data = isset($_GET['data']) ? json_decode($_GET['data']) : null;
        $this->platform = isset($this->data->platform) ? $this->data->platform : null;
        $this->pdoResult = MysqlDb::getDbServer('lala', 'result');
        $this->dbName = 'dblala' . $this->platform . 'result';
    }

    public function run() {
        parent::run();
        try {
            $this->search();
//            print_r($this->result);
            $fset = $this->getFinalWorldIdSet();
            sort($fset);
            $this->getResponseData($fset);
            $this->sendResponse();
        } catch (Exception $e) {
            file_put_contents(dirname(__DIR__) . '/log/' . date('Y-m-d') . '.log', $e->getMessage(), 'a');
            $this->setStatus(self::STATUS_SERVER_ERROR, 'Fetch data error.');
        }

        $this->sendResponse();
    }

    public function validate() {
        if (!parent::validate()) {
            return false;
        }
        if (empty($this->platform) || empty($this->data)) {
            $this->setStatus(self::STATUS_INVALID_PARAMS, 'Missing Params');
            return false;
        }

        if (!$this->validatePlatform()) {
            return false;
        }

        return true;
    }

    public function search() {
        if (isset($this->data->days)) {
            $this->result['days'] = $this->searchByServerDays($this->data->days->num);
        }
        if (isset($this->data->avgOnline)) {
            $this->result['avgOnline'] = $this->searchByMaxOnline($this->data->avgOnline->num);
        }
        if (isset($this->data->avgPayPlayer)) {
            $this->result['avgPayPlayer'] = $this->searchByPayPlayerNum($this->data->avgPayPlayer->num);
        }
        if (isset($this->data->avgAmount)) {
            $this->result['avgAmount'] = $this->searchByAmount($this->data->avgAmount->num);
        }
    }

    public function getFinalWorldIdSet() {
        $worldIdSets = $this->getWorldIdSets($this->result);

        //处理and类型条件
        $andSet = array();
        $andFlag = false;//记录是否存在类型为and的条件
        foreach ($worldIdSets as $k => $set) {
            if ($this->data->$k->opt == 'and') {
                if (!$andFlag) {
                    $andFlag = true;
                }
                if (empty($andSet)) {
                    $andSet = $set;
                } else {
                    $andSet = array_intersect($andSet, $set);
                }
            }
        }
        //如果存在and条件，结果集为空，则不需处理or类型条件
        if ($andFlag === true && empty($andSet)) {
            return null;
        }
        //处理or类型条件
        $orFlag = false;//记录是否存在类型为or的条件
        $orSet = array();
        foreach ($worldIdSets as $k => $set) {
            if ($this->data->$k->opt == 'or') {
                if (!$orFlag) {
                    $orFlag = true;
                }
                if ($andFlag === false) {
                    $orSet[] = $set;
                } else {
                    $orSet[] = array_intersect($andSet, $set);
                }
            }
        }

        //如果不存在or条件则不需继续处理
        if (!$orFlag) {
            return $andSet;
        }
        $finalSet = array();
        foreach ($orSet as $v) {
            if (empty($finalSet)) {
                $finalSet = $v;
            } else {
                $finalSet = $this->unionArray($finalSet, $v);
            }

        }
        return $finalSet;
    }

    public function validatePlatform() {
        $stat = $this->pdoResult->prepare("SELECT 1 FROM tbplt WHERE vPname=:platform");
        $stat->execute(array(':platform' => $this->platform));
        if (count($stat->fetchAll()) == 0) {
            $this->setStatus(self::STATUS_INVALID_PARAMS, 'Unknown Platform');
            return false;
        }

        return true;
    }


    public function searchByServerDays($days) {
        $stat = $this->pdoResult->prepare("
            SELECT
                iWorldId,dtBeginDate
            FROM
                tbworldbegindate
            WHERE
                vPlt=:platform
            AND
                dtBeginDate<=(curdate() - interval :days day)
        ");
        $stat->execute(array(
            ':platform' => $this->platform,
            ':days' => $days
        ));
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByMaxOnline($num) {
        $stat = $this->pdoResult->prepare("
            SELECT
                iWorldId,
                avg(iMaxOnlineNum) iAvgMaxOnlineNum
            FROM
                {$this->dbName}.tbonlinestat
            WHERE
                dtStatDate >= (CURDATE() - INTERVAL 5 DAY)
            GROUP BY
                iWorldId
            HAVING
                avg(iMaxOnlineNum)<=:num
        ");
        $stat->execute(array(
            ':num' => $num
        ));
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByPayPlayerNum($num) {
        $stat = $this->pdoResult->prepare("
            SELECT
                iWorldId,AVG(iDayDepositNum) iAvgPlayerNum
            FROM
                {$this->dbName}.tbdaydepositor
            WHERE
                dtStatDate>=(CURDATE()-INTERVAL 5 DAY) AND iWorldId!=123456789
            GROUP BY
                iWorldId
            HAVING
                AVG(iDayDepositNum) < :num
        ");
        $stat->execute(array(
            ':num' => $num
        ));
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByAmount($num) {
        $stat = $this->pdoResult->prepare("
            SELECT
                iWorldId,avg(iAmount)/100 iAvgAmount
            FROM
                {$this->dbName}.tbdaydepositor
            WHERE
                dtStatDate>=(CURDATE()-INTERVAL 5 DAY) AND iWorldId!=123456789
            GROUP BY
                iWorldId
            HAVING
                avg(iAmount)/100 < :num
        ");
        $stat->execute(array(
            ':num' => $num
        ));
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWorldIdSets($arr) {
        $sets = array();
        foreach ($arr as $k => $v) {
            $sets[$k] = array();
            foreach ($v as $row) {
                $sets[$k][] = $row['iWorldId'];
            }
        }
        return $sets;
    }

    /**
     * 求两个数组值的并集
     * 该函数会对值进行去重
     * @param $arr1
     * @param $arr2
     * @return array
     */
    public function unionArray($arr1, $arr2) {
        return array_merge(
            array_intersect($arr1, $arr2),
            array_diff($arr1, $arr2),
            array_diff($arr2, $arr1)
        );
    }

    /**
     * 生成回应数据
     */
    public function getResponseData($worldIdSet) {
        if (empty($worldIdSet)) {
            $this->responseData = "";
            $this->setStatus(self::STATUS_NO_DATA);
            return;
        }

        $wid=implode(',',$worldIdSet);
        $stat=$this->pdoResult->prepare("
            SELECT
                '{$this->platform}' platform,a.iWorldId,dtBeginDate,iAvgMaxOnlineNum,iAvgPlayerNum,iAvgAmount
            FROM
                (
                    SELECT
                        iWorldId,
                        dtBeginDate
                    FROM
                        tbworldbegindate
                    WHERE
                        vPlt = '{$this->platform}'
                    AND iWorldId IN ($wid)
                ) a
            LEFT JOIN (
                SELECT
                    iWorldId,
                    AVG(iMaxOnlineNum) iAvgMaxOnlineNum
                FROM
                    {$this->dbName}.tbonlinestat
                WHERE
                    iWorldId IN ($wid)
                GROUP BY
                    iWorldId
            ) b ON a.iWorldId = b.iWorldId
            LEFT JOIN (
                SELECT
                    iWorldId,
                    AVG(iDayDepositNum) iAvgPlayerNum,
                    AVG(iAmount) / 100 iAvgAmount
                FROM
                    {$this->dbName}.tbdaydepositor
                WHERE
                    iWorldId IN ($wid)
                GROUP BY
                    iWorldId
            ) c ON c.iWorldId=a.iWorldId
        ");
        $stat->execute();
        $this->responseData= $stat->fetchAll(PDO::FETCH_ASSOC);
        $this->setStatus(self::STATUS_OK);
    }
}
