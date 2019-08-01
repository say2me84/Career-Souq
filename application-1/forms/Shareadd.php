<?php
class Form_Shareadd extends Zend_Form
{
	public function __construct($formData = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		$name = new Zend_Form_Element_Text('name');	
		$name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
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
		$gender->setValue(@$formData['gender']);
		$this->addElements(array($gender));	
		
		
		$father_name = new Zend_Form_Element_Text('father_name');	
		$father_name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Father Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		//$father_name->class'';
		$this->addElements(array($father_name));
		
		$address= new Zend_Form_Element_Text('address');	
		$address->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Address is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($address));
		
		$share_date= new Zend_Form_Element_Text('share_date');	
		$share_date->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Date is empty.')))
				->setAttrib("readonly","true")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($share_date));
		
		$no_share= new Zend_Form_Element_Text('no_share');	
		$no_share->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'No Of share is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($no_share));
		
		$frm_dt= new Zend_Form_Element_Text('frm_dt');	
		$frm_dt->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'From Date is empty.')))
				->setAttrib("readonly","true")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($frm_dt));
		
		$to_dt= new Zend_Form_Element_Text('to_dt');	
		$to_dt->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'To Date is empty.')))
				->setAttrib("readonly","true")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($to_dt));
		
		
		$amt= new Zend_Form_Element_Text('amt');	
		$amt->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Amount is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($amt));
		
		$reg_fol_no= new Zend_Form_Element_Text('reg_fol_no');	
		$reg_fol_no->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Reg. Folio No. is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($reg_fol_no));
		
	}

}

?>