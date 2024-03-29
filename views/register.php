<?php

use app\components\form\Field;
use app\components\form\Form;
use app\models\User;

$model = $user ?? new User();

$form = new Form('/register', Form::POST, $model, $errors ?? []);
$nameField = $form->field('Name', 'name');
$usernameField = $form->field('Username', 'username');
$passwordField = $form->field('Password', 'password', true, Field::PASSWORD);
$confirmPasswordField = $form->field('Confirm password', 'confirmPassword', true, Field::PASSWORD);

?>

<h1 class="my-5">Become new member</h1>

<?php $form->begin(); ?>
  <?php $nameField->render() ?>
  <?php $usernameField->render() ?>
  <?php $passwordField->render() ?>
  <?php $confirmPasswordField->render() ?>
  <p>Already a member? <a href="/login">Log in</a></p>
  <button type="submit" class="my-2 btn btn-primary">Register</button>
<?php $form->end(); ?>