<?php
/**
  * NoSQL
  *
  * 非关系型数据库
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


/**
	* $a->DB('DBName');		//指定所指向的数据库
	* $a->DB('XXX')->TB('XXX')		//切换数据库和表
	* $a->TB('Tablename','dbname');			//快速切换表
	* $a->DB('abc')->TB('fuck')->CMD(array('$project'=>array('a'=>1,'b'=>1)))->CMD(array('$project'=>array('_id'=>0)))->Execute('execute');			//成功执行聚合,保存已做参考
	* $a->DB('abc')->TB('fuck')->setPagesize(YY)->setOffset(XX)		//设置从第XX条开始,读取YY条记录,注意,XX从0开始算起,如果设置为1,您将会丢失掉第一条记录
	* $a->reset()  //清空当前的查询语句和页面数设置,在执行完各种查询后,CMD里会保存有当前已经执行的过的查询条件,这时需要注意必需重置一次.
	*
	* var_dump($a->DB('abc')->TB('fuck')->orderBy('a','DESC')->CMD(array('b'=>1))->CMD(array('a'=>array('$gte'=>1,'$lt'=>6)))->CMD(array('a'=>array('$in'=>array(2,3))))->fetchAll()      );//单个查询和批量查询成功.保存以做参考
	* $a->DB('abc')->TB('fuck')->insert(array('a'=>105,'b'=>3),array('a'=>104,'b'=>3),array('a'=>103,'b'=>3));		//插入成功,保存以做参考
	* $a->DB('abc')->TB('fuck')->CMD(array('a'=>array('$gt'=>100)))->CMD(array('b'=>3))->delete(TRUE);		//只删除一条
	* $a->DB('abc')->TB('fuck')->CMD(array('a'=>array('$gt'=>100)))->CMD(array('b'=>3))->delete(FALSE);		//删除全部
	* $a->DB('abc')->dropDB();			//删除当前所处的数据库
	* $a->DB('XX')->TB('XX')->dropTB();	//删除当前所处的表
	* $a->DB('X')->TB('Y')->CMD(....)->getCount();		//读取该条件下的记录条数
*/
class NoSQL
{
	/**
	 * 所使用的驱动
	 *
	 * @var $Drivers
	 */
	static $Drivers = NULL ;
	
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
	private $Temp = array();

	/**
	 * 查询语句组件存储变量
	 *
	 * @var array $Cmd
	 */
	private $Cmd = array();


	/**
	 * 设置分页
	 *
	 * @var int pagesize
	 * @var int page
	 */
	private $pagesize=0;
	private $Offset=0;

	private $orderby=array();

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
				return NULL;
			}
			$setName = $setName ? $setName : $driverConfig['driver'];
			$ClassName=get_class()."_".$driverConfig['driver'];
			self::$Drivers[$setName] = new $ClassName($driverConfig);
			return TRUE;
		}
		return NULL;
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
				self::$Drivers[$Name]->state || self::$Drivers[$Name]->connect();

				return self::$Drivers[$Name];
			}
		}
		return NULL;
	}


	/**
	  * reset
	  *
	  * 重置查询条件和页面条数,起始位置,排序条件
	  *
	  * @param string $Name 要获取的实例化类索引
	  */
	public function reset()
	{
		$this->Cmd= array();
		$this->pagesize=0;
		$this->Offset=0;
		$this->orderby=array();

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
	  * DB
	  *
	  * 切换当前连接数据库的进程所指向的DB
	  *
	  * @param string $DBName 要切换的DB
	  * return mixed $this
	  */
	public function DB($DBName)
	{
		$this->getDB($DBName);
		return $this;
	}

	/**
	  * TB
	  *
	  * 切换当前连接数据库的进程所指向的表名
	  *
	  * @param string $TableName 要切换的表名
	  * @param string $DBName=NULL 要切换的DB
	  * return mixed $this
	  */
	public function TB($TableName,$DBName = NULL)
	{
		$this->getCollection($TableName,$DBName);
		return $this;
	}


	/**
	  * setPagesize
	  *
	  * 设置每页读取行数
	  *
	  * @param string $Pagesize=0 每页记录数量,留空或0为恢复初始化
	  * return mixed $this
	  */
	public function setPagesize($Pagesize = 0)
	{
		$this->pagesize = (int)$Pagesize;
		return $this;
	}


	/**
	  * setOffset
	  *
	  * 定位起始记录数,类似MYSQL里的limit X,pagesize 中的X
	  *
	  * @param string $Offset=0 起始位,从0开始,注意,如果需要取所有数据,又设置该项为1时,您将会丢失一条数据
	  * return mixed $this
	  */
	public function setOffset($Offset = 0)
	{
		$this->Offset = (int)$Offset;
		return $this;
	}


	/**
	  * getCount
	  *
	  * 查询符合条件的记录条数
	  *
	  * return mixed $this
	  */
	public function getCount()
	{
		return $this->Query("COUNT",$this->Cmd);
	}

	/**
	  * orderBy
	  *
	  * 设置即将执行的查询的排序方式,如果排序字段重复设置,则会由后面的设置覆盖前面的设置
	  *
	  * return mixed $this
	  */
	public function orderBy($Field,$Sort='ASC')
	{
		if(!empty($Field) && is_string($Field) && in_array(strtoupper($Sort),array('ASC','DESC') ) )
		{
			$this->orderby[$Field]=strtoupper($Sort);
		}
		return $this;
	}

	/**
	  * CMD
	  *
	  * 设置fetchOne,fetchAll,execute,update,Delete的条件
	  *
	  * return mixed $this
	  */
	public function CMD($Cmd)
	{
		if($Cmd)
		{
			$this->Cmd[]=$Cmd;
		}
		return $this;
	}


	/**
	  * Execute
	  *
	  * 执行已经设置的CMD,注意,有些数据库如果在已经指定了数据库和表之后,就算没有条件,也是可以默认读取所有记录的(如:MongoDB).所以尽量不要发生执行空命令的操作
	  *
	  * @param string $Type 要执行命令的方式,默认QUERY
	  * return mixed $this
	  */
	public function Execute($Type='QUERY')
	{
		return $this->Query("QUERY",$this->Cmd);

	}


	/**
	  * fetchOne
	  *
	  * 读取一行数据,该方法在MongoDB上的表现不同于使用PHP的findone方式 ,而是使用find方式+limit(1)操作,可以进行排序和skip后再limit(1)
	  *
	  * @param array $Fields = array() 要查询的字段名
	  * @param array $Cond = array() 要执行的查询
	  * return mixed $this
	  */
	public function fetchOne($Fields = array(),$Cond = array())
	{
		return $this->Query("SELECTONE",(empty($Cond)?$this->Cmd:$Cond),$Fields);
	}
	

	/**
	  * fetchAll
	  *
	  * 读取符合条件的所有记录,pagesize和offset生效
	  *
	  * @param array $Fields = array() 要查询的字段名
	  * @param array $Cond = array() 要执行的查询
	  * return mixed $this
	  */
	public function fetchAll($Fields = array(),$Cond = array())
	{
		return $this->Query("SELECTALL",(empty($Cond)?$this->Cmd:$Cond),$Fields);
	}

	/**
	  * update
	  *
	  * 更新信息,
	  *
	  * @param array $NewValue 新的值
	  * @param array $Cond = array() 条件
	  */
	 public function update($NewValue,$Cond= array())
	{
		return $this->Query("UPDATE",(empty($Cond)?$this->Cmd:$Cond),$NewValue);
	}

	/**
	  * insert
	  *
	  * 插入新数据,可以无限插入,每个参数为一个新记录
	  *
	  * @param arrays|objects 要插入的记录
	  */
	public function insert()
	{
		$doc=func_get_args();
		if($doc)
		{
			return call_user_func(array($this,'Query'),'INSERT',$doc);
		}
		else
		{
			return false;
		}
	}

	/**
	  * showTables
	  *
	  * 显示当前所选的数据库下,有多少表
	  *
	  * return mixed 
	  */
	public function showTables()
	{
			return call_user_func(array($this,'Query'),'SHOWTABLES');
	}

	/**
	  * showDatabases
	  *
	  * 显示当前所连接的服务上的数据库列表
	  *
	  * return mixed 
	  */
	public function showDatabases()
	{
			return call_user_func(array($this,'Query'),'SHOWDATABASES');
	}

	/**
	  * delete
	  *
	  * 删除数据
	  *
	  * @param bool $onlyOne = FALSE 是否只删除一行记录,
	  * @param array $Cond = array() 删除的条件,不填时使用CMD
	  * return mixed $this
	  */
	public function delete($onlyOne = FALSE, $Cond = array())
	{
		return $this->Query("DELETE",(empty($Cond)?$this->Cmd:$Cond),$onlyOne);
	}

	/**
	  * dropTB
	  *
	  * 删除当前所指向的表(collection) ,删除后操作类会变成未指定表状态,下次要执行操作前,需要重新指定一个表
	  *
	  */
	public function dropTB()
	{
		return $this->Query("DROPTABLE");
	}
	
	/**
	  * dropDB
	  *
	  * 删除当前所指向的数据库(DB) ,删除后操作类会变成未指定数据库和表状态,下次要执行操作前,需要重新指定数据库和表
	  *
	  */
	public function dropDB()
	{
		$this->Query("DROPDATABASE");
	}


	//public function 

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
		$this->Debug && $this->ERROR[$Type][]=$Msg;
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