<?php

use app\components\form\Form;
use app\core\Application;
use app\models\BorrowRecord;


$model = $body['record'] ?? new BorrowRecord();

$form = new Form('/borrow', Form::GET, $model, $errors ?? []);
$name = Application::getApp()->getSession()->get('name');

$isbnField = $form->field('ISBN', 'isbn');
$titleField = $form->field('Title', 'title');
$beforeField = $form->field('Return date before', 'before');
$afterField = $form->field('Return date after', 'after');

?>

<h1 class="my-5">Books borrowed by <?php echo $name; ?></h1>

<?php $form->begin(); ?>
<button class="btn btn-outline-primary mb-3" type="submit">Search</button>

<div class="row">
  <div class="col-md mb-3">
    <?php $isbnField->render(); ?>
  </div>
  <div class="col-md mb-3">
    <?php $titleField->render(); ?>
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
      <th scope="col"><?php echo $r->isbn; ?></td>
      <td><?php echo $r->title; ?></td>
      <td><?php echo $r->borrowDate; ?></td>
      <td><?php echo $r->returnDate; ?></td>
      <th>
        <a class="btn btn btn-outline-success" href="
        /book?isbn=<?php echo $r->isbn; ?>" role="button">View</a>
      </th>
    </tr>
  <?php endforeach; ?>
</table>

<?php if (count($records) <= 0): ?>
  <p class="text-center">No results</p>
<?php endif; ?>