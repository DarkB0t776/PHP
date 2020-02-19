<?php require_once '../includes/header.php' ?>

<?php


// if (isset($_POST['submit'])) {
//   $category = new Category();
//   $errors = [];
//   $data = [
//     'name' => Sanitizer::sanitizeString($_POST['name'])
//   ];

//   $wasSuccessful = $category->create($data);
//   if ($wasSuccessful) {
//     $msg = Constants::$categoryCreated;
//     redirect('index.php', ['Category Created Successfully'], 'success');
//   } else {
//     $errors = $category->getError();
//     redirect('create.php', $errors, 'error');
//   }
// }

?>


<div class="admin-content">
  <h1 class="admin-content__title">Create Category</h1>

  <div class="message" id="message"></div>

  <form action="process.php" method="POST" class="create-form">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" class="create-form__input">
    <button type="submit" name='submit' id="create" class="form-button">Create</button>
  </form>
</div>


<?php require_once '../includes/footer.php' ?>