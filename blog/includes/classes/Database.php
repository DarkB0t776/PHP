<?php
require_once __DIR__ . '/../config.php';

class Database
{

    private $db = DB_NAME;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;

    private $stmt;
    private $con;
    private $error;

    public function __construct()
    {
        $dns = "mysql:host=localhost;dbname={$this->db}";

        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->con = new PDO($dns, $this->db_user, $this->db_pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }


    public function query($query)
    {
        $this->stmt = $this->con->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function getResultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getSingleResult()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getNumberOfRows()
    {
        $this->execute();
        return $this->stmt->rowCount();
    }
}
