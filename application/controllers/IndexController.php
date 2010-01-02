<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction() {
		$conn1 = Doctrine_Manager::getInstance()->getConnection('one');
		        $this->view->name = "Frank Sinatra";
		
		        $this->view->fruits = array(
		            "apples",
		            "bananas",
		            "papayas",
		            "peaches"
		        );
    }


}

