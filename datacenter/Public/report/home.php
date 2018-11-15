<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>运营分析系统</title>

  <!-- Bootstrap core CSS -->
  <link href="resource/lib/bootstrap/bootstrap.css?t=20140514" rel="stylesheet">
  <!-- Add custom CSS here -->
  <link href="resource/css/admin.css?t=20140514" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesnt work if you view the page via file: -->
  <!--[if lt IE 9]>
  <script src="resource/lib/revise/html5shiv.min.js"></script>
  <script src="resource/lib/revise/respond.min.js"></script>
  <![endif]-->

  <!-- add on -->
  <script src="resource/lib/jquery/jquery-1.10.2.js?t=20140514"></script>
  <script src="resource/lib/jquery/jquery.cookie.js?t=20140514"></script>
  <script src="resource/lib/bootstrap/bootstrap.js?t=20140514"></script>
</head>

<body>
	 <?php
    // config
    include_once "../../RPL/rps_frame_layout.php";
    include "../../RPL/rps_config.php";

    $_ISLOGIN = false;
    $_CLIENTIP = __GET_CLIENT_IP();

    $_NICKNAME = '';
    $_ALLOW_GAME = array();
    $_LEVEL = 0;

    session_start();
    if(!empty($_SESSION['admin'])){
      // var_dump($_SESSION['admin']);
        $_ISLOGIN = true;
        $_ADMININFO = $_SESSION['admin'];
        $_NICKNAME = isset($_ADMININFO['realname']) ? $_ADMININFO['realname'] : '未知用户';

        $_ALLOW_GAME = isset($_ADMININFO['AllowGame']) ? $_ADMININFO['AllowGame'] : array();

        $_LEVEL = isset($_ADMININFO['level']) ? $_ADMININFO['level'] : 0;
    }

    $__OUTPUT = array(
      'LOGIN_CONTROLLER' => __LOGIN_CONTROLLER($_ISLOGIN, $_NICKNAME, $_CLIENTIP),
      'GAMES_LIST' => __GAMES_LIST($_ISLOGIN, $_LEVEL, $_ALLOW_GAME),
      'MORE_MENU' => __MORE_MENU($other_admin_menu,$foreign_admin_menu,$tool_menu)
    );

    
  ?>
	<div id="wrapper" style="padding:0">
		<!-- navbar -->
		<nav id="navbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="home.php">运营分析系统</a>
				<input id="serverListShow" type="hidden"  data-toggle="modal" data-target="#serverList"></div>
			
			<div class="collapse navbar-collapse navbar-ex1-collapse" id="navCollapse">
				<ul class="nav navbar-nav navbar-right navbar-user" style="margin-right:-15px">
					<?php echo $__OUTPUT['LOGIN_CONTROLLER']; ?>
				</ul>
			</div>
		</nav>
		<!-- main -->
		<div id="main">
			<style type="text/css">
		      #main .cat_title{ padding: 5px; font-size: 20px}
		      #main .catalog{ padding: 0 5px; overflow: hidden;}
		      #main .container_m{ padding: 15px 0}
		      #main .g_item{text-align: center; padding-top:10px; }
		      #main .g_item_w{cursor: pointer; }
		      #main .g_item_w:hover{ background-color: #A9CEED}
		      #main .g_title{ text-align: center;}
		      #main .g_item img{ margin: 0 auto}
		      #main .addpadding{ padding: 0 10px}
		      #main .panel{ margin-bottom: 0}
		      #main .ordermenu .panel-heading{background-color: #77b3d4}
		      #main .tool_collection .panel-heading .cat_title a{ color: #FFF}

		      #main .invalid img{opacity:0.3; filter:alpha(opacity=30)}
		      #main .invalid p{color: #ccc}
              .img-responsive {border-radius: 50%;}
		    </style>
			<div id="page-wrapper" style="overflow: hidden;">
				<div class="col-md-8 col-md-offset-2">
					<div id="home_page" class="row container_m">
						<div class="col-lg-12">
							<h1>
								运营分析系统
								<small>门户</small>
							</h1>
							<div id="TopTips"></div>
						</div>
					</div>
					<div id="accordion" class="panel-group container_m">
						<?php echo $__OUTPUT['GAMES_LIST']; ?>

					</div>
					<?php echo $__OUTPUT['MORE_MENU']; ?>
					<!-- <div id="tool_collection" class="container_m">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title cat_title">
									<a data-toggle="collapse" data-toggle="collapse" href="#tools_panel">其他工具</a>
								</h3>
							</div>
							<div class="catalog collapse panel-collapse" id="tools_panel">
								<div class="addpadding row">
									<div class="col-lg-6">
										<div class="row">
											<div class="col-xs-4 g_item_w">
												<a href="http://gm.2qi.net:81/index.php?action=index&op=index" target="_blank">
												<div class="g_item">
													<img class="img-responsive" src="resource/images/GUI/gamecontroller.png" alt="#">
													<p class="g_title">GM工具</p>
												</div>
												</a>
											</div>

											<div class="col-xs-4 g_item_w">
												<a href="mng/report_setting.php" target="_blank">
												<div class="g_item">
													<img class="img-responsive" src="resource/images/GUI/toolbox.png" alt="#">
													<p class="g_title">系统设置</p>
												</div>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
				</div>

			</div>
		</div>
	</div>
	<!-- loginBox -->
	<div style="padding-top: 100px; display: none;" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="loginPopups" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
					<h4 class="modal-title">运营分析系统登录</h4>
				</div>
				<div class="modal-body">
					<div id="LoginTips"></div>
					<form role="form">
						<div class="form-group">
							<label for="LP_username">用户名：</label>
							<input type="text" placeholder="请输入用户名" id="LP_username" class="form-control"></div>
						<div class="form-group">
							<label for="LP_password">密码：</label>
							<input type="password" placeholder="请输入密码" id="LP_password" class="form-control"></div>
						<div class="checkbox">
							<label for="LP_keepstatus">
								<input id="LP_keepstatus" type="checkbox" value="1">一个月内自动登录</label>
						</div>
						<button class="btn btn-primary" type="button" id="LP_submit" onclick="__userLogin()">登录</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="resource/js/comm.js?t=20140514"></script>
	<script type="text/javascript">
		$(function() {
			$('#accordion').on('click', '.itm_game', function(){
				var loginInfo = $('#loginInfo').length;
				if(loginInfo > 0){
					var _itmg = $(this);
					if(_itmg.hasClass('invalid')){
						__showGeneralTips('login_t', "#TopTips", 'warning', '你没有该游戏权限', 3000);
					}else{
						var gamecode = _itmg.data('gameid');
						window.location = APP_STATUS.url.report + '?sgame=' + gamecode;
					}
				}else{
					var msg = '登录后才能查看报表，<a href="'+APP_STATUS.url.login+'" class="alert-link">点击此处登陆</a>';
					__showGeneralTips('login_t', "#TopTips", 'warning', msg, 0);
				}
			})
		})
	</script>
</body>
</html>