<?PHP
class Form_State extends Zend_Form
{
	public function init(){
		global $mySession;
		$this->setMethod('post');
		
		//-----Title
		$_Title = new Zend_Form_Element_Text('_Title');		
		if(isset($mySession->editdetail['title'])) { $_Title->setValue($mySession->editdetail['title']);	 }
		$_Title->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme Title.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
		

		//------type
		$typeList=$this->getTypeList();
		$j=1;
		$Type[0]['key']=0;
		$Type[0]['value']='Select Scheme Type';

		foreach($typeList as $v){
			$Type[$j]['key'] = $v['schemeTypeId'];
			$Type[$j]['value'] =$v['schemeType'];
			$j++;
		}
				
		$_Type = new Zend_Form_Element_Select('_Type');
		$_Type->removeDecorator('label');
		$_Type->removeDecorator('HtmlTag')
        ->addMultiOptions($Type);
		if(isset($mySession->editdetail['schema_type'])) { $_Type->setValue($mySession->editdetail['schema_type']);	 }		
		
		
		//--- time priod type
			$TPType[0]['key']=0;
			$TPType[0]['value']='Day';
			$TPType[1]['key']=1;
			$TPType[1]['value']='Month';
			
		$_TPType = new Zend_Form_Element_Select('_TPType');
		$_TPType->removeDecorator('label');
		$_TPType->removeDecorator('HtmlTag')
        ->addMultiOptions($TPType);
		if(isset($mySession->editdetail['schema_type'])) { $_TPType->setValue($mySession->editdetail['schema_type']);	 }		
		
		
		//--- time priod
		$_TimePriod = new Zend_Form_Element_Text('_TimePriod');		
		if(isset($mySession->editdetail['title'])) { $_TimePriod->setValue($mySession->editdetail['title']);	 }
		$_TimePriod->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme Time Priod.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
			
		//--- No of installment
		$_NoOfInst = new Zend_Form_Element_Text('_NoOfInst');		
		if(isset($mySession->editdetail['title'])) { $_NoOfInst->setValue($mySession->editdetail['title']);	 }
		$_NoOfInst->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme Time Priod.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
			
		//--- agent commition
		$_AgentCommition = new Zend_Form_Element_Text('_AgentCommition');		
		if(isset($mySession->editdetail['title'])) { $_AgentCommition->setValue($mySession->editdetail['title']);	 }
		$_AgentCommition->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme Time Priod.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
			
		//--- Return amount
		$_ReturnAmount = new Zend_Form_Element_Text('_ReturnAmount');		
		if(isset($mySession->editdetail['title'])) { $_ReturnAmount->setValue($mySession->editdetail['title']);	 }
		$_ReturnAmount->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme Time Priod.'))
			->addDecorator('Errors', array('class'=>'errormsg'));
			
		//--- Sms Status
				
		///----Submit
		$submit = new Zend_Form_Element_Submit('submit','Submit',array('disableLoadDefaultDecorators' =>true));
		$submit->class='buttonClass';
		$this->addElements(array($_Type,$_Title,$_TPType,$_TimePriod,$_NoOfInst,$_AgentCommition,$_ReturnAmount,$submit));
	}
	
	function getTypeList(){
		$db = new Db();
		$record = $db->runQuery("select * from rbi_scheme_type where schemeTypeStatus='1'");
		
		if($record){
			return $record;
		} 
		else {
			return false;
		}
	}
}

?>