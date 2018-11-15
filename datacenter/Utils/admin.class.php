<?php
class admin{
	public $tbl='admin';
	public $tbl_log='admin_log';
	public $tbl_group='admin_group';
	public $db;
	function __construct($dbconn=null){
		if($dbconn){
			$this->db=$dbconn;
		}else{
			global $db;
			$this->db=TSQL::initDB('Mysqli');
			echo "admin".$this->db."79879879";
		}
	}


	/*
	*	读取管理员次料
	*   返回代码 -1 没有传递进有效的ID, -2 没有这个用户
	*/
	function getUserInfo($id){
		if(!intval($id)){
			return array('status'=>-1,'userinfo'=>null);
		}
		$where=" where id=".intval($id)." ";

		$sql="select a.* from {$this->tbl} a where a.id=".intval($id);
		$row=$this->db->fetchRow($sql);
		if(!$row){
			return array('status'=>-2,'userinfo'=>null);
		}else{
			return array('status'=>1,'userinfo'=>$row);
		}
	}

	function setAuth($username,$password,$time){
		$i=32;
		$str='';
		while($i>0){
			if(rand(0,9)%2==0){
				if(rand(0,1)){
					$str.=chr(97+rand(0,25));
				}else{
					$str.=chr(65+rand(0,25));
				}
			}else{
				$str.=rand(0,9);
			}
			$i--;
		}
		setcookie('hashcode',$str,time()+$time);
		setcookie('auth',($username.":".md5($username.$str.$password)),time()+$time );

	}

    function cleanAuth(){
        setcookie('hashcode',NULL,time()-3600);
        setcookie('auth',NULL,time()-3600);

    }

	function getAuth(){
		if(empty($_COOKIE['auth']) || empty($_COOKIE['hashcode']) ) {
			return false;
		}
		$authinfo=explode(':',$_COOKIE['auth']);
		if(count($authinfo)!=2){
			return false;
		}
		$sql="select * from {$this->tbl} where name='".safestr($authinfo[0])."' ";
		print_r("$this->db".$this->db);
		$row=$this->db->fetchRow($sql);
		if(!$row){
			return false;
		}
		if(  md5($row['name'].$_COOKIE['hashcode'].$row['password'])!=$authinfo[1]){
			return false;
		}elseif($row['stop']){
			return false;
		}else{
			$GAME=$this->getGameList();
			$row['AllowGame']!='' && $row['AllowGame']=explode(',',$row['AllowGame']);
			$row['function']=array();
			if(!$row['AllowGame']){
				$row['AllowGame']=array();
			}
			$row['AllowPlatform']!='' && $row['AllowPlatform']=explode(',',$row['AllowPlatform']);
			if(!$row['AllowPlatform']){
				$row['AllowPlatform']=array();
			}
				
			if($row['level']!=1){
				if($row['group_ids']){
					$sql="select power from {$this->tbl_group} where id in (".$row['group_ids'].")";
					$tmp=$this->db->fetchAll($sql);
					$str='';
					if($tmp){
						foreach($tmp as $v){
							$str.=$v['power'].',';
						}
						$row['function']=array_unique(explode(',',$str));
					}
				}
				if(!$row['AllowGame']) return false;
				if(!$row['AllowPlatform']) return false;
				$row['selected_game']=$row['AllowGame'][0];

			}else{
				$row['selected_game']=key($GAME);
			}
			if($row['level']!=1 && empty($row['function']))
			{
				return false;
			}
			$_SESSION['admin']=$row;
			return True;


		}
	}

	/*
	* 用户登录,
	* 参数,数组,名称用户名和密码和验证码,键值:logname 和logpwd 和randstr
	* 返回, -1 用户名或密码为空
	*		-2 用户名或密码不正确
	*		-3 用户名被锁
	*		-4 验证码不正确
	*		-5 非法登录
	*		-6 没有权限
	*		-7 帐号未开通任何权限,请联系管理员
	*/
	function login($arr,$is_md5=false,$noRand=false){
 
		if(!$noRand && (!isset($_SESSION['IMGCODE']) || !isset($arr['code']) || !isset($arr['logname']) || !isset($arr['logpwd']) ) ){
			return -5;
		}
		if(!$noRand && strtolower($_SESSION['IMGCODE'])!=strtolower($arr['code'])){
			return -4;
		}
		
		if(trim($arr['logname'])=='' || trim($arr['logpwd'])==''){
			return -1;
		}
		if (!get_magic_quotes_gpc()) {
			$arr['logname']=addslashes($arr['logname']);
		}
		if(!$is_md5){
			$logpwd=md5(md5($arr['logpwd']));
		}else{
			$logpwd=addslashes($arr['logpwd']);
		}
		$sql="select a.* from {$this->tbl} a  where name='".$arr['logname']."' and password='".$logpwd."'";		//SQL
        echo ($this->db==null ?"<br>1111111":"<br>3333333333");
		$row=$this->db->fetchRow($sql);

		if(!$row){
			return -2;
		}else{
			
			if($row['stop']){
				return -3;
			}else{
				$GAME=$this->getGameList();
                $PLATFORM=array();
                if($GAME){
                    foreach($GAME as $g){
                        $PLATFORM=array_unique(array_merge($PLATFORM,explode(',',$g['pltlist'])));
                    }
                }
				$row['AllowGame']!='' && $row['AllowGame']=explode(',',$row['AllowGame']);
				$row['function']=array();
				if(!$row['AllowGame']){
					$row['AllowGame']=array();
				}
				$row['AllowPlatform']!='' && $row['AllowPlatform']=explode(',',$row['AllowPlatform']);
				if(!$row['AllowPlatform']){
					$row['AllowPlatform']=array();
				}
				
				if($row['level']!=1){
					if($row['group_ids']){
						$sql="select power from {$this->tbl_group} where id in (".$row['group_ids'].")";
						$tmp=$this->db->fetchAll($sql);
						$str='';
						if($tmp){
							foreach($tmp as $v){
								$str.=$v['power'].',';
							}
							$row['function']=array_unique(explode(',',$str));
						}
					}
					if(!$row['AllowGame']) return -7;
					if(!$row['AllowPlatform']) return -7;
					$row['selected_game']=$row['AllowGame'][0];

				}else{
					$row['selected_game']=key($GAME);
                    $row['AllowGame']=array_keys($GAME);
                    $row['AllowPlatform']=$PLATFORM;
				}
				if($row['level']!=1 && empty($row['function']))
				{
					return -7;
				}
				unset($_SESSION['IMGCODE']);
				$_SESSION['admin']=$row;
				return 1;
			}
		}
	}


	//读取用户列表
	public function getList($kw='',$page=1,$pagecount=20,$order=' a.id desc'){
		$page=$page>=1?$page:1;
		$pagecount=$pagecount>=1?$pagecount:20;
		$where=' where 1 ';
		if(trim($kw)!=''){
			$kw=safestr($kw);
			$where.=" and  (a.name like '%".safestr($kw)."%' or a.realname like '%".safestr($kw)."%') ";
		}
		
		if(!$order){
			$order=' a.id desc';
		}
		$sql="select count(*) as allcount from {$this->tbl} a ".$where;
		$count=intval($this->db->fetchOne($sql));
		$allpage=ceil($count/$pagecount)?ceil($count/$pagecount):1;
		$page=$page>$allpage?$allpage:$page;


		$sql="select a.* from {$this->tbl} a ".$where." order by ".$order.' limit '.(($page-1)*$pagecount).",".$pagecount;
		$arr['list']=$this->db->fetchAll($sql);
		$arr['page']=$page;
		$arr['allpage']=$allpage;
		$arr['count']=$count;

		return $arr;
	}

	/*
	 *更新用户信息
	
	 */

	public function update_user($arr,$where){
		$this->db->Table($this->tbl)->Record($arr)->Where($where);
		foreach($arr as $k=>$v)
		{
			$this->db->Fields($k);
		}
		return $this->db->update();
	}


	/*
	 *添加新用户信息
	 */
	public function add_user($arr){
		foreach($arr as $key=>$value){
			$this->db->Fields($key);
		}
		return $this->db->Table($this->tbl)->Record($arr)->Save();
		//return $this->db->insert($this->tbl,$arr);
	}


	/*
	 *检查用户是否存在
	 */
	public function check($field,$value){
		$sql="select id from ".$this->tbl." where ".$field."='".safestr($value)."'";
		$this->db->Execute($sql);
		return $this->db->getResultNum();
		
	}
	/*
	 *删除帐号
	 */
	public function del_user($id){
		$sql="delete from ".$this->tbl." where id=".$id;
		$this->db->Execute($sql);

	}

	static  function check_power($op,$allowgame=true){

		//管理员,直接通过
		if($_SESSION['admin']['level']==1){
			return true;
		}
		
		if($allowgame && (!isset($_SESSION['admin']['AllowGame']) || !in_array($_SESSION['admin']['selected_game'],$_SESSION['admin']['AllowGame'])) ){
			return false;
		}
		if($op && ($_SESSION['admin']['level']==1 || in_array($op,$_SESSION['admin']['function']))){
			return true;
		}
		return false;
	}

	/*
	* 读取用户组详细内容,
	*/
	function admin_group_list($id=0){
		$sql="select * from ".$this->tbl_group;
		if(intval($id)){
			$sql.=" where id=".$id;
		}
		if($id){
			return $this->db->fetchRow($sql);
		}else{
			return $this->db->fetchAll($sql);
		}
	}


	/*
	* 读取用户组列表,
	*/
	function getGrouplist($kw='',$page=1,$pagecount=20,$order=' id desc'){
		//global $FunctionList;
		$page=$page>=1?$page:1;
		$pagecount=$pagecount>=1?$pagecount:20;
		$where=' where 1 ';
		if(trim($kw)!=''){
			$kw=safestr($kw);
			$where.=" and  ( a.name like '%".safestr($kw)."%' ) ";
		}
		
		if(!$order){
			$order=' a.id desc';
		}
		$sql="select count(*) as allcount from {$this->tbl_group} a ".$where;
		$tmp=$this->db->fetchRow($sql);
		$count=$tmp['allcount'];
		$allpage=ceil($count/$pagecount)?ceil($count/$pagecount):1;
		$page=$page>$allpage?$allpage:$page;


		$sql="select a.*,d.realname,d.name as username from {$this->tbl_group} a left join {$this->tbl} d on d.id=a.admin_id ".$where." order by ".$order.' limit '.(($page-1)*$pagecount).",".$pagecount;
		$arr['list']=$this->db->fetchAll($sql);
		$arr['page']=$page;
		$arr['allpage']=$allpage;
		$arr['count']=$count;
		return $arr;
	}
	
//使用名称读取权限组
	function getGroupByName($name){
		if(!$name){
			return null;
		}
		$sql="select * from {$this->tbl_group} where name='".safestr($name)."'";
		return $this->db->fetchRow($sql);
	}

//使用ID读取权限组
	function getGroupById($id){
		if(!$id){
			return null;
		}
		$sql="select * from {$this->tbl_group} where id='".intval($id)."'";
		return $this->db->fetchRow($sql);
	}

	
	function updateGroup($arr,$id){
		$this->db->Table($this->tbl_group)->Record($arr)->Where('id='.$id);

		foreach($arr as $k=>$v){
			$this->db->Fields($k);
		}
		return $this->db->update();
	}


	function addGroup($arr){

		foreach($arr as $k=>$v){
			$this->db->Fields($k);
		}
		return $this->db->Table($this->tbl_group)->Record($arr)->Save();
//		return $this->db->insert($this->tbl_group,$arr);
	}

	/*
	 *删除管理员权限组帐号
	 */
	public function del_admin_group($id){
		$sql="delete from ".$this->tbl_group." where id=".$id;
		$this->db->Execute($sql);
		
	}



	public function getGameList(){
		$sql="select * from game";
		$tmp=$this->db->fetchAll($sql);
		$list=array();
		if($tmp){
			foreach($tmp as $game){
				$list[$game['gamecode']]=$game;
				$list[$game['gamecode']]['plt']=explode(',',$game['pltlist']);
			}
		}
		return $list;
	}

	public function getServerlist($game,$plt=''){
		$sql="select * from game_server where gamecode='".$game."' ";
		if($plt){
			$sql.=" and platform='".$plt."'";
		}
		return $this->db->fetchAll($sql);
		
	}
}
