<?PHP
class Form_Resetpass extends Zend_Form
{
	public function init(){
		
		global $mySessionFront;
		
		$user_password=new Zend_Form_Element_Password('user_password');	
		$user_password->class="logininput";
		$user_password->setRequired(true)
			->setAttrib("style","width:300px;")
			->addValidator('NotEmpty',true,array('messages' =>'Please Enter Password.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$user_password->class="inputbox";
		$this->addElements(array($user_password));
		
		$confirm_password=new Zend_Form_Element_Password('confirm_password');	
		$confirm_password->class="logininput";
		$confirm_password->setRequired(true)
			->setAttrib("style","width:300px;")
			->addValidator('NotEmpty',true,array('messages' =>'Please Enter Confirm Password.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$confirm_password->class="inputbox";
		$this->addElements(array($confirm_password));
	}
	
}

?>