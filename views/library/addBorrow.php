<?php

use app\components\form\Form;
use app\models\BorrowRecord;
use app\utils\Dumpster;

$model = $body['record'] ?? new BorrowRecord();

$form = new Form('/library/borrow/add', Form::POST, $model, $errors ?? []);
$idField = $form->field('User ID', 'user_id');
$isbnField = $form->field('ISBN', 'isbn');
$dateField = $form->field('Return date', 'returnDate');

?>

<h1 class="my-5">New record</h1>

<?php $form->begin(); ?>
  <?php $idField->render() ?>
  <?php $isbnField->render() ?>
  <?php $dateField->render() ?>
  <button type="submit" class="my-2 btn btn-primary">Add</button>
  <a role="button" class="btn btn-secondary" href="/library/borrow">Return</a>
<?php $form->end(); ?>