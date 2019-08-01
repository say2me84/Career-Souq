<?php
class CompanyController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		global $mySessionFront;
	   $db=new Db();
	   
		if(!isLogged()) { 
		
			$this->_redirect('index/login');
			
		}
		
    }
	 /* Initialize action controller here */
	 
	public function indexAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   
		if(!isLogged()) { 
		
			$this->_redirect('index/login');
			
		}
		
		
		
			$Job_Seeker_Qry= "SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
	tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
			$Job_Seeker_GetData = $db->runQuery($Job_Seeker_Qry);
				//prd($Job_Seeker_GetData); 
			$this->view->Job_Seeker_Data = $Job_Seeker_GetData[0];
		
		//================================== Advertisement  ======================================//
			$Add_Banner_Qry= "select * from tbl_banners ORDER BY RAND() limit 0,2";
			$Add_Banner_Val = $db->runQuery($Add_Banner_Qry);
				//prd($Add_Banner_Val); 
			$this->view->Add_Banner_Data = $Add_Banner_Val;
		//================================== Multi Value ======================================//
			$User_Exp_Multi= "select * from tbl_user_experience where user_id ='".$mySessionFront->user['FrontUserId']."'";
			$User_Exp_Multi_Val = $db->runQuery($User_Exp_Multi);
			//prd($User_Exp_Multi_Val); 
			$this->view->User_Exp_All_Val = $User_Exp_Multi_Val;
		
		//================================== User Experience Details ======================================//
			//Singal Value
			
			//$User_Exp_Activ= "select * from tbl_user_experience where user_id ='".$mySessionFront->user['FrontUserId']."' and is_current = '1'";
			
			/*$User_Exp_Activ= "SELECT * FROM tbl_user_experience WHERE is_current ='1' and user_id = '".$mySessionFront->user['FrontUserId']."'";
			$User_Exp_User_Exp_Activ_Data = $db->runQuery($User_Exp_Activ);
			//prd($User_Exp_User_Exp_Activ_Data); 
			$this->view->User_Exp_User_Exp_Activ = $User_Exp_User_Exp_Activ_Data[0];*/
			
		//================================== Multi Value ======================================//
		
			$User_Education_Qry="SELECT	tbl_user_education.id,tbl_user_education.degree,tbl_user_education.university,tbl_user_education.starting_year,
		tbl_user_education.finishing_year,tbl_user_education.is_heighest,tbl_user_education.user_id,tbl_job_educations.education_title
		FROM tbl_user_education	LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id where user_id ='".$mySessionFront->user['FrontUserId']."'";
				//prd($User_Education_Qry);
				$User_Education = $db->runQuery("$User_Education_Qry");
				//prd($User_Education);
				$this->view->Education_Dashboard=$User_Education;
		
		//================================== Recommended Jobs ======================================//
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry ORDER BY RAND() limit 0,5";
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
		
		
		
		
//======================================================== Adding Employee Data ====================================================================//		
//======================================================== Adding Employee Data ====================================================================//
//======================================================== Adding Employee Data ====================================================================//
			
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
	tbl_users.user_resume_membership_expires_on
	FROM
	tbl_users
	LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
	
	LEFT JOIN tbl_countries ON tbl_users.user_company_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
	LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id ,
	tbl_job_sub_categories
	WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Employee_Data = $Employee_GetData[0];
//LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
		
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
		
    }	
	
	public function companypostedjobAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   
	   //==================== Company Posted Job Qry ==================== 
	   	$Posted_Job_Qry="SELECT
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_description,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_categories.category_title,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title,
tbl_countries.country_name,
tbl_career_levels.career_level_title
FROM
tbl_jobs
LEFT JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
WHERE user_id='".$mySessionFront->user['FrontUserId']."' and job_status='1'";	
		//prd($Posted_Job_Qry);
		$Posted_Job_Data = $db->runQuery($Posted_Job_Qry);
		//prd($Posted_Job_Data);
		$this->view->Company_Posted_Job_Data = $Posted_Job_Data;
		
		//==================== Company Basic Information Qry ==================== 
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
WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Company_Data = $Employee_GetData[0];
		
		
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
		$Resumes_Qry="SELECT COUNT(`company_id`) as Total_Resumes FROM tbl_company_user_profile_view WHERE `company_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];
		
	}
	
	public function companysavejobAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   
	   //==================== Company Posted Job Qry ==================== 
	   	$Posted_Job_Qry="SELECT
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_description,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_categories.category_title,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title,
tbl_countries.country_name,
tbl_career_levels.career_level_title
FROM
tbl_jobs
LEFT JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
WHERE user_id='".$mySessionFront->user['FrontUserId']."' and job_status='0'";	
		//prd($Posted_Job_Qry);
		$Posted_Job_Data = $db->runQuery($Posted_Job_Qry);
		//prd($Posted_Job_Data);
		$this->view->Company_Posted_Job_Data = $Posted_Job_Data;
		
		//==================== Company Basic Information Qry ==================== 
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
WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Company_Data = $Employee_GetData[0];
		
		
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
		$Resumes_Qry="SELECT COUNT(`company_id`) as Total_Resumes FROM tbl_company_user_profile_view WHERE `company_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];
	}
	
	public function companymsgAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   	
		//==================== Company Notifications Qry ==================== 
	   	$Inbox_Qry="SELECT tbl_users.user_fname,tbl_users.user_lname,tbl_users.user_company,tbl_notifications.id,tbl_notifications.`to`,
tbl_notifications.`from`,tbl_notifications.`subject`,tbl_notifications.message,tbl_notifications.sent_on,
tbl_notifications.is_read FROM tbl_notifications LEFT JOIN tbl_users ON tbl_notifications.`from` = tbl_users.user_id where `to` ='".$mySessionFront->user['FrontUserId']."' ORDER BY is_read=0 DESC";
				//prd($qry);
			$CompanyMsg = $db->runQuery("$Inbox_Qry");
				//prd($CompanyMsg);
			$this->view->CompanyMsg=$CompanyMsg;
			
			//==================== Company Basic Information Qry ==================== 
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
WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Company_Data = $Employee_GetData[0];
		
		
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
		$Resumes_Qry="SELECT COUNT(`company_id`) as Total_Resumes FROM tbl_company_user_profile_view WHERE `company_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];
			
	}
	
	public function companyresumesAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   	
		//==================== Company Resume Download Qry ==================== 
	   	$Resumes_Qry="SELECT
tbl_company_user_profile_view.profile_view_id,
tbl_company_user_profile_view.company_id,
tbl_company_user_profile_view.view_date,
tbl_company_user_profile_view.apply_user_id,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_city,
tbl_countries.country_name,
tbl_nationalities.nation_title,
tbl_career_levels.career_level_title,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.exp_year,
tbl_user_experience.salary,
tbl_user_experience.is_current,
tbl_user_education.is_heighest,
tbl_job_educations.education_title,
tbl_users.user_skills_n_expertise,
tbl_users.user_resume,
tbl_users.user_image
FROM
tbl_company_user_profile_view
LEFT JOIN tbl_users ON tbl_company_user_profile_view.apply_user_id = tbl_users.user_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_user_experience ON tbl_company_user_profile_view.apply_user_id = tbl_user_experience.user_id
LEFT JOIN tbl_user_education ON tbl_company_user_profile_view.apply_user_id = tbl_user_education.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
where is_current = '1' and is_heighest = '1' and company_id = '".$mySessionFront->user['FrontUserId']."' GROUP BY apply_user_id";
			//prd($Resumes_Qry);
			$Resumes_Qry_Data = $db->runQuery("$Resumes_Qry");
			//prd($Resumes_Qry_Data);
			$this->view->Resumes_Data=$Resumes_Qry_Data;
			
			//==================== Company Basic Information Qry ==================== 
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
WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($Employee_GetData); exit;
			$this->view->Company_Data = $Employee_GetData[0];
		
		
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
		$Resumes_Qry="SELECT COUNT(`company_id`) as Total_Resumes FROM tbl_company_user_profile_view WHERE `company_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];
	}	
	
	public function sendmsgAction(){
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
				$this->_redirect('company/companymsg');
				
			}	
					
	//================================== Notification Is Read ... ================================== //
				
				
				
				
				
				
				
	//================================== List of Job Applied User ================================== //
	public function userappliedjobAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   $arr=$this->getRequest()->getParams('job_id');
	   //==================== Applied User Short Details With CV ==================== 
	   	$Posted_Job_User_List_Qry="SELECT
tbl_applied_jobs.id as apply_job_id,
tbl_applied_jobs.job_id,
tbl_users.user_id,
tbl_applied_jobs.application_status,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_dob,
tbl_users.user_city,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_nationalities.nation_title,
tbl_career_levels.career_level_title,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.salary,
tbl_user_experience.is_current,
tbl_user_education.is_heighest,
tbl_job_educations.education_title,
tbl_users.user_resume,
tbl_users.user_image,
tbl_user_experience.exp_year,
tbl_user_experience.exp_month
FROM
tbl_applied_jobs
LEFT JOIN tbl_users ON tbl_applied_jobs.user_id = tbl_users.user_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id
LEFT JOIN tbl_user_education ON tbl_users.user_id = tbl_user_education.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
where is_current = '1' and is_heighest = '1' and job_id ='".$arr['job_id']."'";	
		//prd($Posted_Job_User_List_Qry);
		$Applied_Job_User_List = $db->runQuery($Posted_Job_User_List_Qry);
		//prd($Applied_Job_User_List);
		$this->view->Company_Posted_Job_Data = $Applied_Job_User_List;
		
		$this->view->single_job_id = $arr['job_id'];
		
		//==================== Company Basic Information Qry ==================== 
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
WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Company_Data = $Employee_GetData[0];
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
		$Resumes_Qry="SELECT COUNT(`company_id`) as Total_Resumes FROM tbl_company_user_profile_view WHERE `company_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];	
			

		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
//============================================== Applied User Short Details With CV ====================================================================
//============================================== Applied User Short Details With CV ====================================================================
		public function applyfilterAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   $arr=$this->getRequest()->getParams();
	   $arr_job_id=$this->getRequest()->getParams('job_id');
	   //prd($arr_job_id);

//============================================== Applied User Short Details With CV ====================================================================
//============================================== Applied User Short Details With CV ====================================================================
//============================================== Applied User Short Details With CV ==================================================================== 
		$wherecondition='';
		
		/*if (!empty($arr['user_fname'])) {
			$wherecondition .= " user_fname='".$arr['user_fname']."'";
		}*/
		if (!empty($arr['job_id'])) {
			$wherecondition .= " job_id='".$arr_job_id['job_id']."'";
		}
		if (!empty($arr['user_fname'])) {
				$wherecondition .= "and(user_fname like '".$arr['user_fname']."%')";
				//$wherecondition .= " (user_fname like '%".$arr['user_fname']."%' or user_lname like '%".$arr['user_fname']."%')";
		}
		if (!empty($arr['user_city'])) {
			$wherecondition .= "and (user_city like '".$arr['user_city']."%')";
		}
		if (!empty($arr['user_nationality'])) {
			$wherecondition .= " and user_nationality='".$arr['user_nationality']."'";
		}	
			$wherecondition .= " and exp_year BETWEEN '".$arr['st_yr']."' and '".$arr['mx_yr']."'";
	
		//if (!empty($arr['exp_year'])) {
			/*$dtr1=explode('-',$arr['salary']);
			$sallary_min =$dtr1[0];
			$sallary_max =$dtr1[1];	*/
			//$wherecondition .= " and exp_year BETWEEN '".$arr['st_yr']."' and '".$arr['mx_yr']."'";
		//}
		
			
	   	$Filter_Qry="SELECT
tbl_applied_jobs.id as apply_job_id,
tbl_applied_jobs.job_id,
tbl_users.user_id,
tbl_applied_jobs.application_status,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_dob,
tbl_users.user_city,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_nationalities.nation_title,
tbl_career_levels.career_level_title,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.salary,
tbl_user_experience.is_current,
tbl_user_education.is_heighest,
tbl_job_educations.education_title,
tbl_users.user_resume,
tbl_users.user_image,
tbl_user_experience.exp_year,
tbl_user_experience.exp_month
FROM
tbl_applied_jobs
LEFT JOIN tbl_users ON tbl_applied_jobs.user_id = tbl_users.user_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id
LEFT JOIN tbl_user_education ON tbl_users.user_id = tbl_user_education.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
where is_current = '1' and is_heighest = '1' AND ".$wherecondition;
		//prd($Filter_Qry);
		$Applied_Filter_List = $db->runQuery($Filter_Qry);
		//prd($Applied_Filter_List);
		$this->view->Applied_Filter_Data = $Applied_Filter_List;

//============================================== Applied User Short Details With CV ====================================================================
//============================================== Applied User Short Details With CV ====================================================================
//============================================== Applied User Short Details With CV ====================================================================
	
		//==================== Company Basic Information Qry ==================== 
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
WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Company_Data = $Employee_GetData[0];
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
		$Resumes_Qry="SELECT COUNT(`company_id`) as Total_Resumes FROM tbl_company_user_profile_view WHERE `company_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];	
		
	}
	
	//==================================================================================== Applied User Profile ================================== //
	public function applyuserdetailprofileAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   $arr=$this->getRequest()->getParams('user_id');
   //==================== Applied User Short Details With CV ==================== 
		$Job_Seeker_Qry= "SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id  ='".$arr['user_id']."'";
		$Job_Seeker_GetData = $db->runQuery($Job_Seeker_Qry);
			//prd($Job_Seeker_GetData); 
		$this->view->Job_Seeker_Data = $Job_Seeker_GetData[0];
		
		//==================== Company Basic Information Qry ==================== 
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
WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Company_Details = $Employee_GetData[0];
		
	//================================== Multi Value ======================================//
		$User_Exp_Multi= "select * from tbl_user_experience where user_id ='".$arr['user_id']."'";
		$User_Exp_Multi_Val = $db->runQuery($User_Exp_Multi);
			//prd($User_Exp_Multi_Val); 
		$this->view->User_Exp_All_Val = $User_Exp_Multi_Val;
	
	//================================== User Education Multi Value ======================================//
		$User_Education_Qry="SELECT	tbl_user_education.id,tbl_user_education.degree,tbl_user_education.university,tbl_user_education.starting_year,
		tbl_user_education.finishing_year,tbl_user_education.is_heighest,tbl_user_education.user_id,tbl_job_educations.education_title
		FROM tbl_user_education	LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id where user_id ='".$arr['user_id']."'";
			//prd($User_Education_Qry);
		$User_Education = $db->runQuery("$User_Education_Qry");
			//prd($User_Education);
		$this->view->Education_Dashboard=$User_Education;
	
	//================================== Side Bar ======================================//
	//================================== Side Bar ======================================//
		//-------   Jobs Posted ------//
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
			//-------   Notifications  ------//
			$Resumes_Qry="SELECT COUNT(`company_id`) as Total_Resumes FROM tbl_company_user_resumes WHERE `company_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];
		
		
	}
	
	//================================== Company View User Profile ================================== //
	public function companyviewuserproAction(){
		global $mySessionFront;
	  	$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams('company_id');
		
		//prd($arr);
		
		$dtr=explode('&',$arr['company_id']);
		$company_id = $data['company_id'] =  $dtr[0];
		//prd($company_id);
		
		$dtr=explode('&',$arr['company_id']);
		$apply_user_id = $data['company_id'] =  $dtr[1];
		//prd($apply_user_id);
		
		//
	//if($arr['company_id']) {
			
			//prd($arr);
			$data='';
			$data['company_id']= $company_id;
			$data['apply_user_id']= $apply_user_id;
			$data['view_date']= date("Y-m-d");
				//prd($data);
			
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_company_user_profile_view',$data);
			//$mySessionFront->sucMsg = "Msg send successfully updated";	
			
		//}
	}
	
	//================================== Download User Resume ================================== //
	public function resumesAction(){
		global $mySessionFront;
	  	$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams('company_id');
		
		//prd($arr);
		
		$dtr=explode('&',$arr['company_id']);
		$company_id = $data['company_id'] =  $dtr[0];
		//prd($company_id);
		
		$dtr=explode('&',$arr['company_id']);
		$apply_user_id = $data['company_id'] =  $dtr[1];
		//prd($apply_user_id);
		
		//
	//if($arr['company_id']) {
			
			//prd($arr);
			$data='';
			$data['company_id']= $company_id;
			$data['apply_user_id']= $apply_user_id;
			$data['view_date']= date("Y-m-d");
				//prd($data);
			
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_company_user_profile_view',$data);
			//$mySessionFront->sucMsg = "Msg send successfully updated";	
			
		//}
	}
	
	//================================== Save User Resume ================================== //
	public function saveresumesAction(){
		global $mySessionFront;
	  	$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams('company_id');
		
		//prd($arr);
		
		$dtr=explode('&',$arr['company_id']);
		$company_id = $data['company_id'] =  $dtr[0];
		//prd($company_id);
		
		$dtr=explode('&',$arr['company_id']);
		$resume_user_id = $data['company_id'] =  $dtr[1];
		//prd($apply_user_id);
		
		//
	//if($arr['company_id']) {
			
			//prd($arr);
			$data='';
			$data['company_id']= $company_id;
			$data['resume_user_id']= $resume_user_id;
			$data['download_date']= date("Y-m-d");
				//prd($data);
			
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_company_save_resumes',$data);
			//$mySessionFront->sucMsg = "Msg send successfully updated";	
			
		//}
	}
	
	//================================== Single Job Details ================================== //
		public function singlejobdetailAction(){
		global $mySessionFront;
	  	$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		//================================== Advertisement  ======================================//
			$Add_Banner_Qry= "select * from tbl_banners ORDER BY RAND() limit 0,1";
			$Add_Banner_Val = $db->runQuery($Add_Banner_Qry);
				//prd($Add_Banner_Val); 
			$this->view->Add_Banner_Data = $Add_Banner_Val;
		
		if($arr['id']) {
			$qry="SELECT
tbl_jobs.id,
tbl_jobs.job_reference_no,
tbl_jobs.job_title,
tbl_jobs.job_keywords,
tbl_jobs.job_url,
tbl_jobs.job_category,
tbl_jobs.job_sub_category,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_skills_required,
tbl_jobs.job_country,
tbl_jobs.job_city,
tbl_jobs.job_employment_type,
tbl_jobs.job_type,
tbl_jobs.job_education,
tbl_jobs.job_career_level,
tbl_jobs.job_experience,
tbl_jobs.job_role,
tbl_jobs.job_travel_required,
tbl_jobs.job_relocation,
tbl_jobs.job_sallary,
tbl_jobs.job_other_pay,
tbl_jobs.job_email,
tbl_jobs.job_phone_number,
tbl_jobs.job_contact_name,
tbl_jobs.job_fax,
tbl_jobs.job_posted_on,
tbl_jobs.job_expired_on,
tbl_jobs.job_status,
tbl_jobs.job_is_new,
tbl_jobs.job_is_featured,
tbl_jobs.job_bg_color,
tbl_jobs.job_logo_bg_color,
tbl_jobs.job_menu_color,
tbl_jobs.job_foreground_color,
tbl_jobs.job_menu_foreground_color,
tbl_jobs.Company_Logo,
tbl_jobs.Header_Banner,
tbl_jobs.Content_Banner,
tbl_jobs.job_total_hits,
tbl_jobs.job_viewed_by,
tbl_jobs.job_is_saved,
tbl_jobs.user_id,
tbl_jobs.employment_id,
tbl_jobs.id,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_city,
tbl_countries.country_name,
tbl_job_categories.category_title,
tbl_job_sub_categories.sub_category_title,
tbl_jobs.job_sallary,
tbl_career_levels.career_level_title,
tbl_job_experiences.experience_title,
tbl_job_educations.education_title,
tbl_jobs.job_skills_required,
tbl_users.user_image,
tbl_users.user_company,
tbl_job_roles.job_role_title,
tbl_employment_type.employment_title
FROM
tbl_jobs
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_experiences ON tbl_jobs.job_experience = tbl_job_experiences.id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id
LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id
LEFT JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
LEFT JOIN tbl_employment_type ON tbl_jobs.job_employment_type = tbl_employment_type.employment_id
WHERE tbl_jobs.id='".$arr['id']."'";
			//prd($qry);
			$Job_Details = $db->runQuery("$qry");
			//prd($Job_Details);
			$this->view->Job_Details=$Job_Details[0];
		
		}
		//================================== Side Bar ======================================//
		//================================== Side Bar ======================================//
			//==================== Company Basic Information Qry ==================== 
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
	tbl_users.user_featured_jobs_expire_on,
	tbl_users.user_resume_membership_expires_on
	FROM
	tbl_users
	LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
	
	LEFT JOIN tbl_countries ON tbl_users.user_company_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
	LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id ,
	tbl_job_sub_categories
	WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
			$Employee_GetData = $db->runQuery($Employee_Qry);
			//prd($GetData); exit;
			$this->view->Company_Data = $Employee_GetData[0];
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
		$Resumes_Qry="SELECT COUNT(`company_id`) as Total_Resumes FROM tbl_company_user_profile_view WHERE `company_id` ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Resumes_Qry);
		$Resumes_Data = $db->runQuery("$Resumes_Qry");
				//prd($Resumes_Data);
		$this->view->Resumes_Data_Total=$Resumes_Data[0];
	
	}
	
	
	
	
	
	
	
	
//=================================================================== Ending Index =====================================================================//

	
	
}
?>
