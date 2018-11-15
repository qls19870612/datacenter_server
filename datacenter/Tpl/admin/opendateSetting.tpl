<{include file='header.php'}>
<div class="s_tips">
		<i></i>当前位置： <{$_header->getNavigate()}>
</div>
<table width='95%' class='data_list'>
<thead>
<tr><th colspan=2>&nbsp;</th><th colspan='<{$daylist|@count}>'>采集情况</th><th>&nbsp;</th></tr>
<tr>
	<th>服务器名</th>
	<th>开服日</th>
	<{foreach from=$daylist item=item}>
		<th><{$item}>天</th>
	<{/foreach}>
	<th>操作</th>
</tr>
</thead>
<tbody>
<{foreach from=$list item=item key=key}>
<tr>
	<td><{$w2s[$key]}></td>
	<td><{$item.openday}></td>
	<{foreach from=$daylist item=day}>
		<td><{if $item.day[$day]}>已归档<{else}><font color='red'>未归档</font><{/if}></td>
	<{/foreach}>
	<td><a href='index.php?op=edit_opendateSetting&action=admin&zoneid=<{$key}>'>修改</a></td>
</tr>
<{/foreach}>
</tbody>
</table>