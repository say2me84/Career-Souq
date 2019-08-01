<?php
__autoloadDB('Db');
class CmspageController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		global $mySessionFront;
			
    }
	
	public function indexAction()
	{
		global $mySessionFront;
		$db=new Db();
	
		
		
		$arr=$this->getRequest()->getParams('page_id');
		
		$Footer_Cat_Qry= "SELECT * FROM tbl_static_page_detail where page_id= '".$arr['page_id']."' and status='1'";
		$Get_Cat_Data = $db->runQuery($Footer_Cat_Qry);
			//prd($Get_Cat_Data);
		$this->view->Footer_Data = $Get_Cat_Data[0];
	}
	

}
?>
