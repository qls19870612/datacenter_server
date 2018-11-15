<!DOCTYPE html>
<html>
<?php include_once 'mng_g_h.php'; ?>
<body>
	<?php
		include_once "../../../RPL/rps_mng.php";	
		require("../../../RPL/pdodb/easyCRUD/report_layout.class.php");
		$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		
		session_start();
		$rp_tag = 'layout_setting';
		$_SESSION['rp_tag'] = $rp_tag;


		$tips_er = '';
		$content_er = '';
		$content_nm = 'style="display:none"';
 		// $content_error_sta = 'style="display:none"';
 		// $content_normal_sta = '';
 		// $error_msg = '';
 		$layout_config = '';
 		$rp_cid = '';
 		$rp_title = '';
 		$rp_interval = '';
 		$rp_start = '';

 		$reqArgs = array("rp_cid");

 		$rejMsg = __checkAccess($reqArgs);
		if($rejMsg){
			$tips_er = $rejMsg;					
		}else{
			$report_layout = new REPORT_LAYOUT();
 			$rp_cid = $_GET['rp_cid'];
 			$report_layout->rp_cid = $rp_cid;
 			$report_layout->Find();
 			$layout_config = $report_layout->rp_config;
 			$rp_title = $report_layout->rp_title;
 			$rp_interval = $report_layout->rp_interval;
 			$rp_start = $report_layout->rp_start;
 			$rp_list = $report_layout->rp_list;
			$content_er = 'style="display:none"';
			$content_nm = '';
		} 
	?>

	<!-- page HTMLDOM -->
	<div class="" <?php echo $content_er; ?>>
		<div style="padding-top:40px"><p style="text-align:center"><?php echo $tips_er; ?></p></div>
	</div>
	<div class="content" <?php echo $content_nm; ?>>
		<div id="header">
			<div class="header-wrap">
				<p class="title">页面配置*</p>
				<p class="subtitle">
					<a href="report_setting.php">全部报表</a> > 布局(<?php echo $rp_title; ?>)</p>
			</div>
		</div>
		<div id="main">
			<div class="content-wrap">
				<div class="row" id="reportProp">
					标题：
					<span class="rpspn">
						<?php echo $rp_title ?></span>
					<input class="report-ttl rpipt" type="text" value="<?php echo $rp_title ?>" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;结束：<span class="rpspn"><?php echo $rp_start ?></span><input class="report-str rpipt" type="text" value="<?php echo $rp_start ?>" style="display:none; width:20px">&nbsp;&nbsp;&nbsp;&nbsp;开始：<span class="rpspn"><?php echo $rp_interval ?></span><input class="report-itv rpipt" type="text" value="<?php echo $rp_interval ?>" style="display:none; width:20px">&nbsp;&nbsp;&nbsp;&nbsp;平台：<span class="rpspn"><?php echo $rp_list ?></span><input class="report-slt rpipt" type="text" value="<?php echo $rp_list ?>" style="display:none; width:20px"></div>
				<div class="row">
					<div id="layoutPreview" class="clearfix" data-layout="<?php echo $layout_config; ?>" data-cid="<?php echo $rp_cid; ?>" data-title="<?php echo $rp_title; ?>"></div>
				</div>
				<div class="row">
					<div id="contorler">
						<div class="layoutCWrap" style="display:none">
							<p>
								类型：
								<select id="mtypeSelect">
									<option value="empty">空</option>
									<option value="datepicker">日期选择</option>
									<option value="serverlist">服务器选择</option>
									<option value="parameter">参数筛选</option>
									<option value="mmgrid">普通表</option>
									<option value="mmgridspec">转置表</option>
									<option value="highchart">线柱图</option>
									<option value="highchartpie">饼形图</option>
									<option value="highchartgauge">仪表盘</option>
								</select>
								占位：
								<select id="colSelect">
									<option value="1">1网格</option>
									<option value="2">2网格</option>
									<option value="3">3网格</option>
									<option value="4">4网格</option>
								</select>
								<button id="addgrid">添加控件</button>
							</p>
							<p>
								<button id="losBtn">保存</button>
								&nbsp;&nbsp;
								<button id="lodBtn">不保存</button>
								<!-- <a href="report_setting.php" style="text-decoration: none;"><input type="button" value="返回"></a> -->
								<span class="tipp">选择保存或不保存后，转到控件单独设置模式</span>
							</p>
						</div>
						<div class="detailCWrap">
							<p>
								<button id="changeModeBtn">转到布局设置模式</button>
							</p>
						</div>
						<form id="saveForm" action="layout_setting_save.php" method="post">
							<input id="formCid" type="hidden" name="rp_cid" value="<?php echo $rp_cid; ?>">
							<input id="formTitle" type="hidden" name="rp_title" value="<?php echo $rp_title; ?>">
							<input id="formInterval" type="hidden" name="rp_interval" value="<?php echo $rp_interval; ?>">
							<input id="formStart" type="hidden" name="rp_start" value="<?php echo $rp_start; ?>">
							<input id="formServerList" type="hidden" name="rp_list" value="<?php echo $rp_list; ?>">
							<input id="formConfig" type="hidden" name="rp_config" value="">
							<input id="formRm" type="hidden" name="rp_rm" value="test"></form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- page HTMLDOM end-->
	<script src="sp/jquery-ui-1.9.2.custom.min.js"></script>
	<script type="text/javascript" src="layout_setting.js"></script>
</body>
</html>