<?php 
	require_once("easyCRUD.class.php");

	class REPORT_LAYOUT  Extends Crud {
		
			# Your Table name 
			protected $table = 'report_layout';
			
			# Primary Key of the Table
			protected $pk	 = 'rp_cid';
	}

?>