<?php

/**
 * 游戏物品操作类
 * Class GameItem
 */
class UserModel extends BasicModel
{
    /**
     * 账号失效
     */
    const  status_invalid = 2;
    /**
     * 账号有效
     */
    const  status_valid = 1;

    /**
     * 登录错误   登录成功
     */
    const  loginstatus_scuessce = 1;
    /**
     * 登录错误  缺失用户名或密码
     */
    const  loginstatus_missingnameorpsw = 2;
    /**
     * 登录错误  缺失验证码
     */
    const  loginstatus_minsscheckcode = 3;
    /**
     * 登录错误  用户名或密码错误
     */
    const  loginstatus_errornameorpsw = 4;


    /**
     * 账号登录
     * @param $username 账号名称
     * @param $password 账号密码
     */
    public function  login($username, $password, $checkcode)
    {
        if (empty($username) || empty($password)) {
            return self::loginstatus_missingnameorpsw;
        }
        if (empty($checkcode) || !isset($_SESSION['checkcode'])) {
            return self::loginstatus_minsscheckcode;
        }
        $checkpsw = md5(md5($password));
        $data = $this->_db->reset()->Table('account')->Where(" name = '{$username}' and password ={$checkpsw} ")->FetchRow();






       




        if (empty($data)) {
            return self::loginstatus_errornameorpsw;
        }
        $user = $data;
        $_SESSION['user'] = $user;
        $_SESSION['useragent'] = md5($_SERVER['HTTP_USER_AGENT']);
        return self::loginstatus_scuessce;
    }


    /**
     * 检查用户是否登录session是否有问题 (防止复制session到其他浏览器)
     */
    public function  checkSession()
    {
        $session_useragent = '';
        if (!isset($_SESSION['useragent'])) {
            if ($session_useragent != md5($_SERVER['HTTP_USER_AGENT'])) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }


    /**
     * 注销
     */
    public function  logout()
    {
        session_unset();
    }


    /**
     * 添加账号
     * @param $username 用户名
     * @param $password 密码
     * @param int $check 账号状态
     */
    public function  addAccount($username, $password, $check = self::status_valid)
    {
        $checkdata = $this->_db->reset()->Table('account')->Fields('id')->where(" username = '{$username}' ")->FetchRow();
        if (!empty($checkdata)) {
            return false;
        }
        $a = $this->_db->reset()->Table('account')->Fields('username', 'password', 'status')->Record(array($username, md5(md5($password)), $check))->save();
    }

    /**
     * 更新账号密码
     * @param $username 账号名
     * @param $oldpassword 旧的密码
     * @param $newpassword 新的密码
     */
    public function  updateAccountPsw($username, $oldpassword, $newpassword)
    {

        $checkpsw = md5(md5($oldpassword));
        $data = $this->_db->reset()->Table('account')->Where(" name = '{$username}' and password ={$checkpsw} ")->FetchRow();
        if (empty($data)) {
            return false;
        } else {
            $data = $this->_db->Where(" id = " . $data['id'])->Fields("password")->Record(array(md5(md5($newpassword))))->update();
        }
        return true;
    }
}