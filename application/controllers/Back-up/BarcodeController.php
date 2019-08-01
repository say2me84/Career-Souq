<?php
class BarcodeController extends Zend_Controller_Action
{	
	public function init() 
	{
		
	}
	public function indexAction()
	{

	 $_GET['barcodeType']='code39';
 $_GET['text']='ZEND-FRAMEWORK';
 // $_GET['']='';
 Zend_Barcode::render($_GET['barcodeType'], 'image', $_GET, $_GET);
 exit;
 /*
 $barcodeOptions = array('text' => 'TEXT');

$rendererOptions = array('imageType'=>'gif');

Zend_Barcode::factory('code39', 'image', $barcodeOptions, $rendererOptions)->render();*/
exit;
	}	
}