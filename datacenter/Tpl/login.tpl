<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录运营数据分析中心</title>
<link rel="stylesheet" href="view/css/admin.css" />
<link rel="stylesheet" href="view/css/page_orange.css" />
<script language="javascript" src="view/js/jquery.js"></script>

</head>
<body>
<div style="width:100%; text-align:left" align="center">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td class="tab_left"></td>
	    <td class="tab_middle">
	    	<span style="float:left"><img src="view/images/tab/tb.gif" width="16" height="16" /> 当前位置：运营数据分析登录</span>
		</td>
	    <td class="tab_right"></td>
	  </tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td class="tab_left_2"></td>
	    <td style="padding:2px">
<FORM name="UserLogin"  action="index.php?controller=index&method=login" method="post">
<input type='hidden' name='act' value='login'>
<div style="width:100%;" align="center">
<BR />
<BR />
<table width="400">
<tr>
	<td height="35" align="center" colspan=2><font color='red'><?php echo $this->errmsg;?></font></td>
  </tr>
  <tr>
	<td height="35" align="left">用户名：</td>
	<td height="35" align="left"><input  type="text" name="logname" id="username" /></td>
  </tr>
  <tr>
	<td height="35" align="left">密码：</td>
	<td height="35" align="left">
		<input name="logpwd" id="password"  type="password"/>
	</td>
  </tr>
  <tr>
	<td height="35" align="left">验证码：</td>
	<td height="35" align="left"><input name="code" type="text" id="code" maxlength="4"/>
	<img id="session_pic_check_code" name="session_pic_check_code" src="index.php?controller=index&method=imgcode" border="0" onClick="$(this).src = '?controller=index&method=imgcode&'+Math.random();" alt="看不清请点图片" align="absbottom" /></td>
  </tr>
  <tr>
	<td height="35" align="left">保质期：</td>
	<td height="35" align="left"><select name='keepstatus'>
		<option value=0>默认</option>
		<option value=7>一周</option>
		<option value=30 selected>一个月</option>
	</select>
	</td>
  </tr>
  <tr>
	<td height="35" colspan="2" style="text-align:center">
        <input name="Submit" type="submit" value="确 定" />
        <input type="reset" value="重 输" />
    </td>
  </tr>
</table>
<BR />
</div>
</FORM>

	    </td>
	    <td class="tab_right_2"></td>
	  </tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td class="tab_left_bottom"></td>
	    <td class="tab_middle_bottom">&nbsp;
		</td>
	    <td class="tab_right_bottom"></td>
	  </tr>
	</table>
</div>

</body>
</html>


