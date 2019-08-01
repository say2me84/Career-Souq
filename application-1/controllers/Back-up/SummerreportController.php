<?php
class SummerreportController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }

    public function indexAction(){
        global $mySession;
		
		$db=new Db();
		
			exit;	
					
		
		///echo $mySession->user['userRole'];
    }
	public function duetodayAction(){
		global $mySession;
		
		$db=new Db();
		
		
		$arr=$this->getRequest()->getParams();
		if(isset($arr['summery_sub_wise']) && $arr['summery_sub_wise']!='') 
		{
			$summery_sub_wise=$arr['summery_sub_wise'];
		}else
		{
			$summery_sub_wise=1;
		}
		$this->view->headbranch_or_agent = 'Branch';
		$this->view->sel_1='checked="checked"';
		$this->view->sel_2='';
		$this->view->reporthead ='According Branch';
		if($summery_sub_wise==2)
		{
		
			$resultarray = $db->runQuery("select usi.user_installment_Id, DATE_FORMAT(usi.InstallmentDueDate,'%d %M %Y') as duemonth, usi.InstallmentAmount, usi.user_schemeId, us.schemId, us.title, uag.userId as agentid, uag.profileId as agproid, uag.branchId as branchid
			from rbi_user_scheme_installment as usi 
			inner join rbi_user_to_scheme as us on (us.user_schemeId=usi.user_schemeId) 
			inner join rbi_user_customer as usc on (us.userid=usc.userId) 
			inner join rbi_agent as uag on (usc.agentId=uag.userId) 
			where usi.InstallmentDueDate like '".date('Y-m-d')."%' and Installment_status='0' and usc.custstaus='1' order by uag.agentId, usi.InstallmentDueDate desc");
			
			$this->view->headbranch_or_agent = 'Agent';
			$this->view->sel_1='';
			$this->view->sel_2='checked="checked"';
			$this->view->reporthead ='According Agent';
		} else {
			
			
			$resultarray = $db->runQuery("select usi.user_installment_Id, DATE_FORMAT(usi.InstallmentDueDate,'%d %M %Y') as duemonth, usi.InstallmentAmount, usi.user_schemeId, us.schemId, us.title, uag.userId as agentid, uag.branchId as branchid
			from rbi_user_scheme_installment as usi 
			inner join rbi_user_to_scheme as us on (us.user_schemeId=usi.user_schemeId) 
			inner join rbi_user_customer as usc on (us.userid=usc.userId) 
			inner join rbi_agent as uag on (usc.agentId=uag.userId) 
			where usi.InstallmentDueDate like '".date('Y-m-d')."%' and Installment_status='0' and usc.custstaus='1' order by uag.branchId, usi.InstallmentDueDate desc");
		}
		
		$this->view->resultarray = $resultarray;
		$this->view->summery_sub_wise = $summery_sub_wise;		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	
	public function duethismonthAction(){
		global $mySession;
		
		$db=new Db();
		
		
		$arr=$this->getRequest()->getParams();
		if(isset($arr['summery_sub_wise']) && $arr['summery_sub_wise']!='') 
		{
			$summery_sub_wise=$arr['summery_sub_wise'];
		}else
		{
			$summery_sub_wise=1;
		}
		$this->view->headbranch_or_agent = 'Branch';
		$this->view->sel_1='checked="checked"';
		$this->view->sel_2='';
		$this->view->reporthead ='According Branch';
		if($summery_sub_wise==2)
		{
		
			$resultarray = $db->runQuery("select usi.user_installment_Id, DATE_FORMAT(usi.InstallmentDueDate,'%d %M %Y') as duemonth, usi.InstallmentAmount, usi.user_schemeId, us.schemId, us.title, uag.userId as agentid, uag.profileId as agproid, uag.branchId as branchid
			from rbi_user_scheme_installment as usi 
			inner join rbi_user_to_scheme as us on (us.user_schemeId=usi.user_schemeId) 
			inner join rbi_user_customer as usc on (us.userid=usc.userId) 
			inner join rbi_agent as uag on (usc.agentId=uag.userId) 
			where usi.InstallmentDueDate like '".date('Y-m-')."%' and Installment_status='0' and usc.custstaus='1' and us.scheme_type not in (1,2,3) order by uag.agentId, usi.InstallmentDueDate desc");
			
			$this->view->headbranch_or_agent = 'Agent';
			$this->view->sel_1='';
			$this->view->sel_2='checked="checked"';
			$this->view->reporthead ='According Agent';
		} else {
			
			
			$resultarray = $db->runQuery("select usi.user_installment_Id, DATE_FORMAT(usi.InstallmentDueDate,'%d %M %Y') as duemonth, usi.InstallmentAmount, usi.user_schemeId, us.schemId, us.title, uag.userId as agentid, uag.branchId as branchid
			from rbi_user_scheme_installment as usi 
			inner join rbi_user_to_scheme as us on (us.user_schemeId=usi.user_schemeId) 
			inner join rbi_user_customer as usc on (us.userid=usc.userId) 
			inner join rbi_agent as uag on (usc.agentId=uag.userId) 
			where usi.InstallmentDueDate like '".date('Y-m-')."%' and Installment_status='0' and usc.custstaus='1' and us.scheme_type not in (1,2,3) order by uag.branchId, usi.InstallmentDueDate desc");
		}
		
		$this->view->resultarray = $resultarray;
		$this->view->summery_sub_wise = $summery_sub_wise;		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	public function duethismonthdailyAction(){
		global $mySession;
		
		$db=new Db();
		
		
		$arr=$this->getRequest()->getParams();
		if(isset($arr['summery_sub_wise']) && $arr['summery_sub_wise']!='') 
		{
			$summery_sub_wise=$arr['summery_sub_wise'];
		}else
		{
			$summery_sub_wise=1;
		}
		$this->view->headbranch_or_agent = 'Branch';
		$this->view->sel_1='checked="checked"';
		$this->view->sel_2='';
		$this->view->reporthead ='According Branch';
		if($summery_sub_wise==2)
		{
		
			$resultarray = $db->runQuery("select usi.user_installment_Id, DATE_FORMAT(usi.InstallmentDueDate,'%d %M %Y') as duemonth, usi.InstallmentAmount, usi.user_schemeId, us.schemId, us.title, uag.userId as agentid, uag.profileId as agproid, uag.branchId as branchid
			from rbi_user_scheme_installment as usi 
			inner join rbi_user_to_scheme as us on (us.user_schemeId=usi.user_schemeId) 
			inner join rbi_user_customer as usc on (us.userid=usc.userId) 
			inner join rbi_agent as uag on (usc.agentId=uag.userId) 
			where usi.InstallmentDueDate like '".date('Y-m-')."%' and Installment_status='0' and usc.custstaus='1' and us.scheme_type in (1,2,3) order by uag.agentId, usi.InstallmentDueDate desc");
			
			$this->view->headbranch_or_agent = 'Agent';
			$this->view->sel_1='';
			$this->view->sel_2='checked="checked"';
			$this->view->reporthead ='According Agent';
		} else {
			
			
			$resultarray = $db->runQuery("select usi.user_installment_Id, DATE_FORMAT(usi.InstallmentDueDate,'%d %M %Y') as duemonth, usi.InstallmentAmount, usi.user_schemeId, us.schemId, us.title, uag.userId as agentid, uag.branchId as branchid
			from rbi_user_scheme_installment as usi 
			inner join rbi_user_to_scheme as us on (us.user_schemeId=usi.user_schemeId) 
			inner join rbi_user_customer as usc on (us.userid=usc.userId) 
			inner join rbi_agent as uag on (usc.agentId=uag.userId) 
			where usi.InstallmentDueDate like '".date('Y-m-')."%' and Installment_status='0' and usc.custstaus='1' and us.scheme_type in (1,2,3) order by uag.branchId, usi.InstallmentDueDate desc");
		}
		
		$this->view->resultarray = $resultarray;
		$this->view->summery_sub_wise = $summery_sub_wise;		
		$this->_helper->layout()->setLayout('ajaxlayout');
	}
	public function dueoldAction(){
        global $mySession;
		
		$db=new Db();
		
		
		$arr=$this->getRequest()->getParams();
		if(isset($arr['summery_sub_wise']) && $arr['summery_sub_wise']!='') 
		{
			$summery_sub_wise=$arr['summery_sub_wise'];
		}else
		{
			$summery_sub_wise=1;
		}
		$this->view->headbranch_or_agent = 'Branch';
		$this->view->sel_1='checked="checked"';
		$this->view->sel_2='';
		$this->view->reporthead ='According Branch';
		if($summery_sub_wise==2)
		{
		
			
			
			$resultarray = $db->runQuery("select usi.user_installment_Id, DATE_FORMAT(usi.InstallmentDueDate,'%M %Y') as duemonth, usi.InstallmentAmount, usi.user_schemeId, us.schemId, us.title, uag.userId as agentid, uag.branchId as branchid
			from rbi_user_scheme_installment as usi 
			inner join rbi_user_to_scheme as us on (us.user_schemeId=usi.user_schemeId) 
			inner join rbi_user_customer as usc on (us.userid=usc.userId) 
			inner join rbi_agent as uag on (usc.agentId=uag.userId) 
			where usi.InstallmentDueDate <= '".date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')))."%' and Installment_status='0' and usc.custstaus='1' order by uag.agentId, usi.InstallmentDueDate desc");
			
			$this->view->headbranch_or_agent = 'Agent';
			$this->view->sel_1='';
			$this->view->sel_2='checked="checked"';
			$this->view->reporthead ='According Agent';
		} else {
			
			$resultarray = $db->runQuery("select usi.user_installment_Id, DATE_FORMAT(usi.InstallmentDueDate,'%M %Y') as duemonth, usi.InstallmentAmount, usi.user_schemeId, us.schemId, us.title, uag.userId as agentid, uag.branchId as branchid
			from rbi_user_scheme_installment as usi 
			inner join rbi_user_to_scheme as us on (us.user_schemeId=usi.user_schemeId) 
			inner join rbi_user_customer as usc on (us.userid=usc.userId) 
			inner join rbi_agent as uag on (usc.agentId=uag.userId) 
			where usi.InstallmentDueDate <= '".date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')))."%' and Installment_status='0' and usc.custstaus='1' order by uag.branchId, usi.InstallmentDueDate desc");
		}
		
		$this->view->resultarray = $resultarray;
		$this->view->summery_sub_wise = $summery_sub_wise;		
		$this->_helper->layout()->setLayout('ajaxlayout');
		///echo $mySession->user['userRole'];
    }	
	

}
?>
