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
			//prd($arr);
			$qry="select * from `tbl_jobs` where job_country ='".$arr['country_id']."'";
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
				///prd($Result);
			?>
            
			<option value="<?=$SubCatData["sub_cat_id"]?>"><?=$SubCatData["sub_category_title"]?></option>
			<?
			prd($SubCatData);
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
		
		$this->view->pagetitle = 'Post New Job';
		$form = new Form_Postjob();
		$this->view->myform=$form;		
			//echo "Akash"; exit;
			
		if ($this->_request->isPost()) {		 
				
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
					prd($data);
				$modelobj = new Model_Mainmodel();
				$insid = $modelobj->insertThis('tbl_jobs',$data);
				
				$mySessionFront->sucMsg = "Data Updated Success";
				$this->_redirect('job/postjob');
			}
			//substr($formData['Job_Title'],0,5)
		 }
	}
	
	public function jobdetailAction(){
		global $mySessionFront;
	  	$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['id']) {
			$qry="SELECT *, tbl_jobs.id, tbl_jobs.job_description, tbl_jobs.job_responsibilities, tbl_jobs.job_city, tbl_countries.country_name, tbl_job_categories.category_title,
tbl_job_sub_categories.sub_category_title, tbl_jobs.job_sallary, tbl_career_levels.career_level_title, tbl_job_experiences.experience_title,
tbl_job_educations.education_title, tbl_jobs.job_skills_required FROM tbl_jobs LEFT JOIN tbl_countries ON tbl_jobs.job_country = tbl_countries.country_id
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id LEFT JOIN tbl_job_sub_categories ON tbl_jobs.job_sub_category = tbl_job_sub_categories.sub_cat_id
LEFT JOIN tbl_career_levels ON tbl_jobs.job_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_job_experiences ON tbl_jobs.job_experience = tbl_job_experiences.id
LEFT JOIN tbl_job_educations ON tbl_jobs.job_education = tbl_job_educations.id WHERE tbl_jobs.id='".$arr['id']."'";
			//prd($qry);
			$Job_Details = $db->runQuery("$qry");
			//prd($Job_Details);
			$this->view->Job_Details=$Job_Details[0];
		}
		
		
		//============================================ Recommended Jobs ======================================//		
		//user_industry
		$Rec_Qry="SELECT *, tbl_jobs.job_title, tbl_jobs.id, tbl_jobs.job_posted_on, tbl_jobs.user_id, tbl_jobs.job_city, tbl_users.user_fname, tbl_users.user_lname, tbl_users.user_image, tbl_users.user_industry, tbl_users.user_company FROM tbl_jobs LEFT JOIN tbl_users ON tbl_jobs.job_category = tbl_users.user_industry ORDER BY RAND() limit 0,5";
		//prd($Rec_Qry);
		$Rec_Job = $db->runQuery($Rec_Qry);
		//prd($Rec_Job);
		$this->view->Rec_Job=$Rec_Job;
	
	}
	
	public function jobapplyAction(){
		global $mySessionFront;
	  	$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams();
		
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
			//$this->_redirect('job/jobdetail/id/'.$arr['job_id'].'');
			
			//$condition="id='".$arr['job_id']."'";
			//$modelobj->updateThis('tbl_applied_jobs',$Data,$condition);	
			
			}
	}
	
	public function savejobAction(){
		global $mySessionFront;
	  	$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams();
		
		if($arr['job_id']) {
			
			//prd($arr);
			$data='';
			$data['job_id']=$arr['job_id'];
			$data['job_saved_on']=date('Y-m-d');   
			$data['user_id'] = $mySessionFront->user['FrontUserId'];
				//prd($data);
			
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_saved_jobs',$data);
			
			$mySessionFront->sucMsg ="Job Save Successfully.";	
			//$this->_redirect('job/jobdetail/id/'.$arr['job_id'].'');
			
			//$condition="id='".$arr['job_id']."'";
			//$modelobj->updateThis('tbl_applied_jobs',$Data,$condition);	
			
			}
	}
		
	
}
?>
