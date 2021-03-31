<?php

use app\components\form\Form;
use app\models\Book;

$model = $book ?? new Book();

$form = new Form('/librarian/add', 'get', $model, $errors ?? []);



?>

<h1 class="my-5">New Books</h1>

<?php $form->begin(); ?>