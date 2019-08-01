<?php
class Form_Careerlevels extends Zend_Form
{
	public function __construct($career_level_id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($career_level_id!="")

			{
			//echo "SELECT * FROM tbl_job_educations WHERE career_level_id='".$career_level_id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_career_levels WHERE career_level_id='".$career_level_id."'");
				$career_level_title_Value=$formData[0]['career_level_title'];
			}
		
		
		$career_level_title = new Zend_Form_Element_Text('career_level_title');	
		$career_level_title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->setValue(@$career_level_title_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($career_level_title));
		
	}
		
	

}

?>