<?php
class CustomerController extends Zend_Controller_Action
{
	
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='C')
		{ 	
			$this->_redirect('index');	
		}
	}
	public function listAction()
	{
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Customer List';
		
		$arr=$this->getRequest()->getParams();
		if(isset($arr['searchfor_sb']) && $arr['searchfor_sb']!='') {
			$this->view->searchfor_sb = $arr['searchfor_sb'];
		} else {
			$this->view->searchfor_sb = 5;
		}
		
		if(isset($arr['sel_month']) && $arr['sel_month']!='') {
			$this->view->sel_month = $arr['sel_month'];
		} else {
			$this->view->sel_month = str_pad(date('m'),2,0,STR_PAD_LEFT);
		}
		
		if(isset($arr['sel_year']) && $arr['sel_year']!='') {
			$this->view->sel_year = $arr['sel_year'];
		} else {
			$this->view->sel_year = date('Y');
		}
		$where ='';
		
		$where .= " and rbc.branchId='".$this->view->searchfor_sb."' ";
		
		$dt = $this->view->sel_year.'-'.str_pad($this->view->sel_month,2,0,STR_PAD_LEFT);
		
		$where .= " and u.created_on like '".$dt."-%' ";
		
		$fields = "u.address, u.mobno, concat(u.fname,' ',u.lname) as name, DATE_FORMAT(u.created_on,'%d/%m/%Y') as regdt, u.profileId, rbc.aname, rbc.aprofileid, rbc.bprofileid, rbc.bname, us.title";
		$qry="select ".$fields."
		from rbi_user as u
		inner join rbi_user_customer as rbc on(u.userid=rbc.userId) 
		inner join rbi_user_to_scheme as us on(u.userid=us.userid)		
		where 1 ".$where." order by u.created_on desc, u.userid";
		$result = $db->runQuery($qry);
		$this->view->result = $result;
	}
	public function indexAction()
	{
	global $mySession;
	$db = new Db();
	$this->view->pagetitle = 'View Customer';
	$arr=$this->getRequest()->getParams();
	
	$where='';
	if(isset($_POST['defaultid']) && $_POST['defaultid']!='') {
		$mobj = new Model_Mainmodel();
		
		$dataupd['status']=$_POST['defaultidstatus'];
		$wherecnd="userid='".$_POST['defaultid']."'";
		$mobj->updateThis('rbi_user',$dataupd,$wherecnd);
		
		$dataupd1['custstaus']=$_POST['defaultidstatus'];
		$wherecnd1="userId='".$_POST['defaultid']."'";
		$mobj->updateThis('rbi_user_customer',$dataupd1,$wherecnd1);
			
		}
	if(@$arr['smode']=='1')
	{
	
		$this->view->smode = 1;
		$this->view->searchfor_sb = @$arr['searchfor_sb'];
			if(@$arr['searchfor_sc']!='') {
				$where .= " and u.userid = '".$arr['searchfor_sc']."'";
			} elseif(@$arr['searchfor_sa']!='') {
				$where .= " and rbc.agentId = '".$arr['searchfor_sa']."'";
			} elseif(@$arr['searchfor_sb']!='') {
				$where .= " and rbc.branchId = '".$arr['searchfor_sb']."'";
			}
		
	} elseif(@$arr['smode']=='2') {
		$this->view->smode = 2;
			if(@$arr['searchfor_ac']!='') {
				$getuserid = $db->runQuery("select userid, usrRole from rbi_user where profileId='".$arr['searchfor_ac']."'");
				if(is_array($getuserid) && count($getuserid) > 0) {
					if($getuserid[0]['usrRole']=='C') {
						$where .= " and u.userid = '".$getuserid[0]['userid']."'";
					} elseif($getuserid[0]['usrRole']=='AG') {
						$where .= " and rbc.agentId = '".$getuserid[0]['userid']."'";
					} elseif($getuserid[0]['usrRole']=='B') {
						$where .= " and rbc.branchId = '".$getuserid[0]['userid']."'";
					}
				}
			}
		
	} else {
		$this->view->smode = 1;
		if($mySession->user['branchonly']['isbranch'])
		{
			$this->view->searchfor_sb = $mySession->user['branchonly']['branchid'];
			$where = " and rbc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
		} else {
			$this->view->searchfor_sb = 5;
			$where .= " and rbc.branchId = '5'";
		}
	}
	if($mySession->user['branchonly']['isbranch'])
	{
		$this->view->searchfor_sb = $mySession->user['branchonly']['branchid'];
		$where .= " and rbc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
	}
	if(@$this->view->searchfor_sb=='') {
		$this->view->searchfor_sb = 5;
		$where .= " and rbc.branchId = '5'";
	}
		
		if(@$_POST['scheme_Id']!='') {
			$where .= " and us.schemId = '".$_POST['scheme_Id']."'";
		} elseif(@$_POST['searchfor_scheme_cat']!='') {
			$where .= " and us.scheme_type = '".$_POST['searchfor_scheme_cat']."'";
		}
		/*if(@$_POST['searchreceiptno']!='') {
			$where .= " and usi.receiptno = '".$_POST['searchreceiptno']."'";
		}*/
		if(isset($_REQUEST['chksearchbydate']) && $_REQUEST['chksearchbydate']==1) { 
			$this->view->chksearchbydate = $_REQUEST['chksearchbydate'];
			if(@$_POST['dtmode']!='')
			{
				$this->view->dtmode = $_POST['dtmode'];
				if(@$_POST['dtmode']=='1') {
					$where .= " and u.created_on LIKE '".date('Y-m-d')."%' ";
				} elseif(@$_POST['dtmode']=='2') { 
					$current_day = date("N");
					$days_to_sunday = 7 - $current_day;
					$days_from_monday = $current_day - 1;
					$monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
					$sunday = date("Y-m-d", strtotime("+ {$days_to_sunday} Days"));
	
					$where .= " and u.created_on >= '".$monday."' and u.created_on <= '".$sunday."' ";
				} elseif(@$_POST['dtmode']=='3') { 
					if(@$_POST['dtrangefrom']!='' || @$_POST['dtrangeto']!='')
					{
						if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']!='')
						{
							$dtrangefrom = explode("-",$_POST['dtrangefrom']);
							$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));
							
							$dtrangeto = explode("-",$_POST['dtrangeto']);
							$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));
							
							$where .= " and u.created_on >= '".$firstday."' and u.created_on <= '".$lastday."' ";
						}
						if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']=='')
						{
							$dtrangefrom = explode("-",$_POST['dtrangefrom']);
							$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));
							$where .= " and u.created_on >= '".$firstday."' ";
						}
						if(@$_POST['dtrangefrom']=='' && @$_POST['dtrangeto']!='')
						{
							$dtrangeto = explode("-",$_POST['dtrangeto']);
							$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));
							$where .= " and u.created_on <= '".$lastday."' ";
						}
					
					} 
					
				} elseif(@$_POST['dtmode']=='4') { 
					$firstday = date('Y-m-d',mktime(0,0,0,date('m'),'1',date('Y')));
					$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
					$where .= " and u.created_on >= '".$firstday."' and u.created_on <= '".$lastday."' ";
				}
			} else {
				$where .= " and u.created_on LIKE '".date('Y-m-d')."%' ";
			} 
		}
		if($mySession->user['branchonly']['isbranch'])
		{
			$where .= " and rbc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
		}
		if (!$this->getRequest()->isPost())
		{	
			$this->view->chksearchbydate = 1;
			$this->view->dtmode = 4;
			$firstday = date('Y-m-d',mktime(0,0,0,date('m'),'1',date('Y')));
			$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
			$where .= " and u.created_on >= '".$firstday."' and u.created_on <= '".$lastday."' ";
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
		if (!$sortname) $sortname = 'u.created_on desc, u.userid';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where u.usrRole='C'";
		if(@$_POST['query']!='')
		{
			$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";
		} 
		if($mySession->user['userRole']=='AG') { 
			$where .= " and rbc.agentId = '".$mySession->user['userId']."' ";
		}	
		if($mySession->user['userRole']=='B') { 
			$where .= " and rbc.branchId = '".$mySession->user['userId']."' ";
		}
		if($mySession->user['userRole']=='E') { 
			//$where .= " and ue.userId = '".$mySession->user['userId']."' ";
		}
		$where .= $mySession->sessionwhere;
		////$mySession->sessionwhere = '';
				
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		$fields = "u.userid, u.status as userstatus, DATE_FORMAT(u.created_on,'%d %M %Y') as rdate, concat(u.fname,' ',u.lname) as cname,
				   u.profileId, u.phoneno, u.mobno, u.address, u.emailaddress,
				   us.title, us.landsize, us.timePriodType, us.timePeriod, us.noOfInstallment, 				  
				   rbc.aname as aname, rbc.aprofileid as aprofileId, rbc.bname as bname, rbc.bprofileid as bprofileId,
				   rbc.DateofBirth, rbc.NominiName, rbc.NominiRelation, rbc.PanCartNumber, rbc.Proffession ";
				   
				   // rbi_city.city as cityName, rbi_state.statename,
				   
		$qry="select ".$fields."
		from rbi_user as u
		inner join rbi_user_customer as rbc on(u.userid=rbc.userId)";		
		//if($mySession->user['userRole']=='B' || $mySession->user['userRole']=='E') { 
		//	$qry .=" join rbi_agent as rba on(rba.userId=rbc.agentId)";
		//}		
		
		////--inner join rbi_user_scheme_installment_paid as usi on(usi.user_schemeId=us.user_schemeid and usi.instno=1)
//		inner join rbi_user as ua on (ua.userid=rbc.agentId)
//	    inner join rbi_agent as uag on (uag.userId=ua.userid) 
//	    inner join rbi_user as ub on (ub.userId=uag.branchId)
		$qry .=" 
		inner join rbi_user_to_scheme as us on(u.userid=us.userid)		
		";
		//inner join rbi_state on(u.state=rbi_state.stateid)
		//inner join rbi_city on(u.city=rbi_city.cityid)
		//echo "$qry $where $sort $limit"; exit;
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
			$json .= ",'".$row['cname'].'<br>['.$row['profileId']."]'";
			$json .= ",'".$row['rdate']."'";
			$json .= ",'".$row['aname'].'<br>['.$row['aprofileId']."]'";
			$json .= ",'".$row['title'].'/ L:'.$row['landsize'].'/ '.getinstallmenttimeword($row['timePriodType'],$row['timePeriod'])."'";	
			//$json .= ",'".$row['address'].'<br>'.$row['cityName'].' '.$row['statename']."'";			
			$json .= ",'".$row['noOfInstallment']."'";
			$json .= ",'".$row['phoneno']."'";
			$json .= ",'".$row['mobno']."'";
			$json .= ",'".changeDate($row['DateofBirth'])."'";
			$json .= ",'".$row['emailaddress']."'";	
			$json .= ",'".$row['NominiName']."'";
			$json .= ",'".$row['NominiRelation']."'";
			$json .= ",'".$row['PanCartNumber']."'";
			$json .= ",'".$row['Proffession']."'";
		if($mySession->user['userRole']=='A' || getsubadmin_role('bondcust')) { 
			$json .= ",'<a href=\"".APPLICATION_URL."customer/bond/customerId/".$row['userid']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/paper_icon.gif\" border=\"0\" /></a>'";	
		}	
		if($mySession->user['userRole']=='A' || getsubadmin_role('editcust')) { 
			$json .= ",'<a href=\"".APPLICATION_URL."customer/edit/customerId/".$row['userid']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";	
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('deletecust')) { 		
			$json .= ",'<a href=\"".APPLICATION_URL."customer/delete/customerId/".$row['userid']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";	
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('deletecust')) { 		
			if($row['userstatus']==1) {
				$json .= ",'<span style=\"cursor:pointer\" onclick=\"godefault(".$row['userid'].",0)\"><img title=\"Default\" alt=\"Default\" src=\"".APPLICATION_URL."/images/nodefaultuser.gif\" border=\"0\" /></span>'";	
			} else {
				$json .= ",'<span style=\"cursor:pointer\" onclick=\"godefault(".$row['userid'].",1)\"><img title=\"Default\" alt=\"Default\" src=\"".APPLICATION_URL."/images/defaultuser.gif\" border=\"0\" /></span>'";	
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
	$db=new Db();
	$this->view->pagetitle = 'Add Customer';
		
	$form = new Form_Customer();	
	
	if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			
			$db_validation=1;
			if(trim(@$arr['custid'])!='')
			{
				$qry="select userid from rbi_user where profileId='".trim($arr['custid'])."'";
				$result=$db->runQuery("$qry");
				if(is_array($result) && count($result) > 0)
				{
					$mySession->errorMsg ="This Customer Id already exists."; 
					
					$db_validation=0;
				}
			}
			if ($form->isValid($request->getPost())) 
			{				
				$dataForm=$request->getPost();	
				
				if($dataForm['user_password']!=$dataForm['user_confirm_password'])
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					//$this->view->Form = $Form;
					//$this->render('add');
					$db_validation=0;
				}
				$resultPassbookChk=$db->runQuery("select userId from rbi_user_customer where PassBookNo='".$dataForm['passbookno']."' and PassBookNo!='' and PassBookNo!=0");
				if($resultPassbookChk!="" and count($resultPassbookChk)>0)
				{
					$mySession->errorMsg ="Passbook no. already exists"; 
					//$this->view->Form = $Form;
					//$this->render('add');
					$db_validation=0;
				}
				$checkreceipt=$db->runQuery("select user_installment_Id from rbi_user_scheme_installment_paid where receiptno='".$dataForm['receiptno']."'");
				if($checkreceipt!="" and count($checkreceipt)>0)
				{
					$mySession->errorMsg ="Receipt no. already exists"; 
					//$this->view->Form = $Form;
					//$this->render('add');
					$db_validation=0;
				}
				
				if($mySession->user['userRole']=='E' || $mySession->user['userRole']=='SA') {
					$qry="select id from rbi_receipt where recno='".$dataForm['receiptno']."' and allotto='".$mySession->user['userId']."'";
					$result=$db->runQuery("$qry");
					if(is_array($result) && count($result) > 0)
					{
						
					} else {
						$mySession->errorMsg ="You have not allot this receipt no."; 
						//$this->view->Form = $Form;
						//$this->render('add');
						$db_validation=0;
					}
				}
				
				if($db_validation)
				{			
					$myObj=new Model_Customer();
					$ChkResult=$myObj->InsertCustomer($dataForm);								
					if($ChkResult>0)
					{
					$qry="select profileId from rbi_user where userid='".$ChkResult."'";
					$result=$db->runQuery("$qry");
					
					$message='Your registration successfully on Amardeep Buildhome Ltd. Your a/c no. is '.$result[0]['profileId'];
					sendtosms($dataForm['mobile_number'],$message);
					$mySession->errorMsg ="Customer added successfully.";
					/*if($mySession->user['userRole']=='E' || ($mySession->user['userRole']=='SA' && !getsubadmin_role('printbondcustomer'))) {
						$this->_redirect('customer/index');
					} else { 
						$this->_redirect('customer/bond/customerId/'.$ChkResult);
					}*/
					$this->_redirect('customer/add');
					}
					else
					{						
					$mySession->errorMsg ="Username already exists."; 
					//$this->view->Form = $Form;
					//$this->render('add');
					}	
				}		
			}
			
		}
		$this->view->Form=$form;
	
	}
	public function insertAction()
	{
	global $mySession;
	$db=new Db();
	$this->view->pagetitle = 'Add Customer';
	$arr=$this->getRequest()->getParams();
	
		
	}
	
	public function editAction()
	{
	global $mySession;
	$db = new Db();
	if($mySession->user['userRole']=='A' || getsubadmin_role('editcust'))
	{
	
	} else {
		$this->_redirect('index');	
	}
	
	$this->view->pagetitle = 'Edit Customer';
	$customerId= $this->getRequest()->getParam('customerId');
	$form = new Form_Customer($customerId);
	$this->view->Form=$form;
	$this->view->customerId=$customerId;
		$getcustinfo = $db->runQuery("select * from rbi_user_customer where userId='".$customerId."'");
		if(is_array($getcustinfo) && count($getcustinfo) >0)
		{
			$this->view->custinfo= $getcustinfo[0];
		}
	}
	public function updateAction()
	{
	
	global $mySession;
	if($mySession->user['userRole']=='A' || getsubadmin_role('editcust'))
	{
	
	} else {
		$this->_redirect('index');	
	}
	$db=new Db();
	$this->view->pagetitle = 'Edit Customer';
	$customerId= $this->getRequest()->getParam('customerId');
	$this->view->customerId=$customerId;
		if ($this->getRequest()->isPost())
		{			
			$request=$this->getRequest();
			$Form = new Form_Customer($customerId);
			if ($Form->isValid($request->getPost())) 
			{
				$db_validation=1;				
				$dataForm=$Form->getValues();	
				if($dataForm['user_password']!=$dataForm['user_confirm_password'] and isset($_REQUEST['ChangePass']))
				{
					$mySession->errorMsg ="Password and confirm password should be same."; 
					$this->view->Form = $Form;
					$this->render('edit');
					$db_validation=0;
				}
				$resultPassbookChk=$db->runQuery("select userId from rbi_user_customer where PassBookNo='".$dataForm['passbookno']."' and userId!='".$customerId."' and PassBookNo!='' and PassBookNo!=0");
				if($resultPassbookChk!="" and count($resultPassbookChk)>0)
				{
					$mySession->errorMsg ="Passbook no. already exists"; 
					$this->view->Form = $Form;
					$this->render('edit');
					$db_validation=0;
				}
				
				if($db_validation)
				{							
					$myObj=new Model_Customer();
					$ChkResult=$myObj->UpdateCustomer($dataForm,$customerId);
					if($ChkResult=='1')
					{
					$mySession->errorMsg ="Customer information updated successfully."; 
					$this->_redirect('customer/index');
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
			$this->_redirect('customer/edit/customerId/'.$customerId);
		}
	}
	public function deleteAction()
	{
		global $mySession;
		if($mySession->user['userRole']=='A' || getsubadmin_role('deletecust'))
		{
		
		} else {
			$this->_redirect('index');	
		}
		$db=new Db();
		$customerId= $this->getRequest()->getParam('customerId');
		
		$select_cust = $db->runQuery("select * from `rbi_user` where userid='".$customerId."'");		
		if(is_array($select_cust) && count($select_cust) > 0) 
		{
			$Result=$db->save('arc_rbi_user',$select_cust[0]);
		}
		
		$select_cust = $db->runQuery("select * from `rbi_user_customer` where userId='".$customerId."'");		
		if(is_array($select_cust) && count($select_cust) > 0) 
		{
			$Result=$db->save('arc_rbi_user_customer',$select_cust[0]);
		}
		
		$select_cust = $db->runQuery("select * from `rbi_user_scheme_installment` where userId='".$customerId."'");		
		if(is_array($select_cust) && count($select_cust) > 0) 
		{
			$Result=$db->save('arc_rbi_user_scheme_installment',$select_cust[0]);
		}
		
		$select_cust = $db->runQuery("select * from `rbi_user_scheme_installment_paid` where userId='".$customerId."'");		
		if(is_array($select_cust) && count($select_cust) > 0) 
		{
			foreach($select_cust as $row)
			{
				$Result=$db->save('arc_rbi_user_scheme_installment_paid',$row);			
			}
		}
		
		$select_cust = $db->runQuery("select * from `rbi_user_to_scheme` where userid='".$customerId."'");		
		$Result=$db->save('arc_rbi_user_to_scheme',$select_cust[0]);

		
		$condition1="userid='".$customerId."'";
		$db->delete('rbi_user',$condition1);
		
		$condition2="userId='".$customerId."'";
		$db->delete('rbi_user_customer',$condition2);
		
		$schemeData=$db->runQuery("select * from rbi_user_to_scheme where userid='".$customerId."'");
		if($schemeData!="" and count($schemeData)>0)
		{
			foreach($schemeData as $key=>$schemeValue)
			{
			$condition3="user_schemeId='".$schemeValue['user_schemeid']."'";
			$db->delete('rbi_user_scheme_installment',$condition3);		
			$db->delete('rbi_user_scheme_installment_paid',$condition3);		
			}
		$condition4="userid='".$customerId."'";
		$db->delete('rbi_user_to_scheme',$condition4);
		}
		$mySession->errorMsg="Customer has been deleted successfully";
		$this->_redirect('customer/index');
	}	
	public function bondAction()
	{
	global $mySession;
	if($mySession->user['userRole']=='A' || getsubadmin_role('bondcust'))
	{
	
	} else {
		$this->_redirect('index');	
	}
		
		$customerId= $this->getRequest()->getParam('customerId');
		$db=new Db();
		$this->view->customerId=$customerId;
		
		$BondData=$db->runQuery("select date_format(u.created_on,'%d/%m/%Y') as regDate, date_format(s.expire_on,'%d/%m/%Y') as expire_on_date, concat(u.fname,' ',u.lname) as customerName, u.address, rbi_state.statename, s.installment, s.noOfInstallment, s.user_schemeid,
		rbi_city.city as customerCity, c.profileId, s.timePriodType, s.timePeriod, s.landsize, s.installment, s.ReturnAmount, s.scheme_type,  
		c.agentId as CAgentId, c.aprofileid, c.bprofileid, c.aname, c.bname, c.branchId, s.title, c.NominiName, c.NominiAge, c.NominiRelation
		from rbi_user as u
		inner join rbi_user_customer as c on(c.userId=u.userid)
		inner join rbi_user_to_scheme as s on(s.userid=u.userid)
		left join rbi_city on(u.city=rbi_city.cityid)
		left join rbi_state on(u.state=rbi_state.stateid)
		where u.userid='".$customerId."' and usrRole='C'");
		$this->view->BondData=$BondData;
			
		$this->view->pagetitle = $BondData[0]['customerName']."'s Bond";
		
		//$AgentData=$db->runQuery("select Tbl_Agt.profileId as AgentCode, rbi_branch.profileId as BranchCode, rbi_branch.userid as branchid, (select profileId from rbi_employee where userId=Tbl_Agt.employeeId) as EmpCode from rbi_user as usrTbl inner join rbi_agent as Tbl_Agt on(usrTbl.userid=Tbl_Agt.userId) left join rbi_branch on (rbi_branch.userId=Tbl_Agt.branchId) where usrTbl.userid='".$BondData[0]['CAgentId']."'");
		
		//$AgentData=$db->runQuery("select Tbl_Agt.profileId as AgentCode, rbi_branch.profileId as BranchCode, rbi_branch.userid as branchid, empTbl.profileId as EmpCode from rbi_user as usrTbl inner join rbi_user_customer as rucTbl on(rucTbl.userId=usrTbl.userid) inner join rbi_agent as Tbl_Agt on(rucTbl.agentId=Tbl_Agt.userId) inner join rbi_user as empTbl on (if(rucTbl.agentId=23 and rucTbl.noagentempid!=0,empTbl.userid=rucTbl.noagentempid,empTbl.userid=Tbl_Agt.employeeId)) inner join rbi_employee as empTbl2 on(empTbl2.userId=empTbl.userid) inner join rbi_branch on (rbi_branch.userId=empTbl2.branchId) where usrTbl.userid='".$customerId."'");
		
				
		$qrynextdue = "SELECT DATE_FORMAT(usi.InstallmentDueDate,'%d/%m/%Y') as nextduedate, usi.user_installment_Id as nextdueid FROM rbi_user_scheme_installment as usi where user_schemeId='".$BondData[0]['user_schemeid']."' and instno='2' order by user_installment_Id limit 0,1";
		$extdt = $db->runQuery($qrynextdue);
		
		
		if(is_array($extdt) && count($extdt) < 1) {
			$qrynextdue = "SELECT DATE_FORMAT(usi.InstallmentDueDate,'%d/%m/%Y') as nextduedate, usi.user_installment_Id as nextdueid FROM rbi_user_scheme_installment_paid as usi where user_schemeId='".$BondData[0]['user_schemeid']."' and instno='2' order by user_installment_Id limit 0,1";
			$extdt = $db->runQuery($qrynextdue);
		}
		if(is_array($extdt) && count($extdt) > 0) {
			$this->view->nextduedate=$extdt[0]['nextduedate'];
		} else {
			$this->view->nextduedate='&nbsp;';
		}
		//echo "SELECT InstallmentDueDate FROM rbi_user_scheme_installment as usi where user_schemeId='".$BondData[0]['user_schemeid']."' order by InstallmentDueDate desc limit 0,1";
		$installmentlastdata=$db->runQuery("SELECT date_format(InstallmentDueDate,'%d/%m/%Y') as lastDueDate FROM rbi_user_scheme_installment as usi where user_schemeId='".$BondData[0]['user_schemeid']."' order by InstallmentDueDate desc limit 0,1");
		if(is_array($installmentlastdata) && count($installmentlastdata) < 1) {
			$installmentlastdata=$db->runQuery("SELECT date_format(InstallmentDueDate,'%d/%m/%Y') as lastDueDate FROM rbi_user_scheme_installment_paid as usi where user_schemeId='".$BondData[0]['user_schemeid']."' order by InstallmentDueDate desc limit 0,1");
		}
		$lastinstDate=$installmentlastdata[0]['lastDueDate'];
		$installmentdata=$db->runQuery("SELECT * FROM rbi_user_scheme_installment_paid as usi where user_schemeId='".$BondData[0]['user_schemeid']."' order by user_installment_Id limit 0,1");
		
						
		$this->view->lastinstDate=@$lastinstDate;
		/*$this->view->AgentCode=@$AgentData[0]['AgentCode'];
		$this->view->BranchCode=@$AgentData[0]['BranchCode'];
		$this->view->BranchId=@$AgentData[0]['branchid'];
		$this->view->EmpCode=@$AgentData[0]['EmpCode'];*/
		$this->view->Installment=@$installmentdata[0];
		
	}
	
	public function getschemelistAction()
	{
		global $mySession;
		$db=new Db();
		$Result=$db->runQuery("select * from rbi_scheme where scheme_type='".$_REQUEST['scId']."'");
		?>
		<select name="scheme_Id" id="scheme_Id">
		<option value="">--Scheme--</option>
		<?				
		if($Result!="" and count($Result)>0)
		{
			foreach($Result as $key=>$cityData)
			{
			$sel='';
			if(@$_REQUEST['vl']==$cityData['schemId']) { $sel='selected="selected"'; }
			?>
			<option value="<?=$cityData['schemId']?>" <?=$sel?>><?=@$cityData['title']?>/L:<?=$cityData['landsize']?>/<?=$cityData['installment']?></option>
			<?
			}
		}
		?>
		</select>
		<?
		exit();
	}
	
	public function changeschemeAction()
	{
		
		global $mySession;
		$this->view->pagetitle = 'Change Scheme';
		$db=new Db();
		
		$pid='rb04383105000022';
		$schemeid='56';
		
		$qry="select userid, DATE_FORMAT(created_on,'%d-%m-%Y') as regdate from rbi_user where profileId='".$pid."' and  profileId!=''";	
		$getid=$db->runQuery("$qry");
		echo "<pre>";
		//print_r($getid);
		
		if(is_array($getid) && count($getid) >0)
		{
			$qry="select * from rbi_scheme where schemId='".$schemeid."'";	
			$schemeData=$db->runQuery("$qry");
			//print_r($schemeData);
			//exit;
			$qry="select * from rbi_user_to_scheme where userid='".$getid[0]['userid']."'";	
			$getuserscheme=$db->runQuery("$qry");
			
			
			$qry="select * from rbi_user_scheme_installment_paid where user_schemeId='".$getuserscheme[0]['user_schemeid']."' and Installment_status='1' order by user_installment_Id, instno";	
			$getinstdetail=$db->runQuery("$qry");
			//print_r($getinstdetail);
			if(is_array($getinstdetail) && count($getinstdetail) > 0)
			{
				///update user scheme
				$mydata2 =array('schemId'=>$schemeData[0]['schemId'],
					'title'=>$schemeData[0]['title'],
					'landsize'=>$schemeData[0]['landsize'],
					'timePeriod'=>$schemeData[0]['timePeriod'],
					'timePriodType'=>$schemeData[0]['timePriodType'],
					'installment'=>$schemeData[0]['installment'],
					'agent_commission'=>$schemeData[0]['agent_commission'],
					'noOfInstallment'=>$schemeData[0]['noOfInstallment'],
					'ReturnAmount'=>$schemeData[0]['ReturnAmount'],
					'scheme_type'=>$schemeData[0]['scheme_type'],
					'lastupdate'=>date('Y-m-d H:i:s'));	
				//echo "<pre>";
				//print_r($mydata2);	
				
					$contition2="user_schemeid='".$getuserscheme[0]['user_schemeid']."'";
					$Result=$db->modify('rbi_user_to_scheme',$mydata2,$contition2);
									
				$condition2="user_schemeId='".$getuserscheme[0]['user_schemeid']."'";
				$db->delete('rbi_user_scheme_installment',$condition2);
				
				$condition2="user_schemeId='".$getuserscheme[0]['user_schemeid']."'";
				$db->delete('rbi_user_scheme_installment_paid',$condition2);
		
				//Inserting data in Installment table
				$UsertoSchemeId = $getuserscheme[0]['user_schemeid'];
				print_r($getinstdetail);
				echo $totalpayrec=count($getinstdetail);
				for($i=1;$i<=$schemeData[0]['noOfInstallment'];$i++)
				{
				echo "<br>";
					if($i==1)
					{
					$installmentDueDate=changeDate($getid[0]['regdate']);
					$installmentStatus="1";
					$receiptno=$getinstdetail[0]['receiptno'];
					$regdate = changeDate($getid[0]['regdate']).' 00:00:00';
					//$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid where user_installment_Id!='".@$dataForm['pinsid']."'";
					$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid_paid";
					$maxidresult=$db->runQuery("$qry");	//print_r($dataForm);
				
					if($maxidresult[0]['maxrecno'] < 5000) { $maxid =5000; } else { $maxid =$maxidresult[0]['maxrecno']; }
										
					$transactionno=$maxid;
					$installmentPaidOn=$regdate;
					$installmentPaidBy=$mySession->user['userId'];
					}
					else
					{
						if($i <= $totalpayrec) {
							$m=$i-1;
							echo "<br>";
							echo "I : ".$m." ".$getinstdetail[$m]['receiptno'];
							$installmentStatus=$getinstdetail[$m]['Installment_status'];
							$receiptno=$getinstdetail[$m]['receiptno'];
							$installmentPaidOn=$getinstdetail[$m]['Installment_Paidon'];
							$installmentPaidBy=$getinstdetail[$m]['Installment_Paidby'];
							$transactionno=$getinstdetail[$m]['transactionno'];
						} else {
							$installmentStatus="0";
							$receiptno="0";
							$installmentPaidOn="";
							$installmentPaidBy="";
							$transactionno=0;
						}
						$periodType="";
						if($schemeData[0]['timePriodType']=='0')
						$periodType="DAY";
						if($schemeData[0]['timePriodType']=='1')
						$periodType="MONTH";
						if($schemeData[0]['timePriodType']=='2')
						$periodType="YEAR";
						
						$DueDate=$db->runQuery("SELECT DATE_ADD('".$installmentDueDate."', INTERVAL ".$schemeData[0]['timePeriod']." ".$periodType.") as dueDate");
						$installmentDueDate=$DueDate[0]['dueDate'];
					}
					$mydata3 =array('user_schemeId'=>$UsertoSchemeId,
					'agentId'=>'0',
					'receiptno'=>$receiptno,
					'transactionno'=>$transactionno,
					'instno'=>$i,
					'InstallmentAmount'=>$schemeData[0]['installment'],
					'InstallmentDueDate'=>$installmentDueDate,
					'AgentCommission'=>$schemeData[0]['agent_commission'],
					'Installment_status'=>$installmentStatus,
					'Installment_Paidon'=>$installmentPaidOn,
					'Installment_Paidby'=>$installmentPaidBy);
					print_r($mydata3);
					$Result=$db->save('rbi_user_scheme_installment',$mydata3);
					if($receiptno) {
						$lastid = $db->lastInsertId();
						$expire_condition = "recno='".$receiptno."'";
						$expireDataArray =array('user_inst_Id'=>$lastid);
						$Resultx=$db->modify('rbi_receipt',$expireDataArray,$expire_condition);
					}
				}			
			} else {
				echo 'Pay Multipal Installment';
			}	
			
		}
		exit;
	}
	
}
?>