<?php
__autoloadDB('Db');
class IndexController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		global $mySessionFront;
		
    }
	
	public function indexAction()
	{
		
		global $mySessionFront;
		if(isset($mySessionFront->user['FrontUserId'])){
			$this->_redirect('index/welcome');		
			exit;
		}
		
		$db=new Db();
		
		$qry= "SELECT * from tbl_job_categories where show_on_home_page='1' limit 0,6";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->Categories_Data = $GetData;
		//cat_id category_title  category_banner show_on_home_page
		
//==================================================================

	$Home_Cat_Img_Qry="SELECT
tbl_job_categories.category_banner,
tbl_job_categories.category_title,
tbl_job_categories.cat_id
FROM
tbl_job_categories
LEFT JOIN tbl_jobs ON tbl_job_categories.cat_id = tbl_jobs.job_category WHERE cat_id = 2 ORDER BY category_banner";
			//prd($Home_Cat_Img_Qry);
			$Home_Cat_Data = $db->runQuery("$Home_Cat_Img_Qry");
				//prd($Home_Cat_Data);
			$this->view->Home_Cat_Img=$Home_Cat_Data[0];

		$qry="SELECT
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_description,
tbl_jobs.job_posted_on,
tbl_job_categories.category_title,
tbl_users.user_company,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_image,
tbl_jobs.job_city
FROM
tbl_jobs
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id
WHERE job_category ='28'";
			//prd($qry);
			$cat_id = $db->runQuery("$qry");
				//prd($cat_id);
			$this->view->Cat_Details=$cat_id;
		
	}
	
	public function loadjobAction()
	{	
		global $mySessionFront;
		$this->_helper->layout()->setLayout('ajaxlayout');	
		$db=new Db();
		$arr=$this->getRequest()->getParams('cat_id');
		//$this->view->country_id = $arr['country_id'];
		if(@$arr['cat_id']) {
			//prd($arr['user_id']);
			
			$Cat_Img_Qry="SELECT
tbl_job_categories.category_banner,
tbl_job_categories.category_title,
tbl_job_categories.cat_id
FROM
tbl_job_categories
LEFT JOIN tbl_jobs ON tbl_job_categories.cat_id = tbl_jobs.job_category WHERE cat_id ='".$arr['cat_id']."' GROUP BY category_banner";
			//prd($Cat_Img_Qry);
			$Cat_Data_Img = $db->runQuery("$Cat_Img_Qry");
				//prd($Cat_Data_Img);
			$this->view->Cat_Img=$Cat_Data_Img[0];
			
			
			$qry="SELECT
tbl_jobs.id,
tbl_jobs.job_title,
tbl_jobs.job_description,
tbl_jobs.job_posted_on,
tbl_job_categories.category_title,
tbl_users.user_company,
tbl_users.user_type,
tbl_users.user_fname,
tbl_users.user_image,
tbl_jobs.job_city
FROM
tbl_jobs
LEFT JOIN tbl_job_categories ON tbl_jobs.job_category = tbl_job_categories.cat_id
LEFT JOIN tbl_users ON tbl_jobs.user_id = tbl_users.user_id
WHERE job_category ='".$arr['cat_id']."'";
			//prd($qry);
			$cat_id = $db->runQuery("$qry");
				//prd($cat_id);
			$this->view->Cat_Details=$cat_id;
		
		}
	}
	
	public function loginAction(){
		
		global $mySessionFront;
		$this->view->pagetitle="Login...";
		if(isset($mySessionFront->user['FrontUserId'])){
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
				$user 		= 	new Model_FrontUser();
				$result 	= 	$user->authenticateLogin($formData);	
				if(is_array($result)){	
					if($result['user_is_blocked']==1){	
						
						$mySessionFront->user['FrontUserId'] = $result['user_id'];
						$mySessionFront->user['id'] = $result['id'];
						
						$mySessionFront->user['userRole'] = $result['user_type'];
						$mySessionFront->user['UserName']=$result['user_fname'].' '.$result['user_lname'];
						$mySessionFront->user['user_fname']=$result['user_fname'];
						$mySessionFront->user['user_country']=$result['user_country'];
						
						$mySessionFront->user['user_education']=$result['user_education'];
						
						$this->_redirect('index/login');					
						
					}
					else if($result['user_is_blocked']==0){
						$mySessionFront->errorMsg ="your account is disable."; 
						
						$this->_redirect('index/login');	
					}
				}else{
						unset($mySessionFront->user);		
						$mySessionFront->errorMsg ="Invalid username or password."; 
						$this->_redirect('index/login');	
					}
			}
				}
			}
		}
	
				
	}
	
	public function logoutAction(){ 
		global $mySessionFront;
		//unset($mySessionFront->user);
		unset($mySessionFront->user['FrontUserId']);	
		$mySessionFront->sucMsg ="You are logged out successfully."; 	
		$this->_redirect('index/login');	
	}
	
	public function welcomeAction(){
       global $mySessionFront;
		if(!isLoggedFront()) { 
		
			$this->_redirect('index/login');
			
		}
		$this->_redirect('dashboard');
		
	}
	
	
	public function registerAction()
	{	
		$db = new Db();
		//global $mySessionFront; 
		//$this->view->PageTitle="Adding New User:";
		$arr=$this->getRequest()->getParams('user_type');
		
		$form = new Form_Register(); //echo "Akash Hello Dec"; exit;
		$this->view->myform = $form;
		$objRequest = $this->getRequest();
	
		
		
	if ($objRequest->isPost()) {
	 	$formData = $objRequest->getPost();	
		if($form->isValid($formData)){
			
			$data='';
			$data['user_type'] = $formData['user_type'];
			$data['user_fname'] = $formData['user_fname'];
			$data['user_lname'] = $formData['user_lname'];
			$data['user_email'] = $formData['user_email'];
			$data['user_country'] = $formData['Country_id'];
			$data['user_city'] = $formData['user_city'];
			$data['user_nationality'] = $formData['Nationality_id'];
			
			$data['user_gender'] = $formData['user_gender'];
			$data['user_language_preference'] = $formData['user_language_preference'];
			
			$data['user_param'] = md5(rand(100,999));
			//$data['user_dob'] = $formData['user_dob'];
			
			$dtr=explode('-',$formData['user_dob']);
			$data['user_dob'] = $dtr[2].'-'.$dtr[1].'-'.$dtr[0];	
			
			//confirm_user_password
			$data['user_password'] = md5($formData['user_password']);
			
			
			
			/*
				if(md5($formData['confirm_user_password'])!=md5($formData['user_password']))
				{
					$mySessionFront->errorMsg ="Password and confirm password should be same."; 
					//$this->view->myform = $form;
					$this->_redirect('register/add');
				}
				else
				{
					$data['confirm_user_password'] = md5($formData['confirm_user_password']);	
				}
			*/
			
				//prd($data);
			
			//$modelobj = new Model_Mainmodel();
			//$insid = $modelobj->insertThis('tbl_users',$data);
			$modelobj = new Model_Mainmodel();
			$insid = $modelobj->insertThis('tbl_users',$data);
			//$db->save('tbl_users',$data);
//----------------------------------- Sending Mail to User -----------------------------------------------------------
			$FormMsg='<table>
							<tr>
<td>Hello '.$formData['user_fname'].''.$formData['user_lname'].',<br><br> Welcome to Caree Souq, information are following -<br><br></td>																		
							</tr>
							<tr>
								<td>Your User :-&nbsp;'.$formData['user_email'].'</td>
							</tr>
							<tr>
								<td>Password :-&nbsp;'.$formData['user_password'].'</td>
							</tr>
							<tr>
								<td>
<p>Activate your Career Souq A/c, please follow this link:</p>
<p>'.APPLICATION_URL.'index/activac/user_param/'.$data['user_param'].'
</p>
								</td>
							</tr>
							
 					</table>';
					$to= $formData['user_email'];
					$subject = 'Welcome to Caree Souq';
					
					$headers  = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
					//$headers .= 'Bcc: say2me84@gmail.com' . "\r\n";
					$headers .= "From: info@sybite.com <info@sybite.com>\r\n";
					//$to= ADMIN_EMAIL;
					//$headers .= "From: rbiltd.com <info@rbiltd.com>\r\n";
					 mail($to, $subject, $FormMsg, $headers);
					
			$mySessionFront->sucMsg = "New A/c created Success";
			$this->_redirect('index/login');
			} 
		}
	}
	
	
	public function activacAction()
	{	
		global $mySessionFront;
		
		$db=new Db();
		///index/activac/user_param=ad13a2a07ca4b7642959dc0c4c740ab6
		$arr = $this->_request->getParam('user_param');
		
		//prd($arr);
		//ad13a2a07ca4b7642959dc0c4c740ab6
			if($arr['user_param']) {
				$data='';
				$data['user_is_blocked']='1';
				$data['user_verified']='1';	
				
				$modelobj = new Model_Mainmodel();
				$condition="user_param = '".$arr."'";
				$modelobj->updateThis('tbl_users',$data,$condition);
					$mySessionFront->sucMsg = "Your Account is Activated...";	
			
			}
	

		
	}
	
	public function isreadAction(){
		global $mySessionFront;
	  	$this->_helper->layout()->setLayout('ajaxlayout');	
		
		$db=new Db();	
		$arr=$this->getRequest()->getParams();
		
		if($arr['id']) {
			
			//prd($arr);
			$data='';
			$data['is_read']='1';
				//prd($data);
			$modelobj = new Model_Mainmodel();
			//$insid = $modelobj->insertThis('tbl_applied_jobs',$data);
			$condition="id='".$arr['id']."'";
			$modelobj->updateThis('tbl_notifications',$data,$condition);	
			
			}
	}
}
?>
