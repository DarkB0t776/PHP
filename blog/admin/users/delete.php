<?php
require_once __DIR__ . '/../../includes/classes/User.php';
require_once __DIR__ . '/../../includes/classes/Sanitizer.php';
require_once __DIR__ . '/../../includes/helper.php';


if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);

    $user = new User();

    if ($user->delete($id)) {
        redirect('index.php', ['User Deleted Successfully'], 'success');
    } else {
        redirect('index.php', ['Something went wrong'], 'error');
    }
}
