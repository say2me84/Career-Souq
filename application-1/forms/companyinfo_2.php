<?php
class Form_Companyinfo extends Zend_Form
{		
	public function __construct($user_id = NULL)
	{
		
		global $mySessionFront;
		$db=new Db();
		
		if($user_id!="")

			{
			//echo "SELECT * FROM tbl_users WHERE user_id='".$user_id."'"; exit;
				
		$formData=$db->runQuery("SELECT * FROM tbl_users WHERE user_id='".$user_id."'");
				
				$user_company_address_line_1_Value=$formData[0]['user_company_address_line_1'];
				
				$user_company_address_line_2_Value=$formData[0]['user_company_address_line_2'];
				$user_po_box_Value=$formData[0]['user_po_box'];
				$Nationality_Value=$formData[0]['user_nationality'];
				$user_zip_Value=$formData[0]['user_zip'];
				$Country_id_Value=$formData[0]['user_company_country'];
				$user_company_city_Value=$formData[0]['user_company_city'];
				$user_email_Value=$formData[0]['user_email'];
				$user_company_phone_country_code_Value=$formData[0]['user_company_phone_country_code'];
				$user_company_phone_number_Value=$formData[0]['user_company_phone_number'];
				$user_company_phone_ext_Value=$formData[0]['user_company_phone_ext'];
				$user_company_evening_phone_country_code_Value=$formData[0]['user_company_evening_phone_country_code'];
				$user_company_evening_phone_Value=$formData[0]['user_company_evening_phone'];
				$user_company_evening_phone_extension_code_Value=$formData[0]['user_company_evening_phone_extension_code'];
				$user_mobile_country_code_Value=$formData[0]['user_mobile_country_code'];
				$user_mobile_Value=$formData[0]['user_mobile'];
				$user_company_fax_country_code_Value=$formData[0]['user_company_fax_country_code'];
				$user_company_fax_number_Value=$formData[0]['user_company_fax_number'];
				$user_company_fax_ext_Value=$formData[0]['user_company_fax_ext'];
				$user_company_web_url_Value=$formData[0]['user_company_web_url'];
				
				$user_company_Value=$formData[0]['user_company'];
				$Company_Industry_Value=$formData[0]['user_industry'];
				$user_number_of_employees_Value=$formData[0]['user_number_of_employees'];
				$user_company_detail_Value=$formData[0]['user_company_detail'];
				$user_company_personal_designation_Value=$formData[0]['user_company_personal_designation'];
			}
		
		
		$gender_opt[0]['key']='Male';
		$gender_opt[0]['value']='Male';	
		
		$gender_opt[1]['key']='Female';
		$gender_opt[1]['value']='Female';	
		
		$user_gender= new Zend_Form_Element_Radio('user_gender');
		$user_gender->addMultiOptions($gender_opt);
		$user_gender->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Gender is empty.')))
				//->setAttrib("style","width:203px;")
				->setValue(@$gender_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_gender->class="";
		$this->addElements(array($user_gender));
		
		$user_fname = new Zend_Form_Element_Text('user_fname');	
		$user_fname->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'First Name is empty.')))
				->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_fname->class="inputbox";		
		$this->addElements(array($user_fname));	
		
		$user_dob= new Zend_Form_Element_Text('user_dob');	
		$user_dob->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date Of Birth is empty.')))
				//->setAttrib("style","width:230px;")
				//->setAttrib("readonly","true")
				->setAttrib("onclick","return displayCalendar(document.myform.user_dob,'dd-mm-yyyy',this)")
				->setValue(@$user_dob_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_dob->class="inputbox";
		$this->addElements(array($user_dob));
		
		$user_company_address_line_1= new Zend_Form_Element_Text('user_company_address_line_1');	
		$user_company_address_line_1->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date Of Birth is empty.')))
				//->setAttrib("style","width:230px;")
				//->setAttrib("readonly","true")
				->setValue(@$user_company_address_line_1_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_address_line_1->class="inputbox";
		$this->addElements(array($user_company_address_line_1));
		
		$user_company_address_line_2= new Zend_Form_Element_Text('user_company_address_line_2');	
		$user_company_address_line_2->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date Of Birth is empty.')))
				//->setAttrib("style","width:230px;")
				//->setAttrib("readonly","true")
				->setValue(@$user_company_address_line_2_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_address_line_2->class="inputbox";
		$this->addElements(array($user_company_address_line_2));
		
		$user_po_box= new Zend_Form_Element_Text('user_po_box');	
		$user_po_box->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date Of Birth is empty.')))
				//->setAttrib("style","width:230px;")
				//->setAttrib("readonly","true")
				->setValue(@$user_po_box_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_po_box->class="inputbox";
		$this->addElements(array($user_po_box));
		
		
		
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
					->setAttrib("style","padding:6px;")
					->setValue(@$Nationality_Value);
		$Nationality_id->class="selectbox";
		$this->addElements(array($Nationality_id));
		
		$user_zip= new Zend_Form_Element_Text('user_zip');	
		$user_zip->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date Of Birth is empty.')))
				//->setAttrib("style","width:230px;")
				//->setAttrib("readonly","true")
				->setValue(@$user_zip_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_zip->class="inputbox";
		$this->addElements(array($user_zip));
		
		$user_company_city= new Zend_Form_Element_Text('user_company_city');	
		$user_company_city->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date Of Birth is empty.')))
				//->setAttrib("style","width:230px;")
				//->setAttrib("readonly","true")
				->setValue(@$user_company_city_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_city->class="inputbox";
		$this->addElements(array($user_company_city));
		
		$user_email = new Zend_Form_Element_Text('user_email');	
		$user_email->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_email_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_email->class="inputbox";
		$this->addElements(array($user_email));
		
		$user_company_phone_country_code = new Zend_Form_Element_Text('user_company_phone_country_code');	
		$user_company_phone_country_code->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_phone_country_code_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_phone_country_code->class="inputbox inputbox1";
		$user_company_phone_country_code->placeholder="Country Code";
		$this->addElements(array($user_company_phone_country_code));
		
		$user_company_phone_number = new Zend_Form_Element_Text('user_company_phone_number');	
		$user_company_phone_number->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_phone_number_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_phone_number->class="inputbox inputbox2";
		$user_company_phone_number->placeholder="Phone Number";
		$this->addElements(array($user_company_phone_number));
		
		$user_company_phone_ext = new Zend_Form_Element_Text('user_company_phone_ext');	
		$user_company_phone_ext->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_phone_ext_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_phone_ext->class="inputbox inputbox3";
		$user_company_phone_ext->placeholder="Extension Code (optional)";
		$this->addElements(array($user_company_phone_ext));
		
		$user_company_evening_phone_country_code = new Zend_Form_Element_Text('user_company_evening_phone_country_code');	
		$user_company_evening_phone_country_code->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_evening_phone_country_code_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_evening_phone_country_code->class="inputbox inputbox1";
		$user_company_evening_phone_country_code->placeholder="Country Code";
		$this->addElements(array($user_company_evening_phone_country_code));
		
		$user_company_evening_phone = new Zend_Form_Element_Text('user_company_evening_phone');	
		$user_company_evening_phone->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_evening_phone_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_evening_phone->class="inputbox inputbox2";
		$user_company_evening_phone->placeholder="Phone Number";
		$this->addElements(array($user_company_evening_phone));
		
		$user_company_evening_phone_extension_code = new Zend_Form_Element_Text('user_company_evening_phone_extension_code');	
		$user_company_evening_phone_extension_code->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_evening_phone_extension_code_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_evening_phone_extension_code->class="inputbox inputbox3";
		$user_company_evening_phone_extension_code->placeholder="Extension Code (optional)";
		$this->addElements(array($user_company_evening_phone_extension_code));
		
		$user_mobile_country_code = new Zend_Form_Element_Text('user_mobile_country_code');	
		$user_mobile_country_code->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_mobile_country_code_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_mobile_country_code->class="inputbox inputbox1";
		$user_mobile_country_code->placeholder="Country Code";
		$this->addElements(array($user_mobile_country_code));
		
		$user_mobile = new Zend_Form_Element_Text('user_mobile');	
		$user_mobile->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_mobile_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_mobile->class="inputbox inputbox2";
		$user_mobile->placeholder="Mobile Number";
		$this->addElements(array($user_mobile));
		
		$user_company_fax_country_code = new Zend_Form_Element_Text('user_company_fax_country_code');	
		$user_company_fax_country_code->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_fax_country_code_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_fax_country_code->class="inputbox inputbox1";
		$user_company_fax_country_code->placeholder="Country Code";
		$this->addElements(array($user_company_fax_country_code));
		
		$user_company_fax_number = new Zend_Form_Element_Text('user_company_fax_number');	
		$user_company_fax_number->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_fax_number_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_fax_number->class="inputbox inputbox2";
		$user_company_fax_number->placeholder="Fax Number";
		$this->addElements(array($user_company_fax_number));
		
		$user_company_fax_ext = new Zend_Form_Element_Text('user_company_fax_ext');	
		$user_company_fax_ext->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_fax_ext_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_fax_ext->class="inputbox inputbox3";
		$user_company_fax_ext->placeholder="Extension Code (optional)";
		$this->addElements(array($user_company_fax_ext));
		
		$user_company_web_url = new Zend_Form_Element_Text('user_company_web_url');	
		$user_company_web_url->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$user_company_web_url_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_web_url->class="inputbox";
		$user_company_web_url->placeholder="Extension Code (optional)";
		$this->addElements(array($user_company_web_url));
//============================================================================================================================

		$user_company = new Zend_Form_Element_Text('user_company');	
		$user_company->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Company name is empty.')))
				->setValue(@$user_company_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company->class="inputbox";
		$user_company->placeholder="Company Name";
		$this->addElements(array($user_company));
		
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
			->setAttrib("style","padding:6px;")
			->setValue(@$Country_id_Value);
		$Country_id->class="selectbox";
		$this->addElements(array($Country_id));
//========================================== *** Company Industry (Category) *** =========================================================		
		$Company_IndustryArr=array();
		$Company_IndustryArr[0]['key']="";
		$Company_IndustryArr[0]['value']="Company Industry";
		$Company_IndustryData=$db->runQuery("select * from tbl_job_categories order by category_title");
		//prd($Company_IndustryData);
		if($Company_IndustryData!="" and count($Company_IndustryData)>0)
		{
			$i=1;
			foreach($Company_IndustryData as $key=>$IndustryValue)
			{
				$Company_IndustryArr[$i]['key']=$IndustryValue['cat_id'];
				$Company_IndustryArr[$i]['value']=$IndustryValue['category_title'];
				$i++;
			}
		}	
			
		$Company_Industry=new Zend_Form_Element_Select('Company_Industry');
		$Company_Industry->addMultiOptions($Company_IndustryArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Company Industry is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("style","padding:6px;")
			->setValue(@$Company_Industry_Value);
		$Company_Industry->class="selectbox";
		$this->addElements(array($Company_Industry));
//============================================================================================================================
		$user_number_of_employees_opt[0]['key']='1-9 employees';
		$user_number_of_employees_opt[0]['value']='1-9 employees';	
		
		$user_number_of_employees_opt[1]['key']='10-49 employees';
		$user_number_of_employees_opt[1]['value']='10-49 employees';
		
		$user_number_of_employees_opt[2]['key']='50-99 employees';
		$user_number_of_employees_opt[2]['value']='50-99 employees';	
		
		$user_number_of_employees_opt[3]['key']='100-499 employees';
		$user_number_of_employees_opt[3]['value']='100-499 employees';
		
		$user_number_of_employees_opt[4]['key']='500 employees or more';
		$user_number_of_employees_opt[4]['value']='500 employees or more';
		
		$user_number_of_employees= new Zend_Form_Element_Select('user_number_of_employees');
		$user_number_of_employees->addMultiOptions($user_number_of_employees_opt);
		$user_number_of_employees->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Gender is empty.')))
				->setAttrib("style","padding:6px;")
				->setValue(@$user_number_of_employees_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_number_of_employees->class="selectbox";
		$this->addElements(array($user_number_of_employees));
//============================================================================================================================
		
		$user_company_detail= new Zend_Form_Element_Textarea('user_company_detail');	
		$user_company_detail->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'user_company_detail is empty.')))
				//->setAttrib("style","width:202px; height:50px;")
				->setAttrib("cols","10")
				->setAttrib("rows","5")
				->setValue(@$user_company_detail_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_detail->class="textarea";
		//$user_company_detail->placeholder="Country Code";
		$this->addElements(array($user_company_detail));		
		
		
		$user_company_personal_designation= new Zend_Form_Element_Text('user_company_personal_designation');	
		$user_company_personal_designation->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Designation is empty.')))
				//->setAttrib("style","width:230px;")
				//->setAttrib("readonly","true")
				->setValue(@$user_company_personal_designation_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_company_personal_designation->class="inputbox";
		$this->addElements(array($user_company_personal_designation));
			
				
	}
	
}

?>