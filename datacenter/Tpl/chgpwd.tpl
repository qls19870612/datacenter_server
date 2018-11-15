<?php $this->includefile('header'); ?>
<div style="width:100%; text-align:left" align="center">
	

	<form method='post' action='index.php' id='editFrm'>
	<input type='hidden' name='controller' value='index'>
	<input type='hidden' name='method' value='chgpwd'>
	<input type='hidden' name='saveedit' value='1'><br />
	<table width="600" border=1 align=center class="data_list">
	  <tr>
	    <th><span class="must_fill">*</span>原密码:</th>
	    <td><input type="password" id="old" name="old" style="width:200px" class="text" /><font color=red id='pwd_err'><?php echo $this->old_err;?></font></td>
	  </tr>
	   <tr>
	    <th><span class="must_fill">*</span>新密码:</th>
	    <td><input type="password" id="newpwd" name="newpwd" style="width:200px" class="text" /><font color=red id='newpwd_err'><?php echo $this->newpwd_err;?></font></td>
	  </tr>	  
	  <tr>
	    <th><span class="must_fill">*</span>重复新密码:</th>
	    <td><input type="password" id="repwd" name="repwd" style="width:200px" class="text" /><font color=red id='repwd_err'><?php echo $this->repwd_err;?></font></td>
	  </tr>

	<tr>
	    <td colspan=2 align=center><input type="submit" value="保存"></td>
	  </tr>


	</table>
	</form>
<br /><br /><br /><br />

</div>
<?php
$this->includefile('footer');
?>