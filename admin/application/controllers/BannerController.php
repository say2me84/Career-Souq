<?php

class BannerController extends Zend_Controller_Action
{
	public function init() 
	{	
		global $mySession;
		if(!isLogged())
		{ 	
		$this->_redirect('index');	
		
		}
		
	}
	public function indexAction()
	{	
		global $mySession;
		$db = new Db();
		//prd($db);
		$this->view->pagetitle="Manage Job Banner";
		
	}
	public function generategridAction()
	{	
		global $_CONFIG, $mySession; 
		$db=new Db();
		$this->_helper->viewRenderer->setNoRender();
		$page=$this->getRequest()->page;
		$rp=$this->getRequest()->rp;
		$sortname=$this->getRequest()->sortname;
		$sortorder=$this->getRequest()->sortorder;
		if (!$sortname) $sortname = 'id';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
			
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		
		$show_on_home['_self'] = 'New Window';
		$show_on_home['_blank'] ='Same Window';
		
		$qry="SELECT * FROM `tbl_banners`";
		//prd($qry);
		$roles=$db->runQuery("$qry $where $sort $limit");
		$countQuery=$db->runQuery("$qry $where");		
		$total=count($countQuery);		
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: $total,\n";
		$json .= "rows: [";
		$rc = false;
		if(isset($roles[0]) && $roles[0]['id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['id']."',";
			$json .= "cell:['".$i."'";
			
			
			$json .= ",'".$row['banner_alt']."'";
			$json .= ",'".$row['banner_link']."'";
			
			$json .= ",'".$show_on_home[$row['banner_window_open']]."'";
			
			//$json .= ",'".$row['banner_image']."'";
			 
			//$json .= ",'<img width=\"15\" height=\"15\" title=\"Edit\" alt=\"Edit\" src=\"".IMAGES_BANNER."/banners'".$row['banner_image']."'\" border=\"0\" />'";
			
			$json .= ",'<a href=\"".APPLICATION_URL."banner/edit/id/".$row['id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."banner/del/id/".$row['id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
			$json .= "]}";
			$rc = true;
			$i++;
		}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;		
		exit();
	}
	
	//Add New Records...
	public function addAction()
	{	
		global $mySession;
		
		$this->view->pagetitle = 'Add Banner';
		$form = new Form_Banner();
		$this->view->myform=$form;		
		
		 if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
				$data='';
				
				$data['banner_alt'] = $formData['banner_alt'];
				$data['banner_link'] = $formData['banner_link'];
				$data['banner_window_open'] = $formData['banner_window_open'];
				$data['banner_window_open'] = $formData['banner_window_open'];
				
				
				$modelobj = new Model_Mainmodel();
				$insid = $modelobj->insertThis('tbl_banners',$data);
//----------------------------------- Uploading Image Files -----------------------------------------------------------
				if(is_array($_FILES['banner_image']) && $_FILES['banner_image']['name']!='') {
					
					$ftype = $_FILES['banner_image']['type'];
					$fname = $_FILES['banner_image']['name'];
					$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
					$uploaddir = 'upload/banners/';
					$ext = end(explode(".", $fname));
					$filename = $insid.rand(100,900).'.'.$ext;
					$uploadfile = $uploaddir . $filename;
					//prd($filename);
					if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $uploadfile)) {
					  $data = '';
					  $data['banner_image'] = $filename;
					  $condition = "id='".$insid."'";
						//prd($data);
					  $modelobj->updateThis('tbl_banners',$data,$condition);
					  }
				}

				$mySession->sucMsg = "Banner added successfully updated";
				$this->_redirect('Banner/index');
			}
		 }
	}

		
	//Editing Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Edit Job Banner';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['id']) {
		$this->view->id = $arr['id'];
		$form = new Form_Banner($arr['id']);
		$this->view->myform=$form;	
		
		$qry="SELECT * FROM tbl_banners where id='".$arr['id']."'";	
		$GetData = $db->runQuery($qry);
		$this->view->bannerImg = $GetData;
			//$data=$detail[0];
			
		
		if ($this->_request->isPost()) {		 
			$formData = $this->_request->getPost();
			//prd($formData);	
			if ($form->isValid($formData)) {
			//prd($formData);	
			$Data='';
			$Data['banner_alt'] = $formData['banner_alt'];
			$Data['banner_link'] = $formData['banner_link'];
			$Data['banner_window_open'] = $formData['banner_window_open'];
			
			if(is_array($_FILES['banner_image']) && $_FILES['banner_image']['name']!='') {
						
						$ftype = $_FILES['banner_image']['type'];
						$fname = $_FILES['banner_image']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = 'upload/banners/';
						$ext = end(explode(".", $fname));
						$filename = $arr['id'].rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						
						//$old_image = $_POST['himage'] ;
						//@unlink($old_image );
						
						/*if(is_file(BANNER_IMG. $formData['OldImagePath']))
						{
							unlink(BANNER_IMG. $formData['OldImagePath']) ;
						}*/
						
						$dir = "upload/banners/";
						unlink($dir.$formData['OldImagePath']);
						
						if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $uploadfile)) {
								//echo "Testin...."; exit;			  
						  
						  $Data['banner_image'] = $filename;
						 
						 }
					}
//----------------------------------- Uploading Image Files -----------------------------------------------------------
			 //prd($Data);	
			$condition = "id='".$arr['id']."'";
			$db->modify('tbl_banners',$Data,$condition);
			$mySession->sucMsg = "Banner has been successfully updated";
			$this->_redirect('Banner/index');
				}
			 }
		}
	}
	
	//Del Records...
	public function delAction()
	{	
		global $mySession;
		$db = new Db();
		$this->view->PageTitle="Delete Record..";
		$delData = $this->getRequest()->getParams();
		//prd($delData);
		$mid="id=".$delData['id'];
		$Result=$db->delete('tbl_job_categories',$mid); 
		//prd($Result); exit;
		if($Result==1){
		
		$mySession->sucMsg="Category Deleted Successfully";
		$this->_redirect('category/index');
		}else{
		die('Error');
		}
	}
	

}
?>
