<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */

/**
* @class BaseModel
* Base Model class. All model classes should extend this class
*/
abstract class BaseModel
{
	/**
	* @protected
	* Holds the stored data.
	* @type array
	*/
	protected $_data = array();

	/** Constructor */
	public function __construct(){}

	/**
	* @abstract 
	* @public
	* Add a new entry in the internal list
    * @param string $name
    * @param mixed $value
	* @return BaseModel object
	*/
	abstract public function set( $name, $value );

	/**
	* @abstract 
	* @public
	* Retrieve an entry from the internal array
    * @param string $name
	* @return mixed
	*/
	abstract public function get( $name );

	/**
	* @abstract 
	* @public
	* Retrieve all entries from the internal array
	* @return array
	*/
	abstract public function getAll();

	/**
	* @abstract 
	* @public
	* Remove an entry from the internal array
     * @param string $name
	* @return $this
	*/
	abstract public function remove( $name );

	/**
	* @abstract 
	* @public
	* Clear all entries from the internal array
	* @return BaseModel object
	*/
	abstract public function clear();
}
/* End of file: BaseModel.php */