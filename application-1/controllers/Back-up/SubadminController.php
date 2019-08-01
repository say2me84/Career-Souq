<?php
class SubadminController extends Zend_Controller_Action
{	
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']!='A')
		{
		
			$this->_redirect('index');	
		}
	}
	public function indexAction()
	{
	global $mySession;
	$this->view->pagetitle = 'View Sub Admin';
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
		$where="where usrRole='SA'";
		if(@$_POST['query']!='')
		{
			$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";
		} 		
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		$qry="select *, rbi_city.city as cityName from rbi_user
		join rbi_admin as rbi_emp on(rbi_user.userid=rbi_emp.userId)
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
			$json .= ",'".$row['lname']."'";
			$json .= ",'".$row['fathername']."'";
			$json .= ",'".$row['emailaddress']."'";
			$json .= ",'".$row['statename']."'";	
			$json .= ",'".$row['cityName']."'";	
			$json .= ",'".$row['address']."'";
			$json .= ",'".$row['phoneno']."'";
			$json .= ",'".$row['mobno']."'";
			$json .= ",'".changeDate($row['DateofBirth'])."'";			
			$json .= ",'<a href=\"".APPLICATION_URL."subadmin/edit/employeeId/".$row['userid']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."subadmin/delete/employeeId/".$row['userid']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	$this->view->pagetitle = 'Add Sub Admin';
	$form = new Form_Subadmin();
	$this->view->Form=$form;
	
	$db=new Db();
	$rescat=$db->runQuery("select * from rbi_right_cat where status=1");
	$rights_array='';
		$m=0;
		foreach($rescat as $rcat)
		{
			$rights_array[$m]['catid'] = $rcat['id'];
			$rights_array[$m]['cat'] =	$rcat['catname'];
				$res_rights=$db->runQuery("select * from rbi_adminrighs where catid='".$rcat['id']."' and status=1");				
				$rights_array[$m]['rights'] = $res_rights;	
				$m++;			
		}
		
		
		$this->view->rights_array=$rights_array;
	}
	public function insertAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Add Sub Admin';
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Subadmin();
			if ($Form->isValid($request->getPost())) 
			{				
				$dataForm=$this->_request->getPost();
				if($dataForm['user_password']!=$dataForm['user_confirm_password'])
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					$this->view->Form = $Form;
					$this->render('add');
				}
				else
				{			
					$myObj=new Model_Subadmin();
					$ChkResult=$myObj->InsertAdmin($dataForm);								
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Sub Admin added successfully."; 
					$this->_redirect('subadmin/index');
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
			$this->_redirect('subadmin/add');
		}
	}
	
	
	
	public function editAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Edit Sub Admin';
	$employeeId= $this->getRequest()->getParam('employeeId');
	$form = new Form_Subadmin($employeeId);
	$this->view->Form=$form;
	$this->view->employeeId=$employeeId;
	
	$db=new Db();
	$rescat=$db->runQuery("select * from rbi_right_cat where status=1");
	$rights_array='';
		$m=0;
		foreach($rescat as $rcat)
		{
			$rights_array[$m]['catid'] = $rcat['id'];
			$rights_array[$m]['cat'] =	$rcat['catname'];
				$res_rights=$db->runQuery("select * from rbi_adminrighs where catid='".$rcat['id']."' and status='1'");				
				$rights_array[$m]['rights'] = $res_rights;	
				$m++;			
		}
		
		$admin_rights=$db->runQuery("select rights, branchid from rbi_admin where userId='".$employeeId."'");				
			
		if(is_array($admin_rights) && count($admin_rights) > 0)
		{
			$this->view->onlybranch = $admin_rights[0]['branchid'];
			if($admin_rights[0]['rights']!='') {
				$this->view->admin_rights=explode(",",$admin_rights[0]['rights']);
			} else {
				$this->view->admin_rights=array();
			}
			
		}
		$this->view->rights_array=$rights_array;
	}
	public function updateAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Edit Sub Admin';
	$employeeId= $this->getRequest()->getParam('employeeId');
	$this->view->employeeId=$employeeId;
	
	$db=new Db();
	$rescat=$db->runQuery("select * from rbi_right_cat where status=1");
	$rights_array='';
		$m=0;
		foreach($rescat as $rcat)
		{
			$rights_array[$m]['catid'] = $rcat['id'];
			$rights_array[$m]['cat'] =	$rcat['catname'];
				$res_rights=$db->runQuery("select * from rbi_adminrighs where catid='".$rcat['id']."'");				
				$rights_array[$m]['rights'] = $res_rights;	
				$m++;			
		}
		
		
		$this->view->rights_array=$rights_array;
		
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Subadmin($employeeId);
			if ($Form->isValid($request->getPost())) 
			{				
				$dataForm=$this->_request->getPost();
				if($dataForm['user_password']!=$dataForm['user_confirm_password'] and isset($_REQUEST['ChangePass']))
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					$this->view->Form = $Form;
					$this->render('edit');
				}
				else
				{							
					$myObj=new Model_Subadmin();
					$ChkResult=$myObj->UpdateEmployee($dataForm,$employeeId);
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Subadmin information updated successfully."; 
					$this->_redirect('subadmin/index');
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
			$this->_redirect('subadmin/edit/employeeId/'.$employeeId);
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
		
	$mySession->errorMsg="Sub Admin has been deleted successfully";
	$this->_redirect('employee/index');
	}	
}
?>
