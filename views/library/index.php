<?php

use app\core\Application;
use app\models\Book;
use app\models\BorrowRecord;
use app\models\Reservation;

$name = Application::getApp()->getSession()->get('name');

$rcount = Reservation::countByUserId();
$rcountOverdue = Reservation::countByUserId(-1, true);

$brCount = BorrowRecord::countByUserId();
$brCountOverdue = BorrowRecord::countByUserId(-1, true);

?>
<h1 class="my-5">Hello <?php echo $name ?></h1>

<h4 class="mt-3">Borrowing and reservation</h4>
<table class="table table-bordered">
  <tbody>
    <tr>
      <th scope="row">Pending reservations</th>
      <td><?php echo $rcount ?></td>
    </tr>
    <tr>
      <th scope="row">Overdue pending reservations</th>
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

<h4 class="mt-5">Book statistics</h4>
<table class="table table-bordered">
  <tbody>
    <tr>
      <th scope="row">Number of copies</th>
      <td><?php echo Book::total(); ?></td>
    </tr>
    <tr>
      <th scope="row">Number of ISBNs</th>
      <td><?php echo Book::countIBSN(); ?></td>
    </tr>
  </tbody>
</table>