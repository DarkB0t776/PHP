<?php require_once __DIR__ . '/../includes/header.php' ?>

<?php
$post = new Post();
$category = new Category();
$categories = $category->getCategories();

if (isset($_POST['submit'])) {
    $data = [
        'title' => Sanitizer::sanitizeString($_POST['title']),
        'category_id' => Sanitizer::sanitizeInt($_POST['category_id']),
        'user_id' => $_SESSION['userId'],
        'description' => Sanitizer::sanitizeString($_POST['description']),
        'content' => trim($_POST['content']),
        'image' => $_FILES['image'],
        'status' => Sanitizer::sanitizeInt($_POST['status'])
    ];

    $wasSuccessful = $post->create($data);
    if ($wasSuccessful) {
        redirect('index.php', ['Post Created Successfully'], 'success');
    } else {
        $errors = $post->getErrors();
        redirect('create.php', $errors, 'error');
    }
}


?>

<div class="admin-content">
    <h1 class="admin-content__title">Create Post</h1>
    <?php displayMessage();     ?>

    <form action="create.php" method="post" class="create-form" enctype="multipart/form-data"">
        <label for=" title">Title</label>
        <input type="text" name="title" id="title" class="create-form__input">

        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="create-form__select">
            <?php foreach ($categories as $cat) { ?>
                <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
            <?php } ?>
        </select>

        <label for="description">Description</label>
        <textarea type="text" name="description" id="description" class="create-form__text"></textarea>

        <div class="create-form__editor">
            <label for="content">Content</label>
            <input id="content" type="hidden" name="content">
            <trix-editor class="create-form__text" input="content"></trix-editor>
        </div>

        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="create-form__input">

        <label for="status">Status</label>
        <select name="status" id="status" class="create-form__select">
            <option value="1">Publish</option>
            <option value="0">Draft</option>
        </select>
        <input type="submit" name='submit' value="Create" class="form-button">
    </form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php' ?>