<?php
/**
  * ControllerBase
  *
  * 控制器类父类,定义控制器初始化函数,子类加载方法
  *
  * @author $Author$
  * @version $ID$

  * @since $Header$
  * @property 类的属性说明
  * @package /
  * @subpackage Core
  * @access public
  * @abstract False
 */
class ControllerBase
{
	/**
	 * 实例化的对像保存地方,只保存使用可以使用共享方式的初始化的模块类
	 *
	 * @staticvar $instance 
	 */
	static private $instance = array();

	/**
	 * 实例化的视图类,不一定会有视图类,看用户是否有配置视图类的开关
	 *
	 * @var Object $Viewer
	 */
	protected $Viewer= null;



	/**
	 * 是否自动在Call方法后自动调用视图类进行显示
	 *
	 * @var Bool $AutoView
	 */
	protected $AutoView = TRUE;


	public function __construct()
	{
		$viewerclass=Cfg::G('VIEWER_CLASS_NAME');
		if(!empty($viewerclass) && is_string($viewerclass) && class_exists($viewerclass) )
		{
			$viewconfig=Cfg::G('ViewerConfig');
			$this->Viewer = new $viewerclass($viewconfig);
			$this->AutoView = Cfg::G('AUTO_VIEW_METHOD');
		}
	}

	/**
	  * init
	  *
	  * 初始化子类实例,并保存副本(愿意使用共享方式的),在二次调用时,直接使用副本
	  *
	  * @param bool $UseCache=TRUE 是否可以使用已有的实例类
	  * @param string $ClassName 要实例的类名
	  * return Object
	  */
	static public function init($UseCache = TRUE,$ClassName)
	{
		if($UseCache)
		{
			if (empty(self::$instance[$ClassName]))
			{
				self::$instance[$ClassName]=new $ClassName();
			}
			return self::$instance[$ClassName];
		}
		else
		{
			return new $ClassName;
		}
	}

	/**
	  * Call
	  *
	  * 模块与控制器都使用事先加载和事后处理函数,函数名为当前方法名+"_"和 "_"+方法名
	  * 通过加载器加载的模块,会自动加载该两个事件.但无返回.适用于直访方式的模块和控制器.
	  * 这样可以使模块方法得到分离,在需要返回时,通过正常的调用,在特殊情况下,使用加载器进行全面加载.
	  * 
	  * @param string $Method 要调用的方法
	  * return bool 
	 */
	public function Call($Method)
	{
		
		if(method_exists($this,$Method))
		{
			if(method_exists($this,$Method.'_'))
			{
				call_user_func(array($this,$Method.'_'));
			}
			call_user_func(array($this,$Method));
			if(method_exists($this,'_'.$Method))
			{
				call_user_func(array($this,'_'.$Method));
			}
			if($this->AutoView && $this->Viewer)
			{
				$viewFile= str_replace('Controller','',get_class($this)) . DIRECTORY_SEPARATOR . $Method;
				$this->Viewer->display($viewFile);
			}
		}
		else
		{
			throw new  Exception ('Method '.$Method.' not Exists',E_USER_ERROR );
		}
	}

	


	
}