<?php
__autoloadDB('Db');
class MemberController extends Zend_Controller_Action
{
	public function addAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Create Mamber:";
		$form = new Form_Memberadd();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
		//$form = new Form_Admission();
		
	if ($objRequest->isPost()) {
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			//echo "AAkash";
			$Data['name'] = $formData['name'];
			$Data['gender'] = $formData['gender'];
			$Data['fathername'] = $formData['fathername'];
			$Data['address'] = $formData['address'];
			$Data['occupation'] = $formData['occupation'];
			$Data['nomini_name'] = $formData['nomini_name'];
			$Data['relation'] = $formData['relation'];
			$Data['age'] = $formData['age'];
			$Data['withness_name'] = $formData['withness_name'];
			$Data['withness_fname'] = $formData['withness_fname'];
			$Data['withness_add'] = $formData['withness_add'];
			
			//$Data['reg_dt'] = $formData['reg_dt'];
			//print_r($Data);
			$db->save('rbi_member',$Data); 
			$mid=$db->lastInsertId();
			$mySession->sucMsg = " NEW MEMBER ADDED SUCCESSFULLY";
			$this->_redirect('member/certi/mid/'.$mid);
		} 
			
	}
	
	}
		
	//View Records...
	public function indexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Member List:";
		//echo "akash";
			
	}
	public function generategridAction()
	{		
		global $_CONFIG, $mySession;
		$this->_helper->viewRenderer->setNoRender();
		$db=new Db();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'name';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
			
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		$qry="SELECT * FROM `rbi_member`";
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['mid']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['mid']."',";
			$json .= "cell:['".$i."'";
			$json .= ",'".$row['name']."'";
			$json .= ",'".$row['gender']."'";
			$json .= ",'".$row['fathername']."'";			
			$json .= ",'".$row['address']."'";			
			$json .= ",'".$row['occupation']."'";	
			$json .= ",'".$row['nomini_name']."'";	
			$json .= ",'".$row['relation']."'";			
			$json .= ",'".$row['age']."'";
			$json .= ",'".$row['withness_name']."'";
			$json .= ",'".$row['withness_fname']."'";
			$json .= ",'".$row['withness_add']."'";			
			$json .= ",'<a href=\"".APPLICATION_URL."member/edit/mid/".$row['mid']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."member/del/mid/".$row['mid']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
			$json .= "]}";
			$rc = true;
			$i++;
		}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
		exit();
	}
	
	//Edit Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['mid']) {
		$this->view->mid = $arr['mid'];
		
			$this->view->pagetitle = 'Edit Member';
			
			$form = new Form_Memberedit($arr['mid']);
			$this->view->myform=$form;		
			 if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();
					//prd($formData);
				if ($form->isValid($formData)) {
				
					$data='';
					$data['name'] = $formData['name'];
					$data['fathername'] = $formData['fathername'];
					$data['address'] = $formData['address'];
					$data['occupation'] = $formData['occupation'];
					$data['nomini_name'] = $formData['nomini_name'];
					$data['relation'] = $formData['relation'];
					$data['age'] = $formData['age'];
					$data['withness_name'] = $formData['withness_name'];
					$data['withness_fname'] = $formData['withness_fname'];
					$data['withness_add'] = $formData['withness_add'];
					//prd($data); exit;
										
					
					$condition = "mid='".$arr['mid']."'"; //exit;
					$db->modify('rbi_member',$data,$condition);

										
					$mySession->sucMsg = "MEMBER UPDATED SUCCESSFULLY";
					//$this->_redirect('school/show/schoolid/'.$arr['schoolid']);
					$this->_redirect('member/index');
				}
			 }
		}
	}
	
	//Del Records...
	public function delAction()
	{	
		//global $mySession;
		$db = new Db();
		$this->view->PageTitle="Delete Record..:";
		$delData = $this->getRequest()->getParams();
		//prd($delData);
		$mid="mid=".$delData['mid'];
		$Result=$db->delete('rbi_member',$mid); 
		//prd($Result); exit;
		if($Result==1){
		$this->_redirect('member/index');
		}else{
		die('Error');
		}
	}
	
	public function certiAction()
	{
	global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$mid = $arr['mid'];
		$qry="SELECT * FROM rbi_member WHERE mid='".$mid."'";
		$result=$db->runQuery($qry);
		$this->view->result = $result[0];
	}
	
}
?>