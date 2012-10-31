<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/*
* Custom user functions. Use this file to store your global functions.
*/


/**
 * @public
 * @desc Activate the appropriate menu item depending on the page viewed
 * @param string $action The name of the action to check aginst the current page
 * @param string $controller The name of the controller to match against the currently active controller.
 * Defaults to IMVC_DEFAULT_CONTROLLER_NAME
 * @param string $cssClassName The name of the css class to apply to the active menu item
 * @return string The $cssClassName on success, emtpy string for no matches.
 */
function activateMenu($action, $controller = IMVC_DEFAULT_CONTROLLER_NAME, $cssClassName = 'active')
{
    $fc          = Application::getFrontController();
    $_controller = $fc->getControllerName();
    $_action     = $fc->getActionName();

    if (!Util::stringsEqual($controller, $_controller)) { return ''; }
    if (!Util::StringsEqual($action, $_action)) { return ''; }
    return $cssClassName;
}
