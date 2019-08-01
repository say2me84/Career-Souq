<?PHP
class Form_Customer extends Zend_Form
{
	public function __construct($customerId="")
	{
		$this->init($customerId);
	}
	public function init($customerId)
	{
		$db=new Db();
		global $mySession;
			if($customerId!="")
			{
			
				$formData=$db->runQuery("select *, rbi_user_customer.agentId as agid from rbi_user
				join rbi_user_customer on(rbi_user.userid=rbi_user_customer.userId)
				join rbi_user_to_scheme on(rbi_user.userid=rbi_user_to_scheme.userid)
				where usrRole='C' and rbi_user.userid='".$customerId."'");
				
				$scheme_cat_id_value='';
				$scheme_Id_Value=$formData[0]['schemId'];
				$agent_Id_Value=$formData[0]['agid'];
				$noag_employee_Id_Value =$formData[0]['noagentempid'];
				$first_name_Value=$formData[0]['fname'];
				$last_name_Value=$formData[0]['lname'];
				$fathername_Value=$formData[0]['fathername'];
				$husbandname_Value=$formData[0]['husbandname'];
				$nationality_Value=$formData[0]['nationality'];
				$email_address_Value=$formData[0]['emailaddress'];
				$phone_number_Value=$formData[0]['phoneno'];
				$mobile_number_Value=$formData[0]['mobno'];
				$pan_card_number_Value=$formData[0]['PanCartNumber'];
				$state_id_Value=$formData[0]['state'];
				$city_id_Value=$formData[0]['city'];
				$address_Value=$formData[0]['address'];
				$date_of_birth_Value=changeDate($formData[0]['DateofBirth']);
				$guardiandt_Value=$formData[0]['guardiandt'];
				$nomini_name_Value=$formData[0]['NominiName'];
				$nomini_age_Value=$formData[0]['NominiAge'];
				$nomini_relation_Value=$formData[0]['NominiRelation'];
				$NominiAddress_Value=$formData[0]['NominiAddress'];
				$passbookno_Value=$formData[0]['PassBookNo'];
				$bondno_Value=$formData[0]['Bondno'];
				$proffession_Value=$formData[0]['Proffession'];
				$username_Value=$formData[0]['username'];	
				$branch_Id_Value=$formData[0]['userbranch'];
				
			}
		
		if($customerId=="")
		{
			$SchemecatArr=array();
			$SchemecatArr[0]['key']="";
			$SchemecatArr[0]['value']="--Scheme Type--";
			$scData=$db->runQuery("select * from rbi_scheme_type order by schemeTypeId");
			if($scData!="" and count($scData)>0)
			{
				$i=1;
				foreach($scData as $key=>$stateValue)
				{
					$SchemecatArr[$i]['key']=$stateValue['schemeTypeId'];
					$SchemecatArr[$i]['value']=$stateValue['schemeType'];
					$i++;
				}
			}	
				
			$scheme_cat_id=new Zend_Form_Element_Select('scheme_cat_id');
			$scheme_cat_id->addMultiOptions($SchemecatArr)		
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'State is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("onchange","getSchemelist(this.value)")
			->setValue(@$scheme_cat_id_value);
			$this->addElements(array($scheme_cat_id));
			
			$SchemeArr=array();
			$SchemeArr[0]['key']="";
			$SchemeArr[0]['value']="--Scheme--";
			if( (isset($_REQUEST['scheme_cat_id']) and @$_REQUEST['scheme_cat_id']!=""))
			{
				$schemeData=$db->runQuery("select * from rbi_scheme where scheme_type='".@$_REQUEST['scheme_cat_id']."' order by title");
				if($schemeData!="" and count($schemeData)>0)
				{
					$i=1;
					foreach($schemeData as $key=>$schemeValue)
					{
						$SchemeArr[$i]['key']=$schemeValue['schemId'];
						$SchemeArr[$i]['value']=$schemeValue['title'].'/L:'.$schemeValue['landsize'].'/'.$schemeValue['installment'];
						$i++;
					}
				}
			}	
				
			$scheme_Id=new Zend_Form_Element_Select('scheme_Id');
			$scheme_Id->addMultiOptions($SchemeArr)		
			->setValue(@$scheme_Id_Value);
			if(@$scheme_Id_Value!="")
			{
			$scheme_Id->setAttrib("disabled","true");
			}
			else
			{
			$scheme_Id->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Scheme is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
			}
			$this->addElements(array($scheme_Id));
		}
		
		if($customerId=="")
		{
			$BranchArr=array();
				
		$brwhere = '';
		if($mySession->user['branchonly']['isbranch'])
		 {
			
			$brwhere .= " and ru.userid = '".$mySession->user['branchonly']['branchid']."' ";
			$i=0;
		 } else {
		 	$BranchArr[0]['key']="";

			$BranchArr[0]['value']="--Branch--";
			$i=1;
		 }
		$branchData=$db->runQuery("select ru.userid, ru.fname, rb.profileId  from rbi_user as ru left join rbi_branch as rb on(ru.userid=rb.userId) where usrRole='B' ".$brwhere." order by fname");

		if($branchData!="" and count($branchData)>0)

		{

			

			foreach($branchData as $key=>$branchValue)

			{

				$BranchArr[$i]['key']=$branchValue['userid'];

				$BranchArr[$i]['value']=$branchValue['fname'].'('.$branchValue['profileId'].')';
				$i++;

			}

		}	

			

		$branch_Id=new Zend_Form_Element_Select('branch_Id');

		$branch_Id->addMultiOptions($BranchArr)		
		
		->setRequired(true)

		->addValidator('NotEmpty',true,array('messages' =>'Branch is required.'))

		->addDecorator('Errors', array('class'=>'errormsg'))

		->setAttrib("onchange","getBranchAgent(this.value)")

		->setValue(@$branch_Id_Value);
		$this->addElements(array($branch_Id));		
		}
		
		$AgentArr=array();
		$AgentArr[0]['key']="";
		$AgentArr[0]['value']="--Agent--";
		/*$agentData=$db->runQuery("select rbi_user.userid,concat(rbi_user.fname,' ',rbi_user.lname) as AgentName,
		(select rbi_user.fname as branchName from rbi_user where rbi_user.userid=rbi_ag.branchId) as branchName
		from rbi_user 
		join rbi_agent as rbi_ag on(rbi_user.userid=rbi_ag.userId)
		where usrRole='AG' order by rbi_user.fname");*/
		$agwhere = '';
		if($mySession->user['branchonly']['isbranch'])
		 {
			
			$agwhere .= " and rbi_ag.branchId = '".$mySession->user['branchonly']['branchid']."' ";
		 } elseif($customerId!="")
		{
			$agwhere .= " and rbi_ag.branchId = '".@$branch_Id_Value."' ";
		}
		$agentData=$db->runQuery("select rbi_user.userid,concat(rbi_user.fname,' ',rbi_user.lname) as AgentName,rbi_ag.profileId as AgentProfileId
		from rbi_user 
		join rbi_agent as rbi_ag on(rbi_user.userid=rbi_ag.userId)
		where usrRole='AG' ".$agwhere." order by rbi_user.fname ");
		if($agentData!="" and count($agentData)>0)
		{
			$i=1;
			foreach($agentData as $key=>$agentValue)
			{
				$AgentArr[$i]['key']=$agentValue['userid'];
				$AgentArr[$i]['value']=$agentValue['AgentName']." (".$agentValue['AgentProfileId'].")";
				$i++;
			}
		}
		
		$agent_Id=new Zend_Form_Element_Select('agent_Id');
		$agent_Id->addMultiOptions($AgentArr)		
		->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Agent is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$agent_Id_Value);
		/////->setAttrib("onchange","getNoagent(this.value)")
		
		
		$first_name= new Zend_Form_Element_Text('first_name');
		$first_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'First name is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$first_name_Value);
		
		$first_name1 = new Zend_Form_Element_Text('first_name1');	
		$first_name1->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Father Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($first_name1));
		
		$fathername1 = new Zend_Form_Element_Text('fathername1');	
		$fathername1->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Father Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($fathername1));
		
		$mobile_number1 = new Zend_Form_Element_Text('mobile_number1');	
		$mobile_number1->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Mobile Number is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($mobile_number1));
		
		$address1 = new Zend_Form_Element_Text('address1');	
		$address1->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Mobile Number is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("class","addressfield");
		$this->addElements(array($address1));
		
		$husbandname1 = new Zend_Form_Element_Text('husbandname1');	
		$husbandname1->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Mobile Number is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($husbandname1));
		
		$phone_number1 = new Zend_Form_Element_Text('phone_number1');	
		$phone_number1->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Phone Number is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($phone_number1));
		
		$date_of_firm_reg = new Zend_Form_Element_Text('date_of_firm_reg');	
		$date_of_firm_reg->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Mobile Number is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("style","width:172px;");
		$this->addElements(array($date_of_firm_reg));
		
		$nomini_dob = new Zend_Form_Element_Text('nomini_dob');	
		$nomini_dob->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Mobile Number is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("readonly","true","width:172px;");
		$this->addElements(array($nomini_dob));
		
		$guardian_name = new Zend_Form_Element_Text('guardian_name');	
		$guardian_name->setRequired(false)
				->addValidator('NotEmpty', false, array('messages' => array('isEmpty' => 'Mobile Number is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($guardian_name));
		
				
		$fathername= new Zend_Form_Element_Text('fathername');
		$fathername->setValue(@$fathername_Value);
		
		$husbandname= new Zend_Form_Element_Text('husbandname');
		$husbandname->setValue(@$husbandname_Value);
		
		if($customerId=="")
		{
			$date_of_reg_val = date('d-m-Y');
			
			$date_of_reg= new Zend_Form_Element_Text('date_of_reg');
			$date_of_reg->setAttrib("style","width:172px;")
			->setAttrib("readonly","true")
			->setValue(@$date_of_reg_val);
			$this->addElements(array($date_of_reg));
		}
		
		
		
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
		
		$pan_card_number= new Zend_Form_Element_Text('pan_card_number');
		$pan_card_number->setValue(@$pan_card_number_Value);
		
		
		
		$address= new Zend_Form_Element_Text('address');
		$address->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Address is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setAttrib("class","addressfield")
		->setValue(@$address_Value);
		
		$date_of_birth= new Zend_Form_Element_Text('date_of_birth');
		$date_of_birth->setAttrib("style","width:172px;")
		->setAttrib("readonly","true","width:172px;")
		//->setAttrib("style","width:172px;");
		->setValue(@$date_of_birth_Value);
		
		
		
		$guardiandt= new Zend_Form_Element_Text('guardiandt');
		$guardiandt->setValue(@$guardiandt_Value);
		
		
		$nomini_name= new Zend_Form_Element_Text('nomini_name');
		$nomini_name->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Nomini name is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$nomini_name_Value);
		
		$nomini_age= new Zend_Form_Element_Text('nomini_age');
		$nomini_age->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Nomini age is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setAttrib("onkeypress","return checknumber(event)")
		->setValue(@$nomini_age_Value);
		
		$nomini_relation= new Zend_Form_Element_Text('nomini_relation');
		$nomini_relation->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Nomini relation is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$nomini_relation_Value);
		
		$proffession= new Zend_Form_Element_Text('proffession');
		$proffession->setValue(@$proffession_Value);
		
		$NominiAddress= new Zend_Form_Element_Text('NominiAddress');
		$NominiAddress->setValue(@$NominiAddress_Value);
		
		$passbookno= new Zend_Form_Element_Text('passbookno');
		$passbookno->setValue(@$passbookno_Value);
		$passbookno->setAttrib("onkeypress","return checknumber(event)");
		$this->addElements(array($passbookno));
		
		/*$bondno= new Zend_Form_Element_Text('bondno');
		$bondno->setValue(@$bondno_Value);
		$bondno->setAttrib("onkeypress","return checknumber(event)");
		$this->addElements(array($bondno));*/
		
		$custid= new Zend_Form_Element_Text('custid');	
		$this->addElements(array($custid));
			
		if($customerId=="")
		{
			/*$receiptno= new Zend_Form_Element_Text('receiptno');
			$receiptno->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Receipt no is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib("onkeypress","return checknumber(event)");
			$this->addElements(array($receiptno));*/
		}
		
		$username= new Zend_Form_Element_Text('username');
		$username->setValue(@$username_Value);
		
		$user_password= new Zend_Form_Element_Password('user_password');
		$user_password->setValue('');
		
		$user_confirm_password= new Zend_Form_Element_Password('user_confirm_password');
		$user_confirm_password->setValue('');
		
		
		$this->addElements(array($agent_Id,$first_name,$phone_number,$mobile_number,$pan_card_number,$address,$date_of_birth,$nomini_name,$nomini_age,$nomini_relation,$proffession,$username,$user_password,$user_confirm_password,$fathername,$husbandname,$guardiandt,$NominiAddress));
	}		
}

?>