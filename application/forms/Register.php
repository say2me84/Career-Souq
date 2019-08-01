<?php
class Form_Register extends Zend_Form
{		
	public function __construct($user_id = NULL)
	{
		
		global $mySessionFront;
		$db=new Db();
		
		if($user_id!="")

			{
			//echo "SELECT * FROM rbi_custac WHERE cust_id='".$cust_id."'"; exit;
					/*$formData=$db->runQuery("SELECT * FROM rbi_custac WHERE cust_id='".$cust_id."'");
				
				$user_fname_Value=$formData[0]['user_fname'];
				$gender_Value=$formData[0]['gender'];
				$father_name_Value=$formData[0]['father_name'];
				$cust_dob_Value=$formData[0]['cust_dob'];											
				$address_Value=$formData[0]['address'];
				$branch_Id_Value=$formData[0]['branchId'];
				$phone_home_Value=$formData[0]['phone_home'];
				$phone_off_Value=$formData[0]['phone_off'];
				$mobi_one_Value=$formData[0]['mobi_one'];
				$mobi_two_Value=$formData[0]['mobi_two'];
				$pan_no_Value=$formData[0]['pan_no'];
				$dl_no_Value=$formData[0]['dl_no'];
				//$cust_pic_Value=$formData[0]['cust_pic'];
				//$cust_sing_Value=$formData[0]['cust_sing'];
				$_Value=$formData[0]['user_fname'];
				$_Value=$formData[0]['user_fname'];*/
				//$profileId_Value=$formData[0]['profileId'];
			}
		
		
		$gender_opt[0]['key']='Male';
		$gender_opt[0]['value']='Male';	
		
		$gender_opt[1]['key']='Female';
		$gender_opt[1]['value']='Female';	
		
		$user_gender= new Zend_Form_Element_Select('user_gender');
		$user_gender->addMultiOptions($gender_opt);
		$user_gender->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Gender is empty.')))
				//->setAttrib("style","width:203px;")
				->setValue(@$gender_Value)
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
				//->setValue(@$emailaddress_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_email->class="inputbox";
		$this->addElements(array($user_email));
		
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
		$Country_id->class="selectbox";
		$this->addElements(array($Country_id));
		
		
		$user_city = new Zend_Form_Element_Text('user_city');	
		$user_city->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'City is empty.')))
				//->setValue(@$user_city_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_city->class="inputbox";
		$this->addElements(array($user_city));
		
		
		
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
		$Nationality_id->class="selectbox";
		$this->addElements(array($Nationality_id));
		
		
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
		
		
		$language_opt[0]['key']='English';
		$language_opt[0]['value']='English';	
		
		$language_opt[1]['key']='Arabic';
		$language_opt[1]['value']='Arabic';
		
		$language_opt[2]['key']='French';
		$language_opt[2]['value']='French';	
		
		$user_language_preference= new Zend_Form_Element_Radio('user_language_preference');
		$user_language_preference->addMultiOptions($language_opt);
		$user_language_preference->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Please select language.')))
				//->setAttrib("style","width:203px;")
				->setValue(@$user_language_preference_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		//$user_language_preference->class="inputbox";
		$this->addElements(array($user_language_preference));

//=================================================================================//			
		$user_password = new Zend_Form_Element_Password('user_password');	
		$user_password->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Password is empty.')))
				//->setValue(@$user_password_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$user_password->class="inputbox";
		$this->addElements(array($user_password));
		
		$confirm_user_password = new Zend_Form_Element_Password('confirm_user_password');	
		$confirm_user_password->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Password is empty.')))
				//->setValue(@$user_password_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$confirm_user_password->class="inputbox";
		$this->addElements(array($confirm_user_password));
//=================================================================================//
			
				
	}
	
}

?>