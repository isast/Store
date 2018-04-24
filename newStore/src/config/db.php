<?php
	class db{
		
			/* Database config */
			private $db_host		= 'localhost';
			private $db_user		= 'root';
			private $db_pass		= '';
			private $db_database	= 'store';
		
		/*End Config*/
		public function connect(){
			$con_string = "mysql:host=$this->db_host;db_database=$this->db_database";
			$dbConnection = new PDO($con_string, $this->db_user, $this->db_pass);
			$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbConnection;
		}
	}
