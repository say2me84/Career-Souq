<?PHP
class Form_Receiptno extends Zend_Form
{
	public function __construct($branchId="")
	{
		$this->init($branchId);
	}
	public function init($branchId)
	{
		$db=new Db();
						
		
		$rfrom= new Zend_Form_Element_Text('rfrom');
		$rfrom->setValue(@$rfrom_Value)
		->setAttrib("onkeypress","return checknumber(event)");
		$rfrom->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Receipt from number is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		
		$rto= new Zend_Form_Element_Text('rto');
		$rto->setValue(@$rto_Value)
		->setAttrib("onkeypress","return checknumber(event)");
		
		$usercode= new Zend_Form_Element_Text('usercode');
		$usercode->setValue(@$usercode_Value);
		$usercode->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'User Code is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'));
		
		$this->addElements(array($rfrom,$rto,$usercode));
	}		
}

?>