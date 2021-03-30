<?php

use app\components\form\Form;
use app\core\Request;

$form = new Form('/search', Form::POST, Request::body(), $errors ?? []);
$bookField = $form->field('Type your title', 'name');

?>

<h1 class="my-5">Search for books</h1>

<?php $form->begin(); ?>
  <?php $bookField->render() ?>
<?php $form->end(); ?>