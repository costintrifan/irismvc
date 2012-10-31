<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */

/**
* @class Model
* The default Model class.
*/
class Model extends BaseModel
{
	/** Constructor */
	public function __construct(){ parent::__construct(); }

	/**
	* @public
    * @param string $name
    * @param mixed $value
	* Add a new entry in the internal list
	* @return BaseModel object
	*/
	public function set( $name, $value ){
		$this->_data[$name] = $value;
		return $this;
	}

	/**
	 * @public
     * @param string $name
	 * Retrieve an entry from the internal array
	 * @return mixed
	 */
	public function get( $name ) { return (isset($this->_data[$name]) ? $this->_data[$name] : null); }

	/**
	* @abstract 
	* @public
	* Retrieve all entries from the internal array
	* @return array
	*/
	public function getAll(){ return $this->_data; }

	/**
	 * @public
     * @param string $name
	 * Remove an entry from the internal array
	 * @return BaseModel object
	 */
	public function remove( $name ){
		if (isset($this->_data[$name])){
			unset($this->_data[$name]);
			$this->_data = array_values($this->_data);
		}
		return $this;
	}

	/**
	* @public
	* Clear all entries from the internal array
	* @return BaseModel object
	*/
	public function clear(){
		$this->_data = array();
		return $this;
	}
}
/* End of file: Model.php */