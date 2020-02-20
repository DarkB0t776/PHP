<?php

require_once __DIR__ . '/Database.php';

class Role
{
    private $db;
    private $codes = [];
    private $errors = [];
    private $sqlData;

    public function __construct($id = null)
    {
        $this->db = new Database;

        if ($id != null) {
            $sql = "SELECT * FROM roles WHERE id = $id";
            $this->db->query($sql);

            $this->sqlData = $this->db->getSingleResult();
        }
    }

    public function create($data)
    {
        if ($this->validateName($data['name'])) {
            $sql = "INSERT INTO roles(name) VALUES (:name)";
            $this->db->query($sql);
            $this->db->bind(":name", $data['name']);

            return $this->db->execute();
        } else {
            return false;
        }
    }

    public function update($data, $id)
    {
        if ($this->validateName($data['name'])) {
            $sql = "UPDATE roles SET name = :name WHERE id = $id";
            $this->db->query($sql);
            $this->db->bind(":name", $data['name']);

            return $this->db->execute();
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM roles WHERE id = $id LIMIT 1";
        $this->db->query($sql);

        return $this->db->execute();
    }

    public function getRoles()
    {
        $sql = "SELECT * FROM roles";
        $this->db->query($sql);

        return $this->db->getResultSet();
    }

    public function getRoleById($id)
    {
        $sql = "SELECT * FROM roles
                WHERE id = $id";
        $this->db->query($sql);

        return $this->db->getSingleResult();
    }

    public function getCodes()
    {
        return $this->codes;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function validateName($name)
    {
        $sql = "SELECT name FROM roles
                WHERE name = :name";
        $this->db->query($sql);
        $this->db->bind(":name", $name);

        if ($this->db->getNumberOfRows() === 1) {
            array_push($this->codes, 'role_exists');
            array_push($this->errors, Constants::$roleExists);
        }

        if (!preg_match('/^[A-Za-z]+$/', $name)) {
            array_push($this->codes, 'role_type');
            array_push($this->errors, Constants::$roleNameType);
        }

        if (strlen($name) < 3 || strlen($name) > 50) {
            array_push($this->codes, 'role_length');
            array_push($this->errors, Constants::$roleNameLength);
        }

        if (!empty($this->codes)) {
            return false;
        }

        return true;
    }
}
