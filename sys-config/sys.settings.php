<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/**
* Application's settings
*----------------------------------------
*/

// UNCOMMENT THIS LINE WHEN GOING ON A LIVE SERVER
//    @ini_set("date.timezone", "UTC");
    @date_default_timezone_set('Europe/Bucharest');

/**
* magic_quotes_sybase overrides magic_quotes_gpc and this is a pain
* see: http://php.net/manual/en/function.get-magic-quotes-gpc.php
*
* Note that not all host will allow you to change these values at runtime
*------------------------------------------------------------------------
*/
	@ini_set('magic_quotes_sybase', 'Off');
	@ini_set('magic_quotes_gpc', 'Off');

# Do not allow the Session ID in URL
	@ini_set('session.use_trans_sid', 'Off');

# Make Session use cookies
	@ini_set('session.use_only_cookies', 'On');

    @ini_set('error_log',IMVC_LOG_FILE_PATH);

/*
| @@ Add all important dirs into the include path
|-------------------------------------------------
*/
    Util::addIncludePath(IMVC_SYS_DIR_PATH);
    Util::addIncludePath(IMVC_CONTROLLERS_DIR_PATH);
    Util::addIncludePath(IMVC_MODELS_DIR_PATH);
    //@ so you can add your own classes in their dirs
    $__entries = Util::dirToArray(IMVC_CODE_DIR_PATH, 1);
    foreach($__entries as $entry){
        if(is_dir($entry)){
            Util::addIncludePath($entry);
        }
    }
    unset($__entries);


/**
| -------------------------------------------------------------------
|  Autoloading classes
| -------------------------------------------------------------------
| This function will make available all classes within this framework
| without the use of the require or include directives.
| The class name must match the class's file name.
 */
function __autoload( $class )
{
    if(Util::endsWith('.php', $class) && !class_exists($class)){
        require_once($class);
    }
    else{
        if(!class_exists($class.'.php')){
            require_once("$class.php");
        }
    }
}
/* End of file: sys.settings.php */