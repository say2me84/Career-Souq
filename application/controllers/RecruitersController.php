<?php
class RecruitersController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */   
		
		
    }
	
	
	public function indexAction()
	{	
		global $mySessionFront;	
		if(!isLogged()) { 
			$mySessionFront->errorMsg ="Login to see ..."; 
			$this->_redirect('index/login');
		}	
	}	
	//Search Records...
	public function testAction()
	{	
		global $mySessionFront;	
		$db=new Db();
	}	
	
	//Search Records...
	public function searchAction()
	{	
		global $mySessionFront;	
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();
		$arr1=$this->getRequest()->getParams('salary');
		//prd($arr1);
		
		$wherecondition='';
		
		if (!empty($arr['user_is_blocked'])) {
			$wherecondition .= " user_is_blocked='".$arr['user_is_blocked']."'";
		}
		if (!empty($arr['user_fname'])) {
			$wherecondition .= " and user_fname='".$arr['user_fname']."'";
		}
		if (!empty($arr['user_country'])) {
			$wherecondition .= " and user_country='".$arr['user_country']."'";
		}
		if (!empty($arr['user_employer_type'])) {
			$wherecondition .= " and user_employer_type='".$arr['user_employer_type']."'";
		}
		if (!empty($arr['user_career_level'])) {
			$wherecondition .= " and user_career_level='".$arr['user_career_level']."'";
		}
		if (!empty($arr['job_sallary'])) {
			$wherecondition .= " and job_sallary='".$arr['job_sallary']."'";
		}
		if (!empty($arr['user_nationality'])) {
			$wherecondition .= " and user_nationality='".$arr['user_nationality']."'";
		}
		if (!empty($arr['user_industry'])) {
			$wherecondition .= " and user_industry='".$arr['user_industry']."'";
		}
		if (!empty($arr['user_gender'])) {
			$wherecondition .= " and user_gender='".$arr['user_gender']."'";
		}
		if (!empty($arr['user_city'])) {
			$wherecondition .= " and user_city='".$arr['user_city']."'";
		}
		if (!empty($arr['degree'])) {
			$wherecondition .= " and degree='".$arr['degree']."'";
		}
		//prd($dtr1);
		//$sallary_max['job_sallary'] =$dtr1[1];			[0] => 1000	[1] => 5000
		
		
		if (!empty($arr['salary'])) {
			$dtr1=explode('-',$arr['salary']);
			$sallary_min =$dtr1[0];
			$sallary_max =$dtr1[1];	
			$wherecondition .= " and salary BETWEEN '".$sallary_min."' and '".$sallary_max."'";
		}
		
		/*if (!empty($arr['search_keyword'])) {
			$wherecondition .= " and (first_name like '%".$arr['search_keyword']."%' or 
						last_name like '%".$arr['search_keyword']."%' or
						employee_number = '".$arr['search_keyword']."' or 
						qualification = '".$arr['search_keyword']."') 
						";
		}*/
		
		//$qry="select * from `tbl_users` where user_type='Job Seeker' AND ".$wherecondition;
		$qry="SELECT
tbl_users.user_id,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_city,
tbl_users.user_dob,
tbl_users.user_image,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_categories.category_title,
tbl_nationalities.nation_title,
tbl_job_educations.education_title,
tbl_user_experience.salary,
tbl_user_experience.exp_year,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.is_current
FROM
tbl_users
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_users.user_employer_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_user_education ON tbl_user_education.user_id = tbl_users.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id
where user_type='Job Seeker' AND  user_is_blocked='1' and is_heighest='1'  and is_current = '1' AND ".$wherecondition;
			//prd($qry);
		$searchlist=$db->runQuery("$qry");
		//prd($searchlist);
		$this->view->advsearchlist=$searchlist;
	}
	
	//Recruiter ----- Search By Country Ajax...
	public function recruitercountryAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		//$this->view->country_id = $arr['country_id'];
		
		if($arr['country_id']) {
			//prd($arr);
			$qry="SELECT
tbl_users.user_id,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_city,
tbl_users.user_dob,
tbl_users.user_image,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_categories.category_title,
tbl_nationalities.nation_title,
tbl_job_educations.education_title,
tbl_user_experience.salary,
tbl_user_experience.exp_year,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.is_current
FROM
tbl_users
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_users.user_employer_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_user_education ON tbl_user_education.user_id = tbl_users.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id where user_type='Job Seeker' AND  user_is_blocked='1' and is_heighest='1'  and is_current = '1' and user_country ='".$arr['country_id']."'";
				//prd($qry);
			$country_id = $db->runQuery("$qry");
				//prd($country_id);
			$this->view->country_id=$country_id;
		}
	}
	
	//Recruiter ------- Search By Job Sallary  Ajax...
	public function recruitersalaryAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['salary']) {
		
			//$dtr=explode('-',$formData['cust_dob']);
			//$Data['cust_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
			
			$dtr=explode(',',$arr['salary']);
			$sallary_min = $sallary_min['salary'] =$dtr[0];
			//prd($sallary_min);
			
			$dtr1=explode(',',$arr['salary']);
			$sallary_max = $sallary_max['salary'] =$dtr1[1];
			//prd($sallary_max);
			
			//$qry="select * from `tbl_jobs` where job_sub_category ='".$arr['sub_cat_id']."'";
			
			$qry="SELECT
tbl_users.user_id,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_city,
tbl_users.user_dob,
tbl_users.user_image,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_categories.category_title,
tbl_nationalities.nation_title,
tbl_job_educations.education_title,
tbl_user_experience.salary,
tbl_user_experience.exp_year,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.is_current
FROM
tbl_users
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_users.user_employer_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_user_education ON tbl_user_education.user_id = tbl_users.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id WHERE user_type='Job Seeker' AND  user_is_blocked='1' and is_heighest='1'  and is_current = '1' and salary BETWEEN '".$sallary_min."' AND '".$sallary_max."'";
				//prd($qry);
			$job_sallary = $db->runQuery("$qry");
				//prd($job_sallary);
			$this->view->My_sallary=$job_sallary;
		}
	}
	
	//Recruiter ------- By Job Role Ajax...
	public function recruiterbyroleAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['job_role_id']) {
			$qry="SELECT
tbl_users.user_id,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_city,
tbl_users.user_dob,
tbl_users.user_image,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_categories.category_title,
tbl_nationalities.nation_title,
tbl_job_educations.education_title,
tbl_user_experience.salary,
tbl_user_experience.exp_year,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.is_current
FROM
tbl_users
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_users.user_employer_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_user_education ON tbl_user_education.user_id = tbl_users.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id WHERE user_type='Job Seeker' AND  user_is_blocked='1' and is_heighest='1'  and is_current = '1' where job_role ='".$arr['job_role_id']."'";
			//prd($qry);
			$job_role_id = $db->runQuery("$qry");
			//prd($job_role_id);
			$this->view->job_role_id=$job_role_id;
		}
	}
	
	//Recruiter ------- By Industry...
	public function recruiterbyindustryAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		//$arr=$this->getRequest()->getParams('cat_id');
		$arr=$this->getRequest()->getParams();
		//prd($arr);
		if($arr['cat_id']) {
			$qry="SELECT
tbl_users.user_id,
tbl_users.user_industry,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_city,
tbl_users.user_dob,
tbl_users.user_image,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_categories.category_title,
tbl_nationalities.nation_title,
tbl_job_educations.education_title,
tbl_user_experience.salary,
tbl_user_experience.exp_year,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.is_current
FROM
tbl_users
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_users.user_employer_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_user_education ON tbl_user_education.user_id = tbl_users.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id 
WHERE user_type='Job Seeker' AND  user_is_blocked='1' and is_heighest='1'  and is_current = '1' and cat_id ='".$arr['cat_id']."'";
				//prd($qry);
			$cat_id = $db->runQuery("$qry");
				//prd($cat_id);
			$this->view->cat_id=$cat_id;
		}
	}
	//Recruiter ------- By Career Level	...
	public function recruiterbycareerlevelAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		//$arr=$this->getRequest()->getParams('cat_id');
		$arr=$this->getRequest()->getParams();
		//prd($arr);
		if($arr['career_level_id']) {
			$qry="SELECT
tbl_users.user_id,
tbl_users.user_industry,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_city,
tbl_users.user_dob,
tbl_users.user_image,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_categories.category_title,
tbl_nationalities.nation_title,
tbl_job_educations.education_title,
tbl_user_experience.salary,
tbl_user_experience.exp_year,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.is_current,
tbl_job_sub_categories.sub_category_title,
tbl_job_sub_categories.sub_cat_id,
tbl_job_sub_categories.category_id
FROM
tbl_users
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_users.user_employer_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_user_education ON tbl_user_education.user_id = tbl_users.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id
LEFT JOIN tbl_job_sub_categories ON tbl_job_categories.cat_id = tbl_job_sub_categories.category_id
WHERE user_type='Job Seeker' AND  user_is_blocked='1' and is_heighest='1'  and is_current = '1'  and career_level_id ='".$arr['career_level_id']."'";
				//prd($qry);
			$career_level_id = $db->runQuery("$qry");
				//prd($career_level_id);
			$this->view->career_level_id=$career_level_id;
		}
	}
	
	//Recruiter ------- By Compy Type	...
	public function recruiterbycompytypeAction()
	{	
		global $mySession;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		//$arr=$this->getRequest()->getParams('cat_id');
		$arr=$this->getRequest()->getParams();
		//prd($arr);
		if($arr['category_id']) {
			$qry="SELECT
tbl_users.user_id,
tbl_users.user_fname,
tbl_users.user_lname,
tbl_users.user_gender,
tbl_users.user_city,
tbl_users.user_dob,
tbl_users.user_image,
tbl_users.user_skills_n_expertise,
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_categories.category_title,
tbl_nationalities.nation_title,
tbl_job_educations.education_title,
tbl_user_experience.salary,
tbl_user_experience.exp_year,
tbl_user_experience.position,
tbl_user_experience.company,
tbl_user_experience.is_current
FROM
tbl_users
LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_users.user_employer_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id
LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id
LEFT JOIN tbl_user_education ON tbl_user_education.user_id = tbl_users.user_id
LEFT JOIN tbl_job_educations ON tbl_user_education.degree = tbl_job_educations.id
LEFT JOIN tbl_user_experience ON tbl_users.user_id = tbl_user_experience.user_id 
where user_type='Job Seeker' AND  user_is_blocked='1' and is_heighest='1'  and is_current = '1' and user_industry ='".$arr['category_id']."'";
				//prd($qry);
			$category_id = $db->runQuery("$qry");
				//prd($category_id);
			$this->view->category_id=$category_id;
		}
	}	
	
	
	
	public function oldcompanyhomeAction()
	{	
		global $mySessionFront;	
		$db=new Db();
	}
	
	public function homeAction()
	{
		
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
