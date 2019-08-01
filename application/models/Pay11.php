<?php
 	class Model_Pay extends Db{
	
	protected $_table;
		protected $_table2;
		var $cid;
		public function __construct(){
			$this->_table='rbi_user_scheme_installment';
		}
		
		public function showduelist(){
			global $mySession;
			try{
				$db = new Db();
				$columns="usi.user_installment_Id, usi.InstallmentAmount, usi.instno, DATE_FORMAT(usi.InstallmentDueDate,'%d %M, %Y') as duedate, us.title, us.ReturnAmount, us.created_on, us.sms_status, uc.profileId, concat(u.fname,' ',u.lname) as name, concat(u1.fname,' ',u1.lname) as agentname";
				//$record = $db->showAll($this->_table,$columns);
				$qry = "SELECT ".$columns." "
						." FROM rbi_user_scheme_installment as usi "
						." left join rbi_user_to_scheme as us on (usi.user_schemeid=us.user_schemeId) "
						." left join rbi_user_customer as uc on (us.userid=uc.userId) "
						." left join rbi_user as u on (us.userid=u.userid) "
						." left join rbi_user as u1 on (uc.agentId=u1.userid) "
						." left join rbi_agent as ua on (uc.agentId=ua.userId) "
						." where 1 and u.userid='".$this->cid."' and Installment_status='0' order by usi.user_installment_Id limit 0,1 ";
						
				$record = $db->runQuery($qry);
				if($record){
					return $record;
				} else {
					return false;
				}
			} catch(Exception $e) {
				return false;
			}
		}
		
		public function showpayinst(){
			global $mySession;
			try{
				$db = new Db();
				$columns="usi.user_installment_Id, usi.transactionno, usi.instno, usi.user_schemeId, usi.receiptno, usi.InstallmentAmount, DATE_FORMAT(usi.InstallmentDueDate,'%d/%m/%Y') as duedate, DATE_FORMAT(usi.Installment_Paidon,'%d/%m/%Y %h:%i:%s') as paydate, usi.PaniltyAmount, us.title, us.landsize, us.ReturnAmount, us.created_on, DATE_FORMAT(us.expire_on,'%d/%m/%Y') as expdate, us.sms_status, us.userid, uc.profileId, concat(u.fname,' ',u.lname) as name, ua.profileId as agentcode, ub.profileId as branchcode, ue.profileId as empcode";
				//$record = $db->showAll($this->_table,$columns);
				$qry = "SELECT ".$columns." "
						." FROM rbi_user_scheme_installment as usi "
						." left join rbi_user_to_scheme as us on (usi.user_schemeid=us.user_schemeId) "
						." left join rbi_user_customer as uc on (us.userid=uc.userId) "
						." left join rbi_user as u on (us.userid=u.userid) "
						." left join rbi_user as u1 on (uc.agentId=u1.userid) "
						." left join rbi_agent as ua on (uc.agentId=ua.userId) "
						." left join rbi_branch as ub on (ub.userId=ua.branchId) "
						." left join rbi_employee as ue on (ue.userId=ua.employeeId) "
						." where 1 and usi.user_installment_Id='".$this->cid."' and usi.Installment_status='1'";
						
				$record = $db->runQuery($qry);
				if($record){
					$qry = "SELECT DATE_FORMAT(usi.InstallmentDueDate,'%d %M, %Y') as nextduedate, usi.user_installment_Id as nextdueid  "
						." FROM rbi_user_scheme_installment as usi where user_schemeId='".$record[0]['user_schemeId']."' and Installment_status='0' order by user_installment_Id limit 0,1";
						$extdt = $db->runQuery($qry);
						$record = array_merge($record,$extdt);
					return $record;
				} else {
					return false;
				}
			} catch(Exception $e) {
				return false;
			}
		}
		
		function updateThis($data,$condition)
		{		
			
			try{
					$User = new Db();
					//$data['UserUstmp'] = date('Y-m-d H:i:s');
					
					$updateResult = $User->modify($this->_table,$data,$condition);
					
					
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
	}	