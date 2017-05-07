
<?php

/*
 * Author: Henning, Terry
 * Date: April 26, 2017
 * Description: This file contains the DB connection functions
 */

require 'Globals.php';

class DBConnection {

	private $connection;
	private $log;
	
	/**
	 * This is the default contructor 
	 * @param unknown $db The database name 
	 */
	function __construct($db) {
		
		try { 
			
			$this->connection = new PDO("mysql:host=localhost;dbname=$db", SYSTEM_NAME, SYSTEM_PASS);
			
		} catch(Exception $e) {
			
			error_log($e->getMessage());
			die("Cannot establish a connection");
		}
	}
	
	/**
	 * 
	 * @param unknown $sql
	 * @return number
	 */
	public function select_statement($sql) {
		
		$result= 0;
		
		try {
			
			$stmt = $this->connection->query($sql);
			$result = $stmt->fetchAll();
				
		} catch (Exception $e) {
				
			echo $e->getMessage();
			
			error_log($e->getMessage());
		}
		
		return $result;
		
	}
	
	/**
	 * 
	 * @param unknown $sql
	 */
	public function insert_statement($sql) {
		
		$rows = 0;
		
		try {
			
			$this->connection->beginTransaction();
			
			$stm = $this->connection->prepare($sql);
			$rows = $stm->execute();
			
			$this->connection->commit();
			
		} catch (Exception $e) {
			
			echo $e->getMessage();
			
			error_log($e->getMessage());
			
			$this->connection->rollback();
		}
		
		return $rows;
	}
	
	/**
	 *
	 * @param unknown $sql
	 */
	public function update_statement($sql) {
	
		return insert($sql);
	}
}
 