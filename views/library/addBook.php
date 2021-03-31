<?php

use app\components\form\Form;
use app\models\Book;

$model = $book ?? new Book();

$form = new Form('/librarian/add', 'get', $model, $errors ?? []);

$isbnField = $form->field('Isbn', 'isbn');
$titleField = $form->field('Title', 'title');
$authorField = $form->field('Author', 'author');
$publisherIdField = $form->field('PublisherId', 'publisherId'); 
$publisherNameField = $form->field('PublisherName', 'publisherName');
$categoryIdField = $form->field('CategoryId', 'categoryId'); 
$categoryNameField = $form->field('CategoryName', 'categoryName');
$quantityField = $form->field('Quantity', 'quantity');
$yearField = $form->field('Year', 'year');


?>

<h1 class="my-5">New Books</h1>

<?php $form->begin(); ?>

<div class="mb-3">
    <?php $isbnField->render() ?>
</div>

<div class="row">
  <div class="col-md mb-3">
    <?php $titleField->render() ?>
  </div>
  <div class="col-md mb-3">
    <?php $authorField->render() ?>
  </div>
</div>

<div class="row">
  <div class="col-md mb-3">
    <?php $publisherIdField->render() ?>
  </div>
  <div class="col-md mb-3">
    <?php $publisherNameField->render() ?>
  </div>
</div>

<div class="row">
  <div class="col-md mb-3">
    <?php $categoryIdField->render() ?>
  </div>
  <div class="col-md mb-3">
    <?php $categoryNameField->render() ?>
  </div>
</div>

<div class="row">
  <div class="col-md mb-3">
    <?php $quantityField->render() ?>
  </div>
  <div class="col-md mb-3">
    <?php $yearField->render() ?>
  </div>
</div>

<button type="submit" class="my-2 btn btn-primary">Add</button>

<?php $form->end(); ?>