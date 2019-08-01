<?PHP
class Form_Sendsms extends Zend_Form
{
	public function init(){
	
	} 
	
	public function sendsms() {
		global $mySession;
		$this->setMethod('post');
		
		//-----Title
		$_phnolist = new Zend_Form_Element_Textarea('_phnolist');			
		$_phnolist->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Please Enter Phone No.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib('COLS', '40')
			->setAttrib("onkeypress","return checknumbercomma(event)")
   			->setAttrib('ROWS', '4');
				
			
		$_smstext = new Zend_Form_Element_Textarea('_smstext');			
		$_smstext->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Please Enter Phone No.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setAttrib('COLS', '40')
   			->setAttrib('ROWS', '4');						
		///----Submit
		$submit = new Zend_Form_Element_Submit('submit','Send SMS',array('disableLoadDefaultDecorators' =>true));
		$submit->class='buttonClass';
		$this->addElements(array($_phnolist,$_smstext,$submit));
	}
	
	
}

?>