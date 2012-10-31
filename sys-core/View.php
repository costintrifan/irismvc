<?php if(! defined('IMVC_BASE_PATH')) { exit; }
/**
 * @package      IrisMVC
 * @author       Costin Trifan
 * @copyright    2010-2012 Costin Trifan <http://irismvc.net/>
 * @license      Microsoft Public License (Ms-PL)  http://irismvc.net/license.txt
 */
/**
 * @class View
 * The default View class.
 */
class View extends BaseView
{
	/**
	* @public
	* Constructor
	* @param BaseModel $model The reference to the instance of the Model class
	*/
	public function __construct( BaseModel $model )
	{
		parent::__construct($model);
	}

	/**
	* @public
	* Retrieve the content of a slot
	* @param string $componentFileName The name of the slot file to load
	* @param string $dir The name of the section directory where to look for the slot file. It can only be
	* one of the following: backend, frontend or the _components directory. Defaults to _components directory.
	* @return string
	*/
	public function getComponent( $componentFileName, $dir = '' )
	{
        if ( ! Util::endsWith('.php', $componentFileName)) {
            $componentFileName .= '.php';
        }

        if(empty($dir)){ $dir = '_components'; }
		else { $dir = strtolower($dir); }

		if ( ! in_array($dir, $this->_availableDirs)) {
            IrisLogger::error('Invalid component directory name provided.',array('dir',$dir),__FILE__,__LINE__);
			return '';
		}

		switch( $dir )
		{
			case 'backend':
				$filePath = IMVC_BACKEND_COMPONENTS_DIR_PATH . $componentFileName;
				break;
			case 'frontend':
				$filePath = IMVC_FRONTEND_COMPONENTS_DIR_PATH . $componentFileName;
				break;
			default:
				// '_components'
				$filePath = IMVC_COMPONENTS_DIR_PATH . $componentFileName;
		}

		if ( ! is_file($filePath)) {
            IrisLogger::error('Component file not found.',array('file',$filePath),__FILE__,__LINE__);
			return '';
		}

		return $this->getParsed($filePath);
	}

	/**
	* @public
	* Output the content of the view file into the browser window
	* @param string  The name of the view page to load. Optional
	* @param string The name of the directory where to search for the view file. The directory path must be relative to the views directory. Optional
	* @return void
	*/
	public function render( $viewName='', $dir='' )
	{
        if(empty($viewName) || empty($dir))
        {
            $fc = Application::getFrontController();
            if(empty($viewName)) { $viewName = $fc->getActionName(); }
            if(empty($dir)) { $dir = $fc->getControllerName(); }
        }

        $this->pageContent( $this->load($viewName, $dir) );

		if (empty($this->_masterPagePath)){
			echo $this->pageContent();
		}
		else{ echo $this->loadMasterPage(); }
	}

    /**
	* @public
	* Retrieve the content of the specified view file
	* @param string  the name of the view page to load
	* @param string The name of the directory where to search for the view file.
	* @return string
	*/
	public function get( $viewFile, $dir ) { return $this->load($viewFile, $dir); }
}
/* End of file: View.php */