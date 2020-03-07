<?php require_once __DIR__ . '/../includes/header.php' ?>

<?php
$postObj = new Post();

$posts = $postObj->getPosts();
?>
<?php require_once __DIR__ . '/../includes/modal.php' ?>
<div class="show-items">
    <div class="show-items__header">
        <h1 class="show-items__title">Posts</h1>
        <a class="show-items__create-button" href="create.php">Create Post</a>
    </div>

    <?php displayMessage() ?>
    <table class="show-items__table">
        <thead>
            <th>Image</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Status</th>
            <th>Action</th>
        </thead>

        <?php foreach ($posts as $post) { ?>
            <tr>
                <td><img src="../../assets/img/<?= $post->image ?>" class="show-items__img"></td>
                <td><?= $post->title ?></td>
                <td><?= $post->author ?></td>
                <td><?= $post->cat_name ?></td>
                <td><?= $post->status ? 'Published' : 'Draft' ?></td>
                <td>
                    <a href="edit.php?id=<?= $post->id ?>" class="show-items__edit">Edit</a>
                    <a href="delete.php?id=<?= $post->id ?>" class="show-items__delete">Delete</a>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>


<?php require_once __DIR__ . '/../includes/footer.php' ?>