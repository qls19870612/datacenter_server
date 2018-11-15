<?php
//error_reporting(0);
date_default_timezone_set('Asia/Shanghai');

require_once('controller/ServerCombineAdviceController.php');

$con=new ServerCombineAdviceController();
$con->init();
$con->run();