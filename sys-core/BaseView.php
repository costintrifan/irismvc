<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */

/**
* @class BaseView
* Base View class. All view classes should extend this class
*/
abstract class BaseView
{
    /**
     * @public
     * Holds the reference to the instance of the Model class
     * @type BaseModel object
     */
	public $model = null;

    /**
     * @private
     * Holds the page title to use for the loaded page
	 * @see BaseView::pageTitle()
     * @type string
     */
	private $_pageTitle = '';
    /**
     * @private
     * Holds the page content that will be displayed in the master page
	 * @see BaseView::pageContent()
     * @type string
     */
	private $_pageContent = '';

    /**
     * @protected
     * Holds the path to the master page to use
	 * @see BaseView::masterPagePath()
     * @type string
     */
	protected $_masterPagePath = '';
    /**
     * @protected
     * Holds the list of all available views and slots directories
     * @type array
     */
	protected $_availableDirs = array('_shared','backend','frontend','_components','_error-pages');


	/**
	* @abstract 
	* @public
	* Retrieve the content of a slot
	* @param string The name of the slot file to load
	* @param string The name of the section directory where to look for the slot file. It can only be
	* one of the following: shared,backend or frontend. Defaults to shared.
	* @return string
	*/
	abstract public function getComponent( $componentFileName, $dir = '_components' );
	/**
	* @abstract 
	* @public
	* Retrieve the content of the specified view file
	* @param string  the name of the view page to load
	* @param string The name of the directory where to search for the view file.
	* @return string
	*/
	abstract public function get( $viewFile, $dir );
    /**
     * @abstract
     * @public
     * Output the content of the view file into the browser window
     * @param string  The name of the view page to load. Optional
     * @param string The name of the directory where to search for the view file. Optional
     * @return void
     */
    abstract public function render( $viewName='', $dir='' );



	/**
	* @public
	* Constructor
	* @param BaseModel $model The reference to the instance of the Model class
	*/
	public function __construct( BaseModel $model )
	{
		//@ Pass model to views
		$this->model = $model;
	}

	/**
	* @public
	* Set or retrieve the page title
	* @param string The page title to set
	* @return BaseView object on SET ; string on GET
	*/
	public function pageTitle( $pageTitle = '' )
	{
		if (empty($pageTitle)) { return $this->_pageTitle; }
		$this->_pageTitle = $pageTitle;
		return $this;
	}

	/**
	* @public
	* Set or retrieve the page content that will be displayed in the master page
	* @param string The page content
	* @return BaseView object on SET ; string on GET
	*/
	public function pageContent( $pageContent = '' )
	{
		if (empty($pageContent)) { return $this->_pageContent; }
		$this->_pageContent = $pageContent;
		return $this;
	}

	/**
	* @public
	* Set the path to the master page to use
	* @param string The path to the master page
	* @return BaseView object
	*/
	public function useMasterPage( $masterPagePath )
	{
		$this->_masterPagePath = IMVC_MASTER_PAGES_DIR_PATH.$masterPagePath;
		return $this;
	}

    public function includeCss($fileName, $media="all", $id=''){
        if(! Util::endsWith('.css', $fileName)){
            $fileName .= '.css';
        }
        $filePath = IMVC_CURRENT_THEME_PATH .'css/'. $fileName;
        return '<link id="'.$id.'" href="'.$filePath.'" rel="stylesheet" type="text/css" media="'.$media.'" />';
    }
    public function includeScript($fileName, $id=''){
        if(! Util::endsWith('.js', $fileName)){
            $fileName .= '.js';
        }
        $filePath = IMVC_CURRENT_THEME_PATH .'js/'. $fileName;
        return '<script id="'.$id.'" src="'.$filePath.'" type="text/javascript"></script>';
    }

	/**
	 * @protected
	 * @uses self::$__masterPagePath
	 * @desc Retrieve the parsed content of the master page
	 * @return string
	 */
	protected function loadMasterPage()
	{
		if (empty($this->_masterPagePath)) {
			return '';
		}
        if ( ! Util::endsWith('.php',$this->_masterPagePath)) {
            $this->_masterPagePath .= '.php';
        }
		if ( ! is_file($this->_masterPagePath)) {
            IrisLogger::error('File not found.',array('file',$this->_masterPagePath),__FILE__,__LINE__);
			return '';
		}
		return $this->getParsed($this->_masterPagePath);
	}

	/**
	* @protected
	*  Retrieve the content of the specified view page
	* @param string  the name of the view page to load
	* @param string the subdirectory where to search for the view file
	* @return string
	*/
	protected function load( $fileName, $subdir = '' )
	{
        if ( ! Util::endsWith('.php',$fileName)) {
            $fileName .= '.php';
        }
        if ( ! empty($subdir) && ! Util::endsWith('/',$subdir)) {
			$subdir .= '/';
		}

		$dir = IMVC_VIEWS_DIR_PATH;
        if ( ! Util::endsWith('/',$dir)) {
			$dir .= '/';
		}

        $file = $dir . $subdir . $fileName;
        $str = '';
		if ( ! is_file($file)) {
            IrisLogger::error('File not found.',array('file',$file),__FILE__,__LINE__);
            return $str;
        }

		return $this->getParsed($file);
	}

	/**
	* @protected
	* Retrieve the parsed content of the specified file
	* @param string The path to the file to load. This must be a valid file path
	* @return string
	*/
	protected function getParsed( $filePath )
	{
		clearstatcache();
		$str = '';
		ob_start();
			extract($this->model->getAll(), EXTR_SKIP);
			include $filePath;
			$str = ob_get_contents();
		ob_end_clean();
		return trim($str);
	}
}
/* End of file: BaseView.php */