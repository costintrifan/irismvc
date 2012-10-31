<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/**
* Error logs page
* Template path: ./sys-app/views/frontend/logs.php
*/

// $this = is the reference to the instance of a View class

$frontController = FrontController::getInstance();

echo '<h2>',$frontController->getControllerName(),' controller loaded, action ',$frontController->getActionName(),' triggered.</h2>';

	$data = $this->model->get('logEntries');
	if (empty($data))
	{
		echo '<p>There are no error messages to display!</p>';
	}
	else 
	{
		echo '<pre>', $data, '</pre>';
	}
?>
<p>Template path: ./sys-app/views/frontend/logs.php</p>