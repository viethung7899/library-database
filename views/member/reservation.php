<?php

use app\components\form\Form;
use app\core\Application;
use app\models\Reservation;

$model = $body['reservation'] ?? new Reservation();
$name = Application::getApp()->getSession()->get('name');

$form = new Form('/reservation', Form::GET, $model, $errors ?? []);
$isbnField = $form->field('ISBN', 'isbn');
$titleField = $form->field('Book title', 'title');

?>

<h1 class="my-5">Books reserved by <?php echo $name; ?></h1>

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
<?php $form->end(); ?>

<table class="table table-striped table-hover">
  <thead>
    <tr>
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
      <th scope="row"><?php echo $r->isbn; ?></th>
      <td><?php echo $r->title; ?></td>
      <td><?php echo $r->pickupDate; ?></td>
      <th>
        <a class="btn btn btn-outline-success" href="<?php echo sprintf('/book?isbn=%s', $r->isbn) ?>" role="button">View</a>
      </th>
    </tr>
  <?php endforeach; ?>
</table>

<?php if (count($reservations) <= 0) : ?>
  <p class="text-center">No results</p>
<?php endif; ?>