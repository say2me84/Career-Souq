<?php
__autoloadDB('Db');
class CommentController extends Zend_Controller_Action
{
	
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='A') //|| getsubadmin_role('branch'))
		{
		} else {
			$this->_redirect('index');	
		}
	}
	
	
	public function indexAction()
	{	
		global $mySession;		
	}
	public function addAction()
	{	
		global $mySession;
		
		
		$this->view->pagetitle = 'Add Video';
		$form = new Form_Video();
		$this->view->myform=$form;		
		
		 if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
				$data='';
				$data['CategorySno'] = $formData['CategorySno'];
				$data['SubCatId'] = $formData['SubCatId'];
				$data['VideoName'] = $formData['VideoName'];
				//$data['mhno'] = $formData['institution_fax_no'];
				
				
				$modelobj = new Model_Mainmodel();
				$insid = $modelobj->insertThis('jok_subcatdetail',$data);
//----------------------------------- Uploading Image Files -----------------------------------------------------------
				if(is_array($_FILES['VideoImage']) && $_FILES['VideoImage']['name']!='') {
					
					$ftype = $_FILES['VideoImage']['type'];
					$fname = $_FILES['VideoImage']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/Video_Img/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					//prd($filename);
					if (move_uploaded_file($_FILES['VideoImage']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['VideoImage'] = $filename;
					  $condition = "CatDetailSno='".$insid."'";
					  //$data['VideoImage'] = $_FILES['VideoImage']['tmp_name'];
					  
					  //prd($data);
					  $modelobj->updateThis('jok_subcatdetail',$data,$condition);
					  
					  }
				}
//----------------------------------- Uploading Video Files -----------------------------------------------------------
				if(is_array($_FILES['CatDetailPath']) && $_FILES['CatDetailPath']['name']!='') {
					
					$ftype = $_FILES['CatDetailPath']['type'];
					$fname = $_FILES['CatDetailPath']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/Video_file/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					//prd($filename);
					if (move_uploaded_file($_FILES['CatDetailPath']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['CatDetailPath'] = $filename;
					  $condition = "CatDetailSno='".$insid."'";
					  //$data['CatDetailPath'] = $_FILES['VideoImage']['tmp_name'];
					  
					  //prd($data);
					  $modelobj->updateThis('jok_subcatdetail',$data,$condition);
					  
					  }
				}
				
				$mySession->sucMsg = "Data Updated Success";
				$this->_redirect('Video/viewvideo');
			}
		 }
	}
	
	public function loginAction()
	{	global $mySession;
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
	
}
?>