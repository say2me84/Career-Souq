<?php
class ProfileController extends Zend_Controller_Action
{
	
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
			$this->_redirect('index');	
		}
		
	}
	public function indexAction()
	{
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Profile Customer';
	
		if($mySession->user['userRole']=='C') 
		{
			$customerId=$mySession->user['userId'];
		} else {
			$customerId= $this->getRequest()->getParam('customerId');
		}
		
		$formData=$db->runQuery("select ru.*, ruc.*, rus.*, concat(ag.fname,' ',ag.lname) as agentname, rcity.city as cityname, rstate.statename 
				from rbi_user as ru
				join rbi_user_customer as ruc on(ru.userid=ruc.userId)
				join rbi_user_to_scheme as rus on(ru.userid=rus.userid)
				join rbi_user as ag on(ag.userid=ruc.agentId)
				join rbi_city as rcity on(rcity.cityid=ru.city)
				join rbi_state as rstate on(rcity.stateid=ru.state)
				where ru.usrRole='C' and ru.userid='".$customerId."'");

		if(is_array($formData) && count($formData) > 0)
		{
			$this->view->prodata=$formData[0];
		}
		
	}
	
	
}
?>
