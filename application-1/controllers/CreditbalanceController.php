<?php
class CreditbalanceController extends Zend_Controller_Action
{
	
    public function init() {
        /* Initialize action controller here */
		
		
    }
	public function indexAction(){
      
       global $mySessionFront;
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		
    }
	
	
	
	
}
?>
