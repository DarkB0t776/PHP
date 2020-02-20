<?php require_once '../includes/header.php'; ?>

<?php
$categories = new Category();
?>

<div class="show-items">
    <div class="show-items__header">
        <h1 class="show-items__title">Categories</h1>
        <a class="show-items__create-button" href="create.php">Create Category</a>
    </div>
    <?php displayMessage(); ?>
    <table class="show-items__table">
        <thead>
            <th>Name</th>
            <th>Action</th>
        </thead>

        <?php foreach ($categories->getCategories() as $category) { ?>
            <tr>
                <td><?= $category->name ?></td>
                <td>
                    <a href="edit.php?id=<?= $category->id ?>" class="show-items__edit">Edit</a>
                    <a href="delete.php?id=<?= $category->id ?>" class="show-items__delete">Delete</a>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>

<?php require_once '../includes/footer.php'; ?>