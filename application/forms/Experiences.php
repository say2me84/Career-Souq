<?php
class Form_Experiences extends Zend_Form
{
	public function __construct($id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($id!="")

			{
			//echo "SELECT * FROM tbl_job_educations WHERE id='".$id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_job_experiences WHERE id='".$id."'");
				$experience_title_Value=$formData[0]['experience_title'];
				//prd($experience_title_Value);
			}
		
		
		$experience_title = new Zend_Form_Element_Text('experience_title');	
		$experience_title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Experiences is empty.')))
				->setValue(@$experience_title_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($experience_title));
		
	}
		
	

}

?>