<?php

require_once('ApiBaseController.php');

/**
 * Class TopRoleController
 * 查询指定平台区服的等级前10的玩家信息
 */
class TopRoleController extends ApiBaseController {

    public $platform;

    public $worldId;

    public function init() {
        parent::init();
        $this->platform = isset($_GET['platform']) ? $_GET['platform'] : null;
        $this->worldId = isset($_GET['worldId']) ? $_GET['worldId'] : null;
    }

    public function validate() {
        if (!parent::validate()) {
            return false;
        }
        if (empty($this->platform) || empty($this->worldId)) {
            $this->setStatus(self::STATUS_INVALID_PARAMS,'Missing Params');
            return false;
        }
        return true;
    }

    public function run(){
        parent::run();
        try{
            $this->fetchData();
        }catch (Exception $e){
            file_put_contents(dirname(__DIR__).'/log/'.date('Y-m-d').'.log',$e->getMessage(),'a');
            $this->setStatus(self::STATUS_SERVER_ERROR,'Fetch data error.');
        }

        $this->sendResponse();
    }

    public function fetchData(){
        $pdo=MysqlDb::getDbServer('lala','log');
        //检查platform
        $dbName='dblala'.$this->platform.'log';
        $stat=$pdo->prepare("SHOW DATABASES LIKE :dbName");
        $stat->execute(array(':dbName'=>$dbName));
        if(count($stat->fetchAll())==0){
            $this->setStatus(self::STATUS_INVALID_PARAMS,'Unknown Platform');
            return false;
        }
        //查询数据
        $pdo->query('USE '.$dbName);
        $stat=$pdo->prepare("SELECT * FROM t_player WHERE iWorldId=:worldId GROUP BY `Level` DESC LIMIT 10");
        $stat->execute(array(':worldId'=>$this->worldId));
        $this->responseData=$stat->fetchAll(PDO::FETCH_ASSOC);
        if(count($this->responseData)>0){
            $this->setStatus(self::STATUS_OK);
        }else{
            $this->setStatus(self::STATUS_NO_DATA);
        }
        return true;
    }
}