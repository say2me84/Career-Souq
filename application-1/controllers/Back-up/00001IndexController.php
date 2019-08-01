<?php
__autoloadDB('Db');
class IndexController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		global $mySessionFront;
		/*if(!isLoggedFront())
		{ 	
		$this->_redirect('index');	
		}
		
		if($mySessionFront->user['userRole']=='A' || $mySessionFront->user['userRole']=='C')
		{ 	
			$this->_redirect('index');	
		}*/	
    }
	
	public function indexAction()
	{
		
		global $mySessionFront;
		if(isset($mySessionFront->user['FrontUserId'])){
			$this->_redirect('index/welcome');		
			exit;
		}
		
	}
	
	public function loginAction(){
		
		global $mySessionFront;
		if(isset($mySessionFront->user['FrontUserId'])){
			$this->_redirect('index/welcome');		
			exit;
		}
		
		$db=new Db();
		
		//$formc = new Form_Contactus();	
		//$this->view->Form=$form;
		$form = new Form_Login();
		$this->view->loginform = $form;
		
		 if ($this->_request->isPost()) {
			 
            $formData = $this->_request->getPost();
			if(isset($formData['ptype'])) {
				if($formData['ptype']=='contact') { 
					if ($formc->isValid($dataForm))
					{
				
				}
				} else {
					if ($form->isValid($formData)) {
				$user 		= 	new Model_FrontUser();
				$result 	= 	$user->authenticateLogin($formData);	
				if(is_array($result)){	
					if($result['user_is_blocked']==1){	
						
						$mySessionFront->user['FrontUserId'] = $result['user_id'];
						$mySessionFront->user['id'] = $result['id'];
						
						$mySessionFront->user['userRole'] = $result['user_type'];
						$mySessionFront->user['UserName']=$result['user_fname'].' '.$result['user_lname'];
						$mySessionFront->user['user_fname']=$result['user_fname'];
						$mySessionFront->user['user_country']=$result['user_country'];
						
						$mySessionFront->user['user_education']=$result['user_education'];
						
						$this->_redirect('index/login');					
						
					}
					else if($result['user_is_blocked']==0){
						$mySessionFront->errorMsg ="your account is disable."; 
						
						$this->_redirect('index/login');	
					}
				}else{
						unset($mySessionFront->user);		
						$mySessionFront->errorMsg ="Invalid username or password."; 
						$this->_redirect('index/login');	
					}
			}
				}
			}
		}
	
				
	}
	
	public function logoutAction(){ 
		global $mySessionFront;
		//unset($mySessionFront->user);
		unset($mySessionFront->user['FrontUserId']);	
		$mySessionFront->sucMsg ="You are logged out successfully."; 	
		$this->_redirect('index/login');	
	}
	
	public function welcomeAction(){
       global $mySessionFront;
		if(!isLoggedFront()) { 
		
			$this->_redirect('index/login');
			
		}
		$this->_redirect('dashboard');
		
	}
	
	
	public function registerAction()
	{	
		$db = new Db();
		global $mySessionFront;
		$this->view->PageTitle="Add New User";
		$form = new Form_Register();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 	//echo "AAkash123"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			$Data='';
			$Data['user_type'] = $formData['user_type'];
			$Data['user_fname'] = $formData['user_fname'];
			$Data['user_fname'] = $formData['user_fname']; 
			$Data['user_lname'] = $formData['user_lname'];
			$Data['user_email'] = $formData['Country_id'];
			$Data['user_city'] = $formData['user_city'];
			
			$dtr=explode('-',$formData['user_dob']);
			$Data['user_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];			
			
			$Data['user_gender'] = $formData['user_gender'];
			$Data['user_language_preference'] = $formData['user_language_preference'];
			$Data['user_password'] = md5($formData['user_password']);
			
			if($formData['confirm_user_password']!=$formData['user_password'])
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					//$this->view->Form = $Form;
					//$this->render('register');
					$this->view->myform = $form;
					$this->_redirect('index/register');
				}
				else
				{
					$Data['confirm_user_password'] = md5($formData['confirm_user_password']);	
				}
				prd($Data);	
			$db->save('tbl_users',$Data); 
			$mySessionFront->sucMsg = "New Educations Added Successfully";
			$this->_redirect('index/register');
			
		} 
		
	}
		
	}
	
	
	//Add New Records...
	public function addAction()
	{	
		$db = new Db();
		global $mySessionFront;
		$this->view->PageTitle="Add New User";
		$form = new Form_Register();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
		echo "Akash"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			$Data='';
			$Data['user_type'] = $formData['user_type'];
			$Data['user_fname'] = $formData['user_fname'];
			$Data['user_fname'] = $formData['user_fname']; 
			$Data['user_lname'] = $formData['user_lname'];
			$Data['user_email'] = $formData['Country_id'];
			$Data['user_city'] = $formData['user_city'];
			
			$dtr=explode('-',$formData['user_dob']);
			$Data['user_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];			
			
			$Data['user_gender'] = $formData['user_gender'];
			$Data['user_language_preference'] = $formData['user_language_preference'];
			$Data['user_password'] = md5($formData['user_password']);
			
			if($formData['confirm_user_password']!=$formData['user_password'])
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					//$this->view->Form = $Form;
					//$this->render('register');
					$this->view->myform = $form;
					$this->_redirect('index/register');
				}
				else
				{
					$Data['confirm_user_password'] = md5($formData['confirm_user_password']);	
				}
				prd($Data);	
			
			$db->save('tbl_users',$Data); 
			$mySession->sucMsg = "New Added Successfully";
			$this->_redirect('dashboard');
			
		} 
		
	}
		
	} 
	
	

}
?>
