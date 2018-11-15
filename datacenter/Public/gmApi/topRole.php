<?php
error_reporting(0);
date_default_timezone_set('Asia/Shanghai');

require_once('controller/TopRoleController.php');

$con=new TopRoleController();
$con->init();
$con->run();

