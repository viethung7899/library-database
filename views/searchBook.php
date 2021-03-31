<?php

use app\controllers\BaseController;
use app\components\form\Form;
use app\models\Book;

$model = $book ?? new Book();

$form = new Form('/search', Form::GET, $model, $errors ?? []);
$bookField = $form->field('Search by title...', 'title', false);

$level = BaseController::getSession()->get('level') ?? -1;
$viewLink = '';
if ($level <= BaseController::MEMBER) $viewLink = '/book?isbn=';
if ($level === BaseController::LIBRARIAN) $viewLink = '/library/book?isbn=';

$showPublisher = $body['publisher'] ?? false;
$showYear = $body['year'] ?? false;


?>

<h1 class="my-5">Search for books</h1>

<?php $form->begin(); ?>
<div class="input-group mb-3">
  <?php $bookField->render() ?>
  <button class="btn btn-outline-primary" type="submit">Search</button>
</div>

<div class="me-3">Show more</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" name="showPublisher" type="checkbox" value="publisher">
  <label class="form-check-label" for="inlineCheckbox2">Publisher</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" name="showYear" type="checkbox" value="year">
  <label class="form-check-label" for="inlineCheckbox3">Year</label>
</div>
<?php $form->end(); ?>

Search by
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
      <?php if ($showPublisher) : ?>
        <th scope="col">Publisher</th>
      <?php endif; ?>
      <?php if ($showYear) : ?>
        <th scope="col">Year</th>
      <?php endif; ?>
      <th scope="col">Quantity</th>

      <?php if ($level != BaseController::ADMIN) : ?>
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
      <?php if ($showPublisher) : ?>
        <td><?php echo $book->publisher_name; ?></td>
      <?php endif; ?>
      <?php if ($showYear) : ?>
        <td><?php echo $book->year; ?></td>
      <?php endif; ?>

      <td><?php echo $book->quantity; ?></td>
      <?php if ($level != BaseController::ADMIN) : ?>
        <th>
          <a class="btn btn btn-outline-success" href="<?php echo $viewLink . $book->isbn ?>" role="button">View</a>
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
</table>