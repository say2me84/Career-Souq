<?php
__autoloadDB('Db');
class RegisterController extends Zend_Controller_Action
{
	public function init() 
	{	
		global $mySession;
		/*if(!isLogged())
		{ 	
		$this->_redirect('index');	
		
		}*/
		
	}
	public function indexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Customer List:";
		//echo "akash";
			
	}	
//---------------------------------------------------------------ADD New Records...
	public function addAction()
	{	
		$db = new Db();
		global $mySession;
		$this->view->PageTitle="Video Adding:";
		$form = new Form_Register();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 	$formData = $objRequest->getPost();	
		
		if($form->isValid($formData)){
		
			$Data='';
			$Data['gender'] = $formData['gender']; 
			$Data['fname'] = $formData['fname']; 
			$Data['lname'] = $formData['lname'];
			$Data['username'] = $formData['username'];
			$Data['password'] = $formData['password']; 
			$Data['emailaddress'] = $formData['emailaddress'];
			$Data['dob'] = $formData['dob'];
			$Data['phoneno'] = $formData['phoneno']; 
			$Data['mobno'] = $formData['mobno'];
			$Data['address'] = $formData['address'];
			$Data['state'] = $formData['state_id']; 
			$Data['city'] = $formData['city_id'];
			
	$mycnttData=$db->runQuery("SELECT COUNT(userid) as mycnt FROM jok_user");
	//prd($mycnttData);
	$usr='USR';
	$myid = $usr.str_pad(($mycnttData[0]['mycnt']+1),6,0,STR_PAD_LEFT);
	//prd($myid);
	$Data['profileId'] = $myid;
	
				
				$dtr=explode('-',$formData['dob']);
				
				$Data['dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
				$Data['usrRole'] = 'C';
				$Data['status'] = '1';
				//prd($Data);
				
				$modelobj = new Model_Mainmodel();
				$insid = $modelobj->insertThis('jok_user',$Data);
//----------------------------------- Uploading Image Files -----------------------------------------------------------
				if(is_array($_FILES['photo']) && $_FILES['photo']['name']!='') {
					
					$ftype = $_FILES['photo']['type'];
					$fname = $_FILES['photo']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/User_pic/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					//prd($filename);
					if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['photo'] = $filename;
					  $condition = "userid='".$insid."'";
					  //$data['photo'] = $_FILES['photo']['tmp_name'];
					  
					  //prd($data);
					  $modelobj->updateThis('jok_user',$data,$condition);
					  
					  }
				}
				
				$mySession->sucMsg = "Data Updated Success";
				$this->_redirect('register/add');
			
		} 
		
		
		
		//echo "Akash..."; exit;	
	}
		
	} 
	

	
	
	
	
	
	
}
?>
