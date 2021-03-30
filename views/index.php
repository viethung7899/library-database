<?php

use app\core\Application;

$name = Application::getApp()->getSession()->get('name');

?>
<h1 class="my-5">Hello <?php echo $name ?></h1>