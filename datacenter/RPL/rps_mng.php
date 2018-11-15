<?php
	require("pdodb/Db.class.php");
	$db = new Db();

	function __getReportsForm($page=1, $pagesize=20, $search=''){
		global $db;
		global $_pageSearch;
		$feedback = '';
		$reports = array();
		$startRow = ($page-1)*$pagesize;
		$searchStr = trim($search);
		$searchTxt = '%'.$searchStr.'%';


		$dom_clear_search = $searchStr == '' ? '' : '&nbsp;<button class="clbtn">取消搜索</button>';
		$dom_search_input = '<div class="row"><div id="searchList"><input class="shipt" type="text" value="'.$searchStr.'">&nbsp;<button class="shbtn">搜索</button>'.$dom_clear_search.'</div></div>';
		$dom_report_list = '';
		$dom_page_controler = '';
		$dom_noreports = '<div class="row"><p style="text-align:center;">没有数据</p></div>';

		if($search == ''){
			$reports = $db->query("SELECT * FROM report_layout ORDER BY id DESC LIMIT $startRow, $pagesize");
		}else{
			$reports = $db->query("SELECT * FROM report_layout WHERE id = '$searchStr' OR rp_cid LIKE '$searchTxt' OR rp_title LIKE '$searchTxt' ORDER BY id DESC LIMIT $startRow, $pagesize");
		}

		$reportsCount = count($reports);

		if($reportsCount > 0){

			//get dom_report_list
			$tmp = '';
			foreach ($reports as $i => $row){
				$class = '';
				if($i%3 == 0){
					if($i%6 == 0){
						$class = 'sixth';
					}else{
						$class = 'third';
					}
				}
				// $class = $i%2 == 0 ? 'even' : 'odd';
		    	$tmp .= '<tr class="'.$class.'">';
		    	$tmp .= '<td>'.$row['id'].'</td>';
		    	$tmp .= '<td>'.$row['rp_title'].'</td>';
		    	$tmp .= empty($row['rp_url']) ? '<td class="rglink"><a href="layout_setting.php?rp_cid='.$row['rp_cid'].'">'.$row['rp_cid'].'</a></td>' : '<td class="rglink"><a href="url_setting.php?rp_cid='.$row['rp_cid'].'">'.$row['rp_cid'].'</a></td>';
		    	$c_url = empty($row['rp_url']) ?  '无' : $row['rp_url'];
		    	$tmp .= '<td>'.$c_url.'</td>';
		    	$settingBtn = empty($row['rp_url']) ? '<a href="report_games.php?rp_cid='.$row['rp_cid'].'" style="display:inline"><button>关联</button></a><button class="astemplate">模版</button>' : '<a href="report_games.php?rp_cid='.$row['rp_cid'].'" style="display:inline"><button>关联</button></a>';
		    	$tmp .= '<td>'.$settingBtn.'<form action="report_setting_save.php" method="post" name="report_save" onsubmit="return confirmDelete()" style="display:inline"><input type="hidden" name="act" value="remove"><input type="hidden" name="nrp_cid" value="'.$row['rp_cid'].'"><input type="submit" value="删除"></form></td>';
		    	$tmp .= '</tr>';
		    }
		    $dom_report_list = '<div class="row"><table id="reportList"><tr><th width="6%">ID</th><th width="20%">报表页</th><th width="30%">pagecode</th><th width="28%">URL</th><th width="16%">操作</th></tr>'.$tmp.'</table></div>';

		    //get dom_page_controler
		    $reportsTotal = 0;
		    if($search == ''){
				$reportsTotal = $db->single("SELECT count(id) FROM report_layout");
			}else{
				$reportsTotal = $db->single("SELECT count(id) FROM report_layout WHERE id = '$searchStr' OR rp_cid LIKE '$searchTxt' OR rp_title LIKE '$searchTxt'");
			}
		    $pages = ceil($reportsTotal/$pagesize);
		    $pageEtc = '<li class="pageetc""><span>...</span></li>';
		    $pagePrevNum = $page-1;
			$pageNextNum = $page+1;

			$_pageSearch = $search =='' ? '' : '&search='.trim($search);
			$pagePrev = $page > 1 ? '<li class="pageitm"><a href="?page='.$pagePrevNum.$_pageSearch.'">&laquo;</a></li>' : '<li class="pageitm disabled"><span>&laquo;</span></li>';
			$pageNext = $page < $pages ? '<li class="pageitm"><a href="?page='.$pageNextNum.$_pageSearch.'">&raquo;</a></li>' : '<li class="pageitm disabled"><span>&raquo;</span></li>';
			$pageJump = '<li class="pageetc" style="margin-left:20px"><input style="width:40px;text-align:center;" data-pagesearch="'.$_pageSearch.'"></li><li class="pageetc"><button id="PageJump">GO</button></li>';
			$tmp = '';

			function __mkPageOption($pageNum, $isActive=0) {
				global $_pageSearch;
				$pageOPtion = '';
				if(isset($pageNum) && $pageNum > 0){
					$pageOPtion = $isActive ? '<li class="pageitm pageNum disabled" data-pagenum="'.$pageNum.'"><span>'.$pageNum.'</span></li>' : '<li class="pageitm pageNum" data-pagenum="'.$pageNum.'"><a href="?page='.$pageNum.$_pageSearch.'">'.$pageNum.'</a></li>';
				}
				return $pageOPtion;
			}

			if($pages < 8){
				for($i=0; $i<$pages; $i++){
					$pageNum = $i+1;
					$isActive = $pageNum == $page ? 1 : 0;
					$tmp .= __mkPageOption($pageNum, $isActive);
				}
			}else{
				switch ($page)
				{
				case 1:
				  $tmp = __mkPageOption(1,1).__mkPageOption(2).__mkPageOption(3).$pageEtc.__mkPageOption($pages);
				  break;  
				case 2:
			      $tmp = __mkPageOption(1).__mkPageOption(2,1).__mkPageOption(3).$pageEtc.__mkPageOption($pages);
				  break;
				case 3:
			      $tmp = __mkPageOption(1).__mkPageOption(2).__mkPageOption(3,1).__mkPageOption(4).$pageEtc.__mkPageOption($pages);
				  break;
				case 4:
			      $tmp = __mkPageOption(1).__mkPageOption(2).__mkPageOption(3).__mkPageOption(4,1).__mkPageOption(5).$pageEtc.__mkPageOption($pages);
				  break;
				case $pages-3:
				  $tmp = __mkPageOption(1).$pageEtc.__mkPageOption($pages-4).__mkPageOption($pages-3,1).__mkPageOption($pages-2).__mkPageOption($pages-1).__mkPageOption($pages);
				  break;
				case $pages-2:
				  $tmp = __mkPageOption(1).$pageEtc.__mkPageOption($pages-3).__mkPageOption($pages-2,1).__mkPageOption($pages-1).__mkPageOption($pages);
				  break;
				case $pages-1:
				  $tmp = __mkPageOption(1).$pageEtc.__mkPageOption($pages-2).__mkPageOption($pages-1,1).__mkPageOption($pages);
				  break;
				case $pages:
				  $tmp = __mkPageOption(1).$pageEtc.__mkPageOption($pages-2).__mkPageOption($pages-1).__mkPageOption($pages,1);
				  break;
				default:
				  $tmp = __mkPageOption(1).$pageEtc.__mkPageOption($page-1).__mkPageOption($page,1).__mkPageOption($page+1).$pageetc.__mkPageOption($pages);
				}
			}
			$dom_page_controler = '<div class="row"><ul id="pagecontroler">'.$pagePrev.$tmp.$pageNext.$pageJump.'</ul></div>';

			$feedback = $dom_search_input.$dom_report_list.$dom_page_controler;
		}else{
			$feedback = $dom_noreports;
		}

	    return $feedback;
	}



	function __addReport($rp_cid, $rp_titlen, $rp_urln){
		global $db;
		$add_report = 0;
		$rp_titlef = trim($rp_titlen);
		$rp_title = empty($rp_titlef) ? '报表项目' : $rp_titlef;
		$rp_url = trim($rp_urln);

		if(!empty($rp_cid)){
			$add_report = $db->query("INSERT INTO report_layout(rp_cid, rp_title, rp_url) VALUES(:rp_cid, :rp_title, :rp_url)",array("rp_cid"=>$rp_cid, "rp_title"=>$rp_title, "rp_url"=>$rp_url));	
		}
		$feedback = '<p>报表:<span style="color:#0080C0"> '.$add_report.' </span>记录被添加</p>';
		return $feedback;
	}


	function __addReportLike($rp_cid, $rp_titlen, $rp_urln, $rp_like){
		global $db;
		$add_report = 0;
		$rp_titlef = trim($rp_titlen);
		$rp_title = empty($rp_titlef) ? '报表项目' : $rp_titlef;
		$rp_url = trim($rp_urln);

		if(!empty($rp_cid)){
			$rp_config = ''; 
			$rp_config_group = array();
			$rp_index = ''; 
			$rp_mark = ''; 
			$rp_interval = ''; 
			$rp_start = '';
			$newSuid_arr = array();
			$oldSuid_arr = array();
			$add_mods = 0;
			if(!empty($rp_like)){
				$likeReport =  $db->row("SELECT rp_config, rp_index, rp_mark, rp_interval, rp_start FROM report_layout WHERE rp_cid = :rp_cid ", array('rp_cid' => $rp_like));
				$likeConfig = $likeReport['rp_config'];
				$modsGroup = explode("%", $likeConfig);
				foreach($modsGroup as $i => $mod){
					$tmpArr = explode('|', $mod);
					array_push($oldSuid_arr, $tmpArr[4]);
					$tmpArr[4] = __createSuid();
					array_push($newSuid_arr, $tmpArr[4]);
					$tmpStr = implode('|', $tmpArr);
					array_push($rp_config_group, $tmpStr);
				}
				$rp_config = implode('%', $rp_config_group);
				$rp_index = $likeReport['rp_index']; 
				$rp_mark = $likeReport['rp_mark'];
				$rp_interval = $likeReport['rp_interval']; 
				$rp_start = $likeReport['rp_start'];
			}
			$add_report = $db->query("INSERT INTO report_layout(rp_cid, rp_title, rp_url, rp_config, rp_index, rp_mark, rp_interval, rp_start) VALUES(:rp_cid, :rp_title, :rp_url, :rp_config, :rp_index, :rp_mark, :rp_interval, :rp_start)",array("rp_cid"=>$rp_cid, "rp_title"=>$rp_title, "rp_url"=>$rp_url, "rp_config"=>$rp_config, "rp_index" => $rp_index, "rp_mark" => $rp_mark, "rp_interval" => $rp_interval, "rp_start" => $rp_start));

			if($add_report == 1 && !empty($rp_like)){
				$insertSql = 'insert into sql_tpl(sql_content, sql_key, mod_config, suid, pre_sql) ';
				foreach($oldSuid_arr as $j => $suid){
					$union = $j > 0 ? ' union ' : '';
					$insertSql .=  $union.'select sql_content, "'.$rp_cid.'" as sql_key, mod_config, "'.$newSuid_arr[$j].'" as suid, pre_sql from sql_tpl where suid = "'.$suid.'"';
				}
				$add_mods = $db->query($insertSql);
			}
		}
		$feedback = '<p>报表:<span style="color:#0080C0"> '.$add_report.' </span>记录被添加</p><p>控件:<span style="color:#0080C0"> '.$add_mods.' </span>记录被添加</p>';
		return $feedback;
	}


	function __delReport($rp_cid){
		global $db;
		$del_reports = 0;
		$del_mods = 0;
		$del_binds = 0;
		if(!empty($rp_cid)){
			$del_reports = $db->query("DELETE FROM report_layout WHERE rp_cid = :rp_cid",array("rp_cid"=>$rp_cid));
			$del_mods = $db->query("DELETE FROM sql_tpl WHERE sql_key = :rp_cid",array("rp_cid"=>$rp_cid));
			$del_binds = $db->query("DELETE FROM game_report WHERE rp_cid = :rp_cid",array("rp_cid"=>$rp_cid));
		}
		$feedback = '<p>报表:<span style="color:#0080C0"> '.$del_reports.' </span>记录被删除</p><p>控件:<span style="color:#0080C0"> '.$del_mods.' </span>记录被删除</p><p>关联:<span style="color:#0080C0"> '.$del_binds.' </span>记录被删除</p>';
		return $feedback;
	}

	function __updReportLayout($rp_cid, $rp_config, $rp_rm, $rp_title, $rp_interval, $rp_start, $rp_list){
		global $db;
		$rp_rmarr = explode("%", $rp_rm);
		$rp_rmarr_len = count($rp_rmarr);
		$sql_path = '(';
		if($rp_rmarr_len > 0){
			for($i=0; $i<$rp_rmarr_len; $i++){
				$and = $i == 0 ? '' : ' and ';
				$sql_path .= $and . 'suid != "' . $rp_rmarr[$i] .'"';
			}
		}
		$sql_path .= ')';
		$upd_layout = $db->query("UPDATE report_layout SET rp_config = :rp_config, rp_title = :rp_title, rp_interval = :rp_interval, rp_start = :rp_start, rp_list = :rp_list WHERE rp_cid = :rp_cid",array("rp_config"=>$rp_config, "rp_title"=>$rp_title, "rp_cid"=>$rp_cid, "rp_interval"=>$rp_interval, "rp_start"=>$rp_start, "rp_list"=>$rp_list));
		$del_mod = $db->query("DELETE FROM sql_tpl WHERE sql_key = :rp_cid and ".$sql_path, array("rp_cid"=>$rp_cid));

		$feedback = '<p>报表:<span style="color:#0080C0"> '.$upd_layout.' </span>记录被更新</p><p>控件:<span style="color:#0080C0"> '.$del_mod.' </span>记录被删除</p>';
		return $feedback;
	}

	function __updReportUrl($rp_cid, $rp_title, $rp_url){
		global $db;
		$upd_layout = $db->query("UPDATE report_layout SET rp_title = :rp_title, rp_url = :rp_url WHERE rp_cid = :rp_cid",array("rp_title"=>$rp_title, "rp_cid"=>$rp_cid, "rp_url"=>$rp_url));

		$feedback = '<p>报表:<span style="color:#0080C0"> '.$upd_layout.' </span>记录被更新</p>';
		return $feedback;
	}


	function __getReportDetail($rp_cid){
		global $db;
		$feedback = '';
		$reportDetail = $db->row("SELECT * FROM report_layout WHERE rp_cid = :rp_cid", array("rp_cid"=>$rp_cid));
		if($reportDetail){
			$feedback = '<table id="rpTbl" border="0"><tr><th>id</th><th>标题</th><th>cid(sql_key)</th></tr><tr><td class="sdc">'.$reportDetail['id'].'</td><td class="sdc">'.$reportDetail['rp_title'].'</td><td class="sdc">'.$reportDetail['rp_cid'].'</td></tr></table>';
			// $feedback = ('&nbsp;&nbsp;'.$reportDetail['id'].'&nbsp;&nbsp;&brvbar;&nbsp;&nbsp;'.$reportDetail['rp_title'].'&nbsp;&nbsp;&brvbar;&nbsp;&nbsp;'.$reportDetail['rp_cid']);
		}
		return $feedback;
	}


	function __getGamesList($rp_cid){
		global $db;
		$feedback = '';
		$tmp = '';
		$games = $db->query("SELECT gamename, gamecode FROM game");
		$reportGames = $db->column("SELECT gamecode FROM game_report WHERE rp_cid = :rp_cid", array("rp_cid"=>$rp_cid));
		$reportGames = $reportGames ? $reportGames : array();
		foreach($games as $game){
			$gamecode = $game['gamecode'];
			$gamename = $game['gamename'];
			$checked = in_array($gamecode, $reportGames) ? 'checked' : '';
			$tmp .= '<li><input type="checkbox" class="gamecode" value="'.$gamecode.'" '.$checked.'>'.$gamename.'</li>';
		}
		if($tmp != ''){
			$feedback = '<ul class="clearfix">'.$tmp.'</ul><input name="rp_cid" type="hidden" value="'.$rp_cid.'">';
		}
		return $feedback;
	}


	function __reportGamesSave($rp_cid, $gamecodestr){
		global $db;
		$feedback = '';
		$gamecodes = explode(",", $gamecodestr);
		$insertValueStr = '';
		foreach ($gamecodes  as $i => $gamecode) {
			$dot = $i > 0 ? ',' : ''; 
		 	$insertValueStr .= $dot.'("'.$gamecode.'","'.$rp_cid.'")';
		} 
		
		$del_reportgames = $db->query("DELETE FROM game_report WHERE rp_cid = :rp_cid",array("rp_cid"=>$rp_cid));
		$add_reportgames = $db->query("INSERT INTO game_report(gamecode, rp_cid) VALUES $insertValueStr");
		$feedback = '<p>该报表绑定了<span style="color:#0080C0"> '.$add_reportgames.' </span>个游戏</p>';
		return $feedback;
	}



	function __getModSetting($suid, $sql_key){
		global $db;

		$mod = array('detail_config' => '', 'detail_sql' => '', 'record_type' => '', 'detail_sqlp' => '');
		$detail_itm = $db->row("SELECT * FROM sql_tpl WHERE suid = :suid AND sql_key = :sql_key", array("suid"=>$suid, "sql_key"=>$sql_key));
		if($detail_itm){
			$mod['detail_config'] = $detail_itm['mod_config'];
			$mod['detail_sqlp'] = $detail_itm['pre_sql'];
			$mod['detail_sql'] =  $detail_itm['sql_content'];
			$mod['record_type'] = 'already exists';
		}else{
			$add_mod = $db->query("INSERT INTO sql_tpl(suid, sql_key) VALUES(:suid, :sql_key)", array("suid"=>$suid, "sql_key"=>$sql_key));
			$mod['record_type'] = $add_mod == 1 ? 'new add' : 'add failed';
		}
		return $mod;
	}

	function __updModSetting($mod_config, $sql_key, $sqlt, $suid, $sqltp){
		global $db;
		$upd_layout = $db->query("UPDATE sql_tpl SET mod_config = :mod_config, sql_key = :sql_key, sql_content = :sqlt, pre_sql = :sqltp WHERE suid = :suid",array("mod_config" => $mod_config, "sql_key" => $sql_key, "sqlt" => $sqlt, "suid" => $suid, "sqltp" => $sqltp));

		$feedback = '<p>控件:<span style="color:#0080C0"> '.$upd_layout.' </span>记录被更新</p>';
		return $feedback;
	}


	function __createSuid(){ 
		$str = md5(uniqid(mt_rand(), true));  
   		$uuid  = substr($str,0,4) . '-' . substr($str,4,8);
   		return $uuid;
	}


	function __getGames(){
		global $db;
		$feedback = '';
		$tmp = '';
		$games = $db->query("SELECT * FROM game");
		foreach ($games as $i => $game){
			$pltcount = 0;
			$class = '';
			if($i%3 == 0){
				if($i%6 == 0){
					$class = 'sixth';
				}else{
					$class = 'third';
				}
			}
			if($game['pltlist']){
				$pltlist = explode(',',$game['pltlist']);
				$pltcount = count($pltlist);
			} 
			$tmp .= '<tr class="'.$class.'"><td>'.$game['gameid'].'</td><td>'.$game['gamename'].'</td><td>'.$game['gamecode'].'</td><td class="taleft">'.$game['pltlist'].'</td><td>'.$pltcount.'</td><td>'.$game['gametype'].'</td><td><a href="game_reports.php?gamecode='.$game['gamecode'].'"><button>关联</button></a></td></tr>';
		}
		$feedback = '<table id="gamesList"><tr><th style="width:60px">id</th><th style="width:120px">名称</th><th style="width:60px">代码</th><th style="width:780px">平台代码</th><th  style="width:60px">平台数</th><th  style="width:60px">类型</th><th  style="width:60px">操作</th></tr>'.$tmp.'</table>';
		return $feedback;
	}


	function __getGameDetail($gamecode){
		global $db;
		$feedback = '';
		$GameDetail = $db->row("SELECT * FROM game WHERE gamecode = :gamecode", array("gamecode"=>$gamecode));
		if($GameDetail){
			$feedback = '<table id="rpTbl" border="0"><tr><th>id</th><th>标题</th><th>gamecode</th></tr><tr><td class="sdc">'.$GameDetail['gameid'].'</td><td class="sdc">'.$GameDetail['gamename'].'</td><td class="sdc">'.$GameDetail['gamecode'].'</td></tr></table>';
		}
		return $feedback;
	}

	function __getReportsList($gamecode){
		global $db;
		$feedback = '';
		$tmp = '';
		$reports = $db->query("SELECT rp_cid, rp_title FROM report_layout");
		$gameReports = $db->column("SELECT rp_cid FROM game_report WHERE gamecode = :gamecode", array("gamecode"=>$gamecode));
		$gameReports = $gameReports ? $gameReports : array();
		foreach($reports as $report){
			$rp_cid = $report['rp_cid'];
			$rp_title = $report['rp_title'];
			$checked = in_array($rp_cid, $gameReports) ? 'checked' : '';
			$orgCheckClass = $checked != '' ? 'class="original"' : '';
			$tmp .= '<li '.$orgCheckClass.'><input type="checkbox" class="rpcid" value="'.$rp_cid.'" '.$checked.'>'.$rp_title.'</li>';
		}
		if($tmp != ''){
			$feedback = '<ul class="clearfix">'.$tmp.'</ul><input name="gamecode" type="hidden" value="'.$gamecode.'">';
		}
		return $feedback;
	}

	function __gameReportsSave($gamecode, $rpcidstr){
		global $db;
		$feedback = '';
		$rp_cids = explode(",", $rpcidstr);
		$insertValueStr = '';
		foreach ($rp_cids  as $i => $rp_cid) {
			$dot = $i > 0 ? ',' : ''; 
		 	$insertValueStr .= $dot.'("'.$gamecode.'","'.$rp_cid.'")';
		} 
		
		$del_reportgames = $db->query("DELETE FROM game_report WHERE gamecode = :gamecode",array("gamecode"=>$gamecode));
		$add_reportgames = $db->query("INSERT INTO game_report(gamecode, rp_cid) VALUES $insertValueStr");
		$feedback = '<p>该报游戏定了<span style="color:#0080C0"> '.$add_reportgames.' </span>个报表</p>';
		return $feedback;
	}


	function __getUrlInfo($rp_cid){
		global $db;
		$feedback = '';
		$urlInfTtl = '';
		$urlInfoDom = '<div class="c_wrap"><form action="url_setting_save.php" method="post" name="url_save">';
		$urlSqlDom = '<form action="url_setting_save.php" method="post"><div class="c_wrap"><p><input type="hidden" value="'.$rp_cid.'" name="rp_cid"><input type="hidden" value="1" name="addsql"><input type="submit" value="增加一条SQL"></p></form>';
		$urlInfo = $db->row("SELECT * FROM report_layout WHERE rp_cid = :rp_cid ", array('rp_cid' => $rp_cid));
		$urlInfTtl = '<p>报表：'.$urlInfo['rp_title'].' ('.$rp_cid.')</p>';
		$urlInfoDom .= '<p>标题：<input name="rp_title" class="report-ttl rpipt" type="text" value="'.$urlInfo['rp_title'].'"></p>';
		$urlInfoDom .= '<p>cid：<?php echo $rp_cid; ?><input name="rp_cid" type="hidden" value="'.$rp_cid.'">'.$rp_cid.'</p>';
		$urlInfoDom .= '<p>指定URL：<input name="rp_url" class="report-itv rpipt" style="width:500px" type="text" value="'.$urlInfo['rp_url'].'"></p>';
		$urlInfoDom .= '<p><input type="submit" value="保存"><a href="report_setting.php"><button>返回</button></a></p></form></div>';

		$urlSqls = $db->query("SELECT * FROM sql_tpl WHERE sql_key = :rp_cid ", array('rp_cid' => $rp_cid));
		$urlSqlDom .= '<ul>';
		foreach ($urlSqls  as $i => $urlSql) {
			$urlSqlDom .= '<li>'.($i+1).'&nbsp;<a href="urlsql_setting.php?suid='.$urlSql['suid'].'&rp_cid='.$rp_cid.'">SQL#'.$urlSql['id'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;<form onsubmit="return confirmDelete()" action="url_setting_save.php" method="post" class="forminline"><input type="hidden" value="'.$urlSql['suid'].'" name="suid"><input type="hidden" value="1" name="delsql"><input type="hidden" value="'.$rp_cid.'" name="rp_cid"><input type="submit" value="删除"></form></li>';
		} 
		$urlSqlDom .= '</ul></div>';
		$feedback = $urlInfTtl . $urlInfoDom . $urlSqlDom;
		return $feedback;
	}


	function __addReportUrlSql($rp_cid){
		global $db;
		$newSuid = __createSuid();
		$add_urlsql = $db->query("INSERT INTO sql_tpl(sql_name, sql_key, suid) VALUES ('custom', '$rp_cid', '$newSuid')");
		$feedback = '<p>控件:<span style="color:#0080C0"> '.$add_urlsql.' </span>记录被添加</p>';
		return $feedback;
	}


	function __delReportUrlSql($suid, $rp_cid){
		global $db;
		$del_urlsql = $db->query("DELETE FROM sql_tpl WHERE suid = '$suid' and sql_key = '$rp_cid'");
		$feedback = '<p>控件:<span style="color:#0080C0"> '.$del_urlsql.' </span>记录被删除</p>';
		return $feedback;
	}

	function __getModSql($suid, $rp_cid){
		global $db;
		$feedback = '';
		$mod_urlsql = $db->row("SELECT * FROM sql_tpl WHERE suid = :suid and sql_key = :rp_cid", array('suid' => $suid, 'rp_cid' => $rp_cid));
		$sql_type = empty($mod_urlsql['sql_name']) ? '默认' : $mod_urlsql['sql_name'];
		$feedback .= '<form id="ModSqlForm" action="urlsql_setting_save.php" method="post">';
		$feedback .= '<h3>当前控件SQL</h3><p>所属：'.$mod_urlsql['sql_key'].'</p><p>ID：'.$mod_urlsql['id'].'</p><p>SUID：'.$mod_urlsql['suid'].'</p><p>类型：'.$sql_type.'</p><p>SQL1</p>';
		$feedback .= '<textarea id="Sql1">'.$mod_urlsql['sql_content'].'</textarea>';
		$feedback .= '<p>SQL2</p>';
		$feedback .= '<textarea id="Sql2">'.$mod_urlsql['pre_sql'].'</textarea>';
		$feedback .= '<input type="hidden" value="'.$suid.'" name="suid"><input type="hidden" value="'.$rp_cid.'" name="rp_cid">';
		$feedback .= '<input type="hidden" value="" name="sql1"><input type="hidden" value="" name="sql2">';
		$feedback .= '</form>';
		$feedback .= '<p><button id="saveModSql">保存</button></p>';
		return $feedback;
	}

	function __saveModSql($suid, $rp_cid, $sql1, $sql2){
		global $db;
		$sav_modsql = $db->query('UPDATE sql_tpl SET sql_content = "'.$sql1.'", pre_sql = "'.$sql2.'" WHERE sql_key = "'.$rp_cid.'" and suid = "'.$suid.'"');
		$feedback = '<p>控件:<span style="color:#0080C0"> '.$sav_modsql.' </span>记录被更新</p>';
		return $feedback;
	}


	function __checkAccess($requireArgs){
		$rejectMsg = '';
		if(!empty($_SESSION['admin'])){
			if($_SESSION['admin']['level'] == 1){
				$requireArgs_len = count($requireArgs);
				if($requireArgs_len > 0){
					for($i=0; $i<$requireArgs_len; $i++){
						if(!isset($_GET[$requireArgs[$i]])){
							$rejectMsg = '访问参数有误';
							break;
						}
					}
				}
			}else{
				$rejectMsg = '没有权限访问，请用管理员账号<a href="../login.php">登录</a>';
			}
		}else{
			$rejectMsg = '未登录或登录超时，可以<a href="../login.php">在此登录</a>';
		}
		return $rejectMsg;
	}



	function __checkSaveAccess($requireArgs, $tag){
		$rejectMsg = '';
		if(!empty($_SESSION['admin'])){
			if($_SESSION['admin']['level'] == 1){
				if(isset($_SESSION['rp_tag']) && $_SESSION['rp_tag'] == $tag){
					$requireArgs_len = count($requireArgs);
					if($requireArgs_len > 0){
						for($i=0; $i<$requireArgs_len; $i++){
							if(!isset($_POST[$requireArgs[$i]])){
								$rejectMsg = '访问参数有误';
								break;
							}
						}
					}
				}else{
					$rejectMsg = '页面重复提交';
				}
			}else{
				$rejectMsg = '没有权限访问，请用管理员账号<a href="../login.php">登录</a>';
			}
		}else{
			$rejectMsg = '未登录或登录超时，可以<a href="../login.php">在此登录</a>';
		}
		return $rejectMsg;
	}






