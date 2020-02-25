<?php

require_once __DIR__ . '/Database.php';

class Account
{
    private $db;

    private $codes = [];

    public function __construct()
    {
        $this->db = new Database;
    }

    public function register($data)
    {
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $this->generatePass($data['password']);
        if ($this->validateData($username, $email)) {
            $sql = "INSERT INTO users(username, email, password)
                    VALUES (:un, :em, :pw)";
            $this->db->query($sql);
            $this->db->bind(":un", $username);
            $this->db->bind(":em", $email);
            $this->db->bind(":pw", $password);
            return $this->db->execute();
        } else {
            return false;
        }
    }

    private function generatePass($pass)
    {
        $pass = hash('SHA256', $pass);
        return $pass;
    }

    public function getCode()
    {
        return $this->codes;
    }

    private function validateData($username, $email)
    {
        $this->validateUsername($username);
        $this->validateEmail($email);

        if (!empty($this->codes)) {
            return false;
        }

        return true;
    }

    private function validateUsername($username)
    {
        $sql = "SELECT username FROM users
                 WHERE username = '$username'";

        $this->db->query($sql);
        if (strlen($username) < 4 || strlen($username) > 30) {
            array_push($this->codes, 'unLength');
            return false;
        }
        if (!preg_match('/^[A-Za-z0-9]+$/', $username)) {
            array_push($this->codes, 'unFormat');
            return false;
        }

        if ($this->db->getNumberOfRows() > 0) {
            array_push($this->codes, 'unExists');
            return false;
        }
        return true;
    }

    private function validateEmail($email)
    {

        $sql = "SELECT email FROM users
                WHERE email = '$email'";
        $this->db->query($sql);

        if (strlen($email) > 100) {
            array_push($this->codes, 'emLength');
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->codes, 'emFormat');
            return false;
        }
        if ($this->db->getNumberOfRows() > 0) {
            array_push($this->codes, 'emExists');
            return false;
        }


        return true;
    }
}
