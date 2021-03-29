<?php

use app\components\form\Field;
use app\components\form\Form;
use app\core\Request;

$form = new Form('/login', Form::POST, Request::body(), $errors ?? []);
$usernameField = $form->field('Username', 'username');
$passwordField = $form->field('Password', 'password', Field::PASSWORD);

?>

<h1>Register</h1>

<?php $form->begin(); ?>
  <?php $usernameField->render() ?>
  <?php $passwordField->render() ?>
  <p>Not a member? <a href="/register">Register</a></p>
  <button type="submit" class="my-2 btn btn-primary">Register</button>
<?php $form->end(); ?>