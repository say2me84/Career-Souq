<?php
class Form_Postjob extends Zend_Form
{
	public function __construct($id = NULL)
	{
		
		global $mySessionFront;
		$db=new Db();
		
		if($id!="")

			{
				echo "SELECT * FROM tbl_jobs WHERE id='".$id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_jobs WHERE id='".$id."'");
				
				$CategorySno_Value=$formData[0]['category_title'];
				//$SubCatId_Value=$formData[0]['banner_link'];
				//prd($$CategorySno_Value); exit;	job_role
			}
		
		$Job_Title= new Zend_Form_Element_Text('Job_Title');	
		$Job_Title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Job Title is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("class","inputbox");
		$this->addElements(array($Job_Title));
				
		$job_keywords= new Zend_Form_Element_Text('job_keywords');	
		$job_keywords->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Job Keywords is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("class","inputbox");
		$this->addElements(array($job_keywords));
		
		$CategoryArr=array();
		$CategoryArr[0]['key']="";
		$CategoryArr[0]['value']="--Category Name--";
		$CategoryData=$db->runQuery("select * from tbl_job_categories  order by cat_id");
		//prd($CategoryData);
		
		if($CategoryData!="" and count($CategoryData)>0)
		{
			$i=1;
			foreach($CategoryData as $key=>$CategoryValue)
			{
				$CategoryArr[$i]['key']=$CategoryValue['cat_id'];
				$CategoryArr[$i]['value']=$CategoryValue['category_title'];
				$i++;
			}
		}
			
		$CategorySno=new Zend_Form_Element_Select('CategorySno');
		$CategorySno->addMultiOptions($CategoryArr)		
					->setRequired(true)
					->addValidator('NotEmpty',true,array('messages' =>'Category Name is required.'))
					->addDecorator('Errors', array('class'=>'errormsg'))
					->setAttrib("onchange","getsubcat(this.value)")
					->setValue(@$CategorySno_Value)
					->setAttrib("style","width:155px;");
		$CategorySno->class="inputbox";
		$this->addElements(array($CategorySno));
		
		
		
		$SubCatArr=array();
		$SubCatArr[0]['key']="";
		$SubCatArr[0]['value']="--Subcategory--";
		$SubCatArrData=$db->runQuery("select * from tbl_job_sub_categories  order by sub_cat_id");
		//prd($SubCatArrData);
		
		if($SubCatArrData!="" and count($SubCatArrData)>0)
		{
			$i=1;
			foreach($SubCatArrData as $key=>$SubCatArrValue)
			{
				$SubCatArr[$i]['key']=$SubCatArrValue['sub_cat_id'];
				$SubCatArr[$i]['value']=$SubCatArrValue['sub_category_title'];
				$i++;
			}
		}
		
		$SubCatId=new Zend_Form_Element_Select('SubCatId');
		$SubCatId->addMultiOptions($SubCatArr)		
		->setRequired(false)
		->addValidator('NotEmpty',true,array('messages' =>'SubCategory is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;")
		
		->setValue(@$SubCatId_Value);
		//$SubCatId->class="selectbox";
		$this->addElements(array($SubCatId));
		
		$Description= new Zend_Form_Element_Textarea('Description');	
		$Description->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Description is empty.')))
				->setAttrib("class", "textarea ckeditor")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($Description));
		
		$Responsibilities= new Zend_Form_Element_Textarea('Responsibilities');	
		$Responsibilities->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Responsibilities is empty.')))
				->setAttrib("class", "textarea ckeditor")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($Responsibilities));
		
		$Skills_Required= new Zend_Form_Element_Textarea('Skills_Required');	
		$Skills_Required->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Skills is empty.')))
				->setAttrib("class", "textarea ckeditor")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($Skills_Required));

	/*---------------------------------------- CountryId ----------------------------------------------------*/
		$CountryArr=array();
		$CountryArr[0]['key']="";
		$CountryArr[0]['value']="--Country--";
		$CountryData=$db->runQuery("select * from tbl_countries order by country_id");
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
		$CountryId=new Zend_Form_Element_Select('CountryId');
		$CountryId->addMultiOptions($CountryArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Country is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;");
		$this->addElements(array($CountryId));
		
		
		
		$City= new Zend_Form_Element_Text('City');	
		$City->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'City is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("class","inputbox");
		$this->addElements(array($City));
		
/*---------------------------------------- Employment Type ----------------------------------------------------*/
		$EmploymentArr=array();
		$EmploymentArr[0]['key']="";
		$EmploymentArr[0]['value']="Employment Type";
		$EmploymentData=$db->runQuery("select * from tbl_employment_type order by employment_id");
		if($EmploymentData!="" and count($EmploymentData)>0)
		{
			$i=1;
			foreach($EmploymentData as $key=>$EmploymentValue)
			{
				$EmploymentArr[$i]['key']=$EmploymentValue['employment_id'];
				$EmploymentArr[$i]['value']=$EmploymentValue['employment_title'];
				$i++;
			}
		}	
		$Employment_Type=new Zend_Form_Element_Select('Employment_Type');
		$Employment_Type->addMultiOptions($EmploymentArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Employment Type is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			
			->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;");
		$this->addElements(array($Employment_Type));
/*---------------------------------------- Job Type ----------------------------------------------------*/
		$JobArr=array();
		$JobArr[0]['key']="";
		$JobArr[0]['value']="-- Job Type --";
		$JobData=$db->runQuery("select * from tbl_job_types order by id");
		if($JobData!="" and count($JobData)>0)
		{
			$i=1;
			foreach($JobData as $key=>$JobValue)
			{
				$JobArr[$i]['key']=$JobValue['id'];
				$JobArr[$i]['value']=$JobValue['job_type_title'];
				$i++;
			}
		}	
		$Job_Type=new Zend_Form_Element_Select('Job_Type');
		$Job_Type->addMultiOptions($JobArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Job Type is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;");
		$this->addElements(array($Job_Type));	
		
/*---------------------------------------- Career_Level ----------------------------------------------------*/
		$Career_LevelArr=array();
		$Career_LevelArr[0]['key']="";
		$Career_LevelArr[0]['value']="-- Career Level --";
		$Career_LevelData=$db->runQuery("select * from tbl_career_levels order by career_level_id");
		//prd($Career_LevelData);
		if($Career_LevelData!="" and count($Career_LevelData)>0)
		{
			$i=1;
			foreach($Career_LevelData as $key=>$Career_LevelValue)
			{
				$Career_LevelArr[$i]['key']=$Career_LevelValue['career_level_id'];
				$Career_LevelArr[$i]['value']=$Career_LevelValue['career_level_title'];
				$i++;
			}
		}	
		$Career_Level=new Zend_Form_Element_Select('Career_Level');
		$Career_Level->addMultiOptions($Career_LevelArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Career Level is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;");
		$this->addElements(array($Career_Level));	
		
/*---------------------------------------- Education ----------------------------------------------------*/
		$EducationArr=array();
		$EducationArr[0]['key']="";
		$EducationArr[0]['value']="-- Education --";
		$EducationData=$db->runQuery("select * from tbl_job_educations order by id");
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
		$EducationId=new Zend_Form_Element_Select('EducationId');
		$EducationId->addMultiOptions($EducationArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Education is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;");
		$this->addElements(array($EducationId));
		
/*---------------------------------------- Experience ----------------------------------------------------*/
		$ExperienceArr=array();
		$ExperienceArr[0]['key']="";
		$ExperienceArr[0]['value']="-- Experience --";
		$ExperienceData=$db->runQuery("select * from tbl_job_experiences order by id");
		//prd($ExperienceData);
		if($ExperienceData!="" and count($ExperienceData)>0)
		{
			$i=1;
			foreach($ExperienceData as $key=>$ExperienceValue)
			{
				$ExperienceArr[$i]['key']=$ExperienceValue['id'];
				$ExperienceArr[$i]['value']=$ExperienceValue['experience_title'];
				$i++;
			}
		}	
		$ExperienceId=new Zend_Form_Element_Select('ExperienceId');
		$ExperienceId->addMultiOptions($ExperienceArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Education is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;");
		$this->addElements(array($ExperienceId));
/*---------------------------------------- Experience ----------------------------------------------------*/		
		$Travel_Required_opt[0]['key']='No';
		$Travel_Required_opt[0]['value']='No';	
		
		$Travel_Required_opt[1]['key']='Yes';
		$Travel_Required_opt[1]['value']='Yes';	
		
		$Travel_Required= new Zend_Form_Element_Select('Travel_Required');
		$Travel_Required->addMultiOptions($Travel_Required_opt);
		$Travel_Required->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student title is empty.')))
				->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($Travel_Required));				
/*---------------------------------------- Relocation ----------------------------------------------------*/		
		$Relocation_opt[0]['key']='No';
		$Relocation_opt[0]['value']='No';	
		
		$Relocation_opt[1]['key']='Yes';
		$Relocation_opt[1]['value']='Yes';	
		
		$Relocation= new Zend_Form_Element_Select('Relocation');
		$Relocation->addMultiOptions($Travel_Required_opt);
		$Relocation->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student title is empty.')))
				->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($Relocation));

/*---------------------------------------- job_role ----------------------------------------------------*/
		$Job_RolesArr=array();
		$Job_RolesArr[0]['key']="";
		$Job_RolesArr[0]['value']="-- Job Role --";
		$Job_RolesData=$db->runQuery("select * from tbl_job_roles order by job_role_id");
		//prd($Job_RolesData);
		if($Job_RolesData!="" and count($Job_RolesData)>0)
		{
			$i=1;
			foreach($Job_RolesData as $key=>$Job_RolesDataValue)
			{
				$Job_RolesArr[$i]['key']=$Job_RolesDataValue['job_role_id'];
				$Job_RolesArr[$i]['value']=$Job_RolesDataValue['job_role_title'];
				$i++;
			}
		}	
		$job_role=new Zend_Form_Element_Select('job_role');
		$job_role->addMultiOptions($Job_RolesArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Job Role is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("class","inputbox")
			->setAttrib("style","width:150px;");
		$this->addElements(array($job_role));
/*---------------------------------------- job_role ----------------------------------------------------*/

		$Sallary= new Zend_Form_Element_Text('Sallary');	
		$Sallary->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Sallary is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("style","width:170px;")
				->setAttrib("onkeypress","return checknumber(event)")
				->setAttrib("class","inputbox");
		$this->addElements(array($Sallary));
		
		$Email= new Zend_Form_Element_Text('Email');	
		$Email->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("class","inputbox");
		$this->addElements(array($Email));
		
		$Phone_Number= new Zend_Form_Element_Text('Phone_Number');	
		$Phone_Number->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Phone Number is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				//->setAttrib("onkeypress","return checknumber(event)")
				->setAttrib("class","inputbox");
		$this->addElements(array($Phone_Number));
		
		$Contact_Name= new Zend_Form_Element_Text('Contact_Name');	
		$Contact_Name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Contact Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("class","inputbox");
		$this->addElements(array($Contact_Name));
		
		$Fax= new Zend_Form_Element_Text('Fax');	
		$Fax->setRequired(false)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Fax is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				//->setAttrib("onkeypress","return checknumber(event)")
				->setAttrib("class","inputbox");
		$this->addElements(array($Fax));
		
		
		/*$post_job = new Zend_Form_Element_Submit('post_job','post this job',array('disableLoadDefaultDecorators' =>true));
		$post_job->class='post_job_btn';
		$this->addElements(array($post_job));*/
		
		
		
		
	/*	$submit = new Zend_Form_Element_Button('button','post this job',array('disableLoadDefaultDecorators' =>true));
		$submit->class='post_job_btn';
		$this->addElements(array($submit));*/
	}

}

?>