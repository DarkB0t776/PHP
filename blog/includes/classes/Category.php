<?php

require_once __DIR__ . '/Database.php';

class Category
{
    private $db;
    private $errors = [];
    private $codes = [];

    public function __construct()
    {
        $this->db = new Database;
    }

    public function create($data)
    {
        if ($this->validateName($data['name'])) {
            $name = $data['name'];
            $sql = "INSERT INTO categories (name)
            VALUES (:name)";
            $this->db->query($sql);
            $this->db->bind(":name", $name);

            return $this->db->execute();
        } else {
            return false;
        }
    }

    public function update($data, $id)
    {
        if ($this->validateName($data['name'])) {
            $name = $data['name'];
            $sql = "UPDATE categories SET name = :name
                    WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(":name", $name);
            $this->db->bind(":id", $id);
            $this->db->execute();

            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM categories
                WHERE id = :id';
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->execute();
    }

    public function getCategories()
    {
        $sql = "SELECT * FROM categories";
        $this->db->query($sql);
        return $this->db->getResultSet();
    }

    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories
                WHERE id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->getSingleResult();
    }

    private function validateName($name)
    {
        $sql = "SELECT name FROM categories
                WHERE name = :name";
        $this->db->query($sql);
        $this->db->bind(":name", $name);

        if ($this->db->getNumberOfRows() === 1) {
            array_push($this->codes, 'category_exists');
        }

        if (!preg_match('/^[A-Za-z]+$/', $name)) {
            array_push($this->codes, 'category_type');
        }

        if (strlen($name) < 3 || strlen($name) > 30) {
            array_push($this->codes, 'category_length');
        }

        if (!empty($this->codes)) {
            return false;
        }

        return true;
    }

    public function getError()
    {
        return $this->errors;
    }

    public function getCodes()
    {
        return $this->codes;
    }
}
