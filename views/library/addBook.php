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