<?php
/**
  * Cfg
  *
  * 配置类,读取与设置各个配置和保存
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

class Cfg
{
	static public $info=array();

	/**
	  * LoadConfig
	  * 
	  * 加载配置文件
	  * @param string $FileName 要加载的文件名,如留空则加载默认的基础配置
	  */
	static public function LoadConfig($FileName = NULL)
	{
		if($FileName)
		{
			if(file_exists($FileName) && is_file($FileName))
			{
				require $FileName;
			}
		}
		else if( defined('CFG_FILES_PATH') && is_dir(CFG_FILES_PATH) )
		{
			$config_files=glob(CFG_FILES_PATH.'config.*.php');
			if($config_files)
			{
				foreach($config_files as $cf)
				{
					require_once $cf;
				}
			}
		}
	}

	/**
	  * G
	  * 
	  * 读取配置,读取配置包括可以读取define定义的常量
	  *
	  * @param String $var 要读取的配置的键值
	  */
	static function G($var)
	{
		if ( !$var )
		{
			return NULL;
		}
		$keys_map = explode('.',$var);
		$tmp = NULL;

		foreach($keys_map as $index => $key)
		{
			if( $index > 0 )
			{
				if( isset( $tmp[$key] ) )
				{
					$tmp=$tmp[$key];
				}
				else
				{
					$tmp = NULL;
					break;
				}
			}
			else
			{
				if ( isset( self::$info[$key]) )
				{
					$tmp = self::$info[$key];
				}
				else if ( isset( $GLOBALS[$key]) )
				{
					
					$tmp = $GLOBALS[$key];
				}
				else
				{
					break;
				}
			}
		}

		if( is_null($tmp) && count($keys_map) == 1 && defined($keys_map[0]) )
		{
			$tmp = constant($keys_map[0]);
		}
		return $tmp;
	}


	/**
	  * S
	  * 
	  * 设定配置
	  *
	  * @param String $key 要设置的配置的键值
	  * @param String $value 要设置的配置的值
	  */
	static function S($key,$value)
	{
		if( !$key )
		{
			return NULL;
		}
		self::$info[$key] = $value;
		return TRUE;
	}
}