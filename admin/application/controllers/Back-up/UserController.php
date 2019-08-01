<?php
class UserController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
	}
	public function indexAction(){
      
       global $mySessionFront;
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		
		if($mySessionFront->user['userRole']=='Job Seeker') { 
			
		$db=new Db();
		
		//$qry= "SELECT * FROM `tbl_users` ORDER BY CatDetailSno DESC LIMIT 0, 4";
		
		//$mySessionFront->user['user_fname']
		
		$qry= "SELECT * FROM `tbl_users` where user_id='".$mySessionFront->user['FrontUserId']."'";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->UserData = $GetData;
		
		
		
			/*	
			$gettodaydue = $db->runQuery("select count(a.user_installment_Id) as cnt, sum(a.InstallmentAmount) as amt from rbi_user_scheme_installment as a inner join rbi_user_to_scheme as b on(a.user_schemeId=b.user_schemeId) inner join rbi_user_customer as c on (b.userid=c.userId) where a.InstallmentDueDate like '".date('Y-m-d')."%' and a.Installment_status='0' and c.custstaus='1'");
			$this->view->todaydue = 0;
			$this->view->todaydueamount = 0;
			if(is_array($gettodaydue) && count($gettodaydue))
			{
				$this->view->todaydue = $gettodaydue[0]['cnt'];
				$this->view->todaydueamount = $gettodaydue[0]['amt'];
			}
			
			*/		
					
		} else {
		
			//============================================ Employee ======================================//
		}
    }	
	
	
	public function basicinfoAction(){
      
       global $mySessionFront;
	   
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		$db =  new Db();
		
		
		
		if($mySessionFront->user['userRole']=='Job Seeker') { 
			
			
			/*	
			$gettodaydue = $db->runQuery("select count(a.user_installment_Id) as cnt, sum(a.InstallmentAmount) as amt from rbi_user_scheme_installment as a inner join rbi_user_to_scheme as b on(a.user_schemeId=b.user_schemeId) inner join rbi_user_customer as c on (b.userid=c.userId) where a.InstallmentDueDate like '".date('Y-m-d')."%' and a.Installment_status='0' and c.custstaus='1'");
			$this->view->todaydue = 0;
			$this->view->todaydueamount = 0;
			if(is_array($gettodaydue) && count($gettodaydue))
			{
				$this->view->todaydue = $gettodaydue[0]['cnt'];
				$this->view->todaydueamount = $gettodaydue[0]['amt'];
			}
			
			*/		
					
		} else {
		
			//============================================ Employee ======================================//
		}
    }
	
	public function userprofileAction(){
			$this->_helper->layout()->setLayout('ajaxlayout');
			//$form = new Form_Userprofile($arr['id']);
			global $mySessionFront;
			$db=new Db();
			$qry="SELECT * FROM tbl_users where user_id='".$mySessionFront->user['FrontUserId']."'";
			//echo $qry; exit;
			$result=$db->runQuery($qry);
			$this->view->result =$result[0];
				
		}
	
	public function saveAction() 
	{
		$this->_helper->layout()->setLayout('ajaxlayout');
		$data = $this->_request->getPost();
		echo $user_id = $data['user_id'];
		echo $user_fname = $data['user_fname'];
		//this wont work;
	}
	
	
	//Editing Records...
	public function nneditAction()
	{	
		$this->_helper->layout()->setLayout('ajaxlayout');
			//$form = new Form_Userprofile($arr['id']);
			global $mySessionFront;
			$db=new Db();
			$this->_redirect('index');
			 $this->_helper->layout()->disableLayout('header');
  			 //$this->_helper->viewRenderer->setNoRender(true);
	}
	
	
	public function editAction()
	{	
		global $mySession;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$this->view->gradeid = $arr['gradeid'];
		$this->view->subjectid = $arr['subjectid'];
		$this->view->mode=0;
		
		if(@$arr['gradeid']) {
			if(isset($arr['mode']) && $arr['mode']=='update') {
			
				$this->view->mode=1;
				$modelobj = new Mainmodel();
				
				$Data='';
				$Data['name']=$arr['name'];
				$Data['code']=$arr['code'];
				$Data['updated_at']=date('Y-m-d h:i:s');
				
				$condition="id='".$arr['subjectid']."'";
				$modelobj->updateThis('subjects',$Data,$condition);		
				
				
				$qry="select * from `subjects` where grade_id='".$arr['gradeid']."'";
				$list = $db->runQuery("$qry");
				$this->view->slist=$list;
				
			} else {
				$qry="select * from `subjects` where id='".$arr['subjectid']."'";
				$sdetail = $db->runQuery("$qry");
				$this->view->sdetail=$sdetail[0];
				
				$qry="select * from `grades` where id='".$arr['gradeid']."'";
				$detail = $db->runQuery("$qry");
				$this->view->detail=$detail[0];
			}
			
		}			
	}
	
	







}
?>
