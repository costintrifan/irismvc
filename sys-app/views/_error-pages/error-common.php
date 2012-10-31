<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/**
* This is an example of a global error page.
*/
?>
<div>
    <p><?php echo $this->model->get('errorMessage');?></p>
    <p>Use this page to display all kind of errors that might occur in your website</p>
    <p>Template path: ./site/views/_shared/error-common.php</p>
</div>
