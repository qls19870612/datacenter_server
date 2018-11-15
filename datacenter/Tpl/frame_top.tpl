<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8" />
	<title>系统管理平台</title>
	<meta name="keywords" content="" />
	<meta name="Description" content="" />
	<link href="view/css/caomoo.css" rel="stylesheet" type="text/css">
	<script src="view/js/jquery.js" type="text/javascript"></script>  
</head>
<body>
<div class="header_wrap wf">
	<div class="header center clear">
		<div class="logo fleft"><a href="/?op=systeminfo" target='main'><span>经分系统</span></a></div>
		<div class='fleft tc mc game' style='margin-top:10px;width:300px;'>
			<?php
				if($this->GAME_LIST){
					foreach($this->GAME_LIST as $key=>$game){
						if($this->myinfo['level'] || in_array($key,$this->myinfo['AllowGame'])){
							echo "<a href='javascript:void(0)' onclick='selectgame(\"".$key."\")' id='game_".$key."' class='".($key==$this->myinfo['selected_game']?"selected":"")."'><img src='".$game['LOGO']."' width=40 height=40></a>";
						}//selected_game
					}
				}
			?>
		</div>
		<div class="login">
			欢迎您: <span class="user"><?php echo $this->myinfo['realname'];?></span>,您当前登录的IP是：<span class="user"><?php echo $this->myip;?></span>&nbsp;&nbsp;&nbsp;<a href='index.php?controller=index&method=chgpwd' target='main'>修改密码</a>&nbsp;&nbsp;&nbsp;<a href="index.php?method=logout" target='top'>退出登录</a></div>
		</div>
	</div>
</div>
<script>
function selectgame(gn){
	


	if($('.game').find('.selected').attr('id')==('game_'+gn)){
		return;
	}
	var o={controller:'index',method:'selectedgame',game:gn};
	$.ajax({
        type: 'POST',
        url: 'index.php',
        data: o,
        dataType: 'json',
        success: function (d) {
			    if (d.status) {
                   	$('.game').find('.selected').removeClass('selected');
					$('#game_'+gn).addClass('selected');
					window.parent.reloadwnd('leftFrame','?method=view&id=menu');
					window.parent.reloadwnd('main','?method=systeminfo');

                } else {
					alert('切换游戏失败,请刷新重试');
                }
            }
        })
}
</script>
</body>
</html>