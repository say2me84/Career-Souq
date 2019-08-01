<?php
class DashboardController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }
	public function indexAction(){
      
       global $mySession;
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		if($mySession->user['userRole']=='Job Seeker') { 
			
		$db=new Db();
		
		$qry= "SELECT * FROM `tbl_users` where user_id='".$mySession->user['userId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData;
		
					
		} else {
//============================================ Adding Employee Data ======================================//
			$db=new Db();
			$qry= "SELECT * FROM `tbl_users` where user_id='".$mySession->user['userId']."'";
			$GetData = $db->runQuery($qry);
					//prd($GetData); exit;
			$this->view->UserData = $GetData;
		
//============================================ Employee ======================================//
		}
    }	
	//Editing Records...
	public function neweditAction()
	{	
		global $mySession;
		$db=new Db();
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		$arr=$this->getRequest()->getParams();
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		if($arr['user_id']) {
			$qry = "select * from `tbl_users` where user_id='".$mySession->user['userId']."'";
				//prd($qry);
			$this->view->user_id = $arr['user_id'];
			$user_id = $db->runQuery($qry);
			$this->view->user_id_Data = $user_id[0];
		
		}
	}
	
	public function editAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->user_id = $arr['user_id'];
		$this->view->mode=2;
		
		/*if(@$arr['user_id']) {
			if(isset($arr['mode']) && $arr['mode']=='update') {
			
				$this->view->mode=1;
				$modelobj = new Model_Mainmodel();
				
				$Data='';
				$Data['user_fname']=$arr['user_fname'];
				$Data['user_lname']=$arr['user_lname'];
				
				
				$condition="user_id='".$arr['user_id']."'";
				$modelobj->updateThis('subjects',$Data,$condition);		
			}
			
			} else {
				$qry="select * from `subjects` where user_id='".$arr['user_id']."'";
				$sdetail = $db->runQuery("$qry");
				$this->view->sdetail=$sdetail[0];
			}*/
			
					
		}
	
	
	
	
	
	
	
	
	
	
	
}
?>
