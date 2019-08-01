<?php
class Form_Zone extends Zend_Form
{
	public function __construct($id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($id!="")

			{
			//echo "SELECT * FROM tbl_job_educations WHERE id='".$id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_countries WHERE id='".$id."'");
				$name_Value=$formData[0]['name'];
			}
		
		
		$name = new Zend_Form_Element_Text('name');	
		$name->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Countries is empty.')))
				->setValue(@$name_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($name));
		
	}
		

}

?>