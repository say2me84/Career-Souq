<?php

	/*function unsetSessionVars()
	{
		global $mySessionFront;
		unset($mySessionFront->errmsg);
		unset($mySessionFront->succmsg);
		unset($mySessionFront->errMsg);
		unset($mySessionFront->errTitle);
		unset($mySessionFront->succTitle);
		unset($mySessionFront->succMsg);
	}*/
	
	function frame_1_pre()
	{
		//global IMAGES_URL;
		$frmpre = '<div class="box_gradient"><table border="0" cellspacing="0" cellpadding="0" width="100%" >
		  <tr>
			<td class="frame_1_1" width="5"><img src="images/blank.gif" width="5"></td>
			<td style="border-top:1px solid #D9E9FF;"><img src="images/blank.gif" width="5"></td>
			<td class="frame_1_2" width="5" ><img src="images/blank.gif" width="5"></td>
		  </tr>
		  <tr>
			<td style="border-left:1px solid #D9E9FF; "><img src="images/blank.gif"></td>
			<td style="font-family:Arial,Verdana,  Helvetica, sans-serif;">';
		echo $frmpre;
		
	}
	
	function frame_1_post()
	{
		//global IMAGES_URL;
		$frmpost = '</td>
			<td style="border-right:1px solid #D9E9FF; "><img src="images/blank.gif"></td>
		  </tr>
		  <tr>
			<td class="frame_1_3" width="5" ><img src="images/blank.gif" width="5"></td>
			<td style="border-bottom:1px solid #D9E9FF; "><img src="images/blank.gif"></td>
			<td class="frame_1_4" width="5" ><img src="images/blank.gif" width="5"></td>
		  </tr>
		</table></div>';
		echo $frmpost;
	}
	
	function frame_2_pre()
	{
		//global IMAGES_URL;
		$frmpre = '<div><table border="0" cellspacing="0" cellpadding="0"  >
		  <tr>
			<td width="44"><img src="'.IMAGES_URL.'frame/left1.gif" width="44" ></td>
			<td style="background-image:url('.IMAGES_URL.'frame/center1.gif); background-repeat:repeat-x" ><img src="images/blank.gif" width="44"></td>
			<td width="44" ><img src="'.IMAGES_URL.'frame/right1.gif" width="44"></td>
		  </tr>
		  <tr>
			<td style="background-image:url('.IMAGES_URL.'frame/center2.gif); background-repeat:repeat-y"><img src="images/blank.gif"></td>
			<td >';
		echo $frmpre;
		
	} 
	
	function frame_2_post()
	{
		//global IMAGES_URL;
		$frmpost = '</td>
			<td style="background-image:url('.IMAGES_URL.'frame/center3.gif); background-repeat:repeat-y" ><img src="images/blank.gif"></td>
		  </tr>
		  <tr>
			<td  width="44" ><img src="'.IMAGES_URL.'frame/left2.gif" width="44"></td>
			<td style="background-image:url('.IMAGES_URL.'frame/center4.gif); background-repeat:repeat-x"><img src="images/blank.gif"></td>
			<td width="44" ><img src="'.IMAGES_URL.'frame/right2.gif" width="44"></td>
		  </tr>
		</table></div>';
		echo $frmpost;
	}
	
	function frame_3_pre()
	{
		//global IMAGES_URL;
		$frmpre = '<div><table border="0" cellspacing="0" cellpadding="0"  >
		  <tr>
			<td width="15"><img src="'.IMAGES_URL.'frame/sleft1.jpg" width="15" ></td>
			<td style="background-image:url('.IMAGES_URL.'frame/scenter1.jpg); background-repeat:repeat-x" ><img src="'.IMAGES_URL.'blank.gif" width="15"></td>
			<td width="15" ><img src="'.IMAGES_URL.'frame/sright1.jpg" width="15"></td>
		  </tr>
		  <tr>
			<td style="background-image:url('.IMAGES_URL.'frame/scenter2.jpg); background-repeat:repeat-y"><img src="'.IMAGES_URL.'blank.gif"></td>
			<td >';
		echo $frmpre;
		
	} 
	
	function frame_3_post()
	{
		//global IMAGES_URL;
		$frmpost = '</td>
			<td style="background-image:url('.IMAGES_URL.'frame/scenter3.jpg); background-repeat:repeat-y" ><img src="'.IMAGES_URL.'blank.gif"></td>
		  </tr>
		  <tr>
			<td  width="15" ><img src="'.IMAGES_URL.'frame/sleft2.jpg" width="15"></td>
			<td style="background-image:url('.IMAGES_URL.'frame/scenter4.jpg); background-repeat:repeat-x"><img src="'.IMAGES_URL.'blank.gif"></td>
			<td width="15" ><img src="'.IMAGES_URL.'frame/sright2.jpg" width="15"></td>
		  </tr>
		</table></div>';
		echo $frmpost;
	}
	
	function pr($string_to_print) {
		echo "<pre>";
		print_r($string_to_print);
		echo "</pre>";		
	}
	
	function prd($string_to_print) {
		echo "<pre>";
		print_r($string_to_print);
		echo "</pre>";		
		die;
	}
	
	function encrypt($password)
	{
		$len=strlen($password);
		if($len > 0)
		{
			for($i=0;$i<$len;$i++)
			{
				$password[$i]=chr((ord($password[$i])+$len-$i));
			}
			for($i=0;$i<3;$i++)
			{
				$password .= chr(ord($password[$i])+$len);
			}
		}
		
		return $password;
	}
		
	function decrypt($password)
	{
		$len=strlen($password)-3;
		$passwd = "";
		for($i=0;$i<$len;$i++)
		{
			$temp = ord($password[$i])-($len-$i);
			if($temp < 0)
				$temp += 128;
			$passwd .= chr($temp);
		}
		return $passwd;
	}
	
	function isLogged()
	{
		global $mySession;

		if (isset($mySession->user['userId'])) 
		{	
			
				return true;
		}
		else 
		{
				return false;
		}
	
	}
	
	function sanisitize_input($input_string)
	{
		$san_input=trim(htmlspecialchars(stripslashes($input_string)));
		return $san_input;
	}
	
			
		function implodeData($data)
		{
			$req_value = '';
			foreach ($data as $key=>$value)
			{
		         if(is_array($value))
		         {
		            foreach ($value as $key1=>$value1)
		            {
										if(is_array($value1))
										{
											foreach ($value1 as $key2=>$value2)
											{
													$req_value .= $key2.'=>'.$value2.' , ';
											}
						 			  }
						 			  else
						 			  {
												$req_value .= $key1.'=>'.$value1.' , ';
						 				}
		           }
		         }
		         else
		         {
								$req_value .= $key.'=>'.$value.' , ';
				 			}
			}
			return $req_value;
		}
		
		
		
		function addslashesInputVar($input_string=null)
		{
			if($input_string)
			{
				$p = array();
				foreach ($input_string as $key=>$value)
				{
					 if(is_array($value))
					 {
					   $temp=array();
					   foreach ($value as $key1=>$value1)
					   {
						$temp[$key1]=addslashes($value1);
					   }
					   $p[$key]=$temp;
					 }
					 else
						$p[$key] = addslashes($value);
				}
				return $p;
			}
		}
		
		function stripslashesInputVar($input_string=null)
		{
			if($input_string)
			{
				$p = array();
				foreach ($input_string as $key=>$value)
				{
					 if(is_array($value))
					 {
					   $temp=array();
					   foreach ($value as $key1=>$value1)
					   {
						$temp[$key1]=stripslashes($value1);
					   }
					   $p[$key]=$temp;
					 }
					 else
						$p[$key] = stripslashes($value);
				}
				return $p;
			}
		}
		
		function unhtmlentities($string)
		{
			$string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
			$string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
			$trans_tbl = get_html_translation_table(HTML_ENTITIES);
			$trans_tbl = array_flip($trans_tbl);
			return strtr($string, $trans_tbl);
		}
		
		
	
	function dateDiff($startDate,$endDate)
	{
		if($startDate=='0000-00-00'||$startDate=='0000-00-00 00:00:00')
		{
			$startDate=0;
		}
		if($endDate=='0000-00-00'||$endDate=='0000-00-00 00:00:00')
		{
			$endDate=0;
		}
	  	if(trim($startDate)!=0 && $startDate!=NULL)
	 	 {
		  	$startDate = str_replace("/","-",$startDate);
		  	$startDate = explode(' ',$startDate);
		  	$startDate = strtotime($startDate[0]);
	  	 }
	    if(trim($endDate)!=0 && $endDate!=NULL)
	 	 {
		  	$endDate = str_replace("/","-",$endDate);
		  	$endDate = explode(' ',$endDate);
		  	$endDate = strtotime($endDate[0]);
	  	 }
	    //return ($endDate-$startDate);
	    $datediff = $endDate - $startDate ;
	    
	    $day = $datediff / (60*60*24);
	    
	    return $day;
	    
	}
	
	function endDate($date=null,$monthToAdd=null,$yearToAdd=null)
	{
		
		$addDate = 0;
		$addMonth = 0;
		$addYear = 0;
		
		if($date != null && !empty($date) )
		{
			$currentDate = strtotime($date);
		} else {
			$currentDate = time();
		}
	
		if($monthToAdd != null && !empty($monthToAdd))
		{
			$currentDate = strtotime("+".$monthToAdd." month", $currentDate);
		}
		
		if($yearToAdd != null && !empty($yearToAdd))
		{
			$currentDate = strtotime("+".$yearToAdd." year", $currentDate);;
		}		
	
		//pr($currentDate);
		
		$expiredate = date("Y-m-d", $currentDate);
		
		return $expiredate;
		
	}
	
	
	 function endDate_days($date=null,$monthToAdd=null)
	{
		
		$addDate = 0;
		$addMonth = 0;
		$addYear = 0;
		
		if($date != null && !empty($date) )
		{
			$currentDate = strtotime($date);
		} else {
			$currentDate = time();
		}
	
		if($monthToAdd != null && !empty($monthToAdd))
		{
			$currentDate = strtotime("+".$monthToAdd." day", $currentDate);
		}
		
 
	
		//pr($currentDate);
		
		$expiredate = date("Y-m-d", $currentDate);
		
		return $expiredate;
		
	}
	
	
	
	function findSpaces($value)
		{
		 	if(strpos($value," ")=== false)
		 	{
		 		return false;
		 	}
		 	else
		 	{
		 		return true;
		 	}
		 }
		 
		 
		function createDirectory($dir_name)
		{
			global $CONFIG_VAR;
			if (!file_exists($dir_name))
			{
				mkdir($dir_name, 0777);
				return true;
			}
			else
				return false;
		}
		
		
		function renameDirectory($previousName,$newName)
		{
			global $CONFIG_VAR;
			
			if (rename($previousName,$newName))
				return true;
			else 
				return false;	
		}
		
		
		
		function removeDirectory($dir_name)
		{
			global $CONFIG_VAR;
			
			if ($handle = opendir($dir_name)) 
			{
				while (false !== ($file = readdir($handle))) 
				{
						if($file!='.' && $file!='..')
							unlink($dir_name."/".$file);   						
				}
				closedir($handle);
			}
			if(rmdir($dir_name))
				return true;
			else 
				return false;
		}
		
		
		
		
		function FileExtention($f)
		{
			$arr=explode(".",$f);
			return $arr[count($arr)-1];
		}
		
		
		function createPath($path)
		{
				if(!trim($path))
						return false;
				$dir_ext = substr($path, 0, strrpos($path,'/'));
				if(!is_dir($dir_ext))
				{
					//echo "<BR/>dir_ext:".$dir_ext;
						createPath($dir_ext); //call itself means recursive loop
						if(!is_dir($path))
						{
								mkdir($path);
								chmod($path, 0777);
						}
						return true;
				}
				else
				{
					clearstatcache();
					if(!is_dir($path))
					{
						mkdir($path);
						chmod($path, 0777);
					}
					return true;
				}
		}
		
	function deleteAll($path)
	{
		global $mySession;
		
		
	      foreach(glob($path.'*.*') as $v)
	      {
	      	$org = strstr($v,"_org.");
	      	if($org != false)
	      	{
	      		unlink($v);
	      	}
	      	
	      	$frnd = strstr($v,"_frnd.");
	      	if($frnd != false)
	      	{
	      		unlink($v);
	      	}
	      	
	      	$profile = strstr($v, $mySession->user['Username'].".");
	      	if($profile != false)
	      	{
	      		unlink($v);
	      	}
	      }
	}
 
	
	function __autoloadModels($class_name) 
	{
		//echo APPLICATION_PATH.'/models/'.$class_name . '.php';exit;
	
	
    	require_once APPLICATION_PATH.'/models/'.$class_name . '.php';
	}
	//spl_autoload_register(__autoloadModels);
	function __autoloadDB($class_name) 
	{
	//echo APPLICATION_PATH.'/models/DbTable/'.$class_name . '.php';exit;
    	require_once APPLICATION_PATH.'/models/DbTable/'.$class_name . '.php';
	}
	//spl_autoload_register(__autoloadDB);
	
 
	
	//function to create a random value
	function create_random_value($length, $type = 'chars') 
	{
		if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;
	
		$rand_value = '';
		while (strlen($rand_value) < $length) {
		  if ($type == 'digits') {
			$char = rand(0,9);
		  } else {
			$char = chr(rand(0,255));
		  }
		  if ($type == 'mixed') {
			if (eregi('^[a-z0-9]$', $char)) $rand_value .= $char;
		  } elseif ($type == 'chars') {
			if (eregi('^[a-z]$', $char)) $rand_value .= $char;
		  } elseif ($type == 'digits') {
			if (ereg('^[0-9]$', $char)) $rand_value .= $char;
		  }
		}
	
		return $rand_value;
  	}
	//createjpg($old_image_withpath,$new_image_withpath,$new_height,$new_width);
	function createjpg($old_image, $new_image, $new_height, $new_width)
	{	
			if(copy($old_image,$new_image))
			{
			}
			$destimgthumb=ImageCreateTrueColor($new_width , $new_height) or die("Problem In Creating image"); 
				//echo "<br />destimgthumb =".$destimgthumb ;
			$srcimg=imagecreatefromjpeg($old_image) or die("Problem In opening Source Image"); 
				//echo "<br />srcimg =".$srcimg ; 
			ImageCopyResized($destimgthumb,$srcimg,0,0,0,0,$new_width,$new_height,imagesx($srcimg),imagesy($srcimg))  or die("Problem In resizing");
			//ImageCopyResized($destimgthumb,$old_image,0,0,0,0,$new_width,$new_height,imagesx($old_image),imagesy($old_image))  or die("Problem In resizing");
					
			 ImageJPEG($destimgthumb,$new_image) or die("Problem In saving"); 	
			//die;
		return; 
	}
	
	//creategif($old_image_withpath,$new_image_withpath,$new_height,$new_width);
	function creategif($old_image, $new_image, $new_height, $new_width)
	{	
		if(copy($old_image,$new_image))
		{
		}
		$destimgthumb=ImageCreateTrueColor($new_width , $new_height) or die("Problem In Creating image"); 
		$srcimg=imagecreatefromgif($old_image) or die("Problem In opening Source Image"); 
		ImageCopyResized($destimgthumb,$srcimg,0,0,0,0,$new_width,$new_height,imagesx($srcimg),imagesy($srcimg))  or die("Problem In resizing");
		ImageGIF($destimgthumb,$new_image) or die("Problem In saving"); 	
		return; 
	}
	
	//createpng($old_image_withpath,$new_image_withpath,$new_height,$new_width);
	function createpng($old_image, $new_image, $new_height, $new_width)
	{	
		if(copy($old_image,$new_image))
		{
		}
		$destimgthumb=ImageCreateTrueColor($new_width , $new_height) or die("Problem In Creating image"); 
		$srcimg=imagecreatefrompng($old_image) or die("Problem In opening Source Image"); 
		ImageCopyResized($destimgthumb,$srcimg,0,0,0,0,$new_width,$new_height,imagesx($srcimg),imagesy($srcimg))  or die("Problem In resizing");
		ImagePNG($destimgthumb,$new_image) or die("Problem In saving"); 	
		return; 
	}
	function sucessMsg($text){
		$sucessMsg='<div id="msgdiv1" onclick="divremove(1)"  style="cursor:pointer" class="msgsecuss" align="left"> <div class="msgsecussimg"> <img src="'.IMAGES_URL.'success_icon.png" border="0" alt="Sucess" /> </div>
				 <div class="msgsecusstext">'.$text.'</div></div>';
		return $sucessMsg;
		}
		
		
		function warningMsg($text)
		{
		$warningMsg='<div id="msgdiv2" onclick="divremove(2)"  style="display:bloccursor:pointer" class="msgwarning" align="left"> <div class="msgwarningimg"> <img src="'.IMAGES_URL.'Button-Warning-icon.png" border="0" alt="Sucess" /> </div>
				 <div class="msgwarningtext">'.$text.'</div></div>';
		return $warningMsg;
		}
		
		function errorMsg($text){
		$errorMsg='<div id="msgdiv3" onclick="divremove(3)"  style="cursor:pointer" class="msgerror" align="left"> <div class="msgerrorimg"> <img src="'.IMAGES_URL.'redmsg.png" border="0" alt="Sucess" /> </div>
				 <div class="msgerrortext">'.$text.'</div></div>';
		return $errorMsg;
	}
	
	function changeDate($date)
	{
		if($date=='00-00-0000' || $date=='0000-00-00')
		{
			return "";
		}
		else
		{
		$split=explode("-",$date);
		if(is_array($split) && count($split)==3) {
		return $split[2]."-".$split[1]."-".$split[0];
		} else {
			return '';
		}
		}
	}
	
	function generateBranch_id($stateid,$cityid)
	{
	    ///// RBRJJO0001   //RJ -> Rajasthan , Jo-> Jodhpur, Auto inc
		$db = new Db();
			
		$qry = "SELECT max(profileId) as rno "
						." FROM rbi_user AS u "
						." Where u.usrRole='B' ";
				$resmax = $db->runQuery($qry);
				$maxno = str_replace('ADB','',$resmax[0]['rno']);
			
		$gen_id = 'ADB'.($maxno+1);
		return $gen_id;
	}
	
	function generateEmployee_id($date,$autoId)
	{
		///  RB11090101   ///  11 yerar, 09 month,  01 date, 01 autoinc
		/// dateformate 'dd-mm-yyyy'
		$dt_array=preg_split("/[\s-]+/", $date);
		$gen_id = 'RB'.substr($dt_array[2],2,2).str_pad($dt_array[1],2,0,STR_PAD_LEFT).str_pad($dt_array[0],2,0,STR_PAD_LEFT).str_pad($autoId,6,0,STR_PAD_LEFT);
		return $gen_id;
	}
	function generateSubadmin_id($date,$autoId)
	{
		///  RB11090101   ///  11 yerar, 09 month,  01 date, 01 autoinc
		/// dateformate 'dd-mm-yyyy'
		$dt_array=preg_split("/[\s-]+/", $date);
		$gen_id = 'RB'.substr($dt_array[2],2,2).str_pad($dt_array[1],2,0,STR_PAD_LEFT).'SA'.str_pad($autoId,6,0,STR_PAD_LEFT);
		return $gen_id;
	}
	function generateAgent_id($branchid,$autoId)
	{
		/// RBRJJO00101   / RJJO001 ->Branch id, 01 auto inc
		/// dateformate 'dd-mm-yyyy'
		$db = new Db();
		$qry = "SELECT profileId "
						." FROM rbi_branch AS b "
						." Where b.userId='".$branchid."' ";
				$staterecord = $db->runQuery($qry);
				
		$qry = "SELECT max(profileId) as maxno "
						." FROM rbi_user "
						." Where profileId like '".$staterecord[0]['profileId']."0%' and usrRole='AG'";
		$branch_res = $db->runQuery($qry);			
		$stno = str_replace($staterecord[0]['profileId'],'',$branch_res[0]['maxno']);						
		$gen_id = $staterecord[0]['profileId'].str_pad(($stno+1),9,0,STR_PAD_LEFT);
		return $gen_id;
	}
	
	function generateCustomer_id($branchId)
	{
		///  RB1234031051   /// 1234 -> month random unick id, 03105 -> Constant, 01 -> monthly auto inc
		$db = new Db();
		/// dateformate 'dd-mm-yyyy'
		/*$dt_array=preg_split("/[\s-]+/", $date);
		$dt = $dt_array[2].'-'.$dt_array[1].'-01';*/
		$qry = "SELECT b.profileId "
						." FROM rbi_branch AS b"
						." Where b.userId='".$branchId."' ";
		$branch_res = $db->runQuery($qry);
		$maxno = $db->runQuery("select * from customer_max_no");	
		$stno = $maxno[0]['mxno'];
		/*$qry = "SELECT count(customerId) as rno "
						." FROM rbi_user_customer AS uc "
						." Where uc.profileId like 'RB".$monthrecord[0]['month_id']."3105%' ";*/
		/*$qry = "SELECT max(uc.profileId) as maxno "
						." FROM rbi_user_customer AS uc "
						." Where uc.branchId = '".$branchId."' ";
						
		$custrecord = $db->runQuery($qry);*/
		//$stno = str_replace($branch_res[0]['profileId'],'',$custrecord[0]['maxno']);
		$gen_id = $branch_res[0]['profileId'].str_pad($stno+1,11,0,STR_PAD_LEFT);
		$data = array();
		$data['mxno']=$stno+1;
		$condition="1";
		$db->modify('customer_max_no',$data,$condition);
		return $gen_id;
		
	}
	
	function get_address($custid)
	{
		$db = new Db();
		$qry = "SELECT concat(u.fname,'<br>',u.address,' ', c.city,'<br>', s.statename) as addr"
						." FROM rbi_user AS u "
						." Left join rbi_city as c on (c.cityid=u.city) "
						." Left join rbi_state as s on (s.stateid=u.state) "
						." Where u.userid='".$custid."' ";
				$staterecord = $db->runQuery($qry);
				
		return @$staterecord[0]['addr'];
	
	}
	
	function totalpaidinst($usid)
	{
		$db = new Db();
		$qry = "SELECT count(user_installment_Id) as cnt "
						." FROM rbi_user_scheme_installment "
						." Where user_schemeId='".$usid."' and Installment_status='1' ";
				$staterecord = $db->runQuery($qry);
				
		return @$staterecord[0]['cnt'];
	
	}
	function totalpendinginst($usid)
	{
		$db = new Db();
		$qry = "SELECT count(user_installment_Id) as cnt "
						." FROM rbi_user_scheme_installment "
						." Where user_schemeId='".$usid."' and Installment_status !='1' ";
				$staterecord = $db->runQuery($qry);
				
		return @$staterecord[0]['cnt'];
	
	}
	
	function getsubadmin_role($rolename)
	{
		global $mySession;
		if($mySession->user['userRole']=='SA') {
			if($mySession->user['rights'] && $mySession->user['rights']!='') {
				if(strstr($mySession->user['rights'],$rolename)) {
					return true;
				}
			} 
		} 
		return false;		
	}
	function getbranch_role($userid,$userrole)
	{
		global $mySession;
		$branchrole['isbranch']=0;
		$branchrole['branchid']=0;
		$db = new Db();
		
		if($userrole=='SA') {
			 $qry = "SELECT branchid FROM rbi_admin where userid='".$userid."' ";
			 $staterecord = $db->runQuery($qry);
			 if($staterecord[0]['branchid']) {
			 	$branchrole['isbranch']=1;
				$branchrole['branchid']=$staterecord[0]['branchid'];
			 }
		}
		if($userrole=='E') {
		
		}
		if($userrole=='B') {
		
		} 
		return $branchrole;		
	}
	function getusername($userid)
	{
		$db = new Db();
		$qry = "SELECT concat(u.fname,' ',u.lname) as nm"
						." FROM rbi_user as u"
						." Where u.userid='".$userid."' ";
				$staterecord = $db->runQuery($qry);
		return @$staterecord[0]['nm'];
	}
	function getprofileid($userid)
	{
		$db = new Db();
		$qry = "SELECT profileId "
						." FROM rbi_user as u"
						." Where u.userid='".$userid."' ";
				$staterecord = $db->runQuery($qry);
		return @$staterecord[0]['profileId'];
	}
	function getuserid($profileid)
	{
		$db = new Db();
		$qry = "SELECT userid "
						." FROM rbi_user as u"
						." Where u.profileId='".$profileid."' ";
				$staterecord = $db->runQuery($qry);
		return @$staterecord[0]['userid'];
	}
	function getprofileid_agold($userid)
	{
		$db = new Db();
		$qry = "SELECT old_profileid as profileId "
						." FROM rbi_agent as u"
						." Where u.userId='".$userid."' ";
				$staterecord = $db->runQuery($qry);
		return @$staterecord[0]['profileId'];
	}
	function getschemecatname($id)
	{
		$db = new Db();
		$qry = "SELECT schemeType "
						." FROM rbi_scheme_type as s"
						." Where s.schemeTypeId='".$id."' ";
		$staterecord = $db->runQuery($qry);
		return @$staterecord[0]['schemeType'];
	}
	function getsenior_data($id)
	{
		$db = new Db();
		$qry = "SELECT employeeId "
						." FROM rbi_agent as a"
						." Where userId='".$id."' ";
		$staterecord = $db->runQuery($qry);
		if(is_array($staterecord) && count($staterecord) > 0 && $staterecord[0]['employeeId']!=0) {
			$qry2 = "SELECT userId, profileId "
							." FROM rbi_agent as a"
							." Where userId='".$staterecord[0]['employeeId']."' ";
			$staterecord2 = $db->runQuery($qry2);
		} else {
			$staterecord2[0]['userId']=''; 
			$staterecord2[0]['profileId']='';
		}
		//pr($staterecord2);
		return @$staterecord2[0];
	}
	function getinstallmenttimeword($timePriodType,$timePeriod)
	{	
		if($timePriodType==1) {
				switch ($timePeriod) {
					case 3:
						$timeword = "Quarterly";
					break;
					case 6:
						$timeword = "Half Yearly";
					break;
					case 12:
						$timeword = "Yearly";
					break;
					default:
						$timeword = "Monthly";
					break;
				}
			} elseif($timePriodType==2) {
				$timeword = "Yearly";
			} elseif($timePriodType==3) {
				$timeword = "Single";
			} else {
				switch ($timePeriod) {
					case 7:
						$timeword = "Weekely";
					break;
					default:
						$timeword = "Daily";
					break;
				}
			}
			return $timeword;
	}
	
	function sendtosms($mobno,$message_content) {
		return 1;
			$user="RBILTD"; //your username
			 $password="rbi#1234"; //your password
			 $mobilenumbers=$mobno; //$mres['mobno']; //enter Mobile numbers comma seperated //9462612111 //.',9351171577'
			 $message = $message_content;
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
						
			 $curlresponse = curl_exec($ch); // execute
			if(curl_errno($ch)) {
					//echo 'curl error : '. curl_error($ch);
					return 0;
			}				
			 if (empty($ret)) {
				
				die(curl_error($ch));
				curl_close($ch); // close cURL handler
				return 0;
			 } else {
				$info = curl_getinfo($ch);
				curl_close($ch); // close cURL handler	 
				return 1; 
			 }
	}
	
	function getExt($file) 
	{
		$dot = strrpos($file, '.') ;
		//echo "ddddddddddd".$dot.'hhhhh'.substr($file, $dot);
		return substr($file, $dot);
	}
	
	function agentamount_entry($aid, $tr_type, $inst_id, $c_id,$amount,$credit_dt,$rec_no,$schemeid)
	{
		$db = new Db();
		//echo "select * from rbi_user_to_scheme where userid='".$c_id."'";
		$schemedetail = $db->runQuery("select * from rbi_user_to_scheme where userid='".$c_id."'");
		if(is_array($schemedetail) && count($schemedetail) > 0) {
		//echo "select * from rbi_commission where scheme_cat='".$schemedetail[0]['scheme_type']."' and from_dt <= '".$credit_dt."' and to_dt >= '".$credit_dt."' and mnth='".$schemedetail[0]['mnth']."' ";
		
			$res_com_st = $db->runQuery("select * from rbi_commission where scheme_cat='".$schemedetail[0]['scheme_type']."' and from_dt <= '".$credit_dt."' and to_dt >= '".$credit_dt."' and mnth='".$schemedetail[0]['mnth']."' ");
			if(is_array($res_com_st) && count($res_com_st) > 0) {
				$comission = ($res_com_st[0]['pro']*$amount)/100;
				
				$modelobj = new Model_Mainmodel();
				
				$Data['aid']=$aid;
				$Data['branchId']=$schemedetail[0]['branchId'];
				$Data['com_id']=$res_com_st[0]['id'];
				$Data['scheme_cat']=$res_com_st[0]['scheme_cat'];
				$Data['mnth']=$res_com_st[0]['mnth'];
				$Data['amount']=$amount;
				$Data['comission']=$comission;
				$Data['tr_dt']=date('Y-m-d');
				$Data['credit_dt']=$credit_dt;
				$Data['tr_type']=$tr_type;
				$Data['c_id']=$c_id;
				$Data['inst_id']=$inst_id;
				$Data['rec_no']=$rec_no;
				$Data['status']=1;
				
				$insertdata=$modelobj->insertThis('rbi_agentamount',$Data);
				//prd($Data);
				
			}
		}
		
	}
	
?>