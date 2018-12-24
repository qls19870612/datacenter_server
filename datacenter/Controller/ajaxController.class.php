<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 13-12-23
 * Time: 上午10:37
 */
class ajaxController extends BasicController
{
    private $controller = 'admin';

    /*
     * loginstatus
     * 返回当前用户的登录状态
     */
    public function loginstatus()
    {
        $resutl = array('code' => 0, 'msg' => '');
        if (!empty($_SESSION['admin'])) {
            $result['code'] = Cfg::G('resultCode.SUCCESS');
            $result['msg'] = '登录状态正常';
        } else {
            $result['code'] = Cfg::G('resultCode.UNLOGIN');
            $result['msg'] = '帐号未登录';
        }
        echo json_encode($result);
        die();
    }


    function login()
    {
		 
        $post = _REQUEST();

        $admin = new admin();
        $result = $admin->login($post, false, true);
        $returnmsg = array('msg' => '', 'code' => 0);

        switch ($result) {
            case -1:
                $returnmsg['code'] = Cfg::G('resultCode.MISSPARAM');
                $returnmsg['msg'] = '用户名和密码不能为空';
                break;
            case -2:
                $returnmsg['code'] = Cfg::G('resultCode.FAILD');
                $returnmsg['msg'] = '用户名或密码不正确';
                break;
            case -3:
                $returnmsg['code'] = Cfg::G('resultCode.FAILD');
                $returnmsg['msg'] = '该用户帐号已被锁';
                break;
            case -5:
                $returnmsg['code'] = Cfg::G('resultCode.FAILD');
                $returnmsg['msg'] = '非法登录';
                break;
            case -7:
                $returnmsg['code'] = Cfg::G('resultCode.FAILD');
                $returnmsg['msg'] = '该帐号未开通任何权限,请联系管理员';
                break;
            case 1:
                $seconds = 3600;
                if (!empty($post['keepstatus'])) {
                    $seconds = intval($post['keepstatus']) * 3600 * 24;
                }
                if ($seconds) {
                    $admin->setAuth($_SESSION['admin']['name'], $_SESSION['admin']['password'], $seconds);
                }
                $returnmsg['code'] = Cfg::G('resultCode.SUCCESS');
                $returnmsg['msg'] = '登录成功';
                $returnmsg['username'] = $_SESSION['admin']['name'];
                $returnmsg['allowgame'] = $_SESSION['admin']['AllowGame'];
                $returnmsg['allowplatform'] = $_SESSION['admin']['AllowPlatform'];
                $returnmsg['realname'] = $_SESSION['admin']['realname'];
                break;
        }

        echo json_encode($returnmsg);
        die();
    }

    function logout()
    {
        if (session_id()) {
            unset($_SESSION);
            session_destroy();
            $admin = new admin();
            $admin->cleanAuth();
        }
        $result = array('code' => Cfg::G('resultCode.SUCCESS'), 'msg' => '退出成功');
        echo json_encode($result);
        die();
    }

    public function getfuncs()
    {
        $MenuGroup = Cfg::G('MenuGroup');
        $funclist = Cfg::G('FunctionList');
        $result = array('code' => 0, 'msg' => '', 'functiongroup' => array());
        $gamecode = _REQUEST('gamecode');

        if (empty($_SESSION['randtoken'])) {
            $_SESSION['randtoken'] = md5(time());
        }

        $tmp_group = $this->_db->fetchAll("select id,groupname,parent_id from menu_group");
        $sql = "select id,rp_cid,rp_title,rp_url,rp_mark from report_layout ";
        $sql .= " where rp_cid in (select rp_cid from game_report where gamecode='" . $gamecode . "') ";


        $sql .= " order by rp_index asc";
        $layout = $this->_db->fetchAll($sql);
        $tmp = array();
        if ($tmp_group) {
            foreach ($tmp_group as $v) {
                $tmp[$v['id']] = $v;
                $tmp[$v['id']]['sub_group'] = array();
                $tmp[$v['id']]['menu'] = array();
                foreach ($layout as $l) {
                    if ($l['rp_mark'] == $v['id']) {
                        if ($_SESSION['admin']['level'] || in_array($l['id'], $_SESSION['admin']['function'])) {
                            unset($l['rp_mark']);
                            unset($l['id']);
                            $tmp[$v['id']]['menu'][] = $l;
                        }
                    }
                }
            }

            while (count($tmp) > 1) {

                $noover = false;
                foreach ($tmp as $k => $v) {
                    if ($v['parent_id'] == 0) {
                        continue;
                    } else {
                        $noover = true;
                    }
                    $has_child = false;
                    foreach ($tmp as $k2 => $v2) {
                        if ($v2['parent_id'] == $v['id']) {
                            $has_child = true;
                            break;
                        }
                    }
                    if (!$has_child) {
                        $tmp[$v['parent_id']]['sub_group'][] = $v;
                        unset($tmp[$k]);
                        continue;
                    }
                }
                if (!$noover) {
                    break;
                }
            }

        }

        if ($tmp) {
            $result['code'] = Cfg::G('resultCode.SUCCESS');
            $result['msg'] = '请求完成';
            $result['functiongroup'] = $tmp;
            $result['allowgame'] = $_SESSION['admin']['AllowGame'];
            $result['allowplatform'] = $_SESSION['admin']['AllowPlatform'];
        } else {
            $result['code'] = Cfg::G('resultCode.FAILD');
            $result['msg'] = '没有任何报表中心的权限';
        }
        echo json_encode($result);
        die();

    }



    /*
        public function getdata(){
            $game=_request('game');
            $sid=_request('sid');
            $ft=_request('ft');
            $et=_request('et');
            $timeformat=_request('timeformat');
            $orderby=_request('orderby');
            $groupby=_request('groupby');
            $col=_request('col');
            $timefield=_request('timefield');
            $begin_time=0;
            $end_time=0;
            $result=array('status'=>0,'msg'=>'');


            if(!$game){
                $result['code']=Cfg::G('resultCode.NORIGHT');
                $result['msg']='未指定要读取数据的游戏';
                echo json_encode($result);
                die();
            }

            if(!in_array($game,$_SESSION['admin']['AllowGame'])){
                $result['code']=Cfg::G('resultCode.NORIGHT');
                $result['msg']='没有权限请求游戏［'.$game.'］的数据';
                echo json_encode($result);
                die();
            }
            if($sid){
                foreach($sid as $plt=>$serverlist){
                    if(!in_array($plt,$_SESSION['admin']['AllowPlatform'])){
                        $result['code']=Cfg::G('resultCode.NORIGHT');
                        $result['msg']='没有权限请求［'.$plt.'］平台的数据';
                        echo json_encode($result);
                        die();
                    }
                }
            }

            if(!$col){
                $result['code']=Cfg::G('resultCode.FAILD');
                $result['msg']='没有指定要查询的内容';
                echo json_encode($result);
                die();
            }else{
                foreach($col as $tb=>$fields){
                    if(!$fields){
                        $result['code']=Cfg::G('resultCode.FAILD');
                        $result['msg']='请指定表［'.$tb.'］要读取的字段';
                        echo json_encode($result);
                        die();
                    }
                }
            }



            $dbConfig=CFG::G('noSQL.'.$game);
            if(!$dbConfig){
                $result['code']=Cfg::G('resultCode.FAILD');
                $result['msg']='该游戏数据库配置丢失，请联系管理员,游戏［'.$game.'］';
                echo json_encode($result);
                die();
            }



            NoSQL::instance( $dbConfig,$game);
            $nosql_db=NoSQL::initDB($game);
            $tb_list=$nosql_db->showTables();

            foreach($col as $tbname=>$fields){
                if(!in_array($tbname,$tb_list)){
                    $result['code']=Cfg::G('resultCode.FAILD');
                    $result['msg']='表［'.$tbname.'］不存在';
                    echo json_encode($result);
                    die();
                }
            }

            if($ft){
                if(!$timeformat || !in_array($timeformat,array('timestamp','day','date','datetimestamp')) ){
                    $timeformat='date';
                }
                if(!@strtotime($ft)){
                    $result['code']=Cfg::G('resultCode.FAILD');
                    $result['msg']='开始时间的格式不正确';
                    echo json_encode($result);
                    die();
                }else if ($et && !@strtotime($et) ){
                    $result['code']=Cfg::G('resultCode.FAILD');
                    $result['msg']='结束时间的格式不正确';
                    echo json_encode($result);
                    die();
                }
                if($ft){
                    if($timeformat=='timestamp'){
                        $begin_time=strtotime($ft);
                    }elseif($timeformat=='day'){
                        $begin_time=date("Ymd",strtotime($ft));
                    }elseif($timeformat=='date'){
                        $begin_time=date("Y-m-d H:i:s",strtotime($ft));
                    }elseif($timeformat=='datetimestamp'){
                        $begin_time=date("YmdHis",strtotime($ft));
                    }
                }
                if($et){
                    if($timeformat=='timestamp'){
                        $end_time=strtotime($et);
                    }elseif($timeformat=='day'){
                        $end_time=date("Ymd",strtotime($et));
                    }elseif($timeformat=='date'){
                        $end_time=date("Y-m-d H:i:s",strtotime($et));
                    }elseif($timeformat=='datetimestamp'){
                        $end_time=date("YmdHis",strtotime($et));
                    }
                }
            }

            //开始解释表读取规则
                foreach($col as $tb=>$fields){
                    $nosql_db->TB($tb);	//切换表
                    $cmd=array();
                    $match=array('$match'=>array());
                    //是否有时间项
                    if ($begin_time && $timefield){
                        if($end_time){
                            $match['$match'][$timefield]['$gte']=$begin_time;
                            $match['$match'][$timefield]['$lte']=$end_time;
                        }else{
                            $match['$match'][$timefield]=$begin_time;
                        }
                    }
                    if($sid){
                        $admin=new admin();
                        foreach($sid as $pltname=>$servers){
                            $allsids=$admin->getServerlist($game,$pltname);
                            if(trim($servers)=='*'){

                            }
                        }
                    }



                }
            //开始解释表读取规则


            echo json_encode($result);
        }
        */

    /*
    public function getdata(){
        $game=_request('game');
        $sid=_request('sid');
        $ft=_request('ft');
        $et=_request('et');
        $timeformat=_request('timeformat');
        $orderby=_request('orderby');
        $groupby=_request('groupby');
        $col=_request('col');
        $timefield=_request('timefield');
        $begin_time=0;
        $end_time=0;
        $result=array('status'=>0,'msg'=>'');


        if(!$game){
            $result['code']=Cfg::G('resultCode.NORIGHT');
            $result['msg']='未指定要读取数据的游戏';
            echo json_encode($result);
            die();
        }

        if(!in_array($game,$_SESSION['admin']['AllowGame'])){
            $result['code']=Cfg::G('resultCode.NORIGHT');
            $result['msg']='没有权限请求游戏［'.$game.'］的数据';
            echo json_encode($result);
            die();
        }
        if($sid){
            foreach($sid as $plt=>$serverlist){
                if(!in_array($plt,$_SESSION['admin']['AllowPlatform'])){
                    $result['code']=Cfg::G('resultCode.NORIGHT');
                    $result['msg']='没有权限请求［'.$plt.'］平台的数据';
                    echo json_encode($result);
                    die();
                }
            }
        }

        if(!$col){
            $result['code']=Cfg::G('resultCode.FAILD');
            $result['msg']='没有指定要查询的内容';
            echo json_encode($result);
            die();
        }else{
            foreach($col as $tb=>$fields){
                if(!$fields){
                    $result['code']=Cfg::G('resultCode.FAILD');
                    $result['msg']='请指定表［'.$tb.'］要读取的字段';
                    echo json_encode($result);
                    die();
                }
            }
        }



        $dbConfig=CFG::G('DB.'.$game);
        if(!$dbConfig){
            $result['code']=Cfg::G('resultCode.FAILD');
            $result['msg']='该游戏数据库配置丢失，请联系管理员,游戏［'.$game.'］';
            echo json_encode($result);
            die();
        }



        $tsql_db=TSQL::initDB($game);
        $tb_list_tmp=$tsql_db->fetchAll("show tables");
        $tb_list=array();
        if($tb_list_tmp){
            foreach($tb_list_tmp as $v){
                $tb_list[]=strtoupper($v['Tables_in']);
            }
        }else{
            $result['code']=Cfg::G('resultCode.FAILD');
            $result['msg']='数据库未检测到数据表，请联系管理员';
            echo json_encode($result);
            die();
        }

        if($ft){
            if(!$timeformat || !in_array($timeformat,array('timestamp','day','date','datetimestamp')) ){
                $timeformat='date';
            }
            if(!@strtotime($ft)){
                $result['code']=Cfg::G('resultCode.FAILD');
                $result['msg']='开始时间的格式不正确';
                echo json_encode($result);
                die();
            }else if ($et && !@strtotime($et) ){
                $result['code']=Cfg::G('resultCode.FAILD');
                $result['msg']='结束时间的格式不正确';
                echo json_encode($result);
                die();
            }

            if($ft){
                if($timeformat=='timestamp'){
                    $begin_time=strtotime($ft);
                }elseif($timeformat=='day'){
                    $begin_time=date("Ymd",strtotime($ft));
                }elseif($timeformat=='date'){
                    $begin_time=date("Y-m-d H:i:s",strtotime($ft));
                }elseif($timeformat=='datetimestamp'){
                    $begin_time=date("YmdHis",strtotime($ft));
                }
            }
            if($et){
                if($timeformat=='timestamp'){
                    $end_time=strtotime($et);
                }elseif($timeformat=='day'){
                    $end_time=date("Ymd",strtotime($et));
                }elseif($timeformat=='date'){
                    $end_time=date("Y-m-d H:i:s",strtotime($et));
                }elseif($timeformat=='datetimestamp'){
                    $end_time=date("YmdHis",strtotime($et));
                }
            }
        }

        //开始解释表读取规则
        $result['data']=array();
            foreach($col as $tb=>$fields){

                $tsql_db->reset();	//切换表
                if($sid){
                    $admin=new admin();
                    foreach($sid as $pltname=>$servers){
                        $table_name=$tb;
                        $tsql_db->reset();	//切换表
                        $table_name=$pltname."_".$table_name;
                        if(!in_array(strtoupper($table_name),$tb_list)){
                            $result['code']=Cfg::G('resultCode.FAILD');
                            $result['msg']='表［'.$table_name.'］不存在';
                            echo json_encode($result);
                            die();
                        }
                        $fieldlist=explode(',',$fields);
                        foreach($fieldlist as $f){
                            $tsql_db->Fields($f);
                        }

                        $tsql_db->Table($table_name);
                                //是否有时间项
                        if ($begin_time && $timefield){
                            if($end_time){
                                $tsql_db->Where($timefield." between '".$begin_time."' and '".$end_time."'");
                            }else{
                                $tsql_db->Where($timefield." ='".$begin_time."'");
                            }
                        }
                        if(!empty($groupby[$table_name])){
                            $tsql_db->GroupBy($groupby[$table_name]);
                        }
                        if(!empty($orderby[$table_name])){
                            $tsql_db->OrderBy($orderby[$table_name]);
                        }
                        $allsids=$admin->getServerlist($game,$pltname);
                        $worldid=array();
                        if(trim($servers)=='*'){
                            if($allsids){
                                foreach($allsids as $v){
                                    $worldid[]=$v['worldid'];
                                }
                            }
                        }else{
                            $worldid_tmp=array();
                            if($allsids){
                                foreach($allsids as $v){
                                    $worldid_tmp[]=$v['worldid'];
                                }
                                $select=explode(',',$servers);
                                foreach($select as $wid){
                                    if(intval($wid) && in_array($wid,$worldid_tmp)){
                                        $worldid[]=$wid;
                                    }
                                }
                            }
                        }
                        if(!$worldid){
                            $result['code']=Cfg::G('resultCode.FAILD');
                            $result['msg']='服务器列表不正确，请检查';
                            echo json_encode($result);
                            die();
                        }
                        $tsql_db->Where('iworldid in ('.implode(',',$worldid).')');
                        $result['data']=array_merge($tsql_db->fetchAll(),$result['data']);
                    }
                }else{
                    $result['code']=Cfg::G('resultCode.FAILD');
                    $result['msg']='请选择要游戏服务器';
                    echo json_encode($result);
                    die();

                }
            }
        //开始解释表读取规则


        echo json_encode($result);
    }
*/





    	public function quote($value) {
	    		return '\'' . addcslashes($value, "\x00\n\r\\'\"\x1a") . '\'';
				}



    public function getdata()
    {
        $sql_id = intval(_request('sql_id'));
        $sql_key = _request('sql_key');
        $result = array('code' => 0, 'msg' => '');

        if (!$sql_id) {
            $result['code'] = Cfg::G('resultCode.FAILD');
            $result['msg'] = '未指定请求的SQL';
            echo json_encode($result);
            die();
        }
        if (!$sql_key) {
            $result['code'] = Cfg::G('resultCode.FAILD');
            $result['msg'] = '未指定SQL_KEY';
            echo json_encode($result);
            die();
        }
        //  $tmp = $this->_db->fetchRow("select * from sql_tpl where id=" . $sql_id . " and sql_key='" . $sql_key . "'");
 $tmp = $this->_db->fetchRow("select * from sql_tpl where id=" . $sql_id . " and sql_key=" . $this->quote( $sql_key) );
      



        if (!$tmp) {
            $result['code'] = Cfg::G('resultCode.FAILD');
            $result['msg'] = '请求的SQL不存在！';
            echo json_encode($result);
            die();
        }
        $sql = $tmp['sql_content'];
        $sql_pre = $tmp['pre_sql'];
        $game = _request('game');
        $sid = _request('sid');


//********************************* 新加入 ***************************************************

        if (mb_stripos($sql, '[LOG].') == false) { //判断是否包含有 [LOG]. ,如果包含有此标识,则继续数据的
            $select_db_game_name = $game;
        } else {
            $sql = str_replace("[LOG].", '', $sql); // 去除[LOG].标识
            $select_db_game_name = $game . "_log";  //设置查询 LOG 数量
        }
//********************************* 新加入 ***************************************************


        $p = _REQUEST();
        if (!$game) {
            $result['code'] = Cfg::G('resultCode.NORIGHT');
            $result['msg'] = '未指定要读取数据的游戏';
            echo json_encode($result);
            die();
        }

        if (!in_array($game, $_SESSION['admin']['AllowGame'])) {
            $result['code'] = Cfg::G('resultCode.NORIGHT');
            $result['msg'] = '没有权限请求游戏［' . $game . '］的数据';
            echo json_encode($result);
            die();
        }
        if ($sid) {

            foreach ($sid as $plt => $serverlist) {
                if (!in_array($plt, $_SESSION['admin']['AllowPlatform'])) {
                    $result['code'] = Cfg::G('resultCode.NORIGHT');
                    $result['msg'] = '没有权限请求［' . $plt . '］平台的数据';
                    echo json_encode($result);
                    die();
                }
            }
        } else {
            $result['code'] = Cfg::G('resultCode.FAILD');
            $result['msg'] = '请提交要请求的平台以及服务器列表';
            echo json_encode($result);
            die();
        }


     //   $dbConfig = CFG::G('DB.' . $game);
          $dbConfig = CFG::G('DB.' . $select_db_game_name);
        if (!$dbConfig) {
            $result['code'] = Cfg::G('resultCode.FAILD');
            $result['msg'] = '该游戏数据库配置丢失，请联系管理员,游戏［' . $game . '］';
            echo json_encode($result);
            die();
        }

       // $tsql_db = TSQL::initDB($game);
        $tsql_db = TSQL::initDB($select_db_game_name); //加载对应的数据库db的配置



        if (!$tsql_db->isConnected()) {
            $result['code'] = Cfg::G('resultCode.FAILD');
            $result['msg'] = '内部错误，数据库无法连接';
            echo json_encode($result);
            die();
        }

        $dblist_tmp = $tsql_db->fetchAll('show databases');
        $dblist = array();
        if (!$dblist_tmp) {
            $result['code'] = Cfg::G('resultCode.FAILD');
            $result['msg'] = '无法检索数据库';
            echo json_encode($result);
            die();
        }

        foreach ($dblist_tmp as $v) {
            $dblist[] = strtolower($v['Database']);
        }


        foreach ($p as $k => $v) {
            if (stripos($k, "ouput_") !== false) { //如果是output_开头的变量不做处理
                continue;
            }
            if (in_array($k, array('sid'))) {
                continue;
            }
            if (is_array($v)) {
                $sql = str_replace('{' . $k . '}', implode(',', $v), $sql);
            } else {
                $sql = str_replace('{' . $k . '}', $v, $sql);
            }
        }


        $admin = new admin();
        $result['data'] = array();
        $sql_arr = array();
        foreach ($sid as $plt => $servers) {


            // if(!in_array(strtolower($game.'_'.$plt),$dblist)){
            // 	$result['code']=Cfg::G('resultCode.FAILD');
            // 	$result['msg']='数据库不存在';
            // 	echo json_encode($result);
            // 	die();
            // }

            $allsids = $admin->getServerlist($game, $plt);
            $worldid = array();
            $is_all = false;
            if (trim($servers) == '*') {
                $is_all = true;
                if ($allsids) {

                    foreach ($allsids as $v) {
                        $worldid[] = $v['worldid'];
                    }
                }
            } else {
                $worldid_tmp = array();
                if ($allsids) {
                    foreach ($allsids as $v) {
                        $worldid_tmp[] = $v['worldid'];
                    }
                    $select = explode(',', $servers);
                    foreach ($select as $wid) {
                        //if(intval($wid) && in_array($wid,$worldid_tmp)){      // 修改区服为0过滤
                        if (in_array($wid, $worldid_tmp)) {
                            $worldid[] = $wid;
                        }
                    }
                }
            }

            if (!$worldid) {
                $result['code'] = Cfg::G('resultCode.FAILD');
                $result['msg'] = '服务器列表不正确，请检查';
                echo json_encode($result);
                die();
            }

            $query_sql = str_replace('{sid}', implode(',', $worldid), $sql);
            $query_sql = str_replace('{plt}', $plt, $query_sql);
            $query_sql = str_replace('{game}', $game, $query_sql);
            if ($is_all) {
                $query_sql = str_replace('{c_sid}', '123456789', $query_sql);
            } else {
                $query_sql = str_replace('{c_sid}', implode(',', $worldid), $query_sql);
            }
            $sql_arr[] = $query_sql;


        }

        if ($sql_arr) {
            if ($sql_pre) {
                foreach ($p as $k => $v) {
                    if (stripos($k, "ouput_") !== false) { //如果是output_开头的变量不做处理
                        continue;
                    }
                    if (in_array($k, array('sid'))) {
                        $sql_pre = str_replace('{sid}', implode(',', $worldid), $sql_pre);
                        continue;
                    }
                    if (is_array($v)) {
                        $sql_pre = str_replace('{' . $k . '}', implode(',', $v), $sql_pre);
                    } else {
                        $sql_pre = str_replace('{' . $k . '}', $v, $sql_pre);
                    }
                }

                $sql_tmp = str_replace('[SQL]', implode(" union all ", $sql_arr), $sql_pre);
                $sql_tmp = str_replace('{game}', $game, $sql_tmp);
                $rows = $tsql_db->fetchAll($sql_tmp);

                if (isset($rows['status']) && !$rows['status']) {
                    $result['data'] = array();
                    $result['code'] = Cfg::G('resultCode.FAILD');
                    $result['msg'] = $rows['SQL'] . "执行失败";
                    echo json_encode($result);
                    die();
                }
                $result['data'] = array_merge($result['data'], $rows);
            } else {
                foreach ($sql_arr as $query_sql) {
                    $rows = $tsql_db->fetchAll($query_sql);
                    if (isset($rows['status']) && !$rows['status']) {
                        $result['data'] = array();
                        $result['code'] = Cfg::G('resultCode.FAILD');
                        $result['msg'] = $rows['SQL'] . "执行失败";
                        echo json_encode($result);
                        die();
                    }
                    $result['data'] = array_merge($result['data'], $rows);
                }
            }
        }

        // var_dump($_POST);
        // var_dump($result['data']); exit;
        $output = intval(_request('output_excel')); //是否输出excel 文件 1为输出excel文件
        if ($output == 1) {
            if (!empty($result['msg'])) { //有错误
                echo "错误:" . $result['msg'];
                exit;
            }
            $head_name_array_str = _request('output_head_names'); //显示的excel头数组,用,分割开标题
            $filter_name_array_str = _request('output_filter_names'); //过滤的查询的结果集中的json数据的key值,用,分割開
            $output_tasikmalaya_name = _request('output_tasikmalaya_name'); //数据打横的字段


            $output_tasikmalaya_group_name = _request('output_tasikmalaya_group_name'); //数据打横的分组的数据


            $output_tasikmalaya_group_head_name = _request('output_tasikmalaya_group_head_name'); //标题 左上角
            $output_tasikmalaya_data_name = _request('output_tasikmalaya_data_name'); //数据打横的分组的数据


            $result_data_array = $result['data'];
            if (!empty($result_data_array)) {
                if (!empty($output_tasikmalaya_name) && !empty($output_tasikmalaya_group_name)) {
                    $tasikmalaya_array = array();
                    $head_name_array = array();
                    $head_name_array[] = $output_tasikmalaya_group_head_name;
                    foreach ($result_data_array as $result_data) {
                        $daheng_filed = $result_data[$output_tasikmalaya_name];
                        if (in_array($daheng_filed, $head_name_array) == false) {
                            $head_name_array[] = $daheng_filed;
                        }
                        $tasikmalaya_array[$result_data[$output_tasikmalaya_group_name]][$daheng_filed] = $result_data[$output_tasikmalaya_data_name];
                    }
                    $output_tasikmalaya_data_key_name_array = array();  //所有的列名
                    foreach ($tasikmalaya_array as $result_data) {
                        foreach ($result_data as $key => $val) {
                            $output_tasikmalaya_data_key_name_array[$key] = $key;
                        }
                    }
                    ExcelModel::sentHeader($head_name_array);
                    foreach ($tasikmalaya_array as $output_tasikmalaya_group_name => $result_data) {
                        $output_data_array = array();
                        foreach ($output_tasikmalaya_data_key_name_array as $output_tasikmalaya_data_key_name) {
                            if (array_key_exists($output_tasikmalaya_data_key_name, $result_data)) {
                                $output_data_array[$output_tasikmalaya_data_key_name] = $result_data[$output_tasikmalaya_data_key_name];
                            } else {
                                $output_data_array[$output_tasikmalaya_data_key_name] = 0;
                            }
                        }
                        array_unshift($output_data_array, $output_tasikmalaya_group_name);
                        ExcelModel::sentData($output_data_array);
                    }
                } else {
                    $filter_name_array = explode(",", $filter_name_array_str);
                    $head_name_array = explode(",", $head_name_array_str);
                    ExcelModel::sentHeader($head_name_array);
                    foreach ($result_data_array as $result_data) {
                        $row_data = array();
                        foreach ($filter_name_array as $temp_name) {
                            $row_data[] = $result_data[$temp_name];
                        }
                        ExcelModel::sentData($row_data);
                    }

                }
                ExcelModel::sentEnd();
            } else {
                echo "无相关数据";
            }
            exit;
        }
        $result['code'] = 200;
        echo json_encode($result);
        //$tsql_db->debug();
    }


}
