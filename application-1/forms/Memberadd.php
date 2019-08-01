<?php
class Form_Memberadd extends Zend_Form
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
		
		
		$fathername = new Zend_Form_Element_Text('fathername');	
		$fathername->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Father Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($fathername));
		
		$address= new Zend_Form_Element_Text('address');	
		$address->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Address is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($address));
		
		$occupation= new Zend_Form_Element_Text('occupation');	
		$occupation->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Occupation is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($occupation));
		
		$nomini_name= new Zend_Form_Element_Text('nomini_name');	
		$nomini_name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Nomini Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($nomini_name));
		
		$relation= new Zend_Form_Element_Text('relation');	
		$relation->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Relation is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($relation));
		
		$age= new Zend_Form_Element_Text('age');	
		$age->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Age is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($age));
		
		$withness_name= new Zend_Form_Element_Text('withness_name');	
		$withness_name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Withness Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($withness_name));
		
		$withness_fname= new Zend_Form_Element_Text('withness_fname');	
		$withness_fname->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Withness Father Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($withness_fname));
		
		$withness_add= new Zend_Form_Element_Text('withness_add');	
		$withness_add->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Withness Address is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($withness_add));
		
	}

}

?>