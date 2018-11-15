<?php


class ARC
{
	/**
	 * 状态标识的常量值
	 * @staticvar int $ACTIVE = 1 
	 * @staticvar int $LOCKED = 0
	 */
	static $ACTIVE = 1;
	static $LOCKED = 0;

	/**
	 * 保存登录状态使用什么,可选项session|cookie
	 * @var string $KEEP_STATUS
	 */
	protected $KEEP_STATUS='session';
	
	/**
	 * 帐号在系统中的名称,如数据库中的表名,文件系统中的文件名
	 * @var string $ACCOUNT_ALISANAME
	 */
	protected $ACCOUNT_ALISANAME='account';

	/**
	 * 角色在系统中的名称,如数据库中的表名,文件系统中的文件名
	 * @var string $ROLE_ALISANAME
	 */
	protected $ROLE_ALISANAME='role';

	/**
	 * 角色组在系统中的名称,如数据库中的表名,文件系统中的文件名
	 * @var string $ROLEGROUP_ALISANAME
	 */
	protected $ROLEGROUP_ALISANAME='role_group';

	/**
	 * 权限在系统中的名称,如数据库中的表名,文件系统中的文件名
	 * @var string $ACCESS_ALISANAME
	 */
	protected $ACCESS_ALISANAME='access';

	/**
	 * 权限组在系统中的名称,如数据库中的表名,文件系统中的文件名
	 * @var string $ACCESSGROUP_ALISANAME
	 */
	protected $ACCESSGROUP_ALISANAME='access_group';

	/**
	 * 帐号拥有角色表名
	 * @var string $ACCOUNT2ROLE_ALISANAME
	 */
	protected $ACCOUNTROLE_ALISANAME='account_role';

	/**
	 * 帐号拥有权限表名
	 * @var string $ACCOUNT2ACCESS_ALISANAME
	 */
	protected $ACCOUNTACCESS_ALISANAME='account_access';

	/**
	 * 角色拥有权限的表
	 * @var string $ROLEACCESS_ALISANAME
	 */
	protected $ROLEACCESS_ALISANAME='role_access';


	/**
	 * 帐号表会有多少字段
	 * @var array $ACCOUNT_FIELDS
	 */
	protected $ACCOUNT_FIELDS=array('id','username','password','status');

	/**
	 * 帐号验证登录时需要的验证的字段,必须在ACCOUNT_FIELDS里存在的字段
	 * @var array $AUTH_FIELDS
	 */
	protected $AUTH_FIELDS=array('username','password');

	/**
	 * 帐号唯一标识字段,必须在ACCOUNT_FIELDS里存在的字段,
	 * @var string $ACCOUNT_IDENTIFY_FIELD
	 */
	protected $ACCOUNT_IDENTIFY_FIELD='id';

	/**
	 * 帐号状态字段,必须在ACCOUNT_FIELDS里存在的字段
	 * @var string $ACCOUNT_STATUS_FIELD
	 */
	protected $ACCOUNT_STATUS_FIELD='status';

	/**
	 * 帐号当前登录验证环
	 * @var string $AUTH_TOKEN
	 */
	protected $AUTH_TOKEN='';

	/**
	 * 当前已验证的用户的唯一标识
	 * @var string $AUTH_ACCOUNT
	 */
	protected $AUTH_ACCOUNT='';
	
	/**
	 * 当前已验证的用户的具体信息
	 * @var array $AUTH_ACCOUNT_INFO
	 */
	protected $AUTH_ACCOUNT_INFO=array();
	

	/**
	 * 角色表里的字段清单
	 * @var array $ROLE_FIELDS
	 */
	protected $ROLE_FIELDS=array('id','rolename','role_group','status');

	/**
	 * 角色唯一标识字段,必须在ROLE_FIELDS里存在的字段,
	 * @var string $ROLE_IDENTIFY_FIELD
	 */
	protected $ROLE_IDENTIFY_FIELD='id';

	/**
	 * 角色名称字段,必须在ROLE_FIELDS里存在的字段
	 * @var string $ROLENAME_FIELD
	 */
	protected $ROLENAME_FIELD='rolename';

	/**
	 * 角色所归属组的标识字段,必须在ROLE_FIELDS里存在的字段
	 * @var string $ROLE2GROUP_FIELD
	 */
	protected $ROLE2GROUP_FIELD='role_group';

	/**
	 * 角色状态字段,必须在ROLE_FIELDS里存在的字段
	 * @var string $ROLE_STATUS_FIELD
	 */
	protected $ROLE_STATUS_FIELD='status';

	/**
	 * 当前已验证的用户所归属的角色清单,
	 * @var array $AUTH_ACCOUNT_ROLE
	 */
	protected $AUTH_ACCOUNT_ROLE=array();

	/**
	 * 角色组表里的字段清单
	 * @var array $ROLEGROUP_FIELDS
	 */
	protected $ROLEGROUP_FIELDS=array('id','groupname','parent_id','status');

	/**
	 * 角色组名称字段,必须在ROLEGROUP_FIELDS里存在的字段
	 * @var string $ROLEGROUPNAME_FIELD
	 */
	protected $ROLEGROUPNAME_FIELD='groupname';

	/**
	 * 角色组上级标识字段,必须在ROLEGROUP_FIELDS里存在的字段
	 * @var string $ROLEGROUP_PARENT_FIELD
	 */
	protected $ROLEGROUP_PARENT_FIELD='parent_id';

	/**
	 * 角色组状态字段,必须在ROLEGROUP_FIELDS里存在的字段
	 * @var string $ROLEGROUP_STATUS_FIELD
	 */
	protected $ROLEGROUP_STATUS_FIELD='status';

	/**
	 * 角色组唯一标识字段,必须在ROLEGROUP_FIELDS里存在的字段,
	 * @var string $ROLEGROUP_IDENTIFY_FIELD
	 */
	protected $ROLEGROUP_IDENTIFY_FIELD='id';

	/**
	 * 当前已验证的用户所归属的角色清单,
	 * @var array $AUTH_ACCOUNT_ROLEGROUP
	 */
	protected $AUTH_ACCOUNT_ROLEGROUP=array();

	/**
	 * 权限表里的字段清单
	 * @var array $ACCESS_FIELDS
	 */
	protected $ACCESS_FIELDS=array('id','accessname','accesscode','access_group','status');

	/**
	 * 权限名称字段,必须在ACCESS_FIELDS里存在的字段
	 * @var string $ACCESSNAME_FIELD
	 */
	protected $ACCESSNAME_FIELD='accessname';


	/**
	 * 权限码字段,必须在ACCESS_FIELDS里存在的字段,用于判断权限
	 * @var string $ACCESSCODE_FIELD
	 */
	protected $ACCESSCODE_FIELD='accesscode';

	/**
	 * 权限所归属组的标识字段,必须在ACCESS_FIELDS里存在的字段
	 * @var string $ACCESS2GROUP_FIELD
	 */
	protected $ACCESS2GROUP_FIELD='access_group';

	/**
	 * 权限状态字段,必须在ACCESS_FIELDS里存在的字段
	 * @var string $ACCESS_STATUS_FIELD
	 */
	protected $ACCESS_STATUS_FIELD='status';


	/**
	 * 权限唯一标识字段,必须在ACCESSGROUP_FIELDS里存在的字段
	 * @var string $ACCESSGROUP_IDENTIFY_FIELD
	 */	
	protected $ACCESS_IDENTIFY_FIELD='id';

	/**
	 * 当前已验证的用户所拥有的权限清单,
	 * @var array $AUTH_ACCOUNT_ACCESS
	 */
	protected $AUTH_ACCOUNT_ACCESS=array();

	/**
	 * 权限组表里的字段清单
	 * @var array $ACCESSGROUP_FIELDS
	 */
	protected $ACCESSGROUP_FIELDS=array('id','groupname','parent_id','status');

	/**
	 * 权限组名称字段,必须在ACCESSGROUP_FIELDS里存在的字段
	 * @var string $ACCESSGROUPNAME_FIELD
	 */
	protected $ACCESSGROUPNAME_FIELD='groupname';

	/**
	 * 权限组上级标识字段,必须在ACCESSGROUP_FIELDS里存在的字段
	 * @var string $ACCESSGROUP_PARENT_FIELD
	 */
	protected $ACCESSGROUP_PARENT_FIELD='parent_id';

	/**
	 * 权限组状态字段,必须在ACCESSGROUP_FIELDS里存在的字段
	 * @var string $ACCESSGROUP_STATUS_FIELD
	 */
	protected $ACCESSGROUP_STATUS_FIELD='status';
	
	/**
	 * 权限组唯一标识字段,必须在ACCESSGROUP_FIELDS里存在的字段
	 * @var string $ACCESSGROUP_IDENTIFY_FIELD
	 */	
	protected $ACCESSGROUP_IDENTIFY_FIELD='id';






	/**
	 * 帐号所属角色的表字段清单
	 * @var array $ACCOUNTROLE_FIELDS
	 */
	protected $ACCOUNTROLE_FIELDS=array('account_id','role_id');

	/**
	 * 代表帐号唯一标识的字段名称
	 * @var string $ACCESSGROUPNAME_FIELD
	 */
	protected $ACCOUNTROLE_ACCOUNTID_FIELD='account_id';

	/**
	 * 代表角色ID唯一标识的字段
	 * @var string $ACCOUNTROLE_ROLEID_FIELD
	 */
	protected $ACCOUNTROLE_ROLEID_FIELD='role_id';

	/**
	 * 帐号所拥有权限表里的字段清单
	 * @var array $ACCOUNTACCESS_FIELDS
	 */
	protected $ACCOUNTACCESS_FIELDS=array('account_id','access_id');

	/**
	 * 帐号所拥有权限表里,代表帐号唯一标识的字段名称
	 * @var string $ACCOUNTACCESS_ACCOUNTID_FIELD
	 */
	protected $ACCOUNTACCESS_ACCOUNTID_FIELD='account_id';

	/**
	 * 帐号所拥有权限表里,代表角色ID唯一标识的字段
	 * @var string $ACCOUNTACCESS_ROLEID_FIELD
	 */
	protected $ACCOUNTACCESS_ACCESSID_FIELD='access_id';


	/**
	 * 角色所拥有权限表的字段清单
	 * @var array $ROLEACCESS_FIELDS
	 */
	protected $ROLEACCESS_FIELDS=array('role_id','access_id');

	/**
	 * 角色所拥有权限表中,代表角色唯一标识的字段名
	 * @var string $ROLEACCESS_ROLEID_FIELD='role_id'
	 */
	protected $ROLEACCESS_ROLEID_FIELD='role_id';

	/**
	 * 角色所拥有权限表中,代表权限唯一标识的字段名
	 * @var string $ROLEACCESS_ACCESSID_FIELD 
	 */
	protected $ROLEACCESS_ACCESSID_FIELD='access_id';





	/**
	 * Auth 
	 * 验证用户是否已经验证过
	 *
	 * @param mixed [...] 填入所有验证字段的值,如果是想取得之前已经验证过的用户,直接不传参数
	 * return string 返回已经验证的用户的AUTH_TOKEN
	 */
	public function Auth()
	{
		$args=func_get_args();
		if(!$args || count($args)!=count($this->AUTH_FIELDS))
		{
			return $this->GetAuthStatu();
		}
		$auth_param=array();
		$auth_param[]='ACCOUNT';
		$auth_cond=array();
		$auth_cond[$this->ACCOUNT_STATUS_FIELD]=self::$ACTIVE;

		foreach($this->AUTH_FIELDS as $key=>$field)
		{
			$auth_cond[$field]=$args[$key];
		}
		$auth_param[]=$auth_cond;
		$auth_param[]=0;
		$auth_param[]=1;
		$Result = call_user_func_array(array($this,'C_GET'),$auth_param);

		if($Result)
		{
			$this->AUTH_ACCOUNT_INFO=$Result[0];
			$this->AUTH_ACCOUNT=$this->AUTH_ACCOUNT_INFO[trim($this->ACCOUNT_IDENTIFY_FIELD)];
			$this->AUTH_TOKEN=md5($this->ACCOUNT_IDENTIFY_FIELD."|".$this->AUTH_ACCOUNT_INFO[$this->ACCOUNT_IDENTIFY_FIELD].":".implode(":",$this->AUTH_ACCOUNT_INFO));
			$this->FlushAuthState();
			$this->setSignature();
			return $this->GetAuthStatu();
		}
		else
		{
			return FALSE;
		}
	}
	
	
	/**
	 * GetAuthStatu 
	 * 读取用户登录状态,
	 *
	 * return bool
	 */

	public function GetAuthStatu()
	{
		
		if(!empty($this->AUTH_ACCOUNT_INFO) && !empty($this->AUTH_TOKEN) )
		{
			return TRUE;
		}
		else
		{
			$signature=explode(':',$this->getSignature());
			if(empty($signature) || count($signature)!=2 || empty($signature[0]) || empty($signature[1]) )
			{
				return FALSE;
			}
			$cond_param=array();
			$cond_param[]='ACCOUNT';
			$auth_cond=array();
			$auth_cond[$this->ACCOUNT_IDENTIFY_FIELD] = $signature[0];
			$auth_cond[$this->ACCOUNT_STATUS_FIELD] = self::$ACTIVE;
			$cond_param[]=$auth_cond;
			$cond_param[]=0;
			$cond_param[]=1;
			$info = call_user_func_array(array($this,'C_GET'),$cond_param);
			if(empty($info))
			{
				return FALSE;
			}
			else
			{
				$info=$info[0];
				$token=md5($this->ACCOUNT_IDENTIFY_FIELD."|".$info[$this->ACCOUNT_IDENTIFY_FIELD].":".implode(':',$info));
				if($token == $signature[1])
				{
					$this->AUTH_TOKEN=$token;
					$this->AUTH_ACCOUNT=$info[$this->ACCOUNT_IDENTIFY_FIELD];
					$this->AUTH_ACCOUNT_INFO=$info;
					$this->FlushAuthState();
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}

	}


	/**
	 * FlushAuthState 
	 * 根据验证TOKEN进行更新验证状态,
	 *
	 */
	public function FlushAuthState()
	{
		if( in_array(strtoupper($this->KEEP_STATUS),array('SESSION','COOKIE')) )
		{
			if(strtoupper($this->KEEP_STATUS) == 'SESSION' )
			{
				if(!session_id()) session_start();
				$_SESSION['ARC_'.$this->ACCOUNT_ALISANAME]=$this->AUTH_ACCOUNT;
			}
			else
			{
				setCookie('ARC_'.$this->ACCOUNT_ALISANAME,$this->AUTH_ACCOUNT);
			}
		}
	}

	/**
	 * getSignature 
	 * 读取签名信息,签名信息保存在客户端,读取得到证明是已经通过验证
	 *
	 */
	protected function getSignature()
	{
		return !empty($_COOKIE['ARC_AUTH'])?$_COOKIE['ARC_AUTH']:NULL;
	}


	/**
	 * setSignature 
	 * 设置签名信息,签名信息保存在客户端,
	 *
	 */
	public function setSignature($ex_time=1800)
	{
		(!$ex_time || !intval($ex_time)) && $ex_time=1800;
		$this->AUTH_ACCOUNT && $this->AUTH_TOKEN && setCookie('ARC_AUTH',$this->AUTH_ACCOUNT.":".$this->AUTH_TOKEN,time()+$ex_time);
	}

	/**
	 * C_GET 
	 * 定义用户自已编写的读取方法
	 *
	 * @param string $TYPE 要读取的类型,ACCOUNT|ROLE|ROLE_GROUP|ACCESS|ACCESS_GROUP
	 * @var string [...] 后续参数格式为field|value,可以无限个,注意,这里的关系是同时成立的条件,而不是多选条件
	 * return mixed 
	 */
	public function C_GET($TYPE,$cond,$offset=0,$count=0)
	{
		/*
		//这里模拟用户自行编写一个读写类
		$TYPE=strtoupper($TYPE);
		if(!in_array($TYPE,array('ACCOUNT','ROLE','ROLEGROUP','ACCESS','ACCESSGROUP','ACCOUNTROLE','ACCOUNTACCESS','ROLEACCESS')))
		{
			return NULL;
		}
		$alisaname=$TYPE."_ALISANAME";

		$db=TSQL::initDB('write');
		$db->reset()->table($this->$alisaname);
		if($cond)
		{
			$where=array();
			foreach($cond as $fieldname=>$fieldvalue)
			{
				$where[]=is_null($fieldvalue)?($fieldname.' IS NULL'):($fieldname."='".$fieldvalue."'");
			}
			$db->Where(implode(' AND ',$where));
		}
		if(intval($count))
		{
			$db->Limit(intval($offset),intval($count));
		}
		return $db->fetchAll();
		*/
	}


	/**
	 * C_SAVE 
	 * 定义用户自已编写的保存方法
	 *
	 * @param string $TYPE 要保存的类型,ACCOUNT|ROLE|ROLE_GROUP|ACCESS|ACCESS_GROUP
	 * @var string [...] 后续参数格式为field|value,可以无限个,注意,这里的关系是同时成立的条件,而不是多选条件
	 * return mixed 
	 */
	public function C_SAVE($TYPE,$fieldvalue)
	{
		/*
		//这里模拟用户自行编写一个读写类
		$TYPE=strtoupper($TYPE);
		if(empty($fieldvalue)){
			return FALSE;
		}
		if(!in_array($TYPE,array('ACCOUNT','ROLE','ROLEGROUP','ACCESS','ACCESSGROUP','ACCOUNTROLE','ACCOUNTACCESS','ROLEACCESS')))
		{
			return FALSE;
		}
		$alisaname=$TYPE."_ALISANAME";

		$db=TSQL::initDB('write');
		$db->reset()->table($this->$alisaname);
		$record=array();

		foreach($fieldvalue as $fieldname=>$fieldvalue)
		{
				$record[]=$fieldvalue;
				$db->Fields($fieldname);
		}
		$result=$db->Record($record)->save();
		return $result['status'];
		*/
	}



	/**
	 * C_REMOVE 
	 * 自定义删除方法
	 *
	 * @param string $TYPE 要删除的类型,ACCOUNT|ROLE|ROLE_GROUP|ACCESS|ACCESS_GROUP
	 * @var string [...] 后续参数格式为field|value,可以无限个,注意,这里的关系是同时成立的条件,而不是多选条件
	 * return mixed 
	 */
	public function C_REMOVE($TYPE,$cond)
	{
		/*
		//这里模拟用户自行编写一个删除方法

		$TYPE=strtoupper($TYPE);
		if(!in_array($TYPE,array('ACCOUNT','ROLE','ROLEGROUP','ACCESS','ACCESSGROUP','ACCOUNTROLE','ACCOUNTACCESS','ROLEACCESS')))
		{
			return NULL;
		}
		$alisaname=$TYPE."_ALISANAME";

		$db=TSQL::initDB('write');
		$db->reset()->table($this->$alisaname);
		if(!empty($cond))
		{
			$where=array();
			foreach($cond as $key=>$v)
			{
				$where[]=is_null($v)?($key." is NULL"):($key."='".$v."'");
			}
			$db->Where(implode(' AND ',$where));
		}
		$result=$db->Delete();
		return $result['status'];
		*/
	}

	
	/**
	 * C_UPDATE 
	 * 自定义更新方法
	 *
	 * @param string $TYPE 要删除的类型,ACCOUNT|ROLE|ROLE_GROUP|ACCESS|ACCESS_GROUP
	 * @param array $newValue 要更新的字段和值
	 * @param array $cond 要更新的条件
	 * return mixed 
	 */
	public function C_UPDATE($TYPE,$newValue,$cond)
	{
		/*
		//这里模拟用户自行编写一个更新方法
		$TYPE=strtoupper($TYPE);
		if(!in_array($TYPE,array('ACCOUNT','ROLE','ROLEGROUP','ACCESS','ACCESSGROUP','ACCOUNTROLE','ACCOUNTACCESS','ROLEACCESS')))
		{
			return NULL;
		}
		$alisaname=$TYPE."_ALISANAME";

		$db=TSQL::initDB('write');
		$db->reset()->table($this->$alisaname);
		$values=array();
		foreach($newValue as $field=>$value)
		{
			$values[]=$value;
			$db->Fields($field);
		}
		$db->Record($values);
		if(!empty($cond))
		{
			$where=array();
			foreach($cond as $key=>$value)
			{
				$where[]=$key."='".$value."'";
			}
			$db->Where(implode(' and ',$where));
		}

		$result=$db->Update();
		return $result['status'];
		*/
	}

	/**
	 * addAccount 
	 * 添加帐号
	 *
	 * @param array $Fields 要添加的帐号字段列表
	 * @var array $Value 对应要添加的字段的值
	 * return bool
	 */
	public function addAccount($Fields,$Value)
	{
		foreach($this->AUTH_FIELDS as $f)
		{
			if(!in_array($f,$Fields) || empty($Value[array_search($f,$Fields)]) )
			{
				return false;
			}
		}
		foreach($Fields as $f)
		{
			if(!in_array($f,$this->ACCOUNT_FIELDS))
			{
				return false;
			}
		}

		$params=array();
		$params[]='ACCOUNT';
		$fieldvalue=array();
		foreach($Fields as $inx=>$key)
		{
			$fieldvalue[$key]=$Value[$inx];
		}
		$params[]=$fieldvalue;
		return call_user_func_array(array($this,'C_SAVE'),$params);
	}


	/**
	 * delAccount 
	 * 依据帐号唯一标识删除帐号
	 *
	 * @param array $cond 要删除的帐号的条件
	 * return bool
	 */
	public function delAccount($AccountID)
	{

		$params=array();
		$params[]='ACCOUNT';
		$conds=array();
		$conds[$this->ACCOUNT_IDENTIFY_FIELD]=$AccountID;
		$params[]=$conds;
		//删除该帐号所拥有的角色列表
		$recordlist=$this->getAccountRole($AccountID);
		if($recordlist)
		{
			foreach($recordlist as $record)
			{
				$this->setAccountRole($AccountID,$record[ACCOUNTROLE_ROLEID_FIELD],TRUE,'REMOVE');
			}
		}
		//删除该帐号所拥有的权限列表
		$recordlist=$this->getAccountAccess($AccountID);
		if($recordlist)
		{
			foreach($recordlist as $record)
			{
				$this->setAccountAccess($AccountID,$record[ACCOUNTACCESS_ACCESSID_FIELD],'REMOVE');
			}
		}
		return call_user_func_array(array($this,'C_REMOVE'),$params);
	}


	/**
	 * updateAccount 
	 * 依据帐号的唯一标识,进行更新帐号
	 *
	 * @param array $newValue 更新的键和值
	 * @param array $cond 更新的条件
	 * return bool
	 */
	public function updateAccount($newValue,$AccountID)
	{
		if(empty($newValue))
		{
			return FALSE;
		}
		$cond[$this->ACCOUNT_IDENTIFY_FIELD]=$AccountID;
		return $this->C_UPDATE("ACCOUNT",$newValue,$cond);
	}

	/**
	 * getAccount 
	 * 获取帐号列表
	 *
	 * @param array $cond 要获取的条件
	 * @param int $offset=0 从第几个开始取,起始为0
	 * @param int $count =0 要取多少条,0全取
	 * return bool
	 */
	public function getAccount($cond=array(),$offset=0,$count=0)
	{
		$result=$this->C_GET("ACCOUNT",$cond,$offset,$count);
		return $result;
	}


	/**
	 * addRole 
	 * 添加角色 
	 *
	 * @param string $RoleName 角色名称
	 * @param int $groupid = 0 角色所属组ID
	 * @param int $status = ARC::$ACTIVE 角色是否开放
	 * return bool
	 */	
	public function addRole($RoleName,$groupid = 0,$status = NULL)
	{
		if(empty($RoleName))
		{
			return FALSE;
		}
		if($groupid){
			$cond_check[$this->ROLEGROUP_IDENTIFY_FIELD]=$groupid;
			$grouplist=$this->getRoleGroup($cond_check,0,1);
			if(!$grouplist)
			{
				return FALSE;
			}
		}

		$cond=array();
		$cond[$this->ROLENAME_FIELD]=$RoleName;
		$cond[$this->ROLE2GROUP_FIELD]=$groupid;
		$cond[$this->ROLE_STATUS_FIELD]=in_array($status,array(self::$ACTIVE,self::$LOCKED),TRUE)?($status):(self::$LOCKED);
		return $this->C_SAVE("ROLE",$cond);
	}

	/**
	 * delRole 
	 * 按角色唯一标识删除角色,
	 *
	 * @param array $roleid 要删除的角色唯一标识
	 * return bool
	 */
	public function delRole($roleid)
	{

		$params=array();
		$params[]='ROLE';
		$conds=array($this->ROLE_IDENTIFY_FIELD=>$roleid);
		$params[]=$conds;
		//删除该角色下所有帐号的关联
		$recordlist=$this->getAccountRole(NULL,$roleid);
		if($recordlist)
		{
			foreach($recordlist as $record)
			{
				$this->setAccountRole($record[$this->ACCOUNTROLE_ACCOUNTID_FIELD],$roleid,TRUE,'REMOVE');
			}
		}
		//删除该角色下所有权限的关联
		$recordlist=$this->getRoleAccess($roleid);
		if($recordlist)
		{
			foreach($recordlist as $record)
			{
				$this->setRoleAccess($roleid,$record[$this->ROLEACCESS_ACCESSID_FIELD],'REMOVE');
			}
		}
		return call_user_func_array(array($this,'C_REMOVE'),$params);
	}
	
	


	/**
	 * updateRole 
	 * 更新角色信息
	 *
	 * @param string $RoleId 要更新的角色ID
	 * @param string $RoleName 要更新的角色名称
	 * @param int $groupid 角色的新所属组唯一标识,
	 * @param mixed $status 角色的新状态
	 * return bool
	 */
	public function updateRole($RoleId,$RoleName='',$groupid = -1,$status = NULL)
	{
		$newValue=array();
		if(!empty($RoleName))
		{
			$newValue[$this->ROLENAME_FIELD]=$RoleName;
		}

		if($groupid != -1)
		{
			if(!empty($groupid))
			{
				$cond_check[$this->ROLEGROUP_IDENTIFY_FIELD]=$groupid;
				$grouplist=$this->getRoleGroup($cond_check,0,1);
				if(!$grouplist)
				{
					return FALSE;
				}
				$newValue[$this->ROLE2GROUP_FIELD]=$groupid;
			}
			else
			{
				$newValue[$this->ROLE2GROUP_FIELD]=0;
			}
		}
		if ( in_array($status,array(self::$ACTIVE,self::$LOCKED),TRUE))
		{
			$newValue[$this->ROLE_STATUS_FIELD]=$status;
		}

		if(empty($newValue))
		{
			return FALSE;
		}
		$cond[$this->ROLE_IDENTIFY_FIELD]=$RoleId;
		return $this->C_UPDATE("ROLE",$newValue,$cond);
	}

	/**
	 * getRole 
	 * 获取帐号列表
	 *
	 * @param array $cond 要获取的条件
	 * @param int $offset=0 从第几个开始取,起始为0
	 * @param int $count =0 要取多少条,0全取
	 * return bool
	 */
	public function getRole($cond=array(),$offset=0,$count=0)
	{
		$result=$this->C_GET("ROLE",$cond,$offset,$count);
		return $result;
	}


	/**
	 * addRoleGroup 
	 * 添加角色组
	 *
	 * @param string $RoleGroupName 角色名称
	 * @param int $groupid = 0 角色所属组ID
	 * @param int $status = ARC::$ACTIVE 角色是否开放
	 * return bool
	 */	
	public function addRoleGroup($RoleGroupName,$parentid = 0 , $status = NULL)
	{
		if(empty($RoleGroupName))
		{
			return NULL;
		}
		$cond=array();
		if($parentid)
		{
			$cond_check[$this->ROLEGROUP_IDENTIFY_FIELD]=$parentid;
			$grouplist=$this->getRoleGroup($cond_check,0,1);
			if($grouplist)
			{
				$cond[$this->ROLEGROUP_PARENT_FIELD]=$grouplist[0][$this->ROLEGROUP_PARENT_FIELD].$parentid."|";
			}
			else
			{
				return false;
			}
		}
		$cond[$this->ROLEGROUPNAME_FIELD]=$RoleGroupName;
		$cond[$this->ROLEGROUP_STATUS_FIELD]=in_array($status,array(self::$ACTIVE,self::$LOCKED),TRUE)?($status):(self::$LOCKED);
		return $this->C_SAVE("ROLEGROUP",$cond);
	}



	/**
	 * delRoleGroup 
	 * 按角色组唯一标识删除角色,
	 *
	 * @param array $roleid 要删除的角色唯一标识
	 * return bool
	 */
	public function delRoleGroup($rolegroupid)
	{

		$params=array();
		$params[]='ROLEGROUP';
		$conds[$this->ROLEGROUP_IDENTIFY_FIELD]=$rolegroupid;
		$params[]=$conds;
		//释放下层组
		$recordlist=$this->getRoleGroup($conds);
		if($recordlist)
		{
			$role_parent=trim($recordlist[0][$this->ROLEGROUP_PARENT_FIELD]).$rolegroupid."|";
			$search_cond=array($this->ROLEGROUP_PARENT_FIELD=>$role_parent);
			$recordlist=$this->getRoleGroup($search_cond);
			if($recordlist)
			{
				foreach($recordlist as $record)
				{
					$this->updateRoleGroup($record[$this->ROLEGROUP_IDENTIFY_FIELD],NULL,0);
				}
			}
			
		}
		//取消所有该组内的角色,将该组内的角色变成无组状态
		$search_cond=array($this->ROLE2GROUP_FIELD=>$rolegroupid);
		$recordlist=$this->getRole($search_cond);
		if($recordlist)
		{
			foreach($recordlist as $record)
			{
				$this->updateRole($record[$this->ROLE_IDENTIFY_FIELD],NULL,0);
			}
		}
		
		
		return call_user_func_array(array($this,'C_REMOVE'),$params);
	}

	/**
	 * updateRoleGroup 
	 * 更新角色组信息
	 *
	 * @param int $RoleGroupId 要更新的角色组唯一标识
	 * @param string $RoleGroupName 新角色组名称
	 * @param int $parent_id 新的上级组ID
	 * @param bool $status 角色组新状态
	 * return bool
	 */
	public function updateRoleGroup($RoleGroupId,$RoleGroupName = '',$parent_id = -1,$status=NULL)
	{
		$newValue=array();
		if($RoleGroupName)
		{
			$newValue[$this->ROLEGROUPNAME_FIELD]=$RoleGroupName;
		}

		$my_child_group=array();

		$cond[$this->ROLEGROUP_IDENTIFY_FIELD]=$RoleGroupId;
		$thisgroup=$this->getRoleGroup($cond);
		//要修改的角色组不存在
		if(!$thisgroup)
		{
			return FALSE;
		}

		if($parent_id!=-1)
		{
			if($parent_id==0)
			{
				$newValue[$this->ROLEGROUP_PARENT_FIELD]='';
			}
			else
			{
				$cond_check[$this->ROLEGROUP_IDENTIFY_FIELD]=$parent_id;
				$list=$this->getRoleGroup($cond_check,0,1);
				if(!$list)
				{
					return FALSE;
				}
				else
				{
					$newValue[$this->ROLEGROUP_PARENT_FIELD]=$list[0][$this->ROLEGROUP_PARENT_FIELD].$parent_id."|";
				}
			}
			$old_parent=array($this->ROLEGROUP_PARENT_FIELD=>trim($thisgroup[0][$this->ROLEGROUP_PARENT_FIELD]).$RoleGroupId."|");
			$my_child_group=$this->getRoleGroup($old_parent);

		}
		if(in_array($status,array(self::$ACTIVE,self::$LOCKED),TRUE))
		{
			$newValue[$this->ROLEGROUP_STATUS_FIELD]=$status;
		}
		if(empty($newValue))
		{
			return FALSE;
		}
		
		$status=$this->C_UPDATE("ROLEGROUP",$newValue,$cond);
		if($my_child_group)
		{
			foreach($my_child_group as $group)
			{
				$this->updateRoleGroup($group[$this->ROLEGROUP_IDENTIFY_FIELD],NULL,$RoleGroupId);
			}
		}
		return $status;
	}

	/**
	 * getRoleGroup 
	 * 获取帐号列表
	 *
	 * @param array $cond 要获取的条件
	 * @param int $offset=0 从第几个开始取,起始为0
	 * @param int $count =0 要取多少条,0全取
	 * return bool
	 */
	public function getRoleGroup($cond=array(),$offset=0,$count=0)
	{
		$result=$this->C_GET("ROLEGROUP",$cond,$offset,$count);
		return $result;
	}

	/**
	 * addAccess 
	 * 添加权限
	 *
	 * @param string $AccessName 权限名称
	 * @param string $AccessCode 权限码
	 * @param int $groupid = 0 权限所属组ID
	 * @param int $status = ARC::$ACTIVE 权限是否开放
	 * return bool
	 */	
	public function addAccess($AccessName,$AccessCode,$groupid = 0,$status = NULL)
	{
		if(empty($AccessName) || empty($AccessCode) )
		{
			return FALSE;
		}
		if($groupid)
		{
			$cond_check[$this->ACCESSGROUP_IDENTIFY_FIELD]=$groupid;
			$grouplist=$this->getAccessGroup($cond_check,0,1);
			if(!$grouplist)
			{
				return FALSE;
			}
		}
		$cond_check=array($this->ACCESSCODE_FIELD=>$AccessCode);
		$grouplist=$this->getAccess($cond_check,0,1);
		if($grouplist)
		{
			return FALSE;		//权限代码的检验,代码是判断权限的依据,不能重复
		}

		$cond=array();
		$cond[$this->ACCESSNAME_FIELD]=$AccessName;
		$cond[$this->ACCESSCODE_FIELD]=$AccessCode;
		$cond[$this->ACCESS2GROUP_FIELD]=$groupid;
		$cond[$this->ACCESS_STATUS_FIELD]=in_array($status,array(self::$ACTIVE,self::$LOCKED),TRUE)?($status):(self::$LOCKED);
		return $this->C_SAVE("ACCESS",$cond);
	}

	/**
	 * delAccess 
	 * 按权限唯一标识删除权限,
	 *
	 * @param array $roleid 要删除的权限唯一标识
	 * return bool
	 */
	public function delAccess($Accessid)
	{

		$params=array();
		$params[]='ACCESS';
		$conds[$this->ACCESS_IDENTIFY_FIELD]=$Accessid;
		$params[]=$conds;
		//删除所有已关联了该权限的用户的关联关系
		$recordlist=$this->getAccountAccess(NULL,$Accessid);
		if($recordlist)
		{
			foreach($recordlist as $record)
			{
				$this->setAccountAccess($record[$this->ACCOUNTACCESS_ACCOUNTID_FIELD],$Accessid,'REMOVE');
			}
		}
		//删除所有已关联该权限的角色的关联关系
		$recordlist=$this->getRoleAccess(NULL,$Accessid);
		if($recordlist)
		{
			foreach($recordlist as $record)
			{
				$this->setRoleAccess($record[$this->ROLEACCESS_ROLEID_FIELD],$Accessid,'REMOVE');
			}
		}
		return call_user_func_array(array($this,'C_REMOVE'),$params);
	}

	/**
	 * updateAccess 
	 * 更新权限信息
	 *
	 * @param string $AccessId 要修改的权限的唯一村识
	 * @param string $AccessName 权限新名称
 	 * @param string $AccessCode 权限新代码
	 * @param string $groupid 权限新归属组
	 * @param string $status 权限是否开放
	 * return bool
	 */
	public function updateAccess($AccessId,$AccessName ='',$AccessCode ='',$groupid = -1,$status = NULL)
	{
		$newValue=array();
		if(!empty($AccessName) )
		{
			$newValue[$this->ACCESSNAME_FIELD]=$AccessName;
		}
		if(!empty($AccessCode) )
		{
			$cond_check=array($this->ACCESSCODE_FIELD=>$AccessCode);
			$Accesslist=$this->getAccess($cond_check);
			if($Accesslist)
			{
				//判断该权限代码是否已重复,
				foreach($Accesslist as $accessinfo)
				{
					if($accessinfo[$this->ACCESS_IDENTIFY_FIELD]!=$AccessId)
					{
						return FALSE;
					}
				}
			}
			$newValue[$this->ACCESSCODE_FIELD]=$AccessCode;
		}
		if($groupid!=-1 )
		{
			if($groupid)
			{
				$cond_check[$this->ACCESSGROUP_IDENTIFY_FIELD]=$groupid;
				$grouplist=$this->getAccessGroup($cond_check,0,1);
				if(!$grouplist)
				{
					return FALSE;
				}
				$newValue[$this->ACCESS2GROUP_FIELD]=$groupid;
			}
			else
			{
				$newValue[$this->ACCESS2GROUP_FIELD]=0;
			}
		}

		if( in_array($status,array(self::$ACTIVE,self::$LOCKED),true) )
		{
			$newValue[$this->ACCESS_STATUS_FIELD]=$status;
		}

		$cond[$this->ACCESS_IDENTIFY_FIELD]=$AccessId;
		return $this->C_UPDATE("ACCESS",$newValue,$cond);
	}


	/**
	 * getAccess 
	 * 获取权限列表
	 *
	 * @param array $cond 要获取的条件
	 * @param int $offset=0 从第几个开始取,起始为0
	 * @param int $count =0 要取多少条,0全取
	 * return bool
	 */
	public function getAccess($cond=array(),$offset=0,$count=0)
	{
		$result=$this->C_GET("ACCESS",$cond,$offset,$count);
		return $result;
	}


	/**
	 * addAccessGroup 
	 * 添加权限组
	 *
	 * @param string $AccessGroupName 角色名称
	 * @param int $groupid = 0 权限组所属上级ID
	 * @param int $status = ARC::$ACTIVE 权限组是否开放
	 * return bool
	 */
	public function addAccessGroup($AccessGroupName,$parentid = 0 , $status = NULL)
	{
		if(empty($AccessGroupName))
		{
			return NULL;
		}
		$cond=array();
		if($parentid)
		{
			$cond_check[$this->ACCESSGROUP_IDENTIFY_FIELD]=$parentid;
			$grouplist=$this->getAccessGroup($cond_check,0,1);
			if($grouplist)
			{
				$cond[$this->ACCESSGROUP_PARENT_FIELD]=$grouplist[0][$this->ACCESSGROUP_PARENT_FIELD].$parentid."|";
			}
			else
			{
				return false;
			}
		}
		$cond[$this->ACCESSGROUPNAME_FIELD]=$AccessGroupName;
		$cond[$this->ACCESSGROUP_STATUS_FIELD]=in_array($status,array(self::$ACTIVE,self::$LOCKED),TRUE)?($status):(self::$LOCKED);
		return $this->C_SAVE("ACCESSGROUP",$cond);
	}



	/**
	 * delAccessGroup 
	 * 按权限组唯一标识删除角色,
	 *
	 * @param array $accessid 要删除的权限组唯一标识
	 * return bool
	 */
	public function delAccessGroup($accessgroupid)
	{

		$params=array();
		$params[]='ACCESSGROUP';
		$conds[$this->ACCESSGROUP_IDENTIFY_FIELD]=$accessgroupid;
		$params[]=$conds;
		//释放下层组
		$recordlist=$this->getAccessGroup($conds);
		if($recordlist)
		{
			$access_parent=trim($recordlist[0][$this->ACCESSGROUP_PARENT_FIELD]).$accessgroupid."|";
			$search_cond=array($this->ACCESSGROUP_PARENT_FIELD=>$access_parent);
			$recordlist=$this->getAccessGroup($search_cond);
			if($recordlist)
			{
				foreach($recordlist as $record)
				{
					$this->updateAccessGroup($record[$this->ACCESSGROUP_IDENTIFY_FIELD],NULL,0);
				}
			}
			
		}
		//取消所有该组内的权限,将该组内的权限变成无组状态
		$search_cond=array($this->ACCESS2GROUP_FIELD=>$accessgroupid);
		$recordlist=$this->getAccess($search_cond);
		if($recordlist)
		{
			foreach($recordlist as $record)
			{
				$this->updateAccess($record[$this->ACCESS_IDENTIFY_FIELD],NULL,'',0);
			}
		}
		
		
		return call_user_func_array(array($this,'C_REMOVE'),$params);
	}

	/**
	 * updateAccessGroup 
	 * 更新角色组信息
	 *
	 * @param int $AccessGroupId 要更新的角色组唯一标识
	 * @param string $AccessGroupName 新角色组名称
	 * @param int $parent_id 新的上级组ID
	 * @param bool $status 角色组新状态
	 * return bool
	 */
	public function updateAccessGroup($AccessGroupId,$AccessGroupName = '',$parent_id = -1,$status=NULL)
	{
		$newValue=array();
		if($AccessGroupName)
		{
			$newValue[$this->ACCESSGROUPNAME_FIELD]=$AccessGroupName;
		}

		$my_child_group=array();

		$cond[$this->ACCESSGROUP_IDENTIFY_FIELD]=$AccessGroupId;
		$thisgroup=$this->getAccessGroup($cond);
		//要修改的角色组不存在
		if(!$thisgroup)
		{
			return FALSE;
		}

		if($parent_id!=-1)
		{
			if($parent_id==0)
			{
				$newValue[$this->ACCESSGROUP_PARENT_FIELD]='';
			}
			else
			{
				$cond_check[$this->ACCESSGROUP_IDENTIFY_FIELD]=$parent_id;
				$list=$this->getAccessGroup($cond_check,0,1);
				if(!$list)
				{
					return FALSE;
				}
				else
				{
					$newValue[$this->ACCESSGROUP_PARENT_FIELD]=$list[0][$this->ACCESSGROUP_PARENT_FIELD].$parent_id."|";
				}
			}
			$old_parent=array($this->ACCESSGROUP_PARENT_FIELD=>trim($thisgroup[0][$this->ACCESSGROUP_PARENT_FIELD]).$AccessGroupId."|");
			$my_child_group=$this->getAccessGroup($old_parent);

		}
		if(in_array($status,array(self::$ACTIVE,self::$LOCKED),TRUE))
		{
			$newValue[$this->ACCESSGROUP_STATUS_FIELD]=$status;
		}
		if(empty($newValue))
		{
			return FALSE;
		}
		
		$status=$this->C_UPDATE("ACCESSGROUP",$newValue,$cond);
		if($my_child_group)
		{
			foreach($my_child_group as $group)
			{
				$this->updateAccessGroup($group[$this->ACCESSGROUP_IDENTIFY_FIELD],NULL,$AccessGroupId);
			}
		}
		return $status;
	}

	/**
	 * getAccessGroup 
	 * 获取权限组列表
	 *
	 * @param array $cond 要获取的条件
	 * @param int $offset=0 从第几个开始取,起始为0
	 * @param int $count =0 要取多少条,0全取
	 * return bool
	 */
	public function getAccessGroup($cond=array(),$offset=0,$count=0)
	{
		$result=$this->C_GET("ACCESSGROUP",$cond,$offset,$count);
		return $result;
	}

	/**
	 * setAccountRole
	 * 给帐号赋予或删除角色
	 *
	 * @param string $AccountId 要赋予角色的帐号唯一标识
	 * @param string $RoleId 角色ID,
	 * @param BOOL $Access =TRUE  是否包括赋予和删除权限
	 * @param string $type='ADD|REMOVE' 添加或者删除,默认为添加 
	 * return bool
	 */
	public function setAccountRole($AccountId,$RoleId,$Access=TRUE,$type='ADD')
	{
		$cond[$this->ACCOUNT_IDENTIFY_FIELD]=$AccountId;
		$Account=$this->getAccount($cond,0,1);
		//帐号不存在
		if(empty($Account))
		{
			return FALSE;
		}
		$cond=array($this->ROLE_IDENTIFY_FIELD =>$RoleId);
		$Role=$this->getRole($cond,0,1);
		if(empty($Role))
		{
			//角色不存在
			return FALSE;
		}
		$record=array($this->ACCOUNTROLE_ACCOUNTID_FIELD=>$AccountId,$this->ACCOUNTROLE_ROLEID_FIELD=>$RoleId);
		switch(strtoupper($type))
		{
			case 'ADD':
				$ishas=$this->getAccountRole($AccountId,$RoleId);
				if(!$ishas)
				{
					$addresult=$this->C_SAVE("ACCOUNTROLE",$record);
					if(!$addresult){
						return FALSE;
					}
				}
				break;
			case 'REMOVE':
				$this->C_REMOVE("ACCOUNTROLE",$record);
				break;
			default:
				return FALSE;
				break;
		}

		if(!$Access)
		{
			$accesslist=$this->getRoleAccess($RoleId);
			if($accesslist)
			{
				foreach($accesslist as $access)
				{
					$this->setAccountAccess($AccountId,$access[$this->ROLEACCESS_ACCESSID_FIELD],$type);
				}
			}
			return true;
		}
		
	}

	/**
	 * getAccountRole
	 * 读取帐号所拥有的角色清单,如果指定角色ID,则只返回该角色的值
	 *
	 * @param string $AccountId 要赋予角色的帐号唯一标识
	 * @param string $RoleId 角色ID,不传递时,返回所有
	 * return mixed
	 */

	public function getAccountRole($AccountId = NULL ,$RoleId=NULL)
	{
		$cond=array();
		if(!empty($AccountId))
		{
			$cond[$this->ACCOUNTROLE_ACCOUNTID_FIELD]=$AccountId;
		}
		if(!empty($RoleId))
		{
			$cond[$this->ACCOUNTROLE_ROLEID_FIELD]=$RoleId;
		}
		if(empty($cond))
		{
			return NULL;
		}
		return $this->C_GET('ACCOUNTROLE',$cond);
	}
	

	/**
	 * getAccountAccess
	 * 读取帐号所拥有的权限清单,如果指定权限ID,则只返回该权限的值
	 *
	 * @param string $AccountId = NULL 要赋予角色的帐号唯一标识,不传帐号ID则通过权限ID反查拥有该权限的人员清单
	 * @param string $Access_id = NULL 权限ID,不传递时,返回所有
	 * return mixed
	 */
	public function getAccountAccess($AccountId = NULL,$Access_id = NULL)
	{
		$condcheck=array();
		if($AccountId)
		{
			$condcheck[$this->ACCOUNTACCESS_ACCOUNTID_FIELD]=$AccountId;
		}
		if(!empty($Access_id))
		{
			$condcheck[$this->ACCOUNTACCESS_ACCESSID_FIELD]=$Access_id;
		}
		if(empty($condcheck))
		{
			return NULL;
		}
		return $this->C_GET('ACCOUNTACCESS',$condcheck);

		
	}


	/**
	 * setAccountAccess
	 * 添加或删除用户的某项权限,
	 *
	 * @param string $AccountId 帐号唯一标识
	 * @param string $Access_id 权限ID
	 * @param string $type='ADD|REMOVE' 添加或删除,默认为添加,
	 * return mixed
	 */
	public function setAccountAccess($AccountId,$Access_id,$type='ADD')
	{
		$cond[$this->ACCOUNT_IDENTIFY_FIELD]=$AccountId;
		$Account=$this->getAccount($cond,0,1);
		//帐号不存在
		if(empty($Account))
		{
			return FALSE;
		}
		switch(strtoupper($type))
		{
			case 'ADD':
				$cond=array($this->ACCESS_IDENTIFY_FIELD =>$Access_id);
				$Access=$this->getAccess($cond,0,1);
				if(empty($Access))
				{
					//权限不存在
					return FALSE;
				}
				if(!$this->getAccountAccess($AccountId,$Access_id))
				{
					$newValue=array(
								$this->ACCOUNTACCESS_ACCOUNTID_FIELD=>$AccountId,
								$this->ACCOUNTACCESS_ACCESSID_FIELD=>$Access_id);
					return $this->C_SAVE("ACCOUNTACCESS",$newValue);
				}
				return TRUE;
				break;
			case 'REMOVE':
				$cond=array(
								$this->ACCOUNTACCESS_ACCOUNTID_FIELD=>$AccountId,
								$this->ACCOUNTACCESS_ACCESSID_FIELD=>$Access_id);
				return $this->C_REMOVE("ACCOUNTACCESS",$cond);
				
				break;
			default:
				return FALSE;
				break;
		}
	}


	/**
	 * getRoleAccess
	 * 读取帐号所拥有的权限清单,如果指定权限ID,则只返回该权限的值
	 *
	 * @param string $RoleId 要读取权限的角色唯一标识
	 * @param string $Access_id=NULL 权限ID,不传递时,返回所有
	 * return mixed
	 */

	public function getRoleAccess($RoleId = NULL,$AccessId=NULL)
	{
		$cond=array();
		if($RoleId)
		{
			$cond[$this->ROLEACCESS_ROLEID_FIELD]=$RoleId;
		}

		if($AccessId)
		{
			$cond[$this->ROLEACCESS_ACCESSID_FIELD]=$AccessId;
		}
		if(empty($cond))
		{
			return NULL;
		}
		return $this->C_GET("ROLEACCESS",$cond);
	}



	/**
	 * setRoleAccess
	 * 添加或删除帐号所拥有的权限
	 *
	 * @param string $RoleId 要设置权限的角色唯一标识
	 * @param string $Access_id 权限ID
	 * @param string $type='ADD|REMOVE' 是添加还是删除权限
	 * return mixed
	 */

	public function setRoleAccess($RoleId,$AccessId,$type='ADD')
	{
		$cond=array();
		$cond[$this->ROLEACCESS_ROLEID_FIELD]=$RoleId;
		if(empty($AccessId))
		{
			return FALSE;
		}
		else
		{
			$cond[$this->ROLEACCESS_ACCESSID_FIELD]=$AccessId;
		}
		switch(strtoupper($type))
		{
			case 'ADD':
				if($this->getRoleAccess($RoleId,$AccessId))
				{
					return TRUE;
				}
				else
				{
					return $this->C_SAVE("ROLEACCESS",$cond);
				}
				break;
			case 'REMOVE':
				return $this->C_REMOVE('ROLEACCESS',$cond);
				break;
			default :
				return FALSE;
				break;
		}
	}



	public function __get($key)
	{
		return isset($this->$key)?$this->$key:NULL;
	}
}