<?php
session_start();
require_once __DIR__ . '/../includes/classes/Account.php';
require_once __DIR__ . '/../includes/classes/Sanitizer.php';

$data = [];
$whiteList = ['username'];
$account = new Account;

foreach ($_POST as $key => $value) {
    if (in_array($key, $whiteList) && !empty($value)) {
        $data[$key] = Sanitizer::sanitizeString($value);
    }
}
$data['password'] = $_POST['password'];

$userLogged = $account->login($data);

if ($userLogged['userLoggedIn']) {
    $_SESSION['userLoggedIn'] = true;
    $_SESSION['userId'] = $userLogged['id'];
    $_SESSION['userFullName'] = $userLogged['full_name'];
    $_SESSION['username'] = $userLogged['username'];
    $_SESSION['userEmail'] = $userLogged['email'];
    $_SESSION['userRole'] = $userLogged['role_id'];

    header('Location: index.php');
} else {
    $code = $account->getCode();
    echo $code[0];
}
