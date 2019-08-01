<?php
class Model_Receiptno extends Db
{
	public function InsertRecieptno($dataForm)
	{		
		global $mySession;
		$db=new Db();
		$userid=0;
		$usercheck =0;
		$resultuserChk=$db->runQuery("select userId from rbi_user where profileId='".$dataForm['usercode']."'");
		
		if(count($resultuserChk)>0 && $resultuserChk!="")
		{
			$userid=$resultuserChk[0]['userId'];
			$usercheck =1;
		} 
		
		if($dataForm['rto']) { $tovalue = $dataForm['rto']; } else { $tovalue=0; }
		
		$resultChk=$db->runQuery("select * from rbi_receipt where (recno='".$dataForm['rfrom']."' or recno='".$tovalue."' or (recno > '".$dataForm['rfrom']."' and recno <'".$tovalue."'))");
	
		if(count($resultChk)>0 && $resultChk!="")
		{
			return "2";
		}
		elseif($tovalue < $dataForm['rfrom'] && $tovalue!=0)
		{		
			return "3";
		} elseif($usercheck==0) {
			return "4";
		} else {
		//Inserting data in main user table	
			
			if($tovalue!=0) {
				for($a=$dataForm['rfrom']; $a <=$tovalue;$a++)
				{
					$mydata='';
					$mydata['allotto']=$userid;
					$mydata['recno']=$a;
					$mydata['created_on']=date('Y-m-d H:i:s');
					$mydata['created_by']=$mySession->user['userId'];
					$Result=$db->save('rbi_receipt',$mydata);
				}
			} else {
				$mydata='';
				$mydata['allotto']=$userid;
				$mydata['recno']=$dataForm['rfrom'];
				$mydata['created_on']=date('Y-m-d H:i:s');
				$mydata['created_by']=$mySession->user['userId'];
				$Result=$db->save('rbi_receipt',$mydata);
			}
				
		return "1";
		}
	}
	
}
?>