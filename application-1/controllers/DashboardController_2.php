<?php
class DashboardController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }
	public function indexAction(){
      
       global $mySessionFront;
	   $db=new Db();
	   
		if(!isLogged()) { 
		
			$this->_redirect('index/login');
			
		}
		
		if($mySessionFront->user['userRole']=='Job Seeker') { 
		
		$qry= "SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
			//prd($GetData); 
		$this->view->UserData = $GetData[0];
		
//================================== User Experience Details ======================================//
		//Singal Value
		
		$User_Exp= "select * from tbl_user_experience where user_id ='".$mySessionFront->user['FrontUserId']."' and is_current = '1'";
		$User_Exp_Data = $db->runQuery($User_Exp);
		//prd($User_Exp_Data); 
		$this->view->User_Exp_Data = $User_Exp_Data[0];
		
		//Multi Value
		$User_Exp_Multi= "select * from tbl_user_experience where user_id ='".$mySessionFront->user['FrontUserId']."'";
		$User_Exp_Multi_Val = $db->runQuery($User_Exp_Multi);
		//prd($User_Exp_Multi_Val); 
		$this->view->User_Exp_All_Val = $User_Exp_Multi_Val;
		
		
//==============================================================================================================================================//
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
		//-------   Education List  ------//		
		$User_Education_Qry="SELECT
tbl_user_education.id,
tbl_user_education.degree,
tbl_user_education.university,
tbl_user_education.starting_year,
tbl_user_education.finishing_year,
tbl_user_education.is_heighest,
tbl_user_education.user_id,
tbl_job_educations.education_title
FROM
tbl_user_education
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($User_Education_Qry);
		$User_Education = $db->runQuery("$User_Education_Qry");
		//prd($User_Education);
		$this->view->Education_Dashboard=$User_Education;
		
//============================================ Recommended Jobs ======================================//		
		//user_industry
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry limit 0,5";
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;	
		
//============================================  User Experience ======================================//		
		//user_industry
		$Experience_Qry="SELECT tbl_user_experience.id, tbl_user_experience.position, tbl_user_experience.company, tbl_user_experience.location, tbl_user_experience.responsibility, tbl_user_experience.logo, tbl_user_experience.employment_period_from, tbl_user_experience.employment_period_to,
tbl_user_experience.exp_year, tbl_user_experience.exp_month, tbl_user_experience.salary, tbl_user_experience.is_current, tbl_countries.country_name,
tbl_user_experience.user_id FROM tbl_user_experience LEFT JOIN tbl_users ON tbl_user_experience.user_id = tbl_users.user_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id where tbl_user_experience.user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Rec_Qry);
		$User_Experience = $db->runQuery($Experience_Qry);
		//prd($User_Experience);
		$this->view->User_Experience=$User_Experience;			
		
		
		
				
		} else {
//============================================ Adding Employee Data ======================================//
			
			$qry= "SELECT
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
tbl_users.user_number_of_employees
FROM
tbl_users
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id ,
tbl_job_sub_categories
WHERE user_id ='".$mySessionFront->user['FrontUserId']."' GROUP BY user_id";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData[0];
		
			//-------   Saved Jobs ------//
		$save_qry="SELECT COUNT(job_id) as TotalSave FROM tbl_saved_jobs WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Save);
		$this->view->SaveJobs=$Job_Save[0];
		
		//-------   Jobs Posted ------//
		$Posted_Job_Qry="SELECT COUNT(user_id) as TotalApply FROM tbl_jobs  WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Posted_Job = $db->runQuery("$Posted_Job_Qry");
		//prd($Apply_Job);
		$this->view->Posted_Job=$Posted_Job[0];
		
		//-------   Notifications  ------//
		$Noti_qry="SELECT COUNT(`to`) as TotalNoti FROM tbl_notifications WHERE `to` ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Noti_qry);
		$Job_Noti = $db->runQuery("$Noti_qry");
		//prd($Job_Noti);
		$this->view->Job_Noti=$Job_Noti[0];
		//-------   Education List  ------//		
		$User_Education_Qry="SELECT
tbl_user_education.id,tbl_user_education.degree,tbl_user_education.university,tbl_user_education.starting_year,tbl_user_education.finishing_year,
tbl_user_education.is_heighest,tbl_user_education.user_id,tbl_job_educations.education_title FROM tbl_user_education
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($User_Education_Qry);
		$User_Education = $db->runQuery("$User_Education_Qry");
		//prd($User_Education);
		$this->view->Education_Dashboard=$User_Education;
		
//============================================ Recommended Jobs ======================================//		
		//user_industry
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs INNER JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry limit 0,5";
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;	
		
//============================================  User Experience ======================================//		
		//user_industry
		$Experience_Qry="SELECT tbl_user_experience.id, tbl_user_experience.position, tbl_user_experience.company, tbl_user_experience.location, tbl_user_experience.responsibility, tbl_user_experience.logo, tbl_user_experience.employment_period_from, tbl_user_experience.employment_period_to,
tbl_user_experience.exp_year, tbl_user_experience.exp_month, tbl_user_experience.salary, tbl_user_experience.is_current, tbl_countries.country_name,
tbl_user_experience.user_id FROM tbl_user_experience LEFT JOIN tbl_users ON tbl_user_experience.user_id = tbl_users.user_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id where tbl_user_experience.user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Rec_Qry);
		$User_Experience = $db->runQuery($Experience_Qry);
		//prd($User_Experience);
		$this->view->User_Experience=$User_Experience;
//============================================ Employee ======================================//


//============================================ Credit Info ======================================//
		$Job_Credit_Qry= "SELECT * FROM tbl_Normal_job WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Credit_Data = $db->runQuery($Job_Credit_Qry);
		//prd($Job_Credit_Data); exit;
		$this->view->Credit_Data = $Job_Credit_Data[0];
	

		}
    }	
	//Editing Records...
	
	
//=================================================================== Ending Index =====================================================================//
	public function companyeditAction()
	{	
		global $mySessionFront;
		$db=new Db();
		$this->view->pagetitle = 'Edit Personal Information ';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['user_id']) {
		$this->view->id = $arr['user_id'];
		$form = new Form_Companyedit($arr['user_id']);
		$this->view->myform=$form;	
		
		$Company_Qry="SELECT
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone_country_code,
tbl_users.user_phone,
tbl_users.user_phone_extn_code,
tbl_users.user_image,
tbl_users.user_password,
tbl_users.user_gender,
tbl_users.user_number_of_dependants,
tbl_users.user_nationality,
tbl_users.user_address_line_1,
tbl_users.user_address_line_2,
tbl_users.Residence_Location,
tbl_users.user_country,
tbl_users.user_city,
tbl_users.user_language_preference,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_users.user_education,
tbl_users.user_experience,
tbl_users.user_experience_year,
tbl_users.user_career_level,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary,
tbl_users.user_resume,
tbl_users.user_company,
tbl_users.user_employer_type,
tbl_users.user_company_address_line_1,
tbl_users.user_company_address_line_2,
tbl_users.user_po_box,
tbl_users.user_company_state,
tbl_users.user_company_city,
tbl_users.user_zip,
tbl_users.user_company_country,
tbl_users.user_company_web_url,
tbl_users.user_company_personal_designation,
tbl_users.user_company_phone_country_code,
tbl_users.user_company_phone_number,
tbl_users.user_company_phone_ext,
tbl_users.user_company_fax_country_code,
tbl_users.user_company_fax_number,
tbl_users.user_company_fax_ext,
tbl_users.user_company_evening_phone_country_code,
tbl_users.user_company_evening_phone,
tbl_users.user_company_evening_phone_extension_code,
tbl_users.user_mobile_country_code,
tbl_users.user_mobile,
tbl_users.user_fax_country_code,
tbl_users.user_fax_number,
tbl_users.user_fax_ext,
tbl_users.user_company_detail,
tbl_users.user_industry,
tbl_users.user_annual_revenue,
tbl_users.user_number_of_employees,
tbl_users.user_job_posting_membership_taken_on,
tbl_users.user_jobs_available,
tbl_users.user_jobs_expire_on,
tbl_users.user_featured_jobs_available,
tbl_users.user_featured_jobs_expire_on,
tbl_users.user_resume_membership_taken_on,
tbl_users.user_resume_membership_expires_on,
tbl_users.user_resume_membership,
tbl_users.user_payment_method,
tbl_users.user_credit_card_type,
tbl_users.user_credit_card_fname,
tbl_users.user_credit_card_lname,
tbl_users.user_credit_card_number,
tbl_users.user_credit_card_cvn,
tbl_users.user_credit_card_expiry_date_month,
tbl_users.user_credit_card_expiry_date_year,
tbl_users.user_created_on,
tbl_users.user_last_sign_in,
tbl_users.user_last_IP,
tbl_users.user_param,
tbl_users.user_verified,
tbl_users.user_is_new,
tbl_users.user_is_blocked,
tbl_users.user_profile_views,
tbl_users.map_code,
tbl_job_categories.category_title,
tbl_countries.country_name
FROM tbl_users LEFT JOIN tbl_countries ON tbl_users.Residence_Location = tbl_countries.country_id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
WHERE user_id ='".$arr['user_id']."'";	
		//prd($Company_Qry);
		$Company_Data = $db->runQuery($Company_Qry);
		//prd($Company_Data);
		$this->view->Company_Data = $Company_Data[0];
			
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
			//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			$Data='';
			$Data['user_gender'] = $formData['user_gender'];
			$Data['user_fname'] = $formData['user_fname'];
			$Data['user_nationality'] = $formData['Nationality_id'];	
			$Data['user_dob'] = $formData['user_dob'];	
			$Data['user_address_line_1'] = $formData['user_address_line_1'];	
			$Data['user_address_line_2'] = $formData['user_address_line_2'];
			$Data['user_po_box'] = $formData['user_po_box'];	
			$Data['user_zip'] = $formData['user_zip'];	
			$Data['Residence_Location'] = $formData['Country_id'];
			$Data['user_city'] = $formData['user_city'];
			$Data['user_email'] = $formData['user_email'];
			
			$Data['user_phone_country_code'] = $formData['user_phone_country_code'];
			$Data['user_phone'] = $formData['user_phone'];
			$Data['user_phone_extn_code'] = $formData['user_phone_extn_code'];
			
			$Data['user_company_evening_phone_country_code'] = $formData['user_company_evening_phone_country_code'];
			$Data['user_company_evening_phone'] = $formData['user_company_evening_phone'];
			$Data['user_company_evening_phone_extension_code'] = $formData['user_company_evening_phone_extension_code'];
			$Data['user_mobile_country_code'] = $formData['user_mobile_country_code'];
			$Data['user_mobile'] = $formData['user_mobile'];
			
			$Data['user_fax_country_code'] = $formData['user_fax_country_code'];
			$Data['user_fax_number'] = $formData['user_fax_number'];
			$Data['user_fax_ext'] = $formData['user_fax_ext'];
			
			$Data['user_company_web_url'] = $formData['user_company_web_url'];
			
				
//----------------------------------- Uploading Image Files -----------------------------------------------------------
		//prd($Data);	
			$condition = "user_id='".$arr['user_id']."'";
			$db->modify('tbl_users',$Data,$condition);
			$mySessionFront->sucMsg = "Data has been successfully updated";
			//$this->_redirect('dashboard');
			$this->_redirect("dashboard/companyedit/user_id/".$mySessionFront->user['FrontUserId']."");
				}
			 }
		
		}
	}
	
	
	public function companyinfoAction()
	{	
		global $mySessionFront;
		$db=new Db();
		$this->view->pagetitle = 'Edit Company Information ';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['user_id']) {
		$this->view->id = $arr['user_id'];
		$form = new Form_Companyinfo($arr['user_id']);
		$this->view->myform=$form;
		
		//	user_company_country
		
		$Company_Qry="SELECT
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone_country_code,
tbl_users.user_phone,
tbl_users.user_phone_extn_code,
tbl_users.user_image,
tbl_users.user_password,
tbl_users.user_gender,
tbl_users.user_number_of_dependants,
tbl_users.user_nationality,
tbl_users.user_address_line_1,
tbl_users.user_address_line_2,
tbl_users.Residence_Location,
tbl_users.user_country,
tbl_users.user_city,
tbl_users.user_language_preference,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_users.user_education,
tbl_users.user_experience,
tbl_users.user_experience_year,
tbl_users.user_career_level,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary,
tbl_users.user_resume,
tbl_users.user_company,
tbl_users.user_employer_type,
tbl_users.user_company_address_line_1,
tbl_users.user_company_address_line_2,
tbl_users.user_po_box,
tbl_users.user_company_state,
tbl_users.user_company_city,
tbl_users.user_zip,
tbl_users.user_company_country,
tbl_users.user_company_web_url,
tbl_users.user_company_personal_designation,
tbl_users.user_company_phone_country_code,
tbl_users.user_company_phone_number,
tbl_users.user_company_phone_ext,
tbl_users.user_company_fax_country_code,
tbl_users.user_company_fax_number,
tbl_users.user_company_fax_ext,
tbl_users.user_company_evening_phone_country_code,
tbl_users.user_company_evening_phone,
tbl_users.user_company_evening_phone_extension_code,
tbl_users.user_mobile_country_code,
tbl_users.user_mobile,
tbl_users.user_fax_country_code,
tbl_users.user_fax_number,
tbl_users.user_fax_ext,
tbl_users.user_company_detail,
tbl_users.user_industry,
tbl_users.user_annual_revenue,
tbl_users.user_number_of_employees,
tbl_users.user_job_posting_membership_taken_on,
tbl_users.user_jobs_available,
tbl_users.user_jobs_expire_on,
tbl_users.user_featured_jobs_available,
tbl_users.user_featured_jobs_expire_on,
tbl_users.user_resume_membership_taken_on,
tbl_users.user_resume_membership_expires_on,
tbl_users.user_resume_membership,
tbl_users.user_payment_method,
tbl_users.user_credit_card_type,
tbl_users.user_credit_card_fname,
tbl_users.user_credit_card_lname,
tbl_users.user_credit_card_number,
tbl_users.user_credit_card_cvn,
tbl_users.user_credit_card_expiry_date_month,
tbl_users.user_credit_card_expiry_date_year,
tbl_users.user_created_on,
tbl_users.user_last_sign_in,
tbl_users.user_last_IP,
tbl_users.user_param,
tbl_users.user_verified,
tbl_users.user_is_new,
tbl_users.user_is_blocked,
tbl_users.user_profile_views,
tbl_users.map_code,
tbl_job_categories.category_title,
tbl_countries.country_name
FROM tbl_users LEFT JOIN tbl_countries ON tbl_users.user_company_country = tbl_countries.country_id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
WHERE user_id='".$arr['user_id']."'";	
		//prd($Company_Qry);
		$Company_Data = $db->runQuery($Company_Qry);
		//prd($Company_Data);
		$this->view->Company_Data = $Company_Data[0];
		
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
			//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			$Data='';
			//	user_company_detail
			$Data['user_company'] = $formData['user_company'];
			$Data['user_industry'] = $formData['Company_Industry'];
			$Data['user_number_of_employees'] = $formData['user_number_of_employees'];
			$Data['user_company_detail'] = $formData['user_company_detail'];
			$Data['user_company_address_line_1'] = $formData['user_company_address_line_1'];
			$Data['user_company_address_line_2'] = $formData['user_company_address_line_2'];
			$Data['user_company_state'] = $formData['user_company_state'];
			$Data['user_zip'] = $formData['user_zip'];
			$Data['user_company_city'] = $formData['user_company_city'];
			$Data['user_company_personal_designation'] = $formData['user_company_personal_designation'];
			$Data['user_company_phone_country_code'] = $formData['user_company_phone_country_code'];
			$Data['user_company_phone_number'] = $formData['user_company_phone_number'];
			$Data['user_company_phone_ext'] = $formData['user_company_phone_ext'];
			$Data['user_company_fax_country_code'] = $formData['user_company_fax_country_code'];
			$Data['user_company_fax_number'] = $formData['user_company_fax_number'];
			$Data['user_company_fax_ext'] = $formData['user_company_fax_ext'];
			$Data['user_company_country'] = $formData['Country_id'];
		//prd($Data);	
		
			if(is_array($_FILES['user_image']) && $_FILES['user_image']['name']!='') {
						
						$ftype = $_FILES['user_image']['type'];
						$fname = $_FILES['user_image']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = "admin/upload/user_pic/";
						$ext = end(explode(".", $fname));
						$filename = $arr['user_id'].rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						//prd($uploadfile);
						// unlink Dir
						
						$dir = "admin/upload/user_pic/";
						unlink($dir.$formData['OldImagePath']);
						
						if (move_uploaded_file($_FILES['user_image']['tmp_name'], $uploadfile)) {
								//echo "Testin...."; exit;			  
						  
						  $Data['user_image'] = $filename;
						 
						 }
					}
		//prd($Data);
			$condition = "user_id='".$arr['user_id']."'";
			$db->modify('tbl_users',$Data,$condition);
//----------------------------------- Uploading Image Files -----------------------------------------------------------			
			$mySessionFront->sucMsg = "Data has been successfully updated";
			//$this->_redirect('dashboard');
		//	$this->_redirect("dashboard/companyinfo/$mySessionFront->user['FrontUserId']");
			$this->_redirect("dashboard/companyinfo/user_id/".$mySessionFront->user['FrontUserId']."");
				}
			 }
		
	
		}
	}
	
	
	
	public function mycreditsAction()
	{	
		global $mySessionFront;
		$db=new Db();
		$this->view->pagetitle = 'My Credits';
		
		$Company_Qry="SELECT
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone_country_code,
tbl_users.user_phone,
tbl_users.user_phone_extn_code,
tbl_users.user_image,
tbl_users.user_password,
tbl_users.user_gender,
tbl_users.user_number_of_dependants,
tbl_users.user_nationality,
tbl_users.user_address_line_1,
tbl_users.user_address_line_2,
tbl_users.Residence_Location,
tbl_users.user_country,
tbl_users.user_city,
tbl_users.user_language_preference,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_users.user_education,
tbl_users.user_experience,
tbl_users.user_experience_year,
tbl_users.user_career_level,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary,
tbl_users.user_resume,
tbl_users.user_company,
tbl_users.user_employer_type,
tbl_users.user_company_address_line_1,
tbl_users.user_company_address_line_2,
tbl_users.user_po_box,
tbl_users.user_company_state,
tbl_users.user_company_city,
tbl_users.user_zip,
tbl_users.user_company_country,
tbl_users.user_company_web_url,
tbl_users.user_company_personal_designation,
tbl_users.user_company_phone_country_code,
tbl_users.user_company_phone_number,
tbl_users.user_company_phone_ext,
tbl_users.user_company_fax_country_code,
tbl_users.user_company_fax_number,
tbl_users.user_company_fax_ext,
tbl_users.user_company_evening_phone_country_code,
tbl_users.user_company_evening_phone,
tbl_users.user_company_evening_phone_extension_code,
tbl_users.user_mobile_country_code,
tbl_users.user_mobile,
tbl_users.user_fax_country_code,
tbl_users.user_fax_number,
tbl_users.user_fax_ext,
tbl_users.user_company_detail,
tbl_users.user_industry,
tbl_users.user_annual_revenue,
tbl_users.user_number_of_employees,
tbl_users.user_job_posting_membership_taken_on,
tbl_users.user_jobs_available,
tbl_users.user_jobs_expire_on,
tbl_users.user_featured_jobs_available,
tbl_users.user_featured_jobs_expire_on,
tbl_users.user_resume_membership_taken_on,
tbl_users.user_resume_membership_expires_on,
tbl_users.user_resume_membership,
tbl_users.user_payment_method,
tbl_users.user_credit_card_type,
tbl_users.user_credit_card_fname,
tbl_users.user_credit_card_lname,
tbl_users.user_credit_card_number,
tbl_users.user_credit_card_cvn,
tbl_users.user_credit_card_expiry_date_month,
tbl_users.user_credit_card_expiry_date_year,
tbl_users.user_created_on,
tbl_users.user_last_sign_in,
tbl_users.user_last_IP,
tbl_users.user_param,
tbl_users.user_verified,
tbl_users.user_is_new,
tbl_users.user_is_blocked,
tbl_users.user_profile_views,
tbl_users.map_code,
tbl_job_categories.category_title,
tbl_countries.country_name
FROM tbl_users LEFT JOIN tbl_countries ON tbl_users.user_company_country = tbl_countries.country_id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
WHERE user_id='".$mySessionFront->user['FrontUserId']."'";	
		//prd($Company_Qry);
		$Company_Data = $db->runQuery($Company_Qry);
		//prd($Company_Data);
		$this->view->Company_Data = $Company_Data[0];
		
		$Job_Plan_Qry="select * from `tbl_users` where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Job_Plan_Qry);
		$Job_Plan_Data= $db->runQuery("$Job_Plan_Qry");
		//prd($Job_Plan_Data);
		$this->view->Job_Plan_Data=$Job_Plan_Data;
		
		$CV_Search_Qry="select * from `user_plan_details` where user_id ='".$mySessionFront->user['FrontUserId']."' and membership_plan_name = 'CV Search'";
		//prd($CV_Search_Qry);
		$CV_Search_Data= $db->runQuery("$CV_Search_Qry");
		//prd($CV_Search_Data);
		$this->view->CV_Search_Data=$CV_Search_Data;
	}
	
	public function paymentmethodAction()
	{	
		global $mySessionFront;
		$db=new Db();
		$this->view->pagetitle = 'Payment Method';
		
		$Company_Qry="SELECT
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone_country_code,
tbl_users.user_phone,
tbl_users.user_phone_extn_code,
tbl_users.user_image,
tbl_users.user_password,
tbl_users.user_gender,
tbl_users.user_number_of_dependants,
tbl_users.user_nationality,
tbl_users.user_address_line_1,
tbl_users.user_address_line_2,
tbl_users.Residence_Location,
tbl_users.user_country,
tbl_users.user_city,
tbl_users.user_language_preference,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_users.user_education,
tbl_users.user_experience,
tbl_users.user_experience_year,
tbl_users.user_career_level,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary,
tbl_users.user_resume,
tbl_users.user_company,
tbl_users.user_employer_type,
tbl_users.user_company_address_line_1,
tbl_users.user_company_address_line_2,
tbl_users.user_po_box,
tbl_users.user_company_state,
tbl_users.user_company_city,
tbl_users.user_zip,
tbl_users.user_company_country,
tbl_users.user_company_web_url,
tbl_users.user_company_personal_designation,
tbl_users.user_company_phone_country_code,
tbl_users.user_company_phone_number,
tbl_users.user_company_phone_ext,
tbl_users.user_company_fax_country_code,
tbl_users.user_company_fax_number,
tbl_users.user_company_fax_ext,
tbl_users.user_company_evening_phone_country_code,
tbl_users.user_company_evening_phone,
tbl_users.user_company_evening_phone_extension_code,
tbl_users.user_mobile_country_code,
tbl_users.user_mobile,
tbl_users.user_fax_country_code,
tbl_users.user_fax_number,
tbl_users.user_fax_ext,
tbl_users.user_company_detail,
tbl_users.user_industry,
tbl_users.user_annual_revenue,
tbl_users.user_number_of_employees,
tbl_users.user_job_posting_membership_taken_on,
tbl_users.user_jobs_available,
tbl_users.user_jobs_expire_on,
tbl_users.user_featured_jobs_available,
tbl_users.user_featured_jobs_expire_on,
tbl_users.user_resume_membership_taken_on,
tbl_users.user_resume_membership_expires_on,
tbl_users.user_resume_membership,
tbl_users.user_payment_method,
tbl_users.user_credit_card_type,
tbl_users.user_credit_card_fname,
tbl_users.user_credit_card_lname,
tbl_users.user_credit_card_number,
tbl_users.user_credit_card_cvn,
tbl_users.user_credit_card_expiry_date_month,
tbl_users.user_credit_card_expiry_date_year,
tbl_users.user_created_on,
tbl_users.user_last_sign_in,
tbl_users.user_last_IP,
tbl_users.user_param,
tbl_users.user_verified,
tbl_users.user_is_new,
tbl_users.user_is_blocked,
tbl_users.user_profile_views,
tbl_users.map_code,
tbl_job_categories.category_title,
tbl_countries.country_name
FROM tbl_users LEFT JOIN tbl_countries ON tbl_users.user_company_country = tbl_countries.country_id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
WHERE user_id='".$mySessionFront->user['FrontUserId']."'";	
		//prd($Company_Qry);
		$Company_Data = $db->runQuery($Company_Qry);
		//prd($Company_Data);
		$this->view->Company_Data = $Company_Data[0];
		
	}
	
	public function paymenthistoryAction()
	{	
		global $mySessionFront;
		$db=new Db();
		$this->view->pagetitle = 'Payment Method';
		
		$Company_Qry="SELECT
tbl_users.user_id,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_email,
tbl_users.user_phone_country_code,
tbl_users.user_phone,
tbl_users.user_phone_extn_code,
tbl_users.user_image,
tbl_users.user_password,
tbl_users.user_gender,
tbl_users.user_number_of_dependants,
tbl_users.user_nationality,
tbl_users.user_address_line_1,
tbl_users.user_address_line_2,
tbl_users.Residence_Location,
tbl_users.user_country,
tbl_users.user_city,
tbl_users.user_language_preference,
tbl_users.user_dob,
tbl_users.user_marital_status,
tbl_users.user_education,
tbl_users.user_experience,
tbl_users.user_experience_year,
tbl_users.user_career_level,
tbl_users.user_skills_n_expertise,
tbl_users.user_profile_summary,
tbl_users.user_resume,
tbl_users.user_company,
tbl_users.user_employer_type,
tbl_users.user_company_address_line_1,
tbl_users.user_company_address_line_2,
tbl_users.user_po_box,
tbl_users.user_company_state,
tbl_users.user_company_city,
tbl_users.user_zip,
tbl_users.user_company_country,
tbl_users.user_company_web_url,
tbl_users.user_company_personal_designation,
tbl_users.user_company_phone_country_code,
tbl_users.user_company_phone_number,
tbl_users.user_company_phone_ext,
tbl_users.user_company_fax_country_code,
tbl_users.user_company_fax_number,
tbl_users.user_company_fax_ext,
tbl_users.user_company_evening_phone_country_code,
tbl_users.user_company_evening_phone,
tbl_users.user_company_evening_phone_extension_code,
tbl_users.user_mobile_country_code,
tbl_users.user_mobile,
tbl_users.user_fax_country_code,
tbl_users.user_fax_number,
tbl_users.user_fax_ext,
tbl_users.user_company_detail,
tbl_users.user_industry,
tbl_users.user_annual_revenue,
tbl_users.user_number_of_employees,
tbl_users.user_job_posting_membership_taken_on,
tbl_users.user_jobs_available,
tbl_users.user_jobs_expire_on,
tbl_users.user_featured_jobs_available,
tbl_users.user_featured_jobs_expire_on,
tbl_users.user_resume_membership_taken_on,
tbl_users.user_resume_membership_expires_on,
tbl_users.user_resume_membership,
tbl_users.user_payment_method,
tbl_users.user_credit_card_type,
tbl_users.user_credit_card_fname,
tbl_users.user_credit_card_lname,
tbl_users.user_credit_card_number,
tbl_users.user_credit_card_cvn,
tbl_users.user_credit_card_expiry_date_month,
tbl_users.user_credit_card_expiry_date_year,
tbl_users.user_created_on,
tbl_users.user_last_sign_in,
tbl_users.user_last_IP,
tbl_users.user_param,
tbl_users.user_verified,
tbl_users.user_is_new,
tbl_users.user_is_blocked,
tbl_users.user_profile_views,
tbl_users.map_code,
tbl_job_categories.category_title,
tbl_countries.country_name
FROM tbl_users LEFT JOIN tbl_countries ON tbl_users.user_company_country = tbl_countries.country_id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
WHERE user_id='".$mySessionFront->user['FrontUserId']."'";	
		//prd($Company_Qry);
		$Company_Data = $db->runQuery($Company_Qry);
		//prd($Company_Data);
		$this->view->Company_Data = $Company_Data[0];
		
	}
	
	public function convertpdfAction()
	{	
		global $mySessionFront;
		$db=new Db();
		//$this->view->pagetitle = 'Payment Method';
		
		
		
	}
	
	
//===================== Ajax Load Profile Summery:: IN EDIT Mode :: ================================================================///
	public function usersummaryAction()
	{	$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		global $mySessionFront;
	   	if(!isLogged()) { 
			$this->_redirect('index');
		}
		$arr=$this->getRequest()->getParams('user_id');
		//$this->view->country_id = $arr['country_id'];
		
		if(@$arr['user_id']) {
			//prd($arr['user_id']);
			
			$qry="select * from `tbl_users` where user_id ='".$arr['user_id']."'";
			//prd($qry);
			$user_id = $db->runQuery("$qry");
				//prd($user_id);
			$this->view->user_id=$user_id[0];
		
		}
	}
	
	public function usersummaryeditAction() 
	{
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$user_id = $this->_request->getParam('user_id');
		$editor1 = $this->_request->getParam('editor1');
		
			//prd($user_id);
			//prd($editor1);
			if ($this->_request->isPost())
			{
				$data='';
				$data['user_profile_summary']=$editor1;
				
				$modelobj = new Model_Mainmodel();
				$condition="user_id='".$user_id."'";
				$modelobj->updateThis('tbl_users',$data,$condition);
				$mySessionFront->sucMsg = "Profile Summery Edit Success...";	
			}
			
	}
	
	public function reloadsummaryAction(){
      
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
		$this->view->UserSummaryData = $GetData[0];
				
		
    }
//===================== End Ajax Load Profile Summery:: IN EDIT Mode :: ================================================================///	

	public function neweditAction()
	{	
		global $mySessionFront;
		$db=new Db();
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		if($arr['user_id']) {
			$qry = "select * from `tbl_users` where user_id='".$mySessionFront->user['FrontUserId']."'";
				//prd($qry);
			$this->view->user_id = $arr['user_id'];
			$user_id = $db->runQuery($qry);
			$this->view->user_id_Data = $user_id[0];
		
		}
	}
	
	public function editAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
			
					
		}
		
		
	public function profilestatsAction(){
		global $mySessionFront;
	  	$db=new Db();
		$arr=$this->getRequest()->getParams();
	
		$save_qry="SELECT COUNT(job_id) as TotalApply FROM tbl_notifications WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$Job_Save = $db->runQuery("$save_qry");
		//prd($Job_Details);
		$this->view->SaveJobs=$Job_Save[0];		
	}
	
	
	//============================================ Upload Resume Ajax ======================================//
	public function resumeAction(){
      		global $mySessionFront;	
			$this->_helper->layout()->setLayout('ajaxlayout');
			
			$user_resume = $this->_request->getParam('user_resume');
			$user_id = $this->_request->getParam('user_id');
			
			$db=new Db();
			
			$uploaddir = 'upload/Upload_Resume/';
			
			if(isset($_FILES["user_resume"]))
			{
				//Filter the file types , if you want.
				if ($_FILES["user_resume"]["error"] > 0)
				{
				  echo "Error: " . $_FILES["file"]["error"] . "<br>";
				}
				else
				{
					//move the uploaded file to uploads folder;
					move_uploaded_file($_FILES["user_resume"]["tmp_name"],$uploaddir. $_FILES["user_resume"]["name"]);
				
					$modelobj = new Model_Mainmodel();
					  
					  $condition="user_id='".$user_id."'";
					  $modelobj->updateThis('tbl_users',$data,$condition);
					  $mySessionFront->sucMsg = "Resume Uploaded Success...";
					  
					  //echo "Uploaded File :".$_FILES["myfile"]["name"];
				}
			
			}
			
			/*if(isset($_FILES['user_resume']) && $_FILES['user_resume']['name']!='') {
					
					$ftype = $_FILES['user_resume']['type'];
					$fname = $_FILES['user_resume']['name'];
					
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					
					$uploaddir = 'upload/Upload_Resume/';
					
					$ext = end(explode(".", $fname));
					$filename = rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					//$filename = $insid.rand(100,900).'.'.$ext;
					
					//prd($filename);
					if (move_uploaded_file($_FILES['user_resume']['tmp_name'], $uploadfile)) {
										  
					  $data = '';
					  $data['user_resume'] = $filename;
					 
					  //$Data['CatDetailPath'] = $_FILES['VideoImage']['tmp_name'];
					 // prd($Data);
					  
					  $modelobj = new Model_Mainmodel();
					  
					  $condition="user_id='".$user_id."'";
					  $modelobj->updateThis('tbl_users',$data,$condition);
					  $mySessionFront->sucMsg = "Resume Uploaded Success...";
					  }
				}*/
				
		
    	}
		
	
	public function resumeeditAction(){
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
		$user_id = $this->_request->getParam('user_id');
		
		$path = 'upload/Upload_Resume/';
	$valid_formats = array("doc", "docx");
	//$valid_formats = array("jpg", "png", "gif", "bmp", "docx","rar");
		if(isset($_POST) )
		{
			$user_id=$user_id;
			//$user_name=$user_name;
			
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			//prd($user_name);
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(307200*1024))
						{
							//$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
	$actual_image_name = $mySessionFront->user['userRole']."_".$mySessionFront->user['UserName']."_".date("d-M-Y")."_".rand(100,900).'.'.$ext;
							
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(move_uploaded_file($tmp, $path.$actual_image_name))
								{
								
								 $data = '';
					 			 $data['user_resume']=$actual_image_name;
								 
								 $modelobj = new Model_Mainmodel();
								 $condition="user_id='".$user_id."'";
								 $modelobj->updateThis('tbl_users',$data,$condition);
								 $mySessionFront->sucMsg = "Upload Resume Success...";	
								
									echo $mySessionFront->sucMsg; //echo $size;
								}
							else
								echo "failed";
						}
						else
						echo "Image file size max 1 MB";					
						}
						else
						echo "Invalid file format..";	
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
			
	}
	
	public function reloadresumeAction(){
      
       	global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	   
		if(!isLogged()) { 
			$this->_redirect('index');
		}
		
		$db=new Db();
		
		$qry= "SELECT *, user_skills_n_expertise FROM tbl_users WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->Skill_Data = $GetData[0];
				
		
    }
	//===================== Ajax Load ::Experience:: IN EDIT Mode :: ================================================================///
	public function experienceAction(){	$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		global $mySessionFront;
	   	if(!isLogged()) { 
			$this->_redirect('index');
		}
		$arr=$this->getRequest()->getParams();
		//$this->view->country_id = $arr['country_id'];
		
		if($arr['id']) {
			//prd($arr['user_id']);
			
			$qry="select * from `tbl_user_experience` where id ='".$arr['id']."'";
			//prd($qry);
			$user_experience = $db->runQuery("$qry");
				//prd($user_experience);
			$this->view->experience=$user_experience[0];
		
		}
	}
	
	public function experienceeditAction(){
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	
		$job_id = $this->_request->getParam('job_id');
		
		$position = $this->_request->getParam('position');
		$company = $this->_request->getParam('company');
		$location = $this->_request->getParam('location');
		$employment_period_from = $this->_request->getParam('employment_period_from');
		$employment_period_to = $this->_request->getParam('employment_period_to');
		$responsibility = $this->_request->getParam('responsibility');
			//prd($company.''.$position.''.$company.''.$location.''.$employment_period_from.''.$employment_period_to.''.$responsibility);
			
			if ($this->_request->isPost())
			{
				$data='';
				$data['position']=$position;
				$data['company']=$company;
				$data['location']=$location;
				$data['employment_period_from']=$employment_period_from;
				$data['employment_period_to']=$employment_period_to;
				$data['responsibility']=$responsibility;
				
				$modelobj = new Model_Mainmodel();
				$condition="id='".$job_id."'";
				$modelobj->updateThis('tbl_user_experience',$data,$condition);
				$mySessionFront->sucMsg = "Experience Edit Success...";	
			}
			
	}
	
	public function reloadexperienceAction(){
      
       	global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		$db=new Db();
		$UserExperienceQry= "SELECT * FROM tbl_user_experience WHERE user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($UserExperienceQry);
		$Experience_Data = $db->runQuery($UserExperienceQry);
		//prd($Experience_Data);
		$this->view->UserExperienceData = $Experience_Data;
		
		
				
		
    }
	
	//===================== Ajax Load ::Skills & Expertise:: IN EDIT Mode :: ================================================================///
	public function skillsAction(){	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		global $mySessionFront;
	   	if(!isLogged()) { 
			$this->_redirect('index');
		}
		$arr=$this->getRequest()->getParams();
		//$this->view->country_id = $arr['country_id'];
		
		if($arr['user_id']) {
			//prd($arr['user_id']);
			
			$qry="select * from `tbl_users` where user_id ='".$arr['user_id']."'";
			//prd($qry);
			$user_id = $db->runQuery("$qry");
				//prd($user_id);
			$this->view->user_id=$user_id[0];
		
		}
	}
	
	public function skillseditAction() 
	{
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$user_id = $this->_request->getParam('user_id');
		$editor1 = $this->_request->getParam('editor1');
		
			//prd($user_id);
			//prd($editor1);
			if ($this->_request->isPost())
			{
				$data='';
				$data['user_skills_n_expertise']=$editor1;
				
				$modelobj = new Model_Mainmodel();
				$condition="user_id='".$user_id."'";
				$modelobj->updateThis('tbl_users',$data,$condition);
				$mySessionFront->sucMsg = "Skills & Expertise Edit Success...";	
			}
			
	}
	
	public function reloadskillsAction(){
      
       	global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	   
		if(!isLogged()) { 
			$this->_redirect('index');
		}
		
		$db=new Db();
		
		$qry= "SELECT *, user_skills_n_expertise FROM tbl_users WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->Skill_Data = $GetData[0];
				
		
    }
	
	//===================== Ajax Load Education:: IN EDIT Mode :: ================================================================///
	public function educationAction(){	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		global $mySessionFront;
	   	if(!isLogged()) { 
			$this->_redirect('index');
		}
		$arr=$this->getRequest()->getParams();
		//$this->view->country_id = $arr['country_id'];
		
		if($arr['id']) {
			//prd($arr['user_id']);
			
			$User_Education_Qry="select * from `tbl_user_education` where id ='".$arr['id']."'";
			//prd($User_Education_Qry);
			$User_Education = $db->runQuery("$User_Education_Qry");
			//prd($User_Education);
			$this->view->Edit_User_Education=$User_Education[0];
		
		}
	}
	
	public function educationeditAction(){
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	
		$id = $this->_request->getParam('id');
		$degree = $this->_request->getParam('degree');
		$university = $this->_request->getParam('university');
		$starting_year = $this->_request->getParam('starting_year');
		$finishing_year = $this->_request->getParam('finishing_year');
			
		//prd($id.'&nbsp;'.$degree.'&nbsp;'.$university.'&nbsp;'.$starting_year.'&nbsp;'.$finishing_year);
		if ($this->_request->isPost())
		{
			$data='';
			$data['degree']=$degree;
			$data['university']=$university;
			$data['starting_year']=$starting_year;
			$data['finishing_year']=$finishing_year;
			
			$modelobj = new Model_Mainmodel();
			$condition="id='".$id."'";
			$modelobj->updateThis('tbl_user_education',$data,$condition);
			$mySessionFront->sucMsg = "Education Edit Success...";	
		}
	}
	
	public function reloadeducationAction(){
      
       	global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		$db=new Db();
		$User_Education_Qry="SELECT
tbl_user_education.id,
tbl_user_education.degree,
tbl_user_education.university,
tbl_user_education.starting_year,
tbl_user_education.finishing_year,
tbl_user_education.is_heighest,
tbl_user_education.user_id,
tbl_job_educations.education_title
FROM
tbl_user_education
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($User_Education_Qry);
		$User_Education = $db->runQuery("$User_Education_Qry");
		//prd($User_Education);
		$this->view->Education_Dashboard=$User_Education;
	
	 }
	
	//===================== Ajax Load ::Personal Information:: IN EDIT Mode :: ================================================================///
	public function personalAction(){	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		global $mySessionFront;
	   	if(!isLogged()) { 
			$this->_redirect('index');
		}
		$arr=$this->getRequest()->getParams();
		//$this->view->country_id = $arr['country_id'];
		
		if($arr['user_id']) {
			//prd($arr['user_id']);
			
			$Personal_Qry="select * from `tbl_users` where user_id ='".$arr['user_id']."'";
			//prd($Personal_Qry);
			$User_Personal = $db->runQuery("$Personal_Qry");
				//prd($User_Personal);
			$this->view->Personal_Data=$User_Personal[0];
		
		}
	}
	
	public function personaleditAction() 
	{
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$user_id = $this->_request->getParam('user_id');
		
		$user_dob = $this->_request->getParam('user_dob');
		$user_marital_status = $this->_request->getParam('user_marital_status');
		$user_email = $this->_request->getParam('user_email');
		$user_phone = $this->_request->getParam('user_phone');
		$user_gender = $this->_request->getParam('user_gender');
		$nation_title = $this->_request->getParam('nation_title');
		$career_level_title = $this->_request->getParam('career_level_title');

//prd($user_id.'&nbsp;'.$user_dob.'&nbsp;'.$user_marital_status.'&nbsp;'.$user_email.'&nbsp;'.$user_phone.'&nbsp;'.$user_gender.'&nbsp;'.$nation_title.'&nbsp;'.$career_level_title);		
	
			if ($this->_request->isPost())
			{
				$data='';
				//$dtr=explode('-',$user_dob);
				//$data['user_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
				$data['user_dob'] = $user_dob;
				$data['user_marital_status'] = $user_marital_status;
				$data['user_email'] = $user_email;
				$data['user_phone'] = $user_phone;
				$data['user_gender'] = $user_gender;
				$data['user_nationality'] = $nation_title;
				$data['user_career_level'] = $career_level_title;
				
				$modelobj = new Model_Mainmodel();
				$condition="user_id='".$user_id."'";
				$modelobj->updateThis('tbl_users',$data,$condition);
				$mySessionFront->sucMsg = "Personal Information Edit Success...";	
			}
			
	}
	
	public function reloadpersonalAction(){
      
       	global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	   
		if(!isLogged()) { 
			$this->_redirect('index');
		}
		
		$db=new Db();
		
$qry= "SELECT tbl_users.user_id, tbl_users.user_dob, tbl_users.user_marital_status, tbl_users.user_email, tbl_users.user_phone, tbl_users.user_gender,
tbl_nationalities.nation_title, tbl_career_levels.career_level_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->Personal_Data = $GetData[0];
				
		
    }
	
//===================== End Ajax Load Profile Summery:: IN EDIT Mode :: ================================================================///	
	
	
//===================== Ajax Company Summary :: ================================================================///
	public function overviewAction()
	{	$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		global $mySessionFront;
	   	if(!isLogged()) { 
			$this->_redirect('index');
		}
		$arr=$this->getRequest()->getParams('user_id');
		//$this->view->country_id = $arr['country_id'];
		
		if(@$arr['user_id']) {
			//prd($arr['user_id']);
			
			$qry="select * from `tbl_users` where user_id ='".$arr['user_id']."'";
			//prd($qry);
			$user_id = $db->runQuery("$qry");
				//prd($user_id);
			$this->view->user_id=$user_id[0];
		
		}
	}
	
	public function overvieweditAction() 
	{
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
		
		$user_id = $this->_request->getParam('user_id');
		$user_profile_summary = $this->_request->getParam('user_profile_summary');
		
			//prd($user_id);
			prd($user_profile_summary);
			if ($this->_request->isPost())
			{
				$data='';
				$data['user_profile_summary']=$user_profile_summary;
				
				$modelobj = new Model_Mainmodel();
				$condition="user_id='".$user_id."'";
				$modelobj->updateThis('tbl_users',$data,$condition);
				$mySessionFront->sucMsg = "Company Overview Edit Success...";	
			}
			
	}
	
	public function reloadoverviewAction(){
      
       	global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		$db=new Db();
		
		$qry= "SELECT * FROM tbl_users WHERE user_id='".$mySessionFront->user['FrontUserId']."'";
		//prd($qry);
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserSummaryData = $GetData[0];
				
		
    }
	
}
?>
