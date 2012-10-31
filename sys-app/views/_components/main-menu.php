<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/*
*	If the controller is the default controller, then it can be omitted in the path
*/
?>

<ul class="menu">
    <li><a href="<?php echo createPath();?>" class="<?php echo activateMenu('index');?>">Home</a></li>
    <li><a href="<?php echo createPath('','hello');?>" class="<?php echo activateMenu('hello');?>">Hello</a></li>
    <li><a href="<?php echo createPath('','logs');?>" class="<?php echo activateMenu('logs');?>">Logs</a></li>
    <li><a href="<?php echo createPath('backend');?>" class="<?php echo activateMenu('index','backend');?>">Backend</a></li>
</ul>