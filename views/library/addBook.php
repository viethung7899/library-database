<?php

use app\components\core\Selector;
use app\components\form\Form;
use app\models\Book;

$model = $body['book'] ?? new Book();

$form = new Form('/library/book/add', Form::POST, $model, $errors ?? []);
$isnbField = $form->field('ISBN', 'isbn');
$titleField = $form->field('Title', 'title');
$authorField = $form->field('Author', 'author');
$publisherField = $form->field('Publisher', 'publisher_name');
$quantityField = $form->field('Quantity', 'quantity');
$yearField = $form->field('Year', 'year');

// Making categories selector
$cats = [];
foreach ($body['categories'] as $cat) {
  $cats[$cat->name] = $cat->id;
}

$selector = new Selector('Category', 'category_id', $cats);

?>

<h1 class="my-5">Add new book</h1>

<?php $form->begin(); ?>

<div class="row">
  <div class="col-md mb-3">
    <?php $isnbField->render() ?>
  </div>
  <div class="col-md mb-3">
    <?php $selector->render(); ?>
  </div>
  <div class="col-md mb-3">
    <?php $quantityField->render() ?>
  </div>
</div>

<div class="col-md mb-3">
  <?php $titleField->render() ?>
</div>

<div class="row">
  <div class="col-md mb-3">
    <?php $authorField->render() ?>
  </div>
  <div class="col-md mb-3">
    <?php $publisherField->render() ?>
  </div>
  <div class="col-md mb-3">
    <?php $yearField->render() ?>
  </div>
</div>

<button type="submit" class="my-2 btn btn-primary">Add</button>
<?php $form->end(); ?>