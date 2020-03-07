<?php require_once '../includes/header.php'; ?>

<?php
$roleObj = new Role();
$roles = $roleObj->getRoles();
?>
<?php require_once __DIR__ . '/../includes/modal.php' ?>
<div class="show-items">
    <div class="show-items__header">
        <h1 class="show-items__title">Roles</h1>
        <a class="show-items__create-button" href="create.php">Create Role</a>
    </div>
    <?php displayMessage(); ?>
    <table class="show-items__table">
        <thead>
            <th>Name</th>
            <th>Action</th>
        </thead>

        <?php foreach ($roles as $role) { ?>
            <tr>
                <td><?= ucfirst($role->name) ?></td>
                <td>
                    <a href="edit.php?id=<?= $role->id ?>" class="show-items__edit">Edit</a>
                    <a href="delete.php?id=<?= $role->id ?>" class="show-items__delete">Delete</a>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>

<?php require_once '../includes/footer.php'; ?>