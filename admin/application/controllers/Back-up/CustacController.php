<?php
__autoloadDB('Db');
class CustacController extends Zend_Controller_Action
{
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		
		}
		
	}
	
	//ADD New Records...
	public function addAction()
	{	
		$db = new Db();
		$this->view->PageTitle="Create Customer A/C:";
		$form = new Form_Custacadd();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
	if ($objRequest->isPost()) {
	 //echo "AAkash123"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			//echo "Test......."; exit;
			
			$Data='';
			$Data['cust_name'] = $formData['cust_name']; 
			$Data['father_name'] = $formData['father_name'];
			
			$dtr=explode('-',$formData['cust_dob']);
			$Data['cust_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
			//echo "AAkash"; exit; 
			
			$Data['gender'] = $formData['gender'];
			$Data['address'] = $formData['address'];
			$Data['phone_home'] = $formData['phone_home'];
			$Data['phone_off'] = $formData['phone_off'];
			$Data['mobi_one'] = $formData['mobi_one'];
			$Data['mobi_two'] = $formData['mobi_two'];
			$Data['pan_no'] = $formData['pan_no'];
			$Data['dl_no'] = $formData['dl_no'];
			$Data['bal_amt'] = $formData['bal_amt'];
			
			
			if($_FILES['cust_pic']['size'] > 307200)
				{
					$size=0;
				} else {
					$fname = $_FILES['cust_pic']['name'];
					$ext = getExt($fname);
					$i=1;
					$destino_image = CUST_IMG;
					$id_image = 'Cust_Photo_'.$i.'_'.rand(100,999);
					//move_uploaded_file($_FILES['cust_pic']['tmp_name'], $destino_image.$id_image.$ext); 
				}
			$Data['cust_pic'] = $id_image.$ext;
			
			if($_FILES['cust_sing']['size'] > 307200)
					{
						$size=0;
					} else {
						$fname = $_FILES['cust_sing']['name'];
						$ext = getExt($fname);
						$i=1;
						$destino_image = CUST_IMG;
						$id_image = 'cust_sing_'.$i.'_'.rand(100,999);
						//move_uploaded_file($_FILES['cust_pic']['tmp_name'], $destino_image.$id_image.$ext); 
					}
			$Data['cust_sing'] = $id_image.$ext;
		
	$branchData=$db->runQuery("select * from rbi_branch where userId = '".$formData['branch_Id']."'");	
	
	$mycnttData=$db->runQuery("SELECT COUNT(branchId) as mycnt FROM rbi_custac WHERE branchId = '".$formData['branch_Id']."'");
	
	$myid = str_pad(($mycnttData[0]['mycnt']+1),6,0,STR_PAD_LEFT);
	$Data['profileId'] = $branchData[0]['profileId'].$myid;
			
			$Data['branchId'] = $formData['branch_Id'];
			
			$qry="SELECT MAX(cust_ac_no) AS my_cust_ac_no FROM rbi_custac";
			$result=$db->runQuery($qry);
			$maxid=5000;
			if(is_array($result) && count($result) >0)
			{
				if($result[0]['my_cust_ac_no'] > 4999) {
					$maxid=$result[0]['my_cust_ac_no']+1;
				}
			}
			
			$Data['cust_ac_no'] = $maxid;
			
				prd($Data);
			
			$db->save('rbi_custac',$Data); 
			$mySession->sucMsg = "NEW CUSTOMER ADDED";
			$this->_redirect('custac/index');
			
		} 
		
		//echo "Akash..."; exit;	
	}
		
	} 
	
	//View Records... ->getParam('cust_id')
	public function indexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Customer List:";
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
		$qry="SELECT * FROM `rbi_custac`";
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['cust_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['cust_id']."',";
			$json .= "cell:['".$i."'";
			$json .= ",'".$row['cust_ac_no']."'";
			$json .= ",'".$row['cust_name']."'";
			$json .= ",'".$row['gender']."'";
			$json .= ",'".$row['father_name']."'";	
			$json .= ",'".$row['bal_amt']."'";		
			$json .= ",'".$row['address']."'";			
			$json .= ",'".$row['profileId']."'";
			$json .= ",'".$row['phone_home']."'";	
			$json .= ",'".$row['phone_off']."'";	
			$json .= ",'".$row['mobi_one']."'";			
			$json .= ",'".$row['mobi_two']."'";
			$json .= ",'".$row['dl_no']."'";
			$json .= ",'<a href=\"".APPLICATION_URL."custac/edit/cust_id/".$row['cust_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."custac/del/cust_id/".$row['cust_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	
	//Editing Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		
		$this->view->pagetitle = 'Edit Member';
		//$arr=$this->getRequest()->getParams('cust_id');
		$arr=$this->getRequest()->getParams();
		if($arr['cust_id']) {
		$this->view->cust_id = $arr['cust_id'];
		$form = new Form_Custacadd($arr['cust_id']);
		$this->view->myform=$form;	
		
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
		//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			
			$Data='';
			$Data['cust_name'] = $formData['cust_name']; 
			$Data['father_name'] = $formData['father_name'];
			
			$dtr=explode('-',$formData['cust_dob']);
			$Data['cust_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
			//echo "AAkash"; exit; 
			
			$Data['gender'] = $formData['gender'];
			$Data['address'] = $formData['address'];
			$Data['phone_home'] = $formData['phone_home'];
			$Data['phone_off'] = $formData['phone_off'];
			$Data['mobi_one'] = $formData['mobi_one'];
			$Data['mobi_two'] = $formData['mobi_two'];
			$Data['pan_no'] = $formData['pan_no'];
			$Data['dl_no'] = $formData['dl_no'];
			
			
			
			if($_FILES['cust_pic']['size'] > 307200)
				{
					$size=0;
				} else {
					$fname = $_FILES['cust_pic']['name'];
					$ext = getExt($fname);
					$i=1;
					$destino_image = CUST_IMG;
					$id_image = 'Cust_Photo_'.$i.'_'.rand(100,999);
					//move_uploaded_file($_FILES['cust_pic']['tmp_name'], $destino_image.$id_image.$ext); 
				}
			$Data['cust_pic'] = $id_image.$ext;
			
			if($_FILES['cust_sing']['size'] > 307200)
					{
						$size=0;
					} else {
						$fname = $_FILES['cust_sing']['name'];
						$ext = getExt($fname);
						$i=1;
						$destino_image = CUST_IMG;
						$id_image = 'cust_sing_'.$i.'_'.rand(100,999);
						//move_uploaded_file($_FILES['cust_pic']['tmp_name'], $destino_image.$id_image.$ext); 
					}
			$Data['cust_sing'] = $id_image.$ext;
		
			$branchData=$db->runQuery("select * from rbi_branch where userId = '".$formData['branch_Id']."'");	
						
			$mycnttData=$db->runQuery("SELECT COUNT(branchId) as mycnt FROM rbi_custac WHERE branchId = '".$formData['branch_Id']."'");
			$myid = str_pad(($mycnttData[0]['mycnt']+1),6,0, STR_PAD_LEFT);
			$Data['profileId'] = $branchData[0]['profileId'].$myid;
			
			$Data['branchId'] = $formData['branch_Id'];
			
			//prd($Data);
										
					
			$condition = "cust_id='".$arr['cust_id']."'"; //exit;
			$db->modify('rbi_custac',$Data,$condition);

								
			$mySession->sucMsg = "CUSTOMER UPDATED SUCCESSFULLY";
			//$this->_redirect('school/show/schoolid/'.$arr['schoolid']);
			$this->_redirect('custac/index');
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
		$mid="cust_id=".$delData['cust_id'];
		$Result=$db->delete('rbi_custac',$mid); 
		//prd($Result); exit;
		if($Result==1){
		$this->_redirect('custac/index');
		}else{
		die('Error');
		}
	}
	
//-------------------------------- Cutomer Deposite Amount ---------------------------------------///
		
	public function custpayAction()
	{
		$db = new Db();
		$this->view->PageTitle="GET DEPOSITE TYPE:";
		$form = new Form_custpay();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		
		if ($objRequest->isPost()) {
		//echo"Akash"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
		
		
		$qry="SELECT * FROM rbi_custac";
		$result=$db->runQuery($qry);
		//echo $result[0]['bal_amt']; exit;
			
			//echo "Test......."; exit;
			
			$Data='';
			$Data['cust_ac_no'] = $formData['cust_ac_no']; 
			$Data['amt'] = $formData['amt'];
			
			$dtr=explode('-',$formData['dept_dt']);
			$Data['dept_dt'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
			
			//echo "AAkash"; exit; 
			
			$Data['dept_typ'] = $formData['dept_typ'];
			
			if($formData['dept_typ']==1) {
				$Data['chq_no'] = $formData['vcno'];
				
			}
			if($formData['dept_typ']==2){
				$Data['chq_no'] = $formData['chq_no'];
				$Data['chq_bnk'] = $formData['chq_bnk'];
				$Data['chq_branch'] = $formData['chq_branch'];
			}
			
			if($formData['dept_typ']==3){
				$Data['chq_no'] = $formData['dd_no'];
				$Data['chq_bnk'] = $formData['dd_bnk'];
				$Data['chq_branch'] = $formData['dd_branch'];
			}
			
			if($formData['dept_typ']==4){
				$Data['chq_bnk'] = $formData['other_dis'];
				
			}
			
			$Data['dept_by'] = $formData['dept_by'];
			$Data['branch_Id'] = $formData['branch_Id'];
			
			
			//prd($Data);
			
			$db->save('rbi_cust_dept',$Data); 
			
			//$result[0]['bal_amt'];
			
			$Data1['bal_amt']= $result[0]['bal_amt']+$formData['amt'];
			$condition = "cust_ac_no='".$formData['cust_ac_no']."'"; //exit;
			$db->modify('rbi_custac',$Data1,$condition);
			$mySession->sucMsg = "AMOUNT DEPOSITED SUCCESSFULLY";
			$this->_redirect('custac/custindex');
			
		} 
		
		
		//echo "Akash..."; exit;	
	}
	}
	
	//View Payad Amount....
	public function custpayindexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Customer Payment Track:";
		//echo "akash";
			
	}
	public function custgenerategridAction()
	{	
		global $_CONFIG, $mySession;
		$this->_helper->viewRenderer->setNoRender();
		
		$db=new Db();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'dep_id';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		
		$dep_typ[1] = 'CASH';
		$dep_typ[2] ='Chque'; 
		$dep_typ[3] ='DD';
		$dep_typ[4] = 'Other';
		
		$qry="SELECT *,DATE_FORMAT(`dept_dt`,'%d-%m-%Y') as mydate FROM `rbi_cust_dept`";
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['dep_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['dep_id']."',";
			$json .= "cell:['".$i."'";
			$json .= ",'".$row['cust_ac_no']."'";
			$json .= ",'".$row['amt']."'";
			$json .= ",'".$row['mydate']."'";			
			$json .= ",'".$dep_typ[$row['dept_typ']]."'";			
			$json .= ",'".$row['chq_no']."'";	
			$json .= ",'".$row['chq_bnk']."'";	
			$json .= ",'".$row['chq_branch']."'";			
			$json .= ",'".$row['dept_by']."'";
			$json .= ",'".$row['branch_Id']."'";		
			$json .= ",'<a href=\"".APPLICATION_URL."custac/edit/dep_id/".$row['dep_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."custac/del/dep_id/".$row['dep_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	
//-------------------------------- Passing Customer A/c No to Ajax ---------------------------------------///
	
	function acdataAction(){
	$this->_helper->layout()->setLayout('ajaxlayout');
		global $mySession;
		$db=new Db();
		$qry="SELECT * FROM rbi_custac where cust_ac_no=".$_REQUEST['cust_ac_no']."";
		//echo $qry; exit;
		$result=$db->runQuery($qry);
		$this->view->result =$result[0];
				
	}
//-------------------------------- Cutomer Withdraw Amount ---------------------------------------///

	public function custwdrAction()
	{
		$db = new Db();
		$this->view->PageTitle="CUSTOMER WITHDRAW AMOUNT:";
		$form = new Form_custwdr();
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
		if ($objRequest->isPost()) {
		//echo"Akash"; exit;
		$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			$qry="SELECT * FROM rbi_custac";
			$result=$db->runQuery($qry);
			//echo "Test......."; exit;
			
			$Data='';
			$Data['cust_ac_no'] = $formData['cust_ac_no']; 
			$Data['amt'] = $formData['amt'];
			
			$dtr=explode('-',$formData['wdr_dt']);
			$Data['wdr_dt'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];
			
			//echo "AAkash"; exit; 
			
			$Data['wdr_typ'] = $formData['wdr_typ'];
			
			if($formData['wdr_typ']==1) {
				$Data['chq_no'] = $formData['vcno'];
				
			}
			if($formData['wdr_typ']==2){
				$Data['chq_no'] = $formData['chq_no'];
				$Data['chq_bnk'] = $formData['chq_bnk'];
				$Data['chq_branch'] = $formData['chq_branch'];
			}
			
			if($formData['wdr_typ']==3){
				$Data['chq_no'] = $formData['dd_no'];
				$Data['chq_bnk'] = $formData['dd_bnk'];
				$Data['chq_branch'] = $formData['dd_branch'];
			}
			
			if($formData['wdr_typ']==4){
				$Data['chq_bnk'] = $formData['other_dis'];
				
			}
			
			$Data['wdr_by'] = $formData['wdr_by'];
			$Data['branch_Id'] = $formData['branch_Id'];
			
			
			//prd($Data);
			
			$db->save('rbi_cust_wdr',$Data); 
			
			$Data1['bal_amt']= $result[0]['bal_amt']-$formData['amt'];
			$condition = "cust_ac_no='".$formData['cust_ac_no']."'"; //exit;
			$db->modify('rbi_custac',$Data1,$condition);
			$mySession->sucMsg = "AMOUNT DEPOSITED SUCCESSFULLY";
			$this->_redirect('custac/custwdr');
			
		} 
		
		//echo "Akash..."; exit;	
	}
	}
	
	//View Payad Amount....
	public function wdrindexAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Customer Payment Track:";
		//echo "akash";
			
	}
	public function wdrgenerategridAction()
	{	
		global $_CONFIG, $mySession;
		$this->_helper->viewRenderer->setNoRender();
		
		$db=new Db();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'wdr_id';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		//echo "AAAAAAAkash"; exit;
		$wdr_typ[1] = 'CASH';
		$wdr_typ[2] ='Chque'; 
		$wdr_typ[3] ='DD';
		$wdr_typ[4] = 'Other';
		//echo "SELECT *,DATE_FORMAT(`wdr_dt`,'%d-%m-%Y') as mydate FROM `rbi_cust_wdr`"; exit;
		$qry="SELECT *,DATE_FORMAT(`wdr_dt`,'%d-%m-%Y') as mydate FROM `rbi_cust_wdr`";
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['wdr_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['wdr_id']."',";
			$json .= "cell:['".$i."'";
			$json .= ",'".$row['cust_ac_no']."'";
			$json .= ",'".$row['amt']."'";
			$json .= ",'".$row['mydate']."'";			
			$json .= ",'".$wdr_typ[$row['wdr_typ']]."'";			
			$json .= ",'".$row['chq_no']."'";	
			$json .= ",'".$row['chq_bnk']."'";	
			$json .= ",'".$row['chq_branch']."'";			
			$json .= ",'".$row['wdr_by']."'";
			$json .= ",'".$row['branch_Id']."'";		
			$json .= ",'<a href=\"".APPLICATION_URL."custac/edit/wdr_id/".$row['wdr_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."custac/del/wdr_id/".$row['wdr_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
	
//-------------------------------- Customer Payment Deposite List  ---------------------------------------///
	
	function custpaylistAction()
	{
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Customer Payment Deposite List';
		
		$arr=$this->getRequest()->getParams();
		if(isset($arr['searchfor_sb']) && $arr['searchfor_sb']!='') {
			$this->view->searchfor_sb = $arr['searchfor_sb'];
		} else {
			$this->view->searchfor_sb = 5;
		}
		
		if(isset($arr['sel_month']) && $arr['sel_month']!='') {
			$this->view->sel_month = $arr['sel_month'];
		} else {
			$this->view->sel_month = str_pad(date('m'),2,0,STR_PAD_LEFT);
		}
		
		if(isset($arr['sel_year']) && $arr['sel_year']!='') {
			$this->view->sel_year = $arr['sel_year'];
		} else {
			$this->view->sel_year = date('Y');
		}
		
		
		$where ='';
		$where .= " and branch_Id='".$this->view->searchfor_sb."' ";
		
		$dt = $this->view->sel_year.'-'.str_pad($this->view->sel_month,2,0,STR_PAD_LEFT);
		
		$where .= " and dept_dt like '".$dt."-%' ";
		
		$fields = "cust_ac_no, amt, dept_typ, chq_no, chq_bnk,chq_branch,DATE_FORMAT(dept_dt,'%d/%m/%Y') as mydate,dept_by,branch_Id";
		 
		$qry="select ".$fields."
		from rbi_cust_dept where 1 ".$where." order by branch_Id desc, branch_Id";
		
		$result = $db->runQuery($qry);
		$this->view->result = $result;
		
		
				
	}
	
	function custwdrlistAction()
	{
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Customer Payment Withdraw List';
		
		$arr=$this->getRequest()->getParams();
		if(isset($arr['searchfor_sb']) && $arr['searchfor_sb']!='') {
			$this->view->searchfor_sb = $arr['searchfor_sb'];
		} else {
			$this->view->searchfor_sb = 5;
		}
		
		if(isset($arr['sel_month']) && $arr['sel_month']!='') {
			$this->view->sel_month = $arr['sel_month'];
		} else {
			$this->view->sel_month = str_pad(date('m'),2,0,STR_PAD_LEFT);
		}
		
		if(isset($arr['sel_year']) && $arr['sel_year']!='') {
			$this->view->sel_year = $arr['sel_year'];
		} else {
			$this->view->sel_year = date('Y');
		}
		
		
		$where ='';
		$where .= " and branch_Id='".$this->view->searchfor_sb."' ";
		
		$dt = $this->view->sel_year.'-'.str_pad($this->view->sel_month,2,0,STR_PAD_LEFT);
		
		$where .= " and wdr_dt like '".$dt."-%' ";
		
		$fields = "cust_ac_no, amt, wdr_typ, chq_no, chq_bnk,chq_branch,DATE_FORMAT(wdr_dt,'%d/%m/%Y') as mydate,wdr_by,branch_Id";
		 
		$qry="select ".$fields."
		from rbi_cust_wdr where 1 ".$where." order by branch_Id desc, branch_Id";
		
		$result = $db->runQuery($qry);
		$this->view->result = $result;
		
		
				
	}
	
	function custlistAction()
	{
		global $mySession;
		$db = new Db();
		$this->view->pagetitle = 'Customer List';
		
		$arr=$this->getRequest()->getParams();
		if(isset($arr['searchfor_sb']) && $arr['searchfor_sb']!='') {
			$this->view->searchfor_sb = $arr['searchfor_sb'];
		} else {
			$this->view->searchfor_sb = 5;
		}
		
		if(isset($arr['sel_month']) && $arr['sel_month']!='') {
			$this->view->sel_month = $arr['sel_month'];
		} else {
			$this->view->sel_month = str_pad(date('m'),2,0,STR_PAD_LEFT);
		}
		
		
		
		if(isset($arr['sel_year']) && $arr['sel_year']!='') {
			$this->view->sel_year = $arr['sel_year'];
		} else {
			$this->view->sel_year = date('Y');
		}
		
		
		
		
		$where ='';
		$where .= " and branchId='".$this->view->searchfor_sb."' ";
		
		$dt = $this->view->sel_year.'-'.str_pad($this->view->sel_month,2,0,STR_PAD_LEFT);
		
		$where .= " and cust_dob like '".$dt."-%' ";
		
		$fields = "cust_ac_no, cust_name, father_name, phone_home, mobi_one,address,DATE_FORMAT(cust_dob,'%d/%m/%Y') as cust_dob,cust_dob, dl_no, bal_amt, branchId";
		 
		$qry="select ".$fields."
		from rbi_custac where 1 ".$where." order by branchId desc, branchId";
		
		$result = $db->runQuery($qry);
		$this->view->result = $result;
		
		
				
	}
}
?>
