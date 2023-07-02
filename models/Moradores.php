<?php

require_once 'DB.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
header("Access-Control-Max-Age", "3600");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Access-Control-Allow-Credentials", "true");

class Moradores {
    public $db;

    public function __construct(){
        $this->db = \db::getInstance("docker");
    }

    public function getMoradores(){
        $sql = "SELECT * FROM `oscar-cc-database`.`Moradores` ORDER BY `oscar-cc-database`.`Moradores`.`Nome` ASC";
        $sth = $this->db->conn->prepare($sql);

		$result = [];

		try {
			$sth->execute();

			while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
				$result[] = $row;
			}
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}

		return $result;

    }
}