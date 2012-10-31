<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
* static class Util
*
* A class containing utility functions.
*/
class Util
{
    /**
    * @public
    * Constructor
	* @throws Error
    */
    protected function __construct(){}

    /**
    * @public
    * @static
    * Set the default inclusion path for framework's files.
    * @param The path to the directory you want to add into the inclusion list. Without the path separator
    * @return void
    */
    public static function addIncludePath( $path )
    {
        $inc_path = get_include_path();
        if (self::endsWith($inc_path,PATH_SEPARATOR)) {
            set_include_path($inc_path.$path.PATH_SEPARATOR);
        }
        else { set_include_path($inc_path.PATH_SEPARATOR.$path); }
    }


# STRING MANAGEMENT
#============================

    /**
	* @public
	* @static
    * Cut selected text at a specified length
    * @param string $string  The string to cut at the specified length.
    * @param number $cut_at  The max limit of characters allowed.
    * @param string $complete_char  The character(s) to append at the end of the string. Defaults to empty string.
    * @return string  The new string
    */
    public static function cut( $string, $cut_at, $complete_char = '' )
    {
        if (isset($string[$cut_at+1]))
        {
            $string = substr($string, 0, $cut_at);
            if ( ! empty($complete_char) )
                $string .= $complete_char;
        }
        return $string;
    }

    /**
	* @public
	* @static
    * Check to see whether or not one or all given variables provided as function parameters is/are empty.
	* This function uses the func_get_args method.
	* @param string The list of variables to check
    * @return boolean
    */
    public static function oneEmpty( /*[ $var1, $var2 ]*/ )
    {
		$args = func_get_args();
		$num = count($args);
		if ($num == 0) { return false; }
        if ($num == 1) { return (empty($args[0]) ? true : false); }

		foreach( $args as $arg)
		{
			if (empty($arg)) { return true; }
		}

		return false;
    }

    /**
	* @public
	* @static
    * Check to see whether or not a given string is equal to another.
    * @param string   The first string to compare
    * @param string   The string to compare with the first string
    * @param bool     Whether or not the comparison is case sensitive. Defaults to false.
    * @return boolean
    */
    public static function stringsEqual( $string1, $string2, $caseSensitive = false )
    {
        $string1 = trim($string1);
        $string2 = trim($string2);

        if ($caseSensitive) {
            return (($string1 == $string2) ? true : false);
		}
        else { return ((strcasecmp($string1, $string2) == 0) ? true : false); }
    }


	/**
	 * @public
	 * @static
	 * Remove new lines && multiple consecutive whitespaces from content
	 * @param string The string to compress
	 * @return string
	 */
	public static function compress( $content )
	{
		$content = trim(preg_replace("#\n|\r|\r\n|\n\r#", '', preg_replace('/\s+/', ' ', $content)));
		return $content;
	}

    /**
	* @public
	* @static
    * Create a random string of 40 chars length
    * @return string
    */
    public static function guid()
    {
		$data = sha1(uniqid(rand(), true));
		return $data;
    }

    /**
	* @public
	* @static
    * Check to see if a string($string) starts with the provided string($search)
	* @param string The search string
	* @param string  The string to check
	* @param bool  Whether or not to trim the strings before performing the check. Defaults to true.
    * @return boolean
    */
	public static function startsWith( $search, $string, $trim = true )
	{
		if (self::oneEmpty($search,$string))
		{
			return false;
		}
		if ($trim) {
			$search = trim($search);
			$string = trim($string);
		}
		$bfr = substr($string, 0, strlen($search));
		return self::stringsEqual($search,$bfr);
	}

    /**
	* @public
	* @static
    * Check to see if a string($string) ends with the provided string($endStr)
	* @param string The search string
	* @param string  The string to check
	* @param bool  Whether or not to trim the strings before performing the check
    * @return boolean
    */
	public static function endsWith( $search, $string, $trim = true )
	{
		if (self::oneEmpty($search,$string))
		{
			return false;
		}
		if ($trim) {
			$search = trim($search);
			$string = trim($string);
		}
		$bfr = substr($string, -(strlen($search)), strlen($search));
		return self::stringsEqual($search,$bfr);
	}

    /**
	* @public
	* @static
	* @since beta2
    * Check to see if a string($string) contains the provided string($endStr)
	* @param string The search string
	* @param string  The string to check
	* @param bool  Whether or not to trim the strings before performing the check
    * @return boolean
    */
	public static function stringContains( $search, $string, $trim = true )
	{
		if (self::oneEmpty($search,$string))
		{
			return false;
		}
		if ($trim) {
			$search = trim($search);
			$string = trim($string);
		}
		return preg_match("/$search/msi",$string);
	}

    /**
	* @public
	* @static
    * Check to see if a value is in the specified range of values
	* @param integer the value to check
	* @param integer the minimum value allowed
    * @param integer the maximum value allowed
    * @return boolean
    */
    public static function inRange( $value, $lowerBound, $upperBound )
    {
        return ( (($value >= $lowerBound) && ($value <= $upperBound)) ? true : false );
    }

	/**
	* @public
	* @static
	* Format the file size of a given file
	* @see original version here http://www.php.net/manual/en/function.filesize.php#100097
	* @param string The path to the file
	* @return string The formatted file size
	*/
	public static function fileSize( $file )
	{
		if ( ! is_file($file)) { return ''; }

		$size = filesize($file);
		$units = array('B','KB','MB','GB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
		return round($size, 2).' '.$units[$i];
	}

	/**
	* @public
	* @static
	* Retrieve the specified file's extension
	* @return string
	*/
	public static function getFileExtension( $filename )
	{
		$pos = strrpos($filename,'.');
		if ($pos > 0)
		{
			$pos += 1; // include the dot too
			$ext = substr($filename,$pos, strlen($filename)-$pos);
			return $ext;
		}
		else { return ''; }
	}

	/**
	* @public
	* @static
	* Retrieve the list of files and directories within a given directory.
	* @see http://snippets.dzone.com/posts/show/155
	* @author Peter Odding http://snippets.dzone.com/user/XoloX
	* @return array
	*/
	public static function dirToArray( $directory, $include_dirs = true, $recursive = true )
	{
		$data = array();
		if ($h = opendir($directory))
		{
			while (false !== ($file = readdir($h))) {
				if ($file != '.' && $file != '..') {
					if (is_dir($directory. '/' . $file)) {
						if($recursive) {
							$data = array_merge($data, self::dirToArray($directory.'/'.$file, $include_dirs, $recursive));
						}
						if ($include_dirs) {
							$file = $directory . '/' . $file;
							$data[] = preg_replace("/\/\//si", '/', $file);
						}
					}
					else {
						$file = $directory . "/" . $file;
						$data[] = preg_replace("/\/\//si", '/', $file);
					}
				}
			}
			closedir($h);
		}
		return $data;
	}

	/**
	* @public
	* @static
	* Make writable the provided file or list of directories and files.
	* @return void
	*/
	public static function makeWritable( $list )
	{
		self::setAccessMode($list, 0777);
	}
	/**
	* @public
	* @static
	* Make readonly the provided file or list of directories and files.
	* @return void
	*/
	public static function makeReadonly( $list )
	{
		self::setAccessMode($list,'0644');
	}

	/**
	* @private
	* @internal
	* @static
	* Make writable or readonly the provided file or list of directories and files.
	* @param string | array The file or the list of files or directories to make writeble or readonly.
	* @return void
	*/
	private static function setAccessMode( $list, $permission )
	{
		if ( ! empty($list))
		{
			if (is_array($list))
			{
				foreach($list as $entry) {
					chmod($entry,$permission);
				}
			}
			else { chmod($list,$permission); }
		}
	}

    public static function gzipOutput() {
        (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ? ob_start("ob_gzhandler") : ob_start();
    }

    // @ retrieve the shortened url for the provided link using tinyurl.com
    public static function tinyUrl($url) { return self::shortenUrls($url); }

    // @ retrieve the shortened urls for the provided links using tinyurl.com
    public static function shortenUrls($data) {
        $data = preg_replace_callback('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', array('Util', '_fetchTinyUrl'), $data);
        return $data;
    }
    private static function _fetchTinyUrl($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url[0]);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return '<a href="'.$data.'" target="_blank" rel="nofollow">'.$data.'</a>';
    }

    public static function getIp()
    {
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ip = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = '0.0.0.0';
        return $ip;
    }
}
/* End of file: Util.php */