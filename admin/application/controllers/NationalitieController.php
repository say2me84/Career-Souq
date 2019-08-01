<?php
__autoloadDB('Db');
class NationalitieController extends Zend_Controller_Action
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
		$this->view->pagetitle="Manage Job Nationalities";
		
	}
	public function generategridAction()
	{	
		global $_CONFIG, $mySession; 
		$db=new Db();
		$this->_helper->viewRenderer->setNoRender();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'id';
		if (!$sortorder) $sortorder = 'DEC';		
		$where="where 1";
			
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		
		$qry="SELECT * FROM `tbl_nationalities`";
		
		
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
			$json .= ",'".$row['nation_title']."'";
			$json .= ",'<a href=\"".APPLICATION_URL."nationalitie/edit/id/".$row['id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."nationalitie/del/id/".$row['id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
		$db=new Db();
		$this->view->pagetitle = 'Edit Nationalitie';
		$form = new Form_Nationalitie();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 //echo "AAkash123"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			$data='';
			$data['nation_title'] = $formData['nation_title'];
			
			//prd($data);
			
			//$db->save('tbl_job_categories',$Data); 
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_nationalities',$data);
			
			$mySession->sucMsg="New Nationalitie Added Successfully";
			$this->_redirect('nationalitie/index');
			
		} 
		
	}
		
	} 
		
	//Editing Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Edit Nationalitie';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['id']) {
		$this->view->id = $arr['id'];
		$form = new Form_Nationalitie($arr['id']);
		$this->view->myform=$form;	
		
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
			//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			$Data='';
			$Data['nation_title'] = $formData['nation_title'];
			//prd($Data);
			$condition = "id='".$arr['id']."'";
			$db->modify('tbl_nationalities',$Data,$condition);
			$mySession->sucMsg = "Nationalitie Updated Success";
			$this->_redirect('nationalitie/index');
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
		$mid="id=".$delData['id'];
		$Result=$db->delete('tbl_nationalities',$mid); 
		//prd($Result); exit;
		if($Result==1){
		
		$mySession->sucMsg="Nationalitie Deleted Successfully";
		$this->_redirect('nationalitie/index');
		}else{
		die('Error');
		}
	}
	

}
?>
