<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">  
	<title>报表</title>

	<!-- Bootstrap core CSS -->
	<link href="resource/lib/bootstrap/bootstrap.css?t=20140514" rel="stylesheet">
	<!-- Add custom CSS here -->
	<link href="resource/css/admin.css?t=20140514" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesnt work if you view the page via file: -->
	<!--[if lt IE 9]>
	<script src="resource/lib/revise/html5shiv.min.js"></script>
	<script src="resource/lib/revise/respond.min.js"></script>
	<![endif]-->

	<!-- add on -->
	<link rel="stylesheet" href="resource/plugins/mmgrid/css/mmGrid-c.css?t=20140514">
	<link rel="stylesheet" href="resource/plugins/bootstrap-datepicker/css/datepicker3.css?t=20140514">

	<script src="resource/lib/jquery/jquery-1.9.1.min.js?t=20140514"></script>
	<script src="resource/lib/jquery/json2.js?t=20140514"></script>
	<script src="resource/lib/bootstrap/bootstrap.js?t=20140514"></script>
	<script src="resource/plugins/highcharts/highcharts.js?t=20140519"></script>
	<script src="resource/plugins/highcharts/highcharts-more.js?t=20140519"></script>
	<script src="resource/plugins/highcharts/exporting.src.js?t=20140514"></script>
	<script src="resource/plugins/mmgrid/js/mmGrid2.js?t=20140611"></script>
	<script src="resource/plugins/bootstrap-daterangepicker/moment.min.js?t=20140514"></script>
	<script src="resource/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js?t=20140514"></script>
	 
	<style type="text/css">
		.panel-body{ padding: 0 0 2px 0;}
		.panel-title{font-weight: bold; font-size: 14px}
		.panel-heading{ padding: 4px 10px}
		.panel-heading .ctrl-icon{float: right; cursor: pointer}

		.panel-primary .ctrl-row{ padding:4px 8px}
		.panel-primary .glyphicon-th{ font-size: 15px}
		.panel-primary .ctrl-wrap{padding:4px 0}
		.panel-primary .ctrl-label{line-height:32px}
		.panel-primary .mod-error{ padding: 14px 0; text-align: center}
		.panel-primary .dp-mod{ margin-top: 2px}

		.panel-body .btnfm{ margin-bottom: 8px}
		.panel-title .ctrl-title{ cursor: pointer}
	</style>
</head>
<body style="margin:0">

	<?php
		include_once "../../RPL/rps_frame_detail.php";
		
		session_start();
    	if(empty($_SESSION['admin'])) header('location:rp_error.php?et=nologin');
 		$rp_cid = isset($_GET['rp_cid']) ? $_GET['rp_cid'] : '';

 		$layout_config = '';
 		$report_list = '';
 		$content = '';

 		if($rp_cid){
 			$report_item = __REPORT_MODS($rp_cid);
 			$layout_config =  isset($report_item['rp_config']) ? $report_item['rp_config'] : '';
 			$interval_config = isset($report_item['rp_interval']) ? $report_item['rp_interval'] : 7;
 			$start_config = isset($report_item['rp_start']) ? $report_item['rp_start'] : 0;
 			$df_server_sel = isset($report_item['rp_list']) ? $report_item['rp_list'] : 0;
			if($layout_config){
	 			$layout_config_arr = explode("%", $layout_config);
	 			$content .= '<div class="row">';
	 			$area_count = 0;
	 			$ajaxMods_count = 0;
	 			foreach ($layout_config_arr as $mod_items){
	 				$mod_item = explode("|", $mod_items);
	 				$area = (int)$mod_item[0];
					$height = $mod_item[1];
					$mtype = $mod_item[2];
					$title = $mod_item[3];
					$suid = $mod_item[4];
					$loadtype = $mod_item[5];
					$area_count += $area;

					$mod_item_detail = __MOD_DETAIL($suid);
					$sql_id = isset($mod_item_detail['id']) ? $mod_item_detail['id'] : '';
					$sql_key = isset($mod_item_detail['sql_key']) ? $mod_item_detail['sql_key'] : '';
					$sql_content = isset($mod_item_detail['sql_content']) ? '1' : '';
					$mod_config = isset($mod_item_detail['mod_config']) ? $mod_item_detail['mod_config'] : '';

					if($loadtype == 'ajax'){
						$ajaxMods_index = $ajaxMods_count;
						$ctrl_icon =  '<span onclick="__renderAjaxMods('.$ajaxMods_index.')" style="float:right;" class="ctrl-icon glyphicon glyphicon-refresh"></span>';
						$ajaxMods_count++;
					}else{
						$ajaxMods_index = '';
						$ctrl_icon = '';
					}

					if($area_count > 4) {
						$content .= '</div><div class="row">';
						$area_count = $area;
					}
					$area_num = $area * 3;
					$content .= '<div class="col-lg-'.$area_num.'"><div class="panel panel-primary"><div class="panel-heading"><h4 class="panel-title" data-ajaxmodsindex="'.$ajaxMods_index.'"> <i class="glyphicon glyphicon-th-large"></i>&nbsp;'.'<span class="ctrl-title">'.$title.'</span>'.$ctrl_icon.'</h4></div><div class="panel-body"><div style="width:100%; min-height:'.$height.'px" class="report-mod" data-mtype="'.$mtype.'" data-config="'.$mod_config.'" data-sqlid="'.$sql_id.'" data-sqlkey="'.$sql_key.'" data-sqlcontent="'.$sql_content.'" data-loadtype="'.$loadtype.'" data-area="'.$area_num.'"></div></div></div></div>';
				}
				$content .= '</div>';
	 		}else{
	 			$content .= '<div><p style="text-align: center">该页面还未定义布局</p></div>';
	 		}
 		}else{
 			header('location:rp_error.php?et=noselectreport');
 		}
 	?>

	<div class="row" id="rpHeader" data-interval="<?php echo $interval_config; ?>" data-start="<?php echo $start_config; ?>" data-defserverlist="<?php echo $df_server_sel; ?>">
		<div class="col-lg-12">
			<h1>
				<small id="curGameTitle"></small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"> <i class="glyphicon glyphicon-map-marker"></i>
					当前位置 :
				</li>
			</ol>
		</div>
	</div>
	<?php echo $content; ?>
<script type="text/javascript" src="resource/js/parser.js?t=20140804"></script>
<script type="text/javascript" src="resource/js/rp.js?t=20140804"></script>
</body>
</html>
