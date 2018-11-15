<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title></title>
  <meta name="Author" content="Ashen" />
	<link href="view/css/caomoo.css" rel="stylesheet" type="text/css">
	<script src="view/js/jquery.js" type="text/javascript"></script>

<style>
table.list th{border:1px solid #EEE;height:35px;background:#EEEEEE;}
.w300{height:30px;width:300px;float:left;margin:5px;border:2px solid #EEE;background:#ebfbb7;font-weight:bold;padding-left:20px}
.w100pc{height:30px;margin:5px;padding:5px;border:2px solid #EEE;background:#ebfbb7;font-weight:bold;}
.searchbtm{height:30px;padding:0 10px;}
.checkbox_item{padding:3px;}
</style>
</head>
<body>
<{if $msg}>
<div class="message"><{$msg}></div>
<{/if}>
<div class="s_tips">
		<i></i>当前位置： <{$_header->getNavigate()}><span class='fright'><!-- <a href='/?action=admin&op=admin_list' class='red'>返回列表</a> --></span>
</div>
<link rel="stylesheet" href="/view/css/jquery-ui.css" />
<script src="/view/js/ui.datepicker.js" type="text/javascript"></script>
<script src="/view/js/zn_datepicker.js" type="text/javascript"></script>
<style>
#serverlist{height:0px;overflow:hidden;margin-top:0px;}
#serverlist label{width:190px;text-align:left;display:block;float:left;margin-top:10px;}
</style>

<!--日排行头部-->
<form action='/index.php' method='post' id='searchForm'>
	<input type="hidden" name="action" value="<{$_header->getAction()}>" />
	<input type="hidden" name="op" value="<{$_header->getMethod()}>" />
	<input type='hidden' name='do' value='search'>
	<input type='hidden' name='game_db' value='<{$game_db}>'>
	<div style='width:100%;' class="search_option">
		<div style='width:800px;'>
		
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
				时间选择: <input type='text' name='from_date' value='<{$_header->getFromDate()}>' readonly=readonly id='from_date' class='date'> - <input type='text' name='to_date' value='<{$_header->getToDate()}>' readonly=readonly id='to_date' class='date'>
			</span>
		<{/if}>

		<{*显示单天搜索*}>
		<{if $_header->isShowOnlyDay()}>
			<span>
				&nbsp;&nbsp;&nbsp;&nbsp;
				时间选择: <input type='text' name='from_date' value='<{$_header->getFromDate()}>' readonly=readonly id='from_date' class='date'>
			</span>
		<{/if}>
		<span style='float:right;'><input type='button' id="search_button" value='查询' style='width:80px;height:25px;font-weight:bold;font-size:16px;' onclick="submit_searchForm()">&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='checkbox' value="1" name='todown'>下载Execl文件</label></span><br />
		</div>
		<br clear='all' />
		<{foreach from=$_header->getSelect() item=item key=key}>
			<{if $key && $item}>
				&nbsp;&nbsp;&nbsp;&nbsp;<{$item.title}>：<select name='<{$key}>'>
					<{foreach from=$item.list item=oplist key=v}>
						<option value='<{$v}>' <{if $v==$item.checked}>selected<{/if}>><{$oplist}></option>
					<{/foreach}>
				</select>
			<{/if}>
		<{/foreach}>
		<{foreach from=$_header->getCheckbox() item=item key=key}>
			<{if $key && $item}>
				<{$item.title}>：
					<{foreach from=$item.list item=oplist key=v}>
						<label style='margin-right:20px;'><input type='checkbox' name='<{$key}>[]' value='<{$v}>' <{if $item.checked && $v|@in_array:$item.checked}>checked<{/if}>><{$oplist}></label>
					<{/foreach}>

			<{/if}>
		<{/foreach}>
		<br clear='all' />
		<{if $_header->isShowZoneList()}>

			<div id="pltlist" style='height:20px;margin-top:10px;'>
				&nbsp;&nbsp;&nbsp;&nbsp;服务器列表:&nbsp;&nbsp;
				<{foreach from=$_header->getPlateform() item=item}>
					<{if !$item.plateform|@in_array:$_header->removedPlatform && ($myinfo.level || $item.plateform|@in_array:$myinfo.AllowPlatform)}>
					<label><input type='checkbox' <{if $item.plateform|@in_array:$_header->getCheckedPlates()}>checked<{/if}> id='<{$item.plateform}>' onclick="selectallserver('<{$item.plateform}>')"><{$item.plateform}></label>&nbsp;&nbsp;&nbsp;&nbsp;
					<{/if}>
				<{/foreach}>
                <div style='text-align: right;margin-right:50px '>
                   <input onclick="allSelect()"  type="button" style="line-height: 20px;cursor: pointer;background: #C4D5DF; font-size:11px;font-weight: bolder;" value="  &nbsp;全选&nbsp;  "/>&nbsp;&nbsp;
                   <input onclick="invertplt()"  type="button" style="line-height: 20px;cursor: pointer;background: #C4D5DF; font-size:11px;font-weight: bold;" value="  &nbsp;平台反选&nbsp;  "/>&nbsp;&nbsp;
                   <input onclick="invertserver()"   type="button" style="line-height: 20px;cursor: pointer;background: #C4D5DF; font-size:11px;font-weight: bold;" value="  &nbsp;区服反选&nbsp;  "/>
                </div>
			</div>

			<br clear='all' />
			<p id='viewcontrol'>显示全部</p>

			<div id='serverlist'>
				<{foreach from=$_header->getZoneList() item=item}>
					<{if !$item.ServerType|@in_array:$_header->removedPlatform  && ($myinfo.level || $item.ServerType|@in_array:$myinfo.AllowPlatform)}>
					<label><input type='checkbox' name='sid[]' value='<{$item.ID}>'  <{if $item.ID|@in_array:$_header->getCheckZones()}>checked<{/if}> pf='<{$item.ServerType}>'><{$item.ServerType}>-<{$item.ServerID}>-<{$item.ServerName}></label>
					<{/if}>
				<{/foreach}>
			</div>

		<{/if}>

	</div>
</form>
<br clear='all' />



<script>
$(function() {
		$("#from_date").datepicker({
				showHms:<{if $_header->isShowDateTime()}>true<{else}>false<{/if}>,/*是否显示时分秒*/
				changeMonth: true,
				changeYear: true,
				dateFormat:'yy-mm-dd',
				buttonImageOnly: true,
				showOn: 'focus',
				showButtonPanel:true // must

		});

		$("#to_date").datepicker({
				showHms:<{if $_header->isShowDateTime()}>true<{else}>false<{/if}>,/*是否显示时分秒*/
				changeMonth: true,
				changeYear: true,
				dateFormat:'yy-mm-dd',
				buttonImageOnly: true,
				showOn: 'focus',
				showButtonPanel:true // must

		});
		$('#report').height($(window).height()-160)
		//document.getElementById('searchForm').submit();
});
$(window).resize(function(){
	//console.log($(window).height());
	$('#report').height($(window).height()-160);
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
		$('#searchForm').attr('target','');
	}
	document.getElementById('searchForm').submit();
}


/**
 *  平台反选
 */
    function invertplt(){
        $('#pltlist input[type="checkbox"]').each(function(){
              $(this).trigger("click");
        } );
    showSelectList ();
    }
/**
 * 区服反选
 */
    function invertserver(){
        $('#serverlist input[type="checkbox"]').each(function(){
            if(  $(this).attr('checked') ===  true ){
                $(this).removeAttr('checked');
            }else{
                $(this).attr('checked','checked')
            }
         });
    showSelectList ();
   }

/**
 * 全选
 */
function allSelect(){
    $('#serverlist input[type="checkbox"],#pltlist input[type="checkbox"]').each(function(){
            $(this).attr('checked','checked')
    });
    showSelectList ();
}

function  showSelectList (){
    if($('#serverlist').css('overflow')=='hidden'){
        $('#viewcontrol').trigger("click");
    }
}
</script>