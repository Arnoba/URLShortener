<?php
	class dbConnect{
		public $database;

		function __construct(){
			$this->connect();
		}

		protected function connect(){
			$this->database = mysql_connect('gcdsrv.com', 'praisets', 'hakere73');
			mysql_select_db('praisets_URLshortener', $this->database);
			if(!$this->database){
				echo 'Error connecting to the database!';
				die();
			}
		}


		function db(){
			if(!isset($this->database)){
				$this->connect();
			}
			return $this->database;	
		}

	}
?>