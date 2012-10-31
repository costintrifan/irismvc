<?php if(! defined('IMVC_BASE_PATH')) { exit; }

// Do base stuff here so you won't repeat yourself in each controller

class SiteBaseController extends BaseController
{
	public function __construct()
	{
		parent::__construct();

        // The Model and the View classes defined here
		// will be globally available in all derived
		// controllers. If you want to extend them and use
		// the derived classes in one of your controllers
		// you'll just need to override them in that controller
		$this->model = new Model();
		$this->view = new View($this->model);
	}

	/**
	* @public
	* Display the default page. Must be implemented in derived classes.
	* ! No need for parent::index() in your controllers as it will have no effect anyway.
	* @return void
	*/
	public function index(){}


// ERROR PAGES
	/*
	* @public
	* Display the error page. Must be implemented in derived classes.
	* @param string $errorTitle The error title.
	* @params string $errorMessage The error page's content message.
	* @return void
	*/
	public function error( $errorTitle = '', $errorMessage = '' )
	{
		/**
		* To display an error page you can either:
		* 1. use one of your master pages
		* 2. use a custom layout
		* 3. use none of the above and just display the error message to the browser window,
		*    as in the example below
		*/
		// display error

		$this->model->set('errorMessage', empty($errorMessage) ? '' : $errorMessage);
        
		$this->view->useMasterPage('siteMaster.php');
		$this->view->pageTitle(empty($errorTitle) ? 'An error occurred' : $errorTitle);
		$this->view->render('error-common', '_error-pages/');
	}
}