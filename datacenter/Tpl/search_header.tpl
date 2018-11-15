<{include file='header.php'}>
<div class="s_tips">
		<i></i>当前位置： <{$_header->getNavigate()}><span class='fright'><!-- <a href='/?action=admin&op=admin_list' class='red'>返回列表</a> --></span>
</div>
<link rel="stylesheet" href="/view/css/jquery-ui-1.7.3.custom.css" />
<script src="/view/js/ui.datepicker.js" type="text/javascript"></script>
<script src="/view/js/zn_datepicker.js" type="text/javascript"></script>
<style>
#serverlist{height:0px;overflow:hidden;}
	#serverlist label{width:190px;text-align:left;display:block;float:left;}
</style>

<!--日排行头部-->
	<legend>选择服务器</legend>
	<form action='/index.php' method='post' id='searchForm' target='report'>
	<input type="hidden" name="action" value="<{$_header->getAction()}>" />
	<input type="hidden" name="op" value="<{$_header->getMethod()}>" />
	<input type='hidden' name='do' value='search'>
	<div style='width:950px;float:left;' class="search_option">
	<{foreach from=$_header->getSelect() item=item key=key}>
		<{if $key && $item}>
			<{$item.title}>：<select name='<{$key}>'>
				<{foreach from=$item.list item=oplist key=v}>
					<option value='<{$v}>'><{$oplist}></option>
				<{/foreach}>
			</select>
		<{/if}>
	<{/foreach}>

	<{*年份选择搜索下拉*}>
	<{if $_header->isShowYear()}>
	<span>
	&nbsp;&nbsp;&nbsp;&nbsp; 年份选择
	<select name="s_year">
		<{foreach from=$_header->getShowYears() item=item}>
		<option value="<{$item}>"><{$item}></option>
		<{/foreach}>
	</select>
	</span>
	<{/if}>
	
	<{if $_header->isShowDate()}>
	<span>&nbsp;&nbsp;&nbsp;&nbsp;
	时间选择: <input type='text' name='from_date' value='<{$from_date}>' readonly=readonly id='from_date'> - <input type='text' name='to_date' value='<{$to_date}>' readonly=readonly id='to_date'>
	</span><{/if}>
	
	<{*显示单天搜索*}>
	<{if $_header->isShowOnlyDay()}><span>
	&nbsp;&nbsp;&nbsp;&nbsp;
	时间选择: <input type='text' name='from_date' value='<{$from_date}>' readonly=readonly id='from_date'>
	</span>
	<{/if}>
	
	<{if $_header->isShowZoneList()}>
	<span>
		服务器列表:&nbsp;&nbsp;<{foreach from=$_header->getPlateform() item=item}><label><input type='checkbox' id='<{$item.plateform}>' onclick="selectallserver('<{$item.plateform}>')"><{$item.plateform}></label>&nbsp;&nbsp;&nbsp;&nbsp;<{/foreach}><br />
		<div id='serverlist'>
			<{foreach from=$_header->getZoneList() item=item}>
				<label><input type='checkbox' name='sid[]' value='<{$item.ID}>'  <{if $item.ID|@in_array:$_header->getCheckZones()}>checked<{/if}> pf='<{$item.ServerType}>'><{$item.ServerType}>-<{$item.ServerID}>-<{$item.ServerName}></label>
			<{/foreach}>
	
			</div>
			<br clear='all'>
			<p id='viewcontrol'>显示全部</p>
		</div>
	</span>
	<{/if}>
	
	<div style='width:100px;float:right;text-align:center;'>
		<input type='button' id="search_button" value='查询' style='width:80px;height:80px;font-weight:bold;font-size:16px;' onclick="submit_searchForm()"><br />
		<span id="download_check"><label><input type='checkbox' value="1" name='todown'>下载Execl文件</label></span>
	</div>
	</form>


<script>
$(function() {
		$("#from_date").datepicker({
				showHms:<{if $_header->isShowDateTime()}>true<{else}>false<{/if}>,/*是否显示时分秒*/
				changeMonth: true,
				changeYear: true,
				dateFormat:'yy-mm-dd',
				buttonImageOnly: false,
				showOn: 'both',
				showButtonPanel:true // must 
		
		});

		$("#to_date").datepicker({
				showHms:<{if $_header->isShowDateTime()}>true<{else}>false<{/if}>,/*是否显示时分秒*/
				changeMonth: true,
				changeYear: true,
				dateFormat:'yy-mm-dd',
				buttonImageOnly: false,
				showOn: 'both',
				showButtonPanel:true // must 
		
		});

		//document.getElementById('searchForm').submit();
	});


<{if $_header->isShowZoneList()}>
function selectallserver(pf){
	$('input[pf='+pf+']').attr('checked',$('#'+pf).attr('checked'));
}
/**显示所有zone list**/
$(function(){
	$('#viewcontrol').click(function(){
		if($(this).html()=='显示全部'){
			$('#serverlist').css('overflow','visible').css('height','auto');
			$(this).html('隐藏');
		}else{
			$('#serverlist').css('overflow','hidden').css('height','0px');
			$(this).html('显示全部');
		}
		
	})
})
/**选择服务商zone list**/
function selectallserver(pf){
	$('input[pf='+pf+']').attr('checked',$('#'+pf).attr('checked'));
}
<{/if}>



/**下载 显示打开页面处理**/
function submit_searchForm(){
	if($('#searchForm').find('input[name=todown]').attr('checked')){
		$('#searchForm').attr('target','_blank');
	}else{
		$('#searchForm').attr('target','report');
	}
	document.getElementById('searchForm').submit();
}

</script>

<{if $_header->getMessage()}><font color='red'><{$_header->getMessage()}></font><{/if}>