<?php
class JobController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }
	
	
	public function indexAction()
	{	
		global $mySessionFront;		
	}	
	//Search Records...
	public function searchAction()
	{	
		global $mySession;	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$wherecondition='';
		
		if (!empty($arr['job_country'])) {
			$wherecondition .= " job_country='".$arr['job_country']."'";
		} 
		if(isset($arr['employment_id']) && $arr['employment_id']!='') {
			$wherecondition .= " and employment_id='".$arr['employment_id']."'";
		}
		
		//$this->view->wherecondition=$wherecondition;
		$qry="select *, job_country, employment_id from `tbl_jobs`  where ".$wherecondition;
			  
		//prd($qry);
		//$qry="select a.*, concat(a.first_name,' ',a.last_name) as name, b.name as deptname from `employees` as a left join employee_departments as b on(a.employee_department_id=b.id) where a.schoolid='".$mySession->user['schoolid']."' ".$wherecondition;	
				
			$searchlist=$db->runQuery("$qry");
			 //prd($searchlist);
			$this->view->advsearchlist=$searchlist;
	}	
	
	//Search By Country Ajax...
	public function countryajaxAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		//$this->view->country_id = $arr['country_id'];
		
		if($arr['country_id']) {
			$qry="select * from `tbl_jobs` where job_country ='".$arr['country_id']."'";
			//prd($qry);
			$country_id = $db->runQuery("$qry");
			//prd($list);
			$this->view->country_id=$country_id;
		}
	}
	
	//Search By Career Level Ajax...
	public function careerlevelsajaxAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['career_level_id']) {
			$qry="select * from `tbl_jobs` where job_career_level ='".$arr['career_level_id']."'";
			//prd($qry);
			$career_level_id = $db->runQuery("$qry");
			//prd($list);
			$this->view->career_level_id=$career_level_id;
		}
	}
	
	//Search By Job Role Ajax...
	public function jobroleajaxAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['job_role_id']) {
			$qry="select * from `tbl_jobs` where job_role ='".$arr['job_role_id']."'";
			//prd($qry);
			$job_role_id = $db->runQuery("$qry");
			//prd($job_role_id);
			$this->view->job_role_id=$job_role_id;
		}
	}
	
	//Search By Company  Ajax...
	public function companyajaxAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['cat_id']) {
			$qry="select * from `tbl_jobs` where job_category ='".$arr['cat_id']."'";
			//prd($qry);
			$cat_id = $db->runQuery("$qry");
			//prd($job_role_id);
			$this->view->cat_id=$cat_id;
		}
	}
	
	//Search By Company  Ajax...
	public function companytypajaxAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['sub_cat_id']) {
			$qry="select * from `tbl_jobs` where job_sub_category ='".$arr['sub_cat_id']."'";
			//prd($qry);
			$sub_cat_id = $db->runQuery("$qry");
			//prd($qry);
			$this->view->sub_cat_id=$sub_cat_id;
		}
	}
	
	//Search By Job Sallary  Ajax...
	public function jobsallaryajaxAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['job_sallary']) {
		
			//$dtr=explode('-',$formData['cust_dob']);
			//$Data['cust_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
			
			$dtr=explode(',',$arr['job_sallary']);
			$sallary_min['job_sallary'] =$dtr[0];
			foreach($sallary_min as $sallary_min)
	  		{
				//echo $detail; 
	  		}
			$dtr1=explode(',',$arr['job_sallary']);
			$sallary_max['job_sallary'] =$dtr1[1];
			foreach($sallary_max as $sallary_max)
	  		{
				//echo $sallary_max; 
	  		}
			
			//prd($sallary_max);
			
			//$qry="select * from `tbl_jobs` where job_sub_category ='".$arr['sub_cat_id']."'";
			
			$qry="SELECT * FROM tbl_jobs WHERE job_sallary BETWEEN '".$sallary_min."' AND '".$sallary_max."'";
			//prd($qry);
			$job_sallary = $db->runQuery("$qry");
			//prd($job_sallary);
			$this->view->job_sallary=$job_sallary;
		}
	}
	
	//Search By Job Dates  Ajax...
	public function jobbydateajaxAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['job_posted_on']) {
			
			$qry="SELECT * FROM tbl_jobs WHERE job_posted_on >= CURDATE() - INTERVAL '".$arr['job_posted_on']."' DAY ORDER BY job_posted_on DESC";
			//prd($qry);
			$job_posted_on = $db->runQuery("$qry");
			//prd($job_sallary);
			$this->view->job_posted_on=$job_posted_on;
		}
	}	
	
	
}
?>
