<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
 * @class Application
 * The main class
 */
class Application
{
    /**
     * @private
     */
    private function __clone(){}
    /**
     * @private
     * Constructor
     */
    private function __construct(){}

    /**
     * @final
     * @public
     * @static
     * Start the application
     */
    final public static function start()
    {
        /**
         * Set debugging environment
         */
        self::debugEnvironment(IMVC_DEBUG);
        if(IMVC_DEBUG){
            IrisLogger::applyLoggingLevel(IMVC_LOGGER_LEVEL_DEBUG);
        }
        else {  IrisLogger::applyLoggingLevel(IMVC_LOGGER_LEVEL_INFO); }
    }

    /**
     * @final
     * @public
     * @static
     * Retrieve the reference to the instance of the FrontController class
     * @return FrontController object
     */
    final public static function getFrontController() { return FrontController::getInstance(); }
    /**
     * @final
     * @public
     * @static
     * @param bool $debugMode Defaults to false
     * Whether or not to enable the application's debug mode
     */
    final public static function debugEnvironment($debugMode = false)
    {
        if($debugMode){
            ini_set('display_errors', 'on');
            ini_set('display_startup_errors', 'on');
            ini_set('html_errors', 'on');
            ini_set('xmlrpc_errors', 'off');
            error_reporting(-1);
        }
        else{
            ini_set('display_errors', 'off');
            ini_set('display_startup_errors', 'off');
            ini_set('html_errors', 'off');
            ini_set('xmlrpc_errors', 'off');
            error_reporting(0);
        }
    }
}
/* End of file: Application.php */