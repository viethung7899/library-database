<?php

use app\components\form\Field;
use app\components\form\Form;
use app\core\Request;
use app\utils\Dumpster;

$form = new Form('/register', Form::POST, Request::body(), $errors ?? []);
$usernameField = $form->field('Username', 'username');
$passwordField = $form->field('Password', 'password');
$confirmPasswordField = $form->field('Confirm password', 'confirmPassword');

?>

<h1>Register</h1>

<?php echo $form->begin(); ?>
  <?php echo $usernameField->render() ?>
  <?php echo $passwordField->render(Field::PASSWORD) ?>
  <?php echo $confirmPasswordField->render(Field::PASSWORD) ?>
  <button type="submit" class="my-2 btn btn-primary">Register</button>
<?php echo $form->end(); ?>