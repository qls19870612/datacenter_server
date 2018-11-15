<?php 
	require_once("easyCRUD.class.php");

	class SQL_TPL  Extends Crud {
		
			# Your Table name 
			protected $table = 'sql_tpl';
			
			# Primary Key of the Table
			protected $pk	 = 'suid';
	}

?>