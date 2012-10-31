<?php if(! defined('IMVC_BASE_PATH')) { exit; }


class frontendController extends SiteBaseController
{
	public function __construct()
	{
		parent::__construct();

		// Set the master page to use per site section
		$this->view->useMasterPage('siteMaster.php');
	}

	public function index()
	{
		$this->view->pageTitle('Welcome!');
		$this->view->render();
	}

	public function hello()
	{
		$this->view->pageTitle('Hello World!');
        $this->view->render();
	}

	public function logs()
	{
		$this->view->pageTitle('Error logs');
        $this->view->render();
	}


	/*
	* @public
	* Display the error page. Must be implemented in derived classes.
	* @param string $errorTitle The error title.
	* @params string $errorMessage The error page's content message.
	* @return void
	*/
	public function error( $errorTitle = '404 - Page not found', $errorMessage = 'The page you requested was not found!' )
	{
		//@ Log error
		parent::error($errorTitle,$errorMessage);
	}
}