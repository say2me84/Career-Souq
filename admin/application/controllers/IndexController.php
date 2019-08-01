<?php
class IndexController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		global $mySession;
		/*if(!isLogged())
		{ 	
		$this->_redirect('index');	
		}
		
		if($mySession->user['userRole']=='A' || $mySession->user['userRole']=='C')
		{ 	
			$this->_redirect('index');	
		}*/	
    }
	
	public function indexAction()
	{
		
		global $mySession;
		if(isset($mySession->user['userId'])){
			$this->_redirect('index/welcome');		
			exit;
		}
		
		$db=new Db();
		
		//$formc = new Form_Contactus();	
		//$this->view->Form=$form;
		$form = new Form_Login();
		$this->view->loginform = $form;
		
		 if ($this->_request->isPost()) {
			 
            $formData = $this->_request->getPost();
			if(isset($formData['ptype'])) {
				if($formData['ptype']=='contact') { 
					if ($formc->isValid($dataForm))
					{
				
				}
				} else {
					if ($form->isValid($formData)) {
				$user 		= 	new Model_SystemUser();
				$result 	= 	$user->authenticateLoginfront($formData);	
				if(is_array($result)){	
					if($result['status']==1){	
						/*if($result['usrRole']=='SA'){
							$get_rights = $db->runQuery("select rights from rbi_admin where userId='".$result['userid']."'");
							$rightvar = implode(",",explode(",",$get_rights[0]['rights']));
									
							$res_rights=$db->runQuery("select right_definevar from rbi_adminrighs where rightId in (".$rightvar.")");

							if(is_array($res_rights) && count($res_rights) > 0) { 
								$right_ar=array();
								
								foreach($res_rights as $r_rig)
								{
									$right_ar[]=$r_rig['right_definevar'];
								}		
								$mySession->user['rights']= implode("|",$right_ar);	
							}
						}*/
						$mySession->user['Name']=$result['fname'].' '.$result['lname'];
						$mySession->user['UserName']=$result['username'];	
						$mySession->user['userId'] = $result['userid'];
						$mySession->user['userRole'] = $result['usrRole'];
						$mySession->user['branchonly']=getbranch_role($result['userid'],$result['usrRole']);
						$this->_redirect('index/index');					
						
					}
					else if($result['status']==0){
						$mySession->errorMsg ="your account is disable."; 
						
						$this->_redirect('index');	
					}
				}else{
						unset($mySession->user);		
						$mySession->errorMsg ="Invalid username or password."; 
						$this->_redirect('index');	
					}
			}
				}
			}
		}
	
				
	}
	
	public function changepasswordAction(){
		 global $mySession;
		if(!isLogged()) { 
		
			$this->_redirect('index');
			exit;
		}
		$this->view->pagetitle = 'Change Password';
		$modelobj = new Model_Mainmodel();
	
		$changeup = new Form_Changeup();
		$changeup->frm_p(); 
		$this->view->changeup = $changeup;
		$this->view->chps = 1;
		$request = $this->getRequest();
		
		$request = $this->getRequest();
			if ($this->getRequest()->isPost()) 
			{
				$dataForm = $this->_request->getPost();
				if ($changeup->isValid($dataForm)) {
					$Data='';
					
					$db= new Db();
					$getoldconf = $db->runQuery("select password from rbi_user where userid='".$mySession->user['userId']."' and password='".$dataForm['_oldpass']."'");
					
					if(is_array($getoldconf) && count($getoldconf) > 0) {
						if(md5($dataForm['_oldpass']) == md5($getoldconf[0]['password'])) {
							$Data = array();
							$Data['password']=$dataForm['_pass'];
										
							$where="userid='".$mySession->user['userId']."'";
							 $modelobj->updateThis('rbi_user',$Data,$where);
							$this->view->chps = 0;
							$mySession->errorMsg="Password has been updated successfully";
						} else {
							$mySession->errorMsg="Please enter currect old password";
						}
					} else {
						$mySession->errorMsg="Please enter currect old password";
						
					}
				}
			}
	}
	
	public function welcomeAction(){
       global $mySession;
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		$this->_redirect('dashboard');	
		if($mySession->user['userRole']=='A') {
			$db =  new Db();
			
			$gettodaydue = $db->runQuery("select count(a.user_installment_Id) as cnt, sum(a.InstallmentAmount) as amt from rbi_user_scheme_installment as a inner join rbi_user_to_scheme as b on(a.user_schemeId=b.user_schemeId) inner join rbi_user_customer as c on (b.userid=c.userId) where a.InstallmentDueDate like '".date('Y-m-d')."%' and a.Installment_status='0' and c.custstaus='1'");
			$this->view->todaydue = 0;
			$this->view->todaydueamount = 0;
			if(is_array($gettodaydue) && count($gettodaydue))
			{
				$this->view->todaydue = $gettodaydue[0]['cnt'];
				$this->view->todaydueamount = $gettodaydue[0]['amt'];
			}
			
			$getthismonthdue = $db->runQuery("select count(a.user_installment_Id) as cnt, sum(a.InstallmentAmount) as amt from rbi_user_scheme_installment as a inner join rbi_user_to_scheme as b on(a.user_schemeId=b.user_schemeId) inner join rbi_user_customer as c on (b.userid=c.userId) where a.InstallmentDueDate like '".date('Y-m-')."%' and a.Installment_status='0' and b.scheme_type not in (1,2,3) and c.custstaus='1'");
			$this->view->thismonthdue = 0;
			$this->view->thismonthdueamount = 0;
			if(is_array($getthismonthdue) && count($getthismonthdue))
			{
				$this->view->thismonthdue = $getthismonthdue[0]['cnt'];
				$this->view->thismonthdueamount = $getthismonthdue[0]['amt'];
			}
			
			$getthismonthdailydue = $db->runQuery("select count(a.user_installment_Id) as cnt, sum(a.InstallmentAmount) as amt from rbi_user_scheme_installment as a inner join rbi_user_to_scheme as b on(a.user_schemeId=b.user_schemeId) inner join rbi_user_customer as c on (b.userid=c.userId) where a.InstallmentDueDate like '".date('Y-m-')."%' and a.Installment_status='0' and b.scheme_type in (1,2,3) and c.custstaus='1'");
			$this->view->thismonthdailydue = 0;
			$this->view->thismonthdailydueamount = 0;
			if(is_array($getthismonthdailydue) && count($getthismonthdailydue))
			{
				$this->view->thismonthdailydue = $getthismonthdailydue[0]['cnt'];
				$this->view->thismonthdailydueamount = $getthismonthdailydue[0]['amt'];
			}
			
			$getolddue = $db->runQuery("select count(a.user_installment_Id) as cnt, sum(a.InstallmentAmount) as amt from rbi_user_scheme_installment as a inner join rbi_user_to_scheme as b on(a.user_schemeId=b.user_schemeId) inner join rbi_user_customer as c on (b.userid=c.userId) where a.InstallmentDueDate <= '".date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')))."%' and a.Installment_status='0' and c.custstaus='1'");
			$this->view->olddue = 0;
			$this->view->olddueamount = 0;
			if(is_array($getolddue) && count($getolddue))
			{
				$this->view->olddue = $getolddue[0]['cnt'];
				$this->view->olddueamount = $getolddue[0]['amt'];
			}
			
			
			$gettodaypay = $db->runQuery("select count(user_installment_Id) as cnt from rbi_user_scheme_installment where Installment_Paidon like '".date('Y-m-d')."%' and Installment_status='1'");
			$this->view->todaypay = 0;
			if(is_array($gettodaypay) && count($gettodaypay))
			{
				$this->view->todaypay = $gettodaypay[0]['cnt'];
			}
			
			$getthismonthpay = $db->runQuery("select count(a.user_installment_Id) as cnt from rbi_user_scheme_installment as a inner join rbi_user_to_scheme as b on (a.user_schemeId=b.user_schemeid) where InstallmentDueDate like '".date('Y-m-')."%' and a.Installment_status='0' and b.scheme_type not in (1,2,3)");
			$this->view->thismonthpay = 0;
			if(is_array($getthismonthpay) && count($getthismonthpay))
			{
				$this->view->thismonthpay = $getthismonthpay[0]['cnt'];
			}
			
			$getthismonthdailypay = $db->runQuery("select count(a.user_installment_Id) as cnt from rbi_user_scheme_installment as a inner join rbi_user_to_scheme as b on (a.user_schemeId=b.user_schemeid) where InstallmentDueDate like '".date('Y-m-')."%' and a.Installment_status='0' and b.scheme_type in (1,2,3)");
			$this->view->thismonthdailypay = 0;
			if(is_array($getthismonthdailypay) && count($getthismonthdailypay))
			{
				$this->view->thismonthdailypay = $getthismonthdailypay[0]['cnt'];
			}
			
			$getoldpay = $db->runQuery("select count(user_installment_Id) as cnt from rbi_user_scheme_installment where InstallmentDueDate <= '".date('Y-m-d',mktime(0,0,0,date('m')-1,1,date('Y')))."%' and Installment_status='0'");
			$this->view->oldpay = 0;
			if(is_array($getoldpay) && count($getoldpay))
			{
				$this->view->oldpay = $getoldpay[0]['cnt'];
			}
			
			
			$gettotalnewcollection = $db->runQuery("select sum(InstallmentAmount + PaniltyAmount) as tcls from rbi_user_scheme_installment where Installment_Paidon like '".date('Y-m-')."%' and Installment_status='1' and instno='1'");
			$this->view->totalnewcollection = 0;
			if(is_array($gettotalnewcollection) && count($gettotalnewcollection))
			{
				if($gettotalnewcollection[0]['tcls']) {
					$this->view->totalnewcollection = $gettotalnewcollection[0]['tcls'];
				}
			}	
			
			$gettotalduecollection = $db->runQuery("select sum(InstallmentAmount + PaniltyAmount) as tcls from rbi_user_scheme_installment where Installment_Paidon like '".date('Y-m-')."%' and Installment_status='1' and instno!=1 and InstallmentDueDate like '".date('Y-m-')."%'");
			$this->view->totalduecollection = 0;
			if(is_array($gettotalduecollection) && count($gettotalduecollection))
			{
				if($gettotalduecollection[0]['tcls']) {
					$this->view->totalduecollection = $gettotalduecollection[0]['tcls'];
				}
			}	
			
			$gettotaloldduecollection = $db->runQuery("select sum(InstallmentAmount + PaniltyAmount) as tcls from rbi_user_scheme_installment where Installment_Paidon like '".date('Y-m-')."%' and Installment_status='1' and instno!=1 and InstallmentDueDate < '".date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y')))."'");
			$this->view->totaloldduecollection = 0;
			if(is_array($gettotaloldduecollection) && count($gettotaloldduecollection))
			{
				if($gettotaloldduecollection[0]['tcls']) {
					$this->view->totaloldduecollection = $gettotaloldduecollection[0]['tcls'];
				}
			}
			
			
			$gettotaladvancecollection = $db->runQuery("select sum(InstallmentAmount + PaniltyAmount) as tcls from rbi_user_scheme_installment where Installment_Paidon like '".date('Y-m-')."%' and Installment_status='1' and instno!=1 and InstallmentDueDate >= '".date('Y-m-d',mktime(0,0,0,date('m')+1,1,date('Y')))."'");
			$this->view->totaladvancecollection = 0;
			if(is_array($gettotaladvancecollection) && count($gettotaladvancecollection))
			{
				if($gettotaladvancecollection[0]['tcls']) {
					$this->view->totaladvancecollection = $gettotaladvancecollection[0]['tcls'];
				}
			}	
			
			$getmatuirity = $db->runQuery("select count(user_schemeid) as cnt from rbi_user_to_scheme where expire_on like '".date('Y-m-')."%' ");
			$this->view->totalmaturity = 0;
			if(is_array($getmatuirity) && count($getmatuirity))
			{
				$this->view->totalmaturity = $getmatuirity[0]['cnt'];
			}	
			
			$getcustomer = $db->runQuery("select count(userid) as cnt from rbi_user where created_on like '".date('Y-m-')."%' and usrRole='C' ");
			$this->view->totalcustomer = 0;
			if(is_array($getcustomer) && count($getcustomer))
			{
				$this->view->totalcustomer = $getcustomer[0]['cnt'];
			}	
			
			$getagent = $db->runQuery("select count(userid) as cnt from rbi_user where created_on like '".date('Y-m-')."%' and usrRole='AG' ");
			$this->view->totalagent = 0;
			if(is_array($getagent) && count($getagent))
			{
				$this->view->totalagent = $getagent[0]['cnt'];
			}		
					
		}
		///echo $mySession->user['userRole'];
    }
	
	public function logoutAction(){ 
		global $mySession;
		unset($mySession->user);	
		$mySession->errorMsg ="You are logged out successfully."; 	
		$this->_redirect('index');	
	}
	
	
	/// ---------------------- CITY --------------------
	public function getstatecityAction()
	{
		global $mySession;
		$db=new Db();
		$Result=$db->runQuery("select * from jok_city where stateid='".$_REQUEST['stateId']."'");
		?>
		<select name="city_id" id="city_id">
		<option value="">--City--</option>
		<?				
		if($Result!="" and count($Result)>0)
		{
			foreach($Result as $key=>$cityData)
			{
			?>
			<option value="<?=$cityData['cityid']?>"><?=$cityData['city']?></option>
			<?
			}
		}
		?>
		</select>
		<?
		exit();
	}
	

}
?>
