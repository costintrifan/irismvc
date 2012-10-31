<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
* @class FrontController
* @singleton
* This class is responsible with the request management(Instantiating the appropriate controller and dispatching the request)
*/
final class FrontController
{
	/**
	* @private
	* @static
	* Holds the reference to the instance of this classs
	* @type FrontController object
	*/
	private static $_instance = null;
	/**
	* @private
	* Holds the reference to the instance of the instantiated controller classs
	& @type BaseController object
	*/
	private $_controller = null;

	/**
	* @protected
	* Holds the name of the loaded controller
	* @type string
	*/
    protected $_controllerName = '';
	/**
	* @protected
	* Holds the name of the action to trigger
	* @type string
	*/
    protected $_actionName = '';
	/**
	* @protected
	* Holds the list of args to pass to the triggered action
	* @type array
	*/
    protected $_args = array();


	/**
	* @private
	* Constructor
	*/
	private function __construct() {}

	/**
	* @final
	* @public
	* Retrieve the reference to the instance of this classs
	* @param Configuration $config  The reference to the instance of the Configuration classs
	* @type FrontController object
	*/
	final public static function getInstance()
	{
		if (is_null(self::$_instance) || !(self::$_instance instanceof self))
		{
			self::$_instance = new FrontController();
		}
		return self::$_instance;
	}

	/**
	* @final
	* @public
	* Dispatch the request to the appropriate controller and trigger the specified action
	* @return void
	*/
	final public function dispatch()
	{
		$controllerName = $this->getControllerName();
		if (empty($controllerName))
		{
			$this->parseUrl();

			$controllerName = $this->getControllerName();
			$actionName = $this->getActionName();
			$arguments = $this->getArguments();
		}

		// if controller not already loaded
		if ( ! Util::stringsEqual($controllerName.'Controller', $this->getLoadedControllerName()))
		{
			// check if controller exists
			if ( ! $this->controllerExists($controllerName))
			{
				// Check the default controller
				$this->_controller = $this->loadController(IMVC_DEFAULT_CONTROLLER_NAME);
				$actionName = $controllerName;
			}
			else { $this->_controller = $this->loadController($controllerName); }
		}

		if ( ! $this->controllerExists($controllerName))
		{
			// Check the default controller
			$this->_controller = $this->loadController(IMVC_DEFAULT_CONTROLLER_NAME);
		}

		if ( ! $this->allowMethodCall($this->_controller, $actionName))
		{
			$actionName = 'error';
		}

		noCacheHeaders();

		/*
        * @@ Dispatch the request and trigger the action
		*/
        call_user_func_array(array($this->_controller,$actionName), $arguments);

		exit;
	}

	/**
	* @final
	* @public
	* Retrieve the reference to the instance of the loaded controller class
	* @return BaseController object or null if none instantiated
	*/
	final public function getLoadedController(){ return $this->_controller; }

	/**
	* @final
	* @public
	* Retrieve the name of the controller from URL
	* @return string
	*/
	final public function getControllerName() { return $this->_controllerName; }

	/**
	* @final
	* @public
	* Retrieve the name of the action from URL
	* @return string
	*/
	final public function getActionName() { return $this->_actionName; }

	/**
	* @final
	* @public
	* Retrieve the list of parameters from URL
	* @return array
	*/
	final public function getArguments() { return $this->_args; }

	/**
	* @final
	* @public
	* Retrieve the specified argument from the URL
	* @return string
	*/
	final public function getArgument( $index = 0 ) { return (isset($this->_args[$index]) ? $this->_args[$index] : null); }

    /*
	* @final
	* @public
    * Get all parameters from the querystring
    * @return array
    */
    final public function getQueryParams()
    {
        $params = array();
		foreach ($_GET as $k => $v) {
			if ( ! Util::startsWith('/', $k)) {
				$params[$k] = $v;
			}
		}
		return $params;
    }

    /*
	* @final
	* @public
    * Get the specified parameter from the querystring
    * @return string if found otherwise null
    */
    final public function getQueryParam( $paramName ) { return (isset($_GET[$paramName]) ? $_GET[$paramName] : null); }

	/**
	* @final
	* @public
	* Retrieve the current viewed page( controller/action )
	* This method should be called only after ParseUrl()
	* @return string controllerName/actionName
	*/
	final public function getCurrentPage() { return $this->getControllerName().'/'.$this->getActionName(); }

    /*
	* @final
	* @public
    * Retrieve the list of URL parts as an associative array
    * @return array
    */
	final public function getSegments()
	{
		return array
		(
			'controller' => $this->getControllerName(),
			'action' => $this->getActionName(),
			'args' => $this->getArguments(),
			'queryParams' => $this->getQueryParams()
		);
	}

	/**
	* @final
	* @public
	* @uses class Sentinel
	* @uses class Util
	* @uses global constant IMVC_SITE_PATH
	* Check to see whether or not the page( controller/action/args ) is the same as the page requested in the browser window
	* This method will allow you to search for a page using this format: controller/* or controller/action/* which will match any page
	* served by the specified controller.
	* @param string The controller, the action and the arguments to use for building the path that will be matched against the current
	* browsed url
	* @return boolean
	*/
	final public function isPage( $controllerActionArgs )
	{
		/** Get current url !*/
        $scheme = (!empty($_SERVER['HTTPS']) && (strtoupper($_SERVER['HTTPS']) == 'ON')) ? 'https' : 'http';
        $basePath = $scheme.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$crtPath = IMVC_SITE_PATH . $controllerActionArgs;

		// Check for *
		if (($pos = strpos($crtPath,'*')) !== false)
		{
			$crtPath = str_replace('*','',$crtPath);
			// get the remaining string of $baseUrl from $pos to the end of the string
			$strLast = substr($basePath, $pos);
			$crtPath .= $strLast;
		}
		return Util::stringsEqual($crtPath, $basePath);
	}

    /*
	* @final
	* @public
    * Parse the URL and populate the internal fields
    * @return FrontController object
    */
	final public function parseUrl()
	{
        $args = array();
        $controllerName = IMVC_DEFAULT_CONTROLLER_NAME;
		$actionName = 'index';

        $url = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';

		// Check for querystring params
		if (($pos = strpos($url, '?')) !== false)
		{
			$url = substr($url,0,$pos);
		}

		if (($pos = stripos($url, IMVC_INSTALL_DIR)) !== false)
		{
			$url = substr($url,$pos+strlen(IMVC_INSTALL_DIR), strlen($url));
		}
        $parts = explode('/', trim($url, '/'));

        if ( ! empty($parts) )
        {
            //@ get the controller name
            $controllerName = (empty($parts[0]) ? IMVC_DEFAULT_CONTROLLER_NAME : $parts[0]);

			//@ check if controller exists
			if ( ! $this->controllerExists($controllerName))
			{
				// there is only the action in the url, no controller

				// fallback to the default controller
				$controllerName = IMVC_DEFAULT_CONTROLLER_NAME;

				// get the action name
				if ( isset($parts[0]) )
				{
					$actionName = $parts[0];

					//# If action == page.php
					if (Util::endsWith('.php', $actionName)) {
						$actionName = substr($actionName, 0, strrpos($actionName, '.'));
					}

					//@ go for arguments
					if ( isset($parts[1])){
						unset($parts[0]);
						// reset array keys
						$parts = array_values($parts);
						foreach ( $parts as $part ){
							array_push($args, $part);
						}
					}
				}
			}
			else
			{
				// get the action name
				if ( isset($parts[1]) )
				{
					$actionName = $parts[1];

					//# If action == page.php
					if (Util::endsWith('.php', $actionName)) {
						$actionName = substr($actionName, 0, strrpos($actionName, '.'));
					}

					//@ go for arguments
					if ( isset($parts[2])){
						unset($parts[0], $parts[1]);
						// reset array keys
						$parts = array_values($parts);
						foreach ( $parts as $part ){
							array_push($args, $part);
						}
					}
				}
			}

			//# If controller == page.php
			if (Util::endsWith('.php', $controllerName)) {
				$controllerName = substr($controllerName, 0, strrpos($controllerName, '.'));
			}
        }

		if (Util::stringsEqual($controllerName, $actionName) && ! Util::stringsEqual($controllerName, IMVC_DEFAULT_CONTROLLER_NAME))
		{
			$controllerName = IMVC_DEFAULT_CONTROLLER_NAME;
		}

		// Check if valid controller
		if ( ! preg_match("/[a-z0-9_]/iU", $controllerName)) {
			$controllerName = IMVC_DEFAULT_CONTROLLER_NAME;
		}
		// Check if valid action
		if ( ! preg_match("/[a-z0-9_]/iU", $actionName)) {
			$actionName = 'error';
		}

        $this->_controllerName = $controllerName;
        $this->_actionName = $actionName;
        $this->_args = $args;

        return $this;
	}

    /**
	* @final
	* @protected
	* Return a new instance of the given controller
	* @param string $controllerName The name of the controller to load
	* @return BaseController object
	*/
    final protected function loadController( $controllerName )
    {
        $controllerName .= 'Controller';
        return new $controllerName();
    }

    /**
	* @final
	* @protected
	* Check to see whether or not the provided controller exists
	* @param string $controllerName
	* @return boolean
	*/
    final protected function controllerExists( $controllerName ) { return is_file(IMVC_CONTROLLERS_DIR_PATH.$controllerName.'Controller.php'); }

    /**
	* @final
	* @protected
	* Check to see whether or not the provided controller has the action
	*       $actionName implemented.
	* @param object $controller The reference to the loaded controller class
	* @param string $actionName The name of the action
	* @return boolean
	*/
    final protected function controllerHasMethod( $controller, $actionName )
    {
        // check to see whether or not the controller has the action implemented
        $has_method = (int)method_exists($controller, $actionName);
        return ($has_method ? true : false);
    }

    /**
	* @final
	* @protected
	* @uses ReflectionMethod class
	* Check to see whether or not the provided action is public.
	*       Controller's private(internal) methods are prefixed with an underscore.
	* @param string $actionName The name of the action to check
	* @return boolean false if the $actionName is not a public method, otherwise true
	*/
    final protected function allowMethodCall( BaseController $controller, $actionName )
    {
		try {
			$r = new ReflectionMethod($controller, $actionName);
			return $r->isPublic();
		}
		catch(Exception $e) { return false; }
    }

	/**
	* @final
	* @protected
	* Check to see whether or not the controller has been loaded
	* @return boolean
	*/
	final protected function controllerIsLoaded() { return (empty($this->_controller) ? false : true); }

	/**
	* @final
	* @protected
	* Retrieve the name of the loaded controller class
	* @return string
	*/
	final protected function getLoadedControllerName()
	{
		if (empty($this->_controller)){
			return '';
		}
		return get_class($this->_controller);
	}
}
/* End of file: FrontController.php */