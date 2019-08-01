<?php
 	class Model_Mainmodel extends Db{
		
		
		public function __construct(){
			
		}	
		
		function runThisQuery($query = null)
		{
			try
			{
				
				$User = new Db();
				$UserRecords = $User->runQuery($query);
				
				if(is_array($UserRecords) && count($UserRecords) > 0)
				{
					return $UserRecords; 
				}
				else
				{
					return false;
				}		
			}
			catch (Exception $e)
			{
				//echo "Exception occured ::".$e->getMessage();
				return false;
			}
		}
		function insertThis($_table,$data)
		{
			try{
					$User = new Db();
					
					//$data['UserCstmp'] = date('Y-m-d H:i:s');
					//$data['UserUstmp'] = date('Y-m-d H:i:s');
					
					$insertResult = $User->save($_table, $data);
				
					if($insertResult)
					{
						return $User->lastInsertId();
					}
					else 
					{
						return false;
					}
				}
				catch (Exception $e)
				{
					//echo "Exception occured ::".$e->getMessage();
					return false;
				}
		}
		
		function updateThis($_table,$data,$condition)
		{		
			
			try{
					$User = new Db();
					//$data['UserUstmp'] = date('Y-m-d H:i:s');
					
					$updateResult = $User->modify($_table,$data,$condition);
					
					
					if($updateResult)
					{
						return true;
					}
					else 
					{
						return false;
					}
				}
				catch (Exception $e)
				{
					//echo "Exception occured ::".$e->getMessage();
					return false;
				}
		}
		
		function transfertopaid() {
			$db= new Db();
		
		////$qry = "select * from rbi_user_scheme_installment_paid where 1 limit 0, 500";
		$qry = "select * from rbi_user_scheme_installment where Installment_status='1' limit 0, 500";
		$cust = $db->runQuery($qry);
			if(is_array($cust) && count($cust) > 0)
			{
				foreach($cust as $c) {
					$data = array();
					$data['user_installment_Id'] = $c['user_installment_Id'];
					$data['user_schemeId'] = $c['user_schemeId'];
					$data['receiptno'] = $c['receiptno'];
					$data['instno'] = $c['instno'];
					$data['transactionno'] = $c['transactionno'];
					$data['agentId'] = $c['agentId'];
					$data['userId'] = $c['userId'];
					$data['branchId'] = $c['branchId'];
					$data['empId'] = $c['empId'];
					$data['InstallmentAmount'] = $c['InstallmentAmount'];
					$data['payamt'] = $c['payamt'];
					$data['InstallmentDueDate'] = $c['InstallmentDueDate'];
					$data['AgentCommission'] = $c['AgentCommission'];
					$data['Installment_status'] = $c['Installment_status'];
					$data['Installment_Paidon'] = $c['Installment_Paidon'];
					$data['receiptdt'] = $c['receiptdt'];
					$data['PaniltyAmount'] = $c['PaniltyAmount'];
					$data['Installment_Paidby'] = $c['Installment_Paidby'];
					$data['ApprovedBy'] = $c['ApprovedBy'];
					
					$db->save('rbi_user_scheme_installment_paid',$data);
					$condition="user_installment_Id='".$c['user_installment_Id']."'";
					echo '<br>'.$db->delete('rbi_user_scheme_installment',$condition);
					///echo '<br>'.$db->delete('rbi_user_scheme_installment_paid',$condition);
					
				}
				//exit;
				return 1;
			}
			
		$qry = "select * from rbi_user_scheme_installment_daily where Installment_status='1' limit 0, 500";
		$cust = $db->runQuery($qry);
			if(is_array($cust) && count($cust) > 0)
			{
				foreach($cust as $c) {
					$data = array();
					$data['user_installment_Id'] = $c['user_installment_Id'];
					$data['user_schemeId'] = $c['user_schemeId'];
					$data['receiptno'] = $c['receiptno'];
					$data['instno'] = $c['instno'];
					$data['transactionno'] = $c['transactionno'];
					$data['agentId'] = $c['agentId'];
					$data['userId'] = $c['userId'];
					$data['branchId'] = $c['branchId'];
					$data['empId'] = $c['empId'];
					$data['halfdue'] = $c['halfdue'];
					$data['InstallmentAmount'] = $c['InstallmentAmount'];
					$data['payamt'] = $c['payamt'];
					$data['InstallmentDueDate'] = $c['InstallmentDueDate'];
					$data['AgentCommission'] = $c['AgentCommission'];
					$data['Installment_status'] = $c['Installment_status'];
					$data['Installment_Paidon'] = $c['Installment_Paidon'];
					$data['receiptdt'] = $c['receiptdt'];
					$data['PaniltyAmount'] = $c['PaniltyAmount'];
					$data['Installment_Paidby'] = $c['Installment_Paidby'];
					$data['ApprovedBy'] = $c['ApprovedBy'];
					
					$db->save('rbi_user_scheme_installment_paid',$data);
					$condition="user_installment_Id='".$c['user_installment_Id']."'";
					$db->delete('rbi_user_scheme_installment_daily',$condition);
					///echo '<br>'.$db->delete('rbi_user_scheme_installment_paid',$condition);
					
				}
				//exit;
				return 1;
			}
			return 0;
		}
		
	
	}
	?>