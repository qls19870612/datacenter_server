<!DOCTYPE html>
<html>
<?php 
	include_once 'mng_s_tpl.php';
	include_once "../../../RPL/rps_mng.php";
	$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';		

	// Initialization
	session_start();
	$rp_tag = 'detail_setting';			

	$feedback = '';

	$reqArgs = array("mod_config", "suid");

	$rejMsg = __checkSaveAccess($reqArgs, $rp_tag);
	if(0){
		$feedback = $rejMsg;					
	}else{
		$mod_config = $_POST['mod_config'];
		$suid =  $_POST['suid'];
		$sqlt =  isset($_POST['sqlt']) ? trim($_POST['sqlt']) : '';
		$sqltp = isset($_POST['sqltp']) ? trim($_POST['sqltp']) : '';
		$title = isset($_POST['rp_title']) ? trim($_POST['rp_title']) : '';
		$sql_key = isset($_POST['sql_key']) ? trim($_POST['sql_key']) : '';
		$feedback = __updModSetting($mod_config, $sql_key, $sqlt, $suid, $sqltp);
	}
	
	// $v = mt_rand(1,10000); 
	// $_SESSION['rp_tag'] = $v;

	__getHTMLHead();
	__getHTMLBody($feedback, $_referer);
?>
</html>