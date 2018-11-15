<?php
$this->includefile('header');
?>
<div style="width:100%; text-align:left" align="center">
	<form   onsubmit='return submitFrm(this)' id='editFrm'>
	<input type='hidden' name='controller' value='admin'>
	<input type='hidden' name='method' value='admin_edit'>
	<input type='hidden' name='saveedit' value='1'><br />
	<input type='hidden' name='id' value='<?php echo $this->info['id'];?>'>
	<table width="600" border=1 align=center class="data_list">
	  <tr>
	    <th width=100><span class="must_fill">*</span>登录帐号:</th>
	    <td><?php echo $this->info['name'];?></td>
	  </tr>
	  <tr>
	    <th><span class="must_fill">*</span>登录密码:</th>
	    <td><input type="password" class="text" id="pwd" name="pwd" style="width:200px" /><font color='red' id='pwd_err'><?php echo $this->pwd_err;?></font></td>
	  </tr>
	  <tr>
	    <th><span class="must_fill">*</span>重复密码:</th>
	    <td><input type="password" class="text" id="repwd" name="repwd" style="width:200px" /><font color=red id='repwd_err'><?php echo $this->repwd_err;?></font></td>
	  </tr>	  
	  <tr>
	    <th><span class="must_fill">*</span>真实姓名:</th>
	    <td><input type="text" id="realname" class="text" name="realname" style="width:200px"  value='<?php echo $this->info['realname'];?>'/><font color=red id='realname_err'><?php echo $this->realname_err;?></font></td>
	  </tr>

	  <tr>
	    <th><span class="must_fill">*</span>状态:</th>
	    <td><select name='stop' id='stop'><option value='1'>关闭</option><option value=0 <?php if(!$this->info['stop']) echo 'selected';?>>开放</option></select></td>
	  </tr>
	  <tr>
	    <th><span class="must_fill">*</span>角色:</th>
	    <td><select name='level' id='level' onchange='showgroup()'><option value='0'>普通</option><option value=1  <?php if($this->info['level']) echo 'selected';?>>管理员</option></select></td>
	  </tr>
	  <tr id='grouplist'>
	    <th><span class="must_fill">*</span>选择权限组:</th>
	    <td>
		<?php
			if($this->grouplist){
				foreach($this->grouplist as $key=>$item){
					echo "<span class='checkbox_item'><label><input type='checkbox' name='group[]' value='".$item['id']."' ".(in_array($item['id'],$this->info['grouplist'])?'checked':'').">".$item['name']."</label></span>";
				}
			}
		?>
		</td>
		</tr>
	 <tr>
	    <th><span class="must_fill">*</span>允许游戏:</th>
	    <td>
			<?php
				if($this->GAME_LIST){
					foreach($this->GAME_LIST as $gamecode=>$game){
						echo "<span class='checkbox_item'><label><input type='checkbox' name='allowgame[]' value='".$gamecode."' ".(in_array($gamecode,$this->info['AllowGame'])?"checked":'').">".$game['gamename']."</label></span>";
					}
				}
			?>
		</td>
	  </tr>
		<tr id='allowplatform'>
	    <th><span class="must_fill">*</span>允许平台:</th>
	    <td>
			<?php if($this->PLATFORM){
				foreach($this->PLATFORM as $p)
				{
					if($p){
						echo "<span class='checkbox_item'><label><input type='checkbox' name='allowplatform[]' value='".$p."' ".(in_array($p,$this->info['AllowPlatform'])?'checked':'')." >".$p."</label></span>";
					}
				}
			}
			?>
		</td>
	  </tr>
	<tr>
	    <td colspan=2 align=center><input type="submit" value="保存">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="返回列表" onclick="location.href='index.php?controller=admin&method=admin_list'" /></td>
	</tr>
</table>
	</form>
<br /><br /><br /><br />

</div>
<script>
$(function(){
	showgroup();
})
function showgroup(){
	if(!parseInt($('#level').val())){
		$('#grouplist').show();
		$('#allowgame').show();
		$('#allowplatform').show();
	}else{
		$('#grouplist').hide();
		$('#allowgame').hide();
		$('#allowplatform').hide();
	}
}
function submitFrm(obj){

	$(obj).find('font').html('');
	if($.trim($(obj).find('input[name=pwd]').val())!='' && $.trim($(obj).find('input[name=pwd]').val()).length<6){
		$('#pwd_err').html('登录密码为6-18位字符');
	}else if($.trim($(obj).find('input[name=pwd]').val())!='' && $.trim($(obj).find('input[name=repwd]').val())==''){
		$('#repwd_err').html('请重复一次密码');
	}else if($.trim($(obj).find('input[name=repwd]').val())!=$.trim($(obj).find('input[name=pwd]').val())){
		$('#repwd_err').html('两次密码不一致');
	}else if($.trim($(obj).find('input[name=realname]').val())==''){
		$('#realname_err').html('请填写真实姓名');
	}else{
		var o=$(obj).serialize();
		$.ajax({
			type:'POST',
			url:'index.php',
			data:o,
			dataType:'json',
			success:function(d){
				if(d.status){
					alert('保存成功');
					location.href='?controller=admin&method=admin_list';
				}else{
					alert(d.msg);
				}
			}
		})
	}
	return false;
}
</script>
<?php
$this->includefile('footer');
?>