<?php
class Model_Branch extends Db
{
	public function InsertBranch($dataForm)
	{		
		global $mySession;
		$db=new Db();
		/*$resultChk=$db->runQuery("select * from rbi_user where username='".$dataForm['username']."' and username!=''");
		if(count($resultChk)>0 && $resultChk!="")
		{
		return "2";
		}
		else
		{*/	
				
		/*'username'=>$dataForm['username'],
		'password'=>$dataForm['user_password'],*/	
		//Inserting data in main user table	
		$mydata =array('usrRole' => 'B',
		'fname'=>$dataForm['branch_name'],
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
		
		if(trim($dataForm['profielid'])!='')
		{
			$profileid=trim($dataForm['profielid']);
		} else {
			$profileid = generateBranch_id($dataForm['state_id'],$dataForm['city_id']);
		}
		
		//Inserting data in branch table
		$mydata1 =array('userId'=>$UserId,
		'fax'=>$dataForm['fax_number'],
		'profileId'=>$profileid);					
		$Result=$db->save('rbi_branch',$mydata1);	
		
		$mydataP =array('profileId'=>$profileid);
		$conditionP="userid='".$UserId."'";
		$Result=$db->modify('rbi_user',$mydataP,$conditionP);
		
		
		/*if(trim($dataForm['username'])=='' || trim($dataForm['user_password'])=='') {
			
			$mydata2 =array('username'=>$profileid,'password'=>$dataForm['phone_number']);
			if(trim($dataForm['username'])!='') {
				$mydata2 =array('password'=>$dataForm['phone_number']);
			} elseif(trim($dataForm['user_password'])!='') {
				$mydata2 =array('username'=>$profileid);
			}
			$condition2="userid='".$UserId."'";
			$Result=$db->modify('rbi_user',$mydata2,$condition2);
		}*/				
		return "1";
		//}
	}
	public function UpdateBranch($dataForm,$branchId)
	{		
		global $mySession;
		$db=new Db();
		/*$resultChk=$db->runQuery("select * from rbi_user where username='".$dataForm['username']."' and userid!='".$branchId."'");
		if(count($resultChk)>0 && $resultChk!="")
		{
		return "2";
		}
		else
		{	*/
		/*'username'=>$dataForm['username'],*/	
		//Updating data in main user table	
		$mydata =array('fname'=>$dataForm['branch_name'],					
		'emailaddress'=>$dataForm['email_address'],
		'phoneno'=>$dataForm['phone_number'],
		'mobno'=>$dataForm['mobile_number'],
		'state'=>$dataForm['state_id'],
		'city'=>$dataForm['city_id'],
		'address'=>$dataForm['address'],		
		'lastudpate_on'=>date('Y-m-d H:i:s'),
		'updated_by'=>$mySession->user['userId']);
		$contition="userid='".$branchId."'";
		$Result=$db->modify('rbi_user',$mydata,$contition);
		
		$data = array();
		$data['bname'] = $dataForm['branch_name'];
		$contition="branchId='".$branchId."'";
		$Result=$db->modify('rbi_user_customer',$data,$contition);
		//Update Password for Customer
		/*if(isset($_REQUEST['ChangePass']))
		{		
		$mydata1 =array('password'=>$dataForm['user_password']);
		$contition1="userid='".$branchId."'";
		$Result=$db->modify('rbi_user',$mydata1,$contition1);
		}*/
		
		//Updating data in branch table
		$mydata2 =array('fax'=>$dataForm['fax_number']);
		$contition2="userId='".$branchId."'";
		$Result=$db->modify('rbi_branch',$mydata2,$contition2);		
		
		return "1";
		//}
	}
}
?>