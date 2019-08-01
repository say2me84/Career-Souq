<?php
 	class Model_Paging
	{
		
		protected $_table;
		//$itemsPerPage=20;
		public function __construct()
		{
			require_once 'Zend/Loader/Autoloader.php';
			// register auto-loader
			$loader = Zend_Loader_Autoloader::getInstance();	
		}
		
		public function paging_data_list($data)
		{	
			try {  
					if(!$data){
					  $data=array(); 
					}
			
			// initialize pager with data set
			$pager = new Zend_Paginator(new Zend_Paginator_Adapter_Array($data));
			// set page number from request
			$currentPage = isset($_GET['p']) ? (int) htmlentities($_GET['p']) : 1;
			$pager->setCurrentPageNumber($currentPage);
			// set number of items per page from request
			$itemsPerPage = isset($_GET['c']) ? (int) htmlentities($_GET['c']) : 30;
			$pager->setItemCountPerPage($itemsPerPage);
			// set number of pages in page range
			$pager->setPageRange(5);
			// get page data  
			return $pager->getCurrentItems();
			  
			 } catch(Exception $e) {
			  die ('ERROR: ' . $e->getMessage());
		   }
			}
		
		public function paging_link_slider($data,$searchlink=array())
		{
		  try {  
		  
		  	if(!$data){
					  $data=array(); 
					  
					  return '';
					}
		  
		  // initialize pager with data set
		  $pager = new Zend_Paginator(new Zend_Paginator_Adapter_Array($data));
		  // set page number from request
		 
		  $currentPage = isset($_GET['p']) ? (int) htmlentities($_GET['p']) : 1;
		  $pager->setCurrentPageNumber($currentPage);
		  // set number of items per page from request
		  $itemsPerPage = isset($_GET['c']) ? (int) htmlentities($_GET['c']) : 20;
		  $pager->setItemCountPerPage($itemsPerPage);
		  // set number of pages in page range
		  $pager->setPageRange(5);
		  // get page data
		  $pages = $pager->getPages('Sliding');
		  // create page links
		  $pageLinks = array();
		  $separator = ' | ';
		  // build first page link
		  $pageLinks[] = $this->getLink($pages->first, $itemsPerPage, 'First',$searchlink);        
		  // build previous page link
		  if (!empty($pages->previous)) {
			$pageLinks[] = $this->getLink($pages->previous, $itemsPerPage, 'Previous',$searchlink);        
		  }
		  // build page number links
		  foreach ($pages->pagesInRange as $x) {
			if ($x == $pages->current) {
			  $pageLinks[] = $x;      
			} else {
			  $pageLinks[] = $this->getLink($x, $itemsPerPage, $x,$searchlink);      
			}  
		  } 
		  // build next page link
		  if (!empty($pages->next)) {
			$pageLinks[] = $this->getLink($pages->next, $itemsPerPage, 'Next',$searchlink);        
		  }  
		  // build last page link
		  $pageLinks[] = $this->getLink($pages->last, $itemsPerPage, 'Last',$searchlink); 
		  $pageLinks=implode($pageLinks,' | ');
		$contents='<table width="500" cellpadding="2" cellspacing="0" border="0" style="font-family:Arial, Helvetica, sans-serif;color:#333333; font-size:12px;"><tr><td width="61" align="left" valign="top" >Pages :</td><td align="left" valign="top" class="addclass">'.$pageLinks.'</td><td>Showing '.$pages->firstItemNumber.' to '.$pages->lastItemNumber.' of '.$pages->totalItemCount.'</td></tr></table>';
		  return $contents;       
		} catch(Exception $e) {
		  die ('ERROR: ' . $e->getMessage());
		}

	    }
		
		public function paging_link_select($data)
		{
		  try {  
		  $pager = new Zend_Paginator(new Zend_Paginator_Adapter_Array($data));
		  $currentPage = isset($_GET['p']) ? (int) htmlentities($_GET['p']) : 1;
		  $pager->setCurrentPageNumber($currentPage);
		  $itemsPerPage = isset($_GET['c']) ? (int) htmlentities($_GET['c']) : 30;
		  $pager->setItemCountPerPage($itemsPerPage);
		  $pager->setPageRange(5);
		  $pages = $pager->getPages('Sliding');
		  $pageLinks = array();
		  $separator = ' | '; 
		  foreach ($pages->pagesInRange as $x) {
			if ($x == $pages->current) {
			  $pageLinks[] = $x;      
			} else {
			  $pageLinks[] = $this->getLinkSelect($x, $itemsPerPage, $x);      
			}  
		  } 
		  
		  
		 $contents='<table width="500" cellpadding="2" cellspacing="0" border="0" ><tr><td align="left" valign="top">Pages :</td><td align="left" valign="top" class="addclass"><select name="paginationControl" id="paginationControl" <script>changelocation(this.value)</script>>';
		 
		 
		 foreach($pageLinks as $a){
		 $selected = ($a == $pages->current) ? ' selected="selected"' : ''; 
         $contents.='<option value="'.$a.'" '.$selected.'>'.$a.'</option>'; }
		 $contents.='</select></td></tr></table>';
		 return $contents;     
		  
		  
		  
		} catch(Exception $e) {
		  die ('ERROR: ' . $e->getMessage());
		}

	    }
		
		public function getLink($page, $itemsPerPage, $label,$searchlink=array()) {
		
		$defaultarray=array(
			  'p' => $page, 
			  'c' => $itemsPerPage
			);
			  
		if(is_array($searchlink)){	  
		$defaultarray=array_merge($defaultarray,$searchlink);	  
		}	      
		
		  $q = http_build_query($defaultarray); 
 
		  return "<a href=\"?$q\">$label</a>";  
		
			
		}
		
		public function getLinkSelect($page, $itemsPerPage, $label) {
		  $q = http_build_query(array(
			  'p' => $page, 
			  'c' => $itemsPerPage
			)      
		  );  
		  return '?'.$q;
		    
		}
	}
	?>