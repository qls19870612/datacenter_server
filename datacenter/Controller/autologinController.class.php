<?php
/**
 * 加密密匙
 */
//@ini_set('display_errors', false);
error_reporting(E_ALL & ~E_NOTICE);
define('SIGNKEY', 'test_lala_login_key');
date_default_timezone_set('Asia/Shanghai'); //设置时区

/**
 * 自动登录设置
 * Class autologinController
 */
class autologinController extends ControllerBase
{
    public function  __construct()
    {
        parent::__construct();
        session_start();
        $config_array = CFG::G('DB'); //初始化db所有对象
        $db_config = $config_array['Mysql'];
        $this->_db = new TSQL_mysqlpdo($db_config);
    }

    //清除缓存
    public function  index()
    {
        $db = $this->_db;
        $result = array();
        $uname = _request('uname');
        $time = _request('time');
        $sign = _request('sign');
        if (empty($uname) || empty($time) || empty($sign)) {
            $result['result'] = '-1'; //参数不全
            die(json_encode($result));
        }

        $current_time = time();
        $time_interval = $current_time - $time;
        if (($time_interval < (-1 * 60)) || ($time_interval > 30 * 60)) { //判断时间有效性  半小时内
            $result['result'] = '-3'; // 请求超时
            die(json_encode($result));
        };
        $local = md5($uname . $time . SIGNKEY);
        if ($sign != $local) { //  加密签名错误
            $result['result'] = '-2';
            die(json_encode($result));
        }
        $ip = $this->getIP();
        $agent = $_SERVER['HTTP_USER_AGENT']; //浏览器信息
        $sql = "select * from  `autologinpassip`  where  vPlt ='37wan' and  vIp ='{$ip}'  ";

        $plt_checkData = $db->fetchRow($sql);
        if (empty($plt_checkData)) { // 非法帐号
            $result['result'] = '-4';
            die(json_encode($result));
        }
        $checkName = $db->quote($uname);
        $sql = "select  a.* from admin a ,autologinuser b  where  a.id = b.iUserId  and  b.vPlt ='37wan' and a.`name` =$checkName  ";
        $user_checkData = $db->fetchRow($sql);
        if (empty($user_checkData)) { // 非法帐号
            $result['result'] = '-5';
            die(json_encode($result));
        } else {
            if ($user_checkData['stop']) {
                $result['result'] = '-5';
                die(json_encode($result));
            } else {
                $user_checkData['AllowGame'] != '' && $user_checkData['AllowGame'] = explode(',', $user_checkData['AllowGame']);
                if (!$user_checkData['AllowGame']) {
                    $user_checkData['AllowGame'] = array();
                }
                $user_checkData['AllowPlatform'] != '' && $user_checkData['AllowPlatform'] = explode(',', $user_checkData['AllowPlatform']);
                if (!$user_checkData['AllowPlatform']) {
                    $user_checkData['AllowPlatform'] = array();
                }
                if ($user_checkData['level'] != 1) {
                    if ($user_checkData['group_ids']) {
                        $sql = "select power from admin_group  where id in (" . $user_checkData['group_ids'] . ")";
                        $tmp = $db->fetchAll($sql);
                        $str = '';
                        if ($tmp) {
                            foreach ($tmp as $v) {
                                $str .= $v['power'] . ',';
                            }
                            $user_checkData['function'] = array_unique(explode(',', $str));
                        }
                    }
                }
                unset($_SESSION['IMGCODE']);
                $_SESSION['admin'] = $user_checkData;
            }
            $db->insert('autologinlog', array('iUid' => $user_checkData['id'], 'vIp' => $ip, 'dtDatetime' => date('Y-m-d H:i:s'), 'vAgent' => $agent));
            header('Location: /');
        }
    }

    /**
     * 获取玩家IP地址
     * @return string
     */
    private function getIP()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }
}
