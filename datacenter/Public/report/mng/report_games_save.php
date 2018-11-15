<!DOCTYPE html>
<html>
<?php
	include_once 'mng_s_tpl.php';
	include_once "../../../RPL/rps_mng.php";
	$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';		

	// Initialization
	session_start();
	$rp_tag = 'report_games';			

	$feedback = '';

	$reqArgs = array("rp_cid", "gamecode");

	$rejMsg = __checkSaveAccess($reqArgs, $rp_tag);
	if($rejMsg){
		$feedback = $rejMsg;					
	}else{
		$rp_cid = $_POST['rp_cid'];
		$gamecodestr = $_POST['gamecode'];
		$feedback= __reportGamesSave($rp_cid, $gamecodestr);
	}
	
	$v = mt_rand(1,10000); 
	$_SESSION['rp_tag'] = $v;

	__getHTMLHead();
	__getHTMLBody($feedback, $_referer);
?>
</html>