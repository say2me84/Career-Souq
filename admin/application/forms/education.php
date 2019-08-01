<?php
class Form_Education extends Zend_Form
{
	public function __construct($id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($id!="")

			{
			//echo "SELECT * FROM tbl_job_educations WHERE id='".$id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_job_educations WHERE id='".$id."'");
				$education_title_Value=$formData[0]['education_title'];
			}
		
		
		$education_title = new Zend_Form_Element_Text('education_title');	
		$education_title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->setValue(@$education_title_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($education_title));
		
	}
		
	

}

?>