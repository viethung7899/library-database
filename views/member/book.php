<?php

use app\core\Application;

$rootDir = Application::getRootDir();
include_once "$rootDir/components/BookDetail.php";

$id = Application::getApp()->getSession()->get('id');

$hiddenId = sprintf('<input disabled type="hidden" name="user_id" value="%d">', $id);
$hiddenISBN = sprintf('<input disabled type="hidden" name="user_id" value="%d">', $book->isbn);

?>

<div>
  <form class="mb-3" action="/reservation/confirm" method="post">
    <?php
    echo $hiddenId;
    echo $hiddenISBN;
    ?>
    <button type="submit" class="btn btn-success">
      Make reservation
    </button>
  </form>

  <form class="d-inline" action="/reservation/cancel" method="post">
    <?php
    echo $hiddenId;
    echo $hiddenISBN;
    ?>
    <button type="submit" class="btn btn-danger">
      Cancel rerservation
    </button>
  </form>

  <a href="/search?title=" class="btn btn-secondary">Back</a>
</div>