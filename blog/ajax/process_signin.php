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
    $_SESSION['userId'] = $userLogged['userData']->id;
    $_SESSION['userFullName'] = $userLogged['userData']->full_name;
    $_SESSION['username'] = $userLogged['userData']->username;
    $_SESSION['userEmail'] = $userLogged['userData']->email;
    $_SESSION['userRole'] = $userLogged['userData']->role_id;
    $_SESSION['userAvatar'] = $userLogged['userData']->avatar;
    echo 'signin';
} else {
    $code = $account->getCode();
    echo $code[0];
}
