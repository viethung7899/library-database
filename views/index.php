<?php

use app\core\Application;
use app\models\BorrowRecord;
use app\models\Reservation;

$name = Application::getApp()->getSession()->get('name');
$id = Application::getApp()->getSession()->get('id');

$rcount = Reservation::countByUserId($id);
$rcountOverdue = Reservation::countByUserId($id, true);

$brCount = BorrowRecord::countByUserId(($id));
$brCountOverdue = BorrowRecord::countByUserId($id, true);

?>
<h1 class="my-5">Hello <?php echo $name ?></h1>

<h2>Summary</h2>

<table class="table table-bordered">
  <tbody>
    <tr>
      <th scope="row">Current reservations</th>
      <td><?php echo $rcount ?></td>
    </tr>
    <tr>
      <th scope="row">Overdue reservations</th>
      <td><?php echo $rcountOverdue ?></td>
    </tr>
    <tr>
      <th scope="row">Current borrowed books</th>
      <td><?php echo $brCount ?></td>
    </tr>
    <tr>
      <th scope="row">Current overdue borrowed books</th>
      <td><?php echo $brCountOverdue ?></td>
    </tr>
  </tbody>
</table>