<?php 

use app\controllers\BaseController; 
use app\core\Application;

// Get the crendential
$level = $_SESSION['level'] ?? -1;
$indexLink = '/';
$menu = Application::getRootDir().'/components/menu/';

if ($level == BaseController::LIBRARIAN) {
  $indexLink = '/librarian';
}

if ($level == BaseController::ADMIN) {
  $indexLink = '/admin';
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo $indexLink; ?>">Library Database</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo $indexLink; ?>">Home</a>
        </li>
        
        <!-- Search menu -->
        <?php if ($level !== BaseController::ADMIN): ?>
        <li class="nav-item">
          <a class="nav-link" href="/search">Search</a>
        </li>
        <?php endif; ?>


        <!-- Member menu -->
        <?php 
        switch ($level) {
          case BaseController::MEMBER:
            include_once $menu.'member.html';
            break;
          case BaseController::LIBRARIAN:
            include_once $menu.'librarian.html';
            break;
          case BaseController::ADMIN:
            include_once $menu.'admin.html';
        }
        ?>
      </ul>


      <!-- Right conner buttons -->
      <?php if (!BaseController::isLogin()): ?>
      <div class="d-flex">
        <a class="btn btn-primary mx-2" type="submit" role="button" href="/login">Login</a>
        <a class="btn btn-outline-primary" type="submit" role="button" href="/register">Register</a>
      </div>
      <?php else: ?>
      <div class="d-flex">
        <a class="btn btn-link mx-2" type="submit" role="button" href="/profile">
          <?php echo Application::getApp()->getSession()->get('name'); ?>
        </a>
        <a class="btn btn-outline-primary" type="submit" role="button" href="/logout">Logout</a>
      </div>
      <?php endif ?>
    </div>
  </div>
</nav>