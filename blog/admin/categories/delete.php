<?php
require_once __DIR__ . '/../../includes/classes/Category.php';
require_once __DIR__ . '/../../includes/classes/Sanitizer.php';
require_once __DIR__ . '/../../includes/helper.php';


if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);

    $category = new Category();

    if ($category->delete($id)) {
        redirect('index.php', ['Category Deleted Successfully'], 'success');
    } else {
        redirect('index.php', ['Something went wrong'], 'error');
    }
}
