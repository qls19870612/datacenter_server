<?php
class indexController extends BasicController
{


    function index()
    {
		if(_get('manage')!='1'){
			header('Location:/report/home.php');
			die();
		}
		$FunctionList=Cfg::G('FunctionList');
		$MenuGroup=Cfg::G('MenuGroup');

        $menu = array();
        $templatelist = $FunctionList;
        $myGroup = array();
        if ($_SESSION['admin']['level']) {
            $myGroup = $MenuGroup;
        } else {
            if ($_SESSION['admin']['function']) {
                foreach ($_SESSION['admin']['function'] as $v) {
                    if (!empty($FunctionList[$v]) && !empty($MenuGroup[$FunctionList[$v]['group']])) { //如果 group组 存在的情况
                        if (isset($FunctionList[$v]['group']) && $FunctionList[$v]['group'] && $FunctionList[$v]['is_m']) {
                            $myGroup[$FunctionList[$v]['group']] = $MenuGroup[$FunctionList[$v]['group']];
                        }
                    }
                }
            }
        }

        $this->Viewer->assign('MenuGroup', $myGroup);
        $this->Viewer->assign('templatelist', $templatelist);
        if (_request('test')) {
            $this->Viewer->display('index2.tpl');
        } else {
            $this->Viewer->display('index.tpl');
        }
    }

	
    function chgpwd()
    {
        $p = _post();
        if (isset($p['saveedit']) && $p['saveedit'] == 1) {
            if (!isset($p['old']) || $p['old'] == '') {
                $this->tpl->assign('old_err', '请输入旧密码');
            } elseif (!isset($p['newpwd']) || $p['newpwd'] == '') {
                $this->tpl->assign('newpwd_err', '请输入新密码');
            } elseif (!isset($p['repwd']) || $p['newpwd'] != $p['repwd']) {
                $this->tpl->assign('repwd_err', '两次新密码必须一致');
            } else {
                $admin = new admin();

                $pass = md5(md5($p['old']));
                $info = $admin->getUserInfo($_SESSION['admin']['id']);

                if ($info['status'] != 1 || $info['userinfo']['password'] != $pass) {
                    $this->tpl->assign('old_err', '旧密码不正确');
                } else {
                    $newpass = md5(md5($p['newpwd']));
                    $admin->update_user(array('password' => $newpass), 'id=' . $_SESSION['admin']['id']);
                    unset($_SESSION['admin']);
                    header("Content-type: text/html; charset=utf-8");
                    echo "<script>alert('您的密码已修改成功.请使用新密码进行重新登录');parent.location.href='index.php';</script>";
                    die();
                }
            }
        }
        $this->Viewer->display('chgpwd.tpl');
    }

	function getReportList(){
		echo 'hi';

	}

	function loginajax(){
		$post = _REQUEST();

		$admin = new admin();
        $result = $admin->login($post,false,true);
		$returnmsg=array('msg'=>'','code'=>0);

        switch ($result) {
			case -1:
				$returnmsg['code']=0;
				$returnmsg['msg']='用户名和密码不能为空';
				break;
            case -2:
				$returnmsg['msg']='用户名或密码不正确';
                break;
            case -3:
				$returnmsg['msg']='该用户帐号已被锁';
				break;
            case -4:
				$returnmsg['msg']='验证码不正确';
                break;
            case -5:
				$returnmsg['msg']='非法登录';
                break;
			case -7:
				$returnmsg['msg']='该帐号未开通任何权限,请联系管理员';
				break;
            case 1:
				$seconds=0;
				if(!empty($post['keepstatus'])){
					$seconds=intval($post['keepstatus'])*3600*24;
				}
				if($seconds){
					$admin->setAuth($_SESSION['admin']['name'],$_SESSION['admin']['password'],$seconds);
				}
				$returnmsg['code']=200;
				$returnmsg['msg']='登录成功';
                break;
        }
		echo json_encode($returnmsg);
		die();
	}


    function login()
    {
		if(_get('manage')!='1'){
			header('Location:/report/home.php');
			die();
		}
        $post = _POST();

        if (isset($post['act']) && $post['act'] == 'login') {

            $admin = new admin();
            $result = $admin->login($post);

            switch ($result) {
                case -1:
                    $this->Viewer->assign('errmsg', '用户名和密码不能为空');
                    break;
                case -2:
                    $this->Viewer->assign('errmsg', '用户名或密码不正确');
                    break;
                case -3:
                    $this->Viewer->assign('errmsg', '该用户帐号已被锁');
                    break;
                case -4:
                    $this->Viewer->assign('errmsg', '验证码不正确');
                    break;
                case -5:
                    $this->Viewer->assign('errmsg', '非法登录');
                    break;
				case -7:
					$this->Viewer->assign('errmsg', '该帐号未开通任何权限,请联系管理员');
					break;
                case 1:
					$seconds=0;
					if(!empty($post['keepstatus'])){
						$seconds=intval($post['keepstatus'])*3600*24;
					}
					if($seconds){
						$admin->setAuth($_SESSION['admin']['name'],$_SESSION['admin']['password'],$seconds);
					}
                    $this->redirect('index', 'index','manage=1');

                    break;
            }
        }

        $this->Viewer->display('login.tpl');
    }

    function view()
    {
		$admin=new admin();
		$GAME_LIST=$admin->getGameList();

        $this->Viewer->assign('GAME_LIST', $GAME_LIST);
        $id = _request('id');
        if ($id == 'top') {

            $this->Viewer->assign('myip', get_ip());
            $this->Viewer->display('frame_top.tpl');

        } elseif ($id == 'menu') {

            $dayarr = array(1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六', 7 => '日');
            $this->Viewer->assign('nowday', $dayarr[date('N')]);

			$FunctionList=Cfg::G('FunctionList');
			$MenuGroup=Cfg::G('MenuGroup');

            $menu = array();
            $templatelist = $FunctionList;
            $myGroup = array();

            if ($_SESSION['admin']['level']) {

                $myGroup = $MenuGroup;

            } else {

                if ($_SESSION['admin']['function']) {
                    foreach ($_SESSION['admin']['function'] as $v) {
                        if (!empty($FunctionList[$v]) && !empty($MenuGroup[$FunctionList[$v]['group']])) { //如果 group组 存在的情况
                            if (isset($FunctionList[$v]['group']) && $FunctionList[$v]['group'] && $FunctionList[$v]['is_m']) {
                                $myGroup[$FunctionList[$v]['group']] = $MenuGroup[$FunctionList[$v]['group']];
                            }
                        }
                    }
                }

            }
            //print_r($templatelist);
            $this->Viewer->assign('MenuGroup', $myGroup);
            $this->Viewer->assign('templatelist', $templatelist);
            $this->Viewer->assign('myinfo', $_SESSION['admin']);
            $this->Viewer->display('frame_menu.tpl');
        }
    }


    function logout()
    {
        if (session_id()) {
            unset($_SESSION);
            session_destroy();
            $admin=new admin();
            $admin->cleanAuth();
        }
        $this->redirect('index', 'login');
    }

    function systeminfo()
    {

    }

    function imgcode()
    {
        $img = new ImageCode();
        $code = $img->generateCode(4, 1);
        $_SESSION['IMGCODE'] = $code;

        $img->image($code, $img->English, '#CCCCCC', '#550055', '#FF00FF', 17, 60, 20);

    }


	function selectedgame()
	{
		Cfg::S('G_DEBUG',FALSE);
		$result=array('status'=>false);
		if(!empty($_SESSION['admin'])){
			$selectgame=_REQUEST('game');
			$admin=new admin();

			$GAME=$admin->getGameList();

			if((in_array($selectgame,$_SESSION['admin']['AllowGame']) || $_SESSION['admin']['level']) && !empty($GAME[$selectgame]))
			{
				$_SESSION['admin']['selected_game']=$selectgame;
				$result['status']=true;
			}
		}

		echo json_encode($result);
	}
}