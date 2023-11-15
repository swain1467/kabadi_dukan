<?php
require_once("../config.php");
require_once(ASSET."db_con.php");
require_once(ASSET."error_log.php");
class DBCore {
	public static function executeQuery($sqlString, $data) {
		$pdo = pdo_connect();
    	$pdoStmt = $pdo->prepare($sqlString);
    	$pdoStatus = $pdoStmt->execute($data);
		$pdo = null;

		if(DB_LOG){
			ErrorLog::log('DB_Log_Query->'.$sqlString);
			ErrorLog::log($data);
		}
		if(!$pdoStatus){
			if(PDO_LOG){
				ErrorLog::log($pdoStmt->errorInfo());
				DefaultErrorLog::defaultLog($pdoStmt->errorInfo());
			}
		}
    	return [
    		'status' => $pdoStatus ? 1: 0,
    		'error' => $pdoStatus ? '': $pdoStmt->errorInfo(),
    		'result_obj' => $pdoStmt
    	];
	}

	public static function rowAffected($dbCoreRes){
		return $dbCoreRes['result_obj']->rowCount();
	}
	
	public static function getAllRows($dbCoreRes) {
		if($dbCoreRes['status'] === 0) {
			return [];
		}
		return $dbCoreRes['result_obj']->fetchAll();
	}
};