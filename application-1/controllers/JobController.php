<?php
class JobController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
	}
	public function testAction()
	{	
		global $mySessionFront;	
		$db=new Db();
	}
	
	public function indexAction()
	{	
		global $mySessionFront;	
		$db=new Db();
		
		$job_keywords_Qry="SELECT * FROM tbl_jobs";
				//prd($job_keywords_Qry);
		$job_keywords = $db->runQuery("$job_keywords_Qry");
				//prd($job_keywords);
		$this->view->job_keywords=$job_keywords;
		
			
	}	
	
	
	
	//Search Records...
	public function searchAction()
	{	
		global $mySessionFront;	
		$db=new Db();
		
		$arr=$this->getRequest()->getParams();
		
		$wherecondition='';
		
		/*if (!empty($arr['job_status'])) {job_title
			$wherecondition .= " job_status='".$arr['job_status']."'";
		}
		
		if (!empty($arr['job_keywords'])) {
			$wherecondition .= " and job_keywords='".$arr['job_keywords']."'";
		}*/
		
		if (!empty($arr['job_keywords'])) {
			$wherecondition .= " and (job_title = '".$arr['job_keywords']."' or job_keywords = '".$arr['job_keywords']."')";
		}
		
		if (!empty($arr['job_country'])) {
			$wherecondition .= " and job_country='".$arr['job_country']."'";
		}
		if (!empty($arr['job_employment_type'])) {
			$wherecondition .= " and job_employment_type='".$arr['job_employment_type']."'";
		}
		if (!empty($arr['job_career_level'])) {
			$wherecondition .= " and job_career_level='".$arr['job_career_level']."'";
		}
		if (!empty($arr['job_education'])) {
			$wherecondition .= " and job_education='".$arr['job_education']."'";
		}
		if (!empty($arr['job_type'])) {
			$wherecondition .= " and job_type='".$arr['job_type']."'";
		}
		if (!empty($arr['job_category'])) {
			$wherecondition .= " and job_category='".$arr['job_category']."'";
		}
		
		
		$qry="SELECT
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_educations.education_title,
tbl_job_types.job_type_title,
tbl_job_categories.category_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_keywords,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title
FROM
tbl_jobs
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_jobs.job_employment_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id
LEFT JOIN tbl_job_types ON tbl_jobs.job_type = tbl_job_types.id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
INNER JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
WHERE job_status = '1'".$wherecondition;
		  
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
			//prd($arr);
			$qry="SELECT
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_educations.education_title,
tbl_job_types.job_type_title,
tbl_job_categories.category_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_keywords,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title
FROM
tbl_jobs
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_jobs.job_employment_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id
LEFT JOIN tbl_job_types ON tbl_jobs.job_type = tbl_job_types.id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
INNER JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
WHERE job_status = '1' and job_country ='".$arr['country_id']."'";
				//prd($qry);
			$country_id = $db->runQuery("$qry");
				//prd($country_id);
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
			$qry="SELECT
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_educations.education_title,
tbl_job_types.job_type_title,
tbl_job_categories.category_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_keywords,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title
FROM
tbl_jobs
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_jobs.job_employment_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id
LEFT JOIN tbl_job_types ON tbl_jobs.job_type = tbl_job_types.id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
INNER JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
WHERE job_status = '1' and job_career_level ='".$arr['career_level_id']."'";
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
			$qry="SELECT
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_educations.education_title,
tbl_job_types.job_type_title,
tbl_job_categories.category_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_keywords,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title
FROM
tbl_jobs
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_jobs.job_employment_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id
LEFT JOIN tbl_job_types ON tbl_jobs.job_type = tbl_job_types.id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
INNER JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
WHERE job_status = '1' and job_role ='".$arr['job_role_id']."'";
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
			$qry="SELECT
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_educations.education_title,
tbl_job_types.job_type_title,
tbl_job_categories.category_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_keywords,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title
FROM
tbl_jobs
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_jobs.job_employment_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id
LEFT JOIN tbl_job_types ON tbl_jobs.job_type = tbl_job_types.id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
INNER JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
WHERE job_status = '1' and job_category ='".$arr['cat_id']."'";
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
			$qry="SELECT
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_educations.education_title,
tbl_job_types.job_type_title,
tbl_job_categories.category_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_keywords,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title
FROM
tbl_jobs
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_jobs.job_employment_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id
LEFT JOIN tbl_job_types ON tbl_jobs.job_type = tbl_job_types.id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
INNER JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
WHERE job_status = '1' and job_sub_category ='".$arr['sub_cat_id']."'";
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
			
			$qry="SELECT
tbl_countries.country_name,
tbl_employment_type.employment_title,
tbl_career_levels.career_level_title,
tbl_job_educations.education_title,
tbl_job_types.job_type_title,
tbl_job_categories.category_title,
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_keywords,
tbl_jobs.job_description,
tbl_jobs.job_responsibilities,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_sub_categories.sub_category_title,
tbl_job_roles.job_role_title
FROM
tbl_jobs
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_employment_type ON tbl_jobs.job_employment_type = tbl_employment_type.employment_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id
LEFT JOIN tbl_job_types ON tbl_jobs.job_type = tbl_job_types.id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
INNER JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
WHERE job_status = '1' and job_sallary BETWEEN '".$sallary_min."' AND '".$sallary_max."'";
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
	
	public function keywordajaxAction()
	{	
		global $mySessionFront;	
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['job_posted_on']) {
			
			$namesubst = str_replace(" ","",$data['pro_user_id']);
			$strlen = strlen($namesubst);
			$namesubst = substr($namesubst,0,$strlen-1);
			$namesubst = str_replace("|","','",$namesubst);
			
			echo $namesubst; exit;
			
			$qry="SELECT * FROM tbl_jobs WHERE job_posted_on >= CURDATE() - INTERVAL '".$arr['job_posted_on']."' DAY ORDER BY job_posted_on DESC";
			//prd($qry);
			$job_posted_on = $db->runQuery("$qry");
			//prd($job_sallary);
			$this->view->job_posted_on=$job_posted_on;
		}
	}
//================ Ajax Sub Categories ================	
	public function getsubcatAction()
	{
		global $mySession;
		$db=new Db();
		$Result=$db->runQuery("select * from tbl_job_sub_categories where category_id='".$_REQUEST['CategorySno']."'");
		//prd($Result);
		?>
<select name="SubCatId" id="SubCatId" style="width:200px; height:32px; padding:6px; margin:0px 0px 0px -20px; border-radius:5px; box-shadow:0 0 5px #e1e1e1; border:1px solid #e0e0e0; " class="">
		<option value="">--SubCategory--</option>
		<?				
		
			foreach($Result as $key=>$SubCatData)
			{
			//prd($Result);
			?>
            
			<option value="<?=$SubCatData["sub_cat_id"]?>"><?=$SubCatData["sub_category_title"]?></option>
			<?
			//prd($SubCatData);
			}
		
		
		 ?>
		
		
		</select>
		<?
		exit();
	}
//================ Posting A Job ================
	public function postjobAction()
	{	
		global $mySessionFront;
		$db=new Db();
		
		$this->view->pagetitle = 'Post a new job';
		$form = new Form_Postjob();
		$this->view->myform=$form;		
		$arr=$this->getRequest()->getParams('My_Job_Status');  //My_Job_Status1 Post Active Job
		
		$Credit_Qry="SELECT * FROM tbl_users where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Credit_Qry);
		$Job_Credit_Result=$db->runQuery($Credit_Qry);
		//prd($Job_Credit_Result);
		
		$Company_Qry="SELECT
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
		//prd($Company_Qry);
		$Company_Data = $db->runQuery($Company_Qry);
		//prd($Company_Data);
		$this->view->Company_Data = $Company_Data[0];
		
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
		
		if($Job_Credit_Result[0]['user_jobs_available']==0){
			$mySessionFront->sucMsg = "Please Buy Some Job Credit to Post a Job...";
			$this->_redirect('subscription');
		}else{
				
		
			
		if ($this->_request->isPost()) {		 
				
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
			$Credit_Qry="SELECT * FROM tbl_users where user_id ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Credit_Qry);
			$Job_Credit_Result=$db->runQuery($Credit_Qry);
			
			
				//prd($arr);
			//	prd($arr1);
				
				$data='';
				
				$mycnttData=$db->runQuery("SELECT MAX(id) as MyRef FROM tbl_jobs");
				$myid = str_pad(($mycnttData[0]['MyRef']+1),6,0,STR_PAD_LEFT);
				// echo substr($myvideo['Discription'],0,100)."&nbsp;..."  
				//prd($maxid);
				$data['job_reference_no'] = substr($formData['Job_Title'],0,5).$myid;
				$data['job_title']=$formData['Job_Title'];
				$data['job_keywords']=$formData['job_keywords'];
				$data['job_category'] = $formData['CategorySno'];
				$data['job_sub_category'] = $formData['SubCatId'];
				$data['job_description'] = $formData['Description'];
				$data['job_responsibilities'] = $formData['Responsibilities'];
				$data['job_skills_required'] = $formData['Skills_Required'];
				$data['job_country'] = $formData['CountryId'];
				$data['job_city'] = $formData['City'];
				$data['job_employment_type'] = $formData['Employment_Type'];
				$data['job_type'] = $formData['Job_Type'];
				$data['job_education'] = $formData['Career_Level'];
				$data['job_career_level'] = $formData['EducationId'];
				$data['job_experience'] = $formData['ExperienceId'];
				$data['job_travel_required'] = $formData['Travel_Required'];	
				$data['job_relocation'] = $formData['Relocation'];	
				$data['job_sallary'] = $formData['Sallary'];	
				$data['job_email'] = $formData['Email'];	
				$data['job_phone_number'] = $formData['Phone_Number'];	
				$data['job_contact_name'] = $formData['Contact_Name'];
				$data['job_fax'] = $formData['Fax'];
				$data['job_role'] = $formData['job_role'];
				$data['job_posted_on'] = date('Y-m-d');	
				$data['user_id'] = $mySessionFront->user['FrontUserId'];	
				
				// $data['job_title']=$formData['Job_Title'];
				
				
				/*if($formData['submit']='Save this Job'){
					$data['job_status'] = 1;
				}
				
				if($formData['submit']='Post this Job'){
					$data['job_status'] = '0';
					
					
				}*/
				
				if($formData['submit']=="Save this Job"){
					$data['job_status'] = 0;
				}
				
				if($formData['submit']=="Post this Job"){
					$data['job_status'] = 1;
				}
				//$dtr=explode('-',$formData['cust_dob']);
				//$data['cust_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
				
				$data['job_status'] = $data['job_status'];
				
		//prd($data);
				$modelobj = new Model_Mainmodel();
				$insid = $modelobj->insertThis('tbl_jobs',$data);
				
				
				$data1['user_jobs_available']= $Job_Credit_Result[0]['user_jobs_available']-1;
				$condition = "user_id='".$mySessionFront->user['FrontUserId']."'"; //exit;
				$db->modify('tbl_users',$data1,$condition);
				
				$mySessionFront->sucMsg = "Job Posted Success...";
				$this->_redirect('job/postjob');
			}
			} 
			//substr($formData['Job_Title'],0,5)
		 }
	}
	
	
	public function featuredjobpostAction()
	{	
		global $mySessionFront;
		$db=new Db();
		
		$this->view->pagetitle = 'Featured Job Posting';
		$form = new Form_Featuredjobpost();
		
		//prd($form);
		$this->view->myform=$form;		
		
		$Credit_Qry="SELECT * FROM tbl_users where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Credit_Qry);
		$Job_Credit_Result=$db->runQuery($Credit_Qry);
		//prd($Job_Credit_Result);
		
		if($Job_Credit_Result[0]['user_featured_jobs_available']==0){
			$mySessionFront->sucMsg = "Please Buy Some Job Credit to Post a Job...";
			$this->_redirect('subscription');
		}else{
		
		if ($this->_request->isPost()) {		 
				
			$Credit_Qry="SELECT * FROM tbl_users where user_id ='".$mySessionFront->user['FrontUserId']."'";
			//prd($Credit_Qry);
			$Job_Credit_Result=$db->runQuery($Credit_Qry);
			

				
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
				$data='';
				
				$mycnttData=$db->runQuery("SELECT MAX(id) as MyRef FROM tbl_jobs");
				$myid = str_pad(($mycnttData[0]['MyRef']+1),6,0,STR_PAD_LEFT);
				// echo substr($myvideo['Discription'],0,100)."&nbsp;..."  
				//prd($maxid);
				$data['job_reference_no'] = substr($formData['Job_Title'],0,5).$myid;
				$data['job_title']=$formData['Job_Title'];
				$data['job_keywords']=$formData['job_keywords'];
				$data['job_category'] = $formData['CategorySno'];
				$data['job_sub_category'] = $formData['SubCatId'];
				$data['job_description'] = $formData['Description'];
				$data['job_responsibilities'] = $formData['Responsibilities'];
				$data['job_skills_required'] = $formData['Skills_Required'];
				$data['job_country'] = $formData['CountryId'];
				$data['job_city'] = $formData['City'];
				$data['job_employment_type'] = $formData['Employment_Type'];
				$data['job_type'] = $formData['Job_Type'];
				$data['job_education'] = $formData['Career_Level'];
				$data['job_career_level'] = $formData['EducationId'];
				$data['job_experience'] = $formData['ExperienceId'];
				$data['job_travel_required'] = $formData['Travel_Required'];	
				$data['job_relocation'] = $formData['Relocation'];	
				$data['job_sallary'] = $formData['Sallary'];	
				$data['job_email'] = $formData['Email'];	
				$data['job_phone_number'] = $formData['Phone_Number'];	
				$data['job_contact_name'] = $formData['Contact_Name'];
				$data['job_fax'] = $formData['Fax'];
				$data['job_posted_on'] = date('Y-m-d');	
				$data['user_id'] = $mySessionFront->user['FrontUserId'];	
				$data['job_status'] = 1;
				$data['job_is_featured'] = 1;
//============================================= Featured Job Color Coding ======================================================				
				$data['job_bg_color'] = $formData['job_bg_color'];
				$data['job_foreground_color'] = $formData['job_foreground_color'];
				$data['job_logo_bg_color'] = $formData['job_logo_bg_color'];
				$data['job_menu_foreground_color'] = $formData['job_menu_foreground_color'];
				$data['job_menu_color'] = $formData['job_menu_color'];
				
//============================================= Featured Images ======================================================				
				if(is_array($_FILES['Company_Logo']) && $_FILES['Company_Logo']['name']!='') {
						
						$ftype = $_FILES['Company_Logo']['type'];
						$fname = $_FILES['Company_Logo']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = "admin/upload/company_logo/";
						$ext = end(explode(".", $fname));
						$filename = 'Company_Logo'.rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						//prd($uploadfile);
						// unlink Dir
						
						//$dir = "admin/upload/user_pic/";
						//unlink($dir.$formData['OldImagePath']);
						
						if (move_uploaded_file($_FILES['Company_Logo']['tmp_name'], $uploadfile)) {
								//echo "Testin...."; exit;			  
						  
						  $data['Company_Logo'] = $filename;
						 
						 }
					}
				
				if(is_array($_FILES['Header_Banner']) && $_FILES['Header_Banner']['name']!='') {
						
						$ftype = $_FILES['Header_Banner']['type'];
						$fname = $_FILES['Header_Banner']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = "admin/upload/Company_Header_Banner/";
						$ext = end(explode(".", $fname));
						$filename = 'Company_Header_Banner'.rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						//prd($uploadfile);
						// unlink Dir
						
						//$dir = "admin/upload/user_pic/";
						//unlink($dir.$formData['OldImagePath']);
						
						if (move_uploaded_file($_FILES['Header_Banner']['tmp_name'], $uploadfile)) {
								//echo "Testin...."; exit;			  
						  
						  $data['Header_Banner'] = $filename;
						 
						 }
					}
				
				if(is_array($_FILES['Content_Banner']) && $_FILES['Content_Banner']['name']!='') {
						
						$ftype = $_FILES['Content_Banner']['type'];
						$fname = $_FILES['Content_Banner']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = "admin/upload/Company_Content_Banner/";
						$ext = end(explode(".", $fname));
						$filename = 'Company_Content_Banner'.rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						//prd($uploadfile);
						// unlink Dir
						
						//$dir = "admin/upload/user_pic/";
						//unlink($dir.$formData['OldImagePath']);
						
						if (move_uploaded_file($_FILES['Content_Banner']['tmp_name'], $uploadfile)) {
								//echo "Testin...."; exit;			  
						  
						  $data['Content_Banner'] = $filename;
						 
						 }
					}	
				
		//prd($data);
				$modelobj = new Model_Mainmodel();
				$insid = $modelobj->insertThis('tbl_jobs',$data);
				
				
				$data1['user_featured_jobs_available']= $Job_Credit_Result[0]['user_featured_jobs_available']-1;
				$condition = "user_id='".$mySessionFront->user['FrontUserId']."'"; //exit;
				$db->modify('tbl_users',$data1,$condition);
				
				$mySessionFront->sucMsg = "Job Posted Success...";
				$this->_redirect('job/featuredjobpost');
			}
			} 
			//substr($formData['Job_Title'],0,5)
		 }
		 
		 
		 $Company_Qry="SELECT
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
		//prd($Company_Qry);
		$Company_Data = $db->runQuery($Company_Qry);
		//prd($Company_Data);
		$this->view->Company_Data = $Company_Data[0];
		
		
		//================================== Side Bar ======================================//
		//================================== Side Bar ======================================//
			
			//-------   Jobs Posted ------//
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
	
	public function jobdetailAction(){
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
		
		
		//============================================ Recommended Jobs ======================================//		
		//user_industry
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, 
tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON 
tbl_jobs.job_category = tbl_users.user_industry  where tbl_jobs.job_category = '".$mySessionFront->user['user_industry']."' ORDER BY RAND() limit 0,5";
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;
	
	}
	
	public function alljobsAction(){
		global $mySessionFront;
	  	$db=new Db();
		
		
			$AllJobQry="SELECT
tbl_jobs.id as Job_id,
tbl_jobs.job_title,
tbl_jobs.job_description,
tbl_jobs.job_city,
tbl_jobs.job_posted_on,
tbl_job_roles.job_role_title,
tbl_career_levels.career_level_title,
tbl_job_categories.category_title,
tbl_countries.country_name
FROM tbl_jobs
LEFT JOIN tbl_job_roles ON tbl_jobs.job_role = tbl_job_roles.job_role_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
WHERE tbl_jobs.job_category='".$mySessionFront->user['user_industry']."'";
			//prd($qry);
			$AllJob_Details = $db->runQuery("$AllJobQry");
				//prd($AllJob_Details);
			$this->view->AllJob_Details=$AllJob_Details;
			
			//================================== Advertisement  ======================================//
			$Add_Banner_Qry= "select * from tbl_banners ORDER BY RAND() limit 0,1";
			$Add_Banner_Val = $db->runQuery($Add_Banner_Qry);
				//prd($Add_Banner_Val); 
			$this->view->Add_Banner_Data = $Add_Banner_Val;
					
			$Job_Seeker_Qry= "SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
	tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id  ='".$mySessionFront->user['FrontUserId']."'";
			$Job_Seeker_GetData = $db->runQuery($Job_Seeker_Qry);
				//prd($Job_Seeker_GetData); 
			$this->view->Job_Seeker_Data = $Job_Seeker_GetData[0];
			//================================== Side Bar  ======================================//
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
			//================================== Recommended Jobs ======================================//
			$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, 
tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON 
tbl_jobs.job_category = tbl_users.user_industry  where tbl_jobs.job_category = '".$mySessionFront->user['user_industry']."' ORDER BY RAND() limit 0,5";
			//prd($Rec_Qry);
			$Rec_Job = $db->runQuery($Rec_Qry);
			//prd($Rec_Job);
			$this->view->Rec_Job=$Rec_Job;
			
	}
	
//============================================================ SAVE AND APPLY JOBS =========================================================
	public function jobapplyAction(){
		global $mySessionFront;
	  	//$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();	
		$arr=$this->getRequest()->getParams('job_id');
		
		//prd($arr);
		$modelobj = new Model_Mainmodel();
		$result=$modelobj->runThisQuery("select * from tbl_applied_jobs where job_id='".$arr['job_id']."'");
		//prd($result);
		if(is_array($result) && count($result) > 0)
		{
		
			//echo "You already applied this job.";
			$mySessionFront->errorMsg="You already applied this job.";
			$this->_redirect("job/jobdetail/id/".$arr['job_id']."");
			//$this->_redirect('index/login');
		}else{ 
	
	
	if($arr['job_id']) {
			
			//prd($arr);
			$data='';
			$data['job_id']=$arr['job_id'];
			$data['applied_on']=date('Y-m-d');   
			$data['user_id'] = $mySessionFront->user['FrontUserId'];
				//prd($data);
			
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_applied_jobs',$data);
			$mySessionFront->sucMsg ="Job Apply Successfully.";	
			
			$this->_redirect("job/jobdetail/id/".$arr['job_id']."");
			
			//$condition="id='".$arr['job_id']."'";
			//$modelobj->updateThis('tbl_applied_jobs',$Data,$condition);	
			
			}
		}
	}
	
	public function savejobAction(){
		global $mySessionFront;
	  	//$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams('job_id');
		
		//prd($arr);
		$modelobj = new Model_Mainmodel();
		$result=$modelobj->runThisQuery("select * from tbl_saved_jobs where job_id='".$arr['job_id']."'");
		//prd($result);
		if(is_array($result) && count($result) > 0)
		{
		
			//echo "You already applied this job.";
			$mySessionFront->errorMsg="You already save this job.";
			$this->_redirect("job/jobdetail/id/".$arr['job_id']."");
			//$this->_redirect('index/login');
		}
		 else{
			if($arr['job_id']) {
			
			//prd($arr);
			$data='';
			$data['job_id']=$arr['job_id'];
			$data['job_saved_on']=date('Y-m-d');   
			$data['user_id'] = $mySessionFront->user['FrontUserId'];
				//prd($data);
			
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_saved_jobs',$data);
			
			//echo "Job Save Successfully.";
			$mySessionFront->sucMsg ="Job Save Successfully.";
			
			$this->_redirect("job/jobdetail/id/".$arr['job_id']."");
			
			//$condition="id='".$arr['job_id']."'";
			//$modelobj->updateThis('tbl_applied_jobs',$Data,$condition);	
			
			}
		}
	}
//============================================================ SAVE AND APPLY JOBS =========================================================
		
	
}
?>
