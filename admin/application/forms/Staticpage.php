<?php
class Form_Staticpage extends Zend_Form
{
	public function __construct($page_id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($page_id!="")

			{
			//echo "SELECT * FROM tbl_job_educations WHERE career_level_id='".$career_level_id."'"; exit;
			
				$formData=$db->runQuery("SELECT * FROM tbl_static_page_detail WHERE page_id='".$page_id."'");
				$page_cat_id_Value=$formData[0]['page_cat_id'];
				$title_Value=$formData[0]['title'];
				$content_Value=$formData[0]['content'];
				$is_front_Value=$formData[0]['is_front'];
				$status_Value=$formData[0]['status'];
			}
		
		
		$title = new Zend_Form_Element_Text('title');	
		$title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Page title is empty.')))
				->setValue(@$title_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($title));
		
		
//======================================================================================================
		$CategoryArr=array();
		$CategoryArr[0]['key']="";
		$CategoryArr[0]['value']="--Page Category--";
		$CategoryData=$db->runQuery("select * from tbl_static_page order by Page_Category");
		//prd($CategoryData);
		if($CategoryData!="" and count($CategoryData)>0)
		{
			$i=1;
			foreach($CategoryData as $key=>$CategoryValue)
			{
				$CategoryArr[$i]['key']=$CategoryValue['static_page_id'];
				$CategoryArr[$i]['value']=$CategoryValue['Page_Category'];
				$i++;
			}
		}	
			
		$Page_Category=new Zend_Form_Element_Select('Page_Category');
		$Page_Category->addMultiOptions($CategoryArr)
			->setRequired(false)
			->addValidator('NotEmpty',true,array('messages' =>'Page Category is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setValue(@$page_cat_id_Value);
		$this->addElements(array($Page_Category));	
		
		
		$content= new Zend_Form_Element_Textarea('content');	
		$content->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Content is empty.')))
				->setAttrib("style","width:202px; height:50px;")
				->setValue(@$content_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($content));
		
		
		$is_front_opt[0]['key']='0';
		$is_front_opt[0]['value']='No';	
		$is_front_opt[1]['key']='1';
		$is_front_opt[1]['value']='Yes';
		
		$is_front= new Zend_Form_Element_Select('is_front');
		$is_front->addMultiOptions($is_front_opt);
		$is_front->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Show on Front is empty.')))
				->setAttrib("style","width:203px;")
				->setValue(@$is_front_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($is_front));
		
		
		
		$status_opt[0]['key']='0';
		$status_opt[0]['value']='Desable';	
		$status_opt[1]['key']='1';
		$status_opt[1]['value']='Active';
		
		$status= new Zend_Form_Element_Select('status');
		$status->addMultiOptions($status_opt);
		$status->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Statas is empty.')))
				->setAttrib("style","width:203px;")
				->setValue(@$status_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($status));
		
	}
		
	

}

?>