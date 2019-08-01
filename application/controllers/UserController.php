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
	public function companyjobpostAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
		}
			$Employee_Qry= "SELECT
	tbl_countries.country_name,
	tbl_career_levels.career_level_title,
	tbl_nationalities.nation_title,
	tbl_job_categories.category_title,
	tbl_users.user_id,
	tbl_users.user_fname,
	tbl_users.user_lname,
	tbl_users.user_email,
	tbl_users.user_phone_country_code,
	tbl_users.user_phone,
	tbl_users.user_phone_extn_code,
	tbl_users.user_image,
	tbl_users.user_address_line_1,
	tbl_users.user_address_line_2,
	tbl_users.user_city,
	tbl_users.user_company,
	tbl_users.user_company_address_line_1,
	tbl_users.user_company_address_line_2,
	tbl_users.user_company_web_url,
	tbl_users.user_company_phone_number,
	tbl_users.user_company_fax_country_code,
	tbl_users.user_company_phone_ext,
	tbl_users.user_company_personal_designation,
	tbl_users.user_company_phone_country_code,
	tbl_users.user_company_detail,
	tbl_users.user_annual_revenue,
	tbl_users.user_profile_summary,
	tbl_users.map_code,
	tbl_users.user_number_of_employees,
	tbl_users.user_jobs_available,
	tbl_users.user_jobs_expire_on,
	tbl_users.user_featured_jobs_available,
	tbl_users.user_resume_membership_expires_on
	FROM
	tbl_users
	LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
	LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
	LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id ,
	tbl_job_sub_categories
	WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Employee_Data = $Employee_GetData[0];
//================================== Side Bar ======================================//
//================================== Side Bar ======================================//
		
			//-------   Saved Jobs ------//
			$save_qry="SELECT COUNT(user_id) as TotalSave FROM tbl_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."' and job_status='0'";
			//prd($qry);
			$Job_Save = $db->runQuery("$save_qry");
			//prd($Job_Save);
			$this->view->Emp_SaveJobs=$Job_Save[0];
			
			//-------   Jobs Posted ------//
$Posted_Job_Qry="SELECT COUNT(user_id) as TotalApply FROM tbl_jobs  WHERE user_id ='".$mySessionFront->user['FrontUserId']."' and job_status='1'";
			//prd($qry);
			$Posted_Job = $db->runQuery("$Posted_Job_Qry");
			//prd($Apply_Job);
			$this->view->Emp_Posted_Job=$Posted_Job[0];
			
			//-------   Notifications  ------//
			$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Noti_qry);
			$Job_Noti = $db->runQuery("$Noti_qry");
			//prd($Job_Noti);
			$this->view->Emp_Job_Noti=$Job_Noti[0];
//=========================================   Resumes  ==========================//
		$Resumes_Qry="SELECT COUNT(`employer_id`) as Total_Resumes FROM tbl_saved_resumes WHERE `employer_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];
		
			/*$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Noti_qry);
			$Job_Noti = $db->runQuery("$Noti_qry");
			//prd($Job_Noti);
			$this->view->Emp_Job_Noti=$Job_Noti[0];*/
		
		
			$Company_Job_Post_Qry= "SELECT
tbl_jobs.id,
tbl_jobs.user_id,
tbl_jobs.job_title,
tbl_jobs.job_description,
tbl_jobs.job_posted_on,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_job_sub_categories.sub_category_title,
tbl_job_categories.category_title,
tbl_job_roles.job_role_title,
tbl_career_levels.career_level_title
FROM
tbl_jobs
LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id
INNER JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
INNER JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
INNER JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
INNER JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
WHERE tbl_jobs.user_id ='".$mySessionFront->user['FrontUserId']."'";
			$Company_Job_Post_GetData = $db->runQuery($Company_Job_Post_Qry);
				//prd($Company_Job_Post_GetData); 
			$this->view->Company_Job_Post_List = $Company_Job_Post_GetData;
	}

	public function companysingaljoblistAction(){
      	global $mySessionFront;
	  	$db=new Db();
		
		$arr=$this->getRequest()->getParams('job_id');
		//prd($arr);
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
		}
			$Employee_Qry= "SELECT
	tbl_countries.country_name,
	tbl_career_levels.career_level_title,
	tbl_nationalities.nation_title,
	tbl_job_categories.category_title,
	tbl_users.user_id,
	tbl_users.user_fname,
	tbl_users.user_lname,
	tbl_users.user_email,
	tbl_users.user_phone_country_code,
	tbl_users.user_phone,
	tbl_users.user_phone_extn_code,
	tbl_users.user_image,
	tbl_users.user_address_line_1,
	tbl_users.user_address_line_2,
	tbl_users.user_city,
	tbl_users.user_company,
	tbl_users.user_company_address_line_1,
	tbl_users.user_company_address_line_2,
	tbl_users.user_company_web_url,
	tbl_users.user_company_phone_number,
	tbl_users.user_company_fax_country_code,
	tbl_users.user_company_phone_ext,
	tbl_users.user_company_personal_designation,
	tbl_users.user_company_phone_country_code,
	tbl_users.user_company_detail,
	tbl_users.user_annual_revenue,
	tbl_users.user_profile_summary,
	tbl_users.map_code,
	tbl_users.user_number_of_employees,
	tbl_users.user_jobs_available,
	tbl_users.user_jobs_expire_on,
	tbl_users.user_featured_jobs_available,
	tbl_users.user_resume_membership_expires_on
	FROM
	tbl_users
	LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
	LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
	LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id ,
	tbl_job_sub_categories
	WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Employee_Data = $Employee_GetData[0];
//================================== Side Bar ======================================//
			//-------   Saved Jobs ------//
			$save_qry="SELECT COUNT(user_id) as TotalSave FROM tbl_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."' and job_status='0'";
			//prd($qry);
			$Job_Save = $db->runQuery("$save_qry");
			//prd($Job_Save);
			$this->view->Emp_SaveJobs=$Job_Save[0];
			
			//-------   Jobs Posted ------//
$Posted_Job_Qry="SELECT COUNT(user_id) as TotalApply FROM tbl_jobs  WHERE user_id ='".$mySessionFront->user['FrontUserId']."' and job_status='1'";
			//prd($qry);
			$Posted_Job = $db->runQuery("$Posted_Job_Qry");
			//prd($Apply_Job);
			$this->view->Emp_Posted_Job=$Posted_Job[0];
			
			//-------   Notifications  ------//
			$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Noti_qry);
			$Job_Noti = $db->runQuery("$Noti_qry");
			//prd($Job_Noti);
			$this->view->Emp_Job_Noti=$Job_Noti[0];
//=========================================   Resumes  ==========================//
		$Resumes_Qry="SELECT COUNT(`employer_id`) as Total_Resumes FROM tbl_saved_resumes WHERE `employer_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];
//================================== Side Bar ======================================//
			$Company_Emp_Job_Singal_Qry= "SELECT
tbl_jobs.job_title,
tbl_jobs.job_description,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.is_current,
tbl_user_experience.exp_year,
tbl_users.user_skills_n_expertise,
tbl_users.user_resume,
tbl_users.user_city,
tbl_countries.country_name,
tbl_career_levels.career_level_title,
tbl_job_educations.education_title,
tbl_user_education.is_heighest,
tbl_applied_jobs.job_id,
tbl_applied_jobs.user_id
FROM
tbl_applied_jobs
LEFT JOIN tbl_users ON tbl_applied_jobs.user_id = tbl_users.user_id
LEFT JOIN tbl_user_experience ON tbl_applied_jobs.user_id = tbl_user_experience.user_id
LEFT JOIN tbl_jobs ON tbl_jobs.id = tbl_applied_jobs.job_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_user_education ON tbl_users.user_id = tbl_user_education.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id WHERE job_id ='".$arr['job_id']."'";
			$Company_Emp_Job_Singal_Data = $db->runQuery($Company_Emp_Job_Singal_Qry);
				//prd($Company_Emp_Job_Singal_Data); 
			$this->view->Company_Job_Post_List = $Company_Job_Post_GetData;
			$this->view->Company_Job_Post_List_Singal = $Company_Job_Post_GetData[0];
	}
	
		
		
	
	
	
	
	
	
//============================================ Job Applied ======================================//
	
  	public function jobsappliedAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}
		//===================================== User Information ========================================//
		$qry= "SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
	tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
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
		
		$Rec_Qry="SELECT tbl_users.user_image,tbl_jobs.id,tbl_jobs.job_title,tbl_jobs.job_posted_on,tbl_jobs.job_city,tbl_countries.country_name,tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id WHERE job_status='1' and job_category = '".$mySessionFront->user['user_industry']."' ORDER BY RAND() limit 0,5";
			//prd($Rec_Qry);
			$Rec_Job = $db->runQuery($Rec_Qry);
			//prd($Rec_Job);
			$this->view->Rec_Job=$Rec_Job;

		//================================== Advertisement  ======================================//
			$Add_Banner_Qry= "select * from tbl_banners ORDER BY RAND() limit 0,1";
			$Add_Banner_Val = $db->runQuery($Add_Banner_Qry);
				//prd($Add_Banner_Val); 
			$this->view->Add_Banner_Data = $Add_Banner_Val;
		//===================================== Saved Jobs ========================================//
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
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
		
		//-------   Profile Views  ------//
	$Pro_View_qry="SELECT COUNT(`apply_user_id`) as TotalViewPro FROM tbl_company_user_profile_view WHERE `apply_user_id` ='".$mySessionFront->user['FrontUserId']."'";
	//prd($Pro_View_qry);
		$Pro_View = $db->runQuery("$Pro_View_qry");
		//prd($Job_Noti);
		$this->view->Jobber_Pro_View=$Pro_View[0];
	  	
    }
//============================================ Job Saved ======================================//
	public function jobsavedAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}

		//===================================== User Information ========================================//
		$qry= "SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
	tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
		
		//================================== Advertisement  ======================================//
			$Add_Banner_Qry= "select * from tbl_banners ORDER BY RAND() limit 0,1";
			$Add_Banner_Val = $db->runQuery($Add_Banner_Qry);
				//prd($Add_Banner_Val); 
			$this->view->Add_Banner_Data = $Add_Banner_Val;
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
		//================================== Recommended Jobs ======================================//
		$Rec_Qry="SELECT tbl_users.user_image,tbl_jobs.id,tbl_jobs.job_title,tbl_jobs.job_posted_on,tbl_jobs.job_city,tbl_countries.country_name,tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id WHERE job_status='1' and job_category = '".$mySessionFront->user['user_industry']."' ORDER BY RAND() limit 0,5"; 
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;
		
		//================================== Side Bar ======================================//
		//================================== Side Bar ======================================//
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
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
		
		//-------   Profile Views  ------//
	$Pro_View_qry="SELECT COUNT(`apply_user_id`) as TotalViewPro FROM tbl_company_user_profile_view WHERE `apply_user_id` ='".$mySessionFront->user['FrontUserId']."'";
	//prd($Pro_View_qry);
		$Pro_View = $db->runQuery("$Pro_View_qry");
		//prd($Job_Noti);
		$this->view->Jobber_Pro_View=$Pro_View[0];
	  	
    }	
//============================================ Job Notifications ======================================//
	public function notificationAction(){
      	global $mySessionFront;
	  	$db=new Db();
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}
		//===================================== User Information ========================================//
		$qry= "SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
	tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
		
		//================================== Advertisement  ======================================//
			$Add_Banner_Qry= "select * from tbl_banners ORDER BY RAND() limit 0,1";
			$Add_Banner_Val = $db->runQuery($Add_Banner_Qry);
				//prd($Add_Banner_Val); 
			$this->view->Add_Banner_Data = $Add_Banner_Val;
		
		//===================================== Notifications List ========================================//
		$Inbox_Qry="SELECT tbl_users.user_fname,tbl_users.user_lname,tbl_users.user_company,tbl_notifications.id,tbl_notifications.`to`,
tbl_notifications.`from`,tbl_notifications.`subject`,tbl_notifications.message,tbl_notifications.sent_on,
tbl_notifications.is_read FROM tbl_notifications LEFT JOIN tbl_users ON tbl_notifications.`from` = tbl_users.user_id where `to` ='".$mySessionFront->user['FrontUserId']."' ORDER BY is_read=0 DESC";
				//prd($qry);
			$Inbox = $db->runQuery("$Inbox_Qry");
				//prd($Inbox);
			$this->view->Inbox=$Inbox;
		//================================== Recommended Jobs ======================================//
		$Rec_Qry="SELECT tbl_users.user_image,tbl_jobs.id,tbl_jobs.job_title,tbl_jobs.job_posted_on,tbl_jobs.job_city,tbl_countries.country_name,tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id WHERE job_status='1' and job_category = '".$mySessionFront->user['user_industry']."' ORDER BY RAND() limit 0,5"; 
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;
		
		//================================== Side Bar ======================================//
		//================================== Side Bar ======================================//
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
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
		
		//-------   Profile Views  ------//
	$Pro_View_qry="SELECT COUNT(`apply_user_id`) as TotalViewPro FROM tbl_company_user_profile_view WHERE `apply_user_id` ='".$mySessionFront->user['FrontUserId']."'";
	//prd($Pro_View_qry);
		$Pro_View = $db->runQuery("$Pro_View_qry");
		//prd($Job_Noti);
		$this->view->Jobber_Pro_View=$Pro_View[0];
	  	
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
		$db=new Db();
		//$this->_helper->layout()->setLayout('ajaxlayout');
		//$arr=$this->getRequest()->getParams();
		$subject = $this->_request->getParam('subject');
		$sendto = $this->_request->getParam('sendto');
		$sender = $this->_request->getParam('sender');
		$UserMsg = $this->_request->getParam('UserMsg');
		
		//prd($subject.'<br>'.$sendto.'<br>'.$sender.'<br>'.$UserMsg);
		
		$data='';
		$data['subject'] = $subject;		
		$data['from'] = $sender;
		$data['to'] = $sendto;
		$data['message'] = $UserMsg;
		$data['sent_on'] = date('Y-m-d');
		$data['is_read'] = '1';
		//prd($data);
		
		$modelobj = new Model_Mainmodel();
		$insid = $modelobj->insertThis('tbl_notifications',$data);
		$mySessionFront->sucMsg = "Msg send successfully updated";
		$this->_redirect('user/notification');
		
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
		//===================================== User Information ========================================//
		$qry= "SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
	tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
		
		//===================================== Profile View List ========================================//
		$View_Company_Qry="SELECT
tbl_company_user_profile_view.view_date,
tbl_company_user_profile_view.company_id,
tbl_users.user_company,
tbl_users.user_image,
tbl_users.user_profile_summary,
tbl_users.user_company_city,
tbl_users.user_company_address_line_1,
tbl_users.user_company_address_line_2,
tbl_job_categories.category_title,
tbl_users.user_number_of_employees
FROM
tbl_company_user_profile_view
LEFT JOIN tbl_users ON tbl_company_user_profile_view.company_id = tbl_users.user_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE apply_user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($Apply_Job_List_Qry);	
		$View_Company_List = $db->runQuery("$View_Company_Qry");
		//prd($Apply_Job_List);  
		$this->view->View_Company_Data=$View_Company_List;
		//============================================ Recommended Jobs ======================================//		
		
		$Rec_Qry="SELECT tbl_users.user_image,tbl_jobs.id,tbl_jobs.job_title,tbl_jobs.job_posted_on,tbl_jobs.job_city,tbl_countries.country_name,tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id WHERE job_status='1' and job_category = '".$mySessionFront->user['user_industry']."' ORDER BY RAND() limit 0,5";
			//prd($Rec_Qry);
			$Rec_Job = $db->runQuery($Rec_Qry);
			//prd($Rec_Job);
			$this->view->Rec_Job=$Rec_Job;

		//================================== Advertisement  ======================================//
			$Add_Banner_Qry= "select * from tbl_banners ORDER BY RAND() limit 0,1";
			$Add_Banner_Val = $db->runQuery($Add_Banner_Qry);
				//prd($Add_Banner_Val); 
			$this->view->Add_Banner_Data = $Add_Banner_Val;
		//===================================== Saved Jobs ========================================//
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
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
		
		//-------   Profile Views  ------//
	$Pro_View_qry="SELECT COUNT(`apply_user_id`) as TotalViewPro FROM tbl_company_user_profile_view WHERE `apply_user_id` ='".$mySessionFront->user['FrontUserId']."'";
	//prd($Pro_View_qry);
		$Pro_View = $db->runQuery("$Pro_View_qry");
		//prd($Job_Noti);
		$this->view->Jobber_Pro_View=$Pro_View[0];
	   
	  	
    }
	
	public function companydetailsAction(){
      	global $mySessionFront;
	  	$db=new Db();
		$arr = $this->_request->getParam('company_id');
		//prd($arr);
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
			
		}
		//===================================== Company Details ========================================//
			$Employee_Qry= "SELECT
tbl_countries.country_name,
tbl_career_levels.career_level_title,
tbl_nationalities.nation_title,
tbl_job_categories.category_title,
tbl_users.user_id,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone_country_code,
tbl_users.user_phone,
tbl_users.user_phone_extn_code,
tbl_users.user_image,
tbl_users.user_address_line_1,
tbl_users.user_address_line_2,
tbl_users.user_company_state,
tbl_users.user_city,
tbl_users.user_company,
tbl_users.user_company_address_line_1,
tbl_users.user_company_address_line_2,
tbl_users.user_company_web_url,
tbl_users.user_company_phone_number,
tbl_users.user_company_fax_country_code,
tbl_users.user_company_phone_ext,
tbl_users.user_company_personal_designation,
tbl_users.user_company_phone_country_code,
tbl_users.user_company_detail,
tbl_users.user_annual_revenue,
tbl_users.user_profile_summary,
tbl_users.map_code,
tbl_users.user_number_of_employees,
tbl_users.user_jobs_available,
tbl_users.user_jobs_expire_on,
tbl_users.user_featured_jobs_available,
tbl_users.user_resume_membership_expires_on,
tbl_users.user_featured_jobs_expire_on
FROM
	tbl_users
	LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
	
	LEFT JOIN tbl_countries ON tbl_users.user_company_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
	LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id ,
	tbl_job_sub_categories
WHERE user_id='".$arr['company_id']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($Employee_GetData); 
			$this->view->Employee_Data = $Employee_GetData[0];
		//============================================ Recommended Jobs ======================================//		
		
		$Rec_Qry="SELECT tbl_users.user_image,tbl_jobs.id,tbl_jobs.job_title,tbl_jobs.job_posted_on,tbl_jobs.job_city,tbl_countries.country_name,tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id WHERE job_status='1' and job_category = '".$mySessionFront->user['user_industry']."' ORDER BY RAND() limit 0,5";
			//prd($Rec_Qry);
			$Rec_Job = $db->runQuery($Rec_Qry);
			//prd($Rec_Job);
			$this->view->Rec_Job=$Rec_Job;

		//================================== Advertisement  ======================================//
			$Add_Banner_Qry= "select * from tbl_banners ORDER BY RAND() limit 0,1";
			$Add_Banner_Val = $db->runQuery($Add_Banner_Qry);
				//prd($Add_Banner_Val); 
			$this->view->Add_Banner_Data = $Add_Banner_Val;
		//===================================== Saved Jobs ========================================//
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
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
		
		//-------   Profile Views  ------//
	$Pro_View_qry="SELECT COUNT(`apply_user_id`) as TotalViewPro FROM tbl_company_user_profile_view WHERE `apply_user_id` ='".$mySessionFront->user['FrontUserId']."'";
	//prd($Pro_View_qry);
		$Pro_View = $db->runQuery("$Pro_View_qry");
		//prd($Job_Noti);
		$this->view->Jobber_Pro_View=$Pro_View[0];
	   
	  	
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
//===================================== Company Profile =====================================//	
		public function companyprofileAction()
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
	
		public function ajaxcompanyeditAction() 
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
	
		public function companybaseinfoAction(){
      
       	global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		$db=new Db();
		
		$qry= "SELECT tbl_countries.country_name,tbl_job_categories.category_title,tbl_users.user_fname,tbl_users.user_lname,tbl_users.user_company,
tbl_users.user_city FROM tbl_users LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
				
		
    }
	
		public function homeAction(){
		
		global $mySessionFront;
		$db=new Db();
		
		$qry= "SELECT * from tbl_job_categories where show_on_home_page='1' limit 0,8";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->Categories_Data = $GetData;
		//cat_id category_title  category_banner show_on_home_page
		
	// ================== Testimonials Data =======
		$Testimonial_Qry= "SELECT * FROM tbl_admin_messages ORDER BY testimonial_id DESC limit 0,6";
		$Testimonial_Data = $db->runQuery($Testimonial_Qry);
			//prd($Testimonial_Data); 
		$this->view->Testimonials_Data = $Testimonial_Data;
		
// ==================================== Job Autosugest =========================
		$Autosugest_Qry= "SELECT id, job_keywords FROM tbl_jobs ORDER BY job_title DESC";
		$Auto_Data = $db->runQuery($Autosugest_Qry);
			//prd($Auto_Data); 
		$this->view->Autosugest_Data = $Auto_Data;
// ==================================== Featured Employeers =========================
		//$Featured_Emp_Qry= "SELECT id, job_keywords FROM tbl_jobs where user_image ORDER BY user_image DESC";
		/*$Featured_Emp_Qry= "SELECT * FROM tbl_users where WHERE user_image is_null";
		$Featured_Emp_Data = $db->runQuery($Featured_Emp_Qry);
			//prd($Featured_Emp_Data); 
		$this->view->Autosugest_Data = $Autosugest_Data;	*/
			
//==================================================================

	$Home_Cat_Img_Qry="SELECT
tbl_job_categories.category_banner,
tbl_job_categories.category_title,
tbl_job_categories.cat_id
FROM
tbl_job_categories
LEFT JOIN tbl_jobs ON tbl_job_categories.cat_id = tbl_jobs.job_category WHERE cat_id = 2 ORDER BY category_banner";
			//prd($Home_Cat_Img_Qry);
			$Home_Cat_Data = $db->runQuery("$Home_Cat_Img_Qry");
				//prd($Home_Cat_Data);
			$this->view->Home_Cat_Img=$Home_Cat_Data[0];

		$qry="SELECT
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_description,
tbl_jobs.job_posted_on,
tbl_job_categories.category_title,
tbl_users.user_company,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_image,
tbl_jobs.job_city
FROM
tbl_jobs
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id
WHERE job_category ='28' ORDER BY tbl_jobs.job_posted_on DESC limit 0,2";
			//prd($qry);
			$cat_id = $db->runQuery("$qry");
				//prd($cat_id);
			$this->view->Cat_Details=$cat_id;
		
	}
	
}
?>
