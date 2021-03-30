<?php

use app\components\form\Form;
use app\components\LevelSelector;
use app\components\RoleSelector;
use app\core\Request;
use app\models\Employee;

$model = $employee ?? new Employee();

$form = new Form('/admin/add', 'post', $model, $errors ?? []);

$nameField = $form->field('Name', 'name');
$usernameField = $form->field('Username', 'username');
$passwordField = $form->field('Password', 'password');

$roleSelector = new RoleSelector();
$levelSelector = new LevelSelector();


?>

<h1 class="my-5">New employee</h1>

<?php $form->begin(); ?>

<div class="mb-3">
  <?php $nameField->render() ?>
</div>

<div class="row">
  <div class="col-md mb-3">
    <?php $usernameField->render() ?>
  </div>
  <div class="col-md mb-3">
    <?php $passwordField->render() ?>
  </div>
</div>

<div class="row">
  <div class="col-md mb-3">
    <?php $roleSelector->render(); ?>
  </div>
  <div class="col-md mb-3">
    <?php $levelSelector->render(); ?>
  </div>
</div>

<button type="submit" class="my-2 btn btn-primary">Add</button>

<?php $form->end(); ?>