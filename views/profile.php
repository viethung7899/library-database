<?php

use app\components\form\Field;
use app\components\form\Form;
use app\models\User;

$user = $body['user'] ?? new User();

$form = new Form('/profile', Form::POST, $user, $errors ?? []);
$nameField = $form->field('Name', 'name');
$usernameField = $form->field('Username', 'username');
$passwordField = $form->field('Password', 'password', true, Field::PASSWORD);

?>

<h1 class="my-5">Profile</h1>

<?php $form->begin(); ?>
<div class="mb-3">
  <?php $nameField->render() ?>
</div>
<div class="mb-3">
  <?php $usernameField->render() ?>
</div>
<div class="mb-3">
  <?php $passwordField->render() ?>
</div>
<button type="submit" class="my-2 btn btn-primary">Update</button>
<a role="button" href="/search" class="my-2 btn btn-secondary">Cancel</a>
<?php $form->end(); ?>

<div class="mx-3">
  <?php echo isset($body['success']) ? 'Success' : ''; ?>
</div>