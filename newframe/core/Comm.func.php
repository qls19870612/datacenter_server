<?php
/**
  *
  * 公共函数集
  *
  * @author $Author$
  * @version $ID$

  * @since $Header$
  * @package /
  * @subpackage Core
  * @access public
 */


	/**
	  * _POST
	  * 
	  * 接收POST参数
	  *
	  * @param String $key='' 键名
	  * 
	  * return Mixed
	  */
	function _POST($key='')
	{
		if(isset($_POST) && count($_POST))
		{
			if($key!='')
			{
				if(isset($_POST[$key]))	return $_POST[$key];
			}
			else
			{
				return $_POST;
			}
		}
		return NULL;
	}


	/**
	  * _REQUEST
	  * 
	  * 接收POST或GET形式提交上来的参数
	  *
	  * @param String $key='' 键名
	  * 
	  * return Mixed
	  */
	function _REQUEST($key='')
	{
		if(isset($_REQUEST) && count($_REQUEST))
		{
			if($key!='')
			{
				if(isset($_REQUEST[$key]))	return $_REQUEST[$key];
			}
			else
			{
				return $_REQUEST;
			}
		}
		return NULL;
	}


	/**
	  * _GET
	  * 
	  * 接收GET形式提交上来的参数
	  *
	  * @param String $key='' 键名
	  * 
	  * return Mixed
	  */
	function _GET($key='')
	{
		if(isset($_GET) && count($_GET))
		{
			if($key!='')
			{
				if(isset($_GET[$key]))	return $_GET[$key];
			}
			else
			{
				return $_GET;
			}
		}
		return NULL;
	}
/**
 * 获取客户端IP
 * @return string
 */
function get_ip()
{
	if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
	{
		return getenv('HTTP_X_FORWARDED_FOR');
	}
	elseif (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
	{
		return getenv('HTTP_CLIENT_IP');
	}
	elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
	{
		return getenv('REMOTE_ADDR');
	}
	elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
	{
		return $_SERVER['REMOTE_ADDR'];
	}
}

