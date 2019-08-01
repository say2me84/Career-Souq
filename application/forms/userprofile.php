<?php
class Form_Userprofile extends Zend_Form
{
	public function __construct($user_id = NULL)
	{
		
		global $mySessionFront;
		$db=new Db();
		
		if($user_id!="")

			{
			//echo "SELECT * FROM tbl_users WHERE $user_id='".$user_id."'"; exit;
				$formData=$db->runQuery("SELECT * FROM tbl_users WHERE user_id='".$user_id."'");
				//$user_fname_Value=$formData[0]['user_fname'];
			}
		
		
		$user_fname = new Zend_Form_Element_Text('user_fname');	
		$user_fname->setRequired(true)
				->addValidator('NotEmpty', true, array('messages' => array('isEmpty' => 'Name is empty.')))
				->setValue(@$user_fname_Value)
				->addDecorator('Errors', array('class'=>'errormsg'));
		$this->addElements(array($user_fname));
		
	}
		
	

}

?>