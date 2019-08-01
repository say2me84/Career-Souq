<?php
class NewseventsController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }

    public function indexAction(){
        global $mySession;
		$this->view->pagetitle = 'News & Events';
		$album= $this->getRequest()->getParam('album');
		$this->view->album =$album;
    }
	
	

}
?>
