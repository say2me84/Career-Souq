<?php
class UserController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }
	
	public function indexAction(){
      
       global $mySessionFront;
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		if($mySessionFront->user['userRole']=='Job Seeker') { 
			
		$db=new Db();
		
		$qry= "SELECT * FROM `tbl_users` where user_id='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData;
		
		//===================================== Saved Jobs ========================================//
		$save_qry="SELECT COUNT(job_id) as TotalSave FROM tbl_saved_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Save);
		$this->view->SaveJobs=$Job_Save[0];
		
		//===================================== Applied Jobs =====================================//
		$Apply_Qry="SELECT COUNT(job_id) as TotalApply FROM tbl_applied_jobs WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Apply_Job = $db->runQuery("$Apply_Qry");
		//prd($Apply_Job);
		$this->view->Apply_Job=$Apply_Job[0];
		
		//===================================== Notifications =====================================//
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
		
					
		} else {
//============================================ Adding Employee Data ======================================//
			$db=new Db();
			$qry= "SELECT * FROM `tbl_users` where user_id='".$mySessionFront->user['FrontUserId']."'";
			$GetData = $db->runQuery($qry);
					//prd($GetData); exit;
			$this->view->UserData = $GetData;
		
//============================================ Employee ======================================//
		}
    }	
	//Edit User Profile Ajax...
	public function userprofileAction()
	{	
		global $mySessionFront;
	   	if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		//$this->view->country_id = $arr['country_id'];
		
		if($arr['user_id']) {
			//prd($arr['user_id']);
			
			$qry="select * from `tbl_users` where user_id ='".$arr['user_id']."'";
			//prd($qry);
			$user_id = $db->runQuery("$qry");
			//prd($list);
			$this->view->user_id=$user_id[0];
		
		}
	}
	public function ajaxusereditAction() 
	{
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
		//$arr=$this->getRequest()->getParams();
		//$this->_helper->layout()->setLayout('ajaxlayout');
		$user_fname = $this->_request->getParam('user_fname');
		$user_lname = $this->_request->getParam('user_lname');
		$user_id = $this->_request->getParam('user_id');
		
			//prd($user_id,'',$user_lname);
			if ($this->_request->isPost())
			{
				$data='';
				$data['user_fname']=$user_fname;
				$data['user_lname']=$user_lname;	
				
				$modelobj = new Model_Mainmodel();
				$condition="user_id='".$user_id."'";
				$modelobj->updateThis('tbl_users',$data,$condition);
				$mySessionFront->sucMsg = "Edit Profile Success...";	
			}
			prd($user_fname,'',$user_lname);
	}
	public function baseinfoAction(){
      
       	global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		$db=new Db();
		
		$qry= "SELECT *, user_fname, user_lname,user_image FROM tbl_users WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
				
		
    }
//============================================ User Basic Information ======================================//	
	
	
	
		
		
	
	
	
	
	
	
//============================================ Job Applied ======================================//
	
  	public function jobsappliedAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}
		$qry= "SELECT
tbl_countries.country_name,
tbl_career_levels.career_level_title,
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone,
tbl_users.user_image,
tbl_users.user_gender,
tbl_nationalities.nation_title,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_job_educations.education_title,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary
FROM
tbl_users
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id
WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
		
		//===================================== Saved List ========================================//
		$Apply_Job_List_Qry="SELECT
tbl_career_levels.career_level_title,
tbl_jobs.job_title,
tbl_job_categories.category_title,
tbl_jobs.job_description,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_jobs.id,
tbl_applied_jobs.applied_on,
tbl_applied_jobs.application_status,
tbl_job_roles.job_role_title,
tbl_users.user_company
FROM
tbl_jobs
LEFT JOIN tbl_career_levels ON tbl_career_levels.career_level_id = tbl_jobs.job_career_level
LEFT JOIN tbl_job_categories ON tbl_job_categories.cat_id = tbl_jobs.job_category
LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id
LEFT JOIN tbl_applied_jobs ON tbl_applied_jobs.job_id = tbl_jobs.id
LEFT JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id where tbl_applied_jobs.user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($Apply_Job_List_Qry);	
		$Apply_Job_List = $db->runQuery("$Apply_Job_List_Qry");
		//prd($Apply_Job_List);  
		$this->view->Apply_Job_List=$Apply_Job_List;
		//============================================ Recommended Jobs ======================================//		
		//user_industry
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry limit 0,5";
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;
		//============================================ ALL Jobs ======================================//		
		//user_industry
		$All_Job_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry";
		//prd($All_Job_Qry);
		$All_Job = $db->runQuery($All_Job_Qry);
		//prd($All_Job);
		$this->view->All_Job=$All_Job;
		
	   //===================================== Saved Jobs ========================================//
		$save_qry="SELECT COUNT(job_id) as TotalSave FROM tbl_saved_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Save);
		$this->view->SaveJobs=$Job_Save[0];
		
		//===================================== Applied Jobs =====================================//
		$Apply_Qry="SELECT COUNT(job_id) as TotalApply FROM tbl_applied_jobs WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Apply_Job = $db->runQuery("$Apply_Qry");
		//prd($Apply_Job);
		$this->view->Apply_Job=$Apply_Job[0];
		
		//===================================== Notifications =====================================//
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
	  	
    }
//============================================ Job Saved ======================================//
	public function jobsavedAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}
		$qry= "SELECT
tbl_countries.country_name,
tbl_career_levels.career_level_title,
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone,
tbl_users.user_image,
tbl_users.user_gender,
tbl_nationalities.nation_title,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_job_educations.education_title,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary
FROM
tbl_users
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id
WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
		
		//===================================== Saved List ========================================//
		$Save_Job_List_Qry="SELECT
tbl_career_levels.career_level_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_job_categories.category_title,
tbl_saved_jobs.job_saved_on,
tbl_jobs.job_description,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_saved_jobs.user_id,
tbl_users.user_company,
tbl_job_roles.job_role_title
FROM
tbl_saved_jobs
LEFT JOIN tbl_jobs ON tbl_saved_jobs.job_id = tbl_jobs.id
LEFT JOIN tbl_career_levels ON tbl_career_levels.career_level_id = tbl_jobs.job_career_level
LEFT JOIN tbl_job_categories ON tbl_job_categories.cat_id = tbl_jobs.job_category
LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id
LEFT JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id WHERE tbl_saved_jobs.user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($Save_Job_Qry);	
		$Save_Job_List = $db->runQuery("$Save_Job_List_Qry");
		//prd($Save_Job_List);  
		$this->view->Save_Job_List=$Save_Job_List;
		//============================================ Recommended Jobs ======================================//		
		//user_industry
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry limit 0,5";
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;
		//============================================ ALL Jobs ======================================//		
		//user_industry
		$All_Job_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry";
		//prd($All_Job_Qry);
		$All_Job = $db->runQuery($All_Job_Qry);
		//prd($All_Job);
		$this->view->All_Job=$All_Job;
		
	   //===================================== Saved Jobs ========================================//
		$save_qry="SELECT COUNT(job_id) as TotalSave FROM tbl_saved_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Save);
		$this->view->SaveJobs=$Job_Save[0];
		
		//===================================== Applied Jobs =====================================//
		$Apply_Qry="SELECT COUNT(job_id) as TotalApply FROM tbl_applied_jobs WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Apply_Job = $db->runQuery("$Apply_Qry");
		//prd($Apply_Job);
		$this->view->Apply_Job=$Apply_Job[0];
		
		//===================================== Notifications =====================================//
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
	  	
    }	
//============================================ Job Notifications ======================================//
	public function notificationAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}
		$qry= "SELECT
tbl_countries.country_name,
tbl_career_levels.career_level_title,
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone,
tbl_users.user_image,
tbl_users.user_gender,
tbl_nationalities.nation_title,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_job_educations.education_title,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary
FROM
tbl_users
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id
WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
		
		//===================================== Saved List ========================================//
		$Inbox_Qry="SELECT tbl_users.user_fname,tbl_users.user_lname,tbl_users.user_company,tbl_notifications.id,tbl_notifications.`to`,
tbl_notifications.`from`,tbl_notifications.`subject`,tbl_notifications.message,tbl_notifications.sent_on,
tbl_notifications.is_read FROM tbl_notifications LEFT JOIN tbl_users ON tbl_notifications.`from` = tbl_users.user_id where `to` ='".$mySessionFront->user['FrontUserId']."' ORDER BY is_read=0 DESC";
				//prd($qry);
			$Inbox = $db->runQuery("$Inbox_Qry");
				//prd($Inbox);
			$this->view->Inbox=$Inbox;
		//============================================ Recommended Jobs ======================================//		
		//user_industry
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry limit 0,5";
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;
		//============================================ ALL Jobs ======================================//		
		//user_industry
		$All_Job_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry";
		//prd($All_Job_Qry);
		$All_Job = $db->runQuery($All_Job_Qry);
		//prd($All_Job);
		$this->view->All_Job=$All_Job;
		
	   //===================================== Saved Jobs ========================================//
		$save_qry="SELECT COUNT(job_id) as TotalSave FROM tbl_saved_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Save);
		$this->view->SaveJobs=$Job_Save[0];
		
		//===================================== Applied Jobs =====================================//
		$Apply_Qry="SELECT COUNT(job_id) as TotalApply FROM tbl_applied_jobs WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Apply_Job = $db->runQuery("$Apply_Qry");
		//prd($Apply_Job);
		$this->view->Apply_Job=$Apply_Job[0];
		
		//===================================== Notifications =====================================//
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
	  	
    }
	
	//================================== Notification Inbox Ajax... ================================== //
	public function inboxAction()
	{	
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		//$arr=$this->getRequest()->getParams();
		//$this->view->country_id = $arr['country_id'];
		
		
			//prd($arr);
			$Inbox_Qry="SELECT * FROM tbl_notifications where `to` ='".$mySessionFront->user['FrontUserId']."'";
				//prd($qry);
			$Inbox = $db->runQuery("$Inbox_Qry");
				//prd($Inbox);
			$this->view->Inbox=$Inbox;
		
	}
	
	public function sendmsgAction() 
	{
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
		//$arr=$this->getRequest()->getParams();
		
		$UserMsg = $this->_request->getParam('UserMsg');
		$sendto = $this->_request->getParam('sendto');
		$msgid = $this->_request->getParam('msgid');
		if ($this->_request->isPost())
		{	
			//prd($UserMsg,'', $sendto);
			prd($msgid.''.$UserMsg.''.$sendto);
			echo $UserMsg;
		}
	}
	
	//================================== Notification Is Read ... ================================== //
	public function isreadAction(){
		global $mySessionFront;
	  	$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams();
		
		if($arr['id']) {
			
			//prd($arr);
			$data='';
			$data['is_read']='1';
				//prd($data);
			$modelobj = new Model_Mainmodel();
			//$insid = $modelobj->insertThis('tbl_applied_jobs',$data);
			$condition="id='".$arr['id']."'";
			$modelobj->updateThis('tbl_notifications',$data,$condition);	
			
			}
	}
	
	
	
//============================================ Job  Profile Views ======================================//
	public function profileviewAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}
		$qry= "SELECT * FROM `tbl_users` where user_id='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData;
	   
	  	
    }
	
//============================================ Job  Recommended Jobs ======================================//
	public function  recommendedAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login First..."; 
			$this->_redirect('index');
			
		}
		$qry= "SELECT * FROM `tbl_users` where user_id='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData;
	   
	  	
    }
//============================================			======================================//
	public function updateuserAction(){
		global $mySessionFront;
	  	$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams();
		
		if($arr['user_id'] && $arr['user_fname']&& $arr['user_lname']) {
			
			//prd($arr);
			
			$data='';
			$data['job_id']=$arr['user_id'];
			$data['user_fname']=$arr['user_fname'];   
			$data['user_lname'] =$arr['user_lname'];
				
				prd($data);
			
			$modelobj = new Model_Mainmodel();
			
			$condition="job_id='".$arr['job_id']."'";
			$modelobj->updateThis('tbl_users',$Data,$condition);
			$mySessionFront->sucMsg ="Job Apply Successfully.";		
			
			}
	}		
//============================================			======================================//
	public function profilestatsAction(){
		global $mySessionFront;
	  	$db=new Db();
		$arr=$this->getRequest()->getParams();
	//-------   Saved Jobs ------//
		$save_qry="SELECT COUNT(job_id) as TotalSave FROM tbl_saved_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Save);
		$this->view->SaveJobs=$Job_Save[0];
	
	//-------   Applied Jobs ------//
		$Apply_Qry="SELECT COUNT(job_id) as TotalApply FROM tbl_applied_jobs WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Apply_Job = $db->runQuery("$Apply_Qry");
		//prd($Apply_Job);
		$this->view->Apply_Job=$Apply_Job[0];
		
	//-------   Notifications  ------//
		$Noti_qry="SELECT COUNT(job_id) as TotalApply FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
			
	//-------   Profile Views  ------//
		$save_qry="SELECT COUNT(job_id) as TotalApply FROM tbl_notifications WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Details);
		$this->view->SaveJobs=$Job_Save[0];		
	}
	
//============================================	All Jobs ======================================//	
	public function alljobsAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}
		//===================================== User Profile ========================================//
		$qry= "SELECT
tbl_countries.country_name,
tbl_career_levels.career_level_title,
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone,
tbl_users.user_image,
tbl_users.user_gender,
tbl_nationalities.nation_title,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_job_educations.education_title,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary
FROM
tbl_users
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id
WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
		
		//===================================== Saved List ========================================//
		$Save_Job_List_Qry="SELECT
tbl_career_levels.career_level_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_job_categories.category_title,
tbl_saved_jobs.job_saved_on,
tbl_jobs.job_description,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_saved_jobs.user_id,
tbl_users.user_company,
tbl_job_roles.job_role_title
FROM
tbl_saved_jobs
LEFT JOIN tbl_jobs ON tbl_saved_jobs.job_id = tbl_jobs.id
LEFT JOIN tbl_career_levels ON tbl_career_levels.career_level_id = tbl_jobs.job_career_level
LEFT JOIN tbl_job_categories ON tbl_job_categories.cat_id = tbl_jobs.job_category
LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id
LEFT JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id WHERE tbl_saved_jobs.user_id='".$mySessionFront->user['FrontUserId']."' ORDER BY RAND()";
		//prd($Save_Job_Qry);	
		$Save_Job_List = $db->runQuery("$Save_Job_List_Qry");
		//prd($Save_Job_List);  
		$this->view->Save_Job_List=$Save_Job_List;
		//============================================ Recommended Jobs ======================================//		
		//user_industry
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry ORDER BY RAND() limit 0,5";
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;
		
		
	   //===================================== Count Saved Jobs ========================================//
		$save_qry="SELECT COUNT(job_id) as TotalSave FROM tbl_saved_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Save);
		$this->view->SaveJobs=$Job_Save[0];
		
		//===================================== Count Applied Jobs =====================================//
		$Apply_Qry="SELECT COUNT(job_id) as TotalApply FROM tbl_applied_jobs WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Apply_Job = $db->runQuery("$Apply_Qry");
		//prd($Apply_Job);
		$this->view->Apply_Job=$Apply_Job[0];
		
		//===================================== Count Notifications =====================================//
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
	  	
    }
	
	
	
}
?>
