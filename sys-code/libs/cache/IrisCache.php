<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/**
* @package      IrisMVC
* @author       Costin Trifan
* @copyright    2010-2011 Costin Trifan <http://irismvc.net/>
* @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
* @class IrisCache
* Provides utility functions to manage cache files 
* @uses Util
* @date          May, 2010
* @revision      Feb 15, 2011
* @revision      June 07, 2011
*/
class IrisCache implements ICache
{
	/**
	 * @private
	 * @desc Holds the name of the directory used to store the cached files
	 * @type string
	 */
	private $_cacheDir = 'tmp';
	/**
	 * @private
	 * @desc The time, in minutes, the cached file will be stored in the cache directory.
	 * Defaults to 60 minutes.
	 * @type int
	 */
	private $cacheTimeout = 60;
	/**
	 * @private
	 * @desc Holds the temporary content of the loaded cached file.
	 * @type string
	 */
	private $_buffer = '';
	/**
	 * @private
	 * The prefix to be added in front of the cached file.
	 * @type string
	 */
	private $_prefix = 'cache_';

	/**
	* @public
	* @throws Exception if the cacheDir is not accessible and if the timeout is not provided as integer
	* @desc Constructor
	* @param array The list of options to configure this class
	* valid $options keys: { cacheDir , timeout }
	* @return void
	*/
	public function __construct( array $options = array() )
	{
		if ($options && is_array($options))
		{
			if (array_key_exists('cacheDir',$options) && !empty($options['cacheDir'])) {
                $this->cacheDir($options['cacheDir']);
            }
			if (array_key_exists('timeout',$options) && !empty($options['timeout']) && is_int($options['timeout'])) {
                $this->cacheTimeout($options['timeout']);
            }
		}
		else { $this->cacheDir($this->_cacheDir)->cacheTimeout($this->_cacheTimeout); }
	}

/*
*	GETTERS && SETTERS
*============================================
*/
	/**
	* @public
	* @throws Exception if the diretory is not accessible
	* @desc Set/get the path to the cache directory
	* @return string|$this
	*/
	public function cacheDir( $dir = null )
	{
		if ( is_null($dir) ) { return $this->_cacheDir; }
		if (is_dir($dir))
		{
			if ( ! is_readable($dir) ) { throw new Exception("The cache directory: {$dir} is not readable! Check for permissions"); }
			if ( ! is_writable($dir) ) { throw new Exception("The cache directory: {$dir} is not writable! Check for permissions"); }
		}
		else { throw new Exception("The provided directory {$dir} does not exists!"); }

		$this->_cacheDir = $dir;

		return $this;
	}

	/**
	* @public
	* @throws Exception if the timeout is not an integer
	* @desc Set/get the cached file time to live
	* @return int | IrisCache object
	*/
	public function cacheTimeout( $timeout = null )
	{
		if (is_null($timeout)) { return $this->_cacheTimeout; }
		else
		{
			if ( ! is_int($timeout)) { throw new Exception('The provided timeout is invalid! Expected value type: integer'); }
			$this->_cacheTimeout = $timeout*60; /*[[ transform in seconds ]]]*/
		}

		return $this;
	}

	/**
	* @public
	* @desc Retrieve the cached file's content.
	* If the cache is not found it will be created.
	* @param string  The path to the file to be cached/retrieved from cache
	* @return string
	*/
	public function get( $file )
	{
		if ( ! file_exists($file)) { return 'File '.$file.' not found'; }

		/*[[ getFile the file name from path ]]*/
		$fname = basename($file);

		/*[[ set cache name ]]*/
		$fname = $this->setCacheName($fname);

		/*[[ cache exists? -> getFile file ]]*/
		if ($this->checkCache($fname)) { return $this->getFile($fname); }

		/*[[ get the content of the file to be cached ]]*/
		$this->_buffer = file_get_contents($file);

		/*[[ create && return cache file ]]*/
		return $this
			->save($fname, $this->_buffer)
			->clearBuffer()
			->getFile($fname);
	}

    /**
    * @public
    * @desc Cache a block of content
    * @param string The id of the content to be cached
    * @param string The text content to be cached
    * @param bool   Whether or not to serialize the content.
    * @return IrisCache object
    */
    public function cacheBlock( $id, $content, $serialize = false )
    {
		$fname = $this->setCacheName($id);

		//[[ cache and return
		if ($serialize) { $this->save($fname, serialize($content)); }
		else { $this->save($fname, $content); }

		return $this;
    }

    /**
    * @public
    * @desc Retrieve the content of the cached block
    * @param string The id of the file to getFile from cache
    * @param bool   Whether or not to deserialize the content
    * @return string
    */
    public function getCachedBlock( $id, $deserialize = false )
    {
        /*[[ cache exists? -> get file ]]*/
		if ($this->cachedBlockExists($id))
		{
			/*[[ set cache name ]]*/
			$id = $this->setCacheName($id);

			if ($deserialize) { return unserialize($this->getFile($id)); }
			else { return $this->getFile($id); }
		}

        /*[[ cache not found ]]*/
        return '';
    }

    /**
     * @public
     * @desc Check whether a block of text is cached or not
     * @param int The text block's id
     * @return boolean
     */
	public function cachedBlockExists( $id )
	{
        /*[[ set cache name ]]*/
        $id = $this->setCacheName($id);

		return $this->checkCache($id);
	}



/*
*	PROTECTED METHODS
*============================================
*/
	/**
	* @protected
	* @desc Check to see whether or not the provided file is cached
	* @return boolean
	*/
	protected function checkCache( $file )
	{
		clearstatcache(); /*[[ CLEAR CACHE ]]*/

		if (file_exists($this->_cacheDir.$file))
		{
			if ((time() - filemtime($this->_cacheDir.$file)) <= $this->_cacheTimeout )
			{
				// valid cache.
				return true;
			}
			else { $this->delete($file);  return false; }
		}

		// cache not found
		return false;
	}

	/**
	* @protected
	* @desc Cache the contents of the file.
	* @return IrisCache object
	*/
	protected function save( $file, $data )
	{
		file_put_contents($this->_cacheDir.$file, $data);

		return $this;
	}

	/**
	* @protected
	* @desc Retrieve the contents of the cached file
	* @return string
	*/
	protected function getFile( $file )
	{
		return file_get_contents($this->_cacheDir.$file);
	}

	/**
	* @protected
	* @desc Set the name of the file to be cached
	* @return string
	*/
	protected function setCacheName( $filePath )
	{
		return ($this->_prefix . hash('md5', $filePath));
	}

	/**
	* @protected
	* @desc Clear the internal buffer
	* @return IrisCache object
	*/
	protected function clearBuffer()
	{
		$this->_buffer = '';

		return $this;
	}

	/**
	* @protected
	* @desc Delete the specified file
	* @return IrisCache object
	*/
	protected function delete( $file )
	{
		if (file_exists($this->_cacheDir.$file))
		{
			@unlink($this->_cacheDir.$file);
		}

		return $this;
	}
}
/* End of file: IrisCache.php */