<?php

require_once __DIR__ . '/../../includes/classes/Role.php';
require_once __DIR__ . '/../../includes/classes/Sanitizer.php';
require_once __DIR__ . '/../../includes/helper.php';


if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);

    $roleObj = new Role();

    if ($roleObj->delete($id)) {
        redirect('index.php', ['Role Deleted Successfully'], 'success');
    } else {
        redirect('index.php', ['Something went wrong'], 'error');
    }
}
