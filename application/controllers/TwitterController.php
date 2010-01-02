<?php

class TwitterController extends Zend_Controller_Action {

	private $twitter;

    public function init(){
    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/accounts.ini', 'twitter');   
    	$this->twitter = new Zend_Service_Twitter($config->username, $config->password);
    }

    public function indexAction() {
		if(!$cachedresponse = Zend_Registry::get('cache')->load('userTimeline')) {
			$response = $this->twitter->status->userTimeline();
			$this->view->statuslist = $response->status;
    		Zend_Registry::get('cache')->save($response->asXML(), 'userTimeline');
		} else {
			$xml = new SimpleXMLElement($cachedresponse);
			$this->view->statuslist = $xml->status;
		}
 	}
}