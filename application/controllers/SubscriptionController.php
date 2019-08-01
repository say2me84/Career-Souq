<?php
__autoloadDB('Db');
class SubscriptionController extends Zend_Controller_Action
{

	public function init() 
	{	
		global $mySessionFront;
		if(!isLogged())
		{ 	
		$this->_redirect('index/login');	
		
		}
		
	}


	public function testvalAction()
	{	
		global $mySessionFront;
		$db = new Db();
		$this->view->pagetitle="Job Subscription Plans";
		//echo "akash";
		
	}
	//View Records...
	public function indexAction()
	{	
		global $mySessionFront;
		$db = new Db();
		$this->view->pagetitle="Job Subscription Plans";
		//echo "akash";
		
		/*$Job_Plan_Combo_Qry= "select * from Job_Plan_Combo";
		$Job_Plan_Combo_Val = $db->runQuery($Job_Plan_Combo_Qry);
		//prd($Job_Search_Val); 
		$this->view->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];*/
	}
	public function packsuccessAction()
	{	
		
		global $mySessionFront;
		$db=new Db();
		$this->view->pagetitle="Job Package Plans";
		
			$qry="SELECT MAX(Invoice) AS My_Plan_Sno FROM user_plan_details";
			//prd ($qry);
			$result=$db->runQuery($qry);
			//prd($result);
			$maxid=5000;
			if(is_array($result) && count($result) >0)
			{
				if($result[0]['My_Plan_Sno'] > 4999) {
					$maxid=$result[0]['My_Plan_Sno']+1;
					//$data['Invoice']= $maxid;
				}
			}
		
		$item_no = $_REQUEST['item_number'];
		$item_transaction = $_REQUEST['tx']; // Paypal transaction ID
		$item_price = $_REQUEST['amt']; // Paypal received amount
		$item_currency = $_REQUEST['cc']; // Paypal received currency type
		$Package_Name = $_REQUEST['cm']; // Package Name
		
		//prd($item_no.'<br>'.$item_transaction.'<br>'.$item_price.'<br>'.$item_currency.'<br>'.$Package_Name);
		
		$Credit_Qry="SELECT * FROM tbl_users where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Credit_Qry);
		$Job_Credit_Result=$db->runQuery($Credit_Qry);
		//prd($Job_Credit_Result);
						
		$value = $item_price;
		$myPrice = str_replace('.00', '', $value);
		//prd($myPrice);
		
		$Job_Plan_Combo_Qry= "select * from job_plan_combo where Price ='$myPrice'";
		//prd ($Job_Plan_Combo_Qry);
		$Job_Plan_Combo_Val = $db->runQuery($Job_Plan_Combo_Qry);
		//prd($Job_Plan_Combo_Val); 
		$this->view->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];
		$res=$this->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];
		//prd($res);
		
		
		$arr=$this->getRequest()->getParams();
		
		//========= Cal Job Posting Days ================///
			$job_post = new DateTime();
			$job_post->modify("+20 days");
			$job_post_days = $job_post->format("Y-m-d");
		//echo 'Akash &nbsp;'.$d->format("Y-m-d");
		
		//========= Cal Featured Job Posting Days ================///
			$Featured = new DateTime();
			$Featured->modify("+20 days");
			$Featured_Job_Days = $Featured->format("Y-m-d");
		//echo 'Akash &nbsp;'.$d->format("Y-m-d");
		
		//========= Cal CV Posting Days ================///
			$CV_Days = new DateTime();
			//prd($CV_Days);
			$CV_Days->modify("+20 days");
			$CV_Posting_Days = $CV_Days->format("Y-m-d");
		//prd($CV_Posting_Days);
		if($res['Price']) {
			
			//prd($arr);
			$data='';
			$data['user_id']= $mySessionFront->user['FrontUserId'];
			$data['job_posting_membership_start_dt']= date('Y-m-d');
			$data['job_posting_membership_expire']= $job_post_days;
			$data['membership_plan_name']= $Package_Name;
			$data['user_normal_jobs_val']= $res['Job_Posting'];
			
			$data['user_featured_jobs_start_dt']= date('Y-m-d');
			$data['user_featured_jobs_expire']= $Featured_Job_Days;
			$data['user_featured_jobs_val']= $res['Featured_Job_Posting'];
			
			$data['user_resume_membership_start_dt']= date('Y-m-d');
			$data['user_resume_membership_expires']= $CV_Posting_Days;
			$data['user_resume_membership_val']= $res['Days_CV_Search'];
			$data['Invoice']= $maxid;
			$data['Amt']= $myPrice;
			
		//	prd($data);
		$modelobj = new Model_Mainmodel();
		$modelobj->insertThis('user_plan_details',$data);
			//$modelobj->insertThis('tbl_notifications',$data,$condition);

//================================ Updating Job in user A/c ================================================
			$CV_Days = new DateTime();
			//prd($CV_Days);
			$CV_Days->modify("+20 days");
			
			$Job_Posting_Daya = $CV_Days->format("Y-m-d");
			$CV_Posting_Days = $CV_Days->format("Y-m-d");
			$Featured_Job_Posting = $CV_Days->format("Y-m-d");
			
			//prd($CV_Posting_Days);
			
			
			$data1['user_jobs_available']= $Job_Credit_Result[0]['user_jobs_available']+$res['Job_Posting'];
			$data1['user_jobs_expire_on']= $Job_Posting_Daya;
			
			$data1['user_featured_jobs_available']= $Job_Credit_Result[0]['user_featured_jobs_available']+$res['Featured_Job_Posting'];
			$data1['user_featured_jobs_expire_on']= $Featured_Job_Posting;
			
			$data1['user_resume_membership_taken_on']= date("Y-m-d");
			$data1['user_resume_membership_expires_on']= $CV_Posting_Days;
			$data1['user_resume_qty']= $Job_Credit_Result[0]['user_resume_qty']+20;
		//prd($data1);
			
			$condition = "user_id='".$mySessionFront->user['FrontUserId']."'"; //exit;
			$db->modify('tbl_users',$data1,$condition);
			
			$mySessionFront->sucMsg = "Package Updated Success";
		$this->_redirect('Subscription/index');	
			
			}else{
				$mySessionFront->errorMsg = "Package Updated Failed";
		$this->_redirect('Subscription/index');
				}
// http://localhost/sybite/career_souq/Subscription/packsuccess?tx=91147075X6333013Y&st=Completed&amt=90.00&cc=USD&cm=Akash&item_number=1	
	}
	
	//View Records...
	public function jobpostingcreditsAction()
	{	
		global $mySessionFront;
		$db = new Db();
		$this->view->pagetitle="Zone List:";
		//echo "akash";
	}
//=========================== Job Subscription ===================================//	
	public function jobcreditsAction()
	{	
		global $mySessionFront;
		$db = new Db();
		$this->view->pagetitle="Job Subscription Package";
		//echo "akash";
		
		$Job_Search_Qry= "select * from job_posting_plan";
		$Job_Search_Val = $db->runQuery($Job_Search_Qry);
		//prd($Job_Search_Val); 
		$this->view->Job_Search_Data = $Job_Search_Val;
		
		$arr=$this->getRequest()->getParams('Package_Id');
		
		if(@$arr['Package_Id']) {
			//prd($arr);
			
			$qry="select * from `job_posting_plan` where `Package_Id` ='".$arr['Package_Id']."'";
			//prd($qry);
			$Package = $db->runQuery("$qry");
			//prd($Package);
			$this->view->My_Package=$Package;
			
		
		}
		
		
	}
	
	public function jobsuccessAction()
	{	
		
		global $mySessionFront;
		$db=new Db();
		$this->view->pagetitle="Job Package Plans";
		
			$qry="SELECT MAX(Invoice) AS My_Plan_Sno FROM user_plan_details";
			//prd ($qry);
			$result=$db->runQuery($qry);
			//prd($result);
			$maxid=5000;
			if(is_array($result) && count($result) >0)
			{
				if($result[0]['My_Plan_Sno'] > 4999) {
					$maxid=$result[0]['My_Plan_Sno']+1;
					//$data['Invoice']= $maxid;
				}
			}
		
		$item_no = $_REQUEST['item_number'];
		$item_transaction = $_REQUEST['tx']; // Paypal transaction ID
		$item_price = $_REQUEST['amt']; // Paypal received amount
		$item_currency = $_REQUEST['cc']; // Paypal received currency type
		$Package_Name = $_REQUEST['cm']; // Package Name
		
		//prd($item_no.'<br>'.$item_transaction.'<br>'.$item_price.'<br>'.$item_currency.'<br>'.$Package_Name);
		
		$Credit_Qry="SELECT * FROM tbl_users where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Credit_Qry);
		$Job_Credit_Result=$db->runQuery($Credit_Qry);
		//prd($Job_Credit_Result);
						
		$value = $item_price;
		$myPrice = str_replace('.00', '', $value);
		//prd($myPrice);
		
		$Job_Plan_Combo_Qry= "select * from job_posting_plan where Price ='$myPrice'";
		//prd ($Job_Plan_Combo_Qry);
		$Job_Plan_Combo_Val = $db->runQuery($Job_Plan_Combo_Qry);
		//prd($Job_Plan_Combo_Val); 
		$this->view->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];
		$res=$this->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];
		
		$dtr=explode('-',$res['Package/Days']);
		$job_days = $Add_Days['salary'] =$dtr[1];
		//prd($job_days);
		//Package/Days
		
		$arr=$this->getRequest()->getParams();
		
		//========= Cal Job Posting Days ================///
			$job_post = new DateTime();
			$job_post->modify("+30 days");
			$job_post_days = $job_post->format("Y-m-d");
		//echo 'Akash &nbsp;'.$d->format("Y-m-d");
		
		//========= Cal Featured Job Posting Days ================///
			$Featured = new DateTime();
			$Featured->modify("+30 days");
			$Featured_Job_Days = $Featured->format("Y-m-d");
		//echo 'Akash &nbsp;'.$d->format("Y-m-d");
		
		//========= Cal CV Posting Days ================///
			$CV_Days = new DateTime();
			//prd($CV_Days);
			$CV_Days->modify("+20 days");
			$CV_Posting_Days = $CV_Days->format("Y-m-d");
		
		if($res['Price']) {
			$db=new Db();
			//prd($arr);
			$data='';
			$data['user_id']= $mySessionFront->user['FrontUserId'];
			$data['job_posting_membership_start_dt']= date('Y-m-d');
			$data['job_posting_membership_expire']= $job_post_days;
			$data['membership_plan_name']= 'Job Plan';
			$data['user_normal_jobs_val']= $job_days;
			$data['Invoice']= $maxid;
			$data['Amt']= $myPrice;
			
			//prd($data);
			$modelobj = new Model_Mainmodel();
			$modelobj->insertThis('user_plan_details',$data);
			
			//$db->save('user_plan_details',$data); 
			
//================================ Updating Job in user A/c ================================================
			//$CV_Days = new DateTime();
			$New_Job_Days = new DateTime($Job_Credit_Result[0]['user_jobs_expire_on']);
			//prd($New_Job_Days);
			$My_Job_Up_Dt = $New_Job_Days->modify("+20 days");
			//prd($My_Job_Up_Dt);
			$Update_Job_Date = $My_Job_Up_Dt->format("Y-m-d");
			//prd($Update_Job_Date);
			
				//date("d-m-Y", strtotime($My_Job_Up_Dt));
			//prd($New_Job_Posting_Days);
			
			$data1['user_jobs_available']= $Job_Credit_Result[0]['user_jobs_available']+$job_days;
			//$data1['user_jobs_expire_on']= $Update_Job_Date;
			$data1['user_jobs_expire_on']= $job_post_days;
			$data1['user_job_posting_membership_taken_on']= date("Y-m-d");
		//prd($data1);
			
			$condition = "user_id='".$mySessionFront->user['FrontUserId']."'"; //exit;
			$db->modify('tbl_users',$data1,$condition);
			
			$mySessionFront->sucMsg = "Package Updated Success";
		$this->_redirect('Subscription/index');	
			
			}else{
				$mySessionFront->errorMsg = "Package Updated Failed";
		$this->_redirect('Subscription/index');
				}
// http://localhost/sybite/career_souq/Subscription/packsuccess?tx=91147075X6333013Y&st=Completed&amt=90.00&cc=USD&cm=Akash&item_number=1	
	}
	
//localhost/sybite/career_souq/subscription/jobsuccess ?tx=6C8532648M323634C&st=Completed&amt=110.00&cc=USD&cm=Job%20Plan&item_number=3
//============================================== CV Subscription ==========================================================//
	public function cvcreditsAction()
	{	
		global $mySessionFront;
		$db = new Db();
		$this->view->pagetitle="CV Subscription Package";
		//echo "akash";
		
		$Cv_Search_Qry= "select * from cv_search";
		$Cv_Search_Val = $db->runQuery($Cv_Search_Qry);
		//prd($Cv_Search_Val); 
		$this->view->Cv_Search_Data = $Cv_Search_Val;
	}
	
	public function cvsuccessAction()
	{	
		
		global $mySessionFront;
		$db=new Db();
		$this->view->pagetitle="Job Package Plans";
		
			$qry="SELECT MAX(Invoice) AS My_Plan_Sno FROM user_plan_details";
			//prd ($qry);
			$result=$db->runQuery($qry);
			//prd($result);
			$maxid=5000;
			if(is_array($result) && count($result) >0)
			{
				if($result[0]['My_Plan_Sno'] > 4999) {
					$maxid=$result[0]['My_Plan_Sno']+1;
					//$data['Invoice']= $maxid;
				}
			}
		
		$item_no = $_REQUEST['item_number'];
		$item_transaction = $_REQUEST['tx']; // Paypal transaction ID
		$item_price = $_REQUEST['amt']; // Paypal received amount
		$item_currency = $_REQUEST['cc']; // Paypal received currency type
		$Package_Name = $_REQUEST['cm']; // Package Name
		
		//prd($item_no.'<br>'.$item_transaction.'<br>'.$item_price.'<br>'.$item_currency.'<br>'.$Package_Name);
		
		$Credit_Qry="SELECT * FROM tbl_users where user_id ='".$mySessionFront->user['FrontUserId']."'";
		//prd($Credit_Qry);
		$Job_Credit_Result=$db->runQuery($Credit_Qry);
		//prd($Job_Credit_Result);
						
		$value = $item_price;
		$myPrice = str_replace('.00', '', $value);
		//prd($myPrice);
		
		$Job_Plan_Combo_Qry= "select * from cv_search where Price ='$myPrice'";
		//prd ($Job_Plan_Combo_Qry);
		$Job_Plan_Combo_Val = $db->runQuery($Job_Plan_Combo_Qry);
		//prd($Job_Plan_Combo_Val); 
		$this->view->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];
		$res=$this->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];
		
		$dtr=explode('-',$res['Package/Days']);
		$job_days = $Add_Days['salary'] =$dtr[1];
		//prd($job_days);
		//Package/Days
		
		$arr=$this->getRequest()->getParams();
		
		//========= Cal Job Posting Days ================///
			$job_post = new DateTime();
			$job_post->modify("+30 days");
			$job_post_days = $job_post->format("Y-m-d");
		//echo 'Akash &nbsp;'.$d->format("Y-m-d");
		
		//========= Cal Featured Job Posting Days ================///
			$Featured = new DateTime();
			$Featured->modify("+30 days");
			$Featured_Job_Days = $Featured->format("Y-m-d");
		//echo 'Akash &nbsp;'.$d->format("Y-m-d");
		
		//========= Cal CV Posting Days ================///
			$CV_Days = new DateTime();
			//prd($CV_Days);
			$CV_Days->modify("+20 days");
			$CV_Posting_Days = $CV_Days->format("Y-m-d");
		
		if($res['Price']) {
			
			//prd($arr);
			$data='';
			$data['user_id']= $mySessionFront->user['FrontUserId'];
			$data['user_resume_membership_start_dt']= date('Y-m-d');
			$data['user_resume_membership_expires']= $job_post_days;
			$data['membership_plan_name']= 'Cv Plan';
			$data['user_resume_membership_val']= $job_days;
			
			/*$data['user_featured_jobs_start_dt']= date('Y-m-d');
			$data['user_featured_jobs_expire']= $Featured_Job_Days;
			$data['user_featured_jobs_val']= $res['Featured_Job_Posting'];
			
			$data['user_resume_membership_start_dt']= date('Y-m-d');
			$data['user_resume_membership_expires']= $CV_Posting_Days;
			$data['user_resume_membership_val']= $res['Days_CV_Search'];*/
			$data['Invoice']= $maxid;
			$data['Amt']= $myPrice;
			
			//prd($data);
			$modelobj = new Model_Mainmodel();
			$modelobj->insertThis('user_plan_details',$data);
			//$modelobj->insertThis('tbl_notifications',$data,$condition);

//================================ Updating Job in user A/c ================================================
			//$CV_Days = new DateTime();
			$New_Job_Days = new DateTime($Job_Credit_Result[0]['user_jobs_expire_on']);
			//prd($New_Job_Days);
			$My_Job_Up_Dt = $New_Job_Days->modify("+20 days");
			//prd($My_Job_Up_Dt);
			$Update_Job_Date = $My_Job_Up_Dt->format("Y-m-d");
			//prd($Update_Job_Date);
			
			//date("d-m-Y", strtotime($My_Job_Up_Dt));
			//prd($New_Job_Posting_Days);
			
			//$data1['user_jobs_available']= $Job_Credit_Result[0]['user_jobs_available']+$job_days;
			
			//$data1['user_resume_membership_expires_on']= $Update_Job_Date;
			$data1['user_resume_membership_expires_on']= $job_post_days;
			$data1['user_resume_membership_taken_on']= date("Y-m-d");
		//prd($data1);
			
			$condition = "user_id='".$mySessionFront->user['FrontUserId']."'"; //exit;
			$db->modify('tbl_users',$data1,$condition);
			
			$mySessionFront->sucMsg = "Package Updated Success";
		$this->_redirect('Subscription/index');	
			
			}else{
				$mySessionFront->errorMsg = "Package Updated Failed";
		$this->_redirect('Subscription/index');
				}
// http://localhost/sybite/career_souq/Subscription/packsuccess?tx=91147075X6333013Y&st=Completed&amt=90.00&cc=USD&cm=Akash&item_number=1	
	}
	
	public function oldcvsuccessAction()
	{	
			
		global $mySessionFront;
		$db = new Db();
		$this->view->pagetitle="CV Search Package:";
		//echo "akash";
		
		$item_no = $_GET['item_number'];
		$item_transaction = $_GET['tx']; // Paypal transaction ID
		$item_price = $_GET['amt']; // Paypal received amount
		$item_currency = $_GET['cc']; // Paypal received currency type
		$Package_Name = $_GET['cm']; // Package Name
		
		$value = $item_price;
		$myPrice = str_replace('.00', '', $value);
		//echo 'Price &nbsp;'.$myPrice;
		//echo '<br>';
		
		//product,price,currency
		$Job_Plan_Combo_Qry= "select * from cv_search where Price ='$myPrice'";
		//prd ($Job_Plan_Combo_Qry);
		$Job_Plan_Combo_Val = $db->runQuery($Job_Plan_Combo_Qry);
		//prd($Job_Plan_Combo_Val); 
		//$this->view->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];
		$res=$this->Job_Plan_Combo_Data = $Job_Plan_Combo_Val[0];
		//echo $res['Price']; //exit;
		
		
		//========= CV Package/Days ================///
			$dtr=explode('-',$res['Package/Days']);
			$My_CV_Days = $dtr[1];
			//prd($My_CV_Days);
		
		$arr=$this->getRequest()->getParams();
		
		//========= Cal CV Posting Days ================///
			$CV_Days = new DateTime();
			$CV_Days->modify("$My_CV_Days days");
			$CV_Posting_Days = $CV_Days->format("Y-m-d");
			
			//echo 'CV Search Date &nbsp;'.$CV_Posting_Days;
			$qry="SELECT MAX(Invoice) AS My_Plan_Sno FROM user_plan_details";
			//prd ($qry);
			$result=$db->runQuery($qry);
			//prd($result);
			$maxid=5000;
			if(is_array($result) && count($result) >0)
			{
				if($result[0]['My_Plan_Sno'] > 4999) {
					$maxid=$result[0]['My_Plan_Sno']+1;
					//$data['Invoice']= $maxid;
				}
			}
		if($res['Price']) {
			
				//prd($arr);
				$data='';
				$data['user_id']= $mySessionFront->user['FrontUserId'];
				$data['user_resume_membership_start_dt']= date('Y-m-d');
				$data['user_resume_membership_expires']= $CV_Posting_Days;
				$data['user_resume_membership_val']= $My_CV_Days;
				$data['membership_plan_name']= $Package_Name;
				$data['Invoice']= $maxid;
				$data['Amt']= $myPrice;
					//prd($data);
				$modelobj = new Model_Mainmodel();
				
				$modelobj->insertThis('user_plan_details',$data);
				//$modelobj->insertThis('tbl_notifications',$data,$condition);
				$mySessionFront->sucMsg = "CV Search Package Updated Success";
				
				$this->_redirect('subscription/index');	
			
			}else{
				$mySessionFront->errorMsg = "Package Updated Failed";
			
			}
		
	
	}
	
	
}
?>