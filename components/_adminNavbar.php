<?php use app\core\Application;



?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/admin">Library Database</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/admin">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/admin/search">Search employee</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/admin/add">New employee</a>
        </li>
      </ul>
      <div class="d-flex">
        <a class="btn btn-link mx-2" type="submit" role="button" href="/admin">
          <?php echo Application::getApp()->getSession()->get('name'); ?>
        </a>
        <a class="btn btn-outline-primary" type="submit" role="button" href="/logout">Logout</a>
      </div>
    </div>
  </div>
</nav>