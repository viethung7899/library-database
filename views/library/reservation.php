<?php

use app\controllers\BaseController;
use app\components\form\Form;
use app\models\Reservation;

$model = $body['reservation'] ?? new Reservation();

$form = new Form('/library/reservation', Form::GET, $model, $errors ?? []);
$idField = $form->field('ID', 'user_id');
$nameField = $form->field('Name', 'name');
$isbnField = $form->field('ISBN', 'isbn');
$titleField = $form->field('Book title', 'title');

?>

<h1 class="my-5">Search reservations</h1>

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
    <?php $idField->render(); ?>
  </div>
  <div class="col-md mb-3">
    <?php $nameField->render(); ?>
  </div>
</div>
<?php $form->end(); ?>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">ISBN</th>
      <th scope="col">Title</th>
      <th scope="col">Pickup date</th>
      <th></th>
    </tr>
  </thead>
  <?php $reservations = $body['reservations'] ?? [];
  foreach ($reservations as $r) :
  ?>
    <tr>
      <th scope="row"><?php echo $r->user_id; ?></th>
      <td><?php echo $r->name; ?></td>
      <td><?php echo $r->isbn; ?></td>
      <td><?php echo $r->title; ?></td>
      <td><?php echo $r->pickupDate; ?></td>
      <th>
        <a class="btn btn btn-outline-success" 
        href="<?php echo sprintf('/library/reservation/view?user_id=%d&isbn=%s', $r->user_id, $r->isbn) ?>"
        role="button">View</a>
      </th>
    </tr>
  <?php endforeach; ?>