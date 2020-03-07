<?php require_once 'includes/header.php' ?>

<?php
if (isset($_GET['id'])) {
    $id = Sanitizer::sanitizeInt($_GET['id']);
    $postObj = new Post($id);
    $post = $postObj->getPostById($id);

    $commentObj = new Comment();

    $comments = $commentObj->getCommentsByPostId($id);
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

    <hr>

    <?php if(isset($_SESSION['userLoggedIn'])) { ?>

        <div class="post-comment">
            <h2 class="post-comment__header">Post your comment here:</h2>
            <div id="message"></div>
            <div class="enter-comment">
                <form action="ajax/process_comment.php" method="POST" class="enter-comment__form">
                    <textarea name="content" id="content" class="enter-comment__content"></textarea>
                    <input type="hidden" name="user_id" id="author_id" value="<?= isset($_SESSION['userId']) ? $_SESSION['userId'] : '' ?>">
                    <input type="hidden" name="post_id" id="post_id" value="<?= $post->id ?>">
                    <button type="submit" id="post" class="enter-comment__button">Post</button>
                </form>
            </div>
        </div>
        <!-- /.post-comment -->
    <?php } ?>

    <div class="comments">
        <?php if(!empty($comments)) { ?>
            <h3 class="comments__header">All Comments</h3>
            <?php foreach($comments as $comment){ ?>
                    <div class="comment-data">
                        <div class="author-data">
                            <img src="/assets/avatar/<?= $comment->author_avatar ?>" alt="" class="author-data__avatar">
                            <span class="author-data__username"><?= $comment->author_name ?></span>
                        </div>
                        <p class="comment-data__content" id="content"><?= $comment->content ?></p>
                    </div>
                    <!-- /.comment-data -->        
            <?php } ?>
            <?php }else { ?>
                <h3 class="comments__header">No Comments Yet</h3>
            <?php } ?>
    </div>
    <!-- /.comments -->


</div>

<?php require_once 'includes/footer.php' ?>