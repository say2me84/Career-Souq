<?php
class Form_Contactus extends Zend_Form
{

	public function init()
	{
	
	$name= new Zend_Form_Element_Text('name');
	$name->class='contact_input';
	$name->setValue('Enter the Name')
			->setAttrib('onfocus','checkdefaultvalue(this,\'Enter the Name\')')
			->setAttrib('onblur','allotdefaultvalue(this,\'Enter the Name\')')
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Name is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'));;
												
	$address= new Zend_Form_Element_Text('address');
	$address->class='contact_input';
	$address->setValue('E-mail Address')
			->setAttrib('onfocus','checkdefaultvalue(this,\'E-mail Address\')')
			->setAttrib('onblur','allotdefaultvalue(this,\'E-mail Address\')');
	
	$subject= new Zend_Form_Element_Text('subject');
	$subject->class='contact_input';
	$subject->setValue('Message Subject')
			->setAttrib('onfocus','checkdefaultvalue(this,\'Message Subject\')')
			->setAttrib('onblur','allotdefaultvalue(this,\'Message Subject\')');
	
	$message = new Zend_Form_Element_Textarea('message');
	$message->class='contact_txtarea';
	$message->setValue('Enter Your Message');
	$message->setAttrib('ROWS', '3')
			->setAttrib('onfocus','checkdefaultvalue(this,\'Enter Your Message\')')
			->setAttrib('onblur','allotdefaultvalue(this,\'Enter Your Message\')');
	
	$submit = new Zend_Form_Element_Submit('submit','',array('disableLoadDefaultDecorators' =>true));
	$submit->class='contact_submit';
	
	$this->addElements(array($name,$address,$subject,$message,$submit));
	}
}
?>