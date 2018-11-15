<?php

require("pdodb/Db.class.php");
$db = new Db();


function  __REPORT_MODS ($rp_cid){
	global $db;
	$report_item = $db->row("SELECT * FROM report_layout WHERE rp_cid = :rp_cid", array("rp_cid"=>$rp_cid));
	return $report_item;
}


function __MOD_DETAIL ($suid){
	global $db;
	$mod_item_detail = $db->row("SELECT * FROM sql_tpl WHERE suid = :suid", array("suid"=>$suid));
	return $mod_item_detail;
}
