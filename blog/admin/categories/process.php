<?php
require_once __DIR__ . '/../../includes/classes/Category.php';
require_once __DIR__ . '/../../includes/classes/Sanitizer.php';

$categoryObj = new Category();

$data = ['name' => Sanitizer::sanitizeString($_POST['name'])];

$wasSuccessful = $categoryObj->create($data);



if ($wasSuccessful) {
    echo 'success';
} else {
    $errors = $categoryObj->getCodes();
    echo $errors[0];
}
