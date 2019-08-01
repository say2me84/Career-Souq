<?PHP
class Form_Login extends Zend_Form
{
	public function init(){
		//$this->setMethod('post');
		
		$_uname=new Zend_Form_Element_Text('_uname');	
		$_uname->class="logininput";
		$_uname->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Enter Your Username.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
		$_uname->class="inputbox";
		
		$_pass=new Zend_Form_Element_Password('_pass');
		$_pass->class='in-text1';
		$_pass->setRequired(true)
			->addValidator('NotEmpty',true,array( 'messages' =>'Enter your password.'))
			->addDecorator('Errors', array('class'=>'errormsg'));	
		$_pass->class="inputbox";
		
		$_job_seeker = new Zend_Form_Element_Radio('_job_seeker');	
		//$cust_pic->setAttrib("style", "width:150px;");
		$this->addElements(array($_job_seeker));
		
		$submit = new Zend_Form_Element_Submit('submit','Submit',array('disableLoadDefaultDecorators' =>true));
		$submit->class='buttonClass';
		$this->addElements(array($_uname,$_pass));
		
		
		
		//$job_seeker=new Zend_Form_Element_Radio('job_seeker');	
		
		
		
	}
}

?>