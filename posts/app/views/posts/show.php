<?php require APP_ROOT . '/views/inc/header.php'; ?>
<a href="<?= URL_ROOT ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br>
<h1><?= $data['post']->title ?></h1>
<div class="bg-secondary text-white p-2 mb-3">
  Written By <?= $data['user']->name ?> on <?= $data['post']->created_at ?>
</div>
<p><?= $data['post']->body ?></p>

<?php if ($data['post']->user_id === $_SESSION['user_id']) : ?>
  <hr>
  <a href="<?= URL_ROOT ?>/posts/edit/<?= $data['post']->id ?>" class="btn btn-dark">Edit</a>

  <form class="pull-right" action="<?= URL_ROOT ?>/posts/delete/<?= $data['post']->id ?>" method="POST">
    <input type="submit" value="Delete" class="btn btn-danger">
  </form>
<?php endif; ?>
<?php require APP_ROOT . '/views/inc/footer.php'; ?>