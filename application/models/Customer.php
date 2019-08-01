<?php
class Model_Customer extends Db
{
	public function InsertCustomer($dataForm)
	{		
		global $mySession;
		$db=new Db();
		$resultChk=$db->runQuery("select * from rbi_user where username='".$dataForm['username']."' and username!=''");
		if(count($resultChk)>0 && $resultChk!="")
		{
		return "0";
		}
		else
		{		
		//Inserting data in main user table	
		$regdate = date('Y-m-d H:i:s');
		if($dataForm['date_of_reg']!=date('d-m-Y'))
		{
			$regdate = changeDate($dataForm['date_of_reg']).' 00:00:00';
		}
		
		$mydata =array('usrRole' => 'C',
		'fname'=>$dataForm['first_name'],
		'lname'=>$dataForm['last_name'],
		'username'=>$dataForm['username'],
		'password'=>$dataForm['user_password'],
		'emailaddress'=>$dataForm['email_address'],
		'phoneno'=>$dataForm['phone_number'],
		'mobno'=>$dataForm['mobile_number'],
		'state'=>$dataForm['state_id'],
		'city'=>$dataForm['city_id'],
		'address'=>$dataForm['address'],
		'created_on'=>$regdate,
		'lastudpate_on'=>date('Y-m-d H:i:s'),
		'created_by'=>$mySession->user['userId'],
		'updated_by'=>$mySession->user['userId'],
		'status'=>'1');				
		$Result=$db->save('rbi_user',$mydata);
		$UserId=$db->lastInsertId();
		
		if(trim($dataForm['custid'])!='')
		{
			$profileid=trim($dataForm['custid']);
		} else {
			$profileid=generateCustomer_id($dataForm['branch_Id']);
		}
		//Inserting data in customer table
		$mydata1 =array('userId'=>$UserId,
		'agentId'=>$dataForm['agent_Id'],
		'branchId'=>$dataForm['branch_Id'],
		'fathername'=>$dataForm['fathername'],
		'husbandname'=>$dataForm['husbandname'],
		'nationality'=>$dataForm['nationality'],
		'guardiandt'=>$dataForm['guardiandt'],
		'profileId'=>$profileid,
		'DateofBirth'=>changeDate($dataForm['date_of_birth']),
		'NominiName'=>$dataForm['nomini_name'],
		'NominiAge'=>$dataForm['nomini_age'],
		'NominiRelation'=>$dataForm['nomini_relation'],
		'NominiAddress'=>$dataForm['NominiAddress'],
		'Bondno'=>$dataForm['bondno'],
		'PassBookNo'=>$dataForm['passbookno'],
		'PanCartNumber'=>$dataForm['pan_card_number'],
		'Proffession'=>$dataForm['proffession']);	
				
		$Result=$db->save('rbi_user_customer',$mydata1);
		$this->setagname($UserId);	
		$mydataP =array('profileId'=>$profileid);
		$conditionP="userid='".$UserId."'";
		$Result=$db->modify('rbi_user',$mydataP,$conditionP);
		
		if(trim($dataForm['username'])=='' || trim($dataForm['user_password'])=='') {
			
			$passwordData =array('username'=>$profileid,'password'=>$dataForm['phone_number']);
			if(trim($dataForm['username'])!='') {
				$passwordData =array('password'=>$dataForm['phone_number']);
			} elseif(trim($dataForm['user_password'])!='') {
				$passwordData =array('username'=>$profileid);
			}
			$passwordcondition="userid='".$UserId."'";
			$Result=$db->modify('rbi_user',$passwordData,$passwordcondition);
		}
		
		//Inserting data in user to scheme table
		$schemeData=$db->runQuery("select * from rbi_scheme where schemId='".$dataForm['scheme_Id']."'");
		$mydata2 =array('schemId'=>$dataForm['scheme_Id'],
		'userid'=>$UserId,
		'title'=>$schemeData[0]['title'],
		'mnth'=>$schemeData[0]['mnth'],
		'landsize'=>$schemeData[0]['landsize'],
		'timePeriod'=>$schemeData[0]['timePeriod'],
		'timePriodType'=>$schemeData[0]['timePriodType'],
		'installment'=>$schemeData[0]['installment'],
		'agent_commission'=>$schemeData[0]['agent_commission'],
		'noOfInstallment'=>$schemeData[0]['noOfInstallment'],
		'ReturnAmount'=>$schemeData[0]['ReturnAmount'],
		'scheme_type'=>$schemeData[0]['scheme_type'],
		'agentId'=>$dataForm['agent_Id'],
		'branchId'=>$dataForm['branch_Id'],
		'created_on'=>$regdate,
		'lastupdate'=>date('Y-m-d H:i:s'),
		'created_by'=>'0',
		'updated_by'=>'0',
		'sms_status'=>$schemeData[0]['sms_status']);		
		$Result=$db->save('rbi_user_to_scheme',$mydata2);
		$UsertoSchemeId=$db->lastInsertId();
		
		$qry="select uc.userId, ua.userId as agentId, ub.userId as branchId
			from `rbi_user_customer` as uc
			inner join rbi_agent as ua on (uc.agentId=ua.userId) 			
			inner join rbi_user as ub on (ub.userId=ua.branchId)
			 where uc.userId='".$UserId."' ";
			 ////inner join rbi_employee as ue on (if(uc.agentId=23 and uc.noagentempid!=0, ue.userId=uc.noagentempid, ue.userId=ua.employeeId))
		$rec_branch_emp = $db->runQuery($qry);
		//Inserting data in Installment table
		for($i=1;$i<=$schemeData[0]['noOfInstallment'];$i++)
		{
			if($i==1)
			{
			$installmentDueDate=changeDate($dataForm['date_of_reg']);
			$installmentStatus="1";
			$receiptno=$dataForm['receiptno'];
			
			//$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid where user_installment_Id!='".@$dataForm['pinsid']."'";
			$qry="select (max(transactionno)+1) as maxrecno from rbi_user_scheme_installment_paid";
			$maxidresult=$db->runQuery("$qry");	//print_r($dataForm);
		
			if($maxidresult[0]['maxrecno'] < 5000) { $maxid =5000; } else { $maxid =$maxidresult[0]['maxrecno']; }								
				$transactionno=$maxid;
				$installmentPaidOn=$regdate;
				$installmentPaidBy=$mySession->user['userId'];
			}
			else
			{
				$installmentStatus="0";
				$receiptno="0";
				$installmentPaidOn="";
				$installmentPaidBy="";
				$transactionno=0;
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
			//'empId'=>$rec_branch_emp[0]['employeeId'],
			$mydata3 =array('user_schemeId'=>$UsertoSchemeId,
			'agentId'=>'0',
			'receiptno'=>$receiptno,
			'transactionno'=>$transactionno,
			'instno'=>$i,
			'userId'=>$UserId,
			'agentId'=>$dataForm['agent_Id'],
			'branchId'=>$rec_branch_emp[0]['branchId'],
			
			'InstallmentAmount'=>$schemeData[0]['installment'],
			'InstallmentDueDate'=>$installmentDueDate,
			'AgentCommission'=>$schemeData[0]['agent_commission'],
			'Installment_status'=>$installmentStatus,
			'Installment_Paidon'=>$installmentPaidOn,
			'Installment_Paidby'=>$installmentPaidBy);
			if($schemeData[0]['timePriodType']=='0') {
				$Result=$db->save('rbi_user_scheme_installment_daily',$mydata3);
			} else {
				$Result=$db->save('rbi_user_scheme_installment',$mydata3);
			}
			$inst_unique_id = $db->lastInsertId();
			if($receiptno) {
			$lastid = $db->lastInsertId();
				$expire_condition = "recno='".$receiptno."'";
				$expireDataArray =array('user_inst_Id'=>$lastid);
				$Resultx=$db->modify('rbi_receipt',$expireDataArray,$expire_condition);
			}
			if($installmentStatus) {
				//--1=agent id, 2=Transactino Type, 3= Intallment Id, 4=Customer id, 5=$amount, 6=Credit Date, 7=Receipt No., 8=Scheme Id
				//echo $dataForm['agent_Id'].',1,'.$Result.','.$UserId.','.$schemeData[0]['installment'].','.$installmentDueDate.','.$receiptno.','.$dataForm['scheme_Id'];
//				exit;
				agentamount_entry($dataForm['agent_Id'],1,$inst_unique_id,$UserId,$schemeData[0]['installment'],$installmentDueDate,$receiptno,$dataForm['scheme_Id']);
			}
		}
		$intv = '1';
		if($schemeData[0]['timePriodType']=='2') {
			$intv = '1.1';
		}
		if($schemeData[0]['timePriodType']=='3') {
			$intv = ($schemeData[0]['timePeriod'])+(0.1);			
		}
		
		$DueDate=$db->runQuery("SELECT DATE_ADD('".$installmentDueDate."', INTERVAL ".$intv." YEAR_MONTH) as dueDate");
		$expDate=$DueDate[0]['dueDate'];
					
		$expire_condition = "user_schemeid='".$UsertoSchemeId."'";
		$expireDataArray =array('expire_on'=>$expDate);
		$Result=$db->modify('rbi_user_to_scheme',$expireDataArray,$expire_condition);
		$obj_x = new Model_Mainmodel();	
		$a = $obj_x->transfertopaid();
		return $UserId;
		}
	}
	public function UpdateCustomer($dataForm,$customerId)
	{		
		global $mySession;
		$db=new Db();
		$resultChk=$db->runQuery("select * from rbi_user where username='".$dataForm['username']."' and userid!='".$customerId."'");
		if(count($resultChk)>0 && $resultChk!="")
		{
		return "2";
		}
		else
		{		
		//Updating data in main user table	
		$mydata =array('fname'=>$dataForm['first_name'],
		'lname'=>$dataForm['last_name'],
		'username'=>$dataForm['username'],		
		'emailaddress'=>$dataForm['email_address'],
		'phoneno'=>$dataForm['phone_number'],
		'mobno'=>$dataForm['mobile_number'],
		'state'=>$dataForm['state_id'],
		'city'=>$dataForm['city_id'],
		'address'=>$dataForm['address'],	
		'lastudpate_on'=>date('Y-m-d H:i:s'),
		'updated_by'=>$mySession->user['userId']);
		$contition="userid='".$customerId."'";
		$Result=$db->modify('rbi_user',$mydata,$contition);
		
		//Update Password for Customer
		if(isset($_REQUEST['ChangePass']))
		{		
		$mydata1 =array('password'=>$dataForm['user_password']);
		$contition1="userid='".$customerId."'";
		$Result=$db->modify('rbi_user',$mydata1,$contition1);
		}
		$result_agent=$db->runQuery("select agentId from rbi_user_customer where userid!='".$customerId."'");
		
		if($result_agent[0]['agentId']!=$dataForm['agent_Id'])
		{
			$Data_a='';
				if($dataForm['agent_Id']==23)
				{
					$qry="select ub.userId as branchId, ue.userId as employeeId
								from rbi_employee as ue 
								inner join rbi_user as ub on (ub.userId=ue.branchId)
								 where ue.userId='".$dataForm['noag_employee_Id']."' ";
					$idlist = $db->runQuery("$qry");
					$Data_a['agentId']=23;
				} else {
						 $qry="select ua.userId as agentId, ub.userId as branchId, ue.userId as employeeId
						from rbi_agent as ua 
						inner join rbi_employee as ue on (ue.userId=ua.employeeId)
						inner join rbi_user as ub on (ub.userId=ue.branchId)
						 where ua.userId='".$dataForm['agent_Id']."' ";
					$idlist = $db->runQuery("$qry");
					$Data_a['agentId']=@$idlist[0]['agentId'];
				}
				$result_s_id=$db->runQuery("select user_schemeid from rbi_user_to_scheme where userid!='".$customerId."'");
				
				
				
				
				$Data_a['branchId']=@$idlist[0]['branchId'];						
				$Data_a['empId']=@$idlist[0]['employeeId'];
				//print_r($Data);
				$wherecondition = "user_schemeId='".$result_s_id[0]['user_schemeid']."'";
				$db->modify('rbi_user_scheme_installment',$Data_a,$wherecondition);
		} elseif($dataForm['agent_Id']==23)
		{
			$qry="select ub.userId as branchId, ue.userId as employeeId
						from rbi_employee as ue 
						inner join rbi_user as ub on (ub.userId=ue.branchId)
						 where ue.userId='".$dataForm['noag_employee_Id']."' ";
				$idlist = $db->runQuery("$qry");
				$result_s_id=$db->runQuery("select user_schemeid from rbi_user_to_scheme where userid='".$customerId."'");
				
				$Data_a='';
				
				$Data_a['agentId']=23;
				$Data_a['branchId']=@$idlist[0]['branchId'];						
				$Data_a['empId']=@$idlist[0]['employeeId'];
				//print_r($Data_a);
				$wherecondition = "user_schemeId='".$result_s_id[0]['user_schemeid']."'";
				$db->modify('rbi_user_scheme_installment',$Data_a,$wherecondition);
		}
		
		//Updating data in customer table
		$mydata2 =array('DateofBirth'=>changeDate($dataForm['date_of_birth']),
		'agentId'=>$dataForm['agent_Id'],
		'noagentempid'=>$dataForm['noag_employee_Id'],
		'fathername'=>$dataForm['fathername'],
		'husbandname'=>$dataForm['husbandname'],
		'nationality'=>$dataForm['nationality'],
		'guardiandt'=>$dataForm['guardiandt'],
		'NominiName'=>$dataForm['nomini_name'],
		'NominiRelation'=>$dataForm['nomini_relation'],
		'NominiAddress'=>$dataForm['NominiAddress'],
		'PassBookNo'=>$dataForm['passbookno'],
		'Bondno'=>$dataForm['bondno'],
		'PanCartNumber'=>$dataForm['pan_card_number'],
		'Proffession'=>$dataForm['proffession']);
		$contition2="userId='".$customerId."'";
		$Result=$db->modify('rbi_user_customer',$mydata2,$contition2);		
		//echo 'HHH : '.$result_agent[0]['agentId']."  --  ".$dataForm['agent_Id'].' || '.$dataForm['noag_employee_Id'];
		//exit;
		return "1";
		}
	}
	function setagname($userid)
	{
		global $mySession;		
		$db=new Db();
		$arr=$this->getRequest()->getParams();
		
		$qry = "select userId, agentId, branchId from rbi_user_customer where userId='".$userid."'";
		$cust = $db->runQuery($qry);
		if(is_array($cust) && count($cust) > 0)
		{
			foreach($cust as $user)
			{
				$aginfo = $db->runQuery("select concat(fname,' ',lname) as aname, profileId from rbi_user where userid='".$user['agentId']."'");
				$brinfo = $db->runQuery("select concat(fname,' ',lname) as bname, profileId from rbi_user where userid='".$user['branchId']."'");
				
				$data = array();
				echo $data['aname']=$aginfo[0]['aname'];
				$data['bname']=$brinfo[0]['bname'];
				
				$data['aprofileid']=$aginfo[0]['profileId'];
				$data['bprofileid']=$brinfo[0]['profileId'];
				$condition = "userId='".$user['userId']."'";
				$db->modify('rbi_user_customer', $data, $condition);
			}
			
		}
		
	}
}
?>