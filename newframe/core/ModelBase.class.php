<?php
/**
  * ModelBase
  *
  * 模块类父类,定义模块初始化函数,分支加载方法
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
class ModelBase
{
	/**
	 * 实例化的对像保存地方,只保存使用可以使用共享方式的初始化的模块类
	 *
	 * @staticvar $instance 
	 */
	static private $instance = array();


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
				self::$instance[$ClassName]=new $ClassName;
			}
			return self::$instance[$ClassName];
		}
		else
		{
			return new $ClassName;
		}
	}



}