<?php
__autoloadDB('Db');
class ShareController extends Zend_Controller_Action
{
	public function addAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Create Share Holder:";
		$form = new Form_Shareadd();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	//echo "Test";
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			//echo "AAkash";
			$Data['name'] = $formData['name'];
			$Data['gender'] = $formData['gender'];
			$Data['father_name'] = $formData['father_name'];
			$Data['address'] = $formData['address'];
			
			$dtr=explode('-',$formData['share_date']);
			$Data['share_date'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
			
			$Data['no_share'] = $formData['no_share'];
			
			$dtr1=explode('-',$formData['frm_dt']);
			$Data['frm_dt'] = $dtr1[2].'-'.$dtr1[1].'-'.$dtr1[0];
			
			$dtr2=explode('-',$formData['to_dt']);
			$Data['to_dt'] = $dtr2[2].'-'.$dtr2[1].'-'.$dtr1[0];
			
			
			$Data['amt'] = $formData['amt'];
			$Data['reg_fol_no'] = $formData['reg_fol_no'];
			
			
			$qry="SELECT MAX(share_id) AS my_ceti_no FROM rbi_share";
			$result=$db->runQuery($qry);
			$maxid=5000;
			if(is_array($result) && count($result) >0)
			{
				if($result[0]['my_ceti_no'] > 4999) {
					$maxid=$result[0]['my_ceti_no']+1;
				}
				
				
			}
			$Data['crti_no'] = $maxid;
			
			//prd($Data);
			
			$db->save('rbi_share',$Data); 
			$share_id=$db->lastInsertId();
			$mySession->sucMsg = " NEW SHARE HOLDER ADDED SUCCESSFULLY";
			$this->_redirect('Share/certi/share_id/'.$share_id);
		} 
			
	}
	
	}
		
	//View Records...
	public function indexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Share List:";
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
		$qry="SELECT *,DATE_FORMAT(`share_date`,'%d-%m-%Y') as myshare_dt, DATE_FORMAT(`frm_dt`,'%d-%m-%Y') as myfrm_dt, DATE_FORMAT(`to_dt`,'%d-%m-%Y') as myto_dt FROM `rbi_share`";
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['share_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['share_id']."',";
			$json .= "cell:['".$i."'";
			$json .= ",'".$row['name']."'";
			$json .= ",'".$row['father_name']."'";
			$json .= ",'".$row['gender']."'";			
			$json .= ",'".$row['address']."'";	
			$json .= ",'".$row['myshare_dt']."'";
			$json .= ",'".$row['no_share']."'";	
			
			$json .= ",'".$row['myfrm_dt']."'";			
			$json .= ",'".$row['myto_dt']."'";
			
			$json .= ",'".$row['crti_no']."'";
			$json .= ",'".$row['amt']."'";
			$json .= ",'".$row['reg_fol_no']."'";			
			$json .= ",'<a href=\"".APPLICATION_URL."share/edit/share_id/".$row['share_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."share/del/share_id/".$row['share_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
//	
//	//Edit Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if($arr['share_id']) {
		$this->view->share_id = $arr['share_id'];
		
			$this->view->pagetitle = 'Edit Share Member';
			
			$form = new Form_Shareedit($arr['share_id']);
			$this->view->myform=$form;		
			 if ($this->_request->isPost()) {		 
		
				$formData = $this->_request->getPost();
					//prd($formData);
				if ($form->isValid($formData)) {
				
					$data='';
					$data['name'] = $formData['name'];
					$data['gender'] = $formData['gender'];
					$data['father_name'] = $formData['father_name'];
					$data['address'] = $formData['address'];
					
					$dtr=explode('-',$formData['share_date']);
					$data['share_date'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
//					
					$data['no_share'] = $formData['no_share'];
					
					$dtr1=explode('-',$formData['frm_dt']);
					$data['frm_dt'] = $dtr1[2].'-'.$dtr1[1].'-'.$dtr1[0];
					
					$dtr2=explode('-',$formData['to_dt']);
					$data['to_dt'] = $dtr2[2].'-'.$dtr2[1].'-'.$dtr1[0];
					
					$data['amt'] = $formData['amt'];
					$data['reg_fol_no'] = $formData['reg_fol_no'];
					
					//prd($data); exit; 
										
					
					$condition = "share_id='".$arr['share_id']."'"; //exit;
					$db->modify('rbi_share',$data,$condition);

										
					$mySession->sucMsg = "MEMBER UPDATED SUCCESSFULLY";
					//$this->_redirect('school/show/schoolid/'.$arr['schoolid']);
					$this->_redirect('share/index');
				}
			 }
		}
	}
//	
//	//Del Records...
	public function delAction()
	{	
		//global $mySession;
		$db = new Db();
		$this->view->PageTitle="Delete Record..:";
		$delData = $this->getRequest()->getParams();
		//prd($delData);
		$share_id="share_id=".$delData['share_id'];
		$Result=$db->delete('rbi_share',$share_id); 
		//prd($Result); exit;
		if($Result==1){
		$this->_redirect('share/index');
		}else{
		die('Error');
		}
	}
//	
	public function certiAction()
	{
	global $mySession;
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		$share_id = $arr['share_id'];
		$qry="SELECT *, DATE_FORMAT(`share_date`,'%d-%m-%Y') as mydate, DATE_FORMAT(`frm_dt`,'%d-%m-%Y') as my_frm_dt, DATE_FORMAT(`to_dt`,'%d-%m-%Y') as my_to_dt FROM rbi_share WHERE share_id='".$share_id."'";
		$result=$db->runQuery($qry);
		$this->view->result = $result[0];
	}
	
}
?>