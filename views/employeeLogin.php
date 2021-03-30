<?php

use app\components\form\Field;
use app\components\form\Form;
use app\core\Request;

$form = new Form('/library/login', Form::POST, Request::body(), $errors ?? []);
$usernameField = $form->field('Username', 'username');
$passwordField = $form->field('Password', 'password', true, Field::PASSWORD);

?>

<h1 class="my-5">Employee Portal</h1>

<?php $form->begin(); ?>
  <div class="mb-3">
    <?php $usernameField->render() ?>
  </div>
  <div class="mb-3">
    <?php $passwordField->render() ?>
  </div>
  <div class="my-2">
    <p>Not an employee? <a href="/login">Login here</a></p>
  </div>
  
  <div class="my-1">
  <div>Which role are you in?</div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="level" value="1" checked>
      <label class="form-check-label">Librarian</label>
    </div>
    
    <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="level" value="2">
      <label class="form-check-label">Adminstrator</label>
    </div>
    
    <div>
      <button type="submit" class="my-2 btn btn-primary">Log in</button>
    </div>
  </div>
<?php $form->end(); ?>