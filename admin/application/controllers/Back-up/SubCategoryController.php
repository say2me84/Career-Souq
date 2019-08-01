<?php
__autoloadDB('Db');
class SubcategoryController extends Zend_Controller_Action
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
		$this->view->PageTitle="Manage Job Sub Category";
	}
	public function generategridAction()
	{	
		global $mySession;
		$db = new Db();
		$this->_helper->viewRenderer->setNoRender();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'sub_cat_id';
		if (!$sortorder) $sortorder = 'desc';		
		$where="where 1";
			
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		
		/*$qry="select tbl_job_sub_categories.*, tbl_job_sub_categories.id,tbl_job_sub_categories.sub_category_title,tbl_job_sub_categories.category_id,
tbl_job_categories.category_title from tbl_job_sub_categories left join tbl_job_categories ON (tbl_job_categories.id = tbl_job_sub_categories.category_id)";*/

		$qry="select *, tbl_job_sub_categories.*, tbl_job_categories.category_title from tbl_job_sub_categories
		LEFT JOIN tbl_job_categories on(tbl_job_sub_categories.category_id=tbl_job_categories.cat_id)";
		
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['sub_cat_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "sub_cat_id:'".$row['sub_cat_id']."',";
			$json .= "cell:['".$i."'";
			
			$json .= ",'".$row['sub_category_title']."'";
			$json .= ",'".$row['category_title']."'";
			
			$json .= ",'<a href=\"".APPLICATION_URL."subcategory/edit/sub_cat_id/".$row['sub_cat_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."subcategory/del/sub_cat_id/".$row['sub_cat_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
		$this->view->PageTitle="Add New Sub Category";
		$form = new Form_Subcategory();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 //echo "AAkash123"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			$Data='';
			$Data['sub_category_title'] = $formData['sub_category_title'];
			$Data['category_id'] = $formData['category_title']; 
			//prd($Data);
			
			//$db->save('tbl_job_categories',$Data); 
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_job_sub_categories',$Data);

			$mySession->sucMsg="New Category Added Successfully";
			$this->_redirect('subcategory/index');
			
		} 
		
	}
		
	} 
	
	//Editing Records...
	public function editAction()
	{
	global $mySession;
	$db = new Db();
	$this->view->pagetitle = 'Edit Job Sub Category';
	$sub_cat_id= $this->getRequest()->getParam('sub_cat_id');
	$form = new Form_Subcategory($sub_cat_id);
	//prd($form);
	$this->view->myform=$form;
		if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
				$Data='';
				$Data['sub_category_title'] = $formData['sub_category_title'];
				$Data['category_id'] = $formData['category_title']; 
				
					//prd($Data);
				
				$modelobj = new Model_Mainmodel();
				$condition = "sub_cat_id='".$sub_cat_id."'"; //exit;
				$modelobj->updateThis('tbl_job_sub_categories',$Data,$condition);
						
				$mySession->sucMsg = "Sub category Updated Success";
				$this->_redirect('subcategory/index');
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
		$mid="id=".$delData['id'];
		$Result=$db->delete('tbl_job_sub_categories',$mid); 
		//prd($Result); exit;
		if($Result==1){
		$mySession->errorMsg="Subcategory Delete successfully";	
		$this->_redirect('subcategory/index');
		}else{
		die('Error');
		}
	}

}
?>
