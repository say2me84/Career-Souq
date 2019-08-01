<?php

class TestimonialController extends Zend_Controller_Action
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
		$this->view->pagetitle="Testimonials";
		
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
		if (!$sortname) $sortname = 'testimonial_id';
		if (!$sortorder) $sortorder = 'asc';		
		$where="where 1";
			
		$sort = "ORDER BY $sortname $sortorder";					
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;		
		$start = (($page-1) * $rp);		
		$limit = "LIMIT $start, $rp";
		
		//$show_on_home['_self'] = 'New Window';
		//$show_on_home['_blank'] ='Same Window';
		
		$qry="SELECT * FROM `tbl_admin_messages`";
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
		if(isset($roles[0]) && $roles[0]['testimonial_id']!="")
		{
		$i=1;
		foreach($roles as $row)
		{			
			if ($rc) $json .= ",";
			$json .= "\n{";
			$json .= "id:'".$row['testimonial_id']."',";
			$json .= "cell:['".$i."'";
			
			
			$json .= ",'".$row['name']."'";
			$json .= ",'".$row['company']."'";
			$json .= ",'".$row['designation']."'";
			//$json .= ",'".$show_on_home[$row['designation']]."'";
			
			//$json .= ",'".$row['banner_image']."'";
			 
			//$json .= ",'<img width=\"15\" height=\"15\" title=\"Edit\" alt=\"Edit\" src=\"".IMAGES_BANNER."/banners'".$row['banner_image']."'\" border=\"0\" />'";
			
			$json .= ",'<a href=\"".APPLICATION_URL."testimonial/edit/testimonial_id/".$row['testimonial_id']."\"><img title=\"Edit\" alt=\"Edit\" src=\"".APPLICATION_URL."/images/edit.png\" border=\"0\" /></a>'";			
			$json .= ",'<a href=\"".APPLICATION_URL."testimonial/del/testimonial_id/".$row['testimonial_id']."\"><img title=\"Delete\" alt=\"Delete\" src=\"".APPLICATION_URL."/images/deleteicon.png\" border=\"0\" /></a>'";			
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
		
		$this->view->pagetitle = 'Add Comment';
		$form = new Form_Testimonial();
		$this->view->myform=$form;		
		
		 if ($this->_request->isPost()) {		 
	
            $formData = $this->_request->getPost();			
			if ($form->isValid($formData)) {
			
				$data='';
				
				$data['name'] = $formData['name'];
				$data['company'] = $formData['company'];
				$data['designation'] = $formData['designation'];
				$data['email'] = $formData['email'];
				$data['phone'] = $formData['phone'];
				$data['subject'] = $formData['subject'];
				$data['message'] = $formData['message'];
				$data['is_read'] = '0';
				$data['left_on'] = date("Y-m-d");
				
				if(is_array($_FILES['avator']) && $_FILES['avator']['name']!='') {
						
						$ftype = $_FILES['avator']['type'];
						$fname = $_FILES['avator']['name'];
						
						$fid = preg_replace('/[^a-zA-Z0-9]/s', '', $fname);
						
						$uploaddir = "upload/testimonial_pic/";
						$ext = end(explode(".", $fname));
						$filename = 'Testimonial_'.rand(100,900).'.'.$ext;
						$uploadfile = $uploaddir . $filename;
						//prd($uploadfile);
						// unlink Dir
						
						//$dir = "upload/testimonial_pic/";
						//unlink($dir.$formData['OldImagePath']);
						
						if (move_uploaded_file($_FILES['avator']['tmp_name'], $uploadfile)) {
								//echo "Testin...."; exit;			  
						  
						  $data['avator'] = $filename;
						 
						 }
					}
					
				//prd($data);
				
				$modelobj = new Model_Mainmodel();
				$insid = $modelobj->insertThis('tbl_admin_messages',$data);
//----------------------------------- Uploading Image Files -----------------------------------------------------------avator
				$mySession->sucMsg = "Testimonial added successfully updated";
				$this->_redirect('Testimonial/index');
			}
		 }
	}

		
	//Editing Records...
	public function editAction()
	{	
		global $mySession;
		$db=new Db();
		$this->view->pagetitle = 'Edit Testimonial';
		//$arr=$this->getRequest()->getParams('id');
		$arr=$this->getRequest()->getParams();
		if($arr['testimonial_id']) {
		$this->view->id = $arr['testimonial_id'];
		$form = new Form_Testimonial($arr['testimonial_id']);
		$this->view->myform=$form;	
		
		$qry="SELECT * FROM tbl_admin_messages where testimonial_id='".$arr['testimonial_id']."'";	
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
						
						$uploaddir = 'upload/testimonial_pic/';
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
