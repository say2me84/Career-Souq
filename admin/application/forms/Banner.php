<?php
class Form_Banner extends Zend_Form
{
	public function __construct($id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($id!="")

			{
			//echo "SELECT * FROM tbl_job_categories WHERE id='".$id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_banners WHERE id='".$id."'");
				
				$banner_alt_Value=$formData[0]['banner_alt'];
				$banner_link_Value=$formData[0]['banner_link'];
				$banner_window_open_Value=$formData[0]['banner_window_open'];
				$banner_image_Value=$formData[0]['banner_image'];
				//prd($banner_image_Value); exit;
			}
		
		
		$banner_alt = new Zend_Form_Element_Textarea('banner_alt');	
		$banner_alt->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Caption is empty.')))
				->setAttrib("style","width:300px; height:30px;")
				->setValue(@$banner_alt_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($banner_alt));
		
		
		
		$banner_link = new Zend_Form_Element_Text('banner_link');	
		$banner_link->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->setValue(@$banner_link_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($banner_link));
		
		$banner_window_opt[0]['key']='_self';
		$banner_window_opt[0]['value']='Same Window';	
		
		$banner_window_opt[1]['key']='_blank';
		$banner_window_opt[1]['value']='New Window';	
		
		$banner_window_open= new Zend_Form_Element_Select('banner_window_open');
		$banner_window_open->addMultiOptions($banner_window_opt);
		$banner_window_open->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Student title is empty.')))
				->setAttrib("style","width:203px;")
				->setValue(@$banner_window_open_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($banner_window_open));	
		
		$banner_image = new Zend_Form_Element_File('banner_image');	
		$banner_image->setAttrib("style", "width:400px;");
		$banner_image->setValue(@$banner_image_Value);
		$this->addElements(array($banner_image));
	}

}

?>