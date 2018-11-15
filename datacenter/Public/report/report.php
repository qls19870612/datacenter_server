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
  <script src="resource/lib/jquery/jquery-1.9.1.min.js?t=20140514"></script>
  <script src="resource/lib/jquery/jquery.cookie.js?t=20140514"></script>
  <script src="resource/lib/bootstrap/bootstrap.js?t=20140514"></script>
  <script type="text/javascript">
    function resizeIframe(obj) {
      obj.style.height = (obj.contentWindow.document.body.scrollHeight + 50) + 'px';
    }
  </script>
</head>
<body onresize="javascript:resizeIframe(document.getElementById('reportCase'))">
  <?php
    // config
    include_once "../../RPL/rps_frame_layout.php";
    $_ISLOGIN = false;
    $_CLIENTIP = __GET_CLIENT_IP();

    $_NICKNAME = '';
    $_SELECTED_GAME = '';
    $_ALLOW_GAME = array();

    $_LEVEL = 0;
    $_ALLOW_PLATFORM = array();

    session_start();
    if(!empty($_SESSION['admin'])){
      // var_dump($_SESSION['admin']);
        $_ISLOGIN = true;
        if(isset($_GET['sgame'])){
          $_SESSION['admin']['selected_game'] = $_GET['sgame'];
        }

        $_ADMININFO = $_SESSION['admin'];
        $_NICKNAME = isset($_ADMININFO['realname']) ? $_ADMININFO['realname'] : '未知用户';
        $_SELECTED_GAME = isset($_ADMININFO['selected_game']) ? $_ADMININFO['selected_game'] : '';
        $_ALLOW_GAME = isset($_ADMININFO['AllowGame']) ? $_ADMININFO['AllowGame'] : array();
        if(empty($_SELECTED_GAME) && count($_ALLOW_GAME)>0){
          $_SELECTED_GAME = $_ALLOW_GAME[0];
        }

        $_LEVEL = isset($_ADMININFO['level']) ? $_ADMININFO['level'] : 0;
        $_ALLOW_PLATFORM = isset($_ADMININFO['AllowPlatform']) ? $_ADMININFO['AllowPlatform'] : array();
    }

    $__OUTPUT = array(
      'GAME_SELECTOR' => __GAME_SELECTOR($_SELECTED_GAME, $_ALLOW_GAME),
      'LOGIN_CONTROLLER' => __LOGIN_CONTROLLER($_ISLOGIN, $_NICKNAME, $_CLIENTIP),
      'GAME_REPORTS' => '',
      'GAME_PLATFORMS' => __GAME_PLATFORM($_LEVEL, $_SELECTED_GAME, $_ALLOW_PLATFORM),
      'REPORT_CASE' => '',
      'GAME_REPORTS_SP' => ''
    );
  ?>
  <div id="wrapper">
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
      <div id="selectGame">
        <?php echo $__OUTPUT['GAME_SELECTOR']; ?></div>
      <div class="collapse navbar-collapse navbar-ex1-collapse" id="navCollapse">
        <ul class="nav navbar-nav navbar-right navbar-user" style="margin-right:-15px">
          <?php echo $__OUTPUT['LOGIN_CONTROLLER']; ?></ul>
        <div class="side-nav-wrap" id="sideNavWrap">
          <ul class="nav navbar-nav side-nav"></ul>
        </div>

      </div>
    </nav>

    <div id="main">

      <div id="page-wrapper" style="overflow: hidden;">
        <div id="TopTips"  style="margin:10px 0 -10px 0"></div>
        <div id="iframeLoading" style="padding:12px 0 0 0; display:none" class="row" >
          <div style="background: url(resource/images/GUI/loading2.gif) center top no-repeat; height: 32px;" class="loading"></div>
          <div>
            <p style="text-align:center;">正在加载...</p>
          </div>
        </div>
        <iframe name="Stack" src="" width="100%" frameborder="0" scrolling="no" id="reportCase" onload="javascript:resizeIframe(this)"></iframe>
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
              <input type="text" placeholder="请输入用户名" id="LP_username" class="form-control" ></div>
            <div class="form-group">
              <label for="LP_password">密码：</label>
              <input type="password" placeholder="请输入密码" id="LP_password" class="form-control" ></div>
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
  <!-- 服务器列表 -->
  <?php echo $__OUTPUT['GAME_PLATFORMS']; ?>
  <script type="text/javascript" src="resource/js/comm.js?t=20140514"></script>
  <script type="text/javascript" src="resource/js/report.js?t=20140703"></script>
</body>
</html>