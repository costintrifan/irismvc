<?php if(! defined('IMVC_BASE_PATH')) { exit; }

/**
* @interface ICache
* @desc Defines the methods that derived classes should implement
*
* @package      IrisMVC
* @author       Costin Trifan
* @copyright    2010-2011 Costin Trifan <http://irismvc.net/>
* @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
*
* @revision      Feb 15, 2011
* @revision      June 07, 2011
*/
interface ICache
{
	/**
	* @public
	* @throws Exception if the cacheDir is not accessible and if the timeout is not provided as integer
	* @desc Constructor
	* @param array The list of options to configure this class
	* valid $options keys: { cacheDir , timeout }
	*/
	function __construct( array $options = array() );
	/**
	* @public
	* @throws Exception if the diretory is not accessible
	* @desc Set/Get the path to the cache directory
	* @return string|$this
	*/
	function cacheDir( $dir = null );
	/**
	* @public
	* @throws Exception if the timeout is not an integer
	* @desc Set/Get the cached file time to live
	* @return int|$this
	*/
	function cacheTimeout( $timeout = null );
	/**
    * @public
	* @desc Set or retrieve the cached file's content
	* @desc If the cache is not found it will be created
	* @param string  The path to the file to be cached/retrieved from cache
	* @return string
	*/
	function get( $file );
    /**
     * @public
   * @desc Cache a block of content
    * @param string The id of the content to be cached
    * @param string The text content to be cached
    * @param bool   Whether or not to serialize the content.
    * @return $this
    */
    function cacheBlock( $id, $content, $serialize = false );
    /**
    * @public
    * @desc Retrieve the content of the cached block
    * @param string The id of the file to get from cache
    * @param bool   Whether or not to deserialize the content
    * @return string
    */
    function getCachedBlock( $id, $deserialize = false );
}
/* End of file: ICache.php */