<?php

use app\core\Application;
use app\models\Book;
use app\models\Employee;
use app\models\Member;

$name = Application::getApp()->getSession()->get('name');

?>
<h1 class="my-5">Welcome <?php echo $name ?></h1>

<h4 class="mt-3">User statistics</h4>
<table class="table table-bordered">
  <tbody>
    <tr>
      <th scope="row">Number of employees</th>
      <td><?php echo Employee::count(); ?></td>
    </tr>
    <tr>
      <th scope="row">Number of members</th>
      <td><?php echo Member::count(); ?></td>
    </tr>
  </tbody>
</table>