<!DOCTYPE html>
<html>
<?php include_once 'mng_g_h.php'; ?>
<body>
	<?php
		include_once "../../../RPL/rps_mng.php";		
		$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

		// Initialization
		session_start();
		$rp_tag = 'report_setting';
		$_SESSION['rp_tag'] = $rp_tag;

		$tips_er = '';
		$content_er = '';
		$content_nm = 'style="display:none"';
		$reports_form = '';

		$page = 1;
		$pagesize = 20;
		$search = '';
		$reqArgs = array();


		$rejMsg = __checkAccess($reqArgs);
		if($rejMsg){
			$tips_er = $rejMsg;
		}else{
			if(isset($_GET['page'])){
				$page = intval($_GET['page']);
				$page = $page == 0 ? 1 : $page;
			}
			if(isset($_GET['search']) && $_GET['search'] != ''){
				$search = $_GET['search'];
			}
			$reports_form = __getReportsForm($page, $pagesize, $search);
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
				<p class="subtitle">全部报表<a href="games_list.php" style="float:right">游戏列表</a></p>
			</div>
		</div>
		<div id="main">
			<div class="content-wrap">
				<?php echo $reports_form; ?>
				<div class="row">
				<div id="contorler">
					<form action="report_setting_save.php" method="post" name="report_save">
					<input type="hidden" name="act" value="add">
					<input type="hidden" name="nrp_like" value="">
					<p id="showInfo">标题：<input type="text" name="nrp_title" value="">&nbsp;&nbsp;cid：<input type="text" name="nrp_cid" value="">&nbsp;&nbsp;<input type="submit" value="添加">&nbsp;&nbsp;&nbsp;&nbsp;<span id="templateInfo" style="color:gray"></span></p>
					<p><input class="showseturl" type="checkbox" value="1">设为自定义页面&nbsp;&nbsp;<span id="setUrl" style="display:none">指定该页面URL：<input type="text" name="nrp_url" value="" style="width:300px"></span></p>
					</form>
				</div>
				</div>
			</div>
		</div>
	</div>
	<!-- page HTMLDOM end-->
	<script type="text/javascript">
		var confirmDelete = function (){
			if(confirm('删除报表，连同报表内控件也会被删除，而且将不能恢复。确认是否删除？')){
				return true;
			}else{
				return false;
			}
		}
		var parseURL = function (url) {
			var a = document.createElement('a');
			a.href = url;
			return {
				source: url,
				protocol: a.protocol.replace(':', ''),
				host: a.hostname,
				port: a.port,
				query: a.search,
				params: (function() {
					var ret = {},
						seg = a.search.replace(/^\?/, '').split('&'),
						len = seg.length,
						i = 0,
						s;
					for (; i < len; i++) {
						if (!seg[i]) {
							continue;
						}
						s = seg[i].split('=');
						ret[s[0]] = s[1];
					}
					return ret;
				})(),
				file: (a.pathname.match(/\/([^\/?#]+)$/i) || [, ''])[1],
				hash: a.hash.replace('#', ''),
				path: a.pathname.replace(/^([^\/])/, '/$1'),
				relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [, ''])[1],
				segments: a.pathname.replace(/^\//, '').split('/')
			};
		}
		$(function(){
			$('#reportList').on('click', 'button.astemplate', function(){
				var _this = $(this), _tr = _this.parents('tr');
				var _id = _tr.find('td:eq(0)').text()
				, _title = _tr.find('td:eq(1)').text()
				, _cid = $.trim(_tr.find('td:eq(2)').text());
				var tidom = '模版：'+_id+'|'+_title+'|'+_cid+'&nbsp;&nbsp;<button class="rmtemplate">X</button>';
				$('#contorler').find('input[name="nrp_like"]').val(_cid);
				$('#templateInfo').html(tidom);
			})
			$('#contorler').on('click', 'input.showseturl, button.rmtemplate', function(){
				var _this = $(this);
				if(_this.hasClass('showseturl')){
					if(_this.is(':checked')){
						$('#setUrl').show();
					}else{
						$('#setUrl').hide();
					}
				}else if(_this.hasClass('rmtemplate')){
					$('#contorler').find('input[name="nrp_like"]').val('');
					_this.parent('span').html('');
				}
			})
			$('#PageJump').on('click', function(){
				var _this = $(this);
				var pageGroup = _this.parent('li.pageetc').parent('ul');
				var lastPage = Number(pageGroup.find('li.pageNum:last').data('pagenum'));
				var pageInput = _this.parent('li.pageetc').prev('li.pageetc').find('input');
				var goToPage = Number($.trim(pageInput.val()))
				if(!isNaN(goToPage) && goToPage > 0 && goToPage < lastPage+1){
					var url = parseURL(window.location.href);
					var goToUrl = 'http://' + url.host + ':' + url.port + url.path + '?';
					var count = 0;
					url.params.page = goToPage;
					for(var param in url.params){
						var and = count ? '&' : '';
						goToUrl+=(and+param+'='+url.params[param]);
						count++
					}
					window.location = goToUrl;
				}else{
					pageInput.val('');
				}
			})
			$('#searchList').on('click keydown', function(e){
				var _this = $(this);
				var isTrigger = 0;
				var inputVar = _this.parent('.row').find('input').val() || '';
				var searchVar = inputVar.replace(/\s/g, '');
				var _target = $(e.target);

				if(e.type == 'click'){
					if(_target.hasClass('shbtn')){
						isTrigger = 1;
					}else if(_target.hasClass('clbtn')){
						isTrigger = 1;
						searchVar = '';
					}
				}else if(e.type == 'keydown' && e.keyCode == 13){
					isTrigger = 1;
				}
				if(isTrigger){
					var url = parseURL(window.location.href);
					var goToUrl = 'http://' + url.host + ':' + url.port + url.path;
					if(searchVar){
						goToUrl = 'http://' + url.host + ':' + url.port + url.path + '?search=' + searchVar;
					}
					window.location = goToUrl;
				}
			})
		})
	</script>
</body>
</html>