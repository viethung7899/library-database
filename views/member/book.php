<?php

use app\controllers\BaseController;
use app\core\Application;

$rootDir = Application::getRootDir();
include_once "$rootDir/components/BookDetail.php";

$level = BaseController::getSession()->get('level');
$id = BaseController::getSession()->get('id');

if ($level == BaseController::MEMBER) :
  $hiddenId = sprintf('<input type="hidden" name="user_id" value="%s">', $id);
  $hiddenISBN = sprintf('<input type="hidden" name="ibsn" value="%s">', $book->isbn);

  $reserved = false;
  foreach ($reservations as $r) {
    if ($r->user_id == $id) {
      $reserved = true;
      break;
    }
  }

  $borrowed = false;

  foreach ($records as $b) {
    if ($b->user_id == $id) {
      $borrowed = true;
      break;
    }
  }

  $status = '';
  if ($reserved) $status = 'Reserved';
  if ($borrowed) $status = 'Borrowing';


?>


  <?php if (!empty($status)) : ?>
    <div class="mb-3">Status: <strong><?php echo $status ?></strong></div>
  <?php endif; ?>

  <div>
    <form class="mb-3" action="/reservation/confirm" method="post">
      <?php
      echo $hiddenId;
      echo $hiddenISBN;
      ?>
      <button type="submit" class="btn btn-success" <?php echo ($reserved || $borrowed || $av == 0) ? 'disabled' : '' ?>>
        Make reservation
      </button>
      <a role="button" class="btn btn-danger <?php echo (!$reserved || $borrowed) ? 'disabled' : '' ?>" href="/reservation/cancel?user_id=<?php echo $id; ?>&isbn=<?php echo $book->isbn; ?>">
        Cancel reservation
      </a>
      <a href="/search?title=" class="btn btn-secondary">Back</a>
    </form>
  </div>

<?php endif; ?>