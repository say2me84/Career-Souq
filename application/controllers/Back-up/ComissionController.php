<?php
class ComissionController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('commission'))
		{
		} else {
			$this->_redirect('index');	
		}
		
    }

    public function indexAction(){
        global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Commission Report';		
		$ag_array = array();
		
		if(@$_POST['smode']=='1')
		{
			if(@$_POST['searchfor_sa']!='') {
				$ag_array = $this->getagentarray('AG',$_POST['searchfor_sa']);
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
			$wherea .= " and branchId = '".$mySession->user['branchonly']['branchid']."' ";
		}
		
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
		
		if($mySession->user['branchonly']['isbranch'])
		{
			$flname = date("M Y",mktime(0,0,0,$month,1,$year)).'_'.$mySession->user['branchonly']['branchid'];
		} else {
			$flname = date("M Y",mktime(0,0,0,$month,1,$year));
		}
		$this->view->monthyear = $flname;
		
		$firstday = date('Y-m-d',mktime(0,0,0,$month,'1',$year));
		$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime($month.'/01/'.$year.' 00:00:00'))));
		
		$qry = "select sum(ac.comission) as comission, sum(ac.amount) as amount, sum(ac.inst_amount) as inst_amount, ac.aid, ac.branchId, u.profileId, concat(u.fname,' ',u.lname) as agname, ac.scheme_cat  from rbi_agentamount as ac			
				left join rbi_user as u on (u.userid=ac.aid)
				where 1 and ac.credit_dt >= '".$firstday."' and ac.credit_dt <= '".$lastday."' group by ac.aid ";
		
		$commission = $db->runQuery($qry);
		$this->view->commission = $commission;
	}
	 public function byschemeAction(){
        global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Commission Report By Scheme';		
		$ag_array = array();
		
		if(@$_POST['smode']=='1')
		{
			if(@$_POST['searchfor_sa']!='') {
				$ag_array = $this->getagentarray('AG',$_POST['searchfor_sa']);
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
			$wherea .= " and branchId = '".$mySession->user['branchonly']['branchid']."' ";
		}
		
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
		
		if($mySession->user['branchonly']['isbranch'])
		{
			$flname = date("M Y",mktime(0,0,0,$month,1,$year)).'_'.$mySession->user['branchonly']['branchid'];
		} else {
			$flname = date("M Y",mktime(0,0,0,$month,1,$year));
		}
		$this->view->monthyear = $flname;
		
		$firstday = date('Y-m-d',mktime(0,0,0,$month,'1',$year));
		$lastday = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime($month.'/01/'.$year.' 00:00:00'))));
		
		 $qry = "select sum(ac.comission) as comission, sum(ac.amount) as amount, sum(ac.inst_amount) as inst_amount, ac.aid, ac.branchId, u.profileId, concat(u.fname,' ',u.lname) as agname, ac.scheme_cat, ac.mnth from rbi_agentamount as ac			
				left join rbi_user as u on (u.userid=ac.aid)
				where 1 and ac.credit_dt >= '".$firstday."' and ac.credit_dt <= '".$lastday."' group by ac.aid, ac.scheme_cat, ac.mnth ";
		
		
		$commission = $db->runQuery($qry);
		$this->view->commission = $commission;
	}
	
}
?>
