<?php

require_once __DIR__ . '/Database.php';

class Post
{
    private $db;
    private $errors = [];
    private $sqlData;

    public function __construct($id = null)
    {
        $this->db = new Database;
        if ($id != null) {
            $sql = "SELECT * FROM posts WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(":id", $id);

            $this->sqlData = $this->db->getSingleResult();
        }
    }

    public function create($data)
    {
        if ($this->validateData($data['title'], $data['description'], $data['image'])) {

            $image = $this->uploadImage($data['image']);

            $sql = "INSERT INTO posts(title,description, content, category_id, user_id,status, image)
                    VALUES(:title, :desc, :content, :cat_id, :u_id, :status, :img)";
            $this->db->query($sql);
            $this->db->bind(":title", $data['title']);
            $this->db->bind(":desc", $data['description']);
            $this->db->bind(":content", $data['content']);
            $this->db->bind(":cat_id", $data['category_id']);
            $this->db->bind(":u_id", $data['user_id']);
            $this->db->bind(":status", $data['status']);
            if ($image) $this->db->bind(":img", $image);
            $this->db->execute();

            return true;
        } else {
            return false;
        }
    }

    public function update($data, $id)
    {
        if ($this->validateData($data['title'], $data['description'], $data['image'])) {

            $image = $this->uploadImage($data['image']);

            $sql = "UPDATE posts SET
                    title = :title, description = :desc,
                    content = :content, category_id = :cat_id,
                    user_id = :u_id, status = :status, image = :img
                    WHERE id = :id";
            $this->db->query($sql);
            $this->db->bind(":title", $data['title']);
            $this->db->bind(":desc", $data['description']);
            $this->db->bind(":content", $data['content']);
            $this->db->bind(":cat_id", $data['category_id']);
            $this->db->bind(":u_id", $data['user_id']);
            $this->db->bind(":status", $data['status']);
            $this->db->bind(":img", $image);
            $this->db->bind(":id", $id);
            $this->db->execute();

            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM posts WHERE id = $id LIMIT 1";
        $this->db->query($sql);
        return $this->db->execute();
    }

    public function getPosts()
    {
        $sql = "SELECT posts.*, categories.name AS cat_name, users.full_name AS author
                FROM posts
                JOIN categories ON categories.id = posts.category_id
                JOIN users ON users.id = posts.user_id";
        $this->db->query($sql);

        return $this->db->getResultSet();
    }

    public function getPostById($id)
    {
        $sql = "SELECT posts.*, categories.name AS cat_name, users.full_name AS author
                FROM posts
                JOIN categories ON categories.id = posts.category_id
                JOIN users ON users.id = posts.user_id
                WHERE posts.id = :id";
        $this->db->query($sql);
        $this->db->bind(":id", $id);

        return $this->db->getSingleResult();
    }

    private function validateData($title, $description, $image)
    {
        $this->validateTitle($title);
        $this->validateDescription($description);
        if ($image['name'] !== "") {

            $this->validateImage($image);
        }

        if (!empty($this->errors)) {
            return false;
        } else {
            return true;
        }
    }

    private function validateTitle($title)
    {
        $id = $this->sqlData->id;
        if ($id) {
            $sql = "SELECT COUNT(title)
                    FROM posts
                    WHERE title = '$title' AND id != $id
                    GROUP BY id";
        } else {
            $sql = "SELECT title FROM posts
                    WHERE title = '$title'";
        }

        $this->db->query($sql);

        if ($this->db->getNumberOfRows() > 0) {
            array_push($this->errors, Constants::$postTitleExists);
        }

        if (!preg_match('/^[A-Za-z0-9 ]+$/', $title)) {
            array_push($this->errors, Constants::$postTitleType);
        }

        if (strlen($title) < 5 || strlen($title) > 200) {
            array_push($this->errors, Constants::$postTitleLength);
        }
    }

    private function validateDescription($description)
    {
        if (strlen($description) < 20 || strlen($description) > 255) {
            array_push($this->errors, Constants::$postDescriptionLength);
        }
    }

    private function validateImage($image)
    {
        $ext = strtolower(pathinfo(basename($image['name']), PATHINFO_EXTENSION));

        if ($ext !== 'jpg' && $ext !== 'jpeg' && $ext !== "png") {
            array_push($this->errors, Constants::$imageType);
        }
    }

    private function uploadImage($image)
    {
        if ($image['name'] ===  '') {
            return $this->sqlData->image;
        }

        if ($this->sqlData->image) {
            unlink(__DIR__ . "/../../assets/img/" . $this->sqlData->image);
        }

        $ext = strtolower(pathinfo(basename($image['name']), PATHINFO_EXTENSION));
        $targetDir = __DIR__ . "/../../assets/img/";
        $imageName = random_int(0, 100000000) . '.' . $ext;
        $targetFile = $targetDir . $imageName;

        move_uploaded_file($image['tmp_name'], $targetFile);

        return $imageName;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
