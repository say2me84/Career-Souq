<?php 
class AppController extends Zend_Controller_Action 
{	
	public function init()
    {
		global $mySession;
		$db=new Db();
		$myControllerName=Zend_Controller_Front::getInstance()->getRequest()->getControllerName();		
		$myActionName=Zend_Controller_Front::getInstance()->getRequest()->getActionName();		
	}	
}
?>