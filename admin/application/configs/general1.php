<?php
	function frame_1_pre()
	{
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
	
	function generateBranch_id($stateid,$cityid)
	{
	    ///// RBRJJO001   //RJ -> Rajasthan , Jo-> Jodhpur, Auto inc
		$db = new Db();
		$qry = "SELECT statecode "
						." FROM rbi_state AS s "
						." Where s.stateid='".$stateid."' ";
				$staterecord = $db->runQuery($qry);
				
		$db = new Db();
		$qry = "SELECT citycode "
						." FROM rbi_city AS c "
						." Where c.cityid='".$cityid."' ";
				$cityrecord = $db->runQuery($qry);
		
		$qry = "SELECT count(userid) as rno "
						." FROM rbi_user AS u "
						." Where u.usrRole='B' and city='".$cityid."' ";
				$norecord = $db->runQuery($qry);
				
		$gen_id = $staterecord[0]['statecode'].$cityrecord[0]['citycode'].str_pad($norecord[0]['rno']+1,3,0,'left');
		return $gen_id;
	}
	
	function generateEmployee_id($date,$autoId)
	{
		///  RB11090101   ///  11 yerar, 09 month,  01 date, 01 autoinc
		/// dateformate 'dd-mm-yyyy'
		$dt_array=preg_split("/[\s-]+/", $date);
		$gen_id = 'RB'.substr($dt_array[2],2,2).str_pad($dt_array[1],2,0,'left').str_pad($dt_array[0],2,0,'left').str_pad($autoId,6,0,'left');
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
				
		$gen_id = 'RB'.$staterecord[0]['profileId'].str_pad($autoId,6,0,'left');
		return $gen_id;
	}
	
	function generateCustomer_id($date)
	{
		///  RB1234031051   /// 1234 -> month random unick id, 03105 -> Constant, 01 -> monthly auto inc
		$db = new Db();
		/// dateformate 'dd-mm-yyyy'
		$dt_array=preg_split("/[\s-]+/", $date);
		$dt = $dt_array[2].'/'.$dt_array[1].'/01';
		$qry = "SELECT * "
						." FROM rbi_month_random_id AS m "
						." Where m.dt='".$dt."' ";
				$monthrecord = $db->runQuery($qry);
				
		$qry = "SELECT count(customerId) as rno "
						." FROM rbi_user_customer AS uc "
						." Where uc.profileId like 'RB".$monthrecord[0]['month_id']."3105%' ";
				$custrecord = $db->runQuery($qry);
		$gen_id = 'RB'.$monthrecord[0]['month_id'].'3105'.str_pad($custrecord[0]['rno']+1,6,0,'left');
		return $gen_id;
		
	}
	
?>