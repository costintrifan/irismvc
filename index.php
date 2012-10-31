<?php
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
 * @ This is your website's front controller.
 *=================================================================
 */

/**
 * Set the base path to the application's installation directory
 * @ This also could be used as a flag that you can use in your files
 * @ so they won't be accessible from outside app scope.
 *=================================================================
 */
define('IMVC_BASE_PATH', realpath(dirname(__FILE__)).'/');

/**
 * Load application's required files
 *==================================
 */
require(IMVC_BASE_PATH . 'sys-core/Util.php');
require(IMVC_BASE_PATH . 'sys-config/sys.constants.php');
require(IMVC_BASE_PATH . 'sys-config/sys.settings.php');
require(IMVC_BASE_PATH . 'sys-config/sys.functions.php');

/**
 * Set up logging
 *-------------------------
 */

//;; First set the debugging level if other than the default "DEBUG"
//IrisLogger::$LOGGING_LEVEL = IMVC_LOGGER_LEVEL_ERROR;

//;; Register needed loggers:
//IrisLogger::registerLogger('console', new ConsoleLogger(IrisLogger::$LOGGING_LEVEL));
IrisLogger::registerLogger('file', new FileLogger(IMVC_LOG_FILE_PATH, IrisLogger::$LOGGING_LEVEL));

$_f2 = IMVC_CODE_DIR_PATH.'site.functions.php';
if(is_file($_f2)){ require($_f2); }
unset($_f2);

/**
 * Start the Application
 *=================================================================
 */
Application::start();

/**
 * Parse url and dispatch the request to the appropriate controller
 *=================================================================
 */
Application::getFrontController()->dispatch();

/* End of file: index.php */