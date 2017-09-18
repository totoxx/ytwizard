<?php
require_once 'database.php';
class RunHistory{
	
	public static function addRunHistory($id, $token, $reftoken, $verified, $status="ok"){
		// validate input
			$valid = true;
			if (empty($token)) {
				$valid = false;
			}	
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO `RunHistory`(`RunHistoryID`, `token`, `refToken`, `verified`, `status`, `dateAdd`)  values(?, ?, ?, ?, ?, NOW())";
				$q = $pdo->prepare($sql);
				$q->execute(array($id, $token, $reftoken, $verified, $status));
				Database::disconnect();
			}
			return $pdo->lastInsertId();
		}
	public static function updateRunHistory($status, $id){
		$valid = true;
		if (empty($uploaded)) {
				$valid = false;
			}
		if (empty($title)) {
				$valid = false;
			}	
			// update data
		if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "UPDATE `RunHistory`  set `status` = ? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($uploaded, $id));
				Database::disconnect();
		}
	}
	// Step1 : Get active RunHistorys which are enable to receive videos:
	public static function getActiveRunHistoryList(){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM `RunHistory`, `runhistory` WHERE RunHistory.id = runhistory.id AND `status` = 'ok' AND verified='allowed' AND YEARWEEK(`dateRun`, 1) = YEARWEEK(CURDATE(), 1)";
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetchAll();
			Database::disconnect();
			return $data;
		}
		
	public static function getRunHistory(){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM `RunHistory` WHERE `status` = 'ok' LIMIT 10";
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetchAll();
			Database::disconnect();
			return $data;
		}
	public static function deleteRunHistory($id){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM RunHistory  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
	}	
}

?>