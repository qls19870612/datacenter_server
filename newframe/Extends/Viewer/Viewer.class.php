<?php
/**
  * Viewer
  *
  * 模版显示类
  *
  * @author $Author$
  * @version $ID$

  * @since $Header$
  * @property public
  * @package /
  * @subpackage Extends
  * @access public
  * @abstract FALSE
 */

class Viewer
{
	/**
	 * 模版所在目录
	 *
	 * @var string $template_dir
	 */	
	var $template_dir='html';


	
	/**
	 * 模版变量
	 *
	 * @var array $Tpl_Val
	 */	
	var $Tpl_Val = array();

	
	/**
	 * 模版后缀名
	 *
	 * @var string $Tpl_Suffix
	 */
	var $Tpl_Suffix = 'html|tpl|php';
	
	/**
	 * 当前正在显示的模版所在的目录,用于后续的include
	 *
	 * @var string $CurrentDir
	 */
	var $CurrentDir='';




	/**
	 * __construct
	 *
	 * 视图类初始化
	 * @param array $config 初设配置
	 * <code>
	 * $config=array(
	 *      'template_dir'=>'my HTML ROOT DIR',
	 *		'compile_dir' =>'dir for compiled file save',
	 *		'Tpl_Suffix'=>'all suffixs for the template file',
	 *		''
	 *        );
	 * </code>
	 */
	public function __construct($config=array())
	{
		if($config && is_array($config))
		{
			foreach($config as $key=>$value)
			{
				if(isset($this->$key))
				{
					$this->$key=$value;
				}
			}
		}
	}

	
	/**
	 * display
	 *
	 * 显示模版
	 * @param string $file 模版文件名
	 */
	public function display($file)
	{
		$tplfile='';
		$suffixs=explode('|',$this->Tpl_Suffix);

		if( file_exists($this->template_dir.DIRECTORY_SEPARATOR.$file) )
		{
			$tplfile=$this->template_dir.DIRECTORY_SEPARATOR.$file;
		}
		else if($this->CurrentDir && file_exists($this->CurrentDir.DIRECTORY_SEPARATOR.$file) )
		{
			$tplfile=$this->CurrentDir.DIRECTORY_SEPARATOR.$file;
		}
		else if($this->Tpl_Suffix)
		{
			foreach($suffixs as $suf)
			{
				if( file_exists($this->template_dir. DIRECTORY_SEPARATOR . $file.'.'.$suf) )
				{
					$tplfile=$this->template_dir . DIRECTORY_SEPARATOR . $file . '.' . $suf;
					break;
				}
				else if($this->CurrentDir &&  file_exists($this->CurrentDir. DIRECTORY_SEPARATOR . $file.'.'.$suf) )
				{
					$tplfile=$this->CurrentDir . DIRECTORY_SEPARATOR . $file . '.' . $suf;
					break;
				}
			}
		}
		

		if(!$tplfile)
		{
			$searchfilelist=array($file);
			if($suffixs)
			{
				foreach($suffixs as $suf)
				{
					$searchfilelist[]=$file.'.'.$suf;
				}
			}
			throw new  Exception ("Template File miss In [".$this->template_dir."]: ".implode(' , ',$searchfilelist),E_USER_ERROR );
		}

		
		empty($this->CurrentDir) && $this->CurrentDir=dirname(realpath($tplfile)) . DIRECTORY_SEPARATOR ;
		require $tplfile;
	}


	/**
	 * includefile
	 *
	 * 用于模版中导入其它模版文件
	 * @param string $files  要导入的文件名称
	 */
	public function includefile()
	{
		$files=func_get_args();
		if($files)
		{
			foreach($files as $f)
			{
				$this->display($f);
			}
		}
	}


	/**
	 * assign
	 *
	 * 模版变量赋值
	 * @param string $key 变量名
	 * @param mixed $value 变量的值
	 */
	public function assign($key,$value)
	{
		$this->Tpl_Val[$key]=$value;
	}



	/**
	 * __set __get
	 *
	 * 模版变量赋值和取值的魔术方法,
	 * @param string $key 变量名
	 * @param mixed $value 变量的值
	 */	
	public function __set($key,$value)
	{
		$this->Tpl_Val[$key]=$value;
	}

	public function __get($key)
	{
		return isset($this->Tpl_Val[$key])?$this->Tpl_Val[$key]:NULL;
	}



}