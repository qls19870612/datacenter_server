<!DOCTYPE html>
<html>
<?php include_once 'mng_g_h.php'; ?>
<body>
	<?php
		include_once "../../../RPL/rps_mng.php";
		$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

		// Initialization
		session_start();
		$rp_tag = 'url_setting';	
		$_SESSION['rp_tag'] = $rp_tag;				

		$tips_er = '';
		$content_er = '';
		$content_nm = 'style="display:none"';
		$url_info = '';

		$reqArgs = array("rp_cid");

		$rejMsg = __checkAccess($reqArgs);
		if($rejMsg){
			$tips_er = $rejMsg;					
		}else{
			$rp_cid = $_GET['rp_cid'];
		 	$url_info = __getUrlInfo($rp_cid);
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
				<p class="subtitle"><a href="report_setting.php">全部报表</a> > 布局(自定义)</p>
			</div>
		</div>
		<div id="main">
			<div class="content-wrap">
				<div class="row" id="reportProp">
					<?php echo $url_info; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- page HTMLDOM end-->
	<script type="text/javascript">
	var confirmDelete = function (){
			if(confirm('删除后无法恢复，请确认是否删除？')){
				return true;
			}else{
				return false;
			}
		}
	</script>
</body>
</html>