<?php
class Form_Nationalitie extends Zend_Form
{
	public function __construct($id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($id!="")

			{
			//echo "SELECT * FROM tbl_job_categories WHERE id='".$id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_nationalities WHERE id='".$id."'");
				
				$nation_title_Value=$formData[0]['nation_title'];
				
			}
		
		
		$nation_title = new Zend_Form_Element_Text('nation_title');	
		$nation_title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Nationalitie is empty.')))
				->setValue(@$nation_title_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($nation_title));
		
			
		}

}

?>