<?php

use app\components\form\Field;
use app\components\form\Form;
use app\core\Request;

$form = new Form('/register', Form::POST, Request::body(), $errors ?? []);
$nameField = $form->field('Name', 'name');
$usernameField = $form->field('Username', 'username');
$passwordField = $form->field('Password', 'password', Field::PASSWORD);
$confirmPasswordField = $form->field('Confirm password', 'confirmPassword', Field::PASSWORD);

?>

<h1>Register</h1>

<?php $form->begin(); ?>
  <?php $nameField->render() ?>
  <?php $usernameField->render() ?>
  <?php $passwordField->render() ?>
  <?php $confirmPasswordField->render() ?>
  <p>Already a member? <a href="/login">Log in</a></p>
  <button type="submit" class="my-2 btn btn-primary">Register</button>
<?php $form->end(); ?>