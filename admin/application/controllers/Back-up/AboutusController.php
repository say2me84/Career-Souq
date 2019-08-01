<?php
class AboutusController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }

    public function indexAction(){
        global $mySession;
		$this->view->pagetitle = 'About Us';
    }
	
	

}
?>
