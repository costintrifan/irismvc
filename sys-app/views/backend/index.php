<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/**
* Backend home page
* Template path: ./sys-app/views/backend/index.php
*/
// $this = is the reference to the instance of a View class

	$frontController = FrontController::getInstance();

	echo '<h2>',$frontController->getControllerName(),' controller loaded, action ',$frontController->getActionName(),' triggered.</h2>';
?>
<p>Template path: ./sys-app/views/backend/home.php</p>