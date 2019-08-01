<?php
__autoloadDB('Db');
class ZoneController extends Zend_Controller_Action
{

	
	
	
	//View Records...
	public function indexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Zone List:";
		//echo "akash";
			
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
		$qry="SELECT * FROM `tbl_countries`";
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
			$json .= ",'".$row['name']."'";
			$json .= ",'<a href=\"".APPLICATION_URL."Zone/edit/id/".$row['id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."Zone/del/id/".$row['id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
		$this->view->pagetitle = 'Add Country';
		$form = new Form_Zone();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 	$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			$Data='';
			$Data['name'] = $formData['name'];
			//prd($Data);
			$db->save('tbl_countries',$Data); 
			$mySession->errorMsg="New Country has been added successfully";
			$this->_redirect('zone/index');
			
		} 
		
	}
		
		
	 }
	
	//Edit Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['id']) {
		$this->view->mid = $arr['id'];
		
			$this->view->pagetitle = 'Edit Countries';
			
			$form = new Form_Zone($arr['id']);
			//prd($form);
			$this->view->myform=$form;		
			 if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();
					//prd($formData);
				if ($form->isValid($formData)) {
				
					$data='';
					$data['name'] = $formData['name'];
					//prd($data); exit;
										
					
					$condition = "id='".$arr['id']."'"; //exit;
					$db->modify('tbl_countries',$data,$condition);

										
					$mySession->sucMsg = "Country Updated Successfully";
					//$this->_redirect('school/show/schoolid/'.$arr['schoolid']);
					$this->_redirect('Zone/index');
				}
			 }
		}
	}
	
	//Del Records...
	public function delAction()
	{	
		//global $mySession;
		$db = new Db();
		$this->view->PageTitle="Delete Record..:";
		$delData = $this->getRequest()->getParams();
		//prd($delData);
		$id="id=".$delData['id'];
		$Result=$db->delete('tbl_countries',$id); 
		//prd($Result); exit;
		if($Result==1){
		$this->_redirect('Zone/index');
		}else{
		die('Error');
		}
	}
	
}
?>