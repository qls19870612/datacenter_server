<?php
$this->includefile('header');
?>

<div style="width:100%; text-align:left" align="center">

	<form  method='post' action='index.php' id='editFrm'>
	<input type='hidden' name='controller' value='admin'>
	<input type='hidden' name='method' value='edit_admin_group'>
	<input type='hidden' name='id' value='<?php echo $this->info['id'];?>'>
	<input type='hidden' name='saveedit' value='1'><br />
	<table class="data_list" border="1" align="center" class="data_list" width="600" >
	  <tr>
	    <th width=120><span class="must_fill">*</span>权限组名称:</th>
	    <td><input type="text" class="text" name="name" style="width:200px" value='<?php echo $this->info['name'];?>'/></td>
	  </tr>
		<tr id='grouplist'>
	    <th><span class="must_fill">*</span>选择权限:</th>
	    <td>
			<?php
				if($this->MenuGroup){
					foreach($this->MenuGroup as $groupid=>$groupname){
						echo "<p style='font-weight:bold; display: block;clear: both'>".$groupname."</p>";
						if($this->FunctionList){
							foreach($this->FunctionList as $key=>$item){
								if($groupid==$item['group']){
									echo "<span class='checkbox_item'><label><input type='checkbox' name='power[]' value='".$key."' ".(in_array($key,$this->info['function'])?"checked":"").">&nbsp;".$item['t']."</label></span>";
								}
							}
						}
					}
				}
			?>
		</td>
		</tr>
		<tr>
			<th><span class="must_fill">*</span>报表权限:</th>
			<td>
				<?php
					if($this->report_power){
						foreach($this->report_power as $group){
							if($group['menu']){
								echo "<fieldset><legend>".$group['groupname']."</legend>";
								foreach($group['menu'] as $m){
									echo '<span class="checkbox_item"><label><input type="checkbox" name="power[]" value="'.$m['id'].'" '.(in_array($m['id'],$this->info['function'])?"checked":"").'>&nbsp;'.$m['rp_title'].'</label></span>';

								}

								echo '</fieldset>';
							}
						}
					}
				?>
			</td>
		</tr>
	<tr>
	    <td colspan=2 align=center><input type="submit" value="保存">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="返回列表" onclick="location.href='index.php?action=admin&op=admin_group_list'" /></td>
	  </tr>


	</table>
	</form>
<br /><br /><br /><br />

</div>
<?php
$this->includefile('footer');
?>