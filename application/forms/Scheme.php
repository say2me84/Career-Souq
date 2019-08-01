<?PHP

class Form_Scheme extends Zend_Form

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

		

		//-----Land Size

		$_landsize = new Zend_Form_Element_Text('_landsize');		

		if(isset($mySession->editdetail['landsize'])) { $_landsize->setValue($mySession->editdetail['landsize']);	 }

		$_landsize->setRequired(true)

			->addValidator('NotEmpty',true,array('messages' =>'Enter Land Size.'))

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

		if(isset($mySession->editdetail['scheme_type'])) { $_Type->setValue($mySession->editdetail['scheme_type']);	 }		

		$_Type->setRequired(true)

			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme Type.'))

			->addDecorator('Errors', array('class'=>'errormsg'));

		

		//--- time priod type

			$TPType[0]['key']=0;

			$TPType[0]['value']='Day';

			$TPType[1]['key']=1;

			$TPType[1]['value']='Month';

			$TPType[2]['key']=2;

			$TPType[2]['value']='Year';

			$TPType[3]['key']=3;

			$TPType[3]['value']='Single';

			

		$_TPType = new Zend_Form_Element_Select('_TPType');

		$_TPType->removeDecorator('label');

		$_TPType->removeDecorator('HtmlTag')

        ->addMultiOptions($TPType);

		if(isset($mySession->editdetail['timePriodType'])) { $_TPType->setValue($mySession->editdetail['timePriodType']);	 }		

		

		

		//--- time priod

		$_TimePriod = new Zend_Form_Element_Text('_TimePriod');		

		if(isset($mySession->editdetail['timePeriod'])) { $_TimePriod->setValue($mySession->editdetail['timePeriod']);	 }

		$_TimePriod->setRequired(true)

			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme Time Priod.'))

			->addDecorator('Errors', array('class'=>'errormsg'));

			

		//--- Installment

		$_Installment = new Zend_Form_Element_Text('_Installment');		

		if(isset($mySession->editdetail['installment'])) { $_Installment->setValue($mySession->editdetail['installment']);	 }

		$_Installment->setRequired(true)

			->addValidator('NotEmpty',true,array('messages' =>'Enter Installment.'))

			->addDecorator('Errors', array('class'=>'errormsg'));

			

		//--- No of installment

		$_NoOfInst = new Zend_Form_Element_Text('_NoOfInst');		

		if(isset($mySession->editdetail['noOfInstallment'])) { $_NoOfInst->setValue($mySession->editdetail['noOfInstallment']);	 }

		$_NoOfInst->setRequired(true)

			->addValidator('NotEmpty',true,array('messages' =>'Enter No. of Installment.'))

			->addDecorator('Errors', array('class'=>'errormsg'));

			

		//--- agent commition

		$_AgentCommition = new Zend_Form_Element_Text('_AgentCommition');		

		if(isset($mySession->editdetail['agent_commission'])) { $_AgentCommition->setValue($mySession->editdetail['agent_commission']);	 }
		
		$_AgentCommition->setRequired(true)
			->setAttrib("onkeypress","return checknumber(event)")
			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme NCB.'))
			
			->addDecorator('Errors', array('class'=>'errormsg'));

			

		//--- Return amount

		$_ReturnAmount = new Zend_Form_Element_Text('_ReturnAmount');		

		if(isset($mySession->editdetail['ReturnAmount'])) { $_ReturnAmount->setValue($mySession->editdetail['ReturnAmount']);	 }

		$_ReturnAmount->setRequired(true)

			->addValidator('NotEmpty',true,array('messages' =>'Enter Scheme Return Amount.'))

			->addDecorator('Errors', array('class'=>'errormsg'));

			

		//--- Sms Status
		
		//------Scheme for month
		$Mnth[0]['key']='12';
		$Mnth[0]['value']='12 Month';
		$Mnth[1]['key']=18;
		$Mnth[1]['value']='18 Month';
		$Mnth[2]['key']=24;
		$Mnth[2]['value']='24 Month';
		$Mnth[3]['key']=36;
		$Mnth[3]['value']='36 Month';
		$Mnth[4]['key']=48;
		$Mnth[4]['value']='48 Month';
		$Mnth[5]['key']=60;
		$Mnth[5]['value']='60 Month';
		$Mnth[6]['key']=66;
		$Mnth[6]['value']='66 Month';
		$Mnth[7]['key']=72;
		$Mnth[7]['value']='72 Month';
		$Mnth[8]['key']=75;
		$Mnth[8]['value']='75 Month';
		$Mnth[9]['key']=78;
		$Mnth[9]['value']='78 Month';
		$Mnth[10]['key']=84;
		$Mnth[10]['value']='84 Month';
		$Mnth[11]['key']=90;
		$Mnth[11]['value']='90 Month';
		$Mnth[12]['key']=96;
		$Mnth[12]['value']='96 Month';
		$Mnth[13]['key']=108;
		$Mnth[13]['value']='108 Month';
		$Mnth[14]['key']=120;
		$Mnth[14]['value']='120 Month';
		
		$_mnth = new Zend_Form_Element_Select('_mnth');

		$_mnth->removeDecorator('label');

		$_mnth->removeDecorator('HtmlTag')

        ->addMultiOptions($Mnth);

		if(isset($mySession->editdetail['mnth'])) { $_mnth->setValue($mySession->editdetail['mnth']);	 }		

		$_Type->setRequired(true)

			->addValidator('NotEmpty',true,array('messages' =>'Please Select Scheme For.'))

			->addDecorator('Errors', array('class'=>'errormsg'));
				

		///----Submit

		$submit = new Zend_Form_Element_Submit('submit','Submit',array('disableLoadDefaultDecorators' =>true));

		$submit->class='buttonClass';

		$this->addElements(array($_Type,$_Title,$_TPType,$_TimePriod,$_Installment,$_NoOfInst,$_AgentCommition,$_ReturnAmount,$_landsize,$submit,$_mnth));

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