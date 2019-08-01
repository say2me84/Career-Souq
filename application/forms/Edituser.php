<?php
class Form_Edituser extends Zend_Form
{
	public function __construct($user_id = NULL)
	{
		
		global $mySessionFront;
		$db=new Db();
		
		if($user_id!="")

			{
				//$formData=$db->runQuery("SELECT * FROM tbl_users WHERE cust_id='".$cust_id."'");
/*$formData=$db->runQuery("SELECT  tbl_countries.country_name,tbl_career_levels.career_level_title,tbl_users.user_id,tbl_users.user_type,tbl_users.user_fname,tbl_users.user_lname,
	tbl_users.user_email,tbl_users.user_phone,tbl_users.user_image,tbl_users.user_gender,tbl_nationalities.nation_title,tbl_users.user_dob,tbl_users.user_marital_status,tbl_job_educations.education_title,tbl_users.user_skills_n_expertise,tbl_users.user_profile_summary,tbl_users.user_company,tbl_users.user_city,tbl_job_categories.category_title FROM tbl_users LEFT JOIN tbl_career_levels ON tbl_users.user_career_level = tbl_career_levels.career_level_id LEFT JOIN tbl_countries ON tbl_users.user_country = tbl_countries.country_id
	LEFT JOIN tbl_nationalities ON tbl_users.user_nationality = tbl_nationalities.id LEFT JOIN tbl_job_educations ON tbl_users.user_education = tbl_job_educations.id LEFT JOIN tbl_job_categories ON tbl_users.user_industry = tbl_job_categories.cat_id WHERE user_id ='".$user_id."'");*/
				//prd($formData);
				
				$formData=$db->runQuery("SELECT * FROM tbl_users WHERE user_id='".$user_id."'");
				
				//prd($formData);
				
				$user_fname_Value=$formData[0]['user_fname'];
				$user_lname_Value=$formData[0]['user_lname'];
				$user_email_Value=$formData[0]['user_email'];
				$user_phone_Value=$formData[0]['user_phone'];
				$user_gender_Value=$formData[0]['user_gender'];
				$Nationality_Value=$formData[0]['user_nationality'];
				$Country_id_Value=$formData[0]['user_country'];
				$user_city_Value=$formData[0]['user_city'];
				$user_dob_Value=$formData[0]['user_dob'];
				$user_marital_status_Value=$formData[0]['user_marital_status'];
				$user_career_level_Value=$formData[0]['user_career_level'];
				$user_profile_summary_Value=$formData[0]['user_profile_summary'];
				$user_skills_n_expertise_Value=$formData[0]['user_skills_n_expertise'];
				$user_image_Value=$formData[0]['user_image'];
				
				$UserIndustry_Value=$formData[0]['user_industry'];
				//prd($banner_image_Value); exit;
			}
		//user_profile_summary
		
		
		$gender_opt[0]['key']='Male';
		$gender_opt[0]['value']='Male';	
		
		$gender_opt[1]['key']='Female';
		$gender_opt[1]['value']='Female';	
		
		$user_gender= new Zend_Form_Element_Select('user_gender');
		$user_gender->addMultiOptions($gender_opt);
		$user_gender->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Gender is empty.')))
				//->setAttrib("style","width:203px;")
				->setValue(@$user_gender_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_gender->class="inputbox";
		$this->addElements(array($user_gender));
		
		$user_fname = new Zend_Form_Element_Text('user_fname');	
		$user_fname->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'First Name is empty.')))
				->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_fname->class="inputbox";		
		$this->addElements(array($user_fname));
		$user_lname = new Zend_Form_Element_Text('user_lname');	
		$user_lname->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Last Name is empty.')))
				->setValue(@$user_lname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_lname->class="inputbox";
		$this->addElements(array($user_lname));
		$user_email = new Zend_Form_Element_Text('user_email');	
		$user_email->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_email_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_email->class="inputbox";
		$this->addElements(array($user_email));
		$user_city = new Zend_Form_Element_Text('user_city');	
		$user_city->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'City Name is empty.')))
				->setValue(@$user_city_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_city->class="inputbox";		
		$this->addElements(array($user_city));
		$user_phone = new Zend_Form_Element_Text('user_phone');	
		$user_phone->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Phone No. is empty.')))
				->setValue(@$user_phone_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_phone->class="inputbox";
		$this->addElements(array($user_phone));
		
		$user_profile_summary = new Zend_Form_Element_Textarea('user_profile_summary');	
		$user_profile_summary->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Skills & Expertise is empty.')))
				->setValue(@$user_profile_summary_Value)
				 ->setAttrib("rows","4") 
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_profile_summary->class="inputbox ckeditor";
		$this->addElements(array($user_profile_summary));
		
		$user_skills_n_expertise = new Zend_Form_Element_Textarea('user_skills_n_expertise');	
		$user_skills_n_expertise->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Skills & Expertise is empty.')))
				->setValue(@$user_skills_n_expertise_Value)
				->setAttrib("rows","4") 
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_skills_n_expertise->class="inputbox ckeditor";
		$this->addElements(array($user_skills_n_expertise));
		
		$user_dob= new Zend_Form_Element_Text('user_dob');	
		$user_dob->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date Of Birth is empty.')))
				//->setAttrib("style","width:230px;")
				->setAttrib("readonly","true")
				->setAttrib("onclick","return displayCalendar(document.myform.user_dob,'dd-mm-yyyy',this)")
				->setValue(@$user_dob_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_dob->class="inputbox";
		$this->addElements(array($user_dob));
		
		$marital_status_opt[0]['key']='Unmarried';
		$marital_status_opt[0]['value']='Unmarried';	
		$marital_status_opt[1]['key']='Married';
		$marital_status_opt[1]['value']='Married';
		$marital_status_opt[2]['key']='Divorced';
		$marital_status_opt[2]['value']='Divorced';	
		
		$user_marital_status= new Zend_Form_Element_Select('user_marital_status');
		$user_marital_status->addMultiOptions($marital_status_opt);
		$user_marital_status->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Marital Status is empty.')))
				//->setAttrib("style","width:203px;")
				->setValue(@$user_marital_status_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_marital_status->class="inputbox";
		$this->addElements(array($user_marital_status));
		
		
		////=================== Select Nationality ===========================//
						
		$NationalityArr=array();
		$NationalityArr[0]['key']="";
		$NationalityArr[0]['value']="Select Nationality";
		$NationalityData=$db->runQuery("select * from tbl_nationalities order by nation_title");
		//prd($NationalityData);
		if($NationalityData!="" and count($NationalityData)>0)
		{
			$i=1;
			foreach($NationalityData as $key=>$NationalityValue)
			{
				$NationalityArr[$i]['key']=$NationalityValue['id'];
				$NationalityArr[$i]['value']=$NationalityValue['nation_title'];
				$i++;
			}
		}	
			
		$Nationality_id=new Zend_Form_Element_Select('Nationality_id');
		$Nationality_id->addMultiOptions($NationalityArr)		
					->setRequired(true)
					->addValidator('NotEmpty',true,array('messages' =>'Nationality is required.'))
					->addDecorator('Errors', array('class'=>'errormsg'))
					//->setAttrib("onchange","getNationalitycity(this.value)")
					->setValue(@$Nationality_Value);
		$Nationality_id->class="inputbox";
		$this->addElements(array($Nationality_id));
		
		////=================== COUNTRY ===========================//
		$CountryArr=array();
		$CountryArr[0]['key']="";
		$CountryArr[0]['value']="Select Country";
		$CountryData=$db->runQuery("select * from tbl_countries order by country_name");
		//prd($CountryData);
		if($CountryData!="" and count($CountryData)>0)
		{
			$i=1;
			foreach($CountryData as $key=>$CountryValue)
			{
				$CountryArr[$i]['key']=$CountryValue['country_id'];
				$CountryArr[$i]['value']=$CountryValue['country_name'];
				$i++;
			}
		}	
			
		$Country_id=new Zend_Form_Element_Select('Country_id');
		$Country_id->addMultiOptions($CountryArr)		
				->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Country is required.'))
				->addDecorator('Errors', array('class'=>'errormsg'))
				//->setAttrib("onchange","getCountrycity(this.value)")
				->setValue(@$Country_id_Value);
		$Country_id->class="inputbox";
		$this->addElements(array($Country_id));
		
		
		////=================== Career Level ===========================//
		$CareerArr=array();
		$CareerArr[0]['key']="";
		$CareerArr[0]['value']="Select Career Level";
		$CareerData=$db->runQuery("select * from tbl_career_levels order by career_level_title");
			//prd($CareerData);
		if($CareerData!="" and count($CareerData)>0)
		{
			$i=1;
			foreach($CareerData as $key=>$CareerValue)
			{
				$CareerArr[$i]['key']=$CareerValue['career_level_id'];
				$CareerArr[$i]['value']=$CareerValue['career_level_title'];
				$i++;
			}
		}	
			
		$Career_Level=new Zend_Form_Element_Select('Career_Level');
		$Career_Level->addMultiOptions($CareerArr)		
				->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Career Level is required.'))
				->addDecorator('Errors', array('class'=>'errormsg'))
				//->setAttrib("onchange","getCountrycity(this.value)")
				->setValue(@$user_career_level_Value);
		$Career_Level->class="inputbox";
		$this->addElements(array($Career_Level));
		
		$user_image = new Zend_Form_Element_File('user_image');	
		//$user_image->setAttrib("style", "width:400px;");
		$user_image->setValue(@$user_image_Value);
		$user_image->class="inputbox";
		$this->addElements(array($user_image));
		
		////=================== user_industry ===========================//
		$IndustryArr=array();
		$IndustryArr[0]['key']="";
		$IndustryArr[0]['value']="Select Industry";
		$IndustryData=$db->runQuery("select * from tbl_job_categories order by category_title");
			//prd($IndustryData);
		
		if($IndustryData!="" and count($IndustryData)>0)
		{
			$i=1;
			foreach($IndustryData as $key=>$IndustryValue)
			{
				$IndustryArr[$i]['key']=$IndustryValue['cat_id'];
				$IndustryArr[$i]['value']=$IndustryValue['category_title'];
				$i++;
			}
		}
			
		$UserIndustry=new Zend_Form_Element_Select('UserIndustry');
		$UserIndustry->addMultiOptions($IndustryArr)		
				->setRequired(true)
				->addValidator('NotEmpty',true,array('messages' =>'Industry is required.'))
				->addDecorator('Errors', array('class'=>'errormsg'))
				//->setAttrib("onchange","getCountrycity(this.value)")
				->setValue(@$UserIndustry_Value);
		$UserIndustry->class="inputbox";
		$this->addElements(array($UserIndustry));
		
		$user_image = new Zend_Form_Element_File('user_image');	
		//$user_image->setAttrib("style", "width:400px;");
		$user_image->setValue(@$user_image_Value);
		$user_image->class="inputbox";
		$this->addElements(array($user_image));
		
		
		
////=========================================== User Experience ===========================//
		$Position = new Zend_Form_Element_Text('Position');	
		$Position->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Position is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$Position->class="inputbox";		
		$this->addElements(array($Position));
		
		$Company = new Zend_Form_Element_Text('Company');	
		$Company->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Company name is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$Company->class="inputbox";		
		$this->addElements(array($Company));
		
		$Location = new Zend_Form_Element_Text('Location');	
		$Location->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Location is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$Location->class="inputbox";		
		$this->addElements(array($Location));
		
		$employment_period_from = new Zend_Form_Element_Text('employment_period_from');	
		$employment_period_from->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Employment Period From is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$employment_period_from->class="inputbox";		
		$this->addElements(array($employment_period_from));
		
		$employment_period_to = new Zend_Form_Element_Text('employment_period_to');	
		$employment_period_to->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Employment Period To is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$employment_period_to->class="inputbox";		
		$this->addElements(array($employment_period_to));
		
		$Year = new Zend_Form_Element_Text('Year');	
		$Year->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Year is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$Year->class="inputbox";		
		$this->addElements(array($Year));
		
		$Month = new Zend_Form_Element_Text('Month');	
		$Month->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Month is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$Month->class="inputbox";		
		$this->addElements(array($Month));
		
		$Responsibility = new Zend_Form_Element_Textarea('Responsibility');	
		$Responsibility->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Responsibility is empty.')))
				->setAttrib("rows","4")
				//rows="4" cols="10" 
				->addDecorator('Errors', array('class'=>'errormsg'));
		$Responsibility->class="inputbox ckeditor";		
		$this->addElements(array($Responsibility));
		
		
		
		$Salary = new Zend_Form_Element_Text('Salary');	
		$Salary->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Salary is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$Salary->class="inputbox";
		$Salary->class="inputbox";		
		$this->addElements(array($Salary));
		
////=========================================== User Education ===========================//
		////=================== Degree Name ===========================//
		$EducationArr=array();
		$EducationArr[0]['key']="";
		$EducationArr[0]['value']="Select Education Level";
		$EducationData=$db->runQuery("select * from tbl_job_educations order by education_title");
			//prd($EducationData);
		if($EducationData!="" and count($EducationData)>0)
		{
			$i=1;
			foreach($EducationData as $key=>$EducationValue)
			{
				$EducationArr[$i]['key']=$EducationValue['id'];
				$EducationArr[$i]['value']=$EducationValue['education_title'];
				$i++;
			}
		}	
			
		$Education=new Zend_Form_Element_Select('Education');
		$Education->addMultiOptions($EducationArr)		
				->setRequired(false)
				->addValidator('NotEmpty',true,array('messages' =>'Education is required.'))
				->addDecorator('Errors', array('class'=>'errormsg'));
				//->setAttrib("onchange","getCountrycity(this.value)")
				//->setValue(@$user_career_level_Value);
		$Education->class="inputbox";
		$this->addElements(array($Education));
		
		$UniversityName = new Zend_Form_Element_Text('UniversityName');	
		$UniversityName->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'University Name is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$UniversityName->class="inputbox";
		$this->addElements(array($UniversityName));
		
		$StartingYear = new Zend_Form_Element_Text('StartingYear');	
		$StartingYear->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Starting Year is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$StartingYear->class="inputbox";
		$this->addElements(array($StartingYear));
		
		$FinishingYear = new Zend_Form_Element_Text('FinishingYear');	
		$FinishingYear->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Finishing Year is empty.')))
				//->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$FinishingYear->class="inputbox";
		$this->addElements(array($FinishingYear));
		
		
	}

}

?>