<?php
require_once 'database.php';
class Affiliate{
	
	public static function addPost($id, $token, $reftoken, $verified, $status="ok"){
	// validate input
		$valid = true;
		if (empty($token)) {
			$valid = false;
		}	
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `post`(`PostID`, `token`, `refToken`, `verified`, `status`, `dateAdd`)  values(?, ?, ?, ?, ?, NOW())";
			$q = $pdo->prepare($sql);
			$q->execute(array($id, $token, $reftoken, $verified, $status));
			Database::disconnect();
		}
		return $pdo->lastInsertId();
	}
public static function updatePost($status, $id){
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
			$sql = "UPDATE `Post`  set `status` = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($uploaded, $id));
			Database::disconnect();
	}
}
// Step1 : Get active Posts which are enable to receive videos:
public static function getActivePostList(){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM `Post`, `runhistory` WHERE Post.id = runhistory.id AND `status` = 'ok' AND verified='allowed' AND YEARWEEK(`dateRun`, 1) = YEARWEEK(CURDATE(), 1)";
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetchAll();
		Database::disconnect();
		return $data;
	}
	
public static function getPost(){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM `Post` WHERE `status` = 'ok' LIMIT 10";
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetchAll();
		Database::disconnect();
		return $data;
	}
public static function deletePost($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Post  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
}
}

?>