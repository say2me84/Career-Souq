<?php
class SendsmsController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }

    public function indexAction(){
        global $mySession;
		if(!isLogged()) { 
		
			$this->_redirect('index');
			
		}
		if($mySession->user['userRole']=='A' || getsubadmin_role('sendsms'))
		{ 	
		
		} else {
			$this->_redirect('index');	
		}
		
		$form = new Form_Sendsms();
		$form->sendsms();
		$this->view->Form = $form;
		if ($this->getRequest()->isPost()) 
		{
			$dataForm = $this->_request->getPost();
			
			if ($form->isValid($dataForm))
			{
				$user="RBILTD"; //your username
				 $password="rbi#1234"; //your password
				 $mobilenumbers=$dataForm['_phnolist']; //enter Mobile numbers comma seperated
				 $message = $dataForm['_smstext']; //enter Your Message 
				 $senderid="SMSCountry"; //Your senderid
				 $messagetype="N"; //Type Of Your Message
				 $DReports="Y"; //Delivery Reports
				 $url="http://www.smscountry.com/SMSCwebservice.asp";
				 $message = urlencode($message);
				 $ch = curl_init(); 
				 if (!$ch){die("Couldn't initialize a cURL handle");}
				 $ret = curl_setopt($ch, CURLOPT_URL,$url);
				 curl_setopt ($ch, CURLOPT_POST, 1);
				 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);          
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				 curl_setopt ($ch, CURLOPT_POSTFIELDS, 
				"User=$user&passwd=$password&mobilenumber=$mobilenumbers&message=$message&sid=$senderid&mtype=$messagetype&DR=$DReports");
				 $ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				
				
				//If you are behind proxy then please uncomment below line and provide your proxy ip with port.
				// $ret = curl_setopt($ch, CURLOPT_PROXY, "PROXY IP ADDRESS:PORT");
				
				
				
				 $curlresponse = curl_exec($ch); // execute
				if(curl_errno($ch))
					echo 'curl error : '. curl_error($ch);
					$mySession->errorMsg ="Message Sending Failed."; 
					$this->_redirect('sendsms/index');
				 if (empty($ret)) {
					// some kind of an error happened
					die(curl_error($ch));
					curl_close($ch); // close cURL handler
				 } else {
					$info = curl_getinfo($ch);
					curl_close($ch); // close cURL handler
					//echo "<br>";
					//echo $curlresponse;    //echo "Message Sent Succesfully" ;
				   $mySession->errorMsg ="Message Sent Successfully."; 
					$this->_redirect('sendsms/index');
				 }
				
			}
		}
		///echo $mySession->user['userRole'];
    }
}
?>
