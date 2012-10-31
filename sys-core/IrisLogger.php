<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
 * @class IrisLogger
 * Base logging class
 */
class IrisLogger
{
	public static $LOGGING_LEVEL = IMVC_LOGGER_LEVEL_DEBUG;
	private static $_loggers = array();


	public static function registerLogger($key, Logger $logger)
	{
		if (empty($key))
			return false;

		self::$_loggers[$key] = $logger;
		return true;
	}

	public static function unregisterLogger($key)
	{
		if (array_key_exists($key, self::$_loggers)) {
			$logger = self::$_loggers[$key];
			unset(self::$_loggers[$key]);
			return $logger;
		}
		return null;
	}

    /**
     * @param $level
     * Apply the same logging level to all registered loggers
     */
    public static function applyLoggingLevel($level){
        if(0 == ($num = count(self::$_loggers))){
            return;
        }
        foreach(self::$_loggers as $k){
            $k->setLoggingLevel($level);
        }
    }

	public static function logEvent($level, $message, array $args = null, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		$location = '';
		if ($class != null && $function != null) {
			$location .= "{$class}::{$function}";
		}
		else if ($function != null) {
			$location .= "{$function}";
		}
		else if ($class != null) {
			$location .= "{$class}";
		}
		if ($line != null) {
			$location .= " at line {$line}";
		}
		if ($file != null) {
			$location .= " in {$file}";
		}
		if ($location != '') {
			$location = ltrim($location);
			$message .= " ({$location})";
		}

		foreach (self::$_loggers as &$logger)
		{
			try {
				$logger->logEvent($level, $message, $args, $data);
			}
			catch (Exception $e) {
				// bail; we don't let the logging system interrupt our process
			}
		}
        return true;
	}

	public static function debug($message, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		return self::logEvent(IMVC_LOGGER_LEVEL_DEBUG, $message, null, $data, $file, $line, $function, $class);
	}

	public static function debugFormat($format, array $args = null, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		return self::logEvent(IMVC_LOGGER_LEVEL_DEBUG, $format, $args, $data, $file, $line, $function, $class);
	}

	public static function info($message, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		return self::logEvent(IMVC_LOGGER_LEVEL_INFO, $message, null, $data, $file, $line, $function, $class);
	}

	public static function infoFormat($format, array $args = null, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		return self::logEvent(IMVC_LOGGER_LEVEL_INFO, $format, $args, $data, $file, $line, $function, $class);
	}

	public static function warn($message, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		return self::logEvent(IMVC_LOGGER_LEVEL_WARN, $message, null, $data, $file, $line, $function, $class);
	}

	public static function warnFormat($format, array $args = null, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		return self::logEvent(IMVC_LOGGER_LEVEL_WARN, $format, $args, $data, $file, $line, $function, $class);
	}

	public static function error($message, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		return self::logEvent(IMVC_LOGGER_LEVEL_ERROR, $message, null, $data, $file, $line, $function, $class);
	}

	public static function errorFormat($format, array $args = null, $data = null, $file = null, $line = null, $function = null, $class = null)
	{
		return self::logEvent(IMVC_LOGGER_LEVEL_ERROR, $format, $args, $data, $file, $line, $function, $class);
	}

	public static function printVar($var, $exit = false){
		print_r($var);
		if ($exit) { exit; }
	}

    final public static function clearLogFile($clear = true){
        if($clear){
            foreach (self::$_loggers as &$logger) {
                $logger->clear();
            }
        }
        return true;
    }
}
/* End of file IrisLogger.php */