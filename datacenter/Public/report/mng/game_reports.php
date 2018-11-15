<!DOCTYPE html>
<html>
<?php include_once 'mng_g_h.php'; ?>
<body>
	<?php
		include_once "../../../RPL/rps_mng.php";		
		$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

		// Initialization
		session_start();
		$rp_tag = 'game_reports';				
		$_SESSION['rp_tag'] = $rp_tag;

		$tips_er = '';
		$content_er = '';
		$content_nm = 'style="display:none"';
		$games_detail = '';						
		$report_list = '';						

		$reqArgs = array("gamecode");			


		$rejMsg = __checkAccess($reqArgs);
		if($rejMsg){
			$tips_er = $rejMsg;
		}else{
			$gamecode = $_GET['gamecode'];
			$games_detail = __getGameDetail($gamecode);
			$report_list =  __getReportsList($gamecode);
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
					<a href="report_setting.php">全部报表</a> > <a href="games_list.php">游戏列表</a> > 游戏关联报表
				</p>
			</div>
		</div>
		<div id="main">
			<div class="content-wrap">
				<div class="row"  style="border:1px solid #ccc; padding:10px">
					<p class="ttl">所选游戏：</p>
					<?php echo $games_detail; ?>
					<p class="ttl">绑定报表：</p>
					<div id="GamesList">
						<form action="game_reports_save.php" method="post" name="game_reports_save" id="gmReportsSaveForm">
							<?php echo $report_list; ?>
							<input id="rpcidstr" type="hidden" value="" name="rp_cid"></form>
					</div>
				</div>
				<div class="row">
					<div id="contorler">
						<p>
							<input class="reportGmSaveBtn" type="button" value="保存">
							&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="selectAll" type="button" value="全选">
							<input class="selectNone" type="button" value="全不选">
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- page HTMLDOM end-->
	<script type="text/javascript">
		$(function(){
			$('#contorler').on('click', 'input', function(){
				var _this = $(this);
				var _gmReportsSaveForm = $('#gmReportsSaveForm');
				if(_this.hasClass('reportGmSaveBtn')){
					var rp_cid = [];
					var rpcidstr = '';
					_gmReportsSaveForm.find('input.rpcid:checked').each(function(){
						var _this = $(this);
						rp_cid.push(_this.val());
					})
					rpcidstr = rp_cid.join(',');
					_gmReportsSaveForm.find('#rpcidstr').val(rpcidstr);
					_gmReportsSaveForm.submit();
				}else if(_this.hasClass('selectAll')){
					_gmReportsSaveForm.find('input.rpcid:checked').trigger('click')
					_gmReportsSaveForm.find('input.rpcid').trigger('click');
				}else if(_this.hasClass('selectNone')){
					_gmReportsSaveForm.find('input.rpcid:checked').trigger('click');
				}
			})
		})
	</script>
</body>
</html>