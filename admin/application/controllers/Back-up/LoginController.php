<?php
class LoginController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		global $mySession;
		/*if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		
		if($mySession->user['userRole']=='A' || $mySession->user['userRole']=='C')
		{ 	
			$this->_redirect('index');	
		}*/	
    }
	
	public function indexAction()
	{	
	global $mySession;
	$db = new Db();
	
	
		global $mySession;
		if(isset($mySession->user['userId'])){
			$this->_redirect('index/show');		
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
				$user 		= 	new Model_SystemUser();
				$result 	= 	$user->authenticateLoginfront($formData);	
				if(is_array($result)){	
					if($result['status']==1){	
						
						$mySession->user['Name']=$result['fname'].' '.$result['lname'];
						$mySession->user['UserName']=$result['username'];	
						$mySession->user['userId'] = $result['userid'];
						$mySession->user['userRole'] = $result['usrRole'];
						$CatDetailSno=$_REQUEST['CatDetailSno'];
						$mySession->user['branchonly']=getbranch_role($result['userid'],$result['usrRole']);
						$this->_redirect('index/show/CatDetailSno/'.$CatDetailSno);					
						//					index/show/CatDetailSno/3
					}
					else if($result['user_status']==0){
						$mySession->errorMsg ="your account is disable."; 
						
						$this->_redirect('index');	
					}
				}else{
						unset($mySession->user);		
						$mySession->errorMsg ="Invalid username or password."; 
						$this->_redirect('index');	
					}
			}
				}
			}
		}
	
	
	}
	
	public function loginAction(){
		
		global $mySession;
		if(isset($mySession->user['userId'])){
			$this->_redirect('index/index');		
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
				$user 		= 	new Model_SystemUser();
				$result 	= 	$user->authenticateLoginfront($formData);	
				if(is_array($result)){	
					if($result['status']==1){	
						/*if($result['usrRole']=='SA'){
							$get_rights = $db->runQuery("select rights from rbi_admin where userId='".$result['userid']."'");
							$rightvar = implode(",",explode(",",$get_rights[0]['rights']));
									
							$res_rights=$db->runQuery("select right_definevar from rbi_adminrighs where rightId in (".$rightvar.")");

							if(is_array($res_rights) && count($res_rights) > 0) { 
								$right_ar=array();
								
								foreach($res_rights as $r_rig)
								{
									$right_ar[]=$r_rig['right_definevar'];
								}		
								$mySession->user['rights']= implode("|",$right_ar);	
							}
						}*/
						$mySession->user['Name']=$result['fname'].' '.$result['lname'];
						$mySession->user['UserName']=$result['username'];	
						$mySession->user['userId'] = $result['userid'];
						$mySession->user['userRole'] = $result['usrRole'];
						$mySession->user['branchonly']=getbranch_role($result['userid'],$result['usrRole']);
						$this->_redirect('index/index');					
						
					}
					else if($result['user_status']==0){
						$mySession->errorMsg ="your account is disable."; 
						
						$this->_redirect('index');	
					}
				}else{
						unset($mySession->user);		
						$mySession->errorMsg ="Invalid username or password."; 
						
						$this->_redirect('index');	
					}
			}
				}
			}
		}
	
				
	}
	
	
	
	
	public function logoutAction(){ 
		global $mySession;
		unset($mySession->user);	
		$mySession->errorMsg ="You are logged out successfully."; 	
		$this->_redirect('index');	
	}
	
	
	/// ---------------------- CITY --------------------
	public function getstatecityAction()
	{
		global $mySession;
		$db=new Db();
		$Result=$db->runQuery("select * from jok_city where stateid='".$_REQUEST['stateId']."'");
		?>
		<select name="city_id" id="city_id">
		<option value="">--City--</option>
		<?				
		if($Result!="" and count($Result)>0)
		{
			foreach($Result as $key=>$cityData)
			{
			?>
			<option value="<?=$cityData['cityid']?>"><?=$cityData['city']?></option>
			<?
			}
		}
		?>
		</select>
		<?
		exit();
	}

}
?>
