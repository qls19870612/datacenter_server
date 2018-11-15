<!DOCTYPE html>
<html>
<?php include_once 'mng_g_h.php'; ?>
<body>
	<?php
		include_once "../../../RPL/rps_mng.php";		
		$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

		// Initialization
		session_start();
		$rp_tag = 'urlsql_setting';				
		$_SESSION['rp_tag'] = $rp_tag;

		$tips_er = '';
		$content_er = '';
		$content_nm = 'style="display:none"';
		$layout_url = '';
		$mod_sql = '';

		$reqArgs = array("suid", "rp_cid");

		$rejMsg = __checkAccess($reqArgs);
		if($rejMsg){
			$tips_er = $rejMsg;					
		}else{
			$suid = $_GET['suid'];
			$rp_cid = $_GET['rp_cid'];
			$layout_url = 'url_setting.php?rp_cid='.$rp_cid;
 			$mod_sql = __getModSql($suid, $rp_cid);
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
				<p class="subtitle"><a href="report_setting.php">全部报表</a> > <a href="<?php echo $layout_url; ?>"> 布局(自定义)</a> > SQL(<?php echo $suid; ?>)</p>
			</div>
		</div>
		<div id="main">
			<div class="content-wrap">
				<div class="row" id="reportProp">
					<?php echo $mod_sql; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- page HTMLDOM end-->
	<script type="text/javascript">
		$(function(){
			$('#saveModSql').on('click', function(){
				var sql1 = $('#Sql1').val();
				var sql2 = $('#Sql2').val();
				$('#ModSqlForm').find('input[name="sql1"]').val(sql1);
				$('#ModSqlForm').find('input[name="sql2"]').val(sql2);
				$('#ModSqlForm').submit();
			})
		})
	</script>
</body>
</html>