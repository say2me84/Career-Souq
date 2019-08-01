<?php
class BranchController extends Zend_Controller_Action
{	
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('branch'))
		{
		} else {
			$this->_redirect('index');	
		}
	}
	public function indexAction()
	{
	global $mySession;
	$this->view->pagetitle = 'View Branch';
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
		if (!$sortname) $sortname = 'fname';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where usrRole='B'";
		if(@$_POST['query']!='')
		{
			$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";
		} 		
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		$qry="select rbi_user.*, rbi_branch.fax, rbi_city.city as cityName, rbi_state.statename from rbi_user
		join rbi_branch on(rbi_user.userid=rbi_branch.userId)
		left join rbi_state on(rbi_user.state=rbi_state.stateid)
		left join rbi_city on(rbi_user.city=rbi_city.cityid)";
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['userid']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['userid']."',";
			$json .= "cell:['".$i."'";
			$json .= ",'".$row['profileId']."'";
			$json .= ",'".$row['fname']."'";			
			$json .= ",'".$row['emailaddress']."'";			
			$json .= ",'".$row['statename']."'";	
			$json .= ",'".$row['cityName']."'";	
			$json .= ",'".$row['address']."'";			
			$json .= ",'".$row['phoneno']."'";
			$json .= ",'".$row['mobno']."'";
			$json .= ",'".$row['fax']."'";			
			$json .= ",'<a href=\"".APPLICATION_URL."branch/edit/branchId/".$row['userid']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."branch/delete/branchId/".$row['userid']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	
	public function addAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Add Branch';
	$form = new Form_Branch();
	$this->view->Form=$form;
	}
	public function insertAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Add Branch';
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Branch();
			if ($Form->isValid($request->getPost())) 
			{				
				$dataForm=$Form->getValues();	
				/*if($dataForm['user_password']!=$dataForm['user_confirm_password'])
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					$this->view->Form = $Form;
					$this->render('add');
				}
				else
				{*/							
					$myObj=new Model_Branch();
					$ChkResult=$myObj->InsertBranch($dataForm);								
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Branch added successfully."; 
					//$this->_redirect('branch/index');
					$this->_redirect('branch/add');
					}
					else
					{						
					$mySession->errorMsg ="Username already exists."; 
					$this->view->Form = $Form;
					$this->render('add');
					}	
				//}		
			}
			else
			{
				$this->view->Form = $Form;
				$this->render('add');
			}
		}
		else
		{				
			$this->_redirect('branch/add');
		}
	}
	
	public function editAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Edit Branch';
	$branchId= $this->getRequest()->getParam('branchId');
	$form = new Form_Branch($branchId);
	$this->view->Form=$form;
	$this->view->branchId=$branchId;
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
	public function deleteAction()
	{
	global $mySession;
	$db=new Db();
	$branchId= $this->getRequest()->getParam('branchId');
	
	$condition1="userid='".$branchId."'";
	$db->delete('rbi_user',$condition1);
	
	$condition2="userId='".$branchId."'";
	$db->delete('rbi_branch',$condition2);
	
	$mySession->errorMsg="Branch has been deleted successfully";
	$this->_redirect('branch/index');
	}	
}
?>
