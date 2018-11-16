<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>页面异常</title>

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
<head>

<body style="margin-top:20px">
	<?php
    // config
	$error_type = isset($_GET['et']) ? $_GET['et'] : '';
	$url_host = $_SERVER['HTTP_HOST'];
	$url_login = 'http://'.$url_host . '/report/login.php';
	$url_home = 'http://'.$url_host . '/report/home.php';

    switch ($error_type)
	{
	case 'nologin':
	  $em_ttl = '登录异常';
      $em_des = '未登录或登陆超时，请尝试用下列按钮，或刷新页面后右上角处登陆';
      $em_typ = 'warning';
      $em_ctl = array('login');
	  break;  
	case 'noselectgame':
	  $em_ttl = '选择游戏异常';
      $em_des = '没有选择游戏，或没有该游戏权限，或该游戏不存在。导致无法获取游戏报表信息，请尝试用下列按钮返回首页，或在页面上方导航重新选择游戏';
      $em_typ = 'warning';
      $em_ctl = array('backhome');
	  break;
	case 'noselectreport':
	  $em_ttl = '选择报表异常';
      $em_des = '没有选择报表，或没有该报表权限，或该报表不存在。导致无法获取报表详细信息，请尝试用下列按钮返回首页，或在页面侧栏导航重新选择报表';
      $em_typ = 'warning';
      $em_ctl = array('backhome');
	  break;
	case 'noreport':
	  $em_ttl = '报表加载异常';
      $em_des = '该游戏没有报表，请联系管理员处理';
      $em_typ = 'warning';
      $em_ctl = array('backhome');
	  break;
	case 'requestFails':
	  $em_ttl = '请求失败';
      $em_des = '请求后台配置信息失败，请联系管理员处理';
      $em_typ = 'danger';
      $em_ctl = array('backhome');
	  break;
	default:
	  $em_ttl = '未知异常';
      $em_des = '页面发生未知异常，请尝试用下列按钮返回首页，或重新登陆';
      $em_typ = 'danger';
      $em_ctl = array('backhome', 'login');
	}

	$er_ctrl = array(
		'backhome' => '<button type="button" class="btn btn-default" onclick="javascript:window.parent.location.href=\''.$url_home.'\';">返回首页</button>', 
		'login' => '<button type="button" class="btn btn-'.$em_typ.'" onclick="javascript:window.parent.location.href=\''.$url_login.'\';">重新登陆</button>'
	);

	$crl = '';
	foreach ($em_ctl as $i => $btn) {
		$space = $i > 0 ? '&nbsp;&nbsp;&nbsp;&nbsp;' : '';
		$crl .= isset($er_ctrl[$btn]) ? $space.$er_ctrl[$btn] : '';
	}

	$er_cont = '<div class="col-lg-12"><div class="alert alert-'.$em_typ.' fade in"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><h4>'.$em_ttl.'</h4><p>'.$em_des.'</p><p>&nbsp;</p><p>'.$crl.'</p></div></div>';
    ?>
	<div class="row">
		<?php echo $er_cont; ?>
	</div>
</body>
</html>
