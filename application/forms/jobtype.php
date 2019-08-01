<?php
class Form_Jobtype extends Zend_Form
{
	public function __construct($id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($id!="")

			{
			//echo "SELECT * FROM tbl_job_educations WHERE id='".$id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_job_types WHERE id='".$id."'");
				$job_type_title_Value=$formData[0]['job_type_title'];
			}
		
		
		$job_type_title = new Zend_Form_Element_Text('job_type_title');	
		$job_type_title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->setValue(@$job_type_title_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($job_type_title));
		
	}
		
	

}

?>