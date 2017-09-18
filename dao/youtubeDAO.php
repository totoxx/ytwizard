<?php
require 'database.php';
function addYtData($linkAffiliate, $shortenLinkAffiliate, $linkVideo, $sizeVideo, $titleOrigine, $titleModified, $descOrgine, $descModified, $thumb, $uploaded){
	// validate input
		$valid = true;
		if (empty($linkAffiliate)) {
			$valid = false;
		}
	
		if (empty($shortenLinkAffiliate)) {
			$valid = false;
		}
		if (empty($linkVideo)) {
			$valid = false;
		}

		if (empty($sizeVideo)) {
			$valid = false;
		}

		if (empty($titleOrigine)) {
			$valid = false;
		} 

		if (empty($descModified)) {
			$valid = false;
		}
		
		if (empty($thumb)) {
			$valid = false;
		} 
		// insert data
		
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT IGNORE INTO `youtube`(`linkAffiliate`, `shortenLinkAffiliate`, `linkVideo`, `sizeVideo`, `titleOrigine`, `titleModified`, `descOrgine`, `descModified`, `thumb`, `uploaded`)  values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($linkAffiliate, $shortenLinkAffiliate, $linkVideo, $sizeVideo, $titleOrigine, $titleModified, $descOrgine, $descModified, $thumb, $uploaded));
			Database::disconnect();
		}
}
function updateYtUpload($uploaded, $title){
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
			$sql = "UPDATE `youtube`  set `uploaded` = ? WHERE titleModified = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($uploaded, $title));
			Database::disconnect();
	}
}
function getYtData(){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM `youtube` WHERE `uploaded` = 'none' LIMIT 10";
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetchAll();
		Database::disconnect();
		return $data;
	}
function deleteYtData($id){
	$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM youtube  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
}
?>