<?php require_once 'includes/header.php' ?>
<?php

if (isset($_GET['p_num'])) {
    $pageNum = $_GET['p_num'];
} else {
    $pageNum = 1;
}

$numOfPostsPerPage = 2;

$offset = ($pageNum - 1) * $numOfPostsPerPage;

$postObj = new Post();
$posts = $postObj->getPaginatePosts($numOfPostsPerPage, $offset);

?>


<div class="container">

    <?php foreach ($posts['posts'] as $post) { ?>
        <div class="row">
            <div class="blog-image">
                <img src="assets/img/<?= $post->image ?>" alt="">
            </div>
            <!-- /.blog-image -->
            <div class="blog-info">
                <h1 class="blog-info__title"><?= $post->title ?></h1>
                <p class="blog-info__description"><?= $post->description ?></p>
                <a href="post.php?id=<?= $post->id ?>" class="blog-info__read-more">Continue Reading</a>
            </div>
            <!-- /.blog-info -->
        </div>
        <!-- /.row -->
    <?php } ?>

    <div class="pagination">
        <a href="<?= $pageNum <= 1 ? '#' : "index.php?p_num=" . ($pageNum - 1); ?>" class="<?= $pageNum <= 1 ? 'disabled' : '' ?>"><span class="arr-left">&#10229;</span>PREVIOUS</a>
        <a href="<?= $pageNum >= $posts['totalPages'] ? '#' : "index.php?p_num=" . ($pageNum + 1); ?>" class="<?= $pageNum == $posts['totalPages'] ? 'disabled' : '' ?>">NEXT<span class="arr-right">&#10230;</span></a>
    </div>
</div>
<!-- /.container -->
<?php require_once 'includes/footer.php' ?>