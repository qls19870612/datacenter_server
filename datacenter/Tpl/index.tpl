<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>运营分析系统</title>
	<script src="view/js/jquery.js" type="text/javascript"></script>  

	<style>
		body,div,table,hr,tr,td{margin:0;padding:0;font-size:12px;}
		
	</style>
</head>
<body onresize=javascript:resizeit()>

<table border=0 cellpadding=0 cellspacing=0 width='100%' height='100%'>
	<tr height=65><td colspan=2>
		<iframe id="topFrame" name="topFrame" frameborder="no" scrolling='no' src="?method=view&id=top" width='100%' style='margin:0;padding:0;height:65px'></iframe>
	</td></tr>
	<tr>
		<td width=185>
			<iframe id="leftFrame" name="leftFrame" frameborder="no" src="?method=view&id=menu" width='100%' style='margin:0;padding:0;height:100%'></iframe>
		</td>
		<td>
			<iframe id="main" name="main" frameborder="no" scrolling='auto' src="?method=systeminfo" width='100%' height=100% style='margin:0;padding:0;width:100%;'></iframe>
		</td>
	</tr>
</table>

<script>
$(function(){
	//alert($('body').height());
	$('#main').height($('body').height()-70);

})
function resizeit(){
	$('#main').height($('body').height()-70);
}
function reloadwnd(wnd,src){
	//alert(wnd);
	//$('#'+wnd).remove();
	console.log(src);
	console.log($('#'+wnd).attr('src'));
	$("#"+wnd).attr('src',src);
}
</script>
</body>
</html>
