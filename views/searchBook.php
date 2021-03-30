<?php

use app\components\form\Form;
use app\core\Request;

$form = new Form('/search', Form::POST, Request::body(), $errors ?? []);
$bookField = $form->field('Searching...', 'name', false);

?>

<h1 class="my-5">Search for books</h1>

<?php $form->begin(); ?>
  <div class="input-group mb-3">
    <?php $bookField->render() ?>
    <button class="btn btn-outline-primary" type="submit">Search</button>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="by" value="title">
    <label class="form-check-label">By title</label>
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="by" value="title">
    <label class="form-check-label">By author</label>
</div>
<?php $form->end(); ?>