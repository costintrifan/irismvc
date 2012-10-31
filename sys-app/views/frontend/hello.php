<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/**
* Hello World page
* Template path: ./sys-app/views/frontend/index.php
*/
// $this = is the reference to the instance of a View class

$frontController = FrontController::getInstance();

echo '<h2>',$frontController->getControllerName(),' controller loaded, action ',$frontController->getActionName(),' triggered.</h2>';
?>

<p>This is just a dummy text</p>
<p>Template path: ./sys-app/views/frontend/home.php</p>





