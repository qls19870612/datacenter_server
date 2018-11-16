<?php
/**
  * TSQL_mysql
  *
  * mysql的驱动类
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

/**
  * <code>
  *   $db->reset()->Table('t_9388_pay t')->Fields('order_id','PlayerID','gold')->Where('gold>1000')->Where('ServerId=12 or ServerId=13')->Where('gold<10','or')->Join('a as a','left','a.uid=t.uid')->Limit(10,10)->GroupBy('playerid')->OrderBy('orderid', 'desc')->FetchOne();
  *   $db->reset()->Table('t_9388_pay')->Where('ServerId=12')->delete();
  *
  *
  *   $db->reset()->Table('t_9388_pay')->Fields('order_id','PlayerID2')->Record(array('abc',1),array('bcd',2))->Record(array('dede',3))->save(TRUE);
  *
  * </code>
  */
class TSQL_mysqli extends TSQL
{
	/**
	 * 数据库基本连接属性
	 *
	 * @var $Host 连接地址
	 * @var $User 用户名
	 * @var $Password 密码
	 * @var $DBName	数据库名
	 * @var $Port 端口
	 * @var $Charset 字符集
	 */
	public $Host='';
	public $User='';
	public $Password='';
	public $DBName='';
	public $Port='';
	public $Charset='';

	/**
	 * 必须的参数列表
	 *
	 * @var $Require_Config
	 */
	public $Require_Config=array('Host','User','Password');

	/**
	 * 最近一次的结果集保存
	 *
	 * @var $Result
	 */
	public $Result = NULL;
	
	/**
	 * 当前数据库所指向DB
	 *
	 * @var $DB_Current
	 */

	public $DB_Current = NULL;

	public $OPCODE = array(
						'QUERY' => 'SELECT',
						'INSERT' =>'INSERT INTO',
						'REPLACE'=>'REPLACE INTO',
						'DELETE'=>'DELETE',
						'UPDATE'=>'UPDATE',
						'FETCHONE'=>'SELECT',
						'FETCHROW'=>'SELECT',
						'FETCHALL'=>'SELECT',
						'FETCHNEXT'=>''
						);
	/**
     * connect
     *
	 * 连接数据库
	 *
     * @param string $is_new 是否使用新连接
    */
	public function connect($is_new = TRUE)
	{
		$this->setDB();
		if($this->Host && $this->User && $this->Password)
		{
			$hoststr=$this->Host.(empty($this->Port)?'':(":".$this->Port));
			$this->conn = @mysqli_connect($hoststr,$this->User,$this->Password,"datacenter","3306");
			
			if($this->conn)
			{
				$this->setDB($this->DBName);

				//设置字符集
				$this->setCharset($this->Charset);

				return TRUE;

			}
			else
			{
				$this->Err('Connect',mysqli_error());
				//throw new Exception ('Mysql:Couldn\'t Connect faild');
				return FALSE;
			}
		}
		else 
		{
			$this->Err('Connect','Miss Config!');
			return FALSE;

		}
	}

	/**
     * setDB
     *
	 * 选定数据库
	 *
     * @param string $DBName = NULL 要连接的数据库名称
    */
	public function setDB($DBName = NULL)
	{
		$this->DB_Current= NULL;

		if($DBName && $this->conn)
		{
			if($this->Query('QUERY',sprintf("USE %s",$DBName),TRUE))
			{
				$this->DB_Current = $DBName;
			}
			else if(mysqli_errno($this->conn))
			{
				$this->Err('setDB','[switch DB '.$DBName.']:'.mysqli_error($this->conn));
			}
			else
			{
				$this->Err('setDB','[switch DB '.$DBName.']:Faild');
			}
		}

	}


	/**
     * setCharset
     *
	 * 设置当前数据库链接所使用的字符集
	 *
     * @param string $DBName = NULL 要连接的数据库名称
    */
	public function setCharset($Charset = NULL)
	{
		$Charset && $this->conn && (@mysqli_set_charset($this->conn,$Charset) or $this->Err('setCharset','[set Charset ='.$Charset.']:'.mysqli_error($this->conn)));
	}

	/**
     * CreateSQL
     *
	 * 利用SQL_Adpat组装SQL语句
	 *
     * @param array $SQL_Adpat 要组装的SQL语句数组
	 * @param String $type 类型
	 *
	 * return string 
    */

	private function CreateSQL($SQL_Adpat,$type)
	{
		if(empty($SQL_Adpat) || !isset($this->OPCODE[strtoupper($type)]) )
		{
			return NULL;
		}

		if(is_string($SQL_Adpat))
		{
			return $SQL_Adpat;
		}
		$SQL_str=$this->OPCODE[strtoupper($type)];
		switch(strtoupper($type))
		{
			case "FETCHONE":
			case 'FETCHROW':
			case 'FETCHALL':
			case 'QUERY':
				$SQL_str.="  ".($SQL_Adpat['Field']?implode(',',$SQL_Adpat['Field']):' * ').
						' FROM ' . implode(',',$SQL_Adpat['Table']) . " ";
				if(!empty($SQL_Adpat['Join']))
				{
					foreach($SQL_Adpat['Join'] as $join)
					{
						$SQL_str.=" ".$join['Type']." JOIN ".$join['Table']." ON ".$join['ON']." ";
					}
				}
				if(!empty($SQL_Adpat['Where']['AND']) || !empty($SQL_Adpat['Where']['OR']) )
				{
					$SQL_str.=" WHERE ";
					$has_and = FALSE;
					if(!empty($SQL_Adpat['Where']['AND']))
					{
						$SQL_str.=' ('.implode(') AND (',$SQL_Adpat['Where']['AND']).') ';
						$has_end = TRUE;
					}
					if(!empty($SQL_Adpat['Where']['OR']))
					{
						$SQL_str.=($has_end?" OR ":"").' ('.implode(') OR (',$SQL_Adpat['Where']['OR']).') ';
						$has_end = TRUE;
					}
				}
				$SQL_Adpat['GroupBy'] && ($SQL_str.=" GROUP BY ".implode(',',$SQL_Adpat['GroupBy'])." ");
				if($SQL_Adpat['OrderBy'])
				{
					$order=array();
					foreach($SQL_Adpat['OrderBy'] as $field=>$sort)
					{
						$order[] = $field . ' ' . $sort;
					}
					$SQL_str.="ORDER BY ".implode(',',$order)." ";
				}
				$SQL_Adpat['Having'] && ($SQL_str.=" HAVING ".implode(',',$SQL_Adpat['Having'])." ");
				if($SQL_Adpat['Limit']['pagesize'] || $SQL_Adpat['Limit']['offset'])
				{
					$SQL_str.=" LIMIT ".intval($SQL_Adpat['Limit']['offset']).",".intval($SQL_Adpat['Limit']['pagesize']);
				}
				break;
			case 'INSERT':
			case 'REPLACE':
				$records=array();
				$fieldCount=count($SQL_Adpat['Field']);
				if($SQL_Adpat['Record'])
				{
					$SQL_str.=" " . implode(',',$SQL_Adpat['Table']) . " " . ($SQL_Adpat['Field']?'('.implode(',',$SQL_Adpat['Field']).')':"")." VALUES ";
					foreach($SQL_Adpat['Record'] as $record)
					{
						$fieldCount &&  
						($fieldCount>count($record) && $record=array_pad($record,$fieldCount) ) || 
						($fieldCount<count($record) && $record=array_slice($record,-(count($record)-$fieldCount)) );
						$records[]="('".implode("','",$record)."')";
					}
					$SQL_str.= implode(',',$records);
				}
				break;
			case 'UPDATE':
				if($SQL_Adpat['Field'])
				{
					$SQL_str.=" ".implode(',',$SQL_Adpat['Table'])." SET ";
					$records=array();
					$Value=array_values($SQL_Adpat['Record'][0]);

					foreach($SQL_Adpat['Field'] as $k=>$fd)
					{
						$records[]=$fd."='".$Value[$k]."'";
					}
					$SQL_str.=implode(',',$records);
					if(!empty($SQL_Adpat['Where']['AND']) || !empty($SQL_Adpat['Where']['OR']) )
					{
						$SQL_str.=" WHERE ";
						$has_and = FALSE;
						if(!empty($SQL_Adpat['Where']['AND']))
						{
							$SQL_str.=' ('.implode(') AND (',$SQL_Adpat['Where']['AND']).') ';
							$has_end = TRUE;
						}
						if(!empty($SQL_Adpat['Where']['OR']))
						{
							$SQL_str.=($has_end?" OR ":"").' ('.implode(') OR (',$SQL_Adpat['Where']['OR']).') ';
							$has_end = TRUE;
						}
					}
				}
				break;
			case 'DELETE':
				$SQL_str.=" FROM ".implode(',',$SQL_Adpat['Table'])." ";
				if(!empty($SQL_Adpat['Where']['AND']) || !empty($SQL_Adpat['Where']['OR']) )
				{
					$SQL_str.=" WHERE ";
					$has_and = FALSE;
					if(!empty($SQL_Adpat['Where']['AND']))
					{
						$SQL_str.=' ('.implode(') AND (',$SQL_Adpat['Where']['AND']).') ';
						$has_end = TRUE;
					}
					if(!empty($SQL_Adpat['Where']['OR']))
					{
						$SQL_str.=($has_end?" OR ":"").' ('.implode(') OR (',$SQL_Adpat['Where']['OR']).') ';
						$has_end = TRUE;
					}
				}
				if(!empty($SQL_Adpat['Limit']['pagesize']))
				{
					$SQL_str.=" LIMIT ".intval($SQL_Adpat['Limit']['pagesize']);
				}
				break;
			
		}
		return $SQL_str;
	}


	/**
     * Query
     *
	 * 执行语句.
	 *
     * @param string $Type 要执行的类型
	 * @param String|Array $SQL_Adpat 要执行的SQL语句或组装数组
	 * @param bool $onlyStatus = false 只返回执行状态,还是返回包括语句等内容
	 *
	 * return array array('status'=>true|false,'SQL'=>'','rows'=>(int)X,'lastid'=>'')
    */
	public function Query($Type,$SQL_Adpat = NULL,$onlyStatus=FALSE)
	{
	    
		$Result=array('status'=>FALSE,'SQL'=>'','affect_rows'=>0,'rows_nums'=>0);

		if(!$this->conn)
		{
			$this->Err('Query','Database Not Connect');
			return $onlyStatus ? $Result['status'] : $Result;
		}
        
        $SQL=$this->CreateSQL($SQL_Adpat,$Type);
        $Result['SQL']=$SQL;

        
        if( !empty($SQL) )
        {
            
            $this->Debug && $this->SQLArray[]=$SQL;
			
			if($this->Result = @mysqli_query($this->conn,$SQL))
			{
                
				//执行成功
				switch(strtoupper($Type))
				{
					case 'QUERY':
					case 'INSERT':
					case 'UPDATE':
					case 'DELETE':
					case 'REPLACE':
						$Result['affect_rows']=$this->getAffectRows();
						$Result['rows_nums']=$this->getResultNum();
						$Result['lastid']=$this->getLaseID();
						$Result['status']=TRUE;
						break;
					case 'FETCHONE':
						$result=$this->fetch();
						if($result)
						{
							$result=array_reverse($result);
							$result=array_pop($result);
						}
						return $result;
						break;
					case 'FETCHROW':
						$result=$this->fetch();
						return $result;
						break;
					case 'FETCHALL':
						$results=array();
						while($tmp=$this->fetch())
						{
							$results[]=$tmp;
						}
						return $results;
						break;
				}
			}
			else
			{
				if(mysqli_errno($this->conn))
				{
					$this->Err('Query',"[SQL] : ".$SQL.PHP_EOL."[ERROR] : ".mysqli_error($this->conn));
				}
			}
		}
		else if(strtoupper($Type)=='FETCHNEXT')
		{
			return $this->fetch();
		}

		return $onlyStatus ? $Result['status'] : $Result;
	}


	/**
     * fetch
     *
	 * 从数据集获取一行
	 *
	 * @param int $MoveTo 移往第几行开始
	 * return Array
    */
	public function fetch($MoveTo = -1)
	{
		if ( $this->Result &&  $this->Result->num_rows)
		{
			$MoveTo>=0 && $MoveTo<$this->getResultNum() && mysqli_data_seek($this->Result,$MoveTo);
			if ( $row = @mysqli_fetch_array( $this->Result, MYSQLI_ASSOC ) )
			{
				return $row;
			}
			else
			{
				return NULL;
			}
		}
		else
		{
			return NULL;
		}
	}



	/**
     * getLaseID
     *
	 * 获取插入的数据的ID,该方法必须在表有主键的情况下.如果需要检查更新或插入是否成功.建议通过检查getAffectRows()和Query()进行检查
	 *
	 * return int
    */
	public function getLaseID()
	{
		$id=0;
		if ( $this->conn )
		{
			$id=@mysqli_insert_id( $this->conn );
		}
		
		if ( $id ){
			return $id;
		}else{
			return 0;
		}
	}


	/**
     * getAffectRows
     *
	 * 读取最后一次操作的影响行数.通常可以用于更新或插入时的状态检查
	 *
	 * return int
    */
	public function getAffectRows(){
		if($this->conn)
		{
			return intval(@mysqli_affected_rows( $this->conn));
		}
		else
		{
			return 0;
		}
	}

	/**
     * getResultNum
     *
	 * 返回当前数据集里的数据条数
	 *
	 * return int
    */

	public function getResultNum()
	{
		if($this->Result && is_resource($this->Result))
		{
			return intval(mysqli_num_rows($this->Result));
		}
		else
		{
			return 0;
		}
	}
}