<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
 * @class IrisException
 * base Exception class
 */
class IrisException extends Exception
{
    public function __construct($message, $message2 = null, $code = IMVC_ERROR_INTERNALF, Exception $previous = null)
    {
        if( IMVC_DEBUG && ($message2 != null)){ $message = $message . ' (' . $message2 .')'; }
        if($previous === null) { parent::__construct($message, $code); }
        else { parent::__construct($message, $code, $previous); }
    }
    public function __toString(){return __CLASS__ . ": [{$this->code}]: {$this->message}\n";}
}
/* End of file: IrisException.php */