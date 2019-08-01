<?PHP
class Form_Changeup extends Zend_Form
{
	public function init(){
	
	}
	
	public function frm_p(){
		$this->setMethod('post');
		global $mySession;
		
		
		$_oldpass=new Zend_Form_Element_Password('_oldpass');
		$_oldpass->setRequired(true)
			->addValidator('NotEmpty',true,array( 'messages' =>'Please enter the Old Passowrd.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
		
		$validatorcps = new Zend_Validate_Identical(@$_POST['_pass']);
		$validatorcps->setMessage('The passwords do not match');
		
		$_pass=new Zend_Form_Element_Password('_pass');
		$_pass->setRequired(true)
			->addValidator('NotEmpty',true,array( 'messages' =>'Please enter the password.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
		
		$validatorcps = new Zend_Validate_Identical(@$_POST['_pass']);
		$validatorcps->setMessage('The passwords do not match');
			
		$_cpass=new Zend_Form_Element_Password('_cpass');
		$_cpass->setRequired(true)
			->addValidator('NotEmpty',true,array( 'messages' =>'Please enter the confirm password.'))
			->addValidator($validatorcps)
			->addDecorator('Errors', array('class'=>'errormsg'));	
		
		$submit = new Zend_Form_Element_Submit('submit','',array('disableLoadDefaultDecorators' =>true));
		$submit->class='loginbuttonClass';
		$this->addElements(array($_oldpass,$_pass,$_cpass,$submit));
	}
	
}

?>