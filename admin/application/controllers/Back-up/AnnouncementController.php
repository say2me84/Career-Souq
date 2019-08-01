<?php
class AnnouncementController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }

    public function indexAction(){
        global $mySession;
		$this->view->pagetitle = 'Announcement';
		$db=new Db();
		$where='';
		
		if($mySession->user['userRole']!='A' || getsubadmin_role('announcementother'))
		{
			$where = ' and status=1';
		}
		$qry="select *, date_format(created_on,'%d/%m/%Y %h:%i:%s') as cdate from rbi_announcement where 1 $where order by id desc";		
		$announcement=$db->runQuery($qry);	
		$this->view->detail=$announcement;		
		
    }
	
	public function addAction(){
       global $mySession;
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		if($mySession->user['userRole']!='A'  and !getsubadmin_role('announcementother'))
		{ 	
			$this->_redirect('index');	
		}
		
		$form = new Form_Announcement();
		$form->announcform();
		$this->view->Form = $form;
		if ($this->getRequest()->isPost()) 
		{
			$dataForm = $this->_request->getPost();
			if ($form->isValid($dataForm))
			{
				$db=new Db();
				$mydata['message']=$dataForm['_announcement'];
				$mydata['created_by']=1;
				$mydata['created_on']=date('Y-m-d h:i:s');
				
				$db->save('rbi_announcement',$mydata);
				$mySession->errorMsg ="Announcement added successfully."; 
				$this->_redirect('announcement/index');
			}
		}
		///echo $mySession->user['userRole'];
    }
	
}
?>
