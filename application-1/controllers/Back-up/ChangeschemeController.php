<?php
class ChangeschemeController extends Zend_Controller_Action
{	
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		if($mySession->user['userRole']=='C' || $mySession->user['userRole']=='AG')
		{ 	
			$this->_redirect('index');	
		}
			
		
	}
	public function setagidAction() {
	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry = "select * from rbi_user where userid in(4770,4773,4774,4775,4776)";
		$cust = $db->runQuery($qry);
		if(is_array($cust) && count($cust) > 0)
		{
			foreach($cust as $user)
			{
				$agid = $this->getagid($user['temp_c_agentcode']);
				
				$data = array();
				$data['agentId'] = $agid;
				$condition  = "userId='".$user['userid']."'";
				$db->modify('rbi_user_customer',$data,$condition);
			}
		}
		
	exit;	
	}
	function getagid($agpid) {
		
		$db=new Db();
		echo '<br>'.$qry = "SELECT userId "
						." FROM rbi_agent AS b "
						." Where b.old_profileid='".$agpid."' ";
		$staterecord1 = $db->runQuery($qry);
		if(count($staterecord1) > 0) {
			
			return $staterecord1[0]['userId'];
		} else {
			return 0;
		}
		
	}
	public function setanameAction() {
	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry = "select userId, agentId, branchId from rbi_user_customer where bname='' limit 0, 20";
		
		$cust = $db->runQuery($qry);
		if(is_array($cust) && count($cust) > 0)
		{
			foreach($cust as $user)
			{
				$aginfo = $db->runQuery("select concat(fname,' ',lname) as aname, profileId from rbi_user where userid='".$user['agentId']."'");
				$brinfo = $db->runQuery("select fname as bname, profileId from rbi_user where userid='".$user['branchId']."'");
				
				$data = array();
				echo $data['aname']=$aginfo[0]['aname'];
				$data['bname']=$brinfo[0]['bname'];
				
				$data['aprofileid']=$aginfo[0]['profileId'];
				$data['bprofileid']=$brinfo[0]['profileId'];
				$condition = "userId='".$user['userId']."'";
				$db->modify('rbi_user_customer', $data, $condition);
			}
			echo "<script>window.location='http://localhost/sites/amardeep/changescheme/setaname';</script>";	
		}
		exit;
		
	}
	public function delinstAction()
	{ 
		$db=new Db();
		
		$temprec = $db->runQuery("select * from temp_inst_cust where status='13' limit 0,1");
		$qry = "select s.*, u.userbranch, DATE_FORMAT(u.created_on, '%Y-%m-%d') as date_of_reg from rbi_user_to_scheme as s inner join rbi_user as u on(u.userid=s.userid) where u.profileId='".$temprec[0]['profileid']."' limit 0, 1";
				
		$custarr = $db->runQuery($qry);
		if(is_array($custarr) && count($custarr) > 0) {
			$cnd = "user_schemeId='".$custarr[0]['user_schemeid']."'";
			$db->delete('rbi_user_scheme_installment',$cnd);
			$db->delete('rbi_user_scheme_installment_paid',$cnd);
			//echo '<br>'.$schemeData['noOfInstallment'];
			
			$data = array();

			$data['status']='12';
			$condition = "id='".$temprec[0]['id']."'";
			echo $db->modify('temp_inst_cust',$data,$condition);
		
			echo "<script>window.location='http://localhost/sites/amardeep/changescheme/delinst';</script>";
		exit;
		}
	}
	public function setinstallmentAction()
	{ 
	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		$limit = 10;
		echo '<br>';
		//echo $qry = "select s.*, DATE_FORMAT(u.created_on, '%Y-%m-%d') as date_of_reg from rbi_user_to_scheme as s inner join rbi_user as u on(u.userid=s.userid) where u.userid > 4768 and s.gen_inst=0 limit 0, 1";
		//$temprec = $db->runQuery($qry);
		//$temprec = $db->runQuery("select * from temp_inst_cust where status='12' limit 0,1");
		//print_r($temprec);
		//exit;
		//if(is_array($temprec) && count($temprec) > 0) {
		echo $qry = "select s.*, u.userbranch, DATE_FORMAT(u.created_on, '%Y-%m-%d') as date_of_reg from rbi_user_to_scheme as s inner join rbi_user as u on(u.userid=s.userid) where s.gen_inst=0 limit 0, 1";
				
		$custarr = $db->runQuery($qry);
		if(is_array($custarr) && count($custarr) > 0) {
		foreach($custarr as $schemeData) {
			$UsertoSchemeId = $schemeData['user_schemeid'];
			$UserId = $schemeData['userid'];
			$date_of_reg = $schemeData['date_of_reg'];
			
			echo '<br>'.$qry="select uc.userId, ua.userId as agentId
				from `rbi_user_customer` as uc
				inner join rbi_agent as ua on (uc.agentId=ua.userId) 					
				 where uc.userId='".$schemeData['userid']."' ";
				 ////inner join rbi_employee as ue on (if(uc.agentId=23 and uc.noagentempid!=0, ue.userId=uc.noagentempid, ue.userId=ua.employeeId))
			$rec_branch_emp = $db->runQuery($qry);
			//$cnd = "user_schemeId='".$schemeData['user_schemeid']."'";
			//$db->delete('rbi_user_scheme_installment',$cnd);
			//echo '<br>'.$schemeData['noOfInstallment'];
			
			for($i=1;$i<=$schemeData['noOfInstallment'];$i++)
			{
				if($i==1)
				{
					$installmentDueDate = $schemeData['date_of_reg'];
				$installmentStatus="0";
				$receiptno=0;
				
				//$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid where user_installment_Id!='".@$dataForm['pinsid']."'";
										
					$transactionno=0;
				
				}
				else
				{
					$installmentStatus="0";
					$receiptno="0";
					$installmentPaidOn="";
					$installmentPaidBy="";
					$transactionno=0;
						$periodType="";
						if($schemeData['timePriodType']=='0')
						$periodType="DAY";
						if($schemeData['timePriodType']=='1')
						$periodType="MONTH";
						if($schemeData['timePriodType']=='2')
						$periodType="YEAR";
						
						$DueDate=$db->runQuery("SELECT DATE_ADD('".$installmentDueDate."', INTERVAL ".$schemeData['timePeriod']." ".$periodType.") as dueDate");
						$installmentDueDate=$DueDate[0]['dueDate'];
				}
				//'empId'=>$rec_branch_emp[0]['employeeId'],
				$mydata3 =array('user_schemeId'=>$UsertoSchemeId,
				'receiptno'=>$receiptno,
				'transactionno'=>$transactionno,
				'instno'=>$i,
				'userId'=>$UserId,
				'agentId'=>$rec_branch_emp[0]['agentId'],
				'branchId'=>$schemeData['userbranch'],				
				'InstallmentAmount'=>$schemeData['installment'],
				'InstallmentDueDate'=>$installmentDueDate,
				'AgentCommission'=>$schemeData['agent_commission'],
				'Installment_status'=>$installmentStatus);
				if($schemeData['timePriodType']=='0')
				{
					echo  '<br>'.$Result=$db->save('rbi_user_scheme_installment_daily',$mydata3);
				} else {
					echo  '<br>'.$Result=$db->save('rbi_user_scheme_installment',$mydata3);
				}
				
				
				$inst_unique_id = $db->lastInsertId();
				if($receiptno) {
				/*$lastid = $db->lastInsertId();
					$expire_condition = "recno='".$receiptno."'";
					$expireDataArray =array('user_inst_Id'=>$lastid);
					$Resultx=$db->modify('rbi_receipt',$expireDataArray,$expire_condition);*/
				}
				if($installmentStatus) {
					//--1=agent id, 2=Transactino Type, 3= Intallment Id, 4=Customer id, 5=$amount, 6=Credit Date, 7=Receipt No., 8=Scheme Id
					//echo $dataForm['agent_Id'].',1,'.$Result.','.$UserId.','.$schemeData['installment'].','.$installmentDueDate.','.$receiptno.','.$dataForm['scheme_Id'];
	//				exit;
					//agentamount_entry($dataForm['agent_Id'],1,$inst_unique_id,$UserId,$schemeData['installment'],$installmentDueDate,$receiptno,$dataForm['scheme_Id']);
				}
			}
			$intv = '1';
			if($schemeData['timePriodType']=='2') {
				$intv = '1.1';
			}
			if($schemeData['timePriodType']=='3') {
				$intv = ($schemeData['timePeriod'])+(0.1);			
			}
			
			$DueDate=$db->runQuery("SELECT DATE_ADD('".$installmentDueDate."', INTERVAL ".$intv." YEAR_MONTH) as dueDate");
			$expDate=$DueDate[0]['dueDate'];
						
			$expire_condition = "user_schemeid='".$UsertoSchemeId."'";
			$expireDataArray =array('expire_on'=>$expDate,'created_on'=>$date_of_reg,'gen_inst'=>1);
			$Result=$db->modify('rbi_user_to_scheme',$expireDataArray,$expire_condition);
		}
		//$this->_redirect('changescheme/setinstallment');
		/*$data = array();

			$data['status']='14';
			$condition = "id='".$temprec[0]['id']."'";
			$db->modify('temp_inst_cust',$data,$condition);*/
			
			
		/*echo "<script>window.location='http://localhost/sites/amardeep/changescheme/setinstallment';</script>";*/
		
		} else {
			$data = array();

			$data['status']='15';
			//$condition = "id='".$temprec[0]['id']."'";
			//$db->modify('temp_inst_cust',$data,$condition);
		}
		
		
		echo "<script>window.location='http://localhost/sites/amardeep/changescheme/setinstallment';</script>";
		//}
		exit;
	}
	function regen_installment($userid,$extinst=0)
	{ 
	
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		
		$limit = 10;
		echo '<br>';
		//echo $qry = "select s.*, DATE_FORMAT(u.created_on, '%Y-%m-%d') as date_of_reg from rbi_user_to_scheme as s inner join rbi_user as u on(u.userid=s.userid) where u.userid > 4768 and s.gen_inst=0 limit 0, 1";
		//$temprec = $db->runQuery($qry);
		//$temprec = $db->runQuery("select * from temp_inst_cust where status='12' limit 0,1");
		//print_r($temprec);
		//exit;
		//if(is_array($temprec) && count($temprec) > 0) {
		$condition = "userid = '".$userid."'";
		$db->delete('rbi_user_scheme_installment',$condition);
		$db->delete('rbi_user_scheme_installment_paid',$condition);	
			
		$qry = "select s.*, u.userbranch, DATE_FORMAT(u.created_on, '%Y-%m-%d') as date_of_reg from rbi_user_to_scheme as s inner join rbi_user as u on(u.userid=s.userid) where u.userid ='".$userid."' limit 0, 1";
				
		$custarr = $db->runQuery($qry);
		if(is_array($custarr) && count($custarr) > 0) {
		foreach($custarr as $schemeData) {
			$UsertoSchemeId = $schemeData['user_schemeid'];
			$UserId = $schemeData['userid'];
			$date_of_reg = $schemeData['date_of_reg'];
			
			$qry="select uc.userId, ua.userId as agentId
				from `rbi_user_customer` as uc
				inner join rbi_agent as ua on (uc.agentId=ua.userId) 					
				 where uc.userId='".$schemeData['userid']."' ";
				 ////inner join rbi_employee as ue on (if(uc.agentId=23 and uc.noagentempid!=0, ue.userId=uc.noagentempid, ue.userId=ua.employeeId))
			$rec_branch_emp = $db->runQuery($qry);
			//$cnd = "user_schemeId='".$schemeData['user_schemeid']."'";
			//$db->delete('rbi_user_scheme_installment',$cnd);
			//echo '<br>'.$schemeData['noOfInstallment'];
			if($extinst > $schemeData['noOfInstallment']) { $schemeData['noOfInstallment']=$extinst; }
			//echo '<br><br>sssss'.$schemeData['noOfInstallment'].'<br><br>'; exit;
			for($i=1;$i<=$schemeData['noOfInstallment'];$i++)
			{
				if($i==1)
				{
					$installmentDueDate = $schemeData['date_of_reg'];
				$installmentStatus="0";
				$receiptno=0;
				
				//$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid where user_installment_Id!='".@$dataForm['pinsid']."'";
										
					$transactionno=0;
				
				}
				else
				{
					$installmentStatus="0";
					$receiptno="0";
					$installmentPaidOn="";
					$installmentPaidBy="";
					$transactionno=0;
						$periodType="";
						if($schemeData['timePriodType']=='0')
						$periodType="DAY";
						if($schemeData['timePriodType']=='1')
						$periodType="MONTH";
						if($schemeData['timePriodType']=='2')
						$periodType="YEAR";
						
						$DueDate=$db->runQuery("SELECT DATE_ADD('".$installmentDueDate."', INTERVAL ".$schemeData['timePeriod']." ".$periodType.") as dueDate");
						$installmentDueDate=$DueDate[0]['dueDate'];
				}
				//'empId'=>$rec_branch_emp[0]['employeeId'],
				$mydata3 =array('user_schemeId'=>$UsertoSchemeId,
				'receiptno'=>$receiptno,
				'transactionno'=>$transactionno,
				'instno'=>$i,
				'userId'=>$UserId,
				'agentId'=>$rec_branch_emp[0]['agentId'],
				'branchId'=>$schemeData['userbranch'],				
				'InstallmentAmount'=>$schemeData['installment'],
				'InstallmentDueDate'=>$installmentDueDate,
				'AgentCommission'=>$schemeData['agent_commission'],
				'Installment_status'=>$installmentStatus);
				$Result=$db->save('rbi_user_scheme_installment',$mydata3);
				
				$inst_unique_id = $db->lastInsertId();
				if($receiptno) {
				/*$lastid = $db->lastInsertId();
					$expire_condition = "recno='".$receiptno."'";
					$expireDataArray =array('user_inst_Id'=>$lastid);
					$Resultx=$db->modify('rbi_receipt',$expireDataArray,$expire_condition);*/
				}
				if($installmentStatus) {
					//--1=agent id, 2=Transactino Type, 3= Intallment Id, 4=Customer id, 5=$amount, 6=Credit Date, 7=Receipt No., 8=Scheme Id
					//echo $dataForm['agent_Id'].',1,'.$Result.','.$UserId.','.$schemeData['installment'].','.$installmentDueDate.','.$receiptno.','.$dataForm['scheme_Id'];
	//				exit;
					//agentamount_entry($dataForm['agent_Id'],1,$inst_unique_id,$UserId,$schemeData['installment'],$installmentDueDate,$receiptno,$dataForm['scheme_Id']);
				}
			}
			$intv = '1';
			if($schemeData['timePriodType']=='2') {
				$intv = '1.1';
			}
			if($schemeData['timePriodType']=='3') {
				$intv = ($schemeData['timePeriod'])+(0.1);			
			}
			
			$DueDate=$db->runQuery("SELECT DATE_ADD('".$installmentDueDate."', INTERVAL ".$intv." YEAR_MONTH) as dueDate");
			$expDate=$DueDate[0]['dueDate'];
						
			$expire_condition = "user_schemeid='".$UsertoSchemeId."'";
			$expireDataArray =array('expire_on'=>$expDate,'created_on'=>$date_of_reg,'gen_inst'=>1);
			$Result=$db->modify('rbi_user_to_scheme',$expireDataArray,$expire_condition);
		}
		//$this->_redirect('changescheme/setinstallment');
		/*$data = array();

			$data['status']='14';
			$condition = "id='".$temprec[0]['id']."'";
			$db->modify('temp_inst_cust',$data,$condition);*/
			
			
		/*echo "<script>window.location='http://localhost/sites/amardeep/changescheme/setinstallment';</script>";*/
		
		} else {
			$data = array();

			$data['status']='15';
			//$condition = "id='".$temprec[0]['id']."'";
			//$db->modify('temp_inst_cust',$data,$condition);
		}
		
		
		/*echo "<script>window.location='http://localhost/sites/amardeep/changescheme/setinstallment';</script>";*/
		//}
		
	}
	public function transfertopaidAction()
	{
		$obj_x = new Model_Mainmodel();	
		$a = $obj_x->transfertopaid();
		if($a) {	echo "<script>window.location='http://localhost/sites/amardeep/changescheme/transfertopaid';</script>"; }
			
		
		
		exit;
	}
	public function paydailyinstAction()
	{
		$db= new Db();
		//echo $qry = "select * from temp_inst_cust where is_daily='1' and status='0' and chk='0' and filename like 'rest%' limit 0, 1";
		echo $qry = "select * from temp_inst_cust where is_daily='1' and status='513' and chk='0' limit 0, 1";
		$cust = $db->runQuery($qry);
		if(is_array($cust) && count($cust) > 0)
		{
		
			foreach($cust as $c) {
			
				//echo "select userid from rbi_user where profileId='".$c['profileid']."'";
				$custdetail = $db->runQuery("select userid from rbi_user where profileId='".$c['profileid']."'");
				if($custdetail[0]['userid']) {
				
				} else {
					$custdetail[0]['userid']='0';
				}
				
					echo "select * from rbi_user_scheme_installment_daily where userId='".$custdetail[0]['userid']."' order by instno";
					$custinst = $db->runQuery("select * from rbi_user_scheme_installment_daily where userId='".$custdetail[0]['userid']."' order by instno");
					echo '<br>';
					if($custinst['0']['instno']=='2') {
						//echo "select * from temp_inst_daily_detail where pid='".$c['id']."' and status='0' order by transactionno";
						//exit;
						//echo "select sum(numinst) si from temp_inst_daily_detail where pid='".$c['id']."' and status='0'";
						//echo "<br>select count(numinst) as cnt from temp_inst_daily_detail where pid='".$c['id']."' and numinst=0 and status='0'";
						$paidinstcount = $db->runQuery("select sum(numinst) si from temp_inst_daily_detail where pid='".$c['id']."' and status='0'");
						$instcount = $db->runQuery("select noOfInstallment from rbi_user_to_scheme where userid='".$custdetail[0]['userid']."'");
						
						
						$paidinstcountzero = $db->runQuery("select count(numinst) as cnt from temp_inst_daily_detail where pid='".$c['id']."' and numinst=0 and status='0'");
						$totalinst_intemp = $paidinstcount[0]['si']+$paidinstcountzero[0]['cnt'];
						//echo "select * from temp_inst_daily_detail where pid='".$c['id']."' order by transactionno";
						//exit;
						$paidinst = $db->runQuery("select * from temp_inst_daily_detail where pid='".$c['id']."' order by transactionno");
						//echo $totalinst_intemp.'  '.count($custinst).'   ----    '.$instcount[0]['noOfInstallment']; exit;
						if($totalinst_intemp > count($custinst)) {
							$data = array();
							$data['chk']='1';
							$data['status']='516';
							$condition = "id='".$c['id']."'";
							$db->modify('temp_inst_cust',$data,$condition);
						} else {
						if(is_array($paidinst) && count($paidinst) > 0) {
							$i=0;
							$finst = 10;
							$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid ";
							$maxidresult=$db->runQuery("$qry");	///print_r($dataForm);
						
							if($maxidresult[0]['maxrecno'] < 8000) { $maxid =8000; } else { $maxid =$maxidresult[0]['maxrecno']; }
							$k=0;
							
							foreach($paidinst as $pinst)
							{
								//echo '<br>Update '.$c['profileid'].' -- '.$pinst['installment'].'--'.$pinst['duedate'].' ||\/|| '.$custinst[$i]['InstallmentAmount'].' -- '.$custinst[$i]['InstallmentDueDate'];
								//if($pinst['duedate']==$custinst[$i]['InstallmentDueDate'])
								//{
								if($i==0) {
									$finst=$pinst['paid'];
								}
								
								
									$data = array();
									if($pinst['numinst']) { 
										$data['status']='1'; 
									} else {
										$data['status']='2'; 
									}
									$condition = "pid='".$c['id']."'";
									$db->modify('temp_inst_daily_detail',$data,$condition);
									
									$data = array();
									$data['fill']='1';
									$condition = "id='".$c['id']."'";
									$db->modify('temp_inst_cust',$data,$condition);
									
									if($pinst['numinst'] < 2) {
										$totinst = 1;
										$instids = $custinst[$i]['user_installment_Id'];
										$i++;
									} else {
										$totinst = $pinst['numinst'];
										$instidarr = array();
										for($m = 0; $m < $totinst;$m++)
										{
											$instidarr[] = $custinst[$i]['user_installment_Id'];
											$i++;
										}
										$instids = implode(",",$instidarr);
									}
									
									$data = array();
									$data['Installment_Paidon'] = $pinst['paydate'];
									$data['transactionno'] = $maxid+$k;
									if($pinst['numinst']==0) {
										$data['PaniltyAmount'] = $pinst['paid']-$finst;
									}
									$data['payamt'] = $pinst['paid'];
									$data['Installment_status'] = '1';
									$data['receiptno'] = $pinst['receiptno'];
									
									$condition = "user_installment_Id in (".$instids.")";
									$db->modify('rbi_user_scheme_installment_daily',$data,$condition);
								//s}
								/*$data = array();
								$data['Installment_Paidon'] = '';
								$data['PaniltyAmount'] = '';
								$data['Installment_status'] = '';
								$data['Installment_Paidon'] = '';*/
								$k++;
								
							}
							$data = array();
							$data['chk']='1';
							$data['status']='501';
							$data['fill']='1';
							$condition = "id='".$c['id']."'";
							$db->modify('temp_inst_cust',$data,$condition);
							
							$obj_x = new Model_Mainmodel();	
							$a = $obj_x->transfertopaid();
						} else {
							$data = array();
							$data['status']='504';
							$data['chk']='1';
							$condition = "id='".$c['id']."'";
							$db->modify('temp_inst_cust',$data,$condition);
						}
						
						
							
						} 
					} else {
						$data = array();
						$data['chk']='1';
						$data['status']='515';
						$condition = "id='".$c['id']."'";
						$db->modify('temp_inst_cust',$data,$condition);
					}
					
			}					
				
			echo "<script>window.location='http://localhost/sites/amardeep/changescheme/paydailyinst';</script>";
		}
		
		exit;
	}
	public function paynewdailyinstAction()
	{
		$db= new Db();
		//echo $qry = "select * from tempz_inst_cust where is_daily='1' and status='0' and chk='0' and filename like 'rest%' limit 0, 1";
		echo $qry = "select * from tempz_inst_cust where filename like 'march_cust%' and chk='0'  limit 0, 1";
		$cust = $db->runQuery($qry);
		if(is_array($cust) && count($cust) > 0)
		{
		
			foreach($cust as $c) {
			
				echo "select userid from rbi_user where profileId='".$c['profileid']."'";
				$custdetail = $db->runQuery("select userid from rbi_user where profileId='".$c['profileid']."'");
				if($custdetail[0]['userid']) {
				
				} else {
					$custdetail[0]['userid']='0';
				}
					$paidinstcount = $db->runQuery("select sum(numinst) si from tempz_inst_daily_detail where pid='".$c['id']."' and status='0'");
					$paidinstcountzero = $db->runQuery("select count(numinst) as cnt from tempz_inst_daily_detail where pid='".$c['id']."' and numinst=0 and status='0'");
					$totalinst_intemp = $paidinstcount[0]['si']+$paidinstcountzero[0]['cnt'];
					
					$this->regen_installment($custdetail[0]['userid'],$totalinst_intemp);
					echo "select * from rbi_user_scheme_installment_daily where userId='".$custdetail[0]['userid']."' order by instno";
					$custinst = $db->runQuery("select * from rbi_user_scheme_installment_daily where userId='".$custdetail[0]['userid']."' order by instno");
					echo '<br>';
					if($custinst['0']['instno']=='1') {
						//echo "select * from tempz_inst_daily_detail where pid='".$c['id']."' and status='0' order by transactionno";
						//exit;
						//echo "select sum(numinst) si from temp_inst_daily_detail where pid='".$c['id']."' and status='0'";
						//echo "<br>select count(numinst) as cnt from temp_inst_daily_detail where pid='".$c['id']."' and numinst=0 and status='0'";
												
						//echo "<br>select sum(numinst) si from tempz_inst_daily_detail where pid='".$c['id']."' and status='0'";
						$instcount = $db->runQuery("select noOfInstallment from rbi_user_to_scheme where userid='".$custdetail[0]['userid']."'");
						
						
						
						
						//echo "select * from temp_inst_daily_detail where pid='".$c['id']."' order by transactionno";
						//exit;
						$paidinst = $db->runQuery("select * from tempz_inst_daily_detail where pid='".$c['id']."' order by paydate");
						//echo $totalinst_intemp.'  '.count($custinst).'   ----    '.$instcount[0]['noOfInstallment']; exit;
						if($totalinst_intemp > count($custinst)) {
							$data = array();
							$data['chk']='1';
							$data['status']='516';
							$condition = "id='".$c['id']."'";
							$db->modify('tempz_inst_cust',$data,$condition);
						} else {
						if(is_array($paidinst) && count($paidinst) > 0) {
							$i=0;
							$finst = 10;
							$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid ";
							$maxidresult=$db->runQuery("$qry");	///print_r($dataForm);
						
							if($maxidresult[0]['maxrecno'] < 8000) { $maxid =8000; } else { $maxid =$maxidresult[0]['maxrecno']; }
							$k=0;
							
							foreach($paidinst as $pinst)
							{
								//echo '<br>Update '.$c['profileid'].' -- '.$pinst['installment'].'--'.$pinst['duedate'].' ||\/|| '.$custinst[$i]['InstallmentAmount'].' -- '.$custinst[$i]['InstallmentDueDate'];
								//if($pinst['duedate']==$custinst[$i]['InstallmentDueDate'])
								//{
								if($i==0) {
									$finst=$pinst['paid'];
								}
								
								
									$data = array();
									if($pinst['numinst']) { 
										$data['status']='1'; 
									} else {
										$data['status']='2'; 
									}
									$condition = "pid='".$c['id']."'";
									$db->modify('tempz_inst_daily_detail',$data,$condition);
									
									$data = array();
									$data['fill']='1';
									$condition = "id='".$c['id']."'";
									$db->modify('tempz_inst_cust',$data,$condition);
									
									if($pinst['numinst'] < 2) {
										$totinst = 1;
										$instids = $custinst[$i]['user_installment_Id'];
										$i++;
									} else {
										$totinst = $pinst['numinst'];
										$instidarr = array();
										for($m = 0; $m < $totinst;$m++)
										{
											$instidarr[] = $custinst[$i]['user_installment_Id'];
											$i++;
										}
										$instids = implode(",",$instidarr);
									}
									
									$data = array();
									$data['Installment_Paidon'] = $pinst['paydate'];
									$data['receiptdt'] = $pinst['paydate'];
									$data['transactionno'] = $maxid+$k;
									if($pinst['numinst']==0) {
										$data['PaniltyAmount'] = $pinst['paid']-$finst;
									}
									$data['payamt'] = $pinst['paid'];
									$data['Installment_status'] = '1';
									$data['receiptno'] = $pinst['receiptno'];
									
									$condition = "user_installment_Id in (".$instids.")";
									$db->modify('rbi_user_scheme_installment_daily',$data,$condition);
								//s}
								/*$data = array();
								$data['Installment_Paidon'] = '';
								$data['PaniltyAmount'] = '';
								$data['Installment_status'] = '';
								$data['Installment_Paidon'] = '';*/
								$k++;
								
							}
							$data = array();
							$data['chk']='1';
							$data['status']='501';
							$data['fill']='1';
							$condition = "id='".$c['id']."'";
							$db->modify('tempz_inst_cust',$data,$condition);
							
							$obj_x = new Model_Mainmodel();	
							$a = $obj_x->transfertopaid();
						} else {
							$data = array();
							$data['status']='504';
							$data['chk']='1';
							$condition = "id='".$c['id']."'";
							$db->modify('tempz_inst_cust',$data,$condition);
						}
						
						
							
						} 
					} else {
						$data = array();
						$data['chk']='1';
						$data['status']='515';
						$condition = "id='".$c['id']."'";
						$db->modify('tempz_inst_cust',$data,$condition);
					}
					
			}					
			//exit;	
			echo "<script>window.location='http://localhost/sites/amardeep/changescheme/paynewdailyinst';</script>";
		}
		
		exit;
	}
	public function paynewdailyinst2Action()
	{
		$db= new Db();
		$obj_x = new Model_Mainmodel();	
		
			$qry = "select * from tempx_inst_daily_detail where chk='0' order by paydate limit 0, 1";
			$paidinst = $db->runQuery($qry);
			//prd($paidinst);
			$i=0;
			$finst = 10;
			$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid ";
			$maxidresult=$db->runQuery("$qry");	///print_r($dataForm);
		
			if($maxidresult[0]['maxrecno'] < 8000) { $maxid =8000; } else { $maxid =$maxidresult[0]['maxrecno']; }
			$k=0;
			
			foreach($paidinst as $pinst)
			{
				
					$getuserid = $db->runQuery("select userid from rbi_user where profileId='".$pinst['profileid']."'");
					$userid  = $getuserid[0]['userid'];
					//prd($getuserid);
					if($userid) {
					$chk = $db->runQuery("select user_installment_Id from rbi_user_scheme_installment_paid where userid='".$userid."' and Installment_Paidon like '".$pinst['paydate']."%'");
					pr($chk);
					if(is_array($chk) && count($chk) > 0) { 
						$data = array();
						
						$data['chk']='5';							
						$condition = "id='".$pinst['id']."'";
						$db->modify('tempx_inst_daily_detail',$data,$condition);	
						//exit;			
					} else {
					//echo 'ssss';
					//exit;
						$finst=$pinst['paid'];
						
						$custinst = $db->runQuery("select * from rbi_user_scheme_installment_daily where userId='".$userid."' order by instno");
						$vp_status=1;
						if($pinst['numinst'] < 2) {
							$totinst = 1;
							$instids = $custinst[$i]['user_installment_Id'];
							$i++;
						} else {
							$instamt = $custinst[0]['InstallmentAmount'];	
							$virtual_pay = 	$instamt*$pinst['numinst'];
							if($virtual_pay!=$pinst['paid'])
							{
								if($virtual_pay < $pinst['paid'])
								{
								    $vp_status=3;
									$gp = $virtual_pay - $pinst['paid'];
									$pinst['numinst']=$pinst['numinst']-1;
								} else {
									$vp_status=2;
									$gp = $virtual_pay - $pinst['paid'];
									
									$pinst['numinst']=$pinst['numinst']-1;
								}
							}
							$totinst = $pinst['numinst'];
							$instidarr = array();
							for($m = 0; $m < $totinst;$m++)
							{
								$instidarr[] = $custinst[$i]['user_installment_Id'];
								$i++;
							}
							if($vp_status==2 || $vp_status==3)
							{
								$ext_instid = $custinst[$i]['user_installment_Id'];
								$i++;
							} 
							$instids = implode(",",$instidarr);
						}
						
						$data = array();
						$data['Installment_Paidon'] = $pinst['paydate'];
						$data['receiptdt'] = $pinst['paydate'];
						$data['transactionno'] = $maxid+$k;
						if($pinst['numinst']==0) {
							//$data['PaniltyAmount'] = $pinst['paid']-$finst;
						}
						$data['payamt'] = $pinst['paid'];
						$data['Installment_status'] = '1';
						$data['receiptno'] = $pinst['receiptno'];
						
						$condition = "user_installment_Id in (".$instids.")";
						$db->modify('rbi_user_scheme_installment_daily',$data,$condition);
						
						if($vp_status==2)
						{ 
							$data = array();
							$data['Installment_Paidon'] = $pinst['paydate'];
							$data['receiptdt'] = $pinst['paydate'];
							$data['transactionno'] = $maxid+$k;
							if($pinst['numinst']==0) {
								//$data['PaniltyAmount'] = $pinst['paid']-$finst;
							}
							$data['halfdue'] = $gp;
							$data['InstallmentAmount'] = $custinst[0]['InstallmentAmount']-$gp;
							
							$data['payamt'] = $pinst['paid'];
							$data['Installment_status'] = '1';
							$data['receiptno'] = $pinst['receiptno'];
							
							$condition = "user_installment_Id in (".$ext_instid.")";
							$db->modify('rbi_user_scheme_installment_daily',$data,$condition);
						}
						if($vp_status==3)
						{ 
							$data = array();
							$data['Installment_Paidon'] = $pinst['paydate'];
							$data['receiptdt'] = $pinst['paydate'];
							$data['transactionno'] = $maxid+$k;
							if($pinst['numinst']==0) {
								//$data['PaniltyAmount'] = $pinst['paid']-$finst;
							}
							$data['halfdue'] = 0-$gp;
							$data['InstallmentAmount'] = $custinst[0]['InstallmentAmount']+$gp;
							
							$data['payamt'] = $pinst['paid'];
							$data['Installment_status'] = '1';
							$data['receiptno'] = $pinst['receiptno'];
							
							$condition = "user_installment_Id in (".$ext_instid.")";
							$db->modify('rbi_user_scheme_installment_daily',$data,$condition);
						}
						
						
						$data = array();						
						$data['chk']='1';							
						$condition = "id='".$pinst['id']."'";
						$db->modify('tempx_inst_daily_detail',$data,$condition);	
						
						
						$a = $obj_x->transfertopaid();
						}
					} else {
						$data = array();						
						$data['chk']='7';							
						$condition = "id='".$pinst['id']."'";
						$db->modify('tempx_inst_daily_detail',$data,$condition);
					}
				
						
				$k++;
				
			}
			if(is_array($paidinst) && count($paidinst) > 0 && 2==2)
			{
				echo "<script>window.location='http://localhost/sites/amardeep/changescheme/paynewdailyinst2';</script>";
			}
		
		
		exit;
	}
	public function setreceiptnoAction() {
		$db= new Db();
		$arr=$this->getRequest()->getParams();
		
		if(isset($arr['ino']) && $arr['ino'] > 0) {
			$ino = $arr['ino'];
		} else {
			$ino = 1;
		}
		$limit = 100;
		
		
		$trid = ((($ino-1)*$limit)+1)+1200000;
		$qry = "SELECT `userId`, `transactionno`, count(userid) as n FROM `rbi_user_scheme_installment_paid` WHERE `receiptno`='0' and transactionno!='0' group by `transactionno` order by Installment_Paidon limit 0, ".$limit;
		
		$getrec = $db->runQuery($qry);
		if(is_array($getrec) && count($getrec) > 0) {
			foreach($getrec as $rec)
			{
				$data=array();
				$data['receiptno']=$trid;
				$condition = "userId = '".$rec['userId']."' and transactionno='".$rec['transactionno']."'";
				$db->modify('rbi_user_scheme_installment_paid',$data,$condition);
				$trid++;
			}
			echo "<script>window.location='http://localhost/sites/amardeep/changescheme/setreceiptno/ino/".($ino+1)."';</script>";
		}
		exit;
	}
	public function settransactionidAction() {
		$db= new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry="select (max(transactionno)) as maxrecno from rbi_user_scheme_installment_paid";
			$maxidresult=$db->runQuery("$qry");
		$limit = 100;
		
		
		$trid = @$maxidresult[0]['maxrecno']+1;
		$qry = "SELECT `userId`, `receiptno`, count(userid) as n FROM `rbi_user_scheme_installment_paid` WHERE `transactionno`='0' and receiptno!='0' group by `receiptno` order by Installment_Paidon limit 0, ".$limit;
		
		$getrec = $db->runQuery($qry);
		if(is_array($getrec) && count($getrec) > 0) {
			foreach($getrec as $rec)
			{
				$data=array();
				$data['transactionno']=$trid;
				$condition = "userId = '".$rec['userId']."' and receiptno='".$rec['receiptno']."'";
				$db->modify('rbi_user_scheme_installment_paid',$data,$condition);
				$trid++;
			}
			echo "<script>window.location='http://localhost/sites/amardeep/changescheme/settransactionid/';</script>";
		}
		exit;
	}
	public function chkisschemeAction() {
		$db= new Db();
		$qry = "select * from rbi_user_customer where chk=0 limit 0, 30";
		$cust = $db->runQuery($qry);
		
		if(is_array($cust) && count($cust) > 0)
		{
		
			foreach($cust as $c) {
				$getscheme = $db->runQuery("select userid from rbi_user_to_scheme where userid='".$c['userId']."'");
				if(is_array($getscheme) && count($getscheme) >0) {
					$data = array();
					$data['chk']=1;
					
					$condition = "userid='".$c['userId']."'";
					
					echo '<br>';$db->modify('rbi_user_customer',$data,$condition);
				} else {
				echo "aaaa";
					$data = array();
					$data['chk']=1;
					
					$condition = "userid='".$c['userId']."'";
					
					$db->modify('rbi_user_customer',$data,$condition);
					
					$data = array();
					$data['userid']=$c['userId'];
										
					$db->save('temp_user_not_scheme',$data);
				}
			}
			/*echo "<script>window.location='http://localhost/sites/amardeep/changescheme/chkisscheme';</script>";*/
		}
		exit;
	}
	public function payinstAction()
	{
	exit;	//810,809,808,805,799,793,790,778,777,776,754,753,748,741,733,731,729,690,689,688,652,631,630,837,842,863,879,881,882,883,884,885,886,888,903,928,929,992,1001,1011,1012,1013,1014,1019,1020,1080,1081,1082,1083,1084,1085,1100,1103,1106,1108,1109,1262,1270,1358,1362,1369,1432,1433,1498,1544,1576,1610,2162,2163,2164,2165,2166,2170,2172,2173,2174,2175,2181,2189,2193,2194,2203,4247,4248,4249,4264,4272,4307,4311,2309,2316,2400,2479,2628,2632,2668,2710,2728,2810,2909,2964,2970,3015,3083,3097,3139,3162,3170,3173,3185,3212,3215,3217,3219,3221,4340,4341,3224,3347,3379,3417,1644,1726,1767,1806,1865,1872,1874,1980,1990,1991,1994,2004,2005,2014,2015,2022,2037,2050,2059,4402,4426,4453,4454,4455,4456,4457,4458,4459,4460,4461,4462,4463,4464,4465,4466,4467,4468,4469,4470,4471,4472,4473,4474,4475,4481,4482,4483,4484,4485,4486,4487,4489,4490,4491,4492,4493,4494,4502,4508,4510,4531,4556,4557,4560,4561,4563,4564,4565,4566,4568,4572,4573,4574,4575,4576,4577,4578,4585,4589,4593,4596,4603,4604,4605,4619,4620,4622,4624,4625,4632,4633,4634,4646,4655,4656,4657,4658,4659,4688,4694,4695,4697,4703,4704,4705,4706,4708,4719,3569,3844,3921,3922,3931,3935,4086,4092,4093,4098,4104,4118,4161,4162
		//731,1011,1019,1020,1103,2628,1644,4633
		
		$db= new Db();
		
		//$qry = "select * from temp_inst_cust where fill=0 and is_daily='2' and chk='0' and fill='0' and status='0' and filename like 'rest%' limit 0, 1";
		$qry = "select * from temp_inst_cust where chk ='0' and id not in (13,14) limit 0, 1";
		$cust = $db->runQuery($qry);
		if(is_array($cust) && count($cust) > 0)
		{
			foreach($cust as $c) {
				//echo "select userid from rbi_user where profileId='".$c['profileid']."'";
				$custdetail = $db->runQuery("select userid from rbi_user where profileId='".$c['profileid']."'");
				if($custdetail[0]['userid']) {
				
				} else {
					$custdetail[0]['userid']='0';
				}
				
					
					$custinst = $db->runQuery("select * from rbi_user_scheme_installment where userId='".$custdetail[0]['userid']."' order by instno");
					echo '<br>';
					if($custinst[0]['instno']=='1') {
					
						$paidinst = $db->runQuery("select * from temp_inst_detail where pid='".$c['id']."' and receiptno!='0' order by instno");
						if(is_array($paidinst) && count($paidinst) > 0) {
							$i=0;
							foreach($paidinst as $pinst)
							{
								echo '<br>Update '.$c['profileid'].' -- '.$pinst['installment'].'--'.$pinst['duedate'].' ||\/|| '.$custinst[$i]['InstallmentAmount'].' -- '.$custinst[$i]['InstallmentDueDate'];
								//if($pinst['duedate']==$custinst[$i]['InstallmentDueDate'])
								//{
									$data = array();
									$data['status']='1';
									$condition = "pid='".$c['id']."'";
									$db->modify('temp_inst_detail',$data,$condition);
									
									$data = array();
									$data['fill']='1';
									$condition = "id='".$c['id']."'";
									$db->modify('temp_inst_cust',$data,$condition);
									
									$data = array();
									$data['Installment_Paidon'] = $pinst['paydate'];
									$data['PaniltyAmount'] = $pinst['latefee'];
									$data['Installment_status'] = '1';
									$data['receiptno'] = $pinst['receiptno'];
									
									$condition = "user_installment_Id='".$custinst[$i]['user_installment_Id']."'";
									$db->modify('rbi_user_scheme_installment',$data,$condition);
								//s}
								/*$data = array();
								$data['Installment_Paidon'] = '';
								$data['PaniltyAmount'] = '';
								$data['Installment_status'] = '';
								$data['Installment_Paidon'] = '';*/
								
								$i++;
							}
							$data = array();
							$data['chk']='1';
							$data['fill']='1';
							$data['status']='201';
							$condition = "id='".$c['id']."'";
							$db->modify('temp_inst_cust',$data,$condition);
							$obj_x = new Model_Mainmodel();	
							$a = $obj_x->transfertopaid();
						} else {
							$data = array();
							$data['status']='204';
							$condition = "pid='".$c['id']."'";
							$db->modify('temp_inst_detail',$data,$condition);
						}
						
					} else{
						$data = array();
						$data['status']='202';
						$condition = "id='".$c['id']."'";
						$db->modify('temp_inst_cust',$data,$condition);
						
					}
			}
			
		echo "<script>window.location='http://localhost/sites/amardeep/changescheme/payinst';</script>";
		}
		
		exit;
	}
	public function payinst2Action()
	{
	//810,809,808,805,799,793,790,778,777,776,754,753,748,741,733,731,729,690,689,688,652,631,630,837,842,863,879,881,882,883,884,885,886,888,903,928,929,992,1001,1011,1012,1013,1014,1019,1020,1080,1081,1082,1083,1084,1085,1100,1103,1106,1108,1109,1262,1270,1358,1362,1369,1432,1433,1498,1544,1576,1610,2162,2163,2164,2165,2166,2170,2172,2173,2174,2175,2181,2189,2193,2194,2203,4247,4248,4249,4264,4272,4307,4311,2309,2316,2400,2479,2628,2632,2668,2710,2728,2810,2909,2964,2970,3015,3083,3097,3139,3162,3170,3173,3185,3212,3215,3217,3219,3221,4340,4341,3224,3347,3379,3417,1644,1726,1767,1806,1865,1872,1874,1980,1990,1991,1994,2004,2005,2014,2015,2022,2037,2050,2059,4402,4426,4453,4454,4455,4456,4457,4458,4459,4460,4461,4462,4463,4464,4465,4466,4467,4468,4469,4470,4471,4472,4473,4474,4475,4481,4482,4483,4484,4485,4486,4487,4489,4490,4491,4492,4493,4494,4502,4508,4510,4531,4556,4557,4560,4561,4563,4564,4565,4566,4568,4572,4573,4574,4575,4576,4577,4578,4585,4589,4593,4596,4603,4604,4605,4619,4620,4622,4624,4625,4632,4633,4634,4646,4655,4656,4657,4658,4659,4688,4694,4695,4697,4703,4704,4705,4706,4708,4719,3569,3844,3921,3922,3931,3935,4086,4092,4093,4098,4104,4118,4161,4162
		//731,1011,1019,1020,1103,2628,1644,4633
		
		$db= new Db();
		$obj_x = new Model_Mainmodel();	
		
		//$qry = "select * from temp_inst_cust where fill=0 and is_daily='2' and chk='0' and fill='0' and status='0' and filename like 'rest%' limit 0, 1";
		$qry = "select * from temp_old_coll where fill ='0' and mnth='2012-04-01' and rc!='' limit 0, 5";
		$cust = $db->runQuery($qry);
		if(is_array($cust) && count($cust) > 0)
		{
		$i=1;
			foreach($cust as $c) {
				//echo "select userid from rbi_user where profileId='".$c['profileid']."'";
				$custdetail = $db->runQuery("select userid from rbi_user where profileId='".$c['custcode']."'");
				if($custdetail[0]['userid']) {
					$chkplan = $db->runQuery("select timePriodType from rbi_user_to_scheme where userid='".$custdetail[0]['userid']."'");
					if($chkplan[0]['timePriodType'] > 0) {
						$custinst = $db->runQuery("select * from rbi_user_scheme_installment where userId='".$custdetail[0]['userid']."' order by instno");
						echo '<br>';
						
							
						$paydate_array = explode('/',$c['dt']);												
						
						if(count($paydate_array)==3) {
						$dt = trim($paydate_array[2]).'-'.$paydate_array[1].'-'.$paydate_array[1];
							$chkinst = $db->runQuery("select * from rbi_user_scheme_installment_paid where receiptno='".$c['rc']."' and userid='".$custdetail[0]['userid']."'");
							if(is_array($chkinst) && count($chkinst) > 0) {
								$data['fill']='9';
								$condition = "id='".$c['id']."'";
								$db->modify('temp_old_coll',$data,$condition);
							} else {
								$data = array();
								$data['Installment_Paidon'] = $dt;
								$data['PaniltyAmount'] = $c['lt'];
								$data['Installment_status'] = '1';
								$data['receiptno'] = $c['rc'];
								//pr($data);
								$condition = "user_installment_Id='".$custinst[0]['user_installment_Id']."'";
								
								$db->modify('rbi_user_scheme_installment',$data,$condition);
														
								$a = $obj_x->transfertopaid();
								
								$data = array();
								
								$data['fill']='1';
								$condition = "id='".$c['id']."'";
								$db->modify('temp_old_coll',$data,$condition);
							}
						} else {
							$data = array();
						
							$data['fill']='3';
							$condition = "id='".$c['id']."'";
							$db->modify('temp_old_coll',$data,$condition);
						}
				  } else {
					$data = array();
						
							$data['fill']='6';
							$condition = "id='".$c['id']."'";
							$db->modify('temp_old_coll',$data,$condition);
				  }
				} else {
					$data = array();
					$data['fill']='7';
					$condition = "id='".$c['id']."'";
					$db->modify('temp_old_coll',$data,$condition);
				}
			$i++;
			}			
				
		
			
		echo "<script>window.location='http://localhost/sites/amardeep/changescheme/payinst2';</script>";
		}
		
		exit;
	}
	public function payinst3Action()
	{
	
		
		$db= new Db();
		$obj_x = new Model_Mainmodel();	
		
		//$qry = "select * from temp_inst_cust where fill=0 and is_daily='2' and chk='0' and fill='0' and status='0' and filename like 'rest%' limit 0, 1";
		$qry = "select * from temp_old_coll where fill ='0' and mnthdt='2012-04-26' limit 0, 10";
		$cust = $db->runQuery($qry);
		
		$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid ";
		$maxidresult=$db->runQuery("$qry");	///print_r($dataForm);
	
		if($maxidresult[0]['maxrecno'] < 8000) { $maxid =8000; } else { $maxid =$maxidresult[0]['maxrecno']; }
		$k=0;
							
		if(is_array($cust) && count($cust) > 0)
		{
		$i=1;
			foreach($cust as $c) {
				echo '<br>--'.$c['custcode'].'--<br>';
				//echo "select userid from rbi_user where profileId='".$c['profileid']."'";
				$custdetail = $db->runQuery("select userid from rbi_user where profileId='".$c['custcode']."'");
				if($custdetail[0]['userid']) {
					$chkplan = $db->runQuery("select timePriodType, installment from rbi_user_to_scheme where userid='".$custdetail[0]['userid']."'");
					$dt = $c['mnthdt'];
					$paydate_array = explode('/',$c['dt']);
					if(count($paydate_array)==3) {
						$rcdt = trim($paydate_array[2]).'-'.$paydate_array[1].'-'.trim($paydate_array[0]);
					} else {
						$rcdt = '0000-00-00';
					}
					if($chkplan[0]['timePriodType'] > 0) {
						$custinst = $db->runQuery("select * from rbi_user_scheme_installment where userId='".$custdetail[0]['userid']."' order by instno");
						echo '<br>';
						
							
						$paydate_array = explode('/',$c['dt']);												
						
							
							$chkinst = $db->runQuery("select * from rbi_user_scheme_installment_paid where receiptno='".$c['rc']."' and userid='".$custdetail[0]['userid']."'");
							if(is_array($chkinst) && count($chkinst) > 0) {
								$data['fill']='9';
								$condition = "id='".$c['id']."'";
								$db->modify('temp_old_coll',$data,$condition);
							} else {
								$data = array();
								$data['Installment_Paidon'] = $dt;
								$data['PaniltyAmount'] = $c['lt'];
								$data['Installment_status'] = '1';
								$data['transactionno'] = $maxid+$k;
								$data['receiptno'] = $c['rc'];
								print_r($data);
								$condition = "user_installment_Id='".$custinst[0]['user_installment_Id']."'";
								
								$db->modify('rbi_user_scheme_installment',$data,$condition);
														
								$a = $obj_x->transfertopaid();
								
								$data = array();
								
								$data['fill']='1';
								$condition = "id='".$c['id']."'";
								$db->modify('temp_old_coll',$data,$condition);
							}
						
				  } else {
					
							//echo 'ssss';
							//exit;
								$finst=$c['inst'];
								
								$custinst = $db->runQuery("select * from rbi_user_scheme_installment_daily where userId='".$custdetail[0]['userid']."' order by instno");
								$vp_status=1;
								$pinst['numinst'] = number_format(($finst / $chkplan[0]['installment']));
								$instamt = $custinst[0]['InstallmentAmount'];	
								if($pinst['numinst'] < 2) {
									$totinst = 1;
									$instids = $custinst[0]['user_installment_Id'];
									$i++;
								} else {
									
									$virtual_pay = 	$instamt*$pinst['numinst'];
									if($virtual_pay!=$finst)
									{
										if($virtual_pay < $finst)
										{
											$vp_status=3;
											$gp = $finst - $virtual_pay;
											$pinst['numinst']=$pinst['numinst']-1;
										} else {
											$vp_status=2;
											$gp = $virtual_pay - $finst;
											
											$pinst['numinst']=$pinst['numinst']-1;
										}
									}
									$totinst = $pinst['numinst'];
									$instidarr = array();
									for($m = 0; $m < $totinst;$m++)
									{
										$instidarr[] = $custinst[$m]['user_installment_Id'];
										
									}
									if($vp_status==2 || $vp_status==3)
									{
										$ext_instid = $custinst[$m]['user_installment_Id'];
										
									} 
									$instids = implode(",",$instidarr);
								}
								
								$data = array();
								$data['Installment_Paidon'] = $dt;
								$data['receiptdt'] = $rcdt;
								$data['transactionno'] = $maxid+$k;
								if($pinst['numinst']==0) {
									//$data['PaniltyAmount'] = $pinst['paid']-$finst;
								}
								$data['payamt'] = $finst;
								$data['Installment_status'] = '1';
								$data['receiptno'] = $c['rc'];
								print_r($data);
								$condition = "user_installment_Id in (".$instids.")";
								$db->modify('rbi_user_scheme_installment_daily',$data,$condition);
								echo '<br>--'.$vp_status.'--<br>';
								if($vp_status==2)
								{ 
									$data = array();
									$data['Installment_Paidon'] = $dt;
									$data['receiptdt'] = $rcdt;
									$data['transactionno'] = $maxid+$k;
									if($pinst['numinst']==0) {
										//$data['PaniltyAmount'] = $pinst['paid']-$finst;
									}
									$data['halfdue'] = $gp;
									$data['InstallmentAmount'] = $instamt-$gp;
									
									$data['payamt'] = $finst;
									$data['Installment_status'] = '1';
									$data['receiptno'] = $c['rc'];
									print_r($data);
									$condition = "user_installment_Id in (".$ext_instid.")";
									$db->modify('rbi_user_scheme_installment_daily',$data,$condition);
								}
								if($vp_status==3)
								{ 
									$data = array();
									$data['Installment_Paidon'] = $dt;
									$data['receiptdt'] = $rcdt;
									$data['transactionno'] = $maxid+$k;
									if($pinst['numinst']==0) {
										//$data['PaniltyAmount'] = $pinst['paid']-$finst;
									}
									$data['halfdue'] = (0-$gp);
									$data['InstallmentAmount'] = $instamt+$gp;
									
									$data['payamt'] = $finst;
									$data['Installment_status'] = '1';
									$data['receiptno'] = $c['rc'];
									print_r($data);
									$condition = "user_installment_Id in (".$ext_instid.")";
									$db->modify('rbi_user_scheme_installment_daily',$data,$condition);
								}
								
								
								$data = array();
								
								$data['fill']='1';
								$condition = "id='".$c['id']."'";
								$db->modify('temp_old_coll',$data,$condition);
								
								$a = $obj_x->transfertopaid();
								
				  }
				} else {
					$data = array();
					$data['fill']='7';
					$condition = "id='".$c['id']."'";
					$db->modify('temp_old_coll',$data,$condition);
				}
			$i++;
			$k++;
			}			
				
		
			
		echo "<script>window.location='http://localhost/sites/amardeep/changescheme/payinst3';</script>";
		}
		
		exit;
	}
	public function chkisdailyAction()
	{
		$db= new Db();
		
		echo $qry = "select * from temp_inst_cust where is_daily='0' and filename like 'rest%' and status='0' limit 0, 5";
		$cust = $db->runQuery($qry);
		if(is_array($cust) && count($cust) > 0)
		{
			foreach($cust as $c) {
				echo "<br>select userid from rbi_user where profileId='".$c['profileid']."'";
				
				$custdetail = $db->runQuery("select userid from rbi_user where profileId='".$c['profileid']."'");
				if($custdetail[0]['userid']) {
					echo '<br>'.$getscheme = "select * from rbi_user_to_scheme where userid ='".$custdetail[0]['userid']."'";
					$resscheme = $db->runQuery($getscheme);
					if($resscheme[0]['timePriodType']==0)
					{
						$data = array();
						$data['is_daily'] = 1;
						
						$condition = "id='".$c['id']."'";
						$db->modify('temp_inst_cust',$data,$condition);
					} else {
						$data = array();
						$data['is_daily'] = 2;
						
						$condition = "id='".$c['id']."'";
						$db->modify('temp_inst_cust',$data,$condition);
					}
				} else {
					$data = array();
					$data['status'] = 3;
					
					$condition = "id='".$c['id']."'";
					$db->modify('temp_inst_cust',$data,$condition);
					
					$data = array();
					$data['status'] = 8;
					
					$condition = "pid='".$c['id']."'";
					$db->modify('temp_inst_detail',$data,$condition);
				}
			}
		}
		exit;
	}
	public function setmnthAction() 
	{
		global $mySession;		
		$db=new Db();
		
		$res=$db->runQuery("select * from rbi_user_to_scheme");
		
		foreach($res as $r) {
			$get_mnth = $db->runQuery("select * from rbi_scheme where schemId='".$r['schemId']."'");
			
			$mydata2 = array();
			$mydata2['mnth'] = $get_mnth[0]['mnth'];
			$contition2="user_schemeid='".$r['user_schemeid']."'";
			$Result=$db->modify('rbi_user_to_scheme',$mydata2,$contition2);
		}
		exit;
	}
	public function setagentidAction() 
	{
		global $mySession;		
		$db=new Db();
		
		$res=$db->runQuery("select * from rbi_user_to_scheme");
		
		foreach($res as $r) {
			$get_mnth = $db->runQuery("select agentId, branchId from `rbi_user_customer` where userId='".$r['userid']."'");
			
			$mydata2 = array();
			$mydata2['agentId'] = $get_mnth[0]['agentId'];
			$mydata2['branchId'] = $get_mnth[0]['branchId'];
			$contition2="user_schemeid='".$r['user_schemeid']."'";
			$Result=$db->modify('rbi_user_to_scheme',$mydata2,$contition2);
		}
		exit;
	}
	public function setagentcommAction() 
	{
		global $mySession;		
		$db=new Db();
		
		$res=$db->runQuery("select * from rbi_user_scheme_installment where Installment_status='1'");
		
		foreach($res as $r) {
			$already = $db->runQuery("select id from rbi_agentamount where inst_id='".$r['user_installment_Id']."'");
			if(is_array($already) && count($already) > 0) {
			
			} else {
				$get_scheme = $db->runQuery("select * from rbi_user_to_scheme where user_schemeid='".$r['user_schemeId']."'");
				if($r['instno']==1) {
					$typ = 1;
				} else {
					$typ = 2;
				}
				//--1=agent id, 2=Transactino Type, 3= Intallment Id, 4=Customer id, 5=$amount, 6=Credit Date, 7=Receipt No., 8=Scheme Id
				agentamount_entry($r['agentId'],$typ,$r['user_installment_Id'],$get_scheme[0]['userid'],$r['InstallmentAmount'],$r['InstallmentDueDate'],$r['receiptno'],$get_scheme[0]['schemId']);				
			}
		}
		exit;
	}
	/*public function indexAction()
	{
		
		global $mySession;
		$this->view->pagetitle = 'Change Scheme';
		$db=new Db();
		
		$pid='RB76823105000011';
		$schemeid='55';
		
		$qry="select userid, created_on  from rbi_user where profileId='".$pid."'";	
		$getid=$db->runQuery("$qry");
		
		if(is_array($getid) && count($getid) >0)
		{
			$qry="select * from rbi_scheme where schemId='".$schemeid."'";	
			$schemeData=$db->runQuery("$qry");
			
			$qry="select * from rbi_user_to_scheme where userid='".$getid[0]['userid']."'";	
			$getuserscheme=$db->runQuery("$qry");
			
			
			$qry="select * from rbi_user_scheme_installment where user_schemeId='".$getuserscheme[0]['user_schemeid']."' and Installment_status='1' order by instno";	
			$getinstdetail=$db->runQuery("$qry");
			
			if(is_array($getinstdetail) && count($getinstdetail) >0)
			{
				///update user scheme
				$mydata2 =array('schemId'=>$schemeData[0]['schemId'],
					'title'=>$schemeData[0]['title'],
					'landsize'=>$schemeData[0]['landsize'],
					'timePeriod'=>$schemeData[0]['timePeriod'],
					'timePriodType'=>$schemeData[0]['timePriodType'],
					'installment'=>$schemeData[0]['installment'],
					'agent_commission'=>$schemeData[0]['agent_commission'],
					'noOfInstallment'=>$schemeData[0]['noOfInstallment'],
					'ReturnAmount'=>$schemeData[0]['ReturnAmount'],
					'scheme_type'=>$schemeData[0]['scheme_type'],
					'lastupdate'=>date('Y-m-d H:i:s'));	
				echo "<pre>";
				print_r($mydata2);	
					$contition2="user_schemeid='".$getuserscheme[0]['user_schemeid']."'";
					$Result=$db->modify('rbi_user_to_scheme',$mydata2,$contition2);
									
				$condition2="user_schemeId='".$getuserscheme[0]['user_schemeid']."'";
				$db->delete('rbi_user_scheme_installment',$condition2);
		
				//Inserting data in Installment table
				for($i=1;$i<=$schemeData[0]['noOfInstallment'];$i++)
				{
					if($i==1)
					{
					
					$installmentDueDate=$getid[0]['created_on'];
					$installmentStatus="1";
					$receiptno=$getinstdetail[0]['receiptno'];
					
					//$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid where user_installment_Id!='".@$dataForm['pinsid']."'";
					$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid";
					$maxidresult=$db->runQuery("$qry");	//print_r($dataForm);
				
					if($maxidresult[0]['maxrecno'] < 5000) { $maxid =5000; } else { $maxid =$maxidresult[0]['maxrecno']; }
										
					$transactionno=$maxid;
					$installmentPaidOn=$getid[0]['created_on'].' 10:00:00';
					$installmentPaidBy=$mySession->user['userId'];
					}
					else
					{
					
					if(@$getinstdetail[($i-1)]['receiptno']!='') { 
						$receiptno=$getinstdetail[($i-1)]['receiptno']; 
						$installmentStatus="1"; 
					} else { 
						$receiptno="0"; $installmentStatus="0";
					}
					
					if(@$getinstdetail[($i-1)]['transactionno']!='') { 
						$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid";
						$maxidresult=$db->runQuery("$qry");	//print_r($dataForm);
					
						if($maxidresult[0]['maxrecno'] < 5000) { $maxid =5000; } else { $maxid =$maxidresult[0]['maxrecno']; }
											
						$transactionno=$maxid;
						$installmentPaidOn=$getid[0]['created_on'].' 10:00:00';
						$installmentPaidBy=$mySession->user['userId'];					
					} else { 
						$transactionno=0; 
						$installmentPaidOn="";
						$installmentPaidBy="";
					}
						$periodType="";
						if($schemeData[0]['timePriodType']=='0')
						$periodType="DAY";
						if($schemeData[0]['timePriodType']=='1')
						$periodType="MONTH";
						if($schemeData[0]['timePriodType']=='2')
						$periodType="YEAR";
						
						$DueDate=$db->runQuery("SELECT DATE_ADD('".$installmentDueDate."', INTERVAL ".$schemeData[0]['timePeriod']." ".$periodType.") as dueDate");
						$installmentDueDate=$DueDate[0]['dueDate'];
					}
					$mydata3 =array('user_schemeId'=>$getuserscheme[0]['user_schemeid'],
					'agentId'=>$getinstdetail[0]['agentId'],
					'userId'=>$getinstdetail[0]['userId'],
					'branchId'=>$getinstdetail[0]['branchId'],
					'empId'=>$getinstdetail[0]['empId'],					
					'receiptno'=>$receiptno,
					'transactionno'=>$transactionno,
					'instno'=>$i,
					'InstallmentAmount'=>$schemeData[0]['installment'],
					'InstallmentDueDate'=>$installmentDueDate,
					'AgentCommission'=>$schemeData[0]['agent_commission'],
					'Installment_status'=>$installmentStatus,
					'Installment_Paidon'=>$installmentPaidOn,
					'Installment_Paidby'=>$installmentPaidBy);
					$Result=$db->save('rbi_user_scheme_installment',$mydata3);
					if($receiptno) {
					$lastid = $db->lastInsertId();
						$expire_condition = "recno='".$receiptno."'";
						$expireDataArray =array('user_inst_Id'=>$lastid);
						$Resultx=$db->modify('rbi_receipt',$expireDataArray,$expire_condition);
					}
				}			
			} else {
				echo 'Pay Multipal Installment';
			}	
			
		}
	
	}*/
	
	public function setallidAction()
	{
		global $mySession;
		$this->view->pagetitle = 'Change Scheme';
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		if(isset($arr['page']))
		{
			$pageino = $arr['page'];
		} else {
			$pageino = 1;
		}
		$modelobj = new Model_Mainmodel();
		//echo "<pre>";
		
		$limit=5000;
		$currentlimit = ($pageino-1)*$limit;
		 $qry="select a.user_installment_Id, a.user_schemeId, b.userid 
		from `rbi_user_scheme_installment` as a 
		left join rbi_user_to_scheme as b on (a.user_schemeId=b.user_schemeid) where a.user_schemeId in (370,482,488)
		limit ".$currentlimit.", ".$limit;
		
				$attend = $db->runQuery("$qry");
				if(is_array($attend) && count($attend) > 0)
				{
					foreach($attend as $rec)
					{
						$qry="select uc.userId, ua.userId as agentId, ub.userId as branchId, ue.userId as employeeId
								from `rbi_user_customer` as uc
								inner join rbi_agent as ua on (uc.agentId=ua.userId) 
								inner join rbi_employee as ue on (if(uc.agentId=23 and uc.noagentempid!=0, ue.userId=uc.noagentempid, ue.userId=ua.employeeId))
								inner join rbi_user as ub on (ub.userId=ue.branchId)
								 where uc.userId='".$rec['userid']."' ";
						$idlist = $db->runQuery("$qry");
						
						$Data='';
						$Data['userId']=@$idlist[0]['userId'];
						$Data['agentId']=@$idlist[0]['agentId'];
						$Data['branchId']=@$idlist[0]['branchId'];
						
						$Data['empId']=@$idlist[0]['employeeId'];
						//print_r($Data);
						$wherecondition = "user_installment_Id='".$rec['user_installment_Id']."'";
						$modelobj->updateThis('rbi_user_scheme_installment',$Data,$wherecondition);
					}
						$this->_redirect('changescheme/setallid/page/'.($pageino+1));
				}
		exit;
	}
	
	public function changedt()
	{
/*		update `rbi_user` set `created_on`=DATE_ADD(`created_on`, INTERVAL -1 MONTH) WHERE `userid`='780';
		update `rbi_user` set `created_on`=DATE_ADD(`created_on`, INTERVAL -1 MONTH) WHERE `userid`='781';
		
		update `rbi_user_to_scheme` set `created_on`=DATE_ADD(`created_on`, INTERVAL -1 MONTH) WHERE `userid` in (780,781);
		
		update `rbi_user_scheme_installment` set `InstallmentDueDate` = DATE_ADD(`InstallmentDueDate`, INTERVAL -1 MONTH) WHERE `user_schemeId` in (561,562);
		
		UPDATE `rbi`.`rbi_user_scheme_installment` SET `Installment_Paidon` = '2011-10-02 00:00:00' WHERE `rbi_user_scheme_installment`.`user_installment_Id` =87909 LIMIT 1 ;
		
		UPDATE `rbi`.`rbi_user_scheme_installment` SET `Installment_Paidon` = '2011-10-02 00:00:00' WHERE `rbi_user_scheme_installment`.`user_installment_Id` =87969 LIMIT 1 ;
*/	}
	
}
?>
