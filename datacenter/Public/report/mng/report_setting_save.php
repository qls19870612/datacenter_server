<!DOCTYPE html>
<html>
<?php
	include_once 'mng_s_tpl.php';
	include_once "../../../RPL/rps_mng.php";
	$_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';		

	// Initialization
	session_start();
	$rp_tag = 'report_setting';	//###				

	$feedback = '';

	$reqArgs = array("act", "nrp_cid");

	$rejMsg = __checkSaveAccess($reqArgs, $rp_tag);
	if($rejMsg){
		$feedback = $rejMsg;					
	}else{
		if($_POST['act'] == 'add'){
			$rp_cid = isset($_POST['nrp_cid']) ? trim($_POST['nrp_cid']) : '';
			$rp_like = isset($_POST['nrp_like']) ? $_POST['nrp_like'] : '';
			$rp_title = isset($_POST['nrp_title']) ? $_POST['nrp_title'] : '报表页';
			$rp_url = isset($_POST['nrp_url']) ? trim($_POST['nrp_url']) : '';
			if(empty($rp_like)){
				$feedback= __addReport($rp_cid, $rp_title, $rp_url);
			}else{
				$feedback= __addReportLike($rp_cid, $rp_title, $rp_url, $rp_like);
			}
		}elseif($_POST['act'] == 'remove'){
			$rp_cid = isset($_POST['nrp_cid']) ? trim($_POST['nrp_cid']) : '';
			$feedback= __delReport($rp_cid);
		}else{
			$feedback='<p>无效方法</p>';
		}
	}
	$v = mt_rand(1,10000); 
	$_SESSION['rp_tag'] = $v;

	__getHTMLHead();
	__getHTMLBody($feedback, $_referer);
?>
</html>