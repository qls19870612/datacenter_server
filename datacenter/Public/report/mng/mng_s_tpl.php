<?php
	function __getHTMLHead(){
		echo '<head><meta charset="utf-8"/><title>页面配置系统</title><style type="text/css">.clearfix:after{content:".";display:block;height:0;clear:both;visibility:hidden}.clearfix{*+height:1%;}#main .content-wrap{ width: 800px; margin: 0 auto; padding: 10px 0}</style><script src="sp/jquery-1.9.1.min.js"></script></head>';
	}
	function __getHTMLBody($feedback='未知错误', $_referer=''){
		echo '<body><div id="main"><div class="content-wrap"><div class="sys-output">'.$feedback.'</div><div id="goBack" data-url="'.$_referer.'"><p class="back-tips">在&nbsp;<span id="countDown" style="color:#FF0000">2</span>&nbsp;秒后返回上一页</p></div></div></div><script src="sp/mng_comm.js?t=20140527" type="text/javascript"></script></body>';
	}
	
