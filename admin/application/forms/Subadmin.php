<?PHP
class Form_Subadmin extends Zend_Form
{
	public function __construct($employeeId="")
	{
		$this->init($employeeId);
	}
	public function init($employeeId)
	{
		$db=new Db();
			if($employeeId!="")
			{
				$formData=$db->runQuery("select * from rbi_user
				join rbi_admin as rbi_admin on(rbi_user.userid=rbi_admin.userId)
				where usrRole='SA' and rbi_user.userid='".$employeeId."'");
			
				$first_name_Value=$formData[0]['fname'];
				$last_name_Value=$formData[0]['lname'];
				$father_name_Value=$formData[0]['fathername'];
				$email_address_Value=$formData[0]['emailaddress'];
				$phone_number_Value=$formData[0]['phoneno'];
				$mobile_number_Value=$formData[0]['mobno'];	
				$state_id_Value=$formData[0]['state'];
				$city_id_Value=$formData[0]['city'];		
				$address_Value=$formData[0]['address'];
				$date_of_birth_Value=changeDate($formData[0]['DateofBirth']);				
				$username_Value=$formData[0]['username'];				
			}
		
		$first_name= new Zend_Form_Element_Text('first_name');
		$first_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'First name is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$first_name_Value);
		
		$last_name= new Zend_Form_Element_Text('last_name');
		$last_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Last name is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$last_name_Value);
		
		$father_name= new Zend_Form_Element_Text('father_name');
		$father_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Father name is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$father_name_Value);
		
		$email_address= new Zend_Form_Element_Text('email_address');
		$email_address->setValue(@$email_address_Value);
		
		$phone_number= new Zend_Form_Element_Text('phone_number');
		$phone_number->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Phone number is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setAttrib("onkeypress","return checknumber(event)")
		->setValue(@$phone_number_Value);
		
		$mobile_number= new Zend_Form_Element_Text('mobile_number');
		$mobile_number->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Phone number is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setAttrib("onkeypress","return checknumber(event)")
		->setValue(@$mobile_number_Value);
		
		$StateArr=array();
		$StateArr[0]['key']="";
		$StateArr[0]['value']="--State--";
		$stateData=$db->runQuery("select * from rbi_state  order by statename");
		if($stateData!="" and count($stateData)>0)
		{
			$i=1;
			foreach($stateData as $key=>$stateValue)
			{
				$StateArr[$i]['key']=$stateValue['stateid'];
				$StateArr[$i]['value']=$stateValue['statename'];
				$i++;
			}
		}	
			
		$state_id=new Zend_Form_Element_Select('state_id');
		$state_id->addMultiOptions($StateArr)		
		->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'State is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setAttrib("onchange","getStatecity(this.value)")
		->setValue(@$state_id_Value);
		
		$CityArr=array();
		$CityArr[0]['key']="";
		$CityArr[0]['value']="--City--";
		if( (isset($_REQUEST['state_id']) and @$_REQUEST['state_id']!="") || (@$state_id_Value!=""))
		{			
			$StateId="";
			if(@$_REQUEST['state_id']!="")
			$StateId=$_REQUEST['state_id'];
			else
			$StateId=$state_id_Value;
			$empData=$db->runQuery("select * from rbi_city where stateid='".$StateId."'");
			if($empData!="" and count($empData)>0)
			{
				$i=1;
				foreach($empData as $key=>$empValue)
				{
					$CityArr[$i]['key']=$empValue['cityid'];
					$CityArr[$i]['value']=$empValue['city'];
					$i++;
				}
			}
		}		
		$city_id=new Zend_Form_Element_Select('city_id');
		$city_id->addMultiOptions($CityArr)		
		->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'City is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$city_id_Value);
		
		$address= new Zend_Form_Element_Text('address');
		$address->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Address is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$address_Value);
		
		$date_of_birth= new Zend_Form_Element_Text('date_of_birth');
		$date_of_birth->setAttrib("style","width:172px;")
		->setAttrib("readonly","true")
		->setValue(@$date_of_birth_Value);
		
		$username= new Zend_Form_Element_Text('username');
		$username->setValue(@$username_Value);
		
		$user_password= new Zend_Form_Element_Password('user_password');
		$user_password->setValue('');
		
		$user_confirm_password= new Zend_Form_Element_Password('user_confirm_password');
		$user_confirm_password->setValue('');
		
		
		$this->addElements(array($first_name,$last_name,$father_name,$email_address,$phone_number,$mobile_number,$state_id,$city_id,$address,$date_of_birth,$username,$user_password,$user_confirm_password));
	}		
}

?>