<?php
	$this->includefile('header');
?>


<div style="width:100%; text-align:left" align="center">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td class="tab_left_2"></td>
	    <td style="padding:2px">
			

	<form id="form_user" name="form_user" action="index.php" method="get">
	<input type='hidden' name='controller' value='admin'>
	<input type='hidden' name='method' value='admin_list'>
		<table width="100%">
		  <tr>
			<td bgcolor="#FFFFFF">
				关键字:<input type="text" name="kw" class="text" value="<?php echo $this->kw;?>" style="width:150px">

				<input type="submit" value="搜索" class="button">
			</td>
	      </tr>
		  
		</table>
		<input type="hidden" name="act" id="act" value="list">
	</form>

		<table border=1 width=100% class="data_list">
			<thead>
			<tr align="center" height=30 class="list_table">
				<th width=50>ID</td>
				<th width=120>用户名</td>
				<th width=140>名称</td>
				<th width=120>是否管理员</td>
				<th width=100>状态</td>
				<th width=100>操作</td>
			</tr>
			</thead>
			<tbody>
			<?php
				if($this->list)
				{
					$editable=($this->myinfo['level'] || in_array('admin.admin_edit',$this->myinfo['function']))?TRUE:FALSE;
					$delable=($this->myinfo['level'] || in_array('admin.admin_delete',$this->myinfo['function']))?TRUE:FALSE;
					foreach($this->list as $item)
					{
						echo "<tr style='text-align:center'>";
						echo "<td>".$item['id']."</td>";
						echo "<td>".$item['name']."</td>";
						echo "<td>".$item['realname']."</td>";
						echo "<td>".($item['level']==1?"<font color='red'>管理员</font>":"普通")."</td>";
						echo "<td>".($item['stop']!=0?"<font color='red'>关闭</font>":"正常")."</td>";
						echo "<td>";
						echo $editable?("<a href='index.php?controller=admin&method=admin_edit&id=".$item['id']."'>编辑</a>&nbsp;&nbsp;&nbsp;"):'';
						echo $delable?("<a href='index.php?controller=admin&method=admin_delete&id=".$item['id']."'>删除</a>"):'';
						echo "</td>";
						echo "</tr>";
					}
				}else{
					echo "<tr><td colspan=6>未有任何记录</td></tr>";
				}
			?>
			</tbody>
					</table>
				<?php echo $this->page_str;?>
	    </td>
	    <td class="tab_right_2"></td>
	  </tr>
	  </tbody>
	</table>

</div>
<?php $this->includefile('footer');?>