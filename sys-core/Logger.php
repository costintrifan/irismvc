<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */

//--------------------------------------------------------------------------------------------
// Constants used by logging API
//--------------------------------------------------------------------------------------------

/**
 * No output.
 */
define('IMVC_LOGGER_LEVEL_OFF', 0);

/**
 * Output error-handling messages.
 */
define('IMVC_LOGGER_LEVEL_ERROR', 1);

/**
 * Output warnings and error-handling messages.
 */
define('IMVC_LOGGER_LEVEL_WARN',  2);

/**
 * Output informational messages, warnings, and error-handling messages.
 */
define('IMVC_LOGGER_LEVEL_INFO',  3);

/**
 * Output all debugging and tracing messages.
 */
define('IMVC_LOGGER_LEVEL_DEBUG', 4);


/**
 * Base implementation for logging.
 */
abstract class Logger
{
	private $_level;
	private $_source;

	/**
	 *
	 * @param int $level
	 * @param string $source
	 */
	public function __construct($level = IMVC_LOGGER_LEVEL_OFF, $source = '')
	{
		$this->setLoggingLevel($level);
		$this->setLoggingSource($source);
	}


	public function debug($message, $data = null)
	{
		return $this->logEvent(IMVC_LOGGER_LEVEL_DEBUG, $message, null, $data);
	}

	public function debugFormat($format, array $args = null, $data = null)
	{
		return $this->logEvent(IMVC_LOGGER_LEVEL_DEBUG, $format, $args, $data);
	}

	public function info($message, $data = null)
	{
		return $this->logEvent(IMVC_LOGGER_LEVEL_INFO, $message, null, $data);
	}

	public function infoFormat($format, array $args = null, $data = null)
	{
		return $this->logEvent(IMVC_LOGGER_LEVEL_INFO, $format, $args, $data);
	}

	public function warn($message, $data = null)
	{
		return $this->logEvent(IMVC_LOGGER_LEVEL_WARN, $message, null, $data);
	}

	public function warnFormat($format, array $args = null, $data = null)
	{
		return $this->logEvent(IMVC_LOGGER_LEVEL_WARN, $format, $args, $data);
	}

	public function error($message, $data = null)
	{
		return $this->logEvent(IMVC_LOGGER_LEVEL_ERROR, $message, null, $data);
	}

	public function errorFormat($format, array $args = null, $data = null)
	{
		return $this->logEvent(IMVC_LOGGER_LEVEL_ERROR, $format, $args, $data);
	}

	public abstract function logEvent($level, $message, array $args = null, $data = null);

    public function clear()
    {
        return true;
    }

	public final function isDebugEnabled()
	{
		return $this->_level >= IMVC_LOGGER_LEVEL_DEBUG;
	}

	public final function isInfoEnabled()
	{
		return $this->_level >= IMVC_LOGGER_LEVEL_INFO;
	}

	public final function isWarnEnabled()
	{
		return $this->_level >= IMVC_LOGGER_LEVEL_WARN;
	}

	public final function isErrorEnabled()
	{
		return $this->_level >= IMVC_LOGGER_LEVEL_ERROR;
	}


	public final function getLoggingLevel()
	{
		return $this->_level;
	}

	public final function setLoggingLevel($level)
	{
		$this->validateLevel($level);
		$this->_level = $level;
	}

	public final function getLoggingSource()
	{
		return $this->_source;
	}

	public final function setLoggingSource($source)
	{
		$this->validateSource($source);
		$this->_source = $source;
	}


	protected final function validateLevel($level)
	{
		if (!is_integer($level) || ($level < IMVC_LOGGER_LEVEL_OFF || $level > IMVC_LOGGER_LEVEL_DEBUG))
			throw new IrisException(sprintf(IMVC_ERRMSG_INVALID_PARAMETER, 'level'), null, IMVC_ERROR_INVALIDPARAMETER);
	}

	protected final function validateSource(&$source)
	{
		if (!is_string($source) || strlen($source) > 60)
			throw new IrisException(sprintf(IMVC_ERRMSG_INVALID_PARAMETER, 'source'), null, IMVC_ERROR_INVALIDPARAMETER);
	}
}
/* End of file: Logger.php */