<?php

use app\components\form\Field;

$reservation = $body['reservation'];

$hiddenId = sprintf('<input disabled type="hidden" name="user_id" value="%d">', $reservation->user_id);
$hiddenISBN = sprintf('<input disabled type="hidden" name="isbn" value="%d">', $reservation->isbn);

$dateField = new Field('Return date', 'returnDate');
$dateField->setData('', '');

?>

<h1 class="my-5">Reservation details</h1>

<table class="table table-bordered">
  <tbody>
    <tr>
      <th scope="row">ISBN</th>
      <td><?php echo $reservation->isbn ?></td>
    </tr>
    <tr>
      <th scope="row">Book title</th>
      <td><?php echo $reservation->title ?></td>
    </tr>
    <tr>
      <th scope="row">User ID</th>
      <td><?php echo $reservation->user_id ?></td>
    </tr>
    <tr>
      <th scope="row">Name</th>
      <td><?php echo $reservation->name ?></td>
    </tr>
    <tr>
      <th scope="row">Pickup date</th>
      <td><?php echo $reservation->pickupDate ?></td>
    </tr>
  </tbody>
</table>

<!-- Control buttons -->
<div>
  <form class="d-inline" action="/library/reservation/confirm" method="post">
    <?php echo $hiddenId;
    echo $hiddenISBN;
    ?>
    <div class="mb-3">
      <?php $dateField->render(); ?>
    </div>
    <button class="btn btn-success" role="submit">Confirm Reservation</button>
    <a class="btn btn-danger" href="/library/reservation/delete?user_id=<?php echo $reservation->user_id ?>&isbn=<?php echo $reservation->isbn ?>">Delete</a>
  </form>
</div>