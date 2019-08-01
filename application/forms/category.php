<?php
class Form_Category extends Zend_Form
{
	public function __construct($id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($id!="")

			{
			//echo "SELECT * FROM tbl_job_categories WHERE id='".$id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_job_categories WHERE id='".$id."'");
				
				$category_title_Value=$formData[0]['category_title'];
				$show_on_home_page_Value=$formData[0]['show_on_home_page'];
				$category_banner_Value=$formData[0]['category_banner'];
			}
		
		
		$category_title = new Zend_Form_Element_Text('category_title');	
		$category_title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->setValue(@$category_title_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($category_title));
		
		
		$show_on_home_page_opt[0]['key']='1';
		$show_on_home_page_opt[0]['value']='Yes';	
		
		$show_on_home_page_opt[1]['key']='0';
		$show_on_home_page_opt[1]['value']='No';	
		
		$show_on_home_page= new Zend_Form_Element_Select('show_on_home_page');
		$show_on_home_page->addMultiOptions($show_on_home_page_opt);
		$show_on_home_page->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student title is empty.')))
				->setAttrib("style","width:203px;")
				->setValue(@$show_on_home_page_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($show_on_home_page));	
		
		$category_banner = new Zend_Form_Element_file('category_banner');	
		$category_banner->setValue(@$category_banner_Value);
		$category_banner->setAttrib("style", "width:120px;");
		$this->addElements(array($category_banner));
	
			
		}

}

?>