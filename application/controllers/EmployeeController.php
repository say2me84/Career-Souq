<?php
class EmployeeController extends Zend_Controller_Action
{	
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('emp') || $mySession->user['userRole']=='B')
		{
		} else {
			$this->_redirect('index');	
		}
	}
	public function indexAction()
	{
	global $mySession;
	$this->view->pagetitle = 'View Employee';
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
		$where="where usrRole='E'";
		if(@$_POST['query']!='')
		{
			$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";
		}
		if($mySession->user['branchonly']['isbranch'])
		{
			$where .= " and branchId = '".$mySession->user['branchonly']['branchid']."' ";
		}
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		$qry="select rbi_user.*,rbi_emp.fathername,rbi_emp.branchId,rbi_emp.DateofBirth,(select fname from rbi_user where rbi_user.userid=rbi_emp.branchId) as branch_name,rbi_city.city as cityName, rbi_state.statename, dag.desig as designation from rbi_user
		join rbi_employee as rbi_emp on(rbi_user.userid=rbi_emp.userId)
		left join rbi_designation as dag on(rbi_emp.desig_id=dag.did)
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
			$json .= ",'".$row['branch_name']."'";
			$json .= ",'".$row['fname']."'";
			$json .= ",'".$row['lname']."'";
			$json .= ",'".$row['fathername']."'";
			$json .= ",'".$row['designation']."'";
			$json .= ",'".$row['emailaddress']."'";
			$json .= ",'".$row['statename']."'";	
			$json .= ",'".$row['cityName']."'";	
			$json .= ",'".$row['address']."'";
			$json .= ",'".$row['phoneno']."'";
			$json .= ",'".$row['mobno']."'";
			$json .= ",'".changeDate($row['DateofBirth'])."'";			
			$json .= ",'<a href=\"".APPLICATION_URL."employee/edit/employeeId/".$row['userid']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."employee/delete/employeeId/".$row['userid']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	$this->view->pagetitle = 'Add Employee';
	$form = new Form_Employee();
	$this->view->Form=$form;
	}
	public function insertAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Add Employee';
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Employee();
			if ($Form->isValid($request->getPost())) 
			{				
				$dataForm=$Form->getValues();
				if($dataForm['user_password']!=$dataForm['user_confirm_password'])
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					$this->view->Form = $Form;
					$this->render('add');
				}
				else
				{			
					$myObj=new Model_Employee();
					$ChkResult=$myObj->InsertEmployee($dataForm);								
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Employee added successfully."; 
					$this->_redirect('employee/index');
					}
					else
					{						
					$mySession->errorMsg ="Username already exists."; 
					$this->view->Form = $Form;
					$this->render('add');
					}	
				}		
			}
			else
			{
				$this->view->Form = $Form;
				$this->render('add');
			}
		}
		else
		{				
			$this->_redirect('employee/add');
		}
	}
	
	public function editAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Edit Employee';
	$employeeId= $this->getRequest()->getParam('employeeId');
	$form = new Form_Employee($employeeId);
	$this->view->Form=$form;
	$this->view->employeeId=$employeeId;
	}
	public function updateAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Edit Employee';
	$employeeId= $this->getRequest()->getParam('employeeId');
	$this->view->employeeId=$employeeId;
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Employee($employeeId);
			if ($Form->isValid($request->getPost())) 
			{				
				$dataForm=$Form->getValues();	
				if($dataForm['user_password']!=$dataForm['user_confirm_password'] and isset($_REQUEST['ChangePass']))
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					$this->view->Form = $Form;
					$this->render('edit');
				}
				else
				{							
					$myObj=new Model_Employee();
					$ChkResult=$myObj->UpdateEmployee($dataForm,$employeeId);
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Employee information updated successfully."; 
					$this->_redirect('employee/index');
					}
					else
					{						
					$mySession->errorMsg ="Username already exists."; 
					$this->view->Form = $Form;
					$this->render('edit');
					}	
				}		
			}
			else
			{
				$this->view->Form = $Form;
				$this->render('edit');
			}
		}
		else
		{				
			$this->_redirect('employee/edit/employeeId/'.$employeeId);
		}
	}
	public function deleteAction()
	{
	global $mySession;
	$db=new Db();
	$employeeId= $this->getRequest()->getParam('employeeId');
	
	$condition1="userid='".$employeeId."'";
	$db->delete('rbi_user',$condition1);
	
	$condition2="userId='".$employeeId."'";
	$db->delete('rbi_employee',$condition2);
		
	$mySession->errorMsg="Employee has been deleted successfully";
	$this->_redirect('employee/index');
	}	
}
?>
