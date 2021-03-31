<?php

use app\components\form\Form;
use app\models\BookAuthor;

$model = $book ?? new BookAuthor();

$form = new Form('/library/deleteAll', Form::POST, $model, $errors ?? []);
$bookField = $form->field('Delete by title...', 'title', false);

$success = $body['success'] ?? false;

?>

<h1 class="my-5">Delete books</h1>

<?php $form->begin(); ?>
<div class="input-group mb-3">
  <?php $bookField->render() ?>
  <button class="btn btn-outline-danger" type="submit">Delete</button>
</div>
<?php $form->end(); ?>

Delete by
<div id="search-by" class="mb-3">
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="by" value="title" checked>
    <label class="form-check-label">By title</label>
  </div>

  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="by" value="author">
    <label class="form-check-label">By author</label>
  </div>
</div>

<div class="text-center"><strong><?php echo ($success) ? 'Success' : ''; ?></strong></div>

<script>
  // A small script to change
  const field = document.querySelector('.form-control');
  const radio = document.querySelector('#search-by');

  radio.addEventListener('change', (e) => {
    field.name = e.target.value;
    field.placeholder = 'Delete by ' + e.target.value + '...';
  })
</script>