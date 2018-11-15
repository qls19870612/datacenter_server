<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>MS</title>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="sp/jquery-1.9.1.min.js"></script>
	<style type="text/css">
		.clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden}
		.clearfix{*+height:1%;}
		body{margin: 0; padding: 0}
		.row{ margin-bottom: 12px}
		#optionList{ padding: 8px; border:solid 1px #CCC;}
		#contorler{background-color: #CCC; padding: 2px 8px; border:1px solid #999; }
    	#contorler p{margin: 12px 0; padding: 0 8px;}
    	#confSql{background-color: #eee; padding: 8px 8px}
    	#confSql p{padding: 4px 0; margin: 0}
    	#confSql textarea{width: 100%; height: 40px}
	</style>
</head>
<body>
	<?php
		include_once "../../../RPL/rps_mng.php";

		$sql_key = '';
		$suid = '';
		$detail_config = '';
		$detail_sql =  '';
		$record_type = '';

		$error_msg = '';
		$row_error_sta = 'style="display:none"';
	 	$row_normal_sta = '';


	 	if(isset($_GET['suid']) && isset($_GET['sql_key'])){
	 		$suid = $_GET['suid'];
			$sql_key = $_GET['sql_key'];
			
			$mod = __getModSetting($suid, $sql_key);
			$detail_config = $mod['detail_config'];
			$detail_sql =  $mod['detail_sql'];
			$record_type = $mod['record_type'];

	 	}else{
	 		$error_msg = '<div class="row"><p>--> 参数有误</p></div>';
	 	}
	 	
	?>

	<div class="row error" <?php echo $row_error_sta; ?> name="pagetop"><?php echo $error_msg; ?></div>
	<div class="row normal" <?php echo $row_normal_sta; ?>>
		<div id="optionList">
		<div id="setting" data-config="<?php echo $detail_config; ?>">
			<p class="config-itm">
				方式:
				<select class="emval" cid="dpmethod">
					<option value="0">时间段</option>
					<option value="1">时间点</option>
				</select>
			</p>
			<p class="config-itm">
				选择类型：
				<select class="emval" cid="dptimepick">
					<option value="0">日</option>
					<option value="1">月</option>
					<option value="2">年</option>
				</select>
			</p>
		</div>
		</div>
	</div>

	<div class="row normal" <?php echo $row_normal_sta; ?>>
	<div id="contorler">
		<p><button id="configSave">保存</button>&nbsp;&nbsp;<button id="refresh">刷新</button></p>
		<form action="detail_setting_save.php" method="post" id="detailSettingSave">
			<input id="configSuid" type="hidden" name="suid" value="<?php echo $suid; ?>">
			<input id="configSqlKey" type="hidden" name="sql_key" value="<?php echo $sql_key; ?>">
			<input id="configStr" type="hidden" name="mod_config" value="">
		</form>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		// 初始化
		var _configStr = $('#setting').data('config');
		if(_configStr){
		    try{
		        DC_CHART_CONFIG = JSON.parse(_configStr.replace(/\#\@/g, '"'));
		    }catch(e){}
		}
		if(DC_CHART_CONFIG){
			fetchHighchartColum(DC_CHART_CONFIG);
		}
		$('#configSave').on('click', function() {
			var json = getHighchartColum();
			var jsonStr = JSON.stringify(json);
			var jsonStr_f = jsonStr.replace(/\#\@/g, '').replace(/\"/g, '#@');
			$('#configStr').val(jsonStr_f);
			$('#configSql').val($('#sqlContent').val());
			$('#detailSettingSave').submit();
		});

		// 恢复设置
		$('#refresh').on('click', function(){
			window.location = window.location;
		})
	})
	// 全局对象 
	var DC_CHART_CONFIG;

	// 输出配置信息
	var getHighchartColum = function() {
		var module = {
			dptimepick:0,
			dpmethod:0
		};
		var _target = $('#setting');
		module.dpmethod = Number(_target.find('[cid="dpmethod"]').val());
		module.dptimepick = Number(_target.find('[cid="dptimepick"]').val());
		return module;
	}

	// 读取保存已信息配置信息
	var fetchHighchartColum = function(configData) {
		if (!isEmpty(configData)) {
			var cg = configData,
			dpmethod = cg.dpmethod || '',
			dptimepick = cg.dptimepick || 0

			var _target = $('#setting');
			_target.find('[cid="dpmethod"]').val(dpmethod);
			_target.find('[cid="dptimepick"]').val(dptimepick);

		}
	}

	var isEmpty = function(obj){ for (var name in obj) { return false; } return true; };
</script>
</body>
</html>