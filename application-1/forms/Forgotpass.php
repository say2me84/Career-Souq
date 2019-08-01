<?PHP
class Form_Forgotpass extends Zend_Form
{
	public function init(){
		
		global $mySessionFront;
		
		$user_email=new Zend_Form_Element_Text('user_email');	
		$user_email->class="logininput";
		$user_email->setRequired(true)
			->setAttrib("style","width:300px;")
			->addValidator('NotEmpty',true,array('messages' =>'Please Enter Your Email Id.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$user_email->class="inputbox";
		$this->addElements(array($user_email));
	}
	
}

?>