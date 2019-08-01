<?php
class SchemeController extends Zend_Controller_Action
{
	public function init() 
	{    
		global $mySession;
		if(!isLogged()) 
		{ 	
		$this->_redirect('index');			
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('scheme'))
		{ 	
			
		} else {
			$this->_redirect('index');	
		}
    }
	public function indexAction()
	{
	global $mySession;
	$db = new Db();
	$this->view->pagetitle = 'View Scheme';		
	
	$where='';
		if(@$_POST['searchfor_scheme_cat']!='') {
			$where .= " and scheme_type = '".$_POST['searchfor_scheme_cat']."'";
		}
		unset($mySession->sessionwhere);
		$mySession->sessionwhere=$where;
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
		if (!$sortname) $sortname = 'title';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1=1";
		if(@$_POST['query']!='')
		{
			$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";
		} 		
		$where .= $mySession->sessionwhere;
//$mySession->sessionwhere = '';
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		$qry="select * from rbi_scheme inner join rbi_scheme_type on(rbi_scheme.scheme_type=rbi_scheme_type.schemeTypeId)";
		
		$roles=$db->runQuery("$qry $where $sort $limit");
		
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['schemId']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['schemId']."',";
			$json .= "cell:['".$i."'";
			$json .= ",'".$row['title']."'";
			$json .= ",'".$row['landsize']."'";
			$json .= ",'".getinstallmenttimeword($row['timePriodType'],$row['timePeriod'])."'";		
			$json .= ",'".$row['installment']."'";
			$json .= ",'".$row['noOfInstallment']."'";
			$json .= ",'".$row['ReturnAmount']."'";
			$json .= ",'".$row['schemeType']."'";
			$json .= ",'".$row['agent_commission']."'";
			if($row['status']=='1')
			{
			$json .= ",'<a href=\"".APPLICATION_URL."scheme/changestatus/schemId/".$row['schemId']."/status/".$row['status']."\"><img title=\"Change Status\" alt=\"Change Status\" src=\"".APPLICATION_URL."/images/icon_status_green.gif\" border=\"0\" /></a>'";
			}
			else
			{
			$json .= ",'<a href=\"".APPLICATION_URL."scheme/changestatus/schemId/".$row['schemId']."/status/".$row['status']."\"><img title=\"Change Status\" alt=\"Change Status\" src=\"".APPLICATION_URL."/images/icon_status_red.gif\" border=\"0\" /></a>'";
			}
			$json .= ",'<a href=\"".APPLICATION_URL."scheme/edit/fid/".$row['schemId']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";
			$json .= ",'<a href=\"".APPLICATION_URL."scheme/delete/schemId/".$row['schemId']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	
	public function addAction(){
		global $mySession;
		$this->view->pagetitle = 'Add Scheme';
		if(isset($mySession->user['userId']) && !empty($mySession->user['userId'])){
			if(1==1){
				$mySession->editdetail='';
				$form = new Form_Scheme();
				$this->view->Form = $form;
				
				$request = $this->getRequest();
				
				if ($this->getRequest()->isPost()) 
		 		{
					$dataForm = $this->_request->getPost();
					if ($form->isValid($dataForm))
					{
						
						$modelobj = new Model_Scheme();
						
						
						//$result=$modelobj->runThisQuery("select * from rbi_scheme where title='".$dataForm['_Title']."' and scheme_type='".$dataForm['_Type']."'");
//						
//						if(is_array($result) && count($result) > 0)
//						{
//							$mySession->errorMsg="Scheme title already exists.";
//							
//						} else {
							$Data['title']=$dataForm['_Title'];
							$Data['landsize']=$dataForm['_landsize'];
							$Data['scheme_type']=$dataForm['_Type'];
							$Data['mnth']=$dataForm['_mnth'];
							$Data['timePeriod']=$dataForm['_TimePriod'];
							$Data['timePriodType']=$dataForm['_TPType'];
							$Data['installment']=$dataForm['_Installment'];
							$Data['agent_commission']=$dataForm['_AgentCommition'];
							$Data['noOfInstallment']=$dataForm['_NoOfInst'];
							$Data['ReturnAmount']=$dataForm['_ReturnAmount'];
							$Data['created_on']=date('Y-m-d h:i:s');
							$Data['lastupdate']=date('Y-m-d h:i:s');
							$Data['created_by']=$mySession->user['userId'];
							$Data['updated_by']=$mySession->user['userId'];
							$Data['sms_status']=1;
							$Data['status']=1;
							
							$insertdata=$modelobj->insertThis($Data);
							$mySession->errorMsg="New Scheme has been added successfully";
							$this->_redirect('scheme/add');
						//}
					}
				}
			}
		}else{
			$this->_redirect('index');
		}
		 
	}
	
	public function deleteAction()
	{
	global $mySession;
	$db=new Db();
	$schemId= $this->getRequest()->getParam('schemId');
	$condition="schemId='".$schemId."'";
	$db->delete('rbi_scheme',$condition);
	$mySession->errorMsg="Scheme has been deleted successfully";
	$this->_redirect('scheme/index');
	}
	public function changestatusAction()
	{
	global $mySession;
	$schemId= $this->getRequest()->getParam('schemId');
	$status= $this->getRequest()->getParam('status');
	$db=new Db();
	if($status==0)
	{
	$Updatestatus=1;
	}
	else
	{
	$Updatestatus=0;
	}	
	$mydata =array('status' => $Updatestatus);	
	$where="schemId='".$schemId."'";
	$db->modify('rbi_scheme',$mydata,$where);	
	$mySession->errorMsg="Scheme status changed successfully";			
	$this->_redirect('scheme/index');	
	}
	
	public function editAction(){
		global $mySession;
		$modelobj = new Model_Scheme();
		
		$this->view->pagetitle = 'Edit Scheme';
		$arr=$this->getRequest()->getParams();
		
		if(isset($mySession->user['userId']) && !empty($mySession->user['userId'])){
			if(1==1){
				$result=$modelobj->runThisQuery("select * from rbi_scheme where schemId='".$arr['fid']."'");
				if(is_array($result) && count($result) > 0)
				{
					$mySession->editdetail=$result[0];
				}
				
				$form = new Form_Scheme();
				$this->view->Form = $form;
				$this->view->fid = $arr['fid'];
				
				$request = $this->getRequest();
				if ($this->getRequest()->isPost()) 
				{
					$dataForm = $this->_request->getPost();		
					if ($form->isValid($dataForm))
					{										
					
						//$result=$modelobj->runThisQuery("select * from rbi_scheme where title='".$dataForm['_Scheme']."' and scheme_type='".$dataForm['_Type']."' and schemId!='".$dataForm['fid']."'");
						
						//if(is_array($result) && count($result) > 0)
//						{
//							$mySession->errorMsg="Scheme name already exists.";
//							
//						} else {
							$Data['title']=$dataForm['_Title'];
							$Data['scheme_type']=$dataForm['_Type'];
							$Data['landsize']=$dataForm['_landsize'];
							$Data['mnth']=$dataForm['_mnth'];
							$Data['timePeriod']=$dataForm['_TimePriod'];
							$Data['timePriodType']=$dataForm['_TPType'];
							$Data['installment']=$dataForm['_Installment'];
							$Data['agent_commission']=$dataForm['_AgentCommition'];
							$Data['noOfInstallment']=$dataForm['_NoOfInst'];
							$Data['ReturnAmount']=$dataForm['_ReturnAmount'];							
							$Data['lastupdate']=date('Y-m-d h:i:s');							
							$Data['updated_by']=$mySession->user['userId'];
							$Data['sms_status']=1;
							
							$where="schemId='".$dataForm['fid']."'";
							$insertdata=$modelobj->updateThis($Data,$where);
							$mySession->errorMsg="Scheme has been updated successfully";
							$this->_redirect('scheme/index');
						//}
					}
				}
			}
		}else{
			$this->_redirect('index');
		}
	
	}
	
}
?>
