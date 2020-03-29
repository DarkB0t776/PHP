<?php

class Post
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function getPosts()
  {
    $sql = "SELECT *, posts.id AS postId, 
            users.id AS userID ,
            posts.created_at AS postCreated,
            users.created_at AS userCreated
            FROM posts
            JOIN users 
            ON posts.user_id = users.id
            ORDER BY posts.created_at DESC";
    $this->db->query($sql);

    $results = $this->db->resultSet();

    return $results;
  }

  public function addPost($data)
  {
    $sql = "INSERT INTO posts(title, body, user_id)
    VALUES(:title, :body, :u_id)";
    $this->db->query($sql);

    $this->db->bind(":title", $data['title']);
    $this->db->bind(":body", $data['body']);
    $this->db->bind(":u_id", $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function updatePost($data)
  {
    $sql = "UPDATE posts SET title = :title, body = :body WHERE id = :id";
    $this->db->query($sql);

    $this->db->bind(":title", $data['title']);
    $this->db->bind(":body", $data['body']);
    $this->db->bind(":id", $data['id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function deletePost($id)
  {
    $sql = 'DELETE FROM posts WHERE id = :id LIMIT 1';
    $this->db->query($sql);
    $this->db->bind(":id", $id);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function getPostById($id)
  {
    $sql = "SELECT * FROM posts WHERE id = :id";
    $this->db->query($sql);
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }
}
