<?php

use app\components\form\Form;
use app\models\BorrowRecord;
use app\utils\Dumpster;

$model = $body['record'] ?? new BorrowRecord();

$form = new Form('/library/borrow', Form::GET, $model, $errors ?? []);

$isbnField = $form->field('ISBN', 'isbn');
$titleField = $form->field('Title', 'title');
$nameField = $form->field('Borrower', 'name');
$beforeField = $form->field('Return date before', 'before');
$afterField = $form->field('Return date after', 'after');

?>

<h1 class="my-5">Search borrowing records</h1>

<?php $form->begin(); ?>
<button class="btn btn-outline-primary mb-3" type="submit">Search</button>
<a role="button" class="btn btn-outline-primary mb-3" href="/library/borrow/add">Add new record</a>

<div class="row">
  <div class="col-md mb-3">
    <?php $isbnField->render(); ?>
  </div>
  <div class="col-md mb-3">
    <?php $titleField->render(); ?>
  </div>
  <div class="col-md mb-3">
    <?php $nameField->render(); ?>
  </div>
</div>

<div class="row">
  <div class="col-md mb-3">
    <?php $beforeField->render(); ?>
  </div>
  <div class="col-md mb-3">
    <?php $afterField->render(); ?>
  </div>
</div>

<?php $form->end(); ?>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">Record ID</th>
      <th scope="col">User ID</th>
      <th scope="col">Name</th>
      <th scope="col">ISBN</th>
      <th scope="col">Title</th>
      <th scope="col">Borrowing date</th>
      <th scope="col">Returning date</th>
      <th></th>
    </tr>
  </thead>
  <?php $records = $body['records'] ?? [];
  foreach ($records as $r) :
  ?>
    <tr>
      <th scope="row"><?php echo $r->id; ?></th>
      <td><?php echo $r->user_id; ?></td>
      <td><?php echo $r->name; ?></td>
      <td><?php echo $r->isbn; ?></td>
      <td><?php echo $r->title; ?></td>
      <td><?php echo $r->borrowDate; ?></td>
      <td><?php echo $r->returnDate; ?></td>
      <th>
        <a class="btn btn btn-outline-success" href="
        /library/borrow/return?id=<?php echo $r->id; ?>
        " role="button">Return</a>
      </th>
    </tr>
  <?php endforeach; ?>
</table>

<?php if (count($records) <= 0): ?>
  <p class="text-center">No results</p>
<?php endif; ?>