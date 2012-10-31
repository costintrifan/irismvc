<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
* @class BaseController
* Base Controller class. All controller classes should extend this class
*/
abstract class BaseController
{
	/**
	* @protected
	* Will hold the reference to the instance of the BaseModel class
	* @type BaseModel object
	*/
    protected $model = null;
	/**
	* @protected
	* Will hold the reference to the instance of the BaseView class
	* @type BaseView object
	*/
    protected $view = null;

	/**
	* @public
	* Holds the reference to the instance of the FrontController classs
	* @type FrontController object
	*/
	public $frontController = null;
	
	/**
	* @public
	* Constructor
	*/
	public function __construct(){ $this->frontController = Application::getFrontController(); }

	/**
	* @abstract
	* @public
	* This is the default action that will be triggered in any controller
	* if no other action is specified.
	* @return void
	*/
	abstract public function index();
	/*
	* @abstract
	* @public
	* Display the error page. Must be implemented in derived classes.
	* This method uses the Sentinel class to log the REQUEST_URI in case of a bad request.
	* @param string $errorTitle The error title.
	* @params string $errorMessage The error page's content message.
	* @return void
	*/
	abstract public function error( $errorTitle = '', $errorMessage = '' );
}
/* End of file: BaseController.php */