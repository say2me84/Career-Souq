<?php
class Db 
{
	protected $db;
	
	function __construct()
	{
 
		$this->db = Zend_Registry::get('dbAdapter');
		return $this->db;
	}
	
	function runQuery($qry)
	{
		$result = $this->db->fetchAll($qry);
		return $result;
	}
	
	function firequery($qry)
	{
		$db = Zend_Registry::get('dbAdapter');
		return $db->query($qry);
	}
	//send $orderby as array['field'] ='DESC /ASC';
	function showAll($tbl,$columns='*', $where=NULL, $whereNot=NULL, $orderby=NULL, $tblJoin=NULL,$joinCondition=NULL,$group=NULL,$having=NULL,			     $distinct=NULL,$offset=NULL,$limit=NULL)
	{
		
		if(is_array($distinct))
		{
				$select = $this->db->distinct()
					->from($tbl);			
		}
		else 
		{
				$select = $this->db->select()
							->from($tbl);

				if($columns != '*')			
				{
					$select -> columns($columns);
					//echo $columns;
				}
				if($tblJoin != NULL  && $joinCondition != NULL)
				{
						$select -> join($tblJoin,$joinCondition);
				}
				if(is_array($where))
				{
					foreach($where as $key => $value)
					{
						$select -> where($key.' = ?', $value);
					}
				}
				if(is_array($whereNot))
				{
					foreach($whereNot as $key => $value)
					{
						$select -> where($key.' <> ?', $value);
					}
				}
				
				if($group != NULL)
				{
						$select ->group($group);
				}
				if($having != NULL)
				{
						$select ->having($having);
				}
				
				if($orderby != NULL)
				{	
					$key = array_keys($orderby);
					$value = array_values($orderby);
					
						$select -> order("$key[0] $value[0]");
				}		
				if($offset != NULL)
				{	
						$select -> $offset;
				}
				if($limit != NULL)
				{	
						$select ->limit($limit,$offset);
				}			
			
				 					
		}
 		
		
		//echo $select;
		$result = $this->db->fetchAll($select);
		if(empty($result))
		{
			return false; 
		}else
		{
			return $result;
		}
	}
	
	
	//New show all with OR in where clause.
	//send $orderby as array['field'] ='DESC /ASC';
	function newShowAll($tbl,$columns='*', $where=NULL, $orderby=NULL, $tblJoin=NULL, $joinCondition=NULL, $group=NULL,$having=NULL,$distinct=NULL,$offset=NULL,$limit=NULL)
	{

		if(is_array($distinct))
		{
				$select = $this->db->distinct()
							->from($tbl);
		}
		else 
		{
					$select = $this->db->select()->from( $tbl, $columns );				
 
				if($tblJoin != NULL  && $joinCondition != NULL)
				{
					for($i=0; $i<count($tblJoin); $i++)
					{
						$t = $tblJoin[$i];
						$jc = $joinCondition[$i];
						$select -> join($t,$jc,'');
					}
				}
				if(is_array($where))
				{
					foreach($where as $key => $value)
					{
						$select -> where($key.$value);
					}
				}
				
				if($group != NULL)
				{
						$select ->group($group);
				}
				if($having != NULL)
				{
						$select ->having($having);
				}
				
				if($orderby != NULL)
				{	
					$key = array_keys($orderby);
					$value = array_values($orderby);
					
						$select -> order("$key[0] $value[0]");
				}		
				if($offset != NULL)
				{	
						$select -> $offset;
				}		
			 					
		}
									
		
 		
		$result = $this->db->fetchAll($select);
		

		if(empty($result))
		{
			return false; 
		}else
		{
			return $result;
		}
	}
	
	
	function save($tbl,$data)
	{
		try {
			$result = $this->db->insert($tbl,$data);
				
			if($result)
			{
				return $result;
			}
			else
			{	return false;
			}
		}
		catch(Exception $e){
			echo "Error in insert operation";
			return false;
		}
	}
	
 	function modify($tbl,$data,$condition)		
	{

		try 
		{
		
		
			$result = $this->db->update($tbl,$data, $condition);
			
			if($result)	{
				return true;
			} else {
				return false;
			}
		}	
		catch(Exception $e){
			echo "Error in modify operation";
			return false;
		}
	}
	
	function delete($tbl,$condition)
	{
		try {
			$result = $this->db->delete($tbl,$condition);
			if($result)
			{
				return true;
			}
			else
			{	return false;
			}
		}
		catch(Exception $e){
			echo "Error in delete operation";
			return false;
		}
	}
	
	
	function lastInsertId()
	{
		$id = $this->db->lastInsertId();
		return $id;
	}
	

	
	
}
?>