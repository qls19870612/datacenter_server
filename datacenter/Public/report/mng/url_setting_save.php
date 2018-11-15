<!DOCTYPE html>
<html>
<?php
	include_once 'mng_s_tpl.php';
	include_once "../../../RPL/rps_mng.php";
	$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';		

	// Initialization
	session_start();
	$rp_tag = 'url_setting';			

	$feedback = '';

	$reqArgs = array("rp_cid");

	$rejMsg = __checkSaveAccess($reqArgs, $rp_tag);
	if($rejMsg){
		$feedback = $rejMsg;					
	}else{
		$rp_cid = $_POST['rp_cid'];
		if(isset($_POST['addsql']) && $_POST['addsql'] == 1){
			$feedback = __addReportUrlSql($rp_cid);
		}else if(isset($_POST['delsql']) && $_POST['delsql'] == 1 && isset($_POST['suid'])){
			$suid = $_POST['suid'];
			$feedback = __delReportUrlSql($suid, $rp_cid);
		}else{
			$rp_title = isset($_POST['rp_title']) ? $_POST['rp_title'] : '';
			$rp_url = isset($_POST['rp_url']) ? trim($_POST['rp_url']) : '';
			$feedback = __updReportUrl($rp_cid, $rp_title, $rp_url);
		}
	}
	
	$v = mt_rand(1,10000); 
	$_SESSION['rp_tag'] = $v;

	__getHTMLHead();
	__getHTMLBody($feedback, $_referer);
?>
</html>