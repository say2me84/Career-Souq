<?php
class DashboardController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }
	public function indexAction(){
      
       global $mySessionFront;
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		if($mySessionFront->user['userRole']=='Job Seeker') { 
			
		$db=new Db();
		
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
			$db=new Db();
			$qry= "SELECT * FROM `tbl_users` where user_id='".$mySessionFront->user['FrontUserId']."'";
			$GetData = $db->runQuery($qry);
					//prd($GetData); exit;
			$this->view->UserData = $GetData;
		
//============================================ Employee ======================================//
		}
    }	
	//Editing Records...
	
//===================== Ajax Load Profile Summery:: IN EDIT Mode :: ================================================================///
	public function usersummaryAction()
	{	$this->_helper->layout()->setLayout('ajaxlayout');	
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
		$this->view->user_id = $arr['user_id'];
		$this->view->mode=2;
		
		/*if(@$arr['user_id']) {
			if(isset($arr['mode']) && $arr['mode']=='update') {
			
				$this->view->mode=1;
				$modelobj = new Model_Mainmodel();
				
				$Data='';
				$Data['user_fname']=$arr['user_fname'];
				$Data['user_lname']=$arr['user_lname'];
				
				
				$condition="user_id='".$arr['user_id']."'";
				$modelobj->updateThis('subjects',$Data,$condition);		
			}
			
			} else {
				$qry="select * from `subjects` where user_id='".$arr['user_id']."'";
				$sdetail = $db->runQuery("$qry");
				$this->view->sdetail=$sdetail[0];
			}*/
			
					
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
	
	
	
	
}
?>
