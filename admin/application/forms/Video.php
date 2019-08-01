<?php
class Form_Video extends Zend_Form
{
	
	public function __construct($CatDetailSno="")
	{
		$this->init($CatDetailSno);
	}
	public function init($CatDetailSno)
	{
			global $mySession;
			$db=new Db();
			
			if($CatDetailSno!="")
			{
				//echo "SELECT * FROM jok_subcatdetail WHERE CatDetailSno='".$CatDetailSno."'"; exit;
			
				$formData=$db->runQuery("SELECT * FROM jok_subcatdetail WHERE CatDetailSno='".$CatDetailSno."'");
				//prd($formData);
				$CategorySno_Value=$formData[0]['CategorySno'];
				$SubCatId_Value=$formData[0]['SubCatId'];
				$VideoName_Value=$formData[0]['VideoName'];
				$VideoImage_Value=$formData[0]['VideoImage'];
				$CatDetailPath_Value=$formData[0]['CatDetailPath'];
			}
			
		$CategoryArr=array();
		$CategoryArr[0]['key']="";
		$CategoryArr[0]['value']="--Category Name--";
		$CategoryData=$db->runQuery("select * from jok_category  order by CategorySno");
		//prd($CategoryData);
		
		if($CategoryData!="" and count($CategoryData)>0)
		{
			$i=1;
			foreach($CategoryData as $key=>$CategoryValue)
			{
				$CategoryArr[$i]['key']=$CategoryValue['CategorySno'];
				$CategoryArr[$i]['value']=$CategoryValue['CategoryName'];
				$i++;
			}
		}
			
		$CategorySno=new Zend_Form_Element_Select('CategorySno');
		$CategorySno->addMultiOptions($CategoryArr)		
		->setRequired(true)
		->addValidator('NotEmpty',true,array('messages' =>'Category Name is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setAttrib("onchange","getsubcat(this.value)")
		->setValue(@$CategorySno_Value);
		$this->addElements(array($CategorySno));
		
		/*---------------------------------------- Subcategory ----------------------------------------------------*/
		
		$SubCatArr=array();
		$SubCatArr[0]['key']="";
		$SubCatArr[0]['value']="--Subcategory--";
		$SubCatArrData=$db->runQuery("select * from jok_subcategory  order by SubCatId");
		//prd($CategoryData);
		
		if($SubCatArrData!="" and count($SubCatArrData)>0)
		{
			$i=1;
			foreach($SubCatArrData as $key=>$SubCatArrValue)
			{
				$SubCatArr[$i]['key']=$SubCatArrValue['SubCatId'];
				$SubCatArr[$i]['value']=$SubCatArrValue['SubCatName'];
				$i++;
			}
		}
		
		$SubCatId=new Zend_Form_Element_Select('SubCatId');
		$SubCatId->addMultiOptions($SubCatArr)		
		->setRequired(false)
		->addValidator('NotEmpty',true,array('messages' =>'SubCategory is required.'))
		->addDecorator('Errors', array('class'=>'errormsg'))
		->setValue(@$SubCatId_Value);
		$this->addElements(array($SubCatId));
		
		
		$VideoName = new Zend_Form_Element_Text('VideoName');	
		$VideoName->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Video Name is empty.')))
				->setValue(@$VideoName_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($VideoName));
		
		$VideoImage = new Zend_Form_Element_file('VideoImage');	
		//$VideoImage->setAttrib("style", "width:150px;");
		$VideoImage->setValue(@$CatDetailPath_Value);
		$this->addElements(array($VideoImage));
		
			
		$CatDetailPath = new Zend_Form_Element_file('CatDetailPath');	
		$CatDetailPath->setAttrib('style', 'width:250px;');
		$this->addElements(array($CatDetailPath));
			
	}
	
	
		
	

}

?>