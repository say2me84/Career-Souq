<?php

class StateController extends Zend_Controller_Action{

    public function init()
	{    
		if(!isLogged()) 
		{		
		$this->_redirect('index');			
		}
    }

    public function indexAction(){
		global $mySession;
		$this->view->pagetitle = 'Sates';
		
		$searchlink=array();
		$obj = new Model_State();
		$result = $obj->showState();
		
		
		if($result){
			//$this->view->data = $result;	
		 $orderby=isset($this->getRequest()->order)?$this->getRequest()->order:'sfield_lable|asc';
		   $orderArr=explode("_",$orderby);
		   $order=array();
		   $order[$orderArr[0]]=$orderArr[1];
		   $this->view->currentOrder=$this->getRequest()->order;
			
			$db = new Db();
			$schemeList = $result;
			
			
			
			$paging=new Model_Paging();
			$pager=$paging->paging_data_list($schemeList);
			$pageLinks=$paging->paging_link_slider($schemeList,$searchlink);
			$this->view->pageLinks=$pageLinks;
			$this->view->data=$pager;
		}
	}
	
	public function addAction(){
		global $mySession;
		$this->view->pagetitle = 'Add State';
		if(isset($mySession->user['userId']) && !empty($mySession->user['userId'])){
			if(1==1){
				$form = new Form_Scheme();
				$this->view->Form = $form;
			}
		}else{
			$this->_redirect('index');
		}
		 
	}
	public function saveAction() {
		$modelobj = new Model_State();
		
		$form = new Form_State();
		$this->view->Form = $form;
		$request = $this->getRequest();
		if ($this->getRequest()->isPost() && $form->isValid($request->getPost())) 
		 	{
				$dataForm = $this->_request->getPost();
				
				
				$result=$modelobj->runThisQuery("select * from rbi_scheme where title='".$dataForm['_Title']."' and schema_type='".$dataForm['_Type']."'");
				
				if(is_array($result) && count($result) > 0)
				{
					$mySession->errorMsg="Scheme title already exists.";
					$this->view->Form=$form;
					$this->render('add');
				} else {
					$Data['title']=$dataForm['_Title'];
					$Data['schema_type']=$dataForm['_Type'];
					$insertdata=$modelobj->insertThis($Data);
					$mySession->errorMsg="New Scheme has been added successfully";
					$this->_redirect('scheme/index');
				}
				
			}
	}
	public function deleteAction(){
		global $mySession;
		$db=new Db();
		
		$dataForm = $this->_request->getPost();
		if(isset($dataForm['chk'])) {
			$ListId = implode(",",$dataForm['chk']);
			$whereCondition=" scheme_id in (".$ListId.")";		
			$result=$db->delete('rbi_scheme',$whereCondition);
			$mySession->errorMsg="Scheme has been deleted successfully";
			$this->_redirect('scheme/index');
		}		
		
	}
	public function changestatusAction(){
			
			$modelobj = new Model_Scheme(); 
			
			if($this->getRequest()->status==0)
			{
				$status=1;
			}else
			{
				$status=0;
			}
			$this->getRequest()->fid;
			$Data['scheme_status']=$status;
			$where="scheme_id='".$this->getRequest()->fid."'";
			$insertdata=$modelobj->updateThis($Data,$where);
			$mySession->errorMsg="Scheme has been updated successfully";			
			$this->_redirect('scheme/index');
	}
	
	public function editAction(){
		global $mySession;
		$modelobj = new Model_Scheme();
		
		$this->view->pagetitle = 'Edit Scheme';
		$arr=$this->getRequest()->getParams();
		
		if(isset($mySession->user['userId']) && !empty($mySession->user['userId'])){
			if(1==1){
				$result=$modelobj->runThisQuery("select * from rbi_scheme where schemId='".$arr['fid']."'");
				if(is_array($result) && count($result) > 0)
				{
					$mySession->editdetail=$result[0];
				}
				$form = new Form_Scheme();
				$this->view->Form = $form;
				$this->view->fid = $arr['fid'];
			}
		}else{
			$this->_redirect('index');
		}
	
	}
	public function updateAction()
	{
		$modelobj = new Model_Scheme();
		
		$form = new Form_Scheme();
		$this->view->Form = $form;
		$request = $this->getRequest();
		if ($this->getRequest()->isPost() && $form->isValid($request->getPost())) 
		{
			$dataForm = $this->_request->getPost();
			
			
			$result=$modelobj->runThisQuery("select * from rbi_scheme where title='".$dataForm['_Scheme']."' and schema_type='".$dataForm['_Type']."' and schemId!='".$dataForm['fid']."'");
			
			if(is_array($result) && count($result) > 0)
			{
				$mySession->errorMsg="Scheme name already exists.";
				$this->view->Form=$form;
				$this->render('edit');
			} else {
				$Data['title']=$dataForm['_Title'];
				$Data['schema_type']=$dataForm['_Type'];
				$where="schemId='".$dataForm['fid']."'";
				$insertdata=$modelobj->updateThis($Data,$where);
				$mySession->errorMsg="Scheme has been updated successfully";
				$this->_redirect('scheme/index');
			}
			
		}
	}
}
?>
