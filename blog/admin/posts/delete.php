<?php
require_once __DIR__ . '/../../includes/classes/Post.php';
require_once __DIR__ . '/../../includes/classes/Sanitizer.php';
require_once __DIR__ . '/../../includes/helper.php';


if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);

    $post = new Post();

    if ($post->delete($id)) {
        redirect('index.php', ['Post Deleted Successfully'], 'success');
    } else {
        redirect('index.php', ['Something went wrong'], 'error');
    }
}
