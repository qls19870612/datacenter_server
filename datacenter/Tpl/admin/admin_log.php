<{include file='header.php'}>
<div style="width:100%; text-align:left" align="center">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td class="tab_left"></td>
	    <td class="tab_middle">
	    	<span style="float:left"><img src="/view/images/tab/tb.gif" width="16" height="16" /> 当前位置：用户操作日志查看</span>
		</td>
	    <td class="tab_right"></td>
	  </tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td class="tab_left_2"></td>
	    <td style="padding:2px">
			

	<form id="form_user" name="form_user" action="index.php" method="get">
	<input type='hidden' name='action' value='admin'>
	<input type='hidden' name='op' value='admin_list'>
		<table width="100%">
		  <tr>
			<td bgcolor="#FFFFFF">
				关键字:<input type="text" name="kw" id="kw" value="<{$kw}>" style="width:150px">
				用户名:<input type="text" name="username" id="username" value="<{$username}>" style="width:150px">
				用户ID:<input type="text" name="user_id" id="user_id" value="<{$user_id}>" style="width:150px">
				<input type="submit" value="搜索" class="admin_input_btn">
			</td>
	      </tr>
		  
		</table>
		<input type="hidden" name="act" id="act" value="list">
	</form>

		<table border=1 width=100% class="data_list">
			<tr align="center" height=30 class="list_table">
				<th width=50>ID</td>
				<th width=100>使用的用户名</td>
				<th width=100>用户ID</td>
				<th width=120>操作事项</td>
				<th >操作描述</td>
				<th width=100>IP</td>
				<th width=100>操作时间</td>
				<th width=100>是否成功</td>
			</tr>
			<{foreach from=$list item=item}>
				<tr style='text-align:center'>
				<td><{$item.id}></td>
				<td><{$item.username}></td>
				<td><{$item.user_id}></td>
				<td><{$item.op_title}></td>
				<td><{$item.op_desc}></td>
				<td><{$item.op_ip|@long2ip}></td>
				<td><{$item.op_time|date_format:"%Y-%m-%d %H:%M:%S"}></td>
				<td><{if $item.is_success==1}><font color='green'>成功</font><{else}><font color='red'>失败[<{$item.is_success}>]</font><{/if}></td>

				</tr>
			<{foreachelse}>
				<tr>
					<td align=center colspan=8><font color='red'>没有日志</td>
				</tr>
			<{/foreach}>
					</table>
				<{$page_str}>
	

	    </td>
	    <td class="tab_right_2"></td>
	  </tr>
	</table>

</div>
<{include file='footer.php'}>