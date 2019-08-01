<?php
class Form_Register extends Zend_Form
{
	public function init(){
		
		
		////=================== COUNTRY ===========================//
						
		$CountryArr=array();
		$CountryArr[0]['key']="";
		$CountryArr[0]['value']="Select Country";
		$CountryData=$db->runQuery("select * from tbl_countries order by name");
		//prd($CountryData);
		if($CountryData!="" and count($CountryData)>0)
		{
			$i=1;
			foreach($CountryData as $key=>$CountryValue)
			{
				$CountryArr[$i]['key']=$CountryValue['id'];
				$CountryArr[$i]['value']=$CountryValue['name'];
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
				//->setAttrib("readonly","true")
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