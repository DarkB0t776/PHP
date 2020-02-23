<?php require_once 'includes/header.php' ?>
<?php
$postObj = new Post();
$posts = $postObj->getPosts();
?>


<div class="container">

    <?php foreach ($posts as $post) { ?>
        <div class="row">
            <div class="blog-image">
                <img src="assets/img/<?= $post->image ?>" alt="">
            </div>
            <!-- /.blog-image -->
            <div class="blog-info">
                <h1 class="blog-info__title"><?= $post->title ?></h1>
                <p class="blog-info__description"><?= $post->description ?></p>
                <a href="#" class="blog-info__read-more">Continue Reading</a>
            </div>
            <!-- /.blog-info -->
        </div>
        <!-- /.row -->
    <?php } ?>
</div>
<!-- /.container -->
<?php require_once 'includes/footer.php' ?>