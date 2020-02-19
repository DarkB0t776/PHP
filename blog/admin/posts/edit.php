<?php require_once __DIR__ . '/../includes/header.php' ?>

<?php
$category = new Category();
$categories = $category->getCategories();

if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);
    $postObj = new Post($id);
    $post = $postObj->getPostById($id);

    if (isset($_POST['submit'])) {
        $data = [
            'title' => Sanitizer::sanitizeString($_POST['title']),
            'category_id' => Sanitizer::sanitizeInt($_POST['category_id']),
            'user_id' => 1,
            'description' => Sanitizer::sanitizeString($_POST['description']),
            'content' => trim($_POST['content']),
            'image' => $_FILES['image'],
            'status' => Sanitizer::sanitizeInt($_POST['status'])
        ];

        $wasSuccessful = $postObj->update($data, $id);
        if ($wasSuccessful) {
            redirect('index.php', ['Post Updated Successfully'], 'success');
        } else {
            $errors = $postObj->getErrors();
            redirect("edit.php?id=$id", $errors, 'error');
        }
    }
}



?>

<div class="admin-content">
    <h1 class="admin-content__title">Edit Post</h1>
    <?php displayMessage();     ?>

    <form action="edit.php?id=<?= $id ?>" method="post" class="create-form" enctype="multipart/form-data"">
        <label for=" title">Title</label>
        <input type="text" name="title" id="title" class="create-form__input" value="<?= $post->title ?>">

        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="create-form__select">
            <?php foreach ($categories as $cat) { ?>
                <option value="<?= $cat->id ?>" <?= ($cat->id == $post->category_id) ? "selected" : '' ?>><?= $cat->name ?></option>
            <?php } ?>
        </select>

        <label for="description">Description</label>
        <textarea type="text" name="description" id="description" class="create-form__text"><?= $post->description ?></textarea>

        <div class="create-form__editor">
            <label for="content">Content</label>
            <input id="content" type="hidden" name="content" value="<?= $post->content ?>">
            <trix-editor class="create-form__text" input="content"></trix-editor>
        </div>

        <label for="image">Image</label>
        <img class="create-form__img" src="../../assets/img/<?= $post->image ?>">
        <input type="file" name="image" id="image" class="create-form__input">

        <label for="status">Status</label>
        <select name="status" id="status" class="create-form__select">

            <option value="1" <?= $post->status == 1 ? "selected" : null;  ?>>Publish</option>
            <option value="0" <?= $post->status == 0 ? "selected" : null;  ?>>Draft</option>
        </select>
        <input type="submit" name='submit' value="Edit" class="form-button">
    </form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php' ?>