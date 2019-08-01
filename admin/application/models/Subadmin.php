<?php
class Model_Subadmin extends Db
{
	public function InsertAdmin($dataForm)
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
			$mydata =array('usrRole' => 'SA',
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
			'created_on'=>date('Y-m-d H:i:s'),
			'lastudpate_on'=>date('Y-m-d H:i:s'),
			'created_by'=>$mySession->user['userId'],
			'updated_by'=>$mySession->user['userId'],
			'status'=>'1');				
			$Result=$db->save('rbi_user',$mydata);
			$UserId=$db->lastInsertId();
		
		
		//Inserting data in employee table
		$mydata1['userId']=$UserId;
		$mydata1['DateofBirth']=changeDate($dataForm['date_of_birth']);
		$mydata1['fathername']=$dataForm['father_name'];
		$mydata1['branchid']=$dataForm['onlybranch'];
		if(isset($dataForm['chk_rights'])) {
			$mydata1['rights']=implode(',',$dataForm['chk_rights']);
		}
		$Result=$db->save('rbi_admin',$mydata1);	
		$EmployeeAutoId=$db->lastInsertId();
		
		$profileid = generateSubadmin_id(date("d-m-Y"),$EmployeeAutoId);
		
		$mydatax =array('profileId'=>$profileid);
		
		$conditionx="adminId='".$EmployeeAutoId."'";
		
		$Result=$db->modify('rbi_admin',$mydatax,$conditionx);
		
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
	public function UpdateEmployee($dataForm,$employeeId)
	{		
		global $mySession;
		$db=new Db();
		$resultChk=$db->runQuery("select * from rbi_user where username='".$dataForm['username']."' and userid!='".$employeeId."'");
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
		$contition="userid='".$employeeId."'";
		$Result=$db->modify('rbi_user',$mydata,$contition);
		
		//Update Password for Customer
		if(isset($_REQUEST['ChangePass']))
		{		
		$mydata1 =array('password'=>$dataForm['user_password']);
		$contition1="userid='".$employeeId."'";
		$Result=$db->modify('rbi_user',$mydata1,$contition1);
		}
		
		//Updating data in employee table
		$mydata2='';
		$mydata2['DateofBirth']=changeDate($dataForm['date_of_birth']);
		$mydata2['fathername']=$dataForm['father_name'];
		$mydata2['branchid']=$dataForm['onlybranch'];
		if(isset($dataForm['chk_rights'])) {
			$mydata2['rights']=implode(',',$dataForm['chk_rights']);
		}
		
		$contition2="userId='".$employeeId."'";
		$Result=$db->modify('rbi_admin',$mydata2,$contition2);		
		
		return "1";
		}
	}
}
?>