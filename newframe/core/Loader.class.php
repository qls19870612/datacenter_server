<?php
/**
  * Loader
  *
  * 加载类,加载用于加载框架中所有类型的类，包括扩展类，模块，控制器类，路由器，自动加载完成，无需人工干预
  *
  * @author $Author: Ashen $
  * @version $Id: Loader.class.php 22 2013-11-11 15:09:47Z Ashen $

  * @since $header$
  * @property 类的属性说明
  * @package /
  * @subpackage Core
  * @access public
  * @abstract False
 */

class Loader
{

	static private $IncludePath=array();

	/**
	  * Initialize
	  * 
	  * 初始化系统和加载器
	  *
	  */
	static function Initialize()
	{
		
		ob_start();
		if(version_compare(PHP_VERSION,'5.2.0','<'))  die('require PHP > 5.2.0 !');

		register_shutdown_function(array('Loader','ThreadOver'));	//线程结束时调用结尾函数,用于处理系统错误或语法错误,并实现错误屏蔽
		set_error_handler(array('Loader','ThreadError'));			//处理一般错误
        set_exception_handler(array('Loader','ThreadException'));	//处理手动抛出的错误,如使用throw new exception()抛出的异常,会到这里来


		spl_autoload_register(array('Loader','AutoLoad'));	//注册模块加载函数
		self::$IncludePath[]=G_FRAME_PATH;
		self::$IncludePath[]=G_CORE_PATH;
		self::$IncludePath[]=G_EXT_PATH;

		Cfg::LoadConfig();
		Cfg::G('WEB_PATH') && !in_array(Cfg::G('WEB_PATH'), self::$IncludePath) && self::$IncludePath[] = Cfg::G('WEB_PATH');
		Cfg::G('W_ROOT_PATH') && !in_array(Cfg::G('W_ROOT_PATH'), self::$IncludePath) && self::$IncludePath[] = Cfg::G('W_ROOT_PATH');
		Cfg::G('W_MODEL_PATH') && !in_array(Cfg::G('W_MODEL_PATH'), self::$IncludePath) && self::$IncludePath[] = Cfg::G('W_MODEL_PATH');
		Cfg::G('W_CONTROLLER_PATH') && !in_array(Cfg::G('W_CONTROLLER_PATH'), self::$IncludePath) && self::$IncludePath[] = Cfg::G('W_CONTROLLER_PATH');
		if ( Cfg::G('W_EXT_INCLUDE_PATH') )
		{
			$ext_include=explode(";",Cfg::G('W_EXT_INCLUDE_PATH'));
			if($ext_include)
			{
				foreach($ext_include as $i_dir)
				{
					if( $i_dir && is_dir($i_dir) && !in_array( $i_dir, self::$IncludePath ) )
					{
						self::$IncludePath[]=$i_dir;
					}
				}
				$ext_include = NULL;
			}
		}
		if( isset($GLOBALS['DOMAIN_LIMIT']) && $GLOBALS['DOMAIN_LIMIT'])
		{
			Cfg::S('DOMAIN_LIMIT',$GLOBALS['DOMAIN_LIMIT']);
		}
		self::Router();

	}


	/**
	  * Router
	  *
	  * 路由器,对解释好的参数进行解释并加载
	  *
	  */
	static function Router()
	{

		$routerBaseInfo=self::Explanation();

		if( empty($routerBaseInfo['Controller']) && empty($routerBaseInfo['Model'])) 
		{
			throw new  Exception ('No A Controller or Default Controller selected',E_USER_ERROR );
		}
		if( empty($routerBaseInfo['Method']) )
		{
			throw new  Exception ('Not A Method or Default Method selected',E_USER_ERROR );
		}
		//检查域名是否限定
		if( Cfg::G('DOMAIN_LIMIT.ENABLE_DOMAIN_LIMIT') )
		{
			self::CheckDomainRule($routerBaseInfo);
		}

		if( !empty($routerBaseInfo['Model']) )
		{
			$obj = self::M($routerBaseInfo['Model']);
			$obj->Call($routerBaseInfo['Method']);
		}
		else
		{
			$obj = self::C($routerBaseInfo['Controller']);
			$obj->Call($routerBaseInfo['Method']);
		}
		
	}



	/**
	  * M
	  *
	  * 加载模块类
	  *
	  * @param string $ModelName 模块名
	  * @param bool $init=TRUE 是否直接初始化
	  * @param bool $UseCache=TRUE 是否检查已初始化过的模块并在有的情况下直接返回该实例
	  */
	static function M($ModelName,$init = TRUE, $UseCache = TRUE)
	{
		$ClassName=$ModelName.'Model';
		$FileName=$ClassName.'.class.php';
		
		if(!class_exists($ClassName,FALSE))
		{
			if(file_exists(Cfg::G('W_MODEL_PATH').$FileName) && realpath(Cfg::G('W_MODEL_PATH').$FileName) == Cfg::G('W_MODEL_PATH').$FileName)
			{
				require Cfg::G('W_MODEL_PATH').$FileName;
			}
			else
			{
				throw new  Exception ('Model Miss',E_USER_ERROR );
			}
		}

		if(!class_exists($ClassName,FALSE) || !in_array('ModelBase',class_parents($ClassName)) )
		{
			throw new  Exception ('Make sure your Model Class named by "XxxxModel" and  Extends "ModelBase"',E_USER_ERROR );
		}

		return $init ? call_user_func($ClassName . '::init',$UseCache,$ClassName) : TRUE;
		//这里为什么要把ClassName做为参数传递进初始化函数,
		//在5.2,没有get_called_class的函数的情况下,
		//使用传参可以更省时省力的完成初始化动作,不需要再利用bug_backtract进行回朔查询
	}


	/**
	  * C
	  *
	  * 加载控制器类
	  *
	  * @param string $ControllerName 控制器名
	  * @param bool $init=TRUE 是否直接初始化
	  * @param bool $UseCache=TRUE 是否检查已初始化过的控制器并在有的情况下直接返回该实例
	  */
	static function C($ControllerName,$init = TRUE, $UseCache = TRUE )
	{
		$ClassName = $ControllerName.'Controller';
		$FileName = $ClassName.'.class.php';
		
		if(!class_exists($ClassName,FALSE))
		{
			if(file_exists(Cfg::G('W_CONTROLLER_PATH').$FileName) && realpath(Cfg::G('W_CONTROLLER_PATH').$FileName) == Cfg::G('W_CONTROLLER_PATH').$FileName)
			{
				require Cfg::G('W_CONTROLLER_PATH').$FileName;
			}
			else
			{
				throw new  Exception ('Controller Miss',E_USER_ERROR );
			}
		}

		if(!class_exists($ClassName,FALSE) || !in_array('ControllerBase',class_parents($ClassName)) )
		{
			throw new  Exception ('Make sure your Controller named by "XXXController" and  Extends "ControllerBase"',E_USER_ERROR );
		}
		return $init ? call_user_func($ClassName . '::init',$UseCache,$ClassName) : TRUE;

	}


	/**
	  * CheckDomainRule
	  *
	  * 域名限制检查
	  *
	  * @param array $router 路由配置
	  *
	  */
	static function CheckDomainRule($router)
	{
		if( Cfg::G('DOMAIN_LIMIT.DOMAIN') && substr($_SERVER['SERVER_NAME'],-strlen(Cfg::G('DOMAIN_LIMIT.DOMAIN')) ) != Cfg::G('DOMAIN_LIMIT.DOMAIN') )
		{
			throw new  Exception ('Domain limited',E_USER_ERROR );
		}
		$subdomain=substr($_SERVER['SERVER_NAME'],0,strlen($_SERVER['SERVER_NAME'])-strlen(Cfg::G('DOMAIN_LIMIT.DOMAIN'))-1 );

		if( Cfg::G('DOMAIN_LIMIT.ALLOW_SUB_DOMAIN') )
		{
			
			$subdomainlist=explode(',',Cfg::G('DOMAIN_LIMIT.ALLOW_SUB_DOMAIN') );
			
			if(!in_array($subdomain,$subdomainlist) )
			{
				throw new  Exception (sprintf('SubDomain %s limited',substr($_SERVER['SERVER_NAME'],0,strlen($_SERVER['SERVER_NAME'])-strlen(Cfg::G('DOMAIN_LIMIT.DOMAIN'))-1 )));
			}
		}
		//直调模块是否在允许列表内
		
		if(!empty($router['Model']) )
		{
			$allow_finger=Cfg::G('DOMAIN_LIMIT.ALLOW_FINGER_MODEL.'.$subdomain);
			if(!$allow_finger)
			{
				throw new Exception('Model Allow\' Rule Miss');
			}

			$allow_all=in_array('*',$allow_finger);
			$allow_all_sub=isset($allow_finger[$router['Model']])?in_array('*',$allow_finger[$router['Model']]):$allow_all;
			$allow_this=isset($allow_finger[$router['Model']])?in_array($router['Method'],$allow_finger[$router['Model']]):$allow_all_sub ;
			if( !$allow_all && !$allow_all_sub && !$allow_this )
			{
				throw new Exception ( 'Model Limited' );
			}
		}
		else
		{
			$allow_controller=Cfg::G('DOMAIN_LIMIT.ALLOW_CONTROLLER.'.$subdomain);
			if(!$allow_controller)
			{
				throw new Exception('Controller Allow\' Rule Miss');
			}
			$allow_all=in_array('*',$allow_controller);
			$allow_all_sub=isset($allow_controller[$router['Controller']])?in_array('*',$allow_controller[$router['Controller']]):$allow_all;
			$allow_this=isset($allow_controller[$router['Controller']])?in_array($router['Method'],$allow_controller[$router['Controller']]):$allow_all_sub ;
			if( !$allow_all && !$allow_all_sub && !$allow_this )
			{
				throw new Exception ( 'Controller Limited' );
			}
		}
		return true;
		

	}

	/**
	  * Explanation
	  *
	  * 解释器,对POST,GET等参数进行还原,以后这里做成解释器,
	  *
	  * return array
	  */
	static function Explanation()
	{
		$controller_key=Cfg::G('CONTROLLER_PARAM_NAME');
		$method_key=Cfg::G('METHOD_PARAM_NAME');
		$default_Controller=Cfg::G('DEFAULT_CONTROLLER');
		$default_Method=Cfg::G('DEFAULT_METHOD');
		$finger_model_key=Cfg::G('FINGER_MODEL_PARAM_NAME');
		
		$result=array();
		
		if($controller_key && _POST($controller_key) )
		{
			$result['Controller']=_POST($controller_key);
		}
		else if($controller_key && _GET($controller_key) )
		{
			$result['Controller']=_GET($controller_key);
		}
		else if( $default_Controller )
		{
			$result['Controller']=$default_Controller;
		}

		if($method_key && _POST($method_key) )
		{
			$result['Method']=_POST($method_key);
		}
		else if($method_key && _GET($method_key) )
		{
			$result['Method']=_GET($method_key);
		}
		else if( $default_Method )
		{
			$result['Method']=$default_Method;
		}

		if($finger_model_key && _POST($finger_model_key) )
		{
			$result['Model']=_POST($finger_model_key);
		}
		else if($finger_model_key && _GET($finger_model_key) )
		{
			$result['Model']=_GET($finger_model_key);
		}
		return $result;
				
	}

	/**
	  * ThreadOver
	  * 
	  * 进程结束处理函数,对运行结果进行处理
	  *
	  * @access public
	  */
	static function ThreadOver()
	{

		if($e=error_get_last())
		{
			switch($e['type'])
			{
				case E_ERROR:
				case E_PARSE:
				case E_CORE_ERROR:
				case E_COMPILE_ERROR:
					//ob_end_clean ();		//致命错误时,清屏
					//ob_start();
					break;
			}
		}
		
		//Loader::Debug();
		return TRUE;
	}


	/**
	  * Debug
	  * 
	  * @param array $e=NULL 进行输出的错误,如传递错误,则不去系统读取最后的错误信息.
	  *
	  */
	static function Debug($e = NULL)
	{
		//检查是否开启除错模式,如果不是,直接返回
		if(!Cfg::G('G_DEBUG') )
		{
			return True;
		}

		!$e && $e = error_get_last();
		if($e)
		{
			echo "<Pre>";
			print_r($e);
			echo "</Pre>";
		}
		//这里没完成,挖坑埋地雷
		return TRUE;
	}

	/**
	  * ThreadError
	  * 
	  * 处理一般错误,非致命错误如NOTICE,用户使用trigger_error丢出的错误
	  *
	  */
	static function ThreadError($errno, $errstr, $errfile, $errline){
		$e=array(
				'type'=>$errno,
				'message'=>$errstr,
				'file'=>$errfile,
				'line'=>$errline,
				'from'=>'ThreadError'
				);
		
		
		Loader::Debug($e);
		return TRUE;
	}

	/**
	  * ThreadException
	  * 
	  * 处理由用户主动抛出的错误,注意,抛出异常会导致程序停止,如果只是提示性错误,请使用throw new  Exception ()
	  *
	  */
	static function ThreadException($e){

		$Exception=array(
					'type'	=>	$e->getCode(),
					'message'=>	$e->getMessage(),
					'file'	=>	$e->getFile(),
					'line'	=>	$e->getLine(),
					'from'=>'ThreadException'
						);
		Loader::Debug($e);
		return TRUE;
	}

	/**
	  * AutoLoad
	  * 
	  * 自动加载各种类库,只要符合命名规则并存放在包含目录的,都可以自动加载.由框架自行运行
	  *
	  * @param string $ClassName 要加载的类名
	  */
	static function AutoLoad($ClassName)
	{
		if(substr($ClassName,-5) == 'Model')
		{
			return self::M(substr($ClassName,0,-5),FALSE);
		}
		if(substr($ClassName,-10) == 'Controller')
		{
			return self::C(substr($ClassName,0,-10),FALSE);
		}

		$FileName=$ClassName.'.class.php';

		if(self::$IncludePath)
		{
			$split_separator=explode("_",$ClassName);
			foreach(self::$IncludePath as $dir_path)
			{
				if( file_exists($dir_path.$FileName) && realpath($dir_path.$FileName) == $dir_path.$FileName)
				{
					require $dir_path.$FileName;
					return true;
				}
				
				if(file_exists($dir_path.$ClassName.DIRECTORY_SEPARATOR.$FileName) && realpath($dir_path.$ClassName.DIRECTORY_SEPARATOR.$FileName) == $dir_path.$ClassName.DIRECTORY_SEPARATOR.$FileName)
				{
					require $dir_path.$ClassName.DIRECTORY_SEPARATOR.$FileName;
					return true;
				}

				//分层类或子类
				if( count($split_separator) > 1 )
				{
					if( file_exists($dir_path.$split_separator[0].DIRECTORY_SEPARATOR.'Drivers'.DIRECTORY_SEPARATOR.$FileName) && 
						realpath($dir_path.$split_separator[0].DIRECTORY_SEPARATOR.'Drivers'.DIRECTORY_SEPARATOR.$FileName) == $dir_path.$split_separator[0].DIRECTORY_SEPARATOR.'Drivers'.DIRECTORY_SEPARATOR.$FileName )
					{
						require $dir_path.$split_separator[0].DIRECTORY_SEPARATOR.'Drivers'.DIRECTORY_SEPARATOR.$FileName;
						return true;
					}
				}
			}
		}

	}

}
