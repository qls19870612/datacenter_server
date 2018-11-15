<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title></title>
  <meta name="Author" content="Ashen" />
	<link href="view/css/caomoo.css" rel="stylesheet" type="text/css">
	<script src="view/js/jquery.js" type="text/javascript"></script>

<style>
table.list th{border:1px solid #EEE;height:35px;background:#EEEEEE;}
.w300{height:30px;width:300px;float:left;margin:5px;border:2px solid #EEE;background:#ebfbb7;font-weight:bold;padding-left:20px}
.w100pc{height:30px;margin:5px;padding:5px;border:2px solid #EEE;background:#ebfbb7;font-weight:bold;}
.searchbtm{height:30px;padding:0 10px;}
.checkbox_item{padding:3px;}
</style>
</head>
<body>
<div class="s_tips">
		<i></i>当前位置： <?php
			$myMenu=empty($this->FunctionList[$this->Navigate])?NULL:$this->FunctionList[$this->Navigate];
			if($myMenu){
				echo (empty($this->MenuGroup[$myMenu['group']])?'':$this->MenuGroup[$myMenu['group']]." -> ").$myMenu['t'];
			}
		?>
</div>
<?php
	if($this->msg)
	{
		echo '<div class="message">'.$msg.'</div>';
	}
?>