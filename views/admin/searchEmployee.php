<?php

use app\components\form\Form;
use app\core\Request;
use app\models\Employee;
use app\utils\Dumpster;

$model = $employee ?? new Employee();

$form = new Form('/admin/search', Form::POST, $model, $errors ?? []);
$employeeField = $form->field('Search by name...', 'name', false);

?>

<h1 class="my-5">Search for employees</h1>

<?php $form->begin(); ?>
<div class="input-group mb-3">
  <?php $employeeField->render() ?>
  <button class="btn btn-outline-primary" type="submit">Search</button>
</div>
<?php $form->end(); ?>

<?php

$employees = isset($body) ? $body['employees'] : [];

if (!empty($employees)) : ?>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Role</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($e = $employees->fetch(\PDO::FETCH_OBJ)) : ?>
        <tr>
          <th scope="row"><?php echo $e->user_id; ?></th>
          <td><?php echo $e->name; ?></td>
          <td><?php echo $e->role ;?></td>
        </tr>
        </thead>
      <?php endwhile ?>
    </tbody>
  </table>

<?php endif; ?>