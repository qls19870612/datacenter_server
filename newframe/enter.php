<?php
/**
  * 框架入口文件
  *
  * 引导框架，加载所需的各种必备程序文件
  *
  * @author $Author: Ashen $
  * @version $ID$

  * @since $Header: svn://121.199.35.123/Giraffe/wwwroot/enter.php 31 2013-11-26 13:25:29Z Ashen $
  * @package /
  * @access public
  * @abstract False
 */

/**
  * 进入框架时收集部分信息
  */
define('START_ENTER',microtime());
define('BEGIN_MEMORY_USED_STAGE',memory_get_usage());


/**
  * G_FRAME_PATH
  *
  * 框架根目录
  *
  * @constvar string G_FRAME_PATH
 */
defined("G_FRAME_PATH") or define("G_FRAME_PATH",dirname(__FILE__). DIRECTORY_SEPARATOR);

/**
  * G_CORE_PATH
  * 
  * 内核文件目录,原则上内核目录在框架目录下的core目录,不排除有需要将该目录折分出来进行他用. 
  *
  * @constvar string G_CORE_PATH
 */
defined("G_CORE_PATH") or define("G_CORE_PATH",G_FRAME_PATH . 'core' . DIRECTORY_SEPARATOR);

/**
  * G_EXT_PATH
  * 
  * 扩展库默认路径,如用户已事先定义,则以用户指定目录为准 
  *
  * @constvar string G_EXT_PATH
 */
defined("G_EXT_PATH") or define("G_EXT_PATH",G_FRAME_PATH . 'Extends' . DIRECTORY_SEPARATOR);



/**
  * WEB_FILES_PATH
  * 
  * 配置文件所在目录,指定后,配置会自动检查该目录下所有config.*.php的文件,并加载
  *
  * @constvar string G_EXT_PATH
 */
defined('CFG_FILES_PATH') or define('CFG_FILES_PATH','');


/**
  * WEB_PATH
  * 
  * 网站所在目录
  *
  * @constvar string WEB_PATH
 */
defined('WEB_PATH') or (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT'] && define('WEB_PATH',$_SERVER['DOCUMENT_ROOT'])) or define('WEB_PATH',G_FRAME_PATH);


/**
  * G_DEBUG
  * 
  * 是否开启调试功能.调试功能将打印出所有错误信息
  *
  * @constvar bool G_DEBUG
 */
defined("G_DEBUG") or define("G_DEBUG",TRUE);

/**
  * W_ROOT_PATH
  * 
  * 网站程序所在目录
  *
  * @constvar String W_ROOT_PATH
 */
defined('W_ROOT_PATH') or (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT'] && define('W_ROOT_PATH',$_SERVER['DOCUMENT_ROOT'])) or define('W_ROOT_PATH',G_FRAME_PATH);

/**
  * W_MODEL_PATH
  * 
  * 模块类存放目录
  *
  * @constvar String W_MODEL_PATH
 */
defined('W_MODEL_PATH') or define('W_MODEL_PATH',G_FRAME_PATH);

/**
  * W_CONTROLLER_PATH
  * 
  * 控制器类所在目录
  *
  * @constvar String W_CONTROLLER_PATH
 */
defined('W_CONTROLLER_PATH') or define('W_CONTROLLER_PATH',G_FRAME_PATH);

/**
  * W_EXT_INCLUDE_PATH
  * 
  * 其它你可能会用到的类库所在的目录,类库命名规则必须为"类名.class.php",如果你想框架自动加载.请在此添加,多个以";"分号隔开
  *
  * @constvar String W_EXT_INCLUDE_PATH
 */
defined('W_EXT_INCLUDE_PATH') or define('W_EXT_INCLUDE_PATH','');


/**
  * 控制器调度中使用的参数名
  * 
  * CONTROLLER_PARAM_NAME 指示程序抽取传递上来的哪个参数做为控制器调度依据,
  * METHOD_PARAM_NAME 指示程序抽取传递上来的哪个参数做为方法调度依据
  * DEFAULT_CONTROLLER	默认控制器是哪个.
  * DEFAULT_METHOD 默认方法是哪个
  *
  * @constvar String CONTROLLER_PARAM_NAME
  * @constvar String METHOD_PARAM_NAME
  * @constvar String DEFAULT_CONTROLLER
  * @constvar String DEFAULT_METHOD
 */
defined('CONTROLLER_PARAM_NAME') or define('CONTROLLER_PARAM_NAME','controller');
defined('METHOD_PARAM_NAME') or define('METHOD_PARAM_NAME','method');
defined('DEFAULT_CONTROLLER') or define('DEFAULT_CONTROLLER','index');
defined('DEFAULT_METHOD') or define('DEFAULT_METHOD','index');


/**
  * FINGER_MODEL_PARAM_NAME
  * 
  * 直接访问模块类,不需要经过控制器.通过该参数传递的类名,将会直接访问模块类,而不去走控制器,该指示优先级高于控制器参数名,如果该参数存在,则METHOD_PARAM_NAME指向的将是该模块的方法,而非是控制器的方法
  *
  * @constvar String FINGER_MODEL_PARAM_NAME
 */
defined('FINGER_MODEL_PARAM_NAME') or define('FINGER_MODEL_PARAM_NAME','model');


require G_CORE_PATH.'Loader.class.php';
require G_CORE_PATH.'Comm.func.php';
Loader::Initialize();
