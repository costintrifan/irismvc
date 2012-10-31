<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */

/**
 * Discards all log entries.
 */
final class NullLogger extends Logger
{
    public function __construct(){parent::__construct(IMVC_LOGGER_LEVEL_OFF, '');}
    public final function logEvent($level, $message, array $args = null, $data = null){return 0;}
}
/* End of file: NullLogger.php */