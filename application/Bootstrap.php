<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

	public function _initTimeZone(){
		date_default_timezone_set('Europe/Brussels');
	}
	
	public function _initCache(){
	
		$frontendOptions = array(
		   'lifetime' => 600,
		   'automatic_serialization' => true
		);
		
		$backendOptions = array(
		    'cache_dir' => APPLICATION_PATH . '/../cache/'	    
		);
		
		// getting a Zend_Cache_Core object
		$cache = Zend_Cache::factory('Core',
		                             'File',
		                             $frontendOptions,
		                             $backendOptions);
		                             
		Zend_Registry::set('cache', $cache);
	}

	/**
     * Autoload stuff from the default module (which is not in a `modules` subfolder in this project)
     * (Api_, Form_, Model_, Model_DbTable, Plugin_)
     * */
    protected function _initAutoload()
    {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH));
            
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Rodeveer_');

        return $moduleLoader;
    }

    public function _initDoctrine() {
        $doctrineConfig = $this->getOption('doctrine');

        $manager = Doctrine_Manager::getInstance();
        
        // Creating 2 named connections, to test ZFDebug doctrine plugin
        //$manager->openConnection($doctrineConfig['connection_string'], 'one');
        //$manager->openConnection($doctrineConfig['connection_string'], 'two');
                
        return $manager;
    }
    
    /**
     * Initialize the ZFDebug Bar
     */
    protected function _initZFDebug() {
        $zfdebugConfig = $this->getOption('zfdebug');

        if ($zfdebugConfig['enabled'] != 1) {
            return;
        }

        // Ensure Doctrine connection instance is present, and fetch it
        $this->bootstrap('Doctrine');
        $this->bootstrap('Cache');
        $doctrine = $this->getResource('Doctrine');

		// not in the .ini because we don't always need it
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZFDebug_');

        $options = array(
            'plugins' => array('Variables',
                               'Danceric_Controller_Plugin_Debug_Plugin_Doctrine',
                               'File' => array('base_path' => APPLICATION_PATH),
                               'Memory',
                               'Time',
                               'Cache' => array('backend' => Zend_Registry::get('cache')->getBackend()),
                               'Exception',
                               'Html', 
                               'Registry'
                               ),
            );
        $debug = new ZFDebug_Controller_Plugin_Debug($options);

        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $frontController->registerPlugin($debug);
    }
    
    public function _initSmarty(){
	    require_once( 'Smarty/Smarty.class.php');	    
	    $smarty_config = $this->getOption('smarty');	    
		$view = new Rodeveer_View_Smarty(APPLICATION_PATH . '/views/templates/', $smarty_config);
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view)
		             ->setViewBasePathSpec($view->getEngine()->template_dir)
		             ->setViewScriptPathSpec(':controller/:action.:suffix')
		             ->setViewScriptPathNoControllerSpec(':action.:suffix')
		             ->setViewSuffix('phtml');    
    }

}