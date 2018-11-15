<?php
/**
  * NoSQL_MongoDB
  *
  * MongoDB的驱动类
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

class NoSQL_MongoDB extends NoSQL
{
	/**
	 * 数据库基本连接属性
	 *
	 * @var $Host 连接地址
	 * @var $User 用户名
	 * @var $Password 密码
	 * @var $DBName	数据库名
	 * @var $Port 端口
	 */
	public $Host='';
	public $User='';
	public $Password='';
	public $DBName='';
	public $Port=27017;
	public $state=FALSE;
	/**
	 * 必须的参数列表
	 *
	 * @var $Require_Config
	 */
	public $Require_Config=array();

	/**
	 * 连接句柄
	 *
	 * @var $conn
	 */
	protected $conn=null;


	/**
	 * DB库实例化后保存,以便下次执行时使用,无需再次实例化
	 *
	 * @var $DBHandle
	 */
	protected $DBHandle = Array();

	/**
	 * Collection实例化后保存,以便下次执行时使用,无需再次切换
	 *
	 * @var $CollectionHandle
	 */
	protected $CollectionHandle = Array();


	/**
	 * 当前指向的DB和集合
	 *
	 * @var $DB_Current
	 * @var $Collection_Current
	 */
	protected $DB_Current = NULL;
	protected $Collection_Current = NULL;
	


	/**
	 * 支持事件列表,以及对应的处理方法
	 * 
	 * @var array $Op_List
	 */
	private $Op_List=array(
						'QUERY'=>'Aggregate',
						'SELECTONE'=>'FindOne',
						'SELECTALL'=>'Find',
						'UPDATE'=>'Update',
						'INSERT'=>'Insert',
						'DELETE'=>'Remove',
						'DROPTABLE'=>'DropTable',
						'DROPDATABASE'=>'DropDataBase',
						'COUNT'	=>"Count",
						'SHOWTABLES'=>'ShowTBS',
						'SHOWDATABASES'=>'ShowDBS'
						);

	/**
     * connect
     *
	 * 连接数据库
	 *
    */
	public function connect()
	{
		if(!class_exists('MongoClient'))
		{
			throw new Exception('MongoClient Extension not loaded');
		}
		$connect_str='mongodb://';
		empty($this->Host) && $this->Host=MongoClient::DEFAULT_HOST;
		empty($this->Port) && $this->Port=MongoClient::DEFAULT_PORT;
		$host=$this->Host.":".$this->Port;
		if ($this->User)
		{
			if($this->Password)
			{
				$host=$this->User.":".$this->Password."@".$host;
			}
			else
			{
				$host=$this->User."@".$host;
			}
		}
		$connect_str.=$host.'/';
		try
		{
			$this->conn=new MongoClient($connect_str);
		}
		catch (Exception $e)
		{
			throw new Exception ("MongoDB:Couldn't Connect Server");
		}

		if(!empty($this->conn->connected))
		{
			$this->state=TRUE;
			if($this->DBName)
			{
				$this->getDB($this->DBName);
			}

			return TRUE;
		}
		else
		{
			throw new Exception ("MongoDB:Couldn't Connect Server2");
		}
		return FALSE;
	}

	/**
     * getDB
     *
	 * 切换数据库,并返回一个mongoDB实例类
	 *
     * @param string $DBName 要切换的数据库名
    */
	public function getDB($DBName)
	{
		$this->DB_Current = NULL;
		if(empty($DBName))
		{
			return NULL;
		}
		if($this->conn && $this->conn->connected)
		{
			empty($this->DBHandle[$DBName]) && $this->DBHandle[$DBName] = new MongoDB($this->conn,$DBName);
			if(!empty($this->DBHandle[$DBName]))
			{
				$this->DB_Current = $DBName;
			}
			return $this->DBHandle[$DBName]?TRUE:FALSE;
		}
		else{
			return NULL;
		}
	}

	/**
     * getCollection
     *
	 * 切换数据集(表),并返回实例
	 *
     * @param string $DBName=NULL 要切换的数据集所在数据库名
	 * @param string $CollectionName 要切换的数据集名称
	 * return mixed 
    */
	public function getCollection($CollectionName , $DBName = NULL)
	{
		$this->Collection_Current = NULL;
		if(!$DBName && !$this->DB_Current)
		{
			$this->Err('getCollection','Not DB selected');
			return FALSE;
		}
		else
		{
			if($this->DB_Current!=$DBName && !$this->getDB($DBName))
			{
				$this->Err('getCollection','switch to DB ['.$DBName.'] faild');
				return FALSE;
			}
		}

		if(!empty($this->CollectionHandle[$DBName][$CollectionName]))
		{
			$this->Collection_Current = $CollectionName;
		}
		else
		{
			($this->CollectionHandle[$this->DB_Current][$CollectionName] = new MongoCollection($this->DBHandle[$this->DB_Current],$CollectionName)) && $this->Collection_Current = $CollectionName;
		}
		return $this->Collection_Current?TRUE:FALSE;		
	}
	

	/**
     * Query
     *
	 * 执行操作,分捡操作调度方法
	 *
	 * return mixed 
    */
	public function Query()
	{
		$params=func_get_args();
		if($params && isset($this->Op_List[$params[0]]) )
		{
			$OpType=$params[0];
			return call_user_func(array($this,$this->Op_List[$OpType]),(array_slice($params,1)));
		}
		else
		{
			return NULL;
		}
	}

	/**
     * Aggregate
     *
	 * 执行聚合
	 *
	 * @param array $op 聚合指令
	 * return mixed 
    */
	public function Aggregate($op)
	{
		if(!is_array($op) || !$op)
		{
			return NULL;
		}
		if(!$this->DB_Current || !$this->Collection_Current)
		{
			$this->Err('Aggregate','Not DB or Collection selected');
			return FALSE;
		}
		if(empty($this->CollectionHandle[$this->DB_Current][$this->Collection_Current]))
		{
			$this->Err('Aggregate','Collection Handle Not Exists');
			return FALSE;
		}
		$Result=$this->CollectionHandle[$this->DB_Current][$this->Collection_Current]->aggregate($op[0]);
		
		if(!empty($Result['ok']) && $Result['result'])
		{
			return $Result['result'];
		}
		else if(!empty($Result['errmsg']))
		{
			$this->Err('Aggregate','[Aggregate]:'.json_encode((object)$op[0]).";[errmsg]:".$Result['errmsg']);
		}
		return NULL;
	}
	
	
	
	/**
     * FindOne
     *
	 * 查找一条记录,使用系统自带findone进行查询,必须传递查询参数,不需要设置分页
	 *
	 * @param array $cmd 查询指令
	 * return mixed 
    */
	public function FindOne($cmd)
	{

		if(!$this->DB_Current || !$this->Collection_Current)
		{
			$this->Err('FindOne','Not DB or Collection selected');
			return FALSE;
		}
		if(empty($this->CollectionHandle[$this->DB_Current][$this->Collection_Current]))
		{
			$this->Err('FindOne','Collection Handle Not Exists');
			return FALSE;
		}
		empty($cmd[1]) && $cmd[1]=array();
		$query=array();
		if($cmd[0])
		{
			foreach($cmd[0] as $v)
			{
				$query=array_merge_recursive($query,$v);
			}
		}
		$Result=$this->CollectionHandle[$this->DB_Current][$this->Collection_Current]->find($cmd[0],$cmd[1]);
		
		if($this->Offset)
		{
			$Result->skip($this->Offset);
		}
		if($this->orderby)
		{
			$order=array();
			foreach($this->orderby as $Field=>$Sort)
			{
				$order[$Field]=$Sort=='DESC'?-1:1;
			}
			$Result->sort($order);
		}
		$Result->limit(1);
		
		if($Result)
		{
			return iterator_to_array($Result);
		}
		else
		{
			return NULL;
		}
		
	}


	/**
     * Find
     *
	 * 查找所有记录,如有设置页数和页面条数,则会生效
	 *
	 * @param array $cmd 查询指令
	 * return mixed 
    */
	public function Find($cmd)
	{

		if(!$this->DB_Current || !$this->Collection_Current)
		{
			$this->Err('Find','Not DB or Collection selected');
			return FALSE;
		}
		if(empty($this->CollectionHandle[$this->DB_Current][$this->Collection_Current]))
		{
			$this->Err('Find','Collection Handle Not Exists');
			return FALSE;
		}
		empty($cmd[1]) && $cmd[1]=array();
		$query=array();
		if($cmd[0])
		{
			foreach($cmd[0] as $v)
			{
				$query=array_merge_recursive($query,$v);
			}
		}
		$Result=$this->CollectionHandle[$this->DB_Current][$this->Collection_Current]->find($query,(empty($cmd[1])?array():$cmd[1]));

		if($this->orderby)
		{
			$order=array();
			foreach($this->orderby as $Field=>$Sort)
			{
				$order[$Field]=($Sort=='DESC'?-1:1);
			}
			$Result->sort($order);
		}
		
		
		if($this->Offset)
		{
			$Result->skip($this->Offset);
		}
		if($this->pagesize)
		{
			$Result->limit($this->pagesize);
		}
		
		if($Result)
		{
			return iterator_to_array($Result,false);
		}
		$Error=$this->DBHandle[$this->DB_Current]->lastError();
		if($Error['err'])
		{
			$this->Err('Find',"item:".print_r($doc,TRUE).";".$Error['err']);
		}
		return NULL;
	}

	/**
     * Insert
     *
	 * 添加记录,可以批量添加,批量添加时,需要注意如果只有一条错误时,也会返回FALSE.但实际上没出错的记录会记录,
	 * 如果在出错时,需要保持记录的完整性和统一性,可以使用同样的参数进行remove一次.
	 *
	 * $param arrays|objects 
	 * return boolean 
    */
	final function Insert()
	{
		if(!$this->DB_Current || !$this->Collection_Current)
		{
			$this->Err('Insert','Not DB or Collection selected');
			return FALSE;
		}
		if(empty($this->CollectionHandle[$this->DB_Current][$this->Collection_Current]))
		{
			$this->Err('Insert','Collection Handle Not Exists');
			return FALSE;
		}

		$doc=func_get_args();
		if(!$doc)
		{
			return FALSE;
		}
		$this->CollectionHandle[$this->DB_Current][$this->Collection_Current]->batchInsert($doc,array('w'=>0));
		$Error=$this->DBHandle[$this->DB_Current]->lastError();
		

		if($Error['err'])
		{
			$this->Err('Insert',"item:".print_r($doc,TRUE).";".$Error['err']);
		}
		return TRUE;
	}




	/**
     * Remove
     *
	 * 移除记录.
	 *
	 * $param array|object $cmd 删除条件
	 * return boolean 
    */
	public function Remove($cmd)
	{
		if(!$this->DB_Current || !$this->Collection_Current)
		{
			$this->Err('Remove','Not DB or Collection selected');
			return FALSE;
		}
		if(empty($this->CollectionHandle[$this->DB_Current][$this->Collection_Current]))
		{
			$this->Err('Remove','Collection Handle Not Exists');
			return FALSE;
		}

		$query=array();
		if($cmd[0])
		{
			foreach($cmd[0] as $v)
			{
				$query=array_merge_recursive($query,$v);
			}
		}
		else
		{
			return FALSE;
		}
		$op=array('w'=>0);
		if(isset($cmd[1]))
		{
			$op['justOne']= ($cmd[1]?TRUE:FALSE);
		}
		$this->CollectionHandle[$this->DB_Current][$this->Collection_Current]->remove($query,$op);
		$Error=$this->DBHandle[$this->DB_Current]->lastError();
		
		if($Error['err'])
		{
			$this->Err('Remove',"item:".print_r($doc,TRUE).";".$Error['err']);
		}
		return TRUE;
	}


	/**
     * DropTable
     *
	 * 删除当前所指定的表
	 *
	 * return boolean 
    */
	public function DropTable()
	{
		if(!$this->DB_Current || !$this->Collection_Current)
		{
			$this->Err('DropTable','Not DB or Collection selected');
			return FALSE;
		}
		
		if(empty($this->CollectionHandle[$this->DB_Current][$this->Collection_Current]))
		{
			$this->Err('Remove','Collection Handle Not Exists');
			return FALSE;
		}
		$Result = $this->CollectionHandle[$this->DB_Current][$this->Collection_Current]->drop();
		$this->Collection_Current = NULL;
		$this->CollectionHandle[$this->DB_Current][$this->Collection_Current] = NULL;
		if(!empty($Result['errmsg']))
		{
			$this->Err('DropTable',$Result['errmsg']);
			return FALSE;
		}
		return TRUE;
	}

	/**
     * DropDatabase
     *
	 * 删除当前所指定的数据库
	 *
	 * return boolean 
    */
	public function DropDataBase()
	{
		if(!$this->DB_Current || empty($this->DBHandle[$this->DB_Current]))
		{
			$this->Err('DropDataBase','Not DB selected');
			return FALSE;
		}
		$Result=$this->DBHandle[$this->DB_Current]->drop();

		$this->DB_Current = NULL;
		$this->DBHandle[$this->DB_Current] = NULL;
		$this->CollectionHandle[$this->DB_Current] = NULL;
		if(!empty($Result['errmsg']))
		{
			$this->Err('DropDataBase',$Result['errmsg']);
			return FALSE;
		}
		return TRUE;

	}


	/**
     * ShowTBS
     *
	 * 返回当前连接的数据库上所有表
	 *
	 * return int  
    */
	public function ShowTBS()
	{
		if(!$this->DB_Current || empty($this->DBHandle[$this->DB_Current]))
		{
			$this->Err('ShowTBS','Not DB selected');
			return NULL;
		}
		return $this->DBHandle[$this->DB_Current]->getCollectionNames();

	}

	/**
     * ShowDBS
     *
	 * 返回当前连接的服务器上的所有数据库列表
	 *
	 * return int  
    */
	public function ShowDBS()
	{
		if(!$this->conn)
		{
			$this->Err('ShowDBS','Not db connected');
			return NULL;
		}
		$result=$this->conn->listDBs();
		if(!empty($result['databases']))
		{
			return $result['databases'];
		}
		else
		{
			return NULL;
		}
	}

	/**
     * Count
     *
	 * 返回符合条件的记录条数
	 *
	 * @param array $cmd 
	 * return int  
    */
	public function Count($cmd)
	{
		
		if(!$this->DB_Current || !$this->Collection_Current)
		{
			$this->Err('Find','Not DB or Collection selected');
			return 0;
		}
		if(empty($this->CollectionHandle[$this->DB_Current][$this->Collection_Current]))
		{
			$this->Err('Find','Collection Handle Not Exists');
			return 0;
		}
		empty($cmd[1]) && $cmd[1]=array();
		$query=array();
		if($cmd[0])
		{
			foreach($cmd[0] as $v)
			{
				$query=array_merge_recursive($query,$v);
			}
		}
		return $this->CollectionHandle[$this->DB_Current][$this->Collection_Current]->count($query);

	}
	
	public function __destruct(){
		if(!empty($this->conn) && !empty($this->conn->connected)){
			$this->conn->close(true);
		}
	}
}