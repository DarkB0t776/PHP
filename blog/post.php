<?php require_once 'includes/header.php' ?>

<?php
if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);
    $postObj = new Post($id);
    $post = $postObj->getPostById($id);
}
?>

<div class="container">
    <div class="post-info">
        <img src="assets\img\<?= $post->image ?>" alt="" class="post-info__image">
        <div class="post-author">
            <p class="post-author__name">Author: <a href="user.php?id=<?= $post->user_id ?>"><?= $post->author ?></a></p>
            <span class="post-category">Category: <a href="category.php?id=<?= $post->category_id ?>"><?= $post->cat_name ?? 'Uncategorized' ?></a></span>
            <span class="post-date"> <?= date('j F Y', strtotime($post->created_date)) ?></span>
        </div>
        <h1 class="post-info__title"><?= $post->title ?></h1>
        <div class="post-info__content"><?= $post->content ?></div>

    </div>
</div>

<?php require_once 'includes/footer.php' ?>