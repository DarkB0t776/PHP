<?php require_once __DIR__ . '/../includes/header.php' ?>

<?php



if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);

    $userObj = new User($id);

    $user = $userObj->getUserById($id);

    if (isset($_POST['submit'])) {
        $data = [
            'full_name' => Sanitizer::sanitizeString($_POST['full_name']),
            'username' => Sanitizer::sanitizeString($_POST['username']),
            'email' => Sanitizer::sanitizeEmail($_POST['email']),
            'password' => $_POST['password'],
            'avatar' => $_FILES['avatar'],
            'role_id' => Sanitizer::sanitizeInt($_POST['role_id'])
        ];

        $wasSuccessful = $userObj->update($data, $id);
        if ($wasSuccessful) {
            redirect('index.php', ['User Updated Successfully'], 'success');
        } else {
            $errors = $userObj->getErrors();
            redirect("edit.php?id=$id", $errors, 'error');
        }
    }
}



?>

<div class="admin-content">
    <h1 class="admin-content__title">Create User</h1>
    <?php displayMessage();     ?>

    <form action="edit.php?id=<?= $id ?>" method="post" class="create-form" enctype="multipart/form-data"">
        <label for=" full_name">Full Name</label>
        <input type="text" name="full_name" id="full_name" class="create-form__input" value="<?= $user->full_name; ?>">


        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="create-form__input" value="<?= $user->username; ?>">

        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="create-form__input" value="<?= $user->email; ?>">

        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="create-form__input">


        <label for="avatar">Avatar</label>
        <img class="create-form__avatar" src="../../assets/avatar/<?= $user->avatar ?>">
        <input type="file" name="avatar" id="avatar" class="create-form__input">

        <label for="role"></label>
        <select name="role_id" id="role" class="create-form__select">
            <option value="1" <?= $user->role_id == 1 ? 'selected' : null; ?>>Admin</option>
            <option value="2" <?= $user->role_id == 2 ? 'selected' : null; ?>>Subscriber</option>
        </select>

        <input type="submit" name='submit' value="Update" class="form-button">
    </form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php' ?>