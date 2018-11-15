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
			<div id="controlBar" style="padding-bottom:20px">
				<button id="addVar">增加一个变量</button>
			</div>
			<div id="contentWrap">
			</div>
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
		$('#addVar').on('click', function(){
			var _contentWrap = $('#contentWrap');
			var idx = _contentWrap.find('fieldset').length;
			_contentWrap.append(fieldsetDom());
			refreshIndex();
		})

		$('#contentWrap').on('click', '.pr_remove', function(){
			var _this = $(this);
			console.log(_this);
			_this.parent('p').parent('fieldset').remove();
			refreshIndex();
		})

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
			parameter : []
		};
		var _contentWrap = $('#contentWrap');
		_contentWrap.find('fieldset').each(function(){
			var _fieldset = $(this),tmp = {};
			var pr_title = _fieldset.find('.pr_title').val() || '';
			var pr_name = _fieldset.find('.pr_name').val() || '';
			var pr_value = _fieldset.find('.pr_value').val()|| '';
			var pr_type = _fieldset.find('.pr_type').val()|| '';
			if(pr_title && pr_name && pr_value){
				tmp.title = $.trim(pr_title);
				tmp.name = $.trim(pr_name);
				tmp.type = pr_type;
				var value_f = $.trim(pr_value);
				var value_f_reg = value_f.replace(/select|update|delete|truncate|join|union|exec|inse rt|drop|count|'|"|;|>|<|%/ig, '');
				tmp.value = value_f_reg;
				module.parameter.push(tmp);
			}

		})
		return module;
	}

	// 读取保存已信息配置信息
	var fetchHighchartColum = function(configData) {
		if (!isEmpty(configData)) {
			var cg = configData,
			parameter = cg.parameter,
			parameter_len = parameter.length;
			var issetDom = '';
			if(parameter_len>0){
				for(var i=0; i<parameter_len; i++){
					issetDom += fieldsetDom(parameter[i]);
				}
			}
			$('#contentWrap').html(issetDom);
			refreshIndex();
		}
	}

	var refreshIndex = function(){
		$('#contentWrap').find('fieldset').each(function(i){
			var _this = $(this);
			var idxStr = '#'+(i+1);
			_this.find('legend').html(idxStr);
		})
	}


	var fieldsetDom = function(fobj){
		var pr_title='', pr_name='', pr_value='',pr_type;
		if(fobj){
			pr_title = fobj.title || '';
			pr_name = fobj.name || '';
			pr_value = fobj.value || '';
			pr_type = fobj.type || '';
		}

		var set_text = pr_type == 'text' ? 'selected="selected"' : '';
		var set_datepicker = pr_type == 'datepicker' ? 'selected="selected"' : '';

		return '<fieldset><legend></legend><p><label>标题：</label><input class="pr_title" type="text" value="'+pr_title+'">&nbsp;&nbsp;<label>变量名：</label><input class="pr_name" type="text" value="'+pr_name+'">&nbsp;&nbsp;<label>默认值：</label><input class="pr_value" type="text" value="'+pr_value+'">&nbsp;&nbsp;<select class="pr_type"><option value="text" '+set_text+'>文本</option><option value="datepicker" '+set_datepicker+'>日期</option></select>&nbsp;&nbsp;<button class="pr_remove">删除</button></p></fieldset>';
	} 

	var isEmpty = function(obj){ for (var name in obj) { return false; } return true; };
</script>
</body>
</html>