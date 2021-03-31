<?php

use app\core\Application;

$rootDir = Application::getRootDir();
include_once "$rootDir/components/BookDetail.php";

?>

<!-- Controll button DELETE or BACK -->
<div class="mt-2">
  <form class="form-inline" action="/library/book/delete" method="post">
    <input type="hidden" name="isbn" value="<?php echo $book->isbn ?>">
    <button role="submit" class="btn btn-danger" <?php echo ($bc > 0) ? 'disabled' : '' ?>>Delete Book</button>
    <a class="btn btn-secondary" role="button" href="/search?title=">Back</a>
  </form>
</div>