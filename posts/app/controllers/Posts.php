<?php

class Posts extends Controller
{

  public function __construct()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }

    $this->Post = $this->model('Post');
    $this->User = $this->model('User');
  }

  public function index()
  {
    //Get posts
    $posts = $this->Post->getPosts();

    $data = [
      'posts' => $posts
    ];

    $this->view('posts/index', $data);
  }

  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Sanitize post
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'title_err' => '',
        'body_err' => ''
      ];

      //Validate title
      if (empty($data['title'])) {
        $data['title_err'] = 'Pleas enter title';
      }
      //Validate body
      if (empty($data['body'])) {
        $data['body_err'] = 'Pleas enter body text';
      }

      //Make sure no errors
      if (empty($data['title_err']) && empty($data['body_err'])) {
        //Validated
        if ($this->Post->addPost($data)) {
          flash('post_message', 'Post Added');
          redirect('posts');
        } else {
          die('Something went wrong');
        }
      } else {
        //Load view with errors
        $this->view('posts/add', $data);
      }
    } else {
      $data = [
        'title' => '',
        'body' => ''
      ];

      $this->view('posts/add', $data);
    }
  }

  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Sanitize post
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'id' => $id,
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'title_err' => '',
        'body_err' => ''
      ];

      //Validate title
      if (empty($data['title'])) {
        $data['title_err'] = 'Pleas enter title';
      }
      //Validate body
      if (empty($data['body'])) {
        $data['body_err'] = 'Pleas enter body text';
      }

      //Make sure no errors
      if (empty($data['title_err']) && empty($data['body_err'])) {
        //Validated
        if ($this->Post->updatePost($data)) {
          flash('post_message', 'Post Updated');
          redirect('posts');
        } else {
          die('Something went wrong');
        }
      } else {
        //Load view with errors
        $this->view('posts/edit', $data);
      }
    } else {
      $postData = $this->Post->getPostById($id);
      //Check for owner
      if ($postData->user_id !== $_SESSION['user_id']) {
        redirect('posts');
      }

      $data = [
        'id' => $id,
        'title' => $postData->title,
        'body' => $postData->body
      ];

      $this->view('posts/edit', $data);
    }
  }

  public function show($id)
  {
    $postData = $this->Post->getPostById($id);
    $userData = $this->User->getUserById($postData->user_id);

    $data = [
      'post' => $postData,
      'user' => $userData
    ];

    $this->view('posts/show', $data);
  }

  public function delete($id)
  {
    $postData = $this->Post->getPostById($id);
    //Check for owner
    if ($postData->user_id !== $_SESSION['user_id']) {
      redirect('posts');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if ($this->Post->deletePost($id)) {
        flash('post_message', 'Post Removed');
        redirect('posts');
      } else {
        die('Something went wrong');
      }
    } else {
      redirect('posts');
    }
  }
}
