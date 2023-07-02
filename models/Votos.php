<?php

require_once 'DB.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
header("Access-Control-Max-Age", "3600");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Access-Control-Allow-Credentials", "true");

class Votos
{
    public $db;

    public function __construct()
    {
        $this->db = \db::getInstance("docker");
    }

    public function getVotos()
    {
        $sql = "SELECT * FROM `oscar-cc-database`.`Votos` ORDER BY `oscar-cc-database`.`Votos`.`tituloCategoria` ASC, `oscar-cc-database`.`Votos`.`pontuacao` DESC";
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

    public function insertVotos($arr)
    {
        $categoria = $arr['categoria'];
        $voto = $arr['voto'];
        $pontuacao = (int) $arr['posicao'];
        $result = $this->getVotosWhere($voto, $categoria);

        if (empty($voto)) {
            return;
        }
        
        if (!empty($result)) {
            $pts = $result[0]['pontuacao'];
            $pontuacao = $pontuacao + $pts;
            $sql = "UPDATE `oscar-cc-database`.`Votos` SET `oscar-cc-database`.`Votos`.`pontuacao` = :pontuacao WHERE `oscar-cc-database`.`Votos`.`morador` = :voto AND `oscar-cc-database`.`Votos`.`tituloCategoria` = :categoria";
            $statement = $this->db->conn->prepare($sql);

            try {
                $statement->bindParam(':pontuacao', $pontuacao);
                $statement->bindParam(':voto', $voto);
                $statement->bindParam(':categoria', $categoria);
                $statement->execute();
            } catch (\PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
                var_dump($result) . PHP_EOL;
                echo empty($result) . PHP_EOL;
            }
            return $sql;
        }

        $sql = "INSERT INTO `oscar-cc-database`.`Votos` (`morador`, `tituloCategoria`, `pontuacao`) VALUES (:voto, :categoria, :pontuacao)";
        $statement = $this->db->conn->prepare($sql);

        try {
            $statement->bindParam(':voto', $voto);
            $statement->bindParam(':categoria', $categoria);
            $statement->bindParam(':pontuacao', $pontuacao);
            $statement->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            echo "Insert $sql";
        }
        return $sql;
    }

    private function getVotosWhere($voto, $categoria)
    {
        $sql = "SELECT * FROM `oscar-cc-database`.`Votos` WHERE `oscar-cc-database`.`Votos`.`morador` = :voto AND `oscar-cc-database`.`Votos`.`tituloCategoria` = :categoria";
        $statement = $this->db->conn->prepare($sql);

        $result = [];

        try {
            $statement->bindParam(':voto', $voto);
            $statement->bindParam(':categoria', $categoria);
            $statement->execute();

            while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage() . PHP_EOL;
            echo "getVotos $statement" . PHP_EOL;

        }

        return $result;
    }
}