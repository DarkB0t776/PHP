<?php
require_once __DIR__ . "/Database.php";

class User
{
    private $db;
    private $sqlData;
    private $errors = [];

    public function __construct($id = null)
    {
        $this->db = new Database;
        if ($id != null) {
            $sql = "SELECT * FROM users WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(":id", $id);
            $this->sqlData = $this->db->getSingleResult();
        }
    }

    public function create($data)
    {
        if ($this->validateData($data['full_name'], $data['username'], $data['email'], $data['avatar'])) {
            $avatar = $this->uploadImage($data['avatar']);
            $pass = $this->generatePass($data['password']);
            $sql = "INSERT INTO users(full_name, username, email, password, avatar, is_admin)
                    VALUES(:f_name, :username, :email, :pass, :avatar, :admin)";
            $this->db->query($sql);
            $this->db->bind(":f_name", $data['full_name']);
            $this->db->bind(":username", $data['username']);
            $this->db->bind(":email", $data['email']);
            $this->db->bind(":pass", $pass);
            $this->db->bind(":avatar", $avatar);
            $this->db->bind(":admin", $data['is_admin']);
            return $this->db->execute();
        } else {
            return false;
        }
    }

    public function update($data, $id)
    {

        if ($this->validateData($data['full_name'], $data['username'], $data['email'], $data['avatar'])) {

            $whitelist = [
                'full_name',
                'username',
                'email',
                'role_id'
            ];
            $comma = ' ';
            $sql = "UPDATE users SET";
            foreach ($data as $key => $value) {
                if (in_array($key, $whitelist) && !empty($value)) {
                    $sql .= $comma . $key . '=' . "'$value'";
                    $comma = ',';
                }
            }

            if ($data['avatar']['name'] != '') {
                $avatar = $this->uploadImage($data['avatar']);
                $sql .= ", avatar = '$avatar'";
            }

            if (!empty($data['password'])) {
                $pass = $this->generatePass($data['password']);
                $sql .= ", password = '$pass'";
            }

            $sql .= " WHERE id = $id";

            $this->db->query($sql);
            return $this->db->execute();
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id LIMIT 1";
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->execute();
    }

    public function getUsers()
    {
        $sql = "SELECT users.*, roles.name AS role 
        FROM users
        JOIN roles ON roles.id = users.role_id";
        $this->db->query($sql);

        return $this->db->getResultSet();
    }

    public function getUserById($id)
    {
        $sql = "SELECT users.*, roles.name AS role 
        FROM users 
        JOIN roles ON roles.id = users.role_id
        WHERE users.id = $id";
        $this->db->query($sql);

        return $this->db->getSingleResult();
    }

    private function uploadImage($image)
    {
        if ($image['name'] ===  '') {
            return $this->sqlData->image;
        }

        if ($this->sqlData->image) {
            unlink(__DIR__ . "/../../assets/avatar/" . $this->sqlData->image);
        }

        $ext = strtolower(pathinfo(basename($image['name']), PATHINFO_EXTENSION));
        $targetDir = __DIR__ . "/../../assets/avatar/";
        $imageName = random_int(0, 100000000) . '.' . $ext;
        $targetFile = $targetDir . $imageName;

        move_uploaded_file($image['tmp_name'], $targetFile);

        return $imageName;
    }

    private function generatePass($pass)
    {
        $pass = hash('SHA256', $pass);
        return $pass;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function validateData($fullName, $username, $email, $avatar)
    {
        $this->validateFullName($fullName);
        $this->validateUsername($username);
        $this->validateEmail($email);
        $this->validateImage($avatar);

        if (!empty($this->errors)) {
            return false;
        } else {
            return true;
        }
    }

    private function validateFullName($fullName)
    {
        if (!preg_match('/^[A-Za-z ]+$/', $fullName)) {
            array_push($this->errors, Constants::$fullNameType);
        }
        if (strlen($fullName) < 2 || strlen($fullName) > 100) {
            array_push($this->errors, Constants::$fullNameLength);
        }
    }

    private function validateUsername($username)
    {
        $id = $this->sqlData->id;

        if ($id) {
            $sql = "SELECT COUNT(username) FROM users
                    WHERE username = '$username' AND id != $id
                    GROUP BY id";
        } else {
            $sql = "SELECT username FROM users
                    WHERE username = '$username'";
        }

        $this->db->query($sql);

        if ($this->db->getNumberOfRows() > 0) {
            array_push($this->errors, Constants::$usernameExists);
        }

        if (!preg_match('/^[A-Za-z0-9]+$/', $username)) {
            array_push($this->errors, Constants::$usernameType);
        }
        if (strlen($username) < 4 || strlen($username) > 30) {
            array_push($this->errors, Constants::$usernameLength);
        }
    }

    private function validateEmail($email)
    {
        $id = $this->sqlData->id;
        if ($id) {
            $sql = "SELECT COUNT(email) FROM users
            WHERE email = '$email' AND id != $id
            GROUP BY id";
        } else {
            $sql = "SELECT email FROM users
                    WHERE email = '$email'";
        }
        $this->db->query($sql);

        if ($this->db->getNumberOfRows() > 0) {
            array_push($this->errors, Constants::$emailExists);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errors, Constants::$emailInvalid);
        }

        if (strlen($email) > 100) {
            array_push($this->errors, Constants::$emailLength);
        }
    }

    private function validateImage($image)
    {
        if ($image['name'] != '') {

            $ext = strtolower(pathinfo(basename($image['name']), PATHINFO_EXTENSION));

            if ($ext !== 'jpg' && $ext !== 'jpeg' && $ext !== "png") {
                array_push($this->errors, Constants::$imageType);
            }
        } else {
            return;
        }
    }
}
