<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */

/**
 * Stores log entries in a file.
 */
class FileLogger extends Logger
{
    private $_fileName;

    public function __construct($fileName, $level = IMVC_LOGGER_LEVEL_OFF, $source = '')
    {
        parent::__construct($level, $source);

        $this->setFileName($fileName);
    }

    public function logEvent($level, $message, array $args = null, $data = null)
    {
        $this->validateLevel($level);

        if (!is_string($message))
            throw new IrisException(sprintf(IMVC_ERRMSG_INVALID_PARAMETER, 'message'), null, IMVC_ERROR_INVALIDPARAMETER);
        if ($args != null && !is_array($args))
            throw new IrisException(sprintf(IMVC_ERRMSG_INVALID_PARAMETER, 'args'), null, IMVC_ERROR_INVALIDPARAMETER);

        if ($this->getLoggingLevel() == IMVC_LOGGER_LEVEL_OFF || $level == IMVC_LOGGER_LEVEL_OFF)
            return 0;

        if (($level == IMVC_LOGGER_LEVEL_ERROR && !$this->isErrorEnabled())
            || ($level == IMVC_LOGGER_LEVEL_WARN && !$this->isWarnEnabled())
            || ($level == IMVC_LOGGER_LEVEL_INFO && !$this->isInfoEnabled())
            || ($level == IMVC_LOGGER_LEVEL_DEBUG && !$this->isDebugEnabled()))
            return 0;

        $output = '';

        if (is_array($args))
            $output .= vsprintf($message, $args);
        else
            $output .= $message;

        if ($data !== null) {
            if (is_bool($data))
                $output .= ' Data: ' . ($data ? 'true' : 'false');
            else if (is_scalar($data))
                $output .= ' Data: ' . $data;
            else if (is_array($data)) {
                if (!empty($data))
                    $output .= ' Data: ' . var_export($data, true);
            }
            else
                $output .= ' Data: ' . var_export($data, true);
        }

        $header = '';

        switch ($level) {
            case IMVC_LOGGER_LEVEL_ERROR:
                $header = 'ERROR:';
                break;
            case IMVC_LOGGER_LEVEL_WARN:
                $header = 'WARN:';
                break;
            case IMVC_LOGGER_LEVEL_INFO:
                $header = 'INFO:';
                break;
            case IMVC_LOGGER_LEVEL_DEBUG:
                $header = 'DEBUG:';
                break;
        }

        $source = $this->getLoggingSource();
        if ($source != '') $source = "{$source} ";

        $output = $header . ' [' . date('Y-m-d H:i:s') . '] ' . $source . $output . PHP_EOL;

        return file_put_contents($this->getFileName(), $output, FILE_APPEND | LOCK_EX);
    }

    public function clear() { return (bool)file_put_contents($this->_fileName, ''); }

    public final function getFileName() { return $this->_fileName; }

    public final function setFileName($fileName)
    {
        $this->validateFileName($fileName);
        $this->_fileName = $fileName;
    }

    protected final function validateFileName(&$fileName)
    {
        if (is_string($fileName))
            $fileName = trim($fileName);

        if (!is_string($fileName) || strlen($fileName) > 260 || preg_match('/[' . preg_quote('*?"<>|', '/') . ']/', $fileName) > 0)
            throw new IrisException(sprintf(IMVC_ERRMSG_INVALID_PARAMETER, 'fileName'), null, IMVC_ERROR_INVALIDPARAMETER);
    }
}
/* End of file: FileLogger.php */