<?php

use app\components\form\Form;
use app\models\Book;

$model = $book ?? new Book();

$form = new Form('/search', Form::GET, $model, $errors ?? []);
$bookField = $form->field('Search by title...', 'title', false);

?>

<h1 class="my-5">Search for books</h1>

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
      <th scope="col">ISBN</th>
      <th scope="col">Title</th>
      <th scope="col">Author</th>
      <th scope="col">Publisher</th>
      <th scope="col">Year</th>
      <th scope="col">Quantity</th>
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