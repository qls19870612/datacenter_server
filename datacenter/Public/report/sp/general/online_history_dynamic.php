<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>报表</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="../../resource/lib/bootstrap/bootstrap.css?t=20140324">
	<!-- Add custom CSS here -->
	<link rel="stylesheet" href="../../resource/css/admin.css?t=20140326">
	<link href="../../resource/plugins/font-awesome/css/font-awesome.min.css?t=20140324" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesnt work if you view the page via file: -->
	<!--[if lt IE 9]>
	<script src="../../resource/lib/revise/html5shiv.min.js"></script>
	<script src="../../resource/lib/revise/respond.min.js"></script>
	<![endif]-->

	<!-- add on -->
	<link href="../../resource/plugins/mmgrid/css/mmGrid-c.css?t=20140324" rel="stylesheet">
	<link href="../../resource/plugins/bootstrap-datepicker/css/datepicker3.css?t=20140324" rel="stylesheet">

	<script src="../../resource/lib/jquery/jquery-1.9.1.min.js?t=20140324"></script>
	<script src="../../resource/lib/bootstrap/bootstrap.js?t=20140324"></script>
	<script src="../../resource/plugins/highcharts/highstock.js?t=20140324"></script>
	<script src="../../resource/plugins/bootstrap-daterangepicker/moment.min.js?t=20140324"></script>
	<script src="../../resource/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js?t=20140324"></script>

	<style type="text/css">
		.panel-body{ padding: 0 0 2px 0;}
		.panel-title{font-weight: bold; font-size: 14px}
		.panel-heading{ padding: 4px 10px}
		.panel-heading .ctrl-icon{float: right; cursor: pointer;}

		.panel-primary .ctrl-row{ padding:4px 8px}
		.panel-primary .glyphicon-th{ font-size: 15px}
		.panel-primary .ctrl-wrap{padding:4px 0}
		.panel-primary .ctrl-label{line-height:32px}
		.panel-primary .mod-error{ padding: 14px 0; text-align: center; }
		.panel-primary .dp-mod{ margin-top: 2px}

		.panel-body .btnfm{ margin-bottom: 8px}
		.panel-body .input-group-addon{ background-color: #FFFFFF}
	</style>
</head>
<body style="margin:0">

	<div class="row" id="rpHeader" data-interval="1">
		<div class="col-lg-12">
			<h1>
				<small id="curGameTitle"></small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"> <i class="glyphicon glyphicon-map-marker"></i>
					当前位置 :
				</li>
			</ol>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title"> <i class="glyphicon glyphicon-th-large"></i>
						&nbsp;服务器选择
					</h4>
				</div>
				<div class="panel-body">
					<div data-area="12" data-loadtype="static" data-sqlcontent="1" data-sqlkey="online_by_day_g" data-sqlid="109" data-config="{#@dptimepick#@:0,#@dpmethod#@:1}" data-mtype="datepicker" class="report-mod" style="width:100%; min-height:50px"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title"> <i class="glyphicon glyphicon-th-large"></i>
						&nbsp;服务器选择
					</h4>
				</div>
				<div class="panel-body">
					<div style="width:100%; min-height:50px" class="report-mod" data-mtype="serverlist" data-config="" data-sqlid="" data-sqlkey="" data-sqlcontent="" data-loadtype="static"></div>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">
						<i class="glyphicon glyphicon-th-large"></i>
						&nbsp;历史在线账号
					</h4>
				</div>
				<div class="panel-body">
					<div id="AccountCount" data-stockid="accountcount" class="highchart" style="height: 400px; min-width: 400px"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">
						<i class="glyphicon glyphicon-th-large"></i>
						&nbsp;历史在线角色
					</h4>
				</div>
				<div class="panel-body">
					<div id="PlayerCount" data-stockid="playercount" class="highchart" style="height: 400px; min-width: 400px"></div>
				</div>
			</div>
		</div>
	</div>

	
	<script src="../../resource/js/parser.js?t=20140402" type="text/javascript"></script>
	<script src="../comm/js/rp_sp.js?t=20140402d" type="text/javascript"></script>
	<script src="js/online_history_dynamic.js?t=20140702" type="text/javascript"></script>

</body>
</html>