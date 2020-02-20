<?php require_once '../includes/header.php' ?>

<?php
if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);
    $roleObj = new Role($id);
    $role = $roleObj->getRoleById($id);
    if (isset($_POST['submit'])) {

        $data = ['name' => strtolower(Sanitizer::sanitizeString($_POST['name']))];

        $wasSuccessful = $roleObj->update($data, $id);
        if ($wasSuccessful) {
            redirect('index.php', ['Role updated successfully'], 'success');
        } else {
            $errors = $roleObj->getErrors();
            redirect("edit.php?id=$id", $errors, 'error');
        }
    }
}
?>

<div class="admin-content">
    <h1 class="admin-content__title">Create Role</h1>
    <?php displayMessage(); ?>

    <form action="edit.php?id=<?= $id ?>" method="POST" class="create-form">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="create-form__input" value="<?= $role->name; ?>">
        <button type="submit" name='submit' class="form-button">Edit</button>
    </form>
</div>


<?php require_once '../includes/footer.php' ?>