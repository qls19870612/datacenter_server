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

<body style="background: center 50px no-repeat #f4f4ec;">
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
      </div>
      <div id="selectGame"></div>
      <div id="navCollapse" class="collapse navbar-collapse navbar-ex1-collapse"></div>
    </nav>
    <!-- main -->
    <div id="main">

      <div class="col-md-8 col-md-offset-2">
        <div id="login_wrap">
          <div class="modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="display:none">×</button>
                  <h4 class="modal-title">运营分析系统登录</h4>
                </div>
                <div class="modal-body">
                  <div id="TopTips"></div>
                  <form role="form" id="loginForm">
                    <div class="form-group">
                      <label for="inputName">用户名：</label>
                      <input type="email" class="form-control" id="inputName" placeholder="请输入用户名"></div>
                    <div class="form-group">
                      <label for="inputPassword">密码：</label>
                      <input type="password" class="form-control" id="inputPassword" placeholder="请输入密码"></div>
                    <div class="checkbox">
                      <label for="inputKeepstatus">
                        <input id="inputKeepstatus" type="checkbox">一个月内自动登录</label>
                    </div>
                    <button id="loginSubmit" type="button" class="btn btn-primary">登录</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="resource/js/comm.js?t=20140514"></script>
  <script type="text/javascript">
  $(function() {
   $('#loginForm input').on('keydown', function(e) {
     var curKey = e.which;
     if (curKey == 13) {
       __userLoginP();
     }
   })
   $('#loginSubmit').on('click', function() {
     __userLoginP();
   })

   function __userLoginP() {
     var _username = $('#inputName').val();
     var _password = $('#inputPassword').val();
     var _keepstatus = $('#inputKeepstatus').is(':checked') ? 30 : null;
 
     $.ajax({
       url: APP_STATUS.url.request,
       type: 'POST',
       dataType: 'json',
       data: {
         controller: 'ajax',
         method: 'login',
         logname: _username,
         logpwd: _password,
         keepstatus: _keepstatus
       },
       success: function(d) {
         if (d.code == 200) {
           $.cookie('APP_NOTICE', 'success|用户' + _username + '，登录成功');
           window.location = APP_STATUS.url.home;
         } else {
           __showGeneralTips('LIP_tips', "#TopTips", 'danger', d.msg, 3000);
         }
       },
       error: function() {
         __showGeneralTips('LIP_tips', "#TopTips", 'danger', '请求失败='+APP_STATUS.url.request, 3000);
       }
     })
   }
 })
</script>
</body>
</html>