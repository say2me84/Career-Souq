<?php
class ReportController extends Zend_Controller_Action
{
    public function init() 
	{
        /* Initialize action controller here */
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('report'))
		{
		} else {
			$this->_redirect('index');	
		}
		
    }

    public function indexAction()
	{
        global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Collection Report';
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'Installment_Paidon, receiptno';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where Installment_status='1'";
		if(@$_POST['searchfor_sb']!='') {
			$this->view->searchfor_sb = $_POST['searchfor_sb'];
		} else {
			if($mySession->user['branchonly']['isbranch'])
			{
				$this->view->searchfor_sb = $mySession->user['branchonly']['isbranch'];
			} else {
				$this->view->searchfor_sb = 5;
			}
		}
		$where .= " and uc.branchId = '".$this->view->searchfor_sb."'";
		if(@$_POST['smode']=='1')
		{
			if(@$_POST['searchfor_sc']!='') {
				$where .= " and us.userid = '".$_POST['searchfor_sc']."'";
			} elseif(@$_POST['searchfor_sa']!='') {
				$where .= " and uc.agentId = '".$_POST['searchfor_sa']."'";
			} elseif(@$_POST['searchfor_se']!='') {
				//$where .= " and (ue.userId = '".$_POST['searchfor_se']."' or (uc.noagentempid = '".$_POST['searchfor_se']."' and uc.agentId='23'))";
			} 
		} elseif(@$_POST['smode']=='2') {
			if(@$_POST['searchfor_ac']!='') {
				$getuserid = $db->runQuery("select userid, usrRole from rbi_user where profileId='".$_POST['searchfor_ac']."'");
				if(is_array($getuserid) && count($getuserid) > 0) {
					if($getuserid[0]['usrRole']=='C') {
						$where .= " and us.userid = '".$getuserid[0]['userid']."'";
					} elseif($getuserid[0]['usrRole']=='AG') {
						$where .= " and uc.agentId = '".$getuserid[0]['userid']."'";
					} elseif($getuserid[0]['usrRole']=='E') {
						//$where .= " and (ue.userId = '".$getuserid[0]['userid']."' or (uc.noagentempid = '".$getuserid[0]['userid']."' and uc.agentId='23'))";
					} 
				}
			}
		}
		
		if(@$_POST['dtmode']!='')
		{
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
		if($mySession->user['branchonly']['isbranch'])
		{
			$where .= " and uc.branchId = '".$mySession->user['branchonly']['branchid']."' ";
		}
		$sort = "ORDER BY $sortname $sortorder";					
		$groupby = "Group by usi.transactionno";
		$qry="select usi.user_installment_Id, usi.instno, sum(usi.InstallmentAmount) as InstallmentAmount, usi.InstallmentAmount as finst, min(instno) as miinstno, usi.payamt, max(usi.PaniltyAmount) PaniltyAmount, DATE_FORMAT(Installment_Paidon,'%d/%m/%Y') as paydate, usi.receiptno, uc.userid, us.timePriodType, us.timePeriod, concat(us.title,'/L:',us.landsize) as title, uc.profileId, uc.aname, uc.aprofileid, uc.bname, uc.bprofileid
			  from rbi_user_scheme_installment_paid as usi
			  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)
			  inner join rbi_user_customer as uc on (us.userid=uc.userId)
			  
			  ";
			  /*$qry="";*/
			//echo "$qry $where $groupby $sort"; 
			//exit;
		$roles=$db->runQuery("$qry $where $groupby $sort");
		if(is_array($roles) && count($roles) > 0)
		{
			$this->view->result=$roles;
		}
		
    }
	public function agentcollectionAction() 
	{
		global $mySession;
		$db = new Db();
		
		$this->view->pagetitle = 'Agent wise report ';
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
		$where .= " and branchId='".$this->view->searchfor_sb."' ";
		$dt = $this->view->sel_year.'-'.str_pad($this->view->sel_month,2,0,STR_PAD_LEFT);
		$where .= " and Installment_Paidon like '".$dt."-%' ";
		
		$qry =$db->runQuery("select distinct(agentId) agids from rbi_user_scheme_installment_paid where 1 ".$where." order by agentId");
		$this->view->result = $qry;
		$this->view->where  = $where;
		
	}
	public function changedateofreceiptAction()
	{
		$arr=$this->getRequest()->getParams();
		$db = new Db();
		//print_r($arr);
		$dt = changeDate(str_replace('/','-',$arr['value']));
		//echo 'Yes'.changeDate($arr['value']).'tyty';
		$data = array();
		$data['Installment_Paidon'] = $dt;
		$data['dtstatus'] = 15;
		$condition = "transactionno='".$arr['tid']."'";
		$db->modify('rbi_user_scheme_installment_paid',$data,$condition);
		echo "document.getElementById('exam_maximum_marks_".$arr['tid']."_in_place_editor').innerHTML = '".$arr['value']."';";
		exit;
	}
	public function customerwisecollectionAction()
	{
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Customer Installment Detail';
		$arr=$this->getRequest()->getParams();
		if(@$arr['custcode']) {
			$custid = getuserid($arr['custcode']);
			$where="where Installment_status='1' and usi.userid='".$custid."'";
			
			$sortname=$this->getRequest()->sortname;
			$sortorder=$this->getRequest()->sortorder;
			if (!$sortname) $sortname = 'instno, receiptno';
			if (!$sortorder) $sortorder = 'asc';	
			$sort = "ORDER BY $sortname $sortorder";					
			$groupby = " Group by usi.transactionno";
			$qry="select usi.user_installment_Id, usi.transactionno, usi.instno, sum(usi.InstallmentAmount) as InstallmentAmount, usi.PaniltyAmount, DATE_FORMAT(Installment_Paidon,'%d/%m/%Y') as paydate, usi.receiptno, min(instno) as mininstno, max(instno) as maxinstno
				  from rbi_user_scheme_installment_paid as usi
				  ";
				//echo "$qry $where $groupby $sort"; 
				//exit;
			$roles=$db->runQuery("$qry $where $groupby $sort");
			if(is_array($roles) && count($roles) > 0)
			{
			
				$this->view->result=$roles;
				$schdetail = $db->runQuery("select us.timePriodType, us.timePeriod, concat(us.title,'/L:',us.landsize) as title from rbi_user_to_scheme as us where userid='".$custid."'");
				$this->view->schdetail = $schdetail;
				$custdetail = $db->runQuery("select uc.userid,  uc.profileId, uc.aname, uc.aprofileid, uc.bname, uc.bprofileid from rbi_user_customer as uc where userId='".$custid."'");
				$this->view->custdetail = $custdetail;
			}
		}
	}
	 public function commoninstallmentAction()
	 {
        global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Common Report';
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'Installment_Paidon';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where Installment_status='1'";
		if(@$_POST['smode']=='1')
		{
			if(@$_POST['searchfor_sc']!='') {
				$where .= " and us.userid = '".$_POST['searchfor_sc']."'";
			} elseif(@$_POST['searchfor_sa']!='') {
				$where .= " and ua.userid = '".$_POST['searchfor_sa']."'";
			} elseif(@$_POST['searchfor_se']!='') {
				$where .= " and (ue.userId = '".$_POST['searchfor_se']."' or (uc.noagentempid = '".$_POST['searchfor_se']."' and uc.agentId='23'))";
			} elseif(@$_POST['searchfor_sb']!='') {
				$where .= " and ub.userId = '".$_POST['searchfor_sb']."'";
			}
		} elseif(@$_POST['smode']=='2') {
			if(@$_POST['searchfor_ac']!='') {
				$getuserid = $db->runQuery("select userid, usrRole from rbi_user where profileId='".$_POST['searchfor_ac']."'");
				if(is_array($getuserid) && count($getuserid) > 0) {
					if($getuserid[0]['usrRole']=='C') {
						$where .= " and us.userid = '".$getuserid[0]['userid']."'";
					} elseif($getuserid[0]['usrRole']=='AG') {
						$where .= " and ua.userid = '".$getuserid[0]['userid']."'";
					} elseif($getuserid[0]['usrRole']=='E') {
						$where .= " and (ue.userId = '".$getuserid[0]['userid']."' or (uc.noagentempid = '".$getuserid[0]['userid']."' and uc.agentId='23'))";
					} elseif($getuserid[0]['usrRole']=='B') {
						$where .= " and ub.userId = '".$getuserid[0]['userid']."'";
					}
				}
			}
		}
		if(@$_POST['dtmode']!='')
		{
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
		if($mySession->user['branchonly']['isbranch'])
		{
			$where .= " and uag.branchId = '".$mySession->user['branchonly']['branchid']."' ";
		}
		
		
		$sort = "ORDER BY $sortname $sortorder";					
		
		$qry="select concat(u.fname,' ',u.lname) as cname, u.profileId, usi.user_installment_Id, usi.instno, usi.InstallmentAmount, DATE_FORMAT(Installment_Paidon,'%d %M %Y %h:%i:%s') as paydate, us.timePriodType, us.timePeriod, concat(us.title,'/L:',us.landsize,'/',us.installment) as title, concat(ua.fname,' ',ua.lname) as aname, ua.profileId as aprofileId, concat(ue.fname,' ',ue.lname) as ename, ue.profileId as eprofileId, ub.fname as bname, ub.profileId as bprofileId
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
			//echo "$qry $where $sort"; 
			//exit;
		$roles=$db->runQuery("$qry $where $sort");
		if(is_array($roles) && count($roles) > 0)
		{
			$this->view->result=$roles;
		}
		
    }
	
	public function agentcommissionAction()
	{
		$this->view->pagetitle = 'Agent Commission';
	 	global $mySession;
		$db = new Db();
		
		$agentid = $this->getRequest()->getParam('agentid');
		
		$allag = 0;
		$ag_array = array();
		
		if(isset($agentid)) 
		{
			$ag_array[]=$agentid;
			$allagent=0;
			
		} else {		
			$allag=1;
			
			if(@$_POST['smode']=='1')
			{
				if(@$_POST['searchfor_sa']!='') {
					$ag_array = $this->getagentarray('AG',$_POST['searchfor_sa']);
				} elseif(@$_POST['searchfor_se']!='') {
					$ag_array = $this->getagentarray('E',$_POST['searchfor_se']);
				} elseif(@$_POST['searchfor_sb']!='') {
					$ag_array = $this->getagentarray('B',$_POST['searchfor_sb']);
				}
			} elseif(@$_POST['smode']=='2') {
				if(@$_POST['searchfor_ac']!='') {
					$getuserid = $db->runQuery("select userid, usrRole from rbi_user where profileId='".$_POST['searchfor_ac']."'");
					if(is_array($getuserid) && count($getuserid) > 0) {
						$ag_array = getagentarray($getuserid[0]['usrRole'],$getuserid[0]['userid']);		
					}
				}
			}
			if($mySession->user['branchonly']['isbranch'])
			{
				$wherea = " and branchId = '".$mySession->user['branchonly']['branchid']."' ";
			}
		//echo "select ru.userid, rbi_agent.pancard, concat(ru.fname,' ',ru.lname) as name, ru.profileId, concat(rue.fname,' ',rue.lname) as ename, concat(rub.fname,' ',rub.lname) as bname , rue.profileId as eprofileId, rub.profileId as bprofileId from rbi_agent inner join rbi_user as ru on (rbi_agent.userId=ru.userid) inner join rbi_user as rue on(rbi_agent.employeeId=rue.userid) inner join rbi_user as rub on(rbi_agent.branchId=rub.userid) where ru.usrRole='AG' and ru.userid!='23'";
			$getagids = $db->runQuery("select ru.userid, rbi_agent.pancard, concat(ru.fname,' ',ru.lname) as name, ru.profileId, concat(rue.fname,' ',rue.lname) as ename, concat(rub.fname,' ',rub.lname) as bname , rue.profileId as eprofileId, rub.profileId as bprofileId from rbi_agent inner join rbi_user as ru on (rbi_agent.userId=ru.userid) inner join rbi_user as rue on(rbi_agent.employeeId=rue.userid) inner join rbi_user as rub on(rbi_agent.branchId=rub.userid) where ru.usrRole='AG' and ru.userid!='23' ".@$wherea); 
			if(is_array($getagids) && count($getagids) >0)
			{
				$ag_array = $getagids;
			}
			$allagent = 1;
		}
		$cust_with_inst = array();
		$m=0;
		
		$year = date("Y",mktime(0,0,0,date("m")-1,1,date("Y")));
		$month = date("m",mktime(0,0,0,date("m")-1,1,date("Y")));
		
		$currentyear = date("Y");
		$currentmonth = date("m");
		
		if(isset($_REQUEST['dtmode']) && $_REQUEST['dtmode']=='2') {
			if(@$_REQUEST['sel_month']!='' && @$_REQUEST['sel_year']!='')
			{
				$year = $_REQUEST['sel_year'];
				$month = date("m",mktime(0,0,0,$_REQUEST['sel_month'],1,date("Y")));
			} 
		}
		//echo $currentyear.' -  '.$currentmonth.' -  '.$year.' -  '.$month;
		//echo '<br>'.(($currentyear*12)+$currentmonth)."dsfsdfsdF".(($year*12)+$month);
		if((($year*12)+$month) > (($currentyear*12)+$currentmonth))
		{
			$this->nextmonth = 1;
		} else {
			if($mySession->user['branchonly']['isbranch'])
			{
				$flname = date("M Y",mktime(0,0,0,$month,1,$year)).'_'.$mySession->user['branchonly']['branchid'];
			} else {
				$flname = date("M Y",mktime(0,0,0,$month,1,$year));
			}
			$this->view->monthyear = $flname;
			if($allagent==1 && file_exists("Reports/Commission".$this->view->monthyear.".txt") && 1==2) {
				$this->view->alreadyfile= "Reports/Commission".$this->view->monthyear.".txt";
			} else {
			
				if((($currentyear*12)+$currentmonth) > (($year*12)+$month))
				{
					foreach($ag_array as $agar)
					{
						
						
						
						$cust_with_inst[$m]['agent']=$agar;			
						$cust_with_inst[$m]['inst']=$this->get_agent_installment($agar['userid'],$month,$year);
						$m++;
					}
				} else {
					$cust_with_inst= array();			
					
				}
				
				$cust_with_inst = $this->get_percent($cust_with_inst);
				$this->view->commission = $cust_with_inst;
				$this->view->alreadyfile = false;
			}
		}
		
		//pr($cust_with_inst);
	
	}
	public function maturityAction()
	{
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Maturity Report';
		
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'Installment_Paidon';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		$where='';
		if(@$_POST['smode']=='1')
			{
				if(@$_POST['searchfor_sc']!='') {
					$where .= " and u.userid = '".$_POST['searchfor_sc']."'";
				} elseif(@$_POST['searchfor_sa']!='') {
					$where .= " and ua.userid = '".$_POST['searchfor_sa']."'";
				} elseif(@$_POST['searchfor_se']!='') {
					$where .= " and (ue.userId = '".$_POST['searchfor_se']."' or (uc.noagentempid = '".$_POST['searchfor_se']."' and uc.agentId='23'))";
				} elseif(@$_POST['searchfor_sb']!='') {
					$where .= " and ub.userId = '".$_POST['searchfor_sb']."'";
				}
			} elseif(@$_POST['smode']=='2') {
				if(@$_POST['searchfor_ac']!='') {
					$getuserid = $db->runQuery("select userid, usrRole from rbi_user where profileId='".$_POST['searchfor_ac']."'");
					if(is_array($getuserid) && count($getuserid) > 0) {
						if($getuserid[0]['usrRole']=='C') {
							$where .= " and u.userid = '".$getuserid[0]['userid']."'";
						} elseif($getuserid[0]['usrRole']=='AG') {
							$where .= " and ua.userid = '".$getuserid[0]['userid']."'";
						} elseif($getuserid[0]['usrRole']=='E') {
							$where .= " and (ue.userId = '".$getuserid[0]['userid']."' or (uc.noagentempid = '".$getuserid[0]['userid']."' and uc.agentId='23'))";
						} elseif($getuserid[0]['usrRole']=='B') {
							$where .= " and ub.userId = '".$getuserid[0]['userid']."'";
						}
					}
				}
			}
			if(isset($_REQUEST['dtmode'])) { 
				if(@$_POST['dtmode']!='')
				{
					if(@$_POST['dtmode']=='1') {
												
						$firstday = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));						
						$lastday = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+15,date('Y')));
						
						$where .= " and us.expire_on >= '".$firstday."' and us.expire_on <= '".$lastday."' ";
					} elseif(@$_POST['dtmode']=='2') { 
						$firstday = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));						
						$lastday = date('Y-m-d',mktime(0,0,0,date('m'),date('d')-15,date('Y')));
						
						$where .= " and us.expire_on >= '".$firstday."' and us.expire_on <= '".$lastday."' ";
					} elseif(@$_POST['dtmode']=='3') { 
						if(@$_POST['dtrangefrom']!='' || @$_POST['dtrangeto']!='')
						{
							if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']!='')
							{
								$dtrangefrom = explode("-",$_POST['dtrangefrom']);
								$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));
								
								$dtrangeto = explode("-",$_POST['dtrangeto']);
								$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));
								
								$where .= " and us.expire_on >= '".$firstday."' and us.expire_on <= '".$lastday."' ";
							}
							if(@$_POST['dtrangefrom']!='' && @$_POST['dtrangeto']=='')
							{
								$dtrangefrom = explode("-",$_POST['dtrangefrom']);
								$firstday = date('Y-m-d',mktime(0,0,0,$dtrangefrom[1],$dtrangefrom[0],$dtrangefrom[2]));
								$where .= " and us.expire_on >= '".$firstday."' ";
							}
							if(@$_POST['dtrangefrom']=='' && @$_POST['dtrangeto']!='')
							{
								$dtrangeto = explode("-",$_POST['dtrangeto']);
								$lastday = date('Y-m-d',mktime(0,0,0,$dtrangeto[1],$dtrangeto[0],$dtrangeto[2]));
								$where .= " and us.expire_on <= '".$lastday."' ";
							}
						
						} 
						
					} elseif(@$_POST['dtmode']=='4') { 
						$firstday = date('Y-m-d',mktime(0,0,0,date('m'),'1',date('Y')));
						$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
						$where .= " and us.expire_on >= '".$firstday."' and us.expire_on <= '".$lastday."' ";
					}
				} else {
					$firstday = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));						
					$lastday = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+15,date('Y')));
					
					$where .= " and us.expire_on >= '".$firstday."' and us.expire_on <= '".$lastday."' ";
				} 
			} else {
				$firstday = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));						
				$lastday = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+15,date('Y')));
				
				$where .= " and us.expire_on >= '".$firstday."' and us.expire_on <= '".$lastday."' ";
			}
			//(select *, max(InstallmentDueDate) as lastinst_date, DATE_ADD(max(InstallmentDueDate), INTERVAL 1 MONTH) mat_date from rbi_user_scheme_installment group by user_schemeId) as usi
			   $qry="select us.expire_on as mat_date, concat(u.fname,' ',u.lname) as cname, u.profileId, usi.user_installment_Id, usi.InstallmentAmount,  DATE_FORMAT(us.expire_on,'%d %M %Y') as m_date, us.timePriodType, us.timePeriod, concat(us.title,'/L:',us.landsize,'/',us.installment) as title, us.ReturnAmount, concat(ua.fname,' ',ua.lname) as aname, ua.profileId as aprofileId, concat(ue.fname,' ',ue.lname) as ename, ue.profileId as eprofileId, ub.fname as bname, ub.profileId as bprofileId
			  from (select *, max(InstallmentDueDate) as lastinst_date from rbi_user_scheme_installment group by user_schemeId) as usi
			  inner join rbi_user_to_scheme as us on (usi.user_schemeId=us.user_schemeid)
			  inner join rbi_user_customer as uc on (us.userid=uc.userId)
			  inner join rbi_user as ua on (ua.userid=uc.agentId)
			  inner join rbi_agent as uag on (uag.userId=ua.userid) 
			 inner join rbi_user as ue on (if(uc.agentId=23 and uc.noagentempid!=0, ue.userId=uc.noagentempid, ue.userId=uag.employeeId))
			  inner join rbi_employee as uemp on (ue.userid=uemp.userId)
			  inner join rbi_user as ub on (ub.userId=uemp.branchId)
			  inner join rbi_user as u on (u.userid=uc.userId) ";
			  
			//echo "$qry $where $sort"; 
			//exit;
		$roles=$db->runQuery("$qry $where $sort");
		if(is_array($roles) && count($roles) > 0)
		{
			$this->view->result=$roles;
		}
	}
	public function employeeAction()
	{
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Employee Report';
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'u.fname';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where u.status='1'";
		
		if(@$_POST['searchfor_sb']!='') {
			$where .= " and uemp.branchId = '".$_POST['searchfor_sb']."'";		
		} else {
			$where .= " and uemp.branchId = '5'";
		}
		
		
		$sort = "ORDER BY $sortname $sortorder";					
		
		$qry="select u.userid as empuid, concat(u.fname,' ',u.lname) as cname, u.profileId, ub.fname as bname, ub.profileId as bprofileId, DATE_FORMAT(u.created_on,'%d %M %Y') as r_date
			  from rbi_user as u
			  inner join rbi_employee as uemp on (u.userid=uemp.userId)
			  inner join rbi_user as ub on (ub.userId=uemp.branchId) ";
			//echo "$qry $where $sort"; 
			//exit;
		$roles=$db->runQuery("$qry $where $sort");
		if(is_array($roles) && count($roles) > 0)
		{
			$this->view->result=$roles;
		}
	}
	public function agentlistAction()
	{
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Advisor Report';
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'u.userid';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where u.status='1' and u.usrRole='AG' ";
		
		if(@$_POST['searchfor_sb']!='') {
			$where .= " and uag.branchId = '".$_POST['searchfor_sb']."'";		
		} else {
			$where .= " and uag.branchId = '5'";
		}
		
		
		$sort = "ORDER BY $sortname $sortorder";					
		
		$qry="select u.userid as aguid, concat(u.fname,' ',u.lname) as cname, u.profileId, ub.fname as bname, ub.profileId as bprofileId, DATE_FORMAT(u.created_on,'%d %M %Y') as r_date, u.mobno, uag.pancard, (select count(customerId) from rbi_user_customer where agentId=u.userid) as totcust
			  from rbi_user as u
			  inner join rbi_agent as uag on (u.userid=uag.userId)			 
			  inner join rbi_user as ub on (ub.userId=uag.branchId) ";
			//echo "$qry $where $sort"; 
			//exit; 
			//inner join rbi_employee as uemp on (u.userid=uemp.userId)
		$roles=$db->runQuery("$qry $where $sort");
		if(is_array($roles) && count($roles) > 0)
		{
			$this->view->result=$roles;
		}
	}	
	public function expirdatereportAction()
	{
		global $mySession;
		$db=new Db();
		
		$Result=$db->runQuery("select concat(u.fname, ' ',u.lname) as name, u.profileId, DATE_FORMAT(u.created_on,'%d %M %Y') as regdate, DATE_FORMAT(us.expire_on,'%d %M %Y') as expdate, us.timePriodType, us.timePeriod, us.title from rbi_user as u inner join rbi_user_to_scheme as us on(u.userid=us.userid) where u.usrRole='C' order by u.created_on");
		if(is_array($Result) && count($Result) > 0)
		{
			$this->view->result = $Result;
		}
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
		inner join rbi_user on (rbi_agent.userId=rbi_user.userid) 
		where rbi_agent.employeeId='".$_REQUEST['empId']."'");
		?>
		<select name="searchfor_sa" id="searchfor_sa" <? if(isset($_REQUEST['noagax']) && $_REQUEST['noagax']==1) { } else { ?>onchange="getAgentCustomer(this.value,0)" <? } ?>>
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
	public function commonsummeryAction()
	{
		
        global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Common Summary Report';
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'Installment_Paidon';
		if (!$sortorder) $sortorder = 'asc';		
		$where=" ";
		
		if(@$_POST['dtmode']!='')
		{
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
		
		$sort = "ORDER BY $sortname $sortorder";					
		$groupby = ' GROUP BY DATE(Installment_Paidon) ';
		$formatval = '%d %M %Y';
		if(@$_REQUEST['wisemode']==2) {
			$groupby = ' GROUP BY MONTH(Installment_Paidon) ';
			$formatval = '%M %Y';
		}
		$qry="select * from (select sum(InstallmentAmount) as totnew, date_format(Installment_Paidon,'".$formatval."') as paidon1 from rbi_user_scheme_installment where Installment_status='1' and instno='1' $where $groupby) as t1 left join (select sum(InstallmentAmount) as totrenew, date_format(Installment_Paidon,'".$formatval."') as paidon2 from rbi_user_scheme_installment where Installment_status='1' and instno!='1' $where $groupby) as t2 on (t1.paidon1=t2.paidon2) union select * from (select sum(InstallmentAmount) as totnew, date_format(Installment_Paidon,'".$formatval."') as paidon1 from rbi_user_scheme_installment where Installment_status='1' and instno='1' $where $groupby) as t1 right join (select sum(InstallmentAmount) as totrenew, date_format(Installment_Paidon,'".$formatval."') as paidon2 from rbi_user_scheme_installment where Installment_status='1' and instno!='1' $where $groupby) as t2 on (t1.paidon1=t2.paidon2)";
		
		$roles=$db->runQuery($qry);
		
		if(is_array($roles) && count($roles) > 0)
		{
			
			$this->view->result=$roles;
		}
		
   
	}
	public function getagentcustAction()
	{
		global $mySession;
		$db=new Db();
		
		$Result=$db->runQuery("select rbi_user_customer.profileId, rbi_user_customer.userId,concat(fname,' ',lname) as cust_name from rbi_user_customer inner 
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
		exit;
	}
	function get_agent_installment($agid,$month,$year)
	{
		global $mySession;
		$db=new Db();
		
		$firstday = date('Y-m-d',mktime(0,0,0,$month,'1',$year));
		$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime($month.'/01/'.$year.' 00:00:00'))));
	
		/*$getcust = $db->runQuery("select (InstallmentAmount + PaniltyAmount) as amount, rs.scheme_type as scate from rbi_user_scheme_installment as usi inner join rbi_user_to_scheme as rus on (usi.user_schemeId=rus.user_schemeid) inner join rbi_scheme as rs on(rus.schemId=rs.schemId) where usi.user_schemeId in (select us.user_schemeid from rbi_user_customer as uc inner join rbi_user_to_scheme as us on (uc.userId=us.userid) where uc.agentId='".$agid."') and usi.Installment_Paidon >= '".$firstday."'  and  usi.Installment_Paidon <= '".$lastday." 23:59:59' order by rs.scheme_type");*/
		
		$getcust = $db->runQuery("select sum(InstallmentAmount + PaniltyAmount) as amount, rs.scheme_type as scate, rs.title as stitle from rbi_user_scheme_installment as usi inner join rbi_user_to_scheme as rus on (usi.user_schemeId=rus.user_schemeid) inner join rbi_scheme as rs on(rus.schemId=rs.schemId) where usi.user_schemeId in (select us.user_schemeid from rbi_user_customer as uc inner join rbi_user_to_scheme as us on (uc.userId=us.userid) where uc.agentId='".$agid."') and usi.Installment_Paidon >= '".$firstday."'  and  usi.Installment_Paidon <= '".$lastday." 23:59:59' group by rs.scheme_type order by rs.scheme_type");
	
		return $getcust;
	}
	function get_percent($custarray)
	{
		global $mySession;
		$db=new Db();
		
		$a=0;
		foreach($custarray as $custar)
		{
			$x=0;
			foreach($custar['inst'] as $inst)
			{
				//echo "<br><br>select year_1 from rbi_commission where scheme_cat='".$inst['scate']."' and target_from <= '".$inst['amount']."' and target_to >= '".$inst['amount']."'";
				$getp = $db->runQuery("select year_1 from rbi_commission where scheme_cat='".$inst['scate']."' and target_from <= '".$inst['amount']."' and target_to >= '".$inst['amount']."'");
				if(is_array($getp) && count($getp) > 0)
				{
					$perc = $getp[0]['year_1'];
				} else {
					$perc = 0;
				}	
					$custarray[$a]['inst'][$x]['percent']=$perc;
					if($perc==0) {
						$custarray[$a]['inst'][$x]['percentamount']=0;
					} else {
						$custarray[$a]['inst'][$x]['percentamount']=($inst['amount']*$perc)/100;
					}
				$x++;
			}
			$a++;	
		}
		return $custarray;
	}
	
	function getagentarray($role,$id)
	{
	$db = new Db();
	$agar = array();
		if($role=='AG') {
			$agar[0]['userid']=$id;
			return $agar;
		} elseif($role=='E') {
			$getagent = "select userId as userid from rbi_agent where employeeId='".$id."'";
			$res = $db->runQuery($getagent);
			if(is_array($res)) { $agar = $res; }
			return $agar;
		} elseif($role=='B') {
			$getagent = "select userId as userid from rbi_agent where branchId='".$id."'";
			$res = $db->runQuery($getagent);
			if(is_array($res)) { $agar = $res; }
			return $agar;
		}
	}
	
}
?>
