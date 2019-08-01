<?php
class Form_Memberedit extends Zend_Form
{
	public function __construct($fid = NULL)
	{
		
		global $mySession;
		$db=new Db();
		$qry="SELECT * FROM rbi_member WHERE mid='".$fid."'";
		$result=$db->runQuery($qry);
		
		/*prd($fid);
		exit;*/
		$nameValue='';$fathernameValue='';$addressValue='';$occupationValue='';$nomini_nameValue=''; $relationValue='';$ageValue='';$withness_fnameValue='';$withness_addValue='';
		
		if($result[0]){
		//$stud_nameValue=$result[0]['stud_name'];
		$nameValue=$result[0]['name'];
		$fathernameValue=$result[0]['fathername'];
		$addressValue=$result[0]['address'];
		$occupationValue=$result[0]['occupation'];
		$nomini_nameValue=$result[0]['nomini_name'];
		$relationValue=$result[0]['relation'];
		$ageValue=$result[0]['age'];
		$withness_nameValue=$result[0]['withness_name'];
		$withness_fnameValue=$result[0]['withness_fname'];
		$withness_addValue=$result[0]['withness_add'];
		}
	
		
		$name = new Zend_Form_Element_Text('name');	
		$name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($nameValue);
		$this->addElements(array($name));
		
		$fathername = new Zend_Form_Element_Text('fathername');	
		$fathername->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Father Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($fathernameValue);
		$this->addElements(array($fathername));
		
		$address = new Zend_Form_Element_Text('address');	
		$address->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Address is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($addressValue);
		$this->addElements(array($address));
		
		$occupation = new Zend_Form_Element_Text('occupation');	
		$occupation->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Occupation is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($occupationValue);
		$this->addElements(array($occupation));
		
		$nomini_name = new Zend_Form_Element_Text('nomini_name');	
		$nomini_name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Nomini Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($nomini_nameValue);
		$this->addElements(array($nomini_name));
		
		$relation = new Zend_Form_Element_Text('relation');	
		$relation->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Relation is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($relationValue);
		$this->addElements(array($relation));
		
		$age = new Zend_Form_Element_Text('age');	
		$age->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Age is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($ageValue);
		$this->addElements(array($age));
		
		$withness_name = new Zend_Form_Element_Text('withness_name');	
		$withness_name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Withness Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($withness_nameValue);
		$this->addElements(array($withness_name));
		
		$withness_fname = new Zend_Form_Element_Text('withness_fname');	
		$withness_fname->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'withness Father Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($withness_fnameValue);
		$this->addElements(array($withness_fname));
		
		$withness_add = new Zend_Form_Element_Text('withness_add');	
		$withness_add->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Withness Address is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($withness_addValue);
		$this->addElements(array($withness_add));
	}

}

?>