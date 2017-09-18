<?php
require_once 'database.php';
class Channel {
	
	public static function addChannel($id, $token, $reftoken, $verified, $status="ok"){
		// validate input
			$valid = true;
			if (empty($token)) {
				$valid = false;
			}	
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO `channel`(`channelID`, `token`, `refToken`, `verified`, `status`, `dateAdd`)  values(?, ?, ?, ?, ?, NOW())";
				$q = $pdo->prepare($sql);
				$q->execute(array($id, $token, $reftoken, $verified, $status));
				Database::disconnect();
			}
			return $pdo->lastInsertId();
		}
	public static  function updateChannel($status, $id){
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
				$sql = "UPDATE `channel`  set `status` = ? WHERE id = ?";
				$q = $pdo->prepare($sql);
				$q->execute(array($uploaded, $id));
				Database::disconnect();
		}
	}
	// Step1 : Get active channels which are enable to receive videos:
	public static function getActiveChannelList(){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT id FROM `channel` WHERE `status` = 'ok' AND verified='allowed' AND id NOT IN (SELECT idChannel FROM `runhistory` WHERE YEARWEEK(`dateRun`, 1) = YEARWEEK(CURDATE(), 1))";
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetchAll();
			Database::disconnect();
			return $data;
		}
		
	public static  function getChannel(){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM `channel` WHERE `status` = 'ok' LIMIT 10";
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetchAll();
			Database::disconnect();
			return $data;
		}
	public static function deleteChannel($id){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM channel  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
	}	
}

?>