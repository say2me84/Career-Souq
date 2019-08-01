<?php
class Form_Staticpagecategory extends Zend_Form
{
	public function __construct($static_page_id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($static_page_id!="")

			{
			//echo "SELECT * FROM tbl_job_educations WHERE career_level_id='".$career_level_id."'"; exit;
			
				$formData=$db->runQuery("SELECT * FROM tbl_static_page WHERE static_page_id='".$static_page_id."'");
				$Page_Category_Value=$formData[0]['Page_Category'];
			}
		
		
		$Page_Category = new Zend_Form_Element_Text('Page_Category');	
		$Page_Category->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Page category is empty.')))
				->setValue(@$Page_Category_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($Page_Category));
		
	}
		
	

}

?>