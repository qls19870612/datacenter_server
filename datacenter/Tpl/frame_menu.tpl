<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8" />
	<title></title>
	<meta name="keywords" content="" />
	<meta name="Description" content="" />
	<link href="view/css/caomoo.css" rel="stylesheet" type="text/css">
	<script src="view/js/jquery.js" type="text/javascript"></script>
</head>
<body class="sidebar_bd">
<div class="sidebar">
	<div class="now_date"><?php echo date("Y-m-d");?> 星期<?php echo $this->nowday;?></div>
	<dl>
		<?php
			if($this->MenuGroup){
				foreach($this->MenuGroup as $gid=>$gname){
					echo "<dt id='p_M".$gid."'><a onclick=\"ct('M".$gid."')\">".$gname."</a></dt>";
					echo "<dd id='M".$gid."' style='display:none'>";
					if($this->myinfo['level']){
						foreach($this->templatelist as $key=>$item){
							if( (in_array('*',$item['game']) || in_array($this->myinfo['selected_game'],$item['game'] )) && $item['group']==$gid && $item['is_m'] ) {
								if($this->myinfo['level'] || in_array($key,$this->myinfo['function'])){
									echo "<a href='".$item['url']."' target='".(!empty($item['target'])?$item['target']:"main")."' class='submenu'>".$item['t']."</a>";
								}
							}
						}
					}



					echo "</dd>";
				}
			}
		?>
	</dl>
</div>



<script>
function ct(id){
	if($("#"+id).css('display')=='none'){
		$('#p_'+id).addClass('down');
		$("#"+id).css('display','');
	}else{
		$('#p_'+id).removeClass('down');
		$('#'+id).css('display','none');
	}

}
</script>
</body>
</html>