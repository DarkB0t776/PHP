<?php

require_once __DIR__ . '/../../includes/classes/Sanitizer.php';
require_once __DIR__ . '/../../includes/classes/Role.php';

$roleObj = new Role();

$data = addRoleData($_POST);

$wasSuccessful = $roleObj->create($data);
if ($wasSuccessful) {
    echo 'role_created';
} else {
    $codes = $roleObj->getCodes();
    echo $codes[0];
}


function addRoleData($role)
{
    $whiteList = ['name'];
    $data = [];
    foreach ($role as $key => $value) {
        if (in_array($key, $whiteList)) {
            $data[$key] = strtolower(Sanitizer::sanitizeString($value));
        }
    }
    return $data;
}
