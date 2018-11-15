<{include file='header.php'}>
<div class="s_tips">
		<i></i>当前位置： <{$_header->getNavigate()}>
</div>
<table width='95%' class='data_list'>
<thead>
<tr><th colspan=4><{$GAME_LIST[$game_db].NAME}> 的物品清单</th></tr>
<tr>
	<th>序号</th><th>物品ID</th><th>物品名称</th><th>物品类型</th>
</tr>
</thead>
<tbody>
<{assign var=i value=1}>
<{foreach from=$itemList item=item key=key}>
<tr>
	<td><{$i}></td>
	<td><{$item._id}></td>
	<td><{$item._name}></td>
	<td><{$item._type}></td>
<{assign var=i value=$i+1}>
</tr>
<{/foreach}>
</tbody>
</table>
<fieldset>
	<legend>导入物品列表</legend>
	<form action='index.php' method='post'>
		<input type='hidden' name='action' value='admin'>
		<input type='hidden' name='op' value='importItemList'>
		<input type='hidden' name='game_db' value='<{$game_db}>'>
		<input type='hidden' name='do' value='save'>
		<div style='float:left;width:200px;height:150px;overflow:hidden;line-height:40px;border-left:1px solid #EEE'>是否追加：<input type='checkbox'  checked name='isadd' value=1><br />注,不选则是覆盖</div>
		<div style='float:left;width:500px;'>ＩＤ名称：<textarea name='list' style='width:350px;'></textarea></div>
		<input type='submit' value='保存' class='search_button' style='width:80px;height:25px;font-weight:bold;font-size:16px;'>
	</form>
</fieldset>
注:示例数据<br />
1,物品1,物品类型1<br />
2,物品2,物品类型2<br />
....