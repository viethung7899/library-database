<?php

$book = $body['book'];
$reservations = $body['reservations'];

$rc = count($reservations);
$bc = 0;
$av = $book->quantity - $rc - $bc;

?>

<h1 class="mt-5"><?php echo $book->title ?></h1>
<h5 class="mb-3"><?php echo $book->author ?></h5>

<table class="table table-bordered">
  <tbody>
    <tr>
      <th scope="row">ISBN</th>
      <td><?php echo $book->isbn ?></td>
    </tr>
    <tr>
      <th scope="row">Publisher</th>
      <td><?php echo $book->publisher_name ?></td>
    </tr>
    <tr>
      <th scope="row">Publisher year</th>
      <td><?php echo $book->year ?></td>
    </tr>
    <tr>
      <th scope="row">Category</th>
      <td><?php echo $book->category_name ?></td>
    </tr>
    <tr>
      <th scope="row">Avaibable copies</th>
      <td><?php echo $av ?></td>
    </tr>
    <tr>
      <th scope="row">Reserved copies</th>
      <td><?php echo $rc ?></td>
    </tr>
    <tr>
      <th scope="row">Borrowed copies</th>
      <td><?php echo $bc ?></td>
    </tr>
  </tbody>
</table>