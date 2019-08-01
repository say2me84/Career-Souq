<?php
__autoloadDB('Db');
class VideoController extends Zend_Controller_Action
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
		
		$this->view->pagetitle = 'Add Comment';
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
	
	public function viewvideoAction()
	{	
		global $mySession;
		$db=new Db();
		
		$qry= "SELECT * FROM `jok_SubCatDetail` ORDER BY CatDetailSno DESC LIMIT 0, 4";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->videolist = $GetData;	
		
	}
	
	public function editAction()
	{
	global $mySession;
	//$this->view->pagetitle = 'Edit Video';
	$CatDetailSno= $this->getRequest()->getParam('CatDetailSno');
	$form = new Form_Video($CatDetailSno);
	$this->view->myform=$form;
	//prd($Form);
	//$this->view->CatDetailSno=$CatDetailSno;
		if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
				$data='';
				$data['CategorySno'] = $formData['CategorySno'];
				$data['SubCatId'] = $formData['SubCatId'];
				$data['VideoName'] = $formData['VideoName'];
				//$data['mhno'] = $formData['institution_fax_no'];
				
				
					$modelobj = new Model_Mainmodel();
					$condition = "CatDetailSno='".$CatDetailSno."'"; //exit;
					$modelobj->updateThis('jok_subcatdetail',$data,$condition);
				//$modelobj = new Model_Mainmodel();
				//$insid = $modelobj->insertThis('jok_subcatdetail',$data);
//----------------------------------- Uploading Image Files -----------------------------------------------------------				
				if(is_array($_FILES['VideoImage']) && $_FILES['VideoImage']['name']!='') {
					$insid = $CatDetailSno;
						$ftype = $_FILES['VideoImage']['type'];
						$fname = $_FILES['VideoImage']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = 'upload/Video_Img/';
						$ext = end(explode(".", $fname));
						$filename = $insid.rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						
						if (move_uploaded_file($_FILES['VideoImage']['tmp_name'], $uploadfile)) {
											  
						  $data = '';
						  $data['VideoImage'] = $filename;
						  $condition = "CatDetailSno='".$insid."'";
						  
						  $modelobj->updateThis('jok_subcatdetail',$data,$condition);
						 }
					}
//----------------------------------- Uploading Video Files -----------------------------------------------------------
				if(is_array($_FILES['CatDetailPath']) && $_FILES['CatDetailPath']['name']!='') {
					$insid = $CatDetailSno;
						$ftype = $_FILES['CatDetailPath']['type'];
						$fname = $_FILES['CatDetailPath']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = 'upload/Video_file/';
						$ext = end(explode(".", $fname));
						$filename = $insid.rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						
						$old_image = $_POST['himage'] ;
						@unlink($old_image );
						if (move_uploaded_file($_FILES['CatDetailPath']['tmp_name'], $uploadfile)) {
											  
						  $data = '';
						  $data['CatDetailPath'] = $filename;
						  $condition = "CatDetailSno='".$insid."'";
						  
						  $modelobj->updateThis('jok_subcatdetail',$data,$condition);
						 }
					}
				
				$mySession->sucMsg = "Data Updated Success";
				$this->_redirect('Video/viewvideo');
			}
		 } 
	
	}
	
	public function updateAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Edit Branch';
	$branchId= $this->getRequest()->getParam('branchId');
	$this->view->branchId=$branchId;
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Branch($branchId);
			if ($Form->isValid($request->getPost())) 
			{				
				$dataForm=$Form->getValues();
				/*if($dataForm['user_password']!=$dataForm['user_confirm_password'] and isset($_REQUEST['ChangePass']))
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					$this->view->Form = $Form;
					$this->render('edit');
				}
				else
				{*/							
					$myObj=new Model_Branch();
					$ChkResult=$myObj->UpdateBranch($dataForm,$branchId);
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Branch information updated successfully."; 
					$this->_redirect('branch/index');
					}
					else
					{						
					$mySession->errorMsg ="Username already exists."; 
					$this->view->Form = $Form;
					$this->render('edit');
					}
				//}			
			}
			else
			{
				$this->view->Form = $Form;
				$this->render('edit');
			}
		}
		else
		{				
			$this->_redirect('branch/edit/branchId/'.$branchId);
		}
	}
	
	//Del Records...
	public function delete1Action()
	{
	global $mySession;
	$db=new Db();
	$branchId= $this->getRequest()->getParam('CatDetailSno');
	@unlink($_REQUEST['catName']."/".$_REQUEST['imageName']) ;
	
	$condition1="CatDetailSno='".$CatDetailSno."'";
	$db->delete('jok_subcatdetail',$condition1);
	
	$mySession->errorMsg="Video has been deleted successfully";
	$this->_redirect('Video/viewvideo');
	}	
	
	
		//Del Records...
	public function deleteAction()
	{	
		//global $mySession;
		$db = new Db();
		$this->view->PageTitle="Delete Record..:";
		$delData = $this->getRequest()->getParams();
		//prd($delData);
		$CatDetailSno="CatDetailSno=".$delData['CatDetailSno'];
		$uploaddir = 'upload/Video_Img/';
		
		@unlink($uploaddir.$_REQUEST['VideoImage']) ;
		
		$Result=$db->delete('jok_subcatdetail',$CatDetailSno); 
		//prd($Result); exit;
		if($Result==1){
		$this->_redirect('Video/viewvideo');
		}else{
		die('Error');
		}
	}
	
}
?>