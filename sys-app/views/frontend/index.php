<?php if(! defined('IMVC_BASE_PATH')) { exit; } ?>


<?php
// $this = is the reference to the instance of a View class

$frontController = FrontController::getInstance();

echo '<h2>',$frontController->getControllerName(),' controller loaded, action ',$frontController->getActionName(),' triggered.</h2>';

?>

<p>This is the home page template</p>

<p>path: ./sys-app/views/frontend/index.php</p>
<?php
    $fc = Application::getFrontController();
$args = $fc->getArguments();
print_r($args);
?>