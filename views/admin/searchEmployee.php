<?php

use app\components\form\Form;
use app\core\Request;

$form = new Form('/admin/search', Form::POST, Request::body(), $errors ?? []);
$employeeField = $form->field('Searching...', 'name', false);

?>

<h1 class="my-5">Search for employees</h1>

<?php $form->begin(); ?>
  <div class="input-group mb-3">
    <?php $employeeField->render() ?>
    <button class="btn btn-outline-primary" type="submit">Search</button>
  </div>
  
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="by" value="title" checked>
    <label class="form-check-label">By name</label>
  </div>
  
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="by" value="title">
    <label class="form-check-label">By role</label>
  </div>
<?php $form->end(); 

// Search result shown here
?>

