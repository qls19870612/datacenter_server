<?php

//setting
require("pdodb/Db.class.php");
$db = new Db();

function __GAME_SELECTOR ($selected_game, $AllowGame){
	global $db;
    $selectedGame = $selected_game ? $selected_game : '';
    $allowGame = ($AllowGame && is_array($AllowGame)) ? $AllowGame : array();
    $curGameEffective = in_array($selectedGame, $allowGame);

    if(count($allowGame) > 0){
	//获取游戏列表详细信息
	    $where_str = '';
	    foreach ($allowGame as $i => $gam) {
	      $where_str .= $i > 0 ? (' OR gamecode = "'.$gam.'"') : ('gamecode = "'.$gam.'"');
	    }
	    $_GAMELISTDETAIL = $db->query("SELECT * FROM game WHERE $where_str ORDER BY gametype");

	    
	    $g_curgamecode = $selectedGame;
	    $g_curgamename = '';
	    $g_selectgamepopover = '<div style="display:none" id="selectGamePopover"><div style="width:240px" class="sgp_wrap"><div class="table-responsive"><table class="table"><tbody><tr>';
	    $ccl = count($_GAMELISTDETAIL) - 1;
	    foreach ($_GAMELISTDETAIL as $i => $gamd) {
	      $g_match = $gamd['gamecode'] == $g_curgamecode ? true : false;
	      if($g_match) $g_curgamename = $gamd['gamename'];
	      $g_curgamemark = $g_match ? 'selected' : '';
	      $tmp = '<td width="33.3%" data-gameid="'.$gamd['gamecode'].'" class="changeGame '.$g_curgamemark.'"><a href="?sgame='.$gamd['gamecode'].'"><img style="width:50px; height:50px" class="img-rounded" alt="'.$gamd['gamename'].'" src="resource/images/game_logo/'.$gamd['gamecode'].'.jpg"><p style="text-align: center;">'.$gamd['gamename'].'</p></a></td>';
	      $g_selectgamepopover .= ($i != $ccl && $i % 3 == 2) ? ($tmp.'</tr><tr>') : $tmp;
	    }
	    $g_selectgamepopover .='</tr></tbody></table></div></div></div>';

	    if(!$selectedGame){
	      $g_curgamesta = '<p id="nosgtip" style="text-align:center;padding:14px;">(在此选择游戏)</p>';
	    }else if(!$curGameEffective){
	      $g_curgamesta = '<p id="nosgtip" style="text-align:center;padding:8px; font-size:12px">游戏不存在或没权限<br>(在此重选游戏)</p>';
	    }else{
	      $g_curgamesta = '<div class="icon_wrap"><img src="resource/images/game_logo/'.$g_curgamecode.'.jpg" alt="#"></div><div class="gamename"><p>'.$g_curgamename.'<span>&nbsp;&nbsp;▼</span></p></div>';
	    }
	    $g_selecter = '<div class="selecter clearfix"><a id="GameList" href="javascript:void(0)" data-curgame="'.$g_curgamecode.'">'.$g_curgamesta.'</a></div>';

	    return $g_selecter . $g_selectgamepopover;
	}else{
		return '';
	}
}


function __LOGIN_CONTROLLER ($login, $nickname='', $clientip=''){
	// $host = $_SERVER["HTTP_HOST"];
	// $require = 'http://'.$host.'/index.php?controller=index&method=chgpwd';
	if($login){
		return '<li class="dropdown user-dropdown" id="loginInfo"><a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0)"> <i class="fa fa-user"></i>&nbsp;<span id="userName">'.$nickname.'</span> <b class="caret"></b></a><ul class="dropdown-menu"><li style=" font-size: 12px; margin-left: 20px; padding-top:5px; width: 160px;" class="message-preview"><p class="dec">你的IP是：<span id="userIp">'.$clientip.'</span></p><p class="dec"><span class="time" id="currentTime"></span></p></li><li class="divider"></li><li><a href="../index.php?controller=index&method=chgpwd" target="_blank"><i class="fa fa-gear"></i>&nbsp;修改密码</a></li><li><a href="javascript:__userLogout()"><i class="fa fa-power-off"></i>&nbsp;退出登录</a></li></ul></li>';
	}else{
		return '<li id="loginBtn"><a data-target="#loginPopups" data-toggle="modal" style="padding-left:30px; padding-right:30px" href="javascript:void(0)"> <i class="fa fa-sign-in fa-2"></i>&nbsp;登录</a></li>';
	}
}


// disabled
function __GAME_REPORTS ($selectedGame){
	global $db;
	$ALLGAMEREPORT = '';
	$ALLGAMEREPORTURL = '';
	if($selectedGame){
		$all_grl = $db->query("SELECT * FROM game_report INNER JOIN report_layout on game_report.rp_cid = report_layout.rp_cid WHERE gamecode = :gamecode", array("gamecode"=>$selectedGame));
		foreach ($all_grl as $i => $grl) {
			$commo = $i > 0 ? ',' : '';
			$ALLGAMEREPORT .= $commo.$grl['rp_cid'];
			$ALLGAMEREPORTURL .= $commo.$grl['rp_url'];
		}
	}
	$gameReport = ' data-allgamereport="'.$ALLGAMEREPORT.'" data-allgamereporturl="'.$ALLGAMEREPORTURL.'"';
	return $gameReport;
}

function __GAME_PLATFORM ($level, $selectedGame, $AllowPlatform){
	global $db;
	$dom = '';
	$tab_dom = '';
	$list_dom = '';
	$tabcount = 0;
	$list_arr = array();
	if($level == 1){
		//超级用户
		$_PLATFORMLIST = $db->query('SELECT * FROM game_server WHERE gamecode = "'.$selectedGame.'" ORDER BY platform, worldid');
	}elseif($level == 0){
		//普通用户
		if(count($AllowPlatform) > 0){
			$where_str = '';
			foreach ($AllowPlatform as $k => $v) {
				$or = $k > 0 ? ' OR ' : '';
				$where_str .= $or . 'platform = "' . $v . '"';
			}
			$_PLATFORMLIST = $db->query('SELECT * FROM (SELECT * FROM game_server WHERE gamecode = "'.$selectedGame.'") AS gameplatform WHERE '.$where_str.' ORDER BY platform, worldid');
		}else{
			$_PLATFORMLIST = array();
		}
	}
    if (!empty($_PLATFORMLIST)) {
        if(count($_PLATFORMLIST) > 0){
            foreach ($_PLATFORMLIST as $platform) {
                $pf_code = $platform['platform'];
                $pf_wid = $platform['worldid'];
                $pf_sn = $platform['servername'];
                if(!isset($list_arr[$pf_code])){
                    $list_arr[$pf_code] = '';
                }
                $list_arr[$pf_code] .= '<li class="col-ct-2"><p class="sitm" name="sid_'.$pf_code.'" data-val="'.$pf_wid.'">'.$pf_sn.'</p></li>';
            }
            foreach ($list_arr as $pf_code => $pf_itm) {
                $markact = $tabcount > 0 ? '' : 'active';
                $tab_dom .= '<li class="'.$markact.'"><a data-toggle="tab" href="#t_'.$pf_code.'" class="tab-title">'.$pf_code.'(<span>0</span>)</a></li>';
                $list_dom .= '<div data-plt="'.$pf_code.'" id="t_'.$pf_code.'" class="tab-pane '.$markact.'"><ul class="select-group clearfix">'.$pf_itm.'</ul></div>';
                $tabcount ++;
            }
        }
    }
	$dom .= '<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="serverList" class="modal fade in" style="display: none;"><div class="modal-dialog modal-dialog-lg"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><ul id="selectTab" class="nav nav-tabs">'.$tab_dom.'</ul></div><div class="modal-body"><div class="tab-ctrl clearfix"><div class="btn-group"><button data-btntype="selectAll" class="btn btn-default btn-sm selCtrl" type="button">全选</button><button data-btntype="antiElection" class="btn btn-default btn-sm selCtrl" type="button">反选</button></div><button data-dismiss="modal" class="btn btn-primary btn-sm pull-right selCtrl" type="button" data-btntype="sumbit">确定</button></div><div id="serverGroup" class="tab-content">'.$list_dom.'</div></div><div class="modal-footer"><div class="btn-group pull-left"><button data-btntype="selectAll" class="btn btn-default btn-sm selCtrl" type="button">全选</button><button data-btntype="antiElection" class="btn btn-default btn-sm selCtrl" type="button">反选</button></div><button data-dismiss="modal" class="btn btn-primary btn-sm selCtrl" type="button" data-btntype="sumbit">确定</button></div></div></div></div>';

	return $dom;
}


function __GET_CLIENT_IP(){
	$clientip = '';
	if (getenv("HTTP_CLIENT_IP"))
		$clientip = getenv("HTTP_CLIENT_clientip");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$clientip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
		$clientip = getenv("REMOTE_ADDR");
	else 
		$clientip = "Unknow";
	return $clientip;
}


function __GAMES_LIST($login, $level, $AllowGame){
	global $db;
	$_GAMELISTDETAIL = $db->query("SELECT * FROM game ORDER BY gametype");
	$cats = array();
	$itmsGroup = array();
	$count = 0;
	foreach ($_GAMELISTDETAIL as $i => $game) {
		$g_type = $game['gametype'];
		if($i > 0){
			if($cats[$count] != $g_type){
				$count++;
				$cats[$count] = $g_type;
				$itmsGroup[$count] = array();
			}
		}else{
			$cats[$count] = $g_type;
			$itmsGroup[$count] = array();
		}
		array_push($itmsGroup[$count], $game);
	}
	$dom = '';
	foreach ($itmsGroup as $j => $itms) {
		$in = $j > 0 ? '' : 'in';
		$itms_str = '<div id="page_'.$j.'" class="catalog collapse panel-collapse '.$in.' "><div class="addpadding row"><div class="col-lg-6"><div class="row">';
		$last = count($itms) - 1;
		foreach ($itms as $k => $itm) {
			$invalid = ($login && !in_array($itm['gamecode'], $AllowGame)) ? 'invalid' : '';
			$itms_str.= '<div data-gameid="'.$itm['gamecode'].'" class="col-xs-4 g_item_w itm_game '.$invalid.'"><div class="g_item"><img alt="#" src="resource/images/game_logo/large/'.$itm['gamecode'].'.jpg" class="img-responsive"><p class="g_title">'.$itm['gamename'].'</p></div></div>';
			if($k != $last){
				if($k%6 == 2){
					$itms_str .= '</div></div><div class="col-lg-6"><div class="row">';
				}elseif($k%6 == 5){
					$itms_str .= '</div></div></div><div class="addpadding row"><div class="col-lg-6"><div class="row">';
				}
			}
		}
		$itms_str .= '</div></div></div></div>';
		$dom .= '<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title cat_title"><a href="#page_'.$j.'" data-parent="#accordion" data-toggle="collapse">'.__transGameType($cats[$j]).'游戏</a></h3></div>'.$itms_str.'</div>';
	}
	return $dom;
}

function __transGameType($gametype){
	$typeName = '';
	switch ($gametype)
	{
	case 1:
	  $typeName = "网页";
	  break;
	case 2:
	  $typeName = "手机";
	  break;
	case 3:
	  $typeName = "客户端";
	  break;
	default:
	  $typeName = "其他";
	}
	return $typeName;
}

function __MORE_MENU(){
	$dom = '';
	$head = '';
	$cons = '';
	$menus  = func_get_args();

	if(count($menus) > 0){
		foreach ($menus as $i => $menu) {
			$len = count($menu['items']);
			if($len > 0){
				$last = $len - 1;
				$head = '<div class="panel-heading"><h3 class="panel-title cat_title"><a href="#tp_'.$i.'" data-toggle="collapse">'.$menu['title'].'</a></h3></div>';

				$cons = '<div id="tp_'.$i.'" class="catalog panel-collapse collapse" style="height: auto;"><div class="addpadding row"><div class="col-lg-6"><div class="row">';

				foreach ($menu['items'] as $j => $item) {

					$cons.= '<div class="col-xs-4 g_item_w"><a target="_blank" href="'.$item['link'].'"><div class="g_item"><img alt="#" src="resource/'.$item['icon'].'" class="img-responsive"><p class="g_title">'.$item['title'].'</p></div></a></div>';
					
					if($j != $last){
						if($j%6 == 2){
							$cons .= '</div></div><div class="col-lg-6"><div class="row">';
						}elseif($j%6 == 5){
							$cons .= '</div></div></div><div class="addpadding row"><div class="col-lg-6"><div class="row">';
						}
					}
				}
				$cons .= '</div></div></div></div>';
				$dom .= '<div class="container_m ordermenu"><div class="panel panel-default">'.$head.$cons.'</div></div>';
			}
			
		}
		
	}
	
	return $dom;
}








