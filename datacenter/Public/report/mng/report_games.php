<!DOCTYPE html>
<html>
<?php include_once 'mng_g_h.php'; ?>
<body>
	<?php
		include_once "../../../RPL/rps_mng.php";		
		$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

		// Initialization
		session_start();
		$rp_tag = 'report_games';					
		$_SESSION['rp_tag'] = $rp_tag;

		$tips_er = '';
		$content_er = '';
		$content_nm = 'style="display:none"';
		$report_detail = '';						
		$games_list = '';								

		$reqArgs = array("rp_cid");	

		$rejMsg = __checkAccess($reqArgs);
		if($rejMsg){
			$tips_er = $rejMsg;					
		}else{
			$rp_cid = $_GET['rp_cid'];
			$report_detail = __getReportDetail($rp_cid);	
			$games_list =  __getGamesList($rp_cid);
			$content_er = 'style="display:none"';
			$content_nm = '';
		}

	?>
	<!-- page HTMLDOM -->
	<div class="" <?php echo $content_er; ?>>
		<div style="padding-top:40px">
			<p style="text-align:center">
				<?php echo $tips_er; ?></p>
		</div>
	</div>
	<div class="content" <?php echo $content_nm; ?>
		>
		<div id="header">
			<div class="header-wrap">
				<p class="title">页面配置*</p>
				<p class="subtitle"><a href="report_setting.php">全部报表</a> > 报表关联游戏
				</p>
			</div>
		</div>
		<div id="main">
			<div class="content-wrap">
				<div class="row"  style="border:1px solid #ccc; padding:10px">
					<p class="ttl">所选报表：</p>
					<?php echo $report_detail; ?>
					<p class="ttl">绑定游戏：</p>
					<div id="GamesList">
						<form action="report_games_save.php" method="post" name="report_games_save" id="rpGamesSaveForm">
							<?php echo $games_list; ?>
							<input id="gamecodestr" type="hidden" value="" name="gamecode"></form>
					</div>
				</div>
				<div class="row">
					<div id="contorler">
						<p>
							<input class="gameRpSaveBtn" type="button" value="保存">
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
				var _rpGamesSaveForm = $('#rpGamesSaveForm');
				if(_this.hasClass('gameRpSaveBtn')){
					var gamecode = [];
					var gamecodestr = '';
					_rpGamesSaveForm.find('input.gamecode:checked').each(function(){
						var _this = $(this);
						gamecode.push(_this.val());
					})
					gamecodestr = gamecode.join(',');
					_rpGamesSaveForm.find('#gamecodestr').val(gamecodestr);
					_rpGamesSaveForm.submit();
				}else if(_this.hasClass('selectAll')){
					_rpGamesSaveForm.find('input.gamecode:checked').trigger('click')
					_rpGamesSaveForm.find('input.gamecode').trigger('click');
				}else if(_this.hasClass('selectNone')){
					_rpGamesSaveForm.find('input.gamecode:checked').trigger('click');
				}
			})
		})
	</script>
</body>
</html>