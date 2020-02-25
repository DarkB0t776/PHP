<?php

require_once __DIR__ . '/includes/classes/Account.php';
require_once __DIR__ . '/includes/classes/Sanitizer.php';
require_once __DIR__ . '/includes/helper.php';

$data = [];
$whiteList = ['username', 'email'];
$account = new Account;

foreach ($_POST as $key => $value) {
    if (in_array($key, $whiteList) && !empty($value)) {
        $data[$key] = Sanitizer::sanitizeString($value);
    }
}
$data['password'] = $_POST['password'];

$wasSuccessful = $account->register($data);

if ($wasSuccessful) {
    echo 'signup';
    header('Location: index.php');
} else {
    $code = $account->getCode();
    echo $code[0];
}
