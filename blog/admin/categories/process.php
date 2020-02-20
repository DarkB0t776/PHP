<?php
require_once __DIR__ . '/../../includes/classes/Category.php';
require_once __DIR__ . '/../../includes/classes/Sanitizer.php';

$categoryObj = new Category();


$data = [];
$whiteList = ['name'];

foreach ($_POST as $key => $value) {
    if (in_array($key, $whiteList)) {
        $data[$key] = Sanitizer::sanitizeString($value);
    }
}

$wasSuccessful = $categoryObj->create($data);



if ($wasSuccessful) {
    echo 'category_success';
} else {
    $errors = $categoryObj->getCodes();
    echo $errors[0];
}
