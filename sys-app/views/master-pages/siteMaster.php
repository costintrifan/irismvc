<?php if ( ! defined('IMVC_BASE_PATH')) { return; }
/**
* SITE MASTER PAGE
*/
// $this = is the reference to the instance of the instantiated View class
$pageTitle = $this->pageTitle();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $pageTitle;?></title>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <?php echo $this->includeCss('ui-theme'); ?>
</head>
<body>
	<script src="http://localhost/seo-tools/tracker/tracker.js"></script>
	<script>track('UAX-XXXX-XXX');</script>

<div id="layout">

    <div id="header">
        <h1><a href="<?php echo IMVC_SITE_PATH;?>"><?php echo IMVC_SITE_NAME;?></a></h1>
    </div>

    <div id="navbar" class="box">
        <?php echo $this->getComponent('main-menu');?>
    </div>

    <div id="pageContent">
        <div id="sidebar">
            <?php echo $this->getComponent('global-sidebar'); ?>
        </div>

        <div id="content" class="box">
            <?php echo $this->pageContent(); ?>
        </div>
    </div>

    <div id="footer" class="box"><?php echo $this->getComponent('site-footer');?></div>
</div>

</body>
</html>