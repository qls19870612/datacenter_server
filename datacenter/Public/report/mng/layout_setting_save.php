<!DOCTYPE html>
<html>
<?php
	include_once 'mng_s_tpl.php';
	include_once "../../../RPL/rps_mng.php";
	$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';		

	// Initialization
	session_start();
	$rp_tag = 'layout_setting';			

	$feedback = '';

	$reqArgs = array("rp_cid", "rp_config", "rp_rm");

	$rejMsg = __checkSaveAccess($reqArgs, $rp_tag);
	if($rejMsg){
		$feedback = $rejMsg;					
	}else{
		$rp_cid = $_POST['rp_cid'];
		$rp_config = $_POST['rp_config'];
		$rp_rm = $_POST['rp_rm'];
		$rp_title = isset($_POST['rp_title']) ? $_POST['rp_title'] : '';
		$rp_interval = (isset($_POST['rp_interval']) && $_POST['rp_interval'] >= 0) ? $_POST['rp_interval'] : 7;
		$rp_start = (isset($_POST['rp_start']) && $_POST['rp_start'] >= 0) ? $_POST['rp_start'] : 0;
		$rp_list = (isset($_POST['rp_list']) && $_POST['rp_list'] >= 0) ? $_POST['rp_list'] : 0;
		$feedback = __updReportLayout($rp_cid, $rp_config, $rp_rm, $rp_title, $rp_interval, $rp_start, $rp_list);
	}
	
	$v = mt_rand(1,10000); 
	$_SESSION['rp_tag'] = $v;

	__getHTMLHead();
	__getHTMLBody($feedback, $_referer);
?>
</html>