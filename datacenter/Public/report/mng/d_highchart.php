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
	$detail_sqlp = '';
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
		$detail_sqlp =$mod['detail_sqlp'];
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
				缩放方式：
				<select class="valElm" id="zoomType">
					<option value="xy">xy</option>
					<option value="x">x</option>
					<option value="y">y</option>
				</select>
			</p>
			<p class="config-itm">
				主标题：
				<input class="valElm" id="mainTitle" type="text" value="主标题"></p>
			<p class="config-itm">
				副标题：
				<input class="valElm" id="subTitle" type="text" value="副标题"></p>
			<p class="config-itm">
				X轴数据：
				<input class="valElm" id="xkey" type="text" value=""><span class="remark">用于关联数据</span></p>
			<p>合并柱形图：
				<input class="valElm" id="groupColumns" type="checkbox" value="0"></p>

			<fieldset class="config-collection" id="yAxis">
				<legend>左侧Y轴信息：</legend>
				
				<p class="config-itm">
					单位：
					<input class="valElm" cid="ylabels" type="text" value=""><span style="color:#ccc">(选填)</span></p>
				<p class="config-itm">
					左侧轴标题：
					<input class="valElm" cid="ytitle" type="text" value=""><span style="color:#ccc">(选填)</span></p>
				
			</fieldset>

			<fieldset class="config-collection" id="yAxis_r">
				<legend>右侧Y轴信息：</legend>

				<p>启用：<input type="checkbox" class="valElm" cid="yAxis_r_enable"></p>
				
				<p class="config-itm">
					单位：
					<input class="valElm" cid="ylabels_r" type="text" value=""><span style="color:#ccc">(选填)</span></p>
				<p class="config-itm">
					右侧轴标题：
					<input class="valElm" cid="ytitle_r" type="text" value=""><span style="color:#ccc">(选填)</span></p>
				
			</fieldset>
			
			<fieldset class="config-collection" id="series">
				<legend>数据：</legend>
				<button class="addBtn">添加</button>
				

				<!-- <fieldset class="config-group">
					<legend>
						项目：
						<span class="count">1</span>
					</legend>
					<p class="config-itm">
						标题：
						<input class="valElm" cid="sname" type="text" value="测试1"></p>
					<p class="config-itm">
						显示数据：
						<input class="valElm" cid="sdataLabels" type="checkbox" value=""></p>
					<p class="config-itm">
						对应y轴：
						<select class="valElm" cid="syAxis">
							<option value="0">左侧</option>
							<option value="1">右侧</option>
						</select>
					</p>
					<p class="config-itm">
						图形类别：
						<select class="valElm" cid="stype">
							<option value="colum">柱状</option>
							<option value="spline">曲线</option>
							<option value="line">折线</option>
						</select>
					</p>
					<p class="config-itm">
						单位：
						<input class="valElm" cid="svalueSuffix" type="text" value="m"></p>
					<p class="config-itm">
						键名：
						<input class="valElm" cid="skey" type="text" value="test1">
						<span class="remark">用于关联数据</span>
					</p>
					<button class="removeBtn">REMOVE</button>
				</fieldset> -->
			</fieldset>
		</div>
	</div>
</div>
<div class="row normal" <?php echo $row_normal_sta; ?>>
	<div id="confSql">
		<p>SQL1：</p>
		<textarea id="sqlContent" style="height:100px"><?php echo $detail_sql; ?></textarea>
		<p>SQL2：</p>
		<textarea id="sqlContentp" style="height:100px"><?php echo $detail_sqlp; ?></textarea>
	</div>
</div>
<div class="row normal" <?php echo $row_normal_sta; ?>>
	<div id="contorler">
		<p><button id="configSave">保存</button>&nbsp;&nbsp;<button id="refresh">刷新</button></p>
		<form action="detail_setting_save.php" method="post" id="detailSettingSave">
			<input id="configSuid" type="hidden" name="suid" value="<?php echo $suid; ?>">
			<input id="configSqlKey" type="hidden" name="sql_key" value="<?php echo $sql_key; ?>">
			<input id="configStr" type="hidden" name="mod_config" value="">
			<input id="configSql" type="hidden" name="sqlt" value="">
			<input id="configSqlp" type="hidden" name="sqltp" value="">
		</form>
	</div>
</div>
	<script src="sp/json2.js"></script>
	<script type="text/javascript" src="d_highchart.js"></script>
</body>
</html>