<?php

use app\components\form\Field;
use app\components\form\Form;
use app\core\Request;

$form = new Form('/login', Form::POST, Request::body(), $errors ?? []);
$usernameField = $form->field('Username', 'username');
$passwordField = $form->field('Password', 'password', true, Field::PASSWORD);

?>

<h1 class="my-5">Log in</h1>

<?php $form->begin(); ?>
<div class="mb-3">
    <?php $usernameField->render() ?>
  </div>
  <div class="mb-3">
    <?php $passwordField->render() ?>
  </div>
  <p>Not a member? <a href="/register">Register</a></p>
  <p>Are you an employee? <a href="/library/login">Log in here</a></p>
  <button type="submit" class="my-2 btn btn-primary">Log in</button>
<?php $form->end(); ?>