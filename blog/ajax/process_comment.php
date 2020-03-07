<?php 

require_once __DIR__ . '/../includes/classes/Comment.php';
require_once __DIR__ . '/../includes/classes/Sanitizer.php';


$comment = new Comment();

$data = [
    'content' => Sanitizer::sanitizeString($_POST['content']),
    'user_id' => Sanitizer::sanitizeInt($_POST['user_id']),
    'post_id' => Sanitizer::sanitizeInt($_POST['post_id'])
];

$wasSuccessful = $comment->create($data);

if ($wasSuccessful) {
    echo 'posted';
}else{
    $errors = $comment->getCodes();
    foreach ($errors as $error) {
        echo $error;
    }
}
