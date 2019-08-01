<?php
class Form_Subcategory extends Zend_Form
{
	public function __construct($sub_cat_id = NULL)
	{
		
		global $mySession;
		$db=new Db();
		
		if($sub_cat_id!="")

			{ 
				//echo $sub_cat_id; exit;
		/*echo "select tbl_job_sub_categories.*, tbl_job_sub_categories.sub_cat_id,tbl_job_categories.cat_id,tbl_job_categories.category_title 
from tbl_job_sub_categories LEFT JOIN tbl_job_categories on(tbl_job_sub_categories.category_id=tbl_job_categories.cat_id)
 WHERE tbl_job_sub_categories.category_id='".$sub_cat_id."'"; exit;*/	
				
				
$formData=$db->runQuery("select tbl_job_sub_categories.*, tbl_job_categories.category_title from tbl_job_sub_categories
		LEFT JOIN tbl_job_categories on(tbl_job_sub_categories.category_id=tbl_job_categories.cat_id) WHERE sub_cat_id='".$sub_cat_id."'");
				
				//prd($formData);
				$sub_category_title_Value=$formData[0]['sub_category_title'];
				//$category_title_Value=$formData[0]['category_title'];
				
				$category_title_Value=$formData[0]['sub_cat_id'];
				//prd($category_title_Value);
				
			}
		
		
		$sub_category_title = new Zend_Form_Element_Text('sub_category_title');	
		$sub_category_title->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Sub category title is empty.')))
				->setValue(@$sub_category_title_Value)
				->setAttrib("style","width:262px;")
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($sub_category_title));
		
//======================================================================================================
		$CategoryArr=array();
		$CategoryArr[0]['key']="";
		$CategoryArr[0]['value']="--Category--";
		$CategoryData=$db->runQuery("select * from tbl_job_categories order by category_title");
		//prd($CategoryData);
		if($CategoryData!="" and count($CategoryData)>0)
		{
			$i=1;
			foreach($CategoryData as $key=>$CategoryValue)
			{
				$CategoryArr[$i]['key']=$CategoryValue['cat_id'];
				$CategoryArr[$i]['value']=$CategoryValue['category_title'];
				$i++;
			}
		}	
			
		$category_title=new Zend_Form_Element_Select('category_title');
		$category_title->addMultiOptions($CategoryArr)
			->setRequired(true)
			->addValidator('NotEmpty',true,array('messages' =>'Category is required.'))
			->addDecorator('Errors', array('class'=>'errormsg'))
			->setValue(@$category_title_Value);
		$this->addElements(array($category_title));	
		
		
			
	}

}

?>