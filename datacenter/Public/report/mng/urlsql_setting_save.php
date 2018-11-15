<!DOCTYPE html>
<html>
<?php
	include_once 'mng_s_tpl.php';
	include_once "../../../RPL/rps_mng.php";
	$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';		

	// Initialization
	session_start();
	$rp_tag = 'urlsql_setting';			

	$feedback = '';

	$reqArgs = array("rp_cid", "suid");

	$rejMsg = __checkSaveAccess($reqArgs, $rp_tag);
	if($rejMsg){
		$feedback = $rejMsg;					
	}else{
		$rp_cid = $_POST['rp_cid'];
		$suid = $_POST['suid'];
		$sql1 = isset($_POST['sql1']) ? $_POST['sql1'] : '';
		$sql2 = isset($_POST['sql2']) ? $_POST['sql2'] : '';
		$feedback = __saveModSql($suid, $rp_cid, $sql1, $sql2);
	}
	
	$v = mt_rand(1,10000); 
	$_SESSION['rp_tag'] = $v;

	__getHTMLHead();
	__getHTMLBody($feedback, $_referer);
?>
</html>