<?php require_once '../includes/header.php' ?>

<?php


if (isset($_GET['id'])) {

    $id = Sanitizer::sanitizeInt($_GET['id']);
    $category = new Category();
    $categoryData = $category->getCategoryById($id);
    if (isset($_POST['submit'])) {
        $errors = [];
        $data = [
            'name' => Sanitizer::sanitizeString($_POST['name'])
        ];

        $wasSuccessful = $category->update($data, $id);
        if ($wasSuccessful) {
            $msg = Constants::$categoryCreated;
            redirect('index.php', ['Category Updated Successfully'], 'success');
        } else {
            $errors = $category->getError();
            redirect('edit.php?id=' . $id, $errors, 'error');
        }
    }
}


?>


<div class="admin-content">
    <h1 class="admin-content__title">Edit Category</h1>
    <?php displayMessage(); ?>

    <form action="edit.php?id=<?= $id ?>" method="post" class="create-form">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="create-form__input" value="<?= $categoryData->name ?>">
        <input type="submit" name='submit' value="Edit" class="form-button">
    </form>
</div>


<?php require_once '../includes/footer.php' ?>