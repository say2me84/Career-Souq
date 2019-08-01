<?php
class Form_Zoneedit extends Zend_Form
{
	public function __construct($fid = NULL)
	{
		
		global $mySession;
		$db=new Db();
		$qry="SELECT * FROM rbi_zone WHERE id='".$fid."'";
		$result=$db->runQuery($qry);
		
		/*prd($fid);
		exit;*/
		$zone_nameValue='';
		if($result[0]){
		//$stud_nameValue=$result[0]['stud_name'];
		$zone_nameValue=$result[0]['zone_name'];
		}
	
		
		$zone_name = new Zend_Form_Element_Text('zone_name');	
		$zone_name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue($zone_nameValue);
		$this->addElements(array($zone_name));
		
		
	}

}

?>