<?php

class Model_Agent extends Db

{

	public function InsertAgent($dataForm)

	{		

		global $mySession;

		$db=new Db();

		$resultChk=$db->runQuery("select * from rbi_user where username='".$dataForm['username']."' and username!=''");

		if(count($resultChk)>0 && $resultChk!="")

		{

		return "2";

		}

		else

		{		

		//Inserting data in main user table	
		$regdate = date('Y-m-d H:i:s');
		if($dataForm['date_of_reg']!=date('d-m-Y'))
		{
			$regdate = changeDate($dataForm['date_of_reg']).' 00:00:00';
		}
		
		$mydata =array('usrRole' => 'AG',

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

		

		//Inserting data in agent table

		$mydata1 =array('userId'=>$UserId,

		'profileId'=>'0',

		'branchId'=>$dataForm['branch_Id'],

		'employeeId'=>$dataForm['agent_Id'],

		'fathername'=>$dataForm['father_name'],

		'husbandname'=>$dataForm['husbandname'],

		'DateofBirth'=>changeDate($dataForm['date_of_birth']),

		'DateofApply'=>changeDate($dataForm['date_of_apply']),

		'qualification'=>$dataForm['quallification'],

		'profession'=>$dataForm['proffession'],

		'pancard'=>$dataForm['pan_card_number'],

		'amount'=>$dataForm['amount_deposit']);			

		$Result=$db->save('rbi_agent',$mydata1);		

		$AgentAutoId=$db->lastInsertId();		
		

		

		 $profileid = generateAgent_id($dataForm['branch_Id'],$AgentAutoId);

		

		

		$mydata2 =array('profileId'=> $profileid);

		$condition2="agentId='".$AgentAutoId."'";

		$Result=$db->modify('rbi_agent',$mydata2,$condition2);

		

		$mydataP =array('profileId'=>$profileid);

		$conditionP="userid='".$UserId."'";

		$Result=$db->modify('rbi_user',$mydataP,$conditionP);

		

		if(trim($dataForm['username'])=='' || trim($dataForm['user_password'])=='') {

			

			$mydata2 =array('username'=>$profileid,'password'=>$dataForm['phone_number']);

			if(trim($dataForm['username'])!='') {

				$mydata2 =array('password'=>$dataForm['phone_number']);

			} elseif(trim($dataForm['user_password'])!='') {

				$mydata2 =array('username'=>$profileid);

			}

			$condition2="userid='".$UserId."'";

			$Result=$db->modify('rbi_user',$mydata2,$condition2);

		}		

		return "1";

		}

	}

	public function UpdateAgent($dataForm,$agentId)

	{		

		global $mySession;

		$db=new Db();

		$resultChk=$db->runQuery("select * from rbi_user where username='".$dataForm['username']."' and userid!='".$agentId."'");

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

		$contition="userid='".$agentId."'";

		$Result=$db->modify('rbi_user',$mydata,$contition);

		

		//Update Password for Customer

		if(isset($_REQUEST['ChangePass']))

		{		

		$mydata1 =array('password'=>$dataForm['user_password']);

		$contition1="userid='".$agentId."'";

		$Result=$db->modify('rbi_user',$mydata1,$contition1);

		}

		

		//Updating data in agent table

		$mydata2 =array('branchId'=>$dataForm['branch_Id'],

		'employeeId'=>$dataForm['employee_Id'],

		'fathername'=>$dataForm['father_name'],

		'husbandname'=>$dataForm['husbandname'],

		'DateofBirth'=>changeDate($dataForm['date_of_birth']),

		'DateofApply'=>changeDate($dataForm['date_of_apply']),

		'qualification'=>$dataForm['quallification'],

		'profession'=>$dataForm['proffession'],

		'pancard'=>$dataForm['pan_card_number'],

		'amount'=>$dataForm['amount_deposit']);	

		$contition2="userId='".$agentId."'";

		$Result=$db->modify('rbi_agent',$mydata2,$contition2);		

		$data = array();
		$data['aname'] = $dataForm['first_name'];
		$contition="agentId='".$agentId."'";
		$Result=$db->modify('rbi_user_customer',$data,$contition);

		return "1";

		}

	}

}

?>