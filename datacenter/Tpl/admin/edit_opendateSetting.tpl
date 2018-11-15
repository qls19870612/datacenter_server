<{include file='header.php'}>
<link rel="stylesheet" href="/view/css/jquery-ui.css" />

<script src="/view/js/ui.datepicker.js" type="text/javascript"></script>
<script src="/view/js/zn_datepicker.js" type="text/javascript"></script>

<div class="s_tips">
		<i></i>当前位置： <{$_header->getNavigate()}>
</div>

<div style="width:100%; text-align:left" align="center">


	<form action='index.php' method='post'>
	<input type='hidden' name='action' value='admin'>
	<input type='hidden' name='op' value='edit_opendateSetting'>
	<input type='hidden' name='saveedit' value='1'><br />
	<input type='hidden' name='zoneid' value='<{$zoneid}>'>
	<table width="600" border=1 align=center class="data_list">

	<thead>
		<tr><th colspan=2 align='center'>[<{$w2s[$zoneid]}>] 开服天设置</th></tr>
	</thead>
	<tbody>
		<tr>
	    <td><span class="must_fill">*</span>重设开服天时间:</td>
	    <td><input type='text' readonly=readonly name='openday' id='openday' class='text input_text'><font color='red'>如不修改,勿填,更改时间将导致该服所有数据重新汇总归档</font></td>
	  </tr>
	</tbody>
	<{foreach from=$list item=item}>
		<tbody>
			<tr><td colspan=2>&nbsp;</td></tr>
		</tbody>
		<thead>
			<tr><th colspan=2 class='small'>第<{$item.theday}>天</th></tr>
		</thead>
		<tbody>
	  <tr>
	    <td><span class="must_fill">*</span>归档情况:</td>
	    <td><{if $item.isover}><font color='red'>已归档</font>&nbsp;&nbsp;&nbsp;<input type='checkbox' name='re_summary[]' value='<{$item.theday}>'><{else}>未归档<{/if}></td>
	  </tr>
	  </tbody>
	<{/foreach}>


	<tr>
	    <td colspan=2 align=center><input type="submit" value="保存">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="返回列表" onclick="location.href='index.php?action=admin&op=opendateSetting'" /></td>
	  </tr>


	</table>
	</form>
<br /><br /><br /><br />

</div>
<script>
$(function() {
		$("#openday").datepicker({
				showHms:true,/*是否显示时分秒*/
				changeMonth: true,
				changeYear: true,
				dateFormat:'yy-mm-dd',
				buttonImageOnly: false,
				showOn: 'both',
				showButtonPanel:true // must 
		
		});
})
</script>
<{include file='footer.php'}>