<?php
class Form_Testimonial extends Zend_Form
{
	public function __construct($testimonial_id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($testimonial_id!="")

			{
			//echo "SELECT * FROM tbl_job_educations WHERE career_level_id='".$career_level_id."'"; exit;
			
				$formData=$db->runQuery("SELECT * FROM tbl_admin_messages WHERE testimonial_id='".$testimonial_id."'");
				$testimonial_id_Value=$formData[0]['testimonial_id'];
				$name_Value=$formData[0]['name'];
				$company_Value=$formData[0]['company'];
				$designation_Value=$formData[0]['designation'];
				$email_Value=$formData[0]['email'];
				$phone_Value=$formData[0]['phone'];
				$subject_Value=$formData[0]['subject'];
				$message_Value=$formData[0]['message'];
				$avator_Value=$formData[0]['avator'];
			}
		
		
		$name = new Zend_Form_Element_Text('name');	
		$name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->setValue(@$name_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($name));
		
		$company = new Zend_Form_Element_Text('company');	
		$company->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Company is empty.')))
				->setValue(@$company_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($company));
		
		$designation = new Zend_Form_Element_Text('designation');	
		$designation->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Designation is empty.')))
				->setValue(@$designation_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($designation));
		
		$email = new Zend_Form_Element_Text('email');	
		$email->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Email is empty.')))
				->setValue(@$email_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($email));
		
		$phone = new Zend_Form_Element_Text('phone');	
		$phone->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Phone is empty.')))
				->setValue(@$phone_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($phone));
		
		$subject = new Zend_Form_Element_Text('subject');	
		$subject->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Subject is empty.')))
				->setValue(@$subject_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($subject));
		
		
		$message= new Zend_Form_Element_Textarea('message');	
		$message->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Message is empty.')))
				->setAttrib("style","width:202px; height:50px;")
				->setValue(@$message_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($message));
		
		
		$avator = new Zend_Form_Element_File('avator');	
		$avator->setAttrib("style", "width:400px;");
		$avator->setValue(@$avator_Value);
		$this->addElements(array($avator));
		//avator
		
//======================================================================================================
		
		
	}
		
	

}

?>