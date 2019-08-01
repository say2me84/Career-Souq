<?php
__autoloadDB('Db');
class CareerlevelsController extends Zend_Controller_Action
{
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		
		}
		
	}
	
	//Careerlevels Index
	public function indexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Manage Educations";
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
		$limit = "LIMIT $start, $rp";
		
		$qry="SELECT * FROM `tbl_career_levels`";
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
		if(isset($roles[0]) && $roles[0]['id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:['".$i."'";
			
			$json .= ",'".$row['career_level_title']."'";
			
			$json .= ",'<a href=\"".APPLICATION_URL."careerlevels/edit/id/".$row['id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."careerlevels/del/id/".$row['id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
		$this->view->pagetitle = 'New Career levels';
		$form = new Form_Careerlevels();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 //echo "AAkash123"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			
			$Data='';
			$Data['career_level_title'] = $formData['career_level_title'];
			//prd($Data);
			$db->save('tbl_career_levels',$Data); 
			$mySession->errorMsg="New Career levels has been added successfully";
			$this->_redirect('careerlevels/index');
			
		} 
		
	}
		
		
	 }
	
	//Editing Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Edit Career levels';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['id']) {
		$this->view->id = $arr['id'];
		$form = new Form_Careerlevels($arr['id']);
		$this->view->myform=$form;	
		
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
			//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			$Data='';
			$Data['career_level_title'] = $formData['career_level_title'];
			//prd($Data);
			$condition = "id='".$arr['id']."'"; 
			$db->modify('tbl_career_levels',$Data,$condition);
			
			$mySession->sucMsg = "Career levels Updated Successfully";
			$this->_redirect('careerlevels/index');
				}
			 }
		}
	}
	
	//Del Records... Masters Degree
	public function delAction()
	{	
		//global $mySession;
		$db = new Db();
		$this->view->PageTitle="Delete Record..";
		$delData = $this->getRequest()->getParams();
		//prd($delData);
		$mid="id=".$delData['id'];
		$Result=$db->delete('tbl_career_levels',$mid); 
		//prd($Result); exit;
		if($Result==1){
		$mySession->errorMsg="Scheme status changed successfully";	
		$this->_redirect('careerlevels/index');
		}else{
		die('Error');
		}
	}
	

}
?>
