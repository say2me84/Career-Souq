<?php
__autoloadDB('Db');
class CategoryController extends Zend_Controller_Action
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
		$db = new Db();
		//prd($db);
		$this->view->PageTitle="Manage Job Categories";
		
	}
	public function generategridAction()
	{	//echo "Hello....."; exit;
		global $_CONFIG, $mySession; 
		$db=new Db();
		$this->_helper->viewRenderer->setNoRender();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'cat_id';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
			
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		
		$show_on_home[0] = 'NO';
		$show_on_home[1] ='YES';
		
		$qry="SELECT * FROM tbl_job_categories";
		$show_on_home[0] = 'NO';
		$show_on_home[1] ='YES';
		
		//prd($qry);
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['cat_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "cat_id:'".$row['cat_id']."',";
			$json .= "cell:['".$i."'";
			
			$json .= ",'".$row['category_title']."'";
			$json .= ",'".$row['category_banner']."'";
			//$json .= ",'".$row['show_on_home_page']."'";
			$json .= ",'".$show_on_home[$row['show_on_home_page']]."'";
			
			$json .= ",'<a href=\"".APPLICATION_URL."category/edit/cat_id/".$row['cat_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."category/del/cat_id/".$row['cat_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
			$json .= "]}";
			$rc = true;
			$i++;
		}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
		exit();
	}
	
	//Add New Records...
	public function addAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Add New Category";
		$form = new Form_Category();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 //echo "AAkash123"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			$data='';
			$data['category_title'] = $formData['category_title'];
			$data['show_on_home_page'] = $formData['show_on_home_page'];
			//prd($data);
			
			//$db->save('tbl_job_categories',$Data); 
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_job_categories',$data);
//----------------------------------- Uploading Image Files -----------------------------------------------------------
			if(is_array($_FILES['category_banner']) && $_FILES['category_banner']['name']!='') {
					
					$ftype = $_FILES['category_banner']['type'];
					$fname = $_FILES['category_banner']['name'];
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					//$uploaddir = 'upload/category_banners/';
					$uploaddir = 'upload/category_banners/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					//prd($filename);
					if (move_uploaded_file($_FILES['category_banner']['tmp_name'], $uploadfile)) {
					  $data = '';
					  $data['category_banner'] = $filename;
					  $condition = "cat_id='".$insid."'";
						//prd($data);
					  $modelobj->updateThis('tbl_job_categories',$data,$condition);
					  }
				}
//----------------------------------- Uploading Image Files -----------------------------------------------------------
			$mySession->sucMsg="New Category Added Successfully";
			$this->_redirect('category/index');
			
		} 
		
	}
		
	} 
		
	//Editing Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Edit Category';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['cat_id']) {
		$this->view->cat_id = $arr['cat_id'];
		$form = new Form_Category($arr['cat_id']);
		$this->view->myform=$form;	
		
		$qry="SELECT * FROM tbl_job_categories where cat_id='".$arr['cat_id']."'";	
		$GetData = $db->runQuery($qry);
		$this->view->categoriesImg = $GetData;
		
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
			//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			$Data='';
			$Data['category_title'] = $formData['category_title'];
			$Data['show_on_home_page'] = $formData['show_on_home_page'];
			
			if(is_array($_FILES['category_banner']) && $_FILES['category_banner']['name']!='') {
						
						$ftype = $_FILES['category_banner']['type'];
						$fname = $_FILES['category_banner']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = 'upload/category_banners/';
						//prd($uploaddir);
						$ext = end(explode(".", $fname));
						$filename = $arr['cat_id'].rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						
						$dir = "upload/category_banners/";
						unlink($dir.$formData['OldImagePath']);
						
						if (move_uploaded_file($_FILES['category_banner']['tmp_name'], $uploadfile)) {
								//echo "Testin...."; exit;			  
						  
						  $Data['category_banner'] = $filename;
						  //prd($Data);	
						 
						  
						 // $modelobj->updateThis('jok_subcatdetail',$data,$condition);
						 }
					}
//----------------------------------- Uploading Image Files -----------------------------------------------------------
			$condition = "cat_id='".$arr['cat_id']."'";
			$db->modify('tbl_job_categories',$Data,$condition);
			$mySession->sucMsg = "Category Updated Success";
			$this->_redirect('category/index');
				}
			 }
		}
	}
	
	//Del Records...
	public function delAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Delete Record..";
		$delData = $this->getRequest()->getParams();
		//prd($delData);
		$mid="cat_id=".$delData['cat_id'];
		$Result=$db->delete('tbl_job_categories',$mid); 
		//prd($Result); exit;
		if($Result==1){
		
		$mySession->sucMsg="Category Deleted Successfully";
		$this->_redirect('category/index');
		}else{
		die('Error');
		}
	}
	

}
?>
