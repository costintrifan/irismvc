<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/**
 * @ Core functions
 * -----------------------------------------------------
 * ! No need to edit this file. If you want to add more
 * ! functions, please do it in the site.functions.php file
 * ! from the ./sys-code directory
 */

/**
* @since v.03
* This method has been moved here so the Routing class
* will have access to it and call it before dispatching the request
* so the NoCacheHeaders() function would not be needed in any of the
* controllers
*/
function noCacheHeaders()
{
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

/**
* @since v.04
* Utility debug method
 * @param mixed $data
 * @param bool $exit
* @return void
*/
function dump( $data, $exit = false ){
	echo '<pre>';
	if (is_array($data) || is_object($data)) {
		print_r($data);
	}
	else { var_dump($data); }
	echo '</pre>';
    if ($exit) { exit; }
}

/**
* @public
* Extends the php's in_array functionality by allowing $needle be an array instead of a string
* @param array $arrayNeedles The list of elements to search for in the $arrayHaystack array
* @param array $arrayHaystack The list of elements where to search in
* @return boolean
*/
function inArray( array $arrayNeedles, array $arrayHaystack )
{
	if (empty($arrayNeedles) || empty($arrayHaystack)) {
		return false;
	}
	foreach( $arrayNeedles as $item ){
		if (in_array($item, $arrayHaystack)) {
			return true;
		}
	}
	return false;
}

/**
* @public
* @uses Util
* @uses IMVC_SITE_PATH
* @uses IMVC_DEFAULT_CONTROLLER_NAME
* Create a path.
* @param string $controller The name of the Controller class to instantiate. Without the Controller suffix. Optional, defaults to the the default controller name.
* @param string $action  The name of the Method to trigger. Optional, defaults to index.
* @param array $params  The list of querystring variables to pass to the request. Optional.
* @return string  The new path.
*/
function createPath( $controller = '', $action = 'index', array $params = array() ){
	if ( ! empty($params)){
		if ( empty($action)) { $action = 'index'; }
		if ( ! empty($params)) { $params = implode('/',$params); }
		else { $params = ''; }
	}
	else{
		if ( empty($action)) { $action = 'index'; }
		if ((empty($controller) || Util::stringsEqual($controller, IMVC_DEFAULT_CONTROLLER_NAME)) && Util::stringsEqual($action, 'index'))
		{
			return IMVC_SITE_PATH;
		}
		else{
			if ( ! empty($params)) { $params = implode('/',$params); }
			else { $params = ''; }
		}
	}
	if ( ! empty($controller) && ! Util::endsWith('/', $controller)) { $controller .= '/'; }
	if ( ! empty($params) && ! Util::endsWith('/', $action)) { $action .= '/'; }
    if(empty($params) && in_array(strtolower($action),array('index','index/'))){
        $action = '';
    }

	return (IMVC_SITE_PATH . $controller . $action . $params);
}

/* End of file: sys.functions.php */