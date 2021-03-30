<?php

use app\controllers\BaseController;
use app\components\form\Form;
use app\models\Book;

$model = $book ?? new Book();

$form = new Form('/library/reservation', Form::GET, $model, $errors ?? []);
$idField = $form->field('ID', 'user_id');
$nameField = $form->field('Name', 'name');
$isbnField = $form->field('ISBN', 'isbn');
$titleField = $form->field('Book title', 'title');

?>

<h1 class="my-5">Search reservations</h1>

<?php $form->begin(); ?>
<div class="input-group mb-3">
  <?php $bookField->render() ?>
  <button class="btn btn-outline-primary" type="submit">Search</button>
</div>
<?php $form->end(); ?>

<div id="search-by" class="mb-3">
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="by" value="title" checked>
    <label class="form-check-label">By title</label>
  </div>

  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="by" value="author">
    <label class="form-check-label">By author</label>
  </div>
</div>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">ISBN</th>
      <th scope="col">Title</th>
      <th scope="col">Reservation date</th>
      <th scope="col">Pickup date</th>

      <?php if ($level == BaseController::ADMIN || BaseController::LIBRARIAN) : ?>
        <th></th>
      <?php endif; ?>
    </tr>
  </thead>
  <?php $books = $body['books'] ?? [];
  foreach ($books as $book) :
  ?>
    <tr>
      <th scope="row"><?php echo $book->isbn; ?></th>
      <td><?php echo $book->title; ?></td>
      <td><?php echo $book->author; ?></td>
      <td><?php echo $book->publisher_name; ?></td>
      <td><?php echo $book->year; ?></td>
      <td><?php echo $book->quantity; ?></td>
      <?php if ($level == BaseController::ADMIN || BaseController::LIBRARIAN) : ?>
        <th>
        <a class="btn btn btn-outline-success" href="" role="button">Confirm</a>
        <a class="btn btn btn-outline-danger" href="" role="button">Delete</a>
        </th>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>

  <script>
    // A small script to change
    const field = document.querySelector('.form-control');
    const radio = document.querySelector('#search-by');

    radio.addEventListener('change', (e) => {
      field.name = e.target.value;
      field.placeholder = 'Search by ' + e.target.value + '...';
    })
  </script>