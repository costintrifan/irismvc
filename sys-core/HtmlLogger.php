<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
 * @class HtmlLogger
 */
class HtmlLogger extends Logger
{
    private $_colors = null;

    /**
     *
     * @param int $level
     * @param string $source
     * @param array $colors And associative array where key is the logging level and value is the CSS value for color.
     */
    public function __construct($level = IMVC_LOGGER_LEVEL_OFF, $source = '', array $colors = null)
    {
        parent::__construct($level, $source);

        $this->_colors = array(
            IMVC_LOGGER_LEVEL_ERROR => '#ff0000',
            IMVC_LOGGER_LEVEL_WARN  => '#f3a10f',
            IMVC_LOGGER_LEVEL_INFO  => '#0000ff',
            IMVC_LOGGER_LEVEL_DEBUG => '#000000'
        );

        if (array_key_exists(IMVC_LOGGER_LEVEL_ERROR, $colors) && !empty($colors[IMVC_LOGGER_LEVEL_ERROR]))
            $this->_colors[IMVC_LOGGER_LEVEL_ERROR] = htmlentities($colors[IMVC_LOGGER_LEVEL_ERROR]);
        if (array_key_exists(IMVC_LOGGER_LEVEL_WARN, $colors) && !empty($colors[IMVC_LOGGER_LEVEL_WARN]))
            $this->_colors[IMVC_LOGGER_LEVEL_WARN] = htmlentities($colors[IMVC_LOGGER_LEVEL_WARN]);
        if (array_key_exists(IMVC_LOGGER_LEVEL_INFO, $colors) && !empty($colors[IMVC_LOGGER_LEVEL_INFO]))
            $this->_colors[IMVC_LOGGER_LEVEL_INFO] = htmlentities($colors[IMVC_LOGGER_LEVEL_INFO]);
        if (array_key_exists(IMVC_LOGGER_LEVEL_DEBUG, $colors) && !empty($colors[IMVC_LOGGER_LEVEL_DEBUG]))
            $this->_colors[IMVC_LOGGER_LEVEL_DEBUG] = htmlentities($colors[IMVC_LOGGER_LEVEL_DEBUG]);
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

        $source = $this->getLoggingSource();
        if ($source != '') $source = "{$source} ";

        $output = '<font color="' .  $this->_colors[$level] . '">' . date('Y-m-d H:i:s') . ' '
            . htmlspecialchars($source . $output, ENT_QUOTES) . '</font><br />';

        return print($output);
    }
}
/* End of file: HtmlLogger.php */