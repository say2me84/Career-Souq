<?php
__autoloadDB('Db');
class RegisterController extends Zend_Controller_Action
{
	public function init() 
	{	
		global $mySessionFront;
		/*if(!isLogged())
		{ 	
		$this->_redirect('index');	
		
		}*/
		
	}
	public function editindexAction()
	{	
		$db = new Db();
		global $mySessionFront;
		$db = new Db();
		$this->view->PageTitle="New A/c Creating:";
		$form = new Form_Register();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	/*
		<?php echo $_POST['user_type']?>
	*/ 
			
	}	
//---------------------------------------------------------------ADD New Records...
	public function indexAction()
	{	
		$db = new Db();
		global $mySessionFront;
		$this->view->PageTitle="Adding New User:";
		$form = new Form_Register();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
		$arr=$this->getRequest()->getParams($_POST['user_type']);
			//prd($arr);
		//$this->view->cust_id = $arr['cust_id'];
		
	if ($objRequest->isPost()) {
	 	$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			$Data='';
			
			$Data['user_type'] = $formData['user_type'];
			$Data['user_fname'] = $formData['user_fname'];
			$Data['user_lname'] = $formData['user_lname'];
			$Data['user_email'] = $formData['user_email'];
			$Data['user_country'] = $formData['Country_id'];
			$Data['user_city'] = $formData['user_city'];
			$Data['user_nationality'] = $formData['Nationality_id'];
			
			$Data['user_gender'] = $formData['user_gender'];
			$Data['user_language_preference'] = $formData['user_language_preference'];
			
			
			$Data['user_dob'] = $formData['user_dob'];
			//$dtr=explode('-',$formData['user_dob']);
			//$Data['user_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];	
			
			//confirm_user_password
			$Data['user_password'] = md5($formData['user_password']);
			
			if(md5($formData['confirm_user_password'])!= md5($formData['user_password'])){
				$mySessionFront->errorMsg ="Password and confirm password should be same.";
			}
			else
			{
				$Data['confirm_user_password'] = md5($formData['confirm_user_password']);
			}
			
			/*
				if(md5($formData['confirm_user_password'])!=md5($formData['user_password']))
				{
					$mySessionFront->errorMsg ="Password and confirm password should be same."; 
					//$this->view->myform = $form;
					$this->_redirect('register/add');
				}
				else
				{
					$Data['confirm_user_password'] = md5($formData['confirm_user_password']);	
				}
			*/
			
				//prd($Data);
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_users',$Data);
//----------------------------------- Uploading Image Files -----------------------------------------------------------
			$mySessionFront->sucMsg = "New A/c created Success";
			$this->_redirect('dashboard');
			
		} 
		
		
		
		//echo "Akash..."; exit;	
	}
		
	} 
	
	
	
	
	
	
	
	
}
?>
