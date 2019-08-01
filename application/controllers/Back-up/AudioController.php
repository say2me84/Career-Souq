<?php
class AudioController extends Zend_Controller_Action
{
    public function init() {
        /* Initialize action controller here */
		
		
    }
	
	public function indexAction()
	{	//echo "akash"; exit;
		$db = new Db();
		$qry= "SELECT * FROM `jok_clientaudio`";
		$GetData = $db->runQuery($qry);
		//prd($GetData); exit;
		$this->view->allaudio = $GetData;	
	
		$qry1= "SELECT * FROM `jok_Cat`";
		$GetData1 = $db->runQuery($qry1);
		//prd($GetData); exit;
		$this->view->categorytitle = $GetData1;	
	
	}
	
	
	public function viewaudioAction()
	{	//echo "akash"; exit;
		global $mySession;
		$db=new Db();
		$qry5="SELECT * FROM jok_clientaudio where ClientAudioSno=".$_REQUEST['ClientVideoSno']."";
		//echo $qry; exit;
		$result=$db->runQuery($qry5);
		$this->view->result =$result[0];
		//prd($GetData); exit;
		
		
	}
	
   
}
?>
