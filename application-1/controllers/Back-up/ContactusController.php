<?php
class ContactusController extends Zend_Controller_Action
{
    public function init()
	{
        /* Initialize action controller here */
		
		
    }

    public function indexAction()
	{
        global $mySession;
		$form = new Form_Contactus();
	
	$this->view->Form=$form;
					
			$request=$this->getRequest();
			$Form = new Form_Contactus();
			if ($this->getRequest()->isPost())
			{	
			$dataForm = $this->_request->getPost();
					if ($form->isValid($dataForm))
					{
						$dataForm='<table>
										<tr>
											<td>Hello Administrator,<br><br> Your got a enquiry mail from rbiltd.com, information are following -<br><br></td>																		
										</tr>
										<tr>
											<td>Name : '.$dataForm['name'].'</td>																		
										</tr>
										<tr>
											<td>Address : '.$dataForm['address'].'</td>																					
										</tr>
										<tr>
											<td>Subject : '.$dataForm['subject'].'</td>
										</tr>
										<tr>
											<td>Messag :-<br>'.$dataForm['message'].'</td>
										</tr>
								</table>';
								
								
								$subject = 'Mail From rbiltd.com :: Contact Us -'.$dataForm['subject'];
								$to= 'info@rbiltd.com';
								
								$headers  = "MIME-Version: 1.0\r\n";
								$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
								$headers .= 'Bcc: mscosian@yahoo.co.in' . "\r\n";
								$headers .= "From: rbiltd.com <info@rbiltd.com>\r\n";
								
								$mailsent = @mail($to, $subject, $dataForm, $headers);
								$mySession->errorMsg ="E-mail sent successfully"; 
								$this->_redirect('contactus/index');
						}
			
			}
    }
	
	

}
?>
