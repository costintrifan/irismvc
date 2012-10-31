<?php if(! defined('IMVC_BASE_PATH')) { exit; }

//@ APPLICATION SETTINGS

/*
;; The name of, or the the full path to the directory where the framework is installed.
;; Leave empty if installed directly under root.
;; Ex (in a subdirectory of the root): "ROOT/irismvc-3.0"
*/
define('IMVC_INSTALL_DIR', 'irismvc-3.0');
define('IMVC_SITE_NAME', 'IrisMVC 3.0 DEMO');

define('IMVC_DEBUG', true);
define('IMVC_DEFAULT_CONTROLLER_NAME', 'frontend');
define('IMVC_DEFAULT_THEME_NAME', 'default');
define('IMVC_CURRENT_THEME_NAME', 'default');


/* No need to edit below this line unless you have to */

//@ DEFAULT DIR PATHS
define('IMVC_APP_DIR_PATH', IMVC_BASE_PATH.'sys-app/');
define('IMVC_CODE_DIR_PATH', IMVC_BASE_PATH.'sys-code/');
define('IMVC_CONFIG_DIR_PATH', IMVC_BASE_PATH.'sys-config/');
define('IMVC_CORE_DIR_PATH', IMVC_BASE_PATH.'sys-core/');
define('IMVC_LOGS_DIR_PATH', IMVC_BASE_PATH.'sys-logs/');
define('IMVC_SYS_DIR_PATH', IMVC_BASE_PATH.'sys-core/');
define('IMVC_TEMP_DIR_PATH', IMVC_BASE_PATH.'sys-temp/');
    define('IMVC_CACHE_DIR_PATH', IMVC_TEMP_DIR_PATH.'cache/');
    define('IMVC_SESSION_DIR_PATH', IMVC_TEMP_DIR_PATH.'session/');
    define('IMVC_UPLOADS_DIR_PATH', IMVC_TEMP_DIR_PATH.'uploads/');

//@ MVC
define('IMVC_CONTROLLERS_DIR_PATH', IMVC_APP_DIR_PATH.'controllers/' );
define('IMVC_MODELS_DIR_PATH', IMVC_APP_DIR_PATH.'models/' );
define('IMVC_VIEWS_DIR_PATH', IMVC_APP_DIR_PATH.'views/' );
define('IMVC_BACKEND_VIEWS_DIR_PATH', IMVC_VIEWS_DIR_PATH.'backend/' );
define('IMVC_FRONTEND_VIEWS_DIR_PATH', IMVC_VIEWS_DIR_PATH.'frontend/' );
define('IMVC_SHARED_VIEWS_DIR_PATH', IMVC_VIEWS_DIR_PATH.'_shared/' );
define('IMVC_MASTER_PAGES_DIR_PATH', IMVC_VIEWS_DIR_PATH.'master-pages/' );

//@ COMPONENTS DIR PATHS
define('IMVC_COMPONENTS_DIR_PATH', IMVC_VIEWS_DIR_PATH.'_components/' );
define('IMVC_BACKEND_COMPONENTS_DIR_PATH', IMVC_COMPONENTS_DIR_PATH.'backend/');
define('IMVC_FRONTEND_COMPONENTS_DIR_PATH', IMVC_COMPONENTS_DIR_PATH.'frontend/');

//@ ERROR PAGES DIR PATHS
define('IMVC_ERROR_PAGES_DIR_PATH', IMVC_VIEWS_DIR_PATH.'_error-pages/' );
define('IMVC_BACKEND_ERROR_PAGES_DIR_PATH', IMVC_ERROR_PAGES_DIR_PATH.'backend/' );
define('IMVC_FRONTEND_ERROR_PAGES_DIR_PATH', IMVC_ERROR_PAGES_DIR_PATH.'frontend/' );

//@ ERROR MESSAGES
define('IMVC_ERRMSG_INVALID_PARAMETER', 'Invalid parameter [%s].');
define('IMVC_ERROR_INTERNALF', 0x20);
define('IMVC_ERROR_INVALIDPARAMETER', 0x26);

//@ LOG FILES
define('IMVC_LOG_FILE_PATH', IMVC_LOGS_DIR_PATH.'app.log');
define('IMVC_BAD_LOG_FILE_PATH', IMVC_LOGS_DIR_PATH.'bad.access.log');

/**
 * The path to the website's root. Must end with a forward slash!
 */
$_appUrl = ((!empty($_SERVER['HTTPS']) && (strtoupper($_SERVER['HTTPS']) == 'ON')) ? 'https' : 'http') .'://'. $_SERVER['HTTP_HOST'];
if (!Util::endsWith('/', $_appUrl)) {
    $_appUrl .= '/';
}
if (!Util::endsWith('/', IMVC_INSTALL_DIR)) {
    $_appUrl .= IMVC_INSTALL_DIR.'/';
}
else { $_appUrl .= IMVC_INSTALL_DIR; }

//@ HTTP PATHS
define('IMVC_SITE_PATH', $_appUrl); unset($_appUrl);
define('IMVC_THEMES_PATH', IMVC_SITE_PATH.'sys-app/themes/');
define('IMVC_DEFAULT_THEME_PATH', IMVC_SITE_PATH.'sys-app/themes/'.IMVC_DEFAULT_THEME_NAME.'/');
define('IMVC_CURRENT_THEME_PATH', IMVC_SITE_PATH.'sys-app/themes/'.IMVC_CURRENT_THEME_NAME.'/');

//@ INTERNAL SETTINGS
define('IMVC_APP_CODENAME', 'Miha');
define('IMVC_APP_VERSION', 3.0);
define('IMVC_APP_STATUS', 'GA');
define('IMVC_APP_URL', 'http://irismvc.net/');

/*[ End of file sys.constants.php ]*/