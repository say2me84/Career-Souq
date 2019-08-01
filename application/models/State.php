<?php
 	class Model_State extends Db{
		
		protected $_table;
		protected $_table2;
		
		public function __construct(){
			$this->_table = 'rbi_state';
			//$this->_table2 = 'rbi_scheme_type';
		}
		
		public function showState(){
			global $mySession;
			try{
				$db = new Db();
				$columns='*';
				//$record = $db->showAll($this->_table,$columns);
				//$qry = "SELECT * "
//						." FROM ".$this->_table." AS s "
//						." INNER JOIN ".$this->_table2." AS st"
//						." ON (s.schema_type = st.schemeTypeId)"
//						." ORDER BY s.title ";
				$qry = "SELECT * "
					   ." FROM ".$this->_table
					   ." ORDER BY statename ";			
					   
				$record = $db->runQuery($qry);
				if($record){
					return $record;
				} else {
					return false;
				}
			} catch(Exception $e) {
				return false;
			}
		}
		
		public function addFacilty(){
		
		}
		
		public function updateScheme(){
		
		}
		public function Chstatus(){
			
		}
		public function deleteScheme(){
		
		}
		function runThisQuery($query = null)
		{
			try
			{
				
				$User = new Db();
				$UserRecords = $User->runQuery($query);
				
				if(is_array($UserRecords) && count($UserRecords) > 0)
				{
					return $UserRecords; 
				}
				else
				{
					return false;
				}		
			}
			catch (Exception $e)
			{
				//echo "Exception occured ::".$e->getMessage();
				return false;
			}
		}
		function insertThis($data)
		{
			try{
					$User = new Db();
					
					//$data['UserCstmp'] = date('Y-m-d H:i:s');
					//$data['UserUstmp'] = date('Y-m-d H:i:s');
					
					$insertResult = $User->save($this->_table, $data);
				
					if($insertResult)
					{
						return $User->lastInsertId();
					}
					else 
					{
						return false;
					}
				}
				catch (Exception $e)
				{
					//echo "Exception occured ::".$e->getMessage();
					return false;
				}
		}
		
		function updateThis($data,$condition)
		{		
			
			try{
					$User = new Db();
					//$data['UserUstmp'] = date('Y-m-d H:i:s');
					
					$updateResult = $User->modify($this->_table,$data,$condition);
					
					
					if($updateResult)
					{
						return true;
					}
					else 
					{
						return false;
					}
				}
				catch (Exception $e)
				{
					//echo "Exception occured ::".$e->getMessage();
					return false;
				}
		}
		
	
	}
	?>