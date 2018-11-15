<!DOCTYPE html>
<html>
<?php include_once 'mng_g_h.php'; ?>
<body>
	<?php
		include_once "../../../RPL/rps_mng.php";		
		$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

		// Initialization
		session_start();
		$rp_tag = 'detail_setting';				
		$_SESSION['rp_tag'] = $rp_tag;

		$tips_er = '';
		$content_er = '';
		$content_nm = 'style="display:none"';

		$rp_title = isset($_GET['rp_title']) ? $_GET['rp_title'] : '';
		$mtitle = isset($_GET['mtitle']) ? $_GET['mtitle'] : '';
		$suid = '';
		$mtype = '';
		$sql_key = '';
		$setting_frame = '<div><p>无效控件 </p></div>';

		$reqArgs = array("suid", "mtype", "sql_key");	

		$rejMsg = __checkAccess($reqArgs);
		if($rejMsg){
			$tips_er = $rejMsg;					
		}else{
			$suid = $_GET['suid'];
			$mtype = $_GET['mtype'];
			$sql_key = $_GET['sql_key'];

			$checkSuid = preg_match("/^[0-9a-z]{4}-[0-9a-z]{8}$/i", $suid);		
			
			if($checkSuid){
				$module_tpl = 'd_'.$mtype.'.php';
				$tmp = $module_tpl.'?suid='.$suid.'&sql_key='.$sql_key;
				$setting_frame = '<iframe name="main" height="800" width="100%" frameborder="0" scrolling="auto" src="'.$tmp.'"></iframe>';
			}	
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
				<p class="subtitle"><a href="report_setting.php">全部报表</a> > <a href="layout_setting.php?rp_cid=<?php echo $sql_key; ?>">布局(<?php echo $rp_title; ?>)</a> > detail(<?php echo $mtitle; ?>)</p>
			</div>
		</div>
		<div id="main">
			<div class="content-wrap">
				<p class="param"><?php echo $mtitle.'::'.$mtype.'::'.$suid ?></p>
				<div class="frame-wrap"><?php echo $setting_frame; ?></div>
			</div>
		</div>
	</div>
	<!-- page HTMLDOM end-->
	
</body>
</html>