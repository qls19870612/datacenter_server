<!DOCTYPE html>
<html ng-app="dataCenterApp">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<title>运营分析系统</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="lib/bootstrap/bootstrap.css">

	<!-- Add custom CSS here -->
	<link rel="stylesheet" href="css/admin.css">
	<link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">

	<script src="lib/angalur/angular.min.js"></script>
	<script src="lib/angalur/angular-cookies.min.js"></script>

	<script src="js/angalur_mvc/app.js"></script>
	<script src="js/angalur_mvc/controllers.js"></script>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="lib/revise/html5shiv.min.js"></script>
		<script src="lib/revise/respond.min.js"></script>
	<![endif]-->
<body ng-controller="appController">
	<div id="wrapper" >
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" ng-controller="navigationCtrl" ng-include="navigationTpl.url" ></nav>
	</div>
</body>
<script src="lib/jquery/jquery-1.10.2.js"></script>
<script src="lib/bootstrap/bootstrap.js"></script>
<script type="text/javascript">

	
</script>

</html>