<?php

use app\models\Book;

$books = Book::borrowedByEveryMember();

?>

<h1 class="mt-5">Favorite books by every member</h1>
<p class="mb-5">The list of books borrowed by everry member</p>

<?php foreach ($books as $book) : ?>
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title"><a href="/book?isbn=<?php echo $book->isbn; ?>"><?php echo $book->title ?></a></h5>
      <h6 class="card-subtitle mb-2 text-muted"><?php echo $book->author ?></h6>
      <p class="mb-2 text-muted"><em><?php echo $book->category_name ?></em></p>
      <p class="mb-2 text-muted">ISBN-<?php echo $book->isbn ?></p>
    </div>
  </div>
<?php endforeach; ?>