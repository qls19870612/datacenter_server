<?php

class BasicController extends ControllerBase
{
	var $_db=NULL;
    public function  __construct()
    {
        parent::__construct();
		if(!session_id())
		{
			session_start();
		}

		$config_array = CFG::G('DB'); //初始化db所有对象
		if (!empty($config_array)) {
			foreach ($config_array as $db_type => $config) {
				TSQL::instance($config, $db_type);
			}
		}

		$this->_db=TSQL::initDB('Mysql');
		$routerBaseInfo=Loader::Explanation();
		$accessCode=strtolower($routerBaseInfo['Controller'].'.'.$routerBaseInfo['Method']);




		if(empty($_SESSION['admin']) && !in_array($accessCode,Cfg::G('NoNeedPower')) && !$this->getAuth() ){
            if($routerBaseInfo['Controller']=='ajax'){
				$this->tips('未登录',Cfg::G('resultCode.UNLOGIN'));die();
			}else{
				$this->redirect('index','login');
			}
		}
		if(!empty($_SESSION['admin']) && !in_array($accessCode,array_merge(Cfg::G('NoNeedPower'),array('index.index','index.view','index.systeminfo','ajax.getfuncs'))) && !$this->check($accessCode))
		{
            if($routerBaseInfo['Controller']=='ajax'){
                $this->tips('没有权限',Cfg::G('resultCode.NORIGHT'));die();
            }else{
                $this->tips('没有权限',Cfg::G('resultCode.NORIGHT'));
            }

			die();
		}

        isset($_SESSION['admin']) && $this->Viewer->assign('myinfo', $_SESSION['admin']);
		$this->Viewer->assign('Navigate',$routerBaseInfo['Controller'].'.'.$routerBaseInfo['Method']);
		$this->Viewer->assign('FunctionList',Cfg::G('FunctionList'));
		$this->Viewer->assign('MenuGroup',Cfg::G('MenuGroup'));

    }

	function tips($msg,$code)
	{

			$result['code']=$code;
			$result['msg']=$msg;
			echo json_encode($result);

		die();

	}
	function check($accessCode)
	{
		$admin=new admin();
		return $admin->check_power($accessCode);
	}
	//重定向去其它CONTROLLER和METHOD
	function redirect($c=null,$m=null,$param=''){
		//ob_clean();
		$action=($c && $c!='')?( Cfg::G('CONTROLLER_PARAM_NAME').'='.$c ) : '';
		$op=($m && $m!='')?(Cfg::G('METHOD_PARAM_NAME').'='.$m):'';
		$str=($action!='')?$action:'';
		
		$str!='' && $op!='' && $str.='&'.$op;
		$str=='' && $op!='' && $str=$op;
		
		$str!='' && $param!='' && $str.='&'.$param;
		$str=='' && $param!='' && $str=$param;
		$str!='' && $str='?'.$str;
		
		header('Location: index.php'.$str);
		die();
	}

	function getAuth(){
		$admin=new admin();
		return $admin->getAuth();
	}

	public function  __destruct()
	{
	/*
		$db=Cfg::G('DB');
		if(!empty($db))
		{
			foreach($db as $key=>$config)
			{
				$dbobj=TSQL::initDB($key);
				if($dbobj)
				{
					echo "<br><br>db->".$key.":<br>";
					$dbobj->Debug();
				}

			}
		}
*/
	}


}