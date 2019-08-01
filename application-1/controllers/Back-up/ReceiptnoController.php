<?php
class ReceiptnoController extends Zend_Controller_Action
{	
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('receiptno'))
		{
		} else {
			$this->_redirect('index');	
		}
	}
	public function indexAction()
	{
	
	global $mySession;
	$this->view->pagetitle = 'View Receipt No. List';
	$where='';
	if(@$_POST['filter_rfrom']!='' || @$_POST['filter_rto']!='')
		{
			if(@$_POST['filter_rfrom']!='' && @$_POST['filter_rto']!='')
			{
				$where .= " and rbi_receipt.recno >= '".$_POST['filter_rfrom']."' and rbi_receipt.recno <= '".$_POST['filter_rto']."' ";
			}
			if(@$_POST['filter_rfrom']!='' && @$_POST['filter_rto']=='')
			{
				$where .= " and rbi_receipt.recno >= '".$_POST['filter_rfrom']."' ";
			}
			if(@$_POST['filter_rfrom']=='' && @$_POST['filter_rto']!='')
			{
				$where .= " and rbi_receipt.recno <= '".$_POST['filter_rto']."' ";
			}
		} 
		if(@$_POST['user_profile']!='')
		{	
			$where .= " and (rbi_user.profileId = '".$_POST['user_profile']."')  ";
		}
		
		if(isset($_POST['status']))
		{	
			if($_POST['status']==1) {
				$where .= " and (rbi_receipt.user_inst_Id != '0')  ";
			} else {
				$where .= " and (rbi_receipt.user_inst_Id = '0')  ";
			}
		} else {
			$where .= " and (rbi_receipt.user_inst_Id != '0')  ";
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
		if (!$sortname) $sortname = 'fname';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
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
		$qry="select rbi_receipt.*, rbi_user.userid, concat(rbi_user.fname,' ',rbi_user.lname) as name, rbi_user.usrRole,
		(CASE rbi_user.usrRole
		When 'AG' THEN 'Advisor' 
		When 'E' THEN 'Employe'
		END) as utypename ,
		(CASE rbi_user.usrRole
		When 'AG' THEN (select profileId from rbi_agent where rbi_agent.userId=rbi_user.userid)
		When 'E' THEN (select profileId from rbi_employee where rbi_employee.userId=rbi_user.userid)
		END) as profileid 		
		from rbi_receipt
		join rbi_user on(rbi_user.userid=rbi_receipt.allotto) 
		left join 
 		rbi_agent as rbi_ag on(rbi_ag.userId=rbi_user.userid) 
		left join rbi_employee rbiemp on(rbiemp.userId=rbi_user.userid)
		";
		//echo $qry.' '.$where;
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
			$json .= ",'".$row['utypename']."'";
			$json .= ",'".$row['name']."'";			
			$json .= ",'".$row['profileid']."'";			
			$json .= ",'".$row['recno']."'";				
			if($row['user_inst_Id']) { 
			$json .= ",'--'";
			} else {
			$json .= ",'<a href=\"".APPLICATION_URL."receiptno/delete/recid/".$row['id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";
			}
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
	$this->view->pagetitle = 'Add Receipt List';
	$form = new Form_Receiptno();
	$this->view->Form=$form;
	}
	public function insertAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Add Receipt List';
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Receiptno();
			if ($Form->isValid($request->getPost())) 
			{				
					$dataForm=$Form->getValues();	
					$myObj=new Model_Receiptno();
					$ChkResult=$myObj->InsertRecieptno($dataForm);	
																	
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Receipt List added successfully."; 
					$this->_redirect('receiptno/index');
					}
					elseif($ChkResult=='3')
					{
						$mySession->errorMsg ="Please Enter Receipt No. Properly"; 
						$this->view->Form = $Form;
						$this->render('add');
					} elseif($ChkResult=='4')
					{
						$mySession->errorMsg ="User code invalid."; 
						$this->view->Form = $Form;
						$this->render('add');
					} else 
					{						
					$mySession->errorMsg ="Receipt No. already exists."; 
					$this->view->Form = $Form;
					$this->render('add');
					}	
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
				if($dataForm['user_password']!=$dataForm['user_confirm_password'] and isset($_REQUEST['ChangePass']))
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					$this->view->Form = $Form;
					$this->render('edit');
				}
				else
				{							
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
			$this->_redirect('branch/edit/branchId/'.$branchId);
		}
	}
	public function deleteAction()
	{
	global $mySession;
	$db=new Db();
	$recid= $this->getRequest()->getParam('recid');
	
	$condition1="id='".$recid."'";
	$db->delete('rbi_receipt',$condition1);
	
		$mySession->errorMsg="Receipt No. has been deleted successfully";
	$this->_redirect('receiptno/index');
	}	
}
?>
