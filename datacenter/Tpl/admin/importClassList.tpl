<{include file='header.php'}>
<div class="s_tips">
		<i></i>当前位置： <{$_header->getNavigate()}>
</div>
<table width='95%' class='data_list'>
<thead>
<tr><th colspan=3><{$GAME_LIST[$game_db].NAME}> 的活动礼包清单</th></tr>
<tr>
	<th>序号</th><th>礼包ID</th><th>礼包名称</th>
</tr>
</thead>
<tbody>
<{assign var=i value=1}>
<{foreach from=$classList item=item key=key}>
<tr>
	<td><{$i}></td>
	<td><{$item.class_id}></td>
	<td><{$item.class_name}></td>
<{assign var=i value=$i+1}>
</tr>
<{/foreach}>
</tbody>
</table>
<fieldset>
	<legend>导入活动礼包列表</legend>
	<form action='index.php' method='post'>
		<input type='hidden' name='action' value='admin'>
		<input type='hidden' name='op' value='importClassList'>
		<input type='hidden' name='game_db' value='<{$game_db}>'>
		<input type='hidden' name='do' value='save'>
		<div style='float:left;width:200px;height:150px;overflow:hidden;line-height:40px;border-left:1px solid #EEE'>是否追加：<input type='checkbox' checked  name='isadd' value=1><br />注,不选则是覆盖</div>
		<div style='float:left;width:500px;'>ＩＤ名称：<textarea name='list' style='width:350px;'></textarea></div>
		<input type='submit' value='保存' class='search_button' style='width:80px;height:25px;font-weight:bold;font-size:16px;'>
	</form>
</fieldset>
注:示例数据<br />
1,礼包1<br />
2,礼包2<br />
....