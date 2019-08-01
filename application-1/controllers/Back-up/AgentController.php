<?php
class AgentController extends Zend_Controller_Action
{	
	/*public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='C' || $mySession->user['userRole']=='AG')
		{ 	
			$this->_redirect('index');	
		}
			
		
	}*/
	public function indexAction()
	{
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'View Agent';
		$where='';
		
		if($mySession->user['branchonly']['isbranch'])
		{
			$where .= " and uag.branchId = '".$mySession->user['branchonly']['branchid']."' ";
		} else {
			if(@$_POST['searchfor_sb']!='') {
				$where .= " and ub.userId = '".$_POST['searchfor_sb']."'";
				$this->view->searchfor_sb = $_POST['searchfor_sb'];
			} else {
				$getbrid = $db->runQuery("select userId from rbi_branch order by mainbranch desc limit 0,1");
				$where .= " and ub.userId = '".$getbrid[0]['userId']."'";
				$this->view->searchfor_sb = $getbrid[0]['userId'];
			}
		}
		unset($mySession->sessionwhere);
		echo $mySession->sessionwhere=$where;
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
		if (!$sortname) $sortname = 'rbi_user.profileId';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where rbi_user.usrRole='AG'";
		if(@$_POST['query']!='')
		{
			$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";
		} 
		if($mySession->user['userRole']=='E') { 
			$where .= " and ue.userId = '".$mySession->user['userId']."' ";
		}		
		$sort = "ORDER BY $sortname $sortorder";	
		
		$where .= $mySession->sessionwhere;
//$mySession->sessionwhere = '';
						
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		 $qry="select rbi_user.*, uag.*, concat(ue.fname,' ',ue.lname) as ename, ue.profileId as eprofileId, ub.fname as bname, ub.profileId as bprofileId, rbi_city.city as cityName, rbi_state.statename
		 from rbi_user
		 inner join rbi_agent as uag on(rbi_user.userid=uag.userId)
		 left join rbi_user as ue on (ue.userId=uag.employeeId)
	     inner join rbi_user as ub on (ub.userId=uag.branchId)		
		 inner join rbi_state on(rbi_user.state=rbi_state.stateid)
		 inner join rbi_city on(rbi_user.city=rbi_city.cityid)
		";	
		
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
			$json .= ",'".changeDate($row['DateofApply'])."'";
			if($row['eprofileId']) { 
				$json .= ",'".$row['ename'].'<br>['.$row['eprofileId']."]'";
			} else {
				$json .= ",'--'";
			}
			$json .= ",'".$row['bname'].'<br>['.$row['bprofileId']."]'";
			
			$json .= ",'".$row['statename']."'";	
			$json .= ",'".$row['cityName']."'";	
			$json .= ",'".$row['address']."'";	
			$json .= ",'".$row['phoneno']."'";
			$json .= ",'".$row['mobno']."'";
			$json .= ",'".changeDate($row['DateofBirth'])."'";
			
			$json .= ",'".$row['qualification']."'";
			$json .= ",'".$row['profession']."'";
			$json .= ",'".$row['pancard']."'";
			$json .= ",'".$row['amount']."'";
			$json .= ",'".$row['emailaddress']."'";	
			if($mySession->user['userRole']=='A' || getsubadmin_role('editagent')) {
				$json .= ",'<a href=\"".APPLICATION_URL."agent/edit/agentId/".$row['userid']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			}
			if($mySession->user['userRole']=='A' || getsubadmin_role('deleteagent')) {
				if($row['userid']==23) {
				$json .= ",'--'";
				} else {
				$json .= ",'<a href=\"".APPLICATION_URL."agent/delete/agentId/".$row['userid']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
				}
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
	$this->view->pagetitle = 'Add Agent';
	$form = new Form_Agent();
	$this->view->Form=$form;
	}
	
	
	public function editAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Edit Advisor';
	$agentId= $this->getRequest()->getParam('agentId');
	$form = new Form_Agent($agentId);
	$this->view->Form=$form;
	$this->view->agentId=$agentId;
	}
	public function updateAction()
	{
	global $mySession;
	$this->view->pagetitle = 'Edit Agent';
	$agentId= $this->getRequest()->getParam('agentId');
	$this->view->agentId=$agentId;
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Agent($agentId);
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
					$myObj=new Model_Agent();
					$ChkResult=$myObj->UpdateAgent($dataForm,$agentId);
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Agent information updated successfully."; 
					$this->_redirect('agent/index');
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
			$this->_redirect('agent/edit/agentId/'.$agentId);
		}
	}
	public function deleteAction()
	{
	global $mySession;
	$db=new Db();
	$agentId= $this->getRequest()->getParam('agentId');
	
	$condition1="userid='".$agentId."'";
	$db->delete('rbi_user',$condition1);
	
	$condition2="userId='".$agentId."'";
	$db->delete('rbi_agent',$condition2);
		
	$mySession->errorMsg="Agent has been deleted successfully";
	$this->_redirect('agent/index');
	}
	public function getbranchagentAction()
	{
		global $mySession;
		$db=new Db();
		$Result=$db->runQuery("select rbi_agent.profileId, rbi_agent.userId,concat(fname,' ',lname) as ag_name from rbi_agent 
		join rbi_user on (rbi_agent.userId=rbi_user.userid)
		where (rbi_agent.branchId='".$_REQUEST['branchId']."' or rbi_agent.userId=23)");
		?>
		<select name="agent_Id" id="agent_Id">
		<option value="">--Agent--</option>
		<?				
		if($Result!="" and count($Result)>0)
		{
			foreach($Result as $key=>$empData)
			{
			?>
			<option value="<?=$empData['userId']?>"><?=$empData['ag_name']?>(<?=$empData['profileId']?>)</option>
			<?
			}
		}
		?>
		</select>
		<?
		exit();
	}
	
	public function getstatecityAction()
	{
		global $mySession;
		$db=new Db();
		$Result=$db->runQuery("select * from rbi_city where stateid='".$_REQUEST['stateId']."'");
		?>
		<select name="city_id" id="city_id">
		<option value="">--City--</option>
		<?				
		if($Result!="" and count($Result)>0)
		{
			foreach($Result as $key=>$cityData)
			{
			?>
			<option value="<?=$cityData['cityid']?>"><?=$cityData['city']?></option>
			<?
			}
		}
		?>
		</select>
		<?
		exit();
	}
}
?>
