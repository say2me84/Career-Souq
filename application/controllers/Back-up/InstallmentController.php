<?php
class InstallmentController extends Zend_Controller_Action
{

    public function init() {

        /* Initialize action controller here */

		global $mySession;

		if(!isLogged())

		{ 	

		$this->_redirect('index');	

		}

		if($mySession->user['userRole']=='A' || $mySession->user['userRole']=='AG' || $mySession->user['userRole']=='E' || $mySession->user['userRole']=='C' || getsubadmin_role('installment')) {

		} else {

			$this->_redirect('index');	

		}

		

    }



    public function indexAction(){

		global $mySession;

		$db = new Db();

		$this->view->pagetitle = 'Paid Installment ';

		$where="where Installment_status='1' and usi.instno!=1";

		if(@$_POST['smode']=='1')

			{

				if(@$_POST['searchfor_sc']!='') {

					$where .= " and uc.userId = '".$_POST['searchfor_sc']."'";

				} elseif(@$_POST['searchfor_sa']!='') {

					$where .= " and uc.agentId = '".$_POST['searchfor_sa']."'";

				} elseif(@$_POST['searchfor_se']!='') {

					//$where .= " and (ue.userId = '".$_POST['searchfor_se']."' or (uc.noagentempid = '".$_POST['searchfor_se']."' and uc.agentId='23'))";

				} elseif(@$_POST['searchfor_sb']!='') {

					$where .= " and uc.branchId = '".$_POST['searchfor_sb']."'";

				}

			} elseif(@$_POST['smode']=='2') {

				if(@$_POST['searchfor_ac']!='') {

					$getuserid = $db->runQuery("select userid, usrRole from rbi_user where profileId='".$_POST['searchfor_ac']."'");

					if(is_array($getuserid) && count($getuserid) > 0) {

						if($getuserid[0]['usrRole']=='C') {

							$where .= " and uc.userId = '".$getuserid[0]['userid']."'";

						} elseif($getuserid[0]['usrRole']=='AG') {

							$where .= " and uc.agentId = '".$getuserid[0]['userid']."'";

						} elseif($getuserid[0]['usrRole']=='E') {

							//$where .= " and (ue.userId = '".$getuserid[0]['userid']."' or (uc.noagentempid = '".$getuserid[0]['userid']."' and uc.agentId='23'))";

						} elseif($getuserid[0]['usrRole']=='B') {

							$where .= " and uc.branchId = '".$getuserid[0]['userid']."'";

						}

					}

				}

			
			} else {
				$this->view->smode = 1;
				if($mySession->user['branchonly']['isbranch'])
				{
					$this->view->searchfor_sb = $mySession->user['branchonly']['branchid'];
					$where = " and uc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
				} else {
					$this->view->searchfor_sb = 5;
					$where .= " and uc.branchId = '5'";
				}
			}
			if($mySession->user['branchonly']['isbranch'])
			{
				$this->view->searchfor_sb = $mySession->user['branchonly']['branchid'];
				$where .= " and uc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
			}
			if(@$this->view->searchfor_sb=='') {
				$this->view->searchfor_sb = 5;
				$where .= " and uc.branchId = '5'";
			}

			if(@$_POST['searchreceiptno']!='') {

				$where .= " and usi.receiptno = '".$_POST['searchreceiptno']."'";

			}

			if(isset($_REQUEST['chksearchbydate']) && $_REQUEST['chksearchbydate']==1) { 
			$this->view->chksearchbydate = $_REQUEST['chksearchbydate'];
				if(@$_POST['dtmode']!='')

				{
				$this->view->dtmode = $_POST['dtmode'];
					if(@$_POST['dtmode']=='1') {

						$where .= " and Installment_Paidon LIKE '".date('Y-m-d')."%' ";

					} elseif(@$_POST['dtmode']=='2') { 

						$current_day = date("N");

						$days_to_sunday = 7 - $current_day;

						$days_from_monday = $current_day - 1;

						$monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));

						$sunday = date("Y-m-d", strtotime("+ {$days_to_sunday} Days"));

		

						$where .= " and Installment_Paidon >= '".$monday."' and Installment_Paidon <= '".$sunday."' ";

					} elseif(@$_POST['dtmode']=='3') { 

						if(@$_POST['dtrangefrom']!='' || @$_POST['dtrangeto']!='')

						{

							if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']!='')

							{

								$dtrangefrom = explode("-",$_POST['dtrangefrom']);

								$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));

								

								$dtrangeto = explode("-",$_POST['dtrangeto']);

								$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));

								

								$where .= " and Installment_Paidon >= '".$firstday."' and Installment_Paidon <= '".$lastday."' ";

							}

							if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']=='')

							{

								$dtrangefrom = explode("-",$_POST['dtrangefrom']);

								$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));

								$where .= " and Installment_Paidon >= '".$firstday."' ";

							}

							if(@$_POST['dtrangefrom']=='' && @$_POST['dtrangeto']!='')

							{

								$dtrangeto = explode("-",$_POST['dtrangeto']);

								$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));

								$where .= " and Installment_Paidon <= '".$lastday."' ";

							}

						

						} 

						

					} elseif(@$_POST['dtmode']=='4') { 

						$firstday = date('Y-m-d',mktime(0,0,0,date('m'),'1',date('Y')));

						$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));

						$where .= " and Installment_Paidon >= '".$firstday."' and Installment_Paidon <= '".$lastday."' ";

					}

				} else {

					$where .= " and Installment_Paidon LIKE '".date('Y-m-d')."%' ";

				} 

			}
			if($mySession->user['branchonly']['isbranch'])
			{
				$where .= " and usi.branchId = '".$mySession->user['branchonly']['branchid']."' ";
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
			if (!$this->getRequest()->isPost())
			{	
				$this->view->chksearchbydate = 1;
				$this->view->dtmode = 2;
				$current_day = date("N");

				$days_to_sunday = 7 - $current_day;
				$days_from_monday = $current_day - 1;
				$monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
				$sunday = date("Y-m-d", strtotime("+ {$days_to_sunday} Days"));
				$where .= " and Installment_Paidon >= '".$monday."' and Installment_Paidon <= '".$sunday."' ";
			}
			
			//unset($mySession->sessionwhere);

			//$mySession->sessionwhere=$where;
		if($mySession->user['userRole']=='C')

		{

			$where .= " and uc.userId='".$mySession->user['userId']."'";

		}	

		if($mySession->user['userRole']=='AG') { 

			$where .= " and uc.agentId = '".$mySession->user['userId']."' ";

		}	

		if($mySession->user['userRole']=='B') { 

			$where .= " and uc.branchId = '".$mySession->user['userId']."' ";

		}

		if($mySession->user['userRole']=='E') { 

			//$where .= " and ue.userId = '".$mySession->user['userId']."' ";

		}

		//$where .= $mySession->sessionwhere;
////$mySession->sessionwhere = '';

			

		$sort = "ORDER BY Installment_Paidon ";					

		//if (!$page) $page = 1;

		//if (!$rp) $rp = 10;		

		//$start = (($page-1) * $rp);		

		//$limit = "LIMIT $start, $rp";

		 $qry="select usi.*, usi.user_installment_Id, sum(usi.InstallmentAmount) as totalamount, GROUP_CONCAT(usi.instno) as instnolist, min(instno) as min_instno, max(instno) as max_instno, DATE_FORMAT(Installment_Paidon,'%d %M %Y %h:%i:%s') as paydate, uc.profileId, us.title, us.landsize, us.timePriodType, us.timePeriod  from rbi_user_scheme_installment_paid as usi

			  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)

			  inner join rbi_user_customer as uc on (us.userid=uc.userId)

			  ";

			  $groupby = " group by usi.transactionno ";

			//echo  "$qry $where $groupby $sort";
			//exit;
			$roles=$db->runQuery("$qry $where $groupby $sort ");
			/*echo "<pre>";
			print_r($roles);
exit;*/
			if(is_array($roles) && count($roles) > 0)

			{

				$this->view->result=$roles;

			}
			

	}

	public function unapprovedAction(){

	global $mySession;

	$this->view->pagetitle = 'Unapproved Installment';

		if($mySession->user['userRole']=='A' || getsubadmin_role('approveinstallment'))

		{

			$db=new Db();

			$sortname=$this->getRequest()->sortname;

			$sortorder=$this->getRequest()->sortorder;

			if (!$sortname) $sortname = 'Installment_Paidon';

			if (!$sortorder) $sortorder = 'desc';		

			$where="where Installment_status='2'";

			

			if(@$_POST['filter_rfrom']!='' || @$_POST['filter_rto']!='')

				{

					if(@$_POST['filter_rfrom']!='' && @$_POST['filter_rto']!='')

					{

						$where .= " and usi.receiptno >= '".$_POST['filter_rfrom']."' and usi.receiptno <= '".$_POST['filter_rto']."' ";

					}

					if(@$_POST['filter_rfrom']!='' && @$_POST['filter_rto']=='')

					{

						$where .= " and usi.receiptno >= '".$_POST['filter_rfrom']."' ";

					}

					if(@$_POST['filter_rfrom']=='' && @$_POST['filter_rto']!='')

					{

						$where .= " and usi.receiptno <= '".$_POST['filter_rto']."' ";

					}

				} 

			if(@$_REQUEST['user_profile']!='')

			{	

				$where .= " and usi.Installment_Paidby in (select userid from rbi_user where profileId='".$_REQUEST['user_profile']."')  ";

			}
			if($mySession->user['branchonly']['isbranch'])
			{
				$where .= " and usi.branchId = '".$mySession->user['branchonly']['branchid']."' ";
			}
			if($where=="where Installment_status='2'") {

				//$firstday = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d'),date('Y')));

				//$lastday = date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('d'),date('Y')));

				//$where .= " and Installment_Paidon >= '".$firstday."' and Installment_Paidon <= '".$lastday."' ";

			}				

			$sort = "ORDER BY $sortname $sortorder";		

			$qry="select concat(u.fname,' ',u.lname) as cname, usi.user_installment_Id, u.profileId, usi.InstallmentAmount, usi.receiptno, usi.PaniltyAmount, DATE_FORMAT(Installment_Paidon,'%d %M %Y %h:%i:%s') as paydate, us.timePriodType, us.timePeriod, concat(us.title,'/L:',us.landsize,'/',us.installment) as title, concat(ua.fname,' ',ua.lname) as aname, ua.profileId as aprofileId, concat(ue.fname,' ',ue.lname) as ename, ue.profileId as eprofileId, ub.fname as bname, ub.profileId as bprofileId

			  from rbi_user_scheme_installment as usi

			  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)

			  inner join rbi_user_customer as uc on (us.userid=uc.userId)

			  inner join rbi_user as ua on (ua.userid=uc.agentId)

			  inner join rbi_agent as uag on (uag.userId=ua.userid) 

			  inner join rbi_user as ue on (if(uc.agentId=23 and uc.noagentempid!=0, ue.userId=uc.noagentempid, ue.userId=uag.employeeId))

			  inner join rbi_employee as uemp on (ue.userid=uemp.userId)

			  inner join rbi_user as ub on (ub.userId=uemp.branchId)

			  inner join rbi_user as u on (u.userid=uc.userId)

			  ";

				  //echo $qry.' '.$where.' '.$sort;

				  //exit;

			

			$roles=$db->runQuery("$qry $where $sort");

			if(is_array($roles) && count($roles) > 0)

			{

				$this->view->result=$roles;

			}

	  } else {

		$this->_redirect('index');	

	  }

		  

	}

	public function dueAction(){

     global $mySession;

		$db = new Db();

		$this->view->pagetitle = 'Due Installment ';

		$where='';
		
		if(@$_POST['smode']=='1')

			{

				if(@$_POST['searchfor_sc']!='') {

					$where .= " and uc.userId = '".$_POST['searchfor_sc']."'";

				} elseif(@$_POST['searchfor_sa']!='') {

					$where .= " and uc.agentId = '".$_POST['searchfor_sa']."'";

				} elseif(@$_POST['searchfor_se']!='') {

					//$where .= " and (ue.userId = '".$_POST['searchfor_se']."' or (uc.noagentempid = '".$_POST['searchfor_se']."' and uc.agentId='23'))";

				} elseif(@$_POST['searchfor_sb']!='') {

					$where .= " and uc.branchId = '".$_POST['searchfor_sb']."'";

				}

			} elseif(@$_POST['smode']=='2') {

				if(@$_POST['searchfor_ac']!='') {

					$getuserid = $db->runQuery("select userid, usrRole from rbi_user where profileId='".$_POST['searchfor_ac']."'");

					if(is_array($getuserid) && count($getuserid) > 0) {

						if($getuserid[0]['usrRole']=='C') {

							$where .= " and uc.userId = '".$getuserid[0]['userid']."'";

						} elseif($getuserid[0]['usrRole']=='AG') {

							$where .= " and uc.agentId = '".$getuserid[0]['userid']."'";

						} elseif($getuserid[0]['usrRole']=='E') {

							//$where .= " and (ue.userId = '".$getuserid[0]['userid']."' or (uc.noagentempid = '".$getuserid[0]['userid']."' and uc.agentId='23'))";

						} elseif($getuserid[0]['usrRole']=='B') {

							$where .= " and uc.branchId = '".$getuserid[0]['userid']."'";

						}

					}

				}

			
			} else {
				$this->view->smode = 1;
				if($mySession->user['branchonly']['isbranch'])
				{
					$this->view->searchfor_sb = $mySession->user['branchonly']['branchid'];
					$where = " and uc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
				} else {
					$this->view->searchfor_sb = 5;
					$where .= " and uc.branchId = '5'";
				}
			}
			if($mySession->user['branchonly']['isbranch'])
			{
				$this->view->searchfor_sb = $mySession->user['branchonly']['branchid'];
				$where .= " and uc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
			}
			if(@$this->view->searchfor_sb=='') {
				$this->view->searchfor_sb = 5;
				$where .= " and uc.branchId = '5'";
			}


			if(isset($_REQUEST['chksearchbydate']) && $_REQUEST['chksearchbydate']==1) { 
			$this->view->chksearchbydate = $_REQUEST['chksearchbydate'];
				if(@$_POST['dtmode']!='')

				{
				$this->view->dtmode = $_POST['dtmode'];
					if(@$_POST['dtmode']=='1') {

						$where .= " and usi.InstallmentDueDate = '".date('Y-m-d')."' ";

					} elseif(@$_POST['dtmode']=='2') { 

						$current_day = date("N");

						$days_to_sunday = 7 - $current_day;

						$days_from_monday = $current_day - 1;

						$monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));

						$sunday = date("Y-m-d", strtotime("+ {$days_to_sunday} Days"));

		

						$where .= " and usi.InstallmentDueDate >= '".$monday."' and usi.InstallmentDueDate <= '".$sunday."' ";

					} elseif(@$_POST['dtmode']=='3') { 

						if(@$_POST['dtrangefrom']!='' || @$_POST['dtrangeto']!='')

						{

							if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']!='')

							{

								$dtrangefrom = explode("-",$_POST['dtrangefrom']);

								$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));

								

								$dtrangeto = explode("-",$_POST['dtrangeto']);

								$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));

								

								$where .= " and usi.InstallmentDueDate >= '".$firstday."' and usi.InstallmentDueDate <= '".$lastday."' ";

							}

							if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']=='')

							{

								$dtrangefrom = explode("-",$_POST['dtrangefrom']);

								$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));

								$where .= " and usi.InstallmentDueDate >= '".$firstday."' ";

							}

							if(@$_POST['dtrangefrom']=='' && @$_POST['dtrangeto']!='')

							{

								$dtrangeto = explode("-",$_POST['dtrangeto']);

								$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));

								$where .= " and usi.InstallmentDueDate <= '".$lastday."' ";

							}

						

						} 

						

					} elseif(@$_POST['dtmode']=='4') { 

						$firstday = date('Y-m-d',mktime(0,0,0,date('m'),'1',date('Y')));

						$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));

						$where .= " and usi.InstallmentDueDate >= '".$firstday."' and usi.InstallmentDueDate <= '".$lastday."' ";

					}

				} else {

					$where .= " and usi.InstallmentDueDate = '".date('Y-m-d')."' ";

				} 

			} else {

				$firstday = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

				$lastday = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+15,date('Y')));

				$where .= " and usi.InstallmentDueDate >= '".$firstday."' and usi.InstallmentDueDate <= '".$lastday."' ";

			}

			

			if(isset($_REQUEST['chksearchbyperiod']) && is_array($_REQUEST['chksearchbyperiod']) && count($_REQUEST['chksearchbyperiod']) > 0) {

				$tptype = implode(",",$_REQUEST['chksearchbyperiod']);

				$where .= " and us.timePriodType in (".$tptype.") ";

			}

			unset($mySession->sessionwhere);

			$mySession->sessionwhere=$where;

			

			

			$sortname=$this->getRequest()->sortname;

			$sortorder=$this->getRequest()->sortorder;

			if (!$sortname) $sortname = 'usi.InstallmentDueDate';

			if (!$sortorder) $sortorder = 'asc';		

			$where="where usi.Installment_status='0' and us.timePriodType !='0' and uc.custstaus='1' ";

			 

			if($mySession->user['userRole']=='C')

			{

				$where .= " and usi.userId='".$mySession->user['userId']."'";

			}	

			if($mySession->user['userRole']=='AG') { 

				$where .= " and usi.agentId = '".$mySession->user['userId']."' ";

			}	

			if($mySession->user['userRole']=='B') { 

				$where .= " and usi.branchId = '".$mySession->user['userId']."' ";

			}

			if($mySession->user['userRole']=='E') { 

				$where .= " and usi.empId = '".$mySession->user['userId']."' ";

			}
			if($mySession->user['branchonly']['isbranch'])
			{
				$where .= " and usi.branchId = '".$mySession->user['branchonly']['branchid']."' ";
			}
			$where .= $mySession->sessionwhere;
//$mySession->sessionwhere = '';

				

			$sort = "ORDER BY $sortname $sortorder";					

			

		

			/*$qry="select usi.*, concat(u.fname,' ',u.lname) as cname, u.mobno, DATE_FORMAT(InstallmentDueDate,'%d %M %Y') as duedate, uc.profileId, us.title, us.landsize, us.timePriodType, us.timePeriod, concat(ua.fname,' ',ua.lname) as aname, ua.profileId as aprofileId, concat(ue.fname,' ',ue.lname) as ename, ue.profileId as eprofileId, ub.fname as bname, ub.profileId as bprofileId  from rbi_user_scheme_installment as usi

				  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)

				  inner join rbi_user_customer as uc on (us.userid=uc.userId)

				  inner join rbi_user as ua on (ua.userid=uc.agentId)

				  inner join rbi_agent as uag on (uag.userId=ua.userid) 

				 inner join rbi_user as ue on (if(uc.agentId=23 and uc.noagentempid!=0, ue.userId=uc.noagentempid, ue.userId=uag.employeeId))

				  inner join rbi_employee as uemp on (ue.userid=uemp.userId)

				  inner join rbi_user as ub on (ub.userId=uemp.branchId)

				  inner join rbi_user as u on (u.userid=uc.userId) ";*/
			
			$qry="select usi.*, DATE_FORMAT(InstallmentDueDate,'%d %M %Y') as duedate, uc.profileId, us.title, us.landsize, us.timePriodType, us.timePeriod from rbi_user_scheme_installment as usi

				  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)

				  inner join rbi_user_customer as uc on (us.userid=uc.userId)

				  ";
				  

			//echo $qry.' '.$where.' '.$sort;	  
			//exit;
			

			$roles=$db->runQuery("$qry $where $sort ");
			//echo "<pre>";
			//print_r($roles);
//exit;
			if(is_array($roles) && count($roles) > 0)

			{

				$this->view->result=$roles;

			}

			

    }

	public function duedailyAction(){

     global $mySession;

		$db = new Db();
		

		$this->view->pagetitle = 'Due Daily Installment ';

		$where='';

		if(@$_POST['smode']=='1')

			{

				if(@$_POST['searchfor_sc']!='') {

					$where .= " and uc.userId = '".$_POST['searchfor_sc']."'";

				} elseif(@$_POST['searchfor_sa']!='') {

					$where .= " and uc.agentId = '".$_POST['searchfor_sa']."'";

				} elseif(@$_POST['searchfor_se']!='') {

					//$where .= " and (ue.userId = '".$_POST['searchfor_se']."' or (uc.noagentempid = '".$_POST['searchfor_se']."' and uc.agentId='23'))";

				} elseif(@$_POST['searchfor_sb']!='') {

					$where .= " and uc.branchId = '".$_POST['searchfor_sb']."'";

				}

			} elseif(@$_POST['smode']=='2') {

				if(@$_POST['searchfor_ac']!='') {

					$getuserid = $db->runQuery("select userid, usrRole from rbi_user where profileId='".$_POST['searchfor_ac']."'");

					if(is_array($getuserid) && count($getuserid) > 0) {

						if($getuserid[0]['usrRole']=='C') {

							$where .= " and uc.userId = '".$getuserid[0]['userid']."'";

						} elseif($getuserid[0]['usrRole']=='AG') {

							$where .= " and uc.agentId = '".$getuserid[0]['userid']."'";

						} elseif($getuserid[0]['usrRole']=='E') {

							//$where .= " and (ue.userId = '".$getuserid[0]['userid']."' or (uc.noagentempid = '".$getuserid[0]['userid']."' and uc.agentId='23'))";

						} elseif($getuserid[0]['usrRole']=='B') {

							$where .= " and uc.branchId = '".$getuserid[0]['userid']."'";

						}

					}

				}

			
			} else {
				$this->view->smode = 1;
				if($mySession->user['branchonly']['isbranch'])
				{
					$this->view->searchfor_sb = $mySession->user['branchonly']['branchid'];
					$where = " and uc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
				} else {
					$this->view->searchfor_sb = 5;
					$where .= " and uc.branchId = '5'";
				}
			}
			if($mySession->user['branchonly']['isbranch'])
			{
				$this->view->searchfor_sb = $mySession->user['branchonly']['branchid'];
				$where .= " and uc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
			}
			if(@$this->view->searchfor_sb=='') {
				$this->view->searchfor_sb = 5;
				$where .= " and uc.branchId = '5'";
			}

			

			if(isset($_REQUEST['chksearchbydate']) && $_REQUEST['chksearchbydate']==1) { 
				$this->view->chksearchbydate = $_REQUEST['chksearchbydate'];
					if(@$_POST['dtmode']!='')
					{
						$this->view->dtmode = $_POST['dtmode'];
						$where .= " and InstallmentDueDate = '".date('Y-m-d')."' ";

					} elseif(@$_POST['dtmode']=='2') { 

						$current_day = date("N");

						$days_to_sunday = 7 - $current_day;

						$days_from_monday = $current_day - 1;

						$monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));

						$sunday = date("Y-m-d", strtotime("+ {$days_to_sunday} Days"));

		

						$where .= " and InstallmentDueDate >= '".$monday."' and InstallmentDueDate <= '".$sunday."' ";

					} elseif(@$_POST['dtmode']=='3') { 

						if(@$_POST['dtrangefrom']!='' || @$_POST['dtrangeto']!='')

						{

							if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']!='')

							{

								$dtrangefrom = explode("-",$_POST['dtrangefrom']);

								$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));

								

								$dtrangeto = explode("-",$_POST['dtrangeto']);

								$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));

								

								$where .= " and InstallmentDueDate >= '".$firstday."' and InstallmentDueDate <= '".$lastday."' ";

							}

							if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']=='')

							{

								$dtrangefrom = explode("-",$_POST['dtrangefrom']);

								$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));

								$where .= " and InstallmentDueDate >= '".$firstday."' ";

							}

							if(@$_POST['dtrangefrom']=='' && @$_POST['dtrangeto']!='')

							{

								$dtrangeto = explode("-",$_POST['dtrangeto']);

								$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));

								$where .= " and InstallmentDueDate <= '".$lastday."' ";

							}

						

						} 

						

					} elseif(@$_POST['dtmode']=='4') { 

						$firstday = date('Y-m-d',mktime(0,0,0,date('m'),'1',date('Y')));

						$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));

						$where .= " and InstallmentDueDate >= '".$firstday."' and InstallmentDueDate <= '".$lastday."' ";

					}

				 

			} else {

				$firstday = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));

				$lastday = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+15,date('Y')));

				$where .= " and InstallmentDueDate >= '".$firstday."' and InstallmentDueDate <= '".$lastday."' ";

			}

			if (!$this->getRequest()->isPost())
			{	
				$this->view->chksearchbydate = 1;
				$this->view->dtmode = 4;
				$firstday = date('Y-m-d',mktime(0,0,0,date('m'),'1',date('Y')));
				$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
				$where .= " and InstallmentDueDate >= '".$firstday."' and InstallmentDueDate <= '".$lastday."' ";
			}

			if(isset($_REQUEST['chksearchbyperiod']) && is_array($_REQUEST['chksearchbyperiod']) && count($_REQUEST['chksearchbyperiod']) > 0) {

				$tptype = implode(",",$_REQUEST['chksearchbyperiod']);

				$where .= " and us.timePriodType in (".$tptype.") ";

			}

			unset($mySession->sessionwhere);

			$mySession->sessionwhere=$where;

			

			

			$sortname=$this->getRequest()->sortname;

			$sortorder=$this->getRequest()->sortorder;

			if (!$sortname) $sortname = 'InstallmentDueDate';

			if (!$sortorder) $sortorder = 'asc';		

			$where="where Installment_status='0' and us.timePriodType ='0' and uc.custstaus='1'";

			 

			if($mySession->user['userRole']=='C')

			{

				$where .= " and uc.userId='".$mySession->user['userId']."'";

			}	

			if($mySession->user['userRole']=='AG') { 

				$where .= " and uc.agentId = '".$mySession->user['userId']."' ";

			}	

			if($mySession->user['userRole']=='B') { 

				//$where .= " and ub.userId = '".$mySession->user['userId']."' ";

			}

			if($mySession->user['userRole']=='E') { 

				$where .= " and ue.userId = '".$mySession->user['userId']."' ";

			}
			if($mySession->user['branchonly']['isbranch'])
			{
				$where .= " and usi.branchId = '".$mySession->user['branchonly']['branchid']."' ";
			}
			$where .= $mySession->sessionwhere;
//$mySession->sessionwhere = '';

				

			$sort = "ORDER BY $sortname $sortorder";					

			

		

			$qry="select usi.*, concat(u.fname,' ',u.lname) as cname, u.mobno, DATE_FORMAT(InstallmentDueDate,'%d %M %Y') as duedate, uc.profileId, us.title, us.landsize, us.timePriodType, us.timePeriod, concat(ua.fname,' ',ua.lname) as aname, ua.profileId as aprofileId, concat(ue.fname,' ',ue.lname) as ename, ue.profileId as eprofileId, ub.fname as bname, ub.profileId as bprofileId  from rbi_user_scheme_installment as usi

				  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)

				  inner join rbi_user_customer as uc on (us.userid=uc.userId)

				   ";

				  $groupby = ' Group by usi.user_schemeId ';

			echo $qry.' '.$where.' '.$groupby.' '.$sort;	

			exit;  

			$roles=$db->runQuery("$qry $where $groupby $sort ");

			if(is_array($roles) && count($roles) > 0)

			{

				$this->view->result=$roles;

			}

			

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

		if (!$sortname) $sortname = 'Installment_Paidon';

		if (!$sortorder) $sortorder = 'desc';		

		$where="where Installment_status='1' and usi.instno!=1";

		if(@$_POST['query']!='')

		{

			if($_POST['qtype']=='paydate') {

				$dtar = array();

				if(strstr($_POST['query'],"/"))

				{

					$dtar = explode("/",$_POST['query']);

				} elseif(strstr($_POST['query'],"-")) {

					$dtar = explode("-",$_POST['query']);

				}

				if(count($dtar)==3) {

					$firstday = date('Y-m-d H:i:s',mktime(0,0,0,$dtar[1],$dtar[0],$dtar[2]));

					$lastday = date('Y-m-d H:i:s',mktime(23,59,59,$dtar[1],$dtar[0],$dtar[2]));

					

					$where .= " and Installment_Paidon >= '".$firstday."' and Installment_Paidon <= '".$lastday."' ";

				}

			} else {

				$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";

			}

		} 

		if($mySession->user['userRole']=='C')

		{

			$where .= " and uc.userId='".$mySession->user['userId']."'";

		}	

		if($mySession->user['userRole']=='AG') { 

			$where .= " and uc.agentId = '".$mySession->user['userId']."' ";

		}	

		if($mySession->user['userRole']=='B') { 

			$where .= " and uc.branchId = '".$mySession->user['userId']."' ";

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

		 $qry="select usi.*, usi.user_installment_Id, sum(usi.InstallmentAmount) as totalamount, GROUP_CONCAT(usi.instno) as instnolist, min(instno) as min_instno, max(instno) as max_instno, DATE_FORMAT(Installment_Paidon,'%d %M %Y %h:%i:%s') as paydate, uc.profileId, us.title, us.landsize, us.timePriodType, us.timePeriod  from rbi_user_scheme_installment_paid as usi

			  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)

			  inner join rbi_user_customer as uc on (us.userid=uc.userId)

			  ";

			  $groupby = " group by usi.transactionno ";

			/*echo  "$qry $where $groupby $sort $limit";
			exit;*/

		$roles=$db->runQuery("$qry $where $groupby $sort $limit");

		$countQuery=$db->runQuery("$qry $where $groupby");		

		$total=count($countQuery);		

		$json = "";

		$json .= "{\n";

		$json .= "page: $page,\n";

		$json .= "total: $total,\n";

		$json .= "rows: [";

		$rc = false;

		if(isset($roles[0]) && $roles[0]['user_installment_Id']!="")

		{

		$i=1;

		foreach($roles as $row)

		{			

			if ($rc) $json .= ",";

			$json .= "\n{";

			$json .= "id:'".$row['user_installment_Id']."',";

			$json .= "cell:['".$i."'";

			$json .= ",'".getusername($row['userId']).'<br>'.getprofileid($row['userId'])."'";

			$json .= ",'".$row['title'].'/ L:'.$row['landsize'].'/ '.getinstallmenttimeword($row['timePriodType'],$row['timePeriod'])."'";

			

			if($row['min_instno']==$row['max_instno']) {

				$json .= ",'".$row['instno']."'";

			} else {

				$json .= ",'".$row['min_instno']." - ".$row['max_instno']."'";

			}

			$json .= ",'".$row['receiptno']."'";

			$json .= ",'".$row['transactionno']."'";

			$json .= ",'".$row['totalamount']."'";

			$json .= ",'".$row['PaniltyAmount']."'";

			$json .= ",'".($row['totalamount']+$row['PaniltyAmount'])."'";

			$json .= ",'".$row['paydate']."'";	

				

			//if($mySession->user['userRole']=='A' || getsubadmin_role('reportpayreceipt')) { 

				$json .= ",'<a href=\"".APPLICATION_URL."pay/receipt/receiptId/".$row['user_installment_Id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/paper_icon.gif\" border=\"0\" /></a>'";	

			//}		

			//".APPLICATION_URL."installment/cancelreceipt/receiptId/".$row['user_installment_Id']."

			if($mySession->user['userRole']=='A') { 

				$json .= ",'<a onclick=\"if(confirm(\'Are You Sure\')) { window.location=\'".APPLICATION_URL."installment/cancelreceipt/receiptId/".$row['user_installment_Id']."\'; }\" href=\"#\"><img title=\"Cancel Receipt\" alt=\"Cancel Receipt\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";	

			}		

			//$json .= ",'<a href=\"".APPLICATION_URL."employee/edit/employeeId/".$row['user_installment_Id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			

			//$json .= ",'<a href=\"".APPLICATION_URL."employee/delete/employeeId/".$row['user_installment_Id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			

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

	public function generategrid2Action()

	{		

		global $_CONFIG, $mySession;

		$this->_helper->viewRenderer->setNoRender();

		$db=new Db();

		$page=$this->getRequest()->page;

		$rp=$this->getRequest()->rp;

		$sortname=$this->getRequest()->sortname;

		$sortorder=$this->getRequest()->sortorder;

		if (!$sortname) $sortname = 'InstallmentDueDate';

		if (!$sortorder) $sortorder = 'asc';		

		$where="where Installment_status='0'";

		if(@$_POST['query']!='')

		{

			if($_POST['qtype']=='paydate') {

				$dtar = array();

				if(strstr($_POST['query'],"/"))

				{

					$dtar = explode("/",$_POST['query']);

				} elseif(strstr($_POST['query'],"-")) {

					$dtar = explode("-",$_POST['query']);

				}

				if(count($dtar)==3) {

					$firstday = date('Y-m-d H:i:s',mktime(0,0,0,$dtar[1],$dtar[0],$dtar[2]));

					$lastday = date('Y-m-d H:i:s',mktime(23,59,59,$dtar[1],$dtar[0],$dtar[2]));

					

					$where .= " and Installment_Paidon >= '".$firstday."' and Installment_Paidon <= '".$lastday."' ";

				}

			} else {

				$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";

			}

		} 

		if($mySession->user['userRole']=='C')

		{

			$where .= " and uc.userId='".$mySession->user['userId']."'";

		}	

		if($mySession->user['userRole']=='AG') { 

			$where .= " and uag.userId = '".$mySession->user['userId']."' ";

		}	

		if($mySession->user['userRole']=='B') { 

			$where .= " and ub.userId = '".$mySession->user['userId']."' ";

		}

		if($mySession->user['userRole']=='E') { 

			$where .= " and ue.userId = '".$mySession->user['userId']."' ";

		}

		$where .= $mySession->sessionwhere;
//$mySession->sessionwhere = '';

			

		$sort = "ORDER BY $sortname $sortorder";					

		if (!$page) $page = 1;

		if (!$rp) $rp = 10;		

		$start = (($page-1) * $rp);		

		$limit = "LIMIT $start, $rp";

		$qry="select usi.*, concat(u.fname,' ',u.lname) as cname, DATE_FORMAT(InstallmentDueDate,'%d %M %Y') as duedate, uc.profileId, us.title, us.landsize, us.timePriodType, us.timePeriod, concat(ua.fname,' ',ua.lname) as aname, ua.profileId as aprofileId, concat(ue.fname,' ',ue.lname) as ename, ue.profileId as eprofileId, ub.fname as bname, ub.profileId as bprofileId  from rbi_user_scheme_installment as usi

			  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)

			  inner join rbi_user_customer as uc on (us.userid=uc.userId)

			  inner join rbi_user as ua on (ua.userid=uc.agentId)

			  inner join rbi_agent as uag on (uag.userId=ua.userid) 

			 inner join rbi_user as ue on (if(uc.agentId=23 and uc.noagentempid!=0, ue.userId=uc.noagentempid, ue.userId=uag.employeeId))

			  inner join rbi_employee as uemp on (ue.userid=uemp.userId)

			  inner join rbi_user as ub on (ub.userId=uemp.branchId)

			  inner join rbi_user as u on (u.userid=uc.userId) ";

			  

		//echo $qry.' '.$where.' '.$sort;	  

		$roles=$db->runQuery("$qry $where $sort $limit");

		$countQuery=$db->runQuery("$qry $where");		

		$total=count($countQuery);		

		$json = "";

		$json .= "{\n";

		$json .= "page: $page,\n";

		$json .= "total: $total,\n";

		$json .= "rows: [";

		$rc = false;

		if(isset($roles[0]) && $roles[0]['user_installment_Id']!="")

		{

		$i=1;

		foreach($roles as $row)

		{			

			if ($rc) $json .= ",";

			$json .= "\n{";

			$json .= "id:'".$row['user_installment_Id']."',";

			$json .= "cell:['".$i."'";

			$json .= ",'".$row['cname'].'<br>'.$row['profileId']."'";

			$json .= ",'".$row['aname'].'<br>'.$row['aprofileId']."'";

			$json .= ",'".$row['ename'].'<br>'.$row['eprofileId']."'";

			$json .= ",'".$row['duedate']."'";	

			$json .= ",'".$row['title'].'/ L:'.$row['landsize'].'/ '.getinstallmenttimeword($row['timePriodType'],$row['timePeriod'])."'";

			$json .= ",'".$row['instno']."'";

			$json .= ",'".$row['InstallmentAmount']."'";

			

			

				

			//if($mySession->user['userRole']=='A' || getsubadmin_role('reportpayreceipt')) { 

				$json .= ",'<a href=\"".APPLICATION_URL."pay/receipt/receiptId/".$row['user_installment_Id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/paper_icon.gif\" border=\"0\" /></a>'";	

			//}		

			//$json .= ",'<a href=\"".APPLICATION_URL."employee/edit/employeeId/".$row['user_installment_Id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			

			//$json .= ",'<a href=\"".APPLICATION_URL."employee/delete/employeeId/".$row['user_installment_Id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			

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

	public function cancelreceiptAction()

	{

	global $mySession;

	$receiptId=$this->getRequest()->receiptId;	

		if($mySession->user['userRole']=='A')

		{
		

			if($receiptId) {			

				$db=new Db();

				$Result=$db->runQuery("select * from rbi_user_scheme_installment where user_installment_Id='".$receiptId."'");

				if(is_array($Result) && count($Result) > 0)

				{

					$modelobj = new Model_Mainmodel();

					

					$Data= array();

					$Data['user_installment_Id']=$Result[0]['user_installment_Id'];

					$Data['user_schemeId']=$Result[0]['user_schemeId'];

					$Data['receiptno']=$Result[0]['receiptno'];

					$Data['instno']=$Result[0]['instno'];

					$Data['transactionno']=$Result[0]['transactionno'];

					$Data['agentId']=$Result[0]['agentId'];

					$Data['InstallmentAmount']=$Result[0]['InstallmentAmount'];

					$Data['InstallmentDueDate']=$Result[0]['InstallmentDueDate'];

					$Data['AgentCommission']=$Result[0]['AgentCommission'];

					$Data['Installment_status']=$Result[0]['Installment_status'];

					$Data['Installment_Paidon']=$Result[0]['Installment_Paidon'];

					$Data['PaniltyAmount']=$Result[0]['PaniltyAmount'];

					$Data['Installment_Paidby']=$Result[0]['Installment_Paidby'];

					$Data['ApprovedBy']=$Result[0]['ApprovedBy'];

					$Data['Installment_cancelon']=date('Y-m-d h:i:s');

					

					$insertdata=$modelobj->insertThis('rbi_user_scheme_installment_cancel',$Data);

					

					$Data= array();

					$Data['transactionno']=0;
					$Data['receiptno']=0;
					$Data['Installment_Paidon']='0000-00-00 00:00:00';

					$Data['PaniltyAmount']=0;

					$Data['Installment_Paidby']=0;

					$Data['Installment_status']=0;

					

					$where="user_installment_Id='".$receiptId."'";

					$insertdata=$modelobj->updateThis('rbi_user_scheme_installment',$Data,$where);

					$mySession->errorMsg="Receipt has been canceled successfully";

		exit;
					$this->_redirect('installment/index');

				}

			}

		}

		exit;	

	}

	

	public function getbranchempAction()
	{
		global $mySession;

		$db=new Db();

		$Result=$db->runQuery("select rbi_employee.profileId, rbi_employee.userId,concat(fname,' ',lname) as emp_name from rbi_employee 

		join rbi_user on (rbi_employee.userId=rbi_user.userid)

		where rbi_employee.branchId='".@$_REQUEST['branchId']."'");

		?>

		<select name="searchfor_se" id="searchfor_se" onchange="getEmployeeAgent(this.value,0)">

		<option value="">--Select Employee--</option>

		<?				

		if($Result!="" and count($Result)>0)

		{

			foreach($Result as $key=>$empData)

			{

			$sel='';

			if(@$_REQUEST['vl']==$empData['userId']) { $sel='selected="selected"'; }

			?>

			<option value="<?=$empData['userId']?>" <?=$sel?>><?=$empData['emp_name']?>(<?=$empData['profileId']?>)</option>

			<?

			}

		}

		?>

		</select>

		<?

		exit();

	}

	

	public function getempagentAction()

	{

		global $mySession;

		$db=new Db();

		$Result=$db->runQuery("select rbi_agent.profileId, rbi_agent.userId,concat(fname,' ',lname) as agent_name from rbi_agent 

		join rbi_user on (rbi_agent.userId=rbi_user.userid)

		where rbi_agent.employeeId='".$_REQUEST['empId']."'");

		?>

		<select name="searchfor_sa" id="searchfor_sa" onchange="getAgentCustomer(this.value,0)">

		<option value="">--Select Advisor--</option>

		<?				

		if($Result!="" and count($Result)>0)

		{

			foreach($Result as $key=>$empData)

			{

			$sel='';

			if(@$_REQUEST['vl']==$empData['userId']) { $sel='selected="selected"'; }

			?>

			<option value="<?=$empData['userId']?>" <?=$sel?>><?=$empData['agent_name']?>(<?=$empData['profileId']?>)</option>

			<?

			}

		}

		?>

		</select>

		<?

		exit();

	}

	

	public function getagentcustAction()

	{

		global $mySession;

		$db=new Db();

		

		$Result=$db->runQuery("select rbi_user_customer.profileId, rbi_user_customer.userId,concat(fname,' ',lname) as cust_name from rbi_user_customer 

		join rbi_user on (rbi_user_customer.userId=rbi_user.userid)

		where rbi_user_customer.agentId ='".$_REQUEST['agentId']."'");

		?>

		<select name="searchfor_sc" id="searchfor_sc" >

		<option value="">--Select Customer--</option>

		<?				

		if($Result!="" and count($Result)>0)

		{

			foreach($Result as $key=>$empData)

			{

			$sel='';

			if(@$_REQUEST['vl']==$empData['userId']) { $sel='selected="selected"'; }

			?>

			<option value="<?=$empData['userId']?>" <?=$sel?>><?=$empData['cust_name']?>(<?=$empData['profileId']?>)</option>

			<?

			}

		}

		?>

		</select>

		<?

		exit();

	}

	public function approveinstallmentAction()

	{

		global $mySession;

		$db=new Db();		

		if(isset($_REQUEST['chk']) and count($_REQUEST['chk'])>0)

		{

			foreach($_REQUEST['chk'] as $key=>$myId)

			{

				$data=array();

				$data['Installment_status']='1';

				$data['ApprovedBy']=$mySession->user['userId'];				

				$condition=" user_installment_Id='".$myId."'";

				$db->modify('rbi_user_scheme_installment',$data,$condition);								

			}		

		}

		$mySession->errorMsg ="Selected installments approved successfully."; 

		$this->_redirect(APPLICATION_URL.'installment/unapproved');		

	}

}

?>

