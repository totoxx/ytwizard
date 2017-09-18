<?php
require_once 'database.php';
class Category{
	
	public static function addCategory($id, $idSource=1){
		// validate input
			$valid = true;
			if (empty($id)) {
				$valid = false;
			}	
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO `categorie`(`idCatList`, `json`, `idSource`)  values(?,NULL, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($id, $idSource));
				Database::disconnect();
			}
		return $pdo->lastInsertId();
		}
	public static function addCategoryList($name, $link, $number, $parent, $source=1){
		// validate input
			$valid = true;
			if (empty($name)) {
				$valid = false;
			}	
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO `categorielist`(`name`, `link`, `number`, `isParentCat`, `idSource`)  values(?, ?, ?, ?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($name, $link, $number, $parent, $source));
				Database::disconnect();
			}
	}
	public static function addCategoryChannel($idCat, $idChannel){
		// validate input
			$valid = true;
			if (empty($idChannel)) {
				$valid = false;
			}	
			if ($valid) {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO `categoriechannel`(`idCategorie`, `idChannel`)  values(?, ?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($idCat, $idChannel));
				Database::disconnect();
			}
	}
	// Get list of categories for a channel :
	public static function getCategoriesChannel($channelID){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM `categorie` WHERE `id` in (SELECT `idCategorie` FROM `categoriechannel` WHERE `idChannel` = ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($channelID));
			$data = $q->fetchAll();
			Database::disconnect();
			return $data;
	}
	public static function updateCategory($status, $id){
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
	public static function getCategory(){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM `channel` WHERE `status` = 'ok' LIMIT 10";
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetchAll();
			Database::disconnect();
			return $data;
		}
	public static function getCategoryList(){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM `categorielist` WHERE 1";
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetchAll();
			Database::disconnect();
			return $data;
		}
	public static function getSelectedCategoryList(Array $cats){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM `categorielist` WHERE  number in(".implode(",", $cats).")";
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetchAll();
			Database::disconnect();
			return $data;
		}	
	public static function deleteCategory($id){
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "DELETE FROM channel  WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			Database::disconnect();
	}	
}

?>