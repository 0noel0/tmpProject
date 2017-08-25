<?php

class Prototype{

	const databaseHost = "localhost";
	const databaseName = "sistema_cotizaciones";
	const databaseUser = "SC";
	const databaseUserPass = 'SC';

	function getInstance(){
		$databaseInstance = new PDO("mysql:host=".self::databaseHost.";dbname=".self::databaseName, self::databaseUser, self::databaseUserPass);
		$databaseInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $databaseInstance;
	}

	function utf8ize($d) {
		if (is_array($d)) {
			foreach ($d as $k => $v) {
				$d[$k] = $this->utf8ize($v);
			}
		} else if (is_string ($d)) {
			return utf8_encode($d);
		}
		return $d;
	}

	function insert($table, $params){ 
		$res = array();
		$err = array();
		$isFirst = true;
		try{
			$query = "INSERT INTO $table SET ";
			foreach ($params as $key => $value) {
				if($isFirst){
					$query .= $key."=:".$key;
					$isFirst = false;
				}else{
					$query .= ", ".$key."=:".$key;
				}
			}
			
			$pstm = $this->getInstance()->prepare($query);
			foreach ($params as $key => &$value) {
				$pstm->bindParam($key, $value);
			}

			$res["res"] = $pstm->execute();
			$res["err"] = null;
		} catch (PDOException $e) {
			$err["message"] = $e->getMessage();
			$err["code"] = $e->getCode();
			$res["err"] = $err;
		} 

		return $res;
	}

	function update($table, $params, $conditions = null, $conditionsData = null){ 
		$res = array();
		$err = array();
		$isFirst = true;
		try{
			$query = "UPDATE $table SET ";
			foreach ($params as $key => $value) {
				if($isFirst){
					$query .= $key."=:".$key;
					$isFirst = false;
				}else{
					$query .= ", ".$key."=:".$key;
				}
			}
			if($conditions != null){
				$query .= " ".$conditions;
			}

			$pstm = $this->getInstance()->prepare($query);
			foreach ($params as $key => &$value) {
				$pstm->bindParam($key, $value);
			}
			if($conditionsData != null){
				foreach ($conditionsData as $key => &$value) {
					$pstm->bindParam($key, $value);
				}
			}

			$res["res"] = $pstm->execute();
			$res["err"] = null;
		} catch (PDOException $e) {
			$err["message"] = $e->getMessage();
			$err["code"] = $e->getCode();
			$res["err"] = $err;
		} 

		return $res;
	}

	function delete($table, $conditions = null, $conditionsData = null){ 
		$res = array();
		$err = array();
		try{
			$query = "DELETE FROM $table";
			if($conditions != null){
				$query .= " ".$conditions;
			}

			$pstm = $this->getInstance()->prepare($query);
			if($conditionsData != null){
				foreach ($conditionsData as $key => &$value) {
					$pstm->bindParam($key, $value);
				}
			}

			$res["res"] = $pstm->execute();
			$res["err"] = null;
		} catch (PDOException $e) {
			$err["message"] = $e->getMessage();
			$err["code"] = $e->getCode();
			$res["err"] = $err;
		} 

		return $res;
	}
	
	function select($fields, $table, $conditions = null, $conditionsData = null){
		$res = array();
		$err = array();
		try{
			$query = "SELECT $fields FROM $table";
			if($conditions != null){
				$query .= " ".$conditions;
			}

			$pstm = $this->getInstance()->prepare($query);
			if($conditionsData != null){
				foreach ($conditionsData as $key => &$value) {
					$pstm->bindParam($key, $value);
				}
			}
			$pstm->execute();

			if($pstm->rowCount() > 0){
				$res["res"] = $this->utf8ize($pstm->fetchAll(PDO::FETCH_ASSOC));
			}else{
				$res["res"] = null;
			}
			$res["err"] = null;
		} catch (PDOException $e) {
			$err["message"] = $e->getMessage();
			$err["code"] = $e->getCode();
			$res["err"] = $err;
		} 

		return $res;
	}
}
	
?>