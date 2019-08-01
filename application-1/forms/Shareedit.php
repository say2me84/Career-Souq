<?php
class Form_Shareedit extends Zend_Form
{
	public function __construct($fid = NULL)
	{
		
		global $mySession;
		$db=new Db();
		$qry="SELECT *, DATE_FORMAT(`share_date`,'%d-%m-%Y') as mydate, DATE_FORMAT(`frm_dt`,'%d-%m-%Y') as from_dt,  DATE_FORMAT(`to_dt`,'%d-%m-%Y') as my_to_dt FROM rbi_share WHERE share_id='".$fid."'";
		$result=$db->runQuery($qry);
		
		/*prd($fid);
		exit;*/
		$nameValue='';
		$genderValue='';
		$father_nameValue='';
		$addressValue='';
		$share_dateValue=''; 
		$No_of_ShareValue='';
		$fromValue='';
		$toValue='';
		$amtValue='';
		$regValue='';
		
		if($result[0]){
		//$stud_nameValue=$result[0]['stud_name'];
		$nameValue=$result[0]['name'];
		$genderValue=$result[0]['gender'];
		$father_nameValue=$result[0]['father_name'];
		$addressValue=$result[0]['address'];
		$share_dateValue=$result[0]['mydate'];
		$No_of_ShareValue=$result[0]['no_share'];
		$fromValue=$result[0]['from_dt'];
		$toValue=$result[0]['my_to_dt'];
		$amtValue=$result[0]['amt'];
		$regValue=$result[0]['reg_fol_no'];
		
		}
		$name = new Zend_Form_Element_Text('name');	
		$name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($nameValue);
		$this->addElements(array($name));
		
		$gender_opt[0]['key']='Male';
		$gender_opt[0]['value']='Male';	
		
		$gender_opt[1]['key']='Female';
		$gender_opt[1]['value']='Female';	
		
		$gender= new Zend_Form_Element_Select('gender');
		$gender->addMultiOptions($gender_opt);
		$gender->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student title is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$gender->setValue(@$genderValue['gender']);
		$this->addElements(array($gender));	
		
		
		$father_name = new Zend_Form_Element_Text('father_name');	
		$father_name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Occupation is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($father_nameValue);
		$this->addElements(array($father_name));
		
		$address = new Zend_Form_Element_Text('address');	
		$address->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Address is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($addressValue);
		$this->addElements(array($address));
		
		$share_date = new Zend_Form_Element_Text('share_date');	
		$share_date->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Nomini Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("readonly","true")
		->setValue($share_dateValue);
		$this->addElements(array($share_date));
		
		$no_share = new Zend_Form_Element_Text('no_share');	
		$no_share->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Relation is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($No_of_ShareValue);
		$this->addElements(array($no_share));
		
		$frm_dt = new Zend_Form_Element_Text('frm_dt');	
		$frm_dt->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Age is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("readonly","true")
		->setValue($fromValue);
		$this->addElements(array($frm_dt));
		
		$to_dt = new Zend_Form_Element_Text('to_dt');	
		$to_dt->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Withness Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
				->setAttrib("readonly","true")
		->setValue($toValue);
		$this->addElements(array($to_dt));
		
		$amt = new Zend_Form_Element_Text('amt');	
		$amt->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'withness Father Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($amtValue);
		$this->addElements(array($amt));
		
		$reg_fol_no = new Zend_Form_Element_Text('reg_fol_no');	
		$reg_fol_no->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Withness Address is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($regValue);
		$this->addElements(array($reg_fol_no));
	}

}

?>