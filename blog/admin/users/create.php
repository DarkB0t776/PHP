<?php require_once __DIR__ . '/../includes/header.php' ?>

<?php

$userObj = new User();

if (isset($_POST['submit'])) {
    $data = [
        'full_name' => Sanitizer::sanitizeString($_POST['full_name']),
        'username' => Sanitizer::sanitizeString($_POST['username']),
        'email' => Sanitizer::sanitizeEmail($_POST['email']),
        'password' => $_POST['password'],
        'avatar' => $_FILES['avatar'],
        'is_admin' => Sanitizer::sanitizeInt($_POST['is_admin'])
    ];

    $wasSuccessful = $userObj->create($data);
    if ($wasSuccessful) {
        redirect('create.php', ['User Created Successfully'], 'success');
    } else {
        $errors = $userObj->getErrors();
        redirect('create.php', $errors, 'error');
    }
}


?>

<div class="admin-content">
    <h1 class="admin-content__title">Create User</h1>
    <?php displayMessage();     ?>

    <form action="create.php" method="post" class="create-form" enctype="multipart/form-data"">
        <label for=" full_name">Full Name</label>
        <input type="text" name="full_name" id="full_name" class="create-form__input">


        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="create-form__input">

        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="create-form__input">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="create-form__input">


        <label for="avatar">Avatar</label>
        <input type="file" name="avatar" id="avatar" class="create-form__input">

        <label for="role"></label>
        <select name="is_admin" id="role" class="create-form__select">
            <option value="1">Admin</option>
            <option value="0">Subscriber</option>
        </select>

        <input type="submit" name='submit' value="Create" class="form-button">
    </form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php' ?>