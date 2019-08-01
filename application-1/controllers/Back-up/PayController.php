<?php

class PayController extends Zend_Controller_Action

{

	public function init() 

	{    
		global $mySession;
		
		if(!isLogged()) 

		{ 	

		 $this->_redirect('index');			

		}
		
		if($mySession->user['userRole']=='A' || getsubadmin_role('report') || getsubadmin_role('pay')  || $mySession->user['userRole']=='AG' || $mySession->user['userRole']=='E')
		{
		} else {
			//$this->_redirect('index');	
			//echo "<script>window.location='index'<script>";
		}
		

    }
	public function paydailyAction()
	{
global $mySession;
		
		$this->view->pagetitle = 'Receive Daily Installment';	
		$arr=$this->getRequest()->getParams();
			
		$form = new Form_Pay();
		$form->paydailyform();
		$this->view->Form = $form;
		if ($this->getRequest()->isPost()) 
		{
		
			$dataForm = $this->_request->getPost();
			if ($form->isValid($dataForm))
			{
				
				$db=new Db();
				$db_validation=1;
				if($mySession->user['userRole']=='AG' || $mySession->user['userRole']=='E' || $mySession->user['userRole']=='SA') {
						if(DEF_CHK_ALLOT_RECEIPT) {
							$qry="select id from rbi_receipt where recno='".$dataForm['receipt_no']."' and allotto='".$mySession->user['userId']."'";
							$result=$db->runQuery("$qry");
							if(is_array($result) && count($result) > 0)
							{
								
							} else {
								$mySession->errorMsg ="You have not allot this receipt no."; 
								$db_validation=0;
							}
						}
				}
				if(DEF_CHK_RECEIPT_ALREADY) {
					$qry="select receiptno from rbi_user_scheme_installment_paid where receiptno='".$dataForm['receipt_no']."'";
					$result=$db->runQuery("$qry");
					if(is_array($result) && count($result) > 0 && $db_validation==1)
					{
						$mySession->errorMsg ="Receipt no. already exists"; 
						$db_validation=0;
					} 
				}
				if($db_validation) {
		
					$obj = new Model_Pay();
					$db=new Db();
			
					//$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid where user_installment_Id!='".$dataForm['pinsid']."'";
					$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid ";
					$maxidresult=$db->runQuery("$qry");	///print_r($dataForm);
				
					if($maxidresult[0]['maxrecno'] < 5000) { $maxid =5000; } else { $maxid =$maxidresult[0]['maxrecno']; }
					
					$custinst = $db->runQuery("select * from rbi_user_scheme_installment_daily where userId='".$arr['userid']."' order by instno");
					$vp_status=1;
					$instamt = $custinst[0]['InstallmentAmount'];
					$payamt = $arr['payamt'];
					
					$numinst = number_format($payamt / $instamt);					
						
					$virtual_pay = 	$instamt*$numinst;
					if($virtual_pay!=$payamt)
					{
						if($virtual_pay < $payamt)
						{
							$vp_status=3;
							$gp = $virtual_pay - $payamt;
							$numinst=$numinst-1;
						} else {
							$vp_status=2;
							$gp = $virtual_pay - $payamt;
							
							$numinst=$numinst-1;
						}
					}
					
					$instidarr = array();
					$i=0;
					for($m = 0; $m < $numinst;$m++)
					{
						$instidarr[] = $custinst[$i]['user_installment_Id'];
						$i++;
					}
					if($vp_status==2 || $vp_status==3)
					{
						$ext_instid = $custinst[$i]['user_installment_Id'];
					} 
					$instids = implode(",",$instidarr);
					
					
					$payto = 1;
					if(DEF_NEED_APPROVE) {
						if($mySession->user['userRole']=='A' || getsubadmin_role('i'))
						{
							$Data['Installment_status']=1;	
							$payto=1;
						} elseif($mySession->user['userRole']=='AG' || $mySession->user['userRole']=='E') {
							$Data['Installment_status']=2;	
							$payto=1;
						}
					} else {
						$Data['Installment_status']=1;	
						$payto=1;
					}
					if($payto) {
						$Data['receiptno']=$dataForm['receipt_no'];
						$Data['PaniltyAmount']=$dataForm['penalty'];
						$Data['transactionno']=$maxid;
					
						$paydate = changeDate($dataForm['date_of_reg']);
						if($paydate==date('Y-m-d')) {
							$Data['Installment_Paidon']=date('Y-m-d h:i:s');	
						} else {
							$Data['Installment_Paidon']=$paydate;	
						}
						$Data['payamt']=$payamt;
						$Data['Installment_Paidby']=$mySession->user['userId'];	
										
						$where="user_installment_Id  in (".$instids.")";
						$table1 = 'rbi_user_scheme_installment_daily';
						
						$db->modify($table1,$Data,$where);
						if($vp_status==2)
						{ 
							$data['halfdue'] = $gp;
							$data['InstallmentAmount'] = $custinst[0]['InstallmentAmount']-$gp;
							
							$where="user_installment_Id  in (".$ext_instid.")";
							$db->modify($table1,$Data,$where);
						}
						if($vp_status==3)
						{ 
							$data['halfdue'] = 0-$gp;
							$data['InstallmentAmount'] = $custinst[0]['InstallmentAmount']+$gp;
							
							$where="user_installment_Id  in (".$ext_instid.")";
							$db->modify($table1,$Data,$where);
						}
						//prd($Data);
					//$insertdata=$obj->updateThis($Data,$where);
					//echo "ssssssssssssssss";
					//exit;
					
					if($dataForm['receipt_no']) {
						$obj_x = new Model_Mainmodel();	
														
						$expire_condition = "recno='".$dataForm['receipt_no']."'";
						$expireDataArray =array('user_inst_Id'=>$ext_instid);
						$Resultx=$obj_x->updateThis('rbi_receipt',$expireDataArray,$expire_condition);
					}
					
					if($Data['Installment_status']==1) {
						$qry_user="select userid, mobno from rbi_user where profileId='".$dataForm['d_customerid']."'";
						$userdetail=$db->runQuery("$qry_user");	///print_r($dataForm);
						
						if(is_array($userdetail) && count($userdetail) > 0 && 2==3)
						{
							$message ='';
							//$message='Your installment successfully paid. Rajasthan Build Square India Ltd.';
							
							$instno='2';
							$qryi="select min(instno) as min_instno, max(instno) as max_instno from rbi_user_scheme_installment where user_installment_Id  in (".$instids.")";
							
					$resulti=$db->runQuery("$qryi");
							
							if(is_array($resulti) && count($resulti) > 0)
							{
								if($resulti[0]['min_instno']==$resulti[0]['max_instno']) {
									$instno = $resulti[0]['min_instno'];
								} else {
									$instno = $resulti[0]['min_instno'].' - '.$resulti[0]['max_instno'];
								}
							}
							
							if(1==2) {
								$nm = '';
								$qryn="select u.fname, u.lname "
								." FROM rbi_user_scheme_installment as usi "
								." inner join rbi_user_to_scheme as us on (usi.user_schemeid=us.user_schemeId) "
								." inner join rbi_user as u on (us.userid=u.userid) "
								." where usi.user_installment_Id  in (".$instids.") limit 0,1";
								
								$resultn=$db->runQuery("$qryn");
								if(is_array($resultn) && count($resultn) > 0)
								{
									$nm = $resultn[0]['fname'].' - '.$resultn[0]['lname'];
								}
								
								$message=$nm.' thanks for your '.$instno.' renewal your orignal receipt no '.$maxid.' and local recpipt no '.$dataForm['receipt_no'];
								
								sendtosms($userdetail[0]['mobno'],$message);
							}
						}
						
						$obj_x = new Model_Mainmodel();	
						$a = $obj_x->transfertopaid();
						
						/*echo "<script>window.location='pay/receipt/receiptId/".$dataForm['pinsid']."'</script>";*/
						$mySession->errorMsg ="Installment paid successfully."; 
						//$this->_redirect('pay/paydaily');
						echo "<script>window.location='".APPLICATION_URL."pay/paydaily'</script>";
						exit;
					} else {
						$mySession->errorMsg ="Installment paid successfully but need to administrator approval."; 
						echo "<script>window.location='".APPLICATION_URL."pay/paydaily'</script>";
						exit;
					}
					
					//$this->_redirect('pay/receipt/receiptId/'.$dataForm['pinsid']);
					} else {
						echo "<script>window.location='".APPLICATION_URL."pay/paydaily'</script>";
						exit;
					}
					exit;
				
				}
			}
		}
		
	}
	public function userdetailtdAction()
	{
		$arr=$this->getRequest()->getParams();
		
		$db = new Db();
		 //echo "select userid, concat(fname,' ',lname) as name from rbi_user where profileId='".$arr['vl']."' and status='1'<br>";
		$getuser = $db->runQuery("select userid, concat(fname,' ',lname) as name from rbi_user where profileId='".$arr['vl']."' and status='1'");
		if(is_array($getuser) && count($getuser) > 0)
		{
			//echo "select timePriodType, installment, noOfInstallment from rbi_user_to_scheme where userid='".$getuser[0]['userid']."'";
			//exit;
			$schdetail = $db->runQuery("select timePriodType, installment, noOfInstallment from rbi_user_to_scheme where userid='".$getuser[0]['userid']."'");
			if(is_array($schdetail) && count($schdetail) > 0)
			{
				if($schdetail[0]['timePriodType']==0) {
					//echo "select sum(InstallmentAmount) as paidamount from rbi_user_scheme_installment_paid where userid='".$getuser[0]['userid']."' group by userid";
					//exit;
					$paid_amount = $db->runQuery("select sum(InstallmentAmount) as paidamount from rbi_user_scheme_installment_paid where userid='".$getuser[0]['userid']."' group by userid");
					if(is_array($paid_amount) && count($paid_amount) > 0)
					{
						$totalpaid = $paid_amount[0]['paidamount'];
					} else {
						$totalpaid = 0;
					}
					
					echo '<input type="hidden" name="userid" id="userid" value="'.$getuser[0]['userid'].'">';
					echo '<input type="hidden" name="usercode" id="usercode" value="'.$arr['vl'].'">';
					echo ''.$getuser[0]['name'];
					echo '<br><br>';
					echo 'Total Paid Amount : '.$totalpaid;
					echo '<br><br>';
					$totalamt  = ($schdetail[0]['installment']*$schdetail[0]['noOfInstallment']);
					echo 'Total Amount  : '.$totalamt;
					echo '<br><br>';
					echo 'Total Amount  : '.($totalamt-$totalpaid);
				} else {
					echo '<input type="hidden" name="userid" id="userid" value="0">';
					echo '<input type="hidden" name="usercode" id="usercode" value="'.$arr['vl'].'">';
					echo 'This customer not have daily plan.<br>Please enter daily customer code';
				} 
			} else {
				echo '<input type="hidden" name="userid" id="userid" value="0">';
				echo '<input type="hidden" name="usercode" id="usercode" value="'.$arr['vl'].'">';
				echo 'Please Enter Currect Customer Code';
			}			
		} else {
			echo '<input type="hidden" name="userid" id="userid" value="0">';
			echo '<input type="hidden" name="usercode" id="usercode" value="'.$arr['vl'].'">';
			echo 'Please Enter Currect Customer Code';
			
		}
		
		exit;
	}
	public function indexAction()

	{

		global $mySession;
		

		$this->view->pagetitle = 'Receive Installment';		
		
		if(isset($mySession->user['userId']) && !empty($mySession->user['userId'])){

			if(1==1){

				$mySession->editdetail='';
				
				$form = new Form_Pay();
				$form->payform();
				$this->view->Form = $form;
				if ($this->getRequest()->isPost()) 
		 		{
					$dataForm = $this->_request->getPost();
					
					
					if(isset($dataForm['pinsid']))
					{	
					
						$form1 = new Form_Pay();
						$form1->payreceiptform();
						$this->view->receiptForm = $form1;
						
						if ($form1->isValid($dataForm))
						{
						
							$db=new Db();
							$db_validation=1;
							if($mySession->user['userRole']=='AG' || $mySession->user['userRole']=='E' || $mySession->user['userRole']=='SA') {
									if(DEF_CHK_ALLOT_RECEIPT) {
										$qry="select id from rbi_receipt where recno='".$dataForm['receipt_no']."' and allotto='".$mySession->user['userId']."'";
										$result=$db->runQuery("$qry");
										if(is_array($result) && count($result) > 0)
										{
											
										} else {
											$mySession->errorMsg ="You have not allot this receipt no."; 
											$db_validation=0;
										}
									}
							}
							if(DEF_CHK_RECEIPT_ALREADY) {
								$qry="select receiptno from rbi_user_scheme_installment_paid where receiptno='".$dataForm['receipt_no']."'";
								$result=$db->runQuery("$qry");
								if(is_array($result) && count($result) > 0 && $db_validation==1)
								{
									$mySession->errorMsg ="Receipt no. already exists"; 
									$db_validation=0;
								} 
							}
							if($db_validation) {
								$obj = new Model_Pay();
								$db=new Db();
						
								//$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid where user_installment_Id!='".$dataForm['pinsid']."'";
								$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid ";
								$maxidresult=$db->runQuery("$qry");	///print_r($dataForm);
							
								if($maxidresult[0]['maxrecno'] < 5000) { $maxid =5000; } else { $maxid =$maxidresult[0]['maxrecno']; }
								$payto = 1;
								if(DEF_NEED_APPROVE) {
									if($mySession->user['userRole']=='A' || getsubadmin_role('i'))
									{
										$Data['Installment_status']=1;	
										$payto=1;
									} elseif($mySession->user['userRole']=='AG' || $mySession->user['userRole']=='E') {
										$Data['Installment_status']=2;	
										$payto=1;
									}
								} else {
									$Data['Installment_status']=1;	
									$payto=1;
								}
								if($payto) {
								$Data['receiptno']=$dataForm['receipt_no'];
								$Data['PaniltyAmount']=$dataForm['penalty'];
								$Data['transactionno']=$maxid;
								$paydate = changeDate($dataForm['date_of_reg']);
								if($paydate==date('Y-m-d')) {
									$Data['Installment_Paidon']=date('Y-m-d h:i:s');	
								} else {
									$Data['Installment_Paidon']=$paydate;	
								}
								$Data['Installment_Paidby']=$mySession->user['userId'];						
								$where="user_installment_Id  in (".$dataForm['pinsid'].")";
								if($dataForm['sctype']==0) {
									$table1 = 'rbi_user_scheme_installment_daily';
								} else {
									$table1 = 'rbi_user_scheme_installment';									
								}
								
								$db->modify($table1,$Data,$where);
								//$insertdata=$obj->updateThis($Data,$where);
								//echo "ssssssssssssssss";
								//exit;
								if($dataForm['receipt_no']) {
									$obj_x = new Model_Mainmodel();									
									$expire_condition = "recno='".$dataForm['receipt_no']."'";
									$expireDataArray =array('user_inst_Id'=>$dataForm['pinsid']);
									$Resultx=$obj_x->updateThis('rbi_receipt',$expireDataArray,$expire_condition);
								}
								
								if($Data['Installment_status']==1) {
									$qry_user="select userid, mobno from rbi_user where profileId='".$dataForm['ppid']."'";
									$userdetail=$db->runQuery("$qry_user");	///print_r($dataForm);
									if(is_array($userdetail) && count($userdetail) > 0)
									{
										$message ='';
										//$message='Your installment successfully paid. Rajasthan Build Square India Ltd.';
										
										$instno='2';
										$qryi="select min(instno) as min_instno, max(instno) as max_instno from rbi_user_scheme_installment where user_installment_Id  in (".$dataForm['pinsid'].")";
										$resulti=$db->runQuery("$qryi");
										
										if(is_array($resulti) && count($resulti) > 0)
										{
											if($resulti[0]['min_instno']==$resulti[0]['max_instno']) {
												$instno = $resulti[0]['min_instno'];
											} else {
												$instno = $resulti[0]['min_instno'].' - '.$resulti[0]['max_instno'];
											}
										}
										if(1==2) {
											$nm = '';
											$qryn="select u.fname, u.lname "
											." FROM rbi_user_scheme_installment as usi "
											." inner join rbi_user_to_scheme as us on (usi.user_schemeid=us.user_schemeId) "
											." inner join rbi_user as u on (us.userid=u.userid) "
											." where usi.user_installment_Id  in (".$dataForm['pinsid'].") limit 0,1";
											
											$resultn=$db->runQuery("$qryn");
											if(is_array($resultn) && count($resultn) > 0)
											{
												$nm = $resultn[0]['fname'].' - '.$resultn[0]['lname'];
											}
											
											$message=$nm.' thanks for your '.$instno.' renewal your orignal receipt no '.$maxid.' and local recpipt no '.$dataForm['receipt_no'];
											
											sendtosms($userdetail[0]['mobno'],$message);
										}
									}
									$obj_x = new Model_Mainmodel();	
									$a = $obj_x->transfertopaid();
									/*echo "<script>window.location='pay/receipt/receiptId/".$dataForm['pinsid']."'</script>";*/
									$mySession->errorMsg ="Installment paid successfully."; 
									echo "<script>window.location='pay';</script>";
								} else {
									$mySession->errorMsg ="Installment paid successfully but need to administrator approval."; 
									echo "<script>window.location='pay';</script>";
								}
								
								//$this->_redirect('pay/receipt/receiptId/'.$dataForm['pinsid']);
								} else {
									echo "<script>window.location='index'</script>";
								}
								exit;
							}
						}
							$db=new Db();
							$qry="select userId from rbi_user_customer where profileId='".$dataForm['ppid']."'";
							
							//$qry="select rus.user_schemeid from rbi_user_customer as ruc inner join rbi_user_to_scheme as rus on(ruc.  	userId=rus.userid) where ruc.profileId='".$dataForm['_Customerid']."'";
	
							$result=$db->runQuery("$qry");
							if(is_array($result) && count($result) > 0)
							{
							
								$cid=$result[0]['userId'];
			
								if(isset($dataForm['_limit']) && $dataForm['_limit']!='') {
									$limit = $dataForm['_limit'];
									
								} else {
									$limit = 1;
								}
								$this->view->limit=$limit;
								$this->view->custid=$dataForm['ppid'];
							$cid=$result[0]['userId'];
								$getsctype = $db->runQuery("select timePriodType from rbi_user_to_scheme where userid='".$cid."'");
								if(is_array($result) && count($result) > 0)
								{
									$this->view->sctype = $getsctype[0]['timePriodType'];
								} else {
									$this->view->sctype = 1;
								}
								
								$obj = new Model_Pay();
								$obj->cid=$cid;
								$result = $obj->showduelist();
								
								if(is_array($result)){
									$this->view->data = $result;
									$this->view->showduelist =1;
								}
							}
						
					
					} else {
					
					
					
						if ($form->isValid($dataForm))
						{
							$form = new Form_Pay();
							$form->payreceiptform();
							$this->view->receiptForm = $form;
					
							$db=new Db();
							$qry="select userId from rbi_user_customer where profileId='".$dataForm['_Customerid']."'";
							//$qry="select rus.user_schemeid from rbi_user_customer as ruc inner join rbi_user_to_scheme as rus on(ruc.  	userId=rus.userid) where ruc.profileId='".$dataForm['_Customerid']."'";
	
							$result=$db->runQuery("$qry");
							if(is_array($result) && count($result) > 0)
							{
																
								if(isset($dataForm['_limit']) && $dataForm['_limit']!='') {
									$limit = $dataForm['_limit'];
								} else {
									$limit = 1;
								}
								$this->view->limit=$limit;
								$this->view->custid=$dataForm['_Customerid'];
							$cid=$result[0]['userId'];
								$getsctype = $db->runQuery("select timePriodType from rbi_user_to_scheme where userid='".$cid."'");
								if(is_array($getsctype) && count($getsctype) > 0)
								{
									$this->view->sctype = $getsctype[0]['timePriodType'];
								} else {
									$this->view->sctype = 1;
								}
					
								$obj = new Model_Pay();
								$obj->cid=$cid;
								$obj->limit=$limit;
								$obj->sctype = $this->view->sctype;
								$result = $obj->showduelist();
								//prd($result);
								if(is_array($result)){
									$this->view->data = $result;
									$this->view->showduelist =1;
								}	
								
								//$this->_redirect('pay/duelist/cid/'.$result[0]['userId']);
								
							} else {
								$mySession->errorMsg="Customer Id not available.";
							}
						}
					}
				}
			}
			
		}		
		

	}

	public function payinstAction()
	{
		global $mySession;
		$obj = new Model_Pay();
		
		if(isset($mySession->user['userId']) && !empty($mySession->user['userId'])){
			$request = $this->getRequest();
				if ($this->getRequest()->isPost()) 
				{
					$dataForm = $this->_request->getPost();		
					if (@$dataForm['pinsid']!='' && @$dataForm['ppid']!='')
					{
						$db=new Db();
						
						$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid where user_installment_Id!='".$dataForm['pinsid']."'";
						$maxidresult=$db->runQuery("$qry");	print_r($dataForm);
					
						if($maxidresult[0]['maxrecno'] < 5000) { $maxid =5000; } else { $maxid =$maxidresult[0]['maxrecno']; }
						$Data['Installment_status']=1;	
						$Data['transactionno']=$maxid;
						$Data['Installment_Paidon']=date('Y-m-d h:i:s');	
						$Data['Installment_Paidby']=$mySession->user['userId'];						
						$where="user_installment_Id='".$dataForm['pinsid']."'";
						
						
		$insertdata=$obj->updateThis($Data,$where);
						
						$this->_redirect('pay/receipt/receiptId/'.$dataForm['pinsid']);
						
						exit;
						
					}
				}
		}
	}
	public function receiptAction()
	{
		global $mySession;
		$obj = new Model_Pay();
		$receiptId= $this->getRequest()->getParam('receiptId');
		
		$obj->cid=$receiptId;
		$result = $obj->showpayinst();
		if($result){
			$this->view->data = $result;			
		}									
	}
	public function duelistAction()
	{
		global $mySession;
		
		$cid=$this->getRequest()->cid;
		
		$obj = new Model_Pay();
		$obj->cid=$cid;
		$result = $obj->showduelist();
		if($result){
			$this->view->data = $result;
		}	
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

		if (!$sortname) $sortname = 'title';

		if (!$sortorder) $sortorder = 'asc';		

		$where="where 1=1";

		if(@$_POST['query']!='')

		{

			$where .= " and ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ";

		} 		

		$sort = "ORDER BY $sortname $sortorder";					

		if (!$page) $page = 1;

		if (!$rp) $rp = 10;		

		$start = (($page-1) * $rp);		

		$limit = "LIMIT $start, $rp";

		$qry="select * from rbi_scheme inner join rbi_scheme_type on(rbi_scheme.scheme_type=rbi_scheme_type.schemeTypeId)";

		$roles=$db->runQuery("$qry $where $sort $limit");

		$countQuery=$db->runQuery("$qry $where");		

		$total=count($countQuery);		

		$json = "";

		$json .= "{\n";

		$json .= "page: $page,\n";

		$json .= "total: $total,\n";

		$json .= "rows: [";

		$rc = false;

		if(isset($roles[0]) && $roles[0]['schemId']!="")

		{

		$i=1;

		foreach($roles as $row)

		{			

			if ($rc) $json .= ",";

			$json .= "\n{";

			$json .= "id:'".$row['schemId']."',";

			$json .= "cell:['".$i."'";

			$json .= ",'".$row['title']."'";

			$json .= ",'".$row['schemeType']."'";

			if($row['status']=='1')

			{

			$json .= ",'<a href=\"".APPLICATION_URL."scheme/changestatus/schemId/".$row['schemId']."/status/".$row['status']."\"><img title=\"Change Status\" alt=\"Change Status\" src=\"".APPLICATION_URL."/images/icon_status_green.gif\" border=\"0\" /></a>'";

			}

			else

			{

			$json .= ",'<a href=\"".APPLICATION_URL."scheme/changestatus/schemId/".$row['schemId']."/status/".$row['status']."\"><img title=\"Change Status\" alt=\"Change Status\" src=\"".APPLICATION_URL."/images/icon_status_red.gif\" border=\"0\" /></a>'";

			}

			$json .= ",'<a href=\"".APPLICATION_URL."scheme/edit/fid/".$row['schemId']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";

			$json .= ",'<a href=\"".APPLICATION_URL."scheme/delete/schemId/".$row['schemId']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			

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

	

	public function addAction(){

		global $mySession;

		$this->view->pagetitle = 'Add Scheme';

		if(isset($mySession->user['userId']) && !empty($mySession->user['userId'])){

			if(1==1){

				$mySession->editdetail='';

				$form = new Form_Scheme();

				$this->view->Form = $form;

				

				$request = $this->getRequest();

				

				if ($this->getRequest()->isPost()) 

		 		{

					$dataForm = $this->_request->getPost();

					if ($form->isValid($dataForm))

					{

						

						$modelobj = new Model_Scheme();

						

						

						$result=$modelobj->runThisQuery("select * from rbi_scheme where title='".$dataForm['_Title']."' and scheme_type='".$dataForm['_Type']."'");

						

						if(is_array($result) && count($result) > 0)

						{

							$mySession->errorMsg="Scheme title already exists.";

							

						} else {

							$Data['title']=$dataForm['_Title'];

							$Data['scheme_type']=$dataForm['_Type'];

							$Data['timePeriod']=$dataForm['_TimePriod'];

							$Data['timePriodType']=$dataForm['_TPType'];

							$Data['installment']=$dataForm['_Installment'];

							$Data['agent_commission']=$dataForm['_AgentCommition'];

							$Data['noOfInstallment']=$dataForm['_NoOfInst'];

							$Data['ReturnAmount']=$dataForm['_ReturnAmount'];

							$Data['created_on']=date('Y-m-d h:i:s');

							$Data['lastupdate']=date('Y-m-d h:i:s');

							$Data['created_by']=$mySession->user['userId'];

							$Data['updated_by']=$mySession->user['userId'];

							$Data['sms_status']=1;

							

							$insertdata=$modelobj->insertThis($Data);

							$mySession->errorMsg="New Scheme has been added successfully";

							$this->_redirect('scheme/index');

						}

					}

				}

			}

		}else{

			$this->_redirect('index');

		}

		 

	}

	

	public function deleteAction()
	{

	global $mySession;

	$db=new Db();

	$schemId= $this->getRequest()->getParam('schemId');

	$condition="schemId='".$schemId."'";

	$db->delete('rbi_scheme',$condition);

	$mySession->errorMsg="Scheme has been deleted successfully";

	$this->_redirect('scheme/index');

	}

	public function changestatusAction()

	{

	global $mySession;

	$schemId= $this->getRequest()->getParam('schemId');

	$status= $this->getRequest()->getParam('status');

	$db=new Db();

	if($status==0)

	{

	$Updatestatus=1;

	}

	else

	{

	$Updatestatus=0;

	}	

	$mydata =array('status' => $Updatestatus);	

	$where="schemId='".$schemId."'";

	$db->modify('rbi_scheme',$mydata,$where);	

	$mySession->errorMsg="Scheme status changed successfully";			

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

				

				$request = $this->getRequest();

				if ($this->getRequest()->isPost()) 

				{

					$dataForm = $this->_request->getPost();		

					if ($form->isValid($dataForm))

					{										

					

						$result=$modelobj->runThisQuery("select * from rbi_scheme where title='".$dataForm['_Scheme']."' and scheme_type='".$dataForm['_Type']."' and schemId!='".$dataForm['fid']."'");

						

						if(is_array($result) && count($result) > 0)

						{

							$mySession->errorMsg="Scheme name already exists.";

							

						} else {

							$Data['title']=$dataForm['_Title'];

							$Data['scheme_type']=$dataForm['_Type'];

							$Data['timePeriod']=$dataForm['_TimePriod'];

							$Data['timePriodType']=$dataForm['_TPType'];

							$Data['installment']=$dataForm['_Installment'];

							$Data['agent_commission']=$dataForm['_AgentCommition'];

							$Data['noOfInstallment']=$dataForm['_NoOfInst'];

							$Data['ReturnAmount']=$dataForm['_ReturnAmount'];							

							$Data['lastupdate']=date('Y-m-d h:i:s');							

							$Data['updated_by']=$mySession->user['userId'];

							$Data['sms_status']=1;

							

							$where="schemId='".$dataForm['fid']."'";

							$insertdata=$modelobj->updateThis($Data,$where);

							$mySession->errorMsg="Scheme has been updated successfully";

							$this->_redirect('scheme/index');

						}

					}

				}

			}

		}else{

			$this->_redirect('index');

		}

	

	}

	

}

?>

