<?php require_once __DIR__ . '/../includes/header.php' ?>

<?php
$userObj = new User();

$users = $userObj->getUsers();
?>

<div class="show-items">
    <div class="show-items__header">
        <h1 class="show-items__title">Posts</h1>
        <a class="show-items__create-button" href="create.php">Create User</a>
    </div>

    <?php displayMessage() ?>
    <table class="show-items__table">
        <thead>
            <th>Image</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </thead>

        <?php foreach ($users as $user) { ?>
            <tr>
                <td><img src="../../assets/avatar/<?= $user->avatar ?>" class="show-items__avatar"></td>
                <td><?= $user->full_name ?></td>
                <td><?= $user->username ?></td>
                <td><?= $user->email ?></td>
                <td><?= ucfirst($user->role); ?></td>
                <td>
                    <a href="edit.php?id=<?= $user->id ?>" class="show-items__edit">Edit</a>
                    <a href="delete.php?id=<?= $user->id ?>" class="show-items__delete">Delete</a>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>


<?php require_once __DIR__ . '/../includes/footer.php' ?>