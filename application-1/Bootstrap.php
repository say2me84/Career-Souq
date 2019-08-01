<?php

include_once(APPLICATION_PATH.'/configs/config.inc.php');

include_once(APPLICATION_PATH.'/configs/general.php');

include_once(APPLICATION_PATH.'/configs/cr.php');

include_once(APPLICATION_PATH.'/configs/messages.php');

__autoloadDB('Db'); 

defined('APPLICATION_ENVIRONMENT')

    or define('APPLICATION_ENVIRONMENT', 'development');

    

ini_set('display_errors','on');

error_reporting(E_ALL);



$frontController = Zend_Controller_Front::getInstance(); 

$frontController->setControllerDirectory(APPLICATION_PATH . '/controllers');

$frontController->setParam('env', APPLICATION_ENVIRONMENT);

//Zend_Layout::startMvc(APPLICATION_PATH . '/layouts/scripts', false, "layout");

Zend_Controller_Action_HelperBroker::addPath('/helpers/','Zend_Controller_Action_Helper_');



$configuration = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'development');



$dbAdapter = Zend_Db::factory($configuration->database);



$dbAdapter->query("SET NAMES 'utf8'");

Zend_Db_Table_Abstract::setDefaultAdapter($dbAdapter);



$registry = Zend_Registry::getInstance();

$registry->configuration = $configuration;

$registry->dbAdapter     = $dbAdapter;





unset($frontController, $view, $configuration, $dbAdapter, $registry);

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{



protected function _initAutoload() {

    

 $modelLoader = new Zend_Application_Module_Autoloader(array(

                  'namespace' => '',

                   'basePath' => APPLICATION_PATH)



);

   

  $modelLoader = new Zend_Application_Module_Autoloader(array(

                  'namespace' => '',

                   'basePath' => APPLICATION_PATH)



);

  		

   // Zend_Loader::loadFile('AppController.php',  APPLICATION_PATH.'/controllers/' , true);

  

  



  

}

}

