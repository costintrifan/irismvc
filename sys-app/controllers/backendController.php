<?php if(! defined('IMVC_BASE_PATH')) { exit; }

class backendController extends SiteBaseController
{
	public function __construct()
	{
		parent::__construct();

		$this->view->useMasterPage('siteMaster.php');
	}

	public function index()
	{
        $this->view->pageTitle('Backend home page');
        $this->view->render();
    }

	/*
	* @public
	* Display the error page. Must be implemented in derived classes.
	* @param string $pageTitle The error page's title.
	* @params string $errorMessage The error page's content message.
	* @return void
	*/
	public function error( $errorTitle = 'Page Not Found', $errorMessage = 'The page you were looking for was not found' )
	{
		parent::error($errorTitle, $errorMessage);
	}
}