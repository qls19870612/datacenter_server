<?php
/**
  * TSQL
  *
  * 关系型数据库基类。所有关系型数据实例都通过该类实现，指定配置后由该类进行调取
  *
  * @author $Author$
  * @version $ID$
  * @copyright Giraffe Group
  * @since $Header$
  * @property public
  * @package /
  * @subpackage Extends
  * @access public
  * @abstract FALSE
 */

class TSQL
{
	/**
	 * 所使用的驱动
	 *
	 * @var $Drivers
	 */
	static $Drivers = NULL ;
	
	/**
	 * 连接句柄
	 *
	 * @var $conn
	 */
	protected $conn=null;
	
	/**
	 * 调试模试下,保存所有执行过的SQL语句
	 *
	 * @var $SQLArray
	 */
	public $SQLArray=array();

	/**
	 * 调试模试下,保存错误信息
	 *
	 * @var $ERROR
	 */
	public $ERROR=array();

	/**
	 * 是否开启调试模式
	 *
	 * @var $Debug
	 */
	private $Debug = FALSE;


	/**
	 * 必需要参数键名
	 *
	 * @var $Require_Config
	 */
	public $Require_Config=array();


	/**
	 * 临时变量,用来保存不存在的属性,
	 *
	 * @var array $Temp
	 *
	 */
	private $Temp=array();

	/**
	 * SQL语句部位储存器
	 *
	 * @var $SQL_Adpat 
	 */
	private $SQL_Adpat = array (
							'Field'=>array(),
							'Table'=>array(),
							'Where'=>array('AND'=>array(),'OR'=>array()),
							'OrderBy'=>array(),
							'GroupBy'=>array(),
							'Having'=>array(),
							'Record'=>array(),
							'Limit'=>array('pagesize'=>0,'offset'=>0),
							'Join'=>array()
							);

	/**
	  * instance
	  *
	  * 根据配置初始化所有数据库实例,所有实例化的数据库连接都是未进行连接的.
	  *
	  * @param array $DriverConfig 数据库配置列表
	  * @param string $setName 本次实例的实例名,如留空则使用驱动名,当同名实例存在时,将会覆盖旧的实例
	  */
	static public function instance($driverConfig , $setName = NULL) 
	{
		if(is_array($driverConfig) && $driverConfig )
		{

			if(empty($driverConfig['driver']) || !class_exists(get_class()."_".$driverConfig['driver']))
			{
				return FALSE;
			}
			$setName = $setName ? $setName : $driverConfig['driver'];
			$ClassName=get_class()."_".$driverConfig['driver'];
			self::$Drivers[$setName] = new $ClassName($driverConfig);
			return TRUE;
		}
		return FALSE;
	}


	/**
	  * initDB
	  *
	  * 获取实例化的数据库类,实际上可以通过TSQL::$Drivers['XXX']方式获得,使用该方式只为了写法统一而以,需要与否根据个人
	  *
	  * @param string $Name 要获取的实例化类索引
	  */
	static function initDB($Name)
	{


		if(isset(self::$Drivers[$Name]) && self::$Drivers[$Name])
		{

			if(isset(self::$Drivers[$Name]) && self::$Drivers[$Name])
			{
				!self::$Drivers[$Name]->isConnected() &&  self::$Drivers[$Name]->connect();
				return self::$Drivers[$Name];
			}
		}

		return NULL;
	}


	public function isConnected()
	{
		return (bool)$this->conn;
	}

	/**
	  * __construct
	  *
	  * 实例化时的初始化函数
	  *
	  * @param array $config 本次初始化的配置
	  */
	public function __construct($config)
	{
		$this->Debug = Cfg::G('G_DEBUG');
		if(!extension_loaded($config['driver']))
		{
			//phpinfo();
			//print_r(get_loaded_extensions());
			//echo(get_loaded_extensions());
			throw new Exception('Extension '.$config['driver']." not Loaded");
		}

		if($this->Require_Config)
		{
			foreach($this->Require_Config as $key)
			{
				if(empty($config[$key]))
				{
					$this->Err('instance' , 'Miss Config['.$key.']');
					return ;
				}
			}

		}
		if($config)
		{
			foreach($config as $key=>$value)
			{
				$this->$key=$value;
			}
		}
	}


	/**
	  * reset
	  *
	  * 重置SQL参数
	  *
	  */
	public function reset()
	{
		$this->SQL_Adpat=array (
							'Field'=>array(),
							'Table'=>array(),
							'Where'=>array('AND'=>array(),'OR'=>array()),
							'OrderBy'=>array(),
							'GroupBy'=>array(),
							'Having'=>array(),
							'Record'=>array(),
							'Limit'=>array('pagesize'=>0,'offset'=>0),
							'Join'=>array()
							);
		return $this;
	}
	
	public function DB($DBName)
	{
		$this->setDB($DBName);
		return $this;
	}

	/**
	  * Fields
	  *
	  * 设置要查询或插入或更新的字段,如字段名需要别名"Field1",请直接设置如"Field1 as F1";
	  *
	  * @param string $fields 字段名,多个字段名可以当成多个参数,
	  */
	public function Fields()
	{
		$fields=func_get_args();
		if(!empty($fields) )
		{
			foreach($fields as $field)
			{
				if(is_string($field) && !empty($field) )
				{
					$this->SQL_Adpat['Field'][]=$field;
				}
			}
		}
		return $this;
	}


	/**
	  * Table
	  *
	  * 要查询的表名,如'tablename1',如需要给表附加别名,则"tablename as t1"
	  *
	  * @param string $fields 字段名,多个字段名可以当成多个参数,
	  */
	public function Table()
	{
		$tbs=func_get_args();
		if(!empty($tbs) )
		{
			foreach($tbs as $table)
			{
				if(is_string($table) && !empty($table) )
				{
					$this->SQL_Adpat['Table'][]=$table;
				}
			}
		}
		return $this;
	}
	

	/**
	  * Where
	  *
	  * 要查询的条件
	  *
	  * @param string|array $cond 条件语句
	  * @param string $logic = "AND|OR" 该批语句的连接逻辑,是AND还是OR
	  */
	public function Where($cond,$logic='AND')
	{
		if(!empty($cond) )
		{
			$logic= in_array(strtoupper($logic),array('AND','OR')) ? strtoupper($logic) : 'AND';
			if(is_array($cond))
			{
				foreach($cond as $str)
				{
					if(is_string($str) && !empty($str) )
					{
						$this->SQL_Adpat['Where'][$logic][]=$str;
					}
				}
			}
			else
			{
				$this->SQL_Adpat['Where'][$logic][]=$cond;
			}
		}
		return $this;
	}
	
	/**
	  * Orderby
	  *
	  * 查询时所使用的排序
	  *
	  * @param string $field
	  * @param string $sort
	  */
	public function Orderby($field,$sort = 'ASC')
	{
		if(!empty($field) )
		{
			$sort = in_array(strtoupper($sort),array('ASC','DESC')) ? strtoupper($sort):'ASC';
			$this->SQL_Adpat['OrderBy'][$field]=$sort;
		}
		return $this;
	}
	
	/**
	  * Having
	  *
	  * Having条件设定
	  *
	  * @param string $fields 字段名,多个字段名可以当成多个参数,
	  */
	public function Having()
	{
		$conds=func_get_args();
		if(!empty($conds) )
		{
			foreach($conds as $cond)
			{
				if(is_string($cond) && !empty($cond) )
				{
					$this->SQL_Adpat['Having'][]=$cond;
				}
			}
		}
		return $this;
	}

	
	/**
	  * GroupBy
	  *
	  * 要归组的字段
	  *
	  * @param string $fields 字段名,多个字段名可以当成多个参数,
	  */
	public function GroupBy()
	{
		$fields=func_get_args();
		if(!empty($fields) )
		{
			foreach($fields as $field)
			{
				if(is_string($field) && !empty($field) && !in_array($field, $this->SQL_Adpat['GroupBy']))
				{
					$this->SQL_Adpat['GroupBy'][]=$field;
				}
			}
		}
		return $this;
	}


	/**
	  * Record
	  *
	  * 设置查询记录时的起始位置和条数
	  *
	  * @param int @records 每一条记录为一个数组,多个记录可以直接多个参数传递
	  */
	public function Record()
	{
		$records=func_get_args();
		if(!empty($records) )
		{
			foreach($records as $r)
			{
				if(is_array($r) && !empty($r) )
				{
					$this->SQL_Adpat['Record'][]=$r;
				}
			}
		}
		return $this;
	}






	/**
	  * Limit
	  *
	  * 设置查询记录时的起始位置和条数
	  *
	  * @param string $offset 从第几条开始读取, SQL语句中的limit x,y 中的x
	  * @param int @pagesize 每页读取条数,SQL语句中的limit x,y 中的y
	  */
	public function Limit($offset=0 , $pagesize = 0)
	{
		$this->SQL_Adpat['Limit']['pagesize']=(int)$pagesize;
		$this->SQL_Adpat['Limit']['offset']=(int)$offset;
		return $this;
	}

		

	/**
	  * Join
	  *
	  * 连表设置
	  *
	  * @param string $tb 要连接的表名,包括别名,如"tablename as tb1",不需要别名则"tablename"即可
	  * @param string $type = 'LEFT|RIGHT|INNER|UNION|LEFT OUTER|RIGHT OUTER|HASH|MERGE.....' 连接类型
	  * @param string $cond 表连接的条件,ON 后面的内容
	  */
	public function Join($tb,$type='' ,$cond ="")
	{
		if(!empty($tb) )
		{
			$this->SQL_Adpat['Join'][]=array('Type'=>$type,'Table'=>$tb,'ON'=>$cond);
		}
		return $this;
	}


	/**
	  * Execute
	  *
	  * 执行SQL语句,
	  *
	  * @param string $SQL 该方法是所有SQL操作方法的补充,用于执行一些无法进行拼装的操作
	  * return array array('status'=>true|false,'SQL'=>'','rows'=>(int)X,'lastid'=>'')
	  */
	public function Execute($SQL)
	{
		return $this->Query("QUERY",empty($SQL)?$this->SQL_Adpat:$SQL);
	}

	/**
	  * Save
	  *
	  * 保存记录
	  *
	  * @param bool $isReplace = false 是否使用替换 REPLACE 
	  * return array array('status'=>true|false,'SQL'=>'','rows'=>(int)X,'lastid'=>'')
	  */
	public function Save($isReplace = FALSE)
	{
		return $this->Query($isReplace?"REPLACE":"INSERT",$this->SQL_Adpat);
	}


	/**
	  * Delete
	  *
	  * 按条件删除记录,如果设置了LIMIT,则会使用LIMIT语句对删除行数进行限制
	  *
	  * return array array('status'=>true|false,'SQL'=>'','rows'=>(int)X)
	  */
	public function Delete()
	{
		return $this->Query("DELETE",$this->SQL_Adpat);
	}


	/**
	  * Update
	  *
	  * 按条件更新记录,如果设置了LIMIT,则会使用LIMIT语句对删除行数进行限制
	  *
	  * return array array('status'=>true|false,'SQL'=>'','rows'=>(int)X)
	  */
	public function Update($SQL = "")
	{
		return $this->Query("UPDATE",empty($SQL)?$this->SQL_Adpat:$SQL);
	}

	/**
	  * FetchOne
	  *
	  * 执行查询语句,并读取第一行的第一列
	  *
	  * @param string $SQL ="" SQL语句,如果传递了该参数,则以该语句为优先,否则使用SQL_Adpat进行组装
	  * return string|NULL
	  */
	public function FetchOne($SQL = "")
	{
		return $this->Query("FETCHONE",empty($SQL)?$this->SQL_Adpat:$SQL);
	}


	/**
	  * FetchRow
	  *
	  * 执行查询语句,并读取第一行
	  *
	  * @param string $SQL ="" SQL语句,如果传递了该参数,则以该语句为优先,否则使用SQL_Adpat进行组装
	  * return string|NULL
	  */
	public function FetchRow($SQL = "")
	{
		return $this->Query("FETCHROW",empty($SQL)?$this->SQL_Adpat:$SQL);
	}


	/**
	  * FetchAll
	  *
	  * 执行查询语句,并读取所有行数
	  *
	  * @param string $SQL ="" SQL语句,如果传递了该参数,则以该语句为优先,否则使用SQL_Adpat进行组装
	  * return array|NULL
	  */
	public function FetchAll($SQL = "" )
	{
		return $this->Query("FETCHALL",empty($SQL)?$this->SQL_Adpat:$SQL );
	}


	/**
	  * Next
	  *
	  * 读取最后一次执行查询后所返回的记录集中的下一行.
	  *
	  * return array|NULL
	  */
	public function Next($offset = 0)
	{
		return $this->Query("FETCHNEXT",$offset);
	}
	

	/**
	  * Err
	  *
	  * 记录错误
	  *
	  * @param string $Type 类型,是在进行什么操作时出错
	  * @param string $Msg 错误信息.
	  */
	public function Err($Type,$Msg)
	{
//        $this->Debug && $this->{ERROR[$Type]}[]=$Msg;
        if($this->Debug==false)return;
        $arr=$this->ERROR["$Type"];
        if($arr==null)
        {
            $arr = array();

        }

        $arr[count($arr)]=$Msg;
        $this->ERROR[$Type]=$arr;
        echo $Msg;
	}


	/**
	  * Debug
	  *
	  * 输出所有执行过的语句和产生的错误,如果调试模式关闭的情况下,将不记录任何信息
	  *
	  * @param string $output 是否直接输出
	  */
	public function Debug($output=TRUE)
	{
		if(!$this->Debug)
		{
			return NULL;
		}
		$Str='';
		if($this->SQLArray)
		{
			$Str.="Your has Queries ".count($this->SQLArray)." SQLs".PHP_EOL;
			$sqlcounter=1;
			foreach($this->SQLArray as $sql)
			{
				$Str.="[". ($sqlcounter++) .']'.$sql.PHP_EOL;
			}
		}
		else
		{
			$Str.="Your havn't Query Any SQL".PHP_EOL;
		}
		$Str.=PHP_EOL;
		if($this->ERROR)
		{
			$Str.="Occur ".count($this->ERROR)." Errors".PHP_EOL;
			foreach($this->ERROR as $Type=>$msg)
			{
				$errorCounter=1;
				$Str.=$Type." Occur ".count($msg)." Errors".PHP_EOL;
				foreach($msg as $err)
				{
					$Str.='['.($errorCounter++).'] => '.$err.PHP_EOL;
				}
			}
		}
		else
		{
			$Str.="0 Error";
		}
		if($output)
		{
			echo "<pre>".$Str."</Pre>";
		}
		else
		{
			return $Str;
		}
	}


	/**
	  * __set
	  *
	  * 设置不存在的变量时
	  *
	  * @param string $key 变量名
	  * @param string $value 变量值
	  */
	public function __set($key,$value)
	{
		$this->Temp[$key]=$value;
	}

	public function __get($key)
	{
		return isset($this->$key)?$this->$key:NULL;
	}
}