<?php
__autoloadDB('Db');
class StaticController extends Zend_Controller_Action
{
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		
		}
		
	}
	
// ===================== Page Category ====================================================================
	public function indexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Manage Static Page";
	}
	public function generategridAction()
	{	
		global $_CONFIG, $mySession;
		$this->_helper->viewRenderer->setNoRender();
		$db=new Db();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'name';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
			
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";					//tbl_static_page static_page_id Page_Category
		$qry="SELECT * FROM `tbl_static_page`";
		//static_page_id Page_Category
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['static_page_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['static_page_id']."',";
			$json .= "cell:['".$i."'";
			$json .= ",'".$row['Page_Category']."'";
			$json .= ",'<a href=\"".APPLICATION_URL."static/editcategory/static_page_id/".$row['static_page_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."static/delcategory/static_page_id/".$row['static_page_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	public function addcategoryAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Add New Static Page Category';
		$form = new Form_Staticpagecategory();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 //echo "AAkash123"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			
			$Data='';
			$Data['Page_Category'] = $formData['Page_Category'];
			//prd($Data);
			$db->save('tbl_static_page',$Data); 
			$mySession->sucMsg="New Static Page Category has been added successfully";
			$this->_redirect('static/index');
			
		} 
		
	}
		
		
	 }
	
	//Editing Records...
	public function editcategoryAction()
	{	
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Edit Career levels';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['static_page_id']) {
		$this->view->id = $arr['static_page_id'];
		$form = new Form_Staticpagecategory($arr['static_page_id']);
		$this->view->myform=$form;	
		
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
			//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			$Data='';
			$Data['Page_Category'] = $formData['Page_Category'];
			//prd($Data);
			$condition = "static_page_id='".$arr['static_page_id']."'"; 
			$db->modify('tbl_static_page',$Data,$condition);
			
			$mySession->sucMsg = "Page Category Updated Successfully";
			$this->_redirect('static/index');
				}
			 }
		}
	}
	
	//Del Records... Masters Degree
	public function delcategoryAction()
	{
	global $mySession;
	$db=new Db();
	$static_page_id= $this->getRequest()->getParam('static_page_id');
	$condition="static_page_id='".$static_page_id."'";
	$db->delete('tbl_static_page',$condition);
	$mySession->errorMsg="Page Category Delete Successfully";
	$this->_redirect('static/index');
	}
// ===================== End of Page Category ====================================================================





// ===================== Page Details ====================================================================
	public function pageindexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Manage Web Pages";
	}
	public function pagegridAction()
	{	
		global $_CONFIG, $mySession;
		$this->_helper->viewRenderer->setNoRender();
		$db=new Db();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'name';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
			
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";					
		$qry="SELECT tbl_static_page_detail.page_id,tbl_static_page_detail.page_cat_id,tbl_static_page_detail.title,tbl_static_page_detail.created_on,
tbl_static_page_detail.last_updated_on,tbl_static_page_detail.is_front,tbl_static_page_detail.`status`,tbl_static_page.Page_Category FROM
tbl_static_page_detail LEFT JOIN tbl_static_page ON tbl_static_page_detail.page_cat_id = tbl_static_page.static_page_id";
		//static_page_id Page_Category
		
		$status_Show[0] = 'Active';
		$status_Show[1] ='Disable';
		
		$status_Front[0] = 'NO';
		$status_Front[1] ='YES';
		
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['page_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['page_id']."',";
			$json .= "cell:['".$i."'";
			
			$json .= ",'".$row['title']."'";
			$json .= ",'".$row['Page_Category']."'";
			$json .= ",'".$row['created_on']."'";
			$json .= ",'".$row['last_updated_on']."'";
			$json .= ",'".$status_Front[$row['is_front']]."'";
			$json .= ",'".$status_Show[$row['status']]."'";
			
			$json .= ",'<a href=\"".APPLICATION_URL."static/editpage/page_id/".$row['page_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."static/delpage/page_id/".$row['page_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	public function pageaddAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Add New CMS Page';
		$form = new Form_Staticpage();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 //echo "AAkash123"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			
			$Data='';
			$Data['title'] = $formData['title'];
			$Data['page_cat_id'] = $formData['Page_Category'];
			$Data['content'] = $formData['content'];
			$Data['created_on'] =date("Y-m-d");
			$Data['last_updated_on'] =date("Y-m-d");
			$Data['is_front'] = $formData['is_front'];
			$Data['status'] = $formData['status'];
			
			//prd($Data);
			$db->save('tbl_static_page_detail',$Data); 
			$mySession->sucMsg="New Static Page Category has been added successfully";
			$this->_redirect('static/pageindex');
			
		} 
		
	}
		
		
	 }
	
	//Editing Records...
	public function editpageAction()
	{	
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Edit CMS Page';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['page_id']) {
		$this->view->id = $arr['page_id'];
		$form = new Form_Staticpage($arr['page_id']);
		$this->view->myform=$form;	
		
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
			//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			
			$Data='';
			$Data['title'] = $formData['title'];
			$Data['page_cat_id'] = $formData['Page_Category'];
			$Data['content'] = $formData['content'];
			$Data['is_front'] = $formData['is_front'];
			$Data['status'] = $formData['status'];
			
			//prd($Data);
			$condition = "page_id='".$arr['page_id']."'"; 
			$db->modify('tbl_static_page_detail',$Data,$condition);
			
			$mySession->sucMsg = "Page Category Updated Successfully";
			$this->_redirect('static/pageindex');
				}
			 }
		}
	}
	
	//Del Records... Masters Degree
	public function delpageAction()
	{
	global $mySession;
	$db=new Db();
	$page_id= $this->getRequest()->getParam('page_id');
	$condition="page_id='".$page_id."'";
	$db->delete('tbl_static_page_detail',$condition);
	$mySession->errorMsg="Page Delete Successfully";
	$this->_redirect('static/pageindex');
	}
// ===================== End of Page Details ====================================================================


}
?>
