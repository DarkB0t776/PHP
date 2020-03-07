<?php

require_once __DIR__ . '/Database.php';

class Comment {

    private $db;
    private $codes = [];

    public function __construct()
    {
        $this->db = new Database;
    }

    public function create($data) {

        if($this->validateContent($data['content'])){
            $postId = $data['post_id'];
            $userId = $data['user_id'];

           $sql = 'INSERT INTO comments(content, user_id, post_id)
                    VALUES (:content, :u_id, :p_id)';
            
            $this->db->query($sql);
            $this->db->bind(':content', $data['content']);
            $this->db->bind(':u_id', $userId);
            $this->db->bind(':p_id', $postId);

            return $this->db->execute();
        }else{
            return false;
        }
    }

    public function getComments()
    {
        $sql = "SELECT comments.*, users.username AS author_name, users.avatar AS author_avatar
                FROM comments
                JOIN users ON users.id = comments.user_id";

        $this->db->query($sql);

        return $this->db->getResultSet();
    }

    public function getCommentsByPostId($id)
    {
        $sql = "SELECT comments.*, users.username AS author_name, users.avatar AS author_avatar
                FROM comments
                JOIN users ON users.id = comments.user_id
                WHERE comments.post_id = :post_id";

        $this->db->query($sql);
        $this->db->bind(':post_id', $id);

        return $this->db->getResultSet();
    }


    private function validateContent($content)
    {
        if(strlen($content) < 2 || strlen($content) > 200){
            array_push($this->codes, 'comment_length');
            return false;
        }

        return true;
    }

    public function getCodes()
    {
        return $this->codes;
    }
}