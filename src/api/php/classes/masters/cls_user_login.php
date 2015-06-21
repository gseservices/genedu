<?php
include_once BASE_PATH . '\classes\clsBase.php';

class cls_user_login extends clsBase
{	
	public $m_user_name="";
	public $m_password="";
	
	public $dbal;

	function __construct()
	{
		parent::connect();
		$this->dbal= new DBAL($this->myLink);
	}
	public function Add()
	{
		try{
			$sql = "CALL spm_get_mst_gen_user_login('".$this->m_user_name."','".$this->m_password."')";			 
			$result = $this->dbal->execScalar($sql,TRUE);
			if($result == 1)
			{
				$_SESSION["user_name"] = $this->m_user_name;
				$_SESSION["user_id"] = "";
				$_SESSION["user_password"] = $this->m_password;
			}			 			
			return $result;
			
		}catch (Exception $ex)
		{
			$this->WriteLog($ex);
		}
	}	
	
	public function Update()
	{		
	}
	
	public function Delete()
	{
		
	}
	public function GetData($mode = SELECT_MODE_VIEW, $returntype =SELECT_RETURN_TYPE_JSONSTRING, $dbobj="",$projectionList="*",$filter="")
	{		
		switch($mode)
		{
			case SELECT_MODE_VIEW:
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . (($filter == "")? "" : " WHERE " . $filter);
				
				break;
			case SELECT_MODE_TABLE :
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . (($filter == "")? "" : " WHERE " . $filter);		 
				
				break;
			case SELECT_MODE_SP:
				$sql = "CALL ". $dbobj . ($filter == "")? "" : "(". $filter .")";
				
				break;
			default:
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . ($filter == "")? "" : " WHERE " . $filter;
				break;
		}		
		//$sql = " SELECT ". $projectionList ." FROM ". $dbobj ;//. ($filter == "")? "" : " WHERE " . $filter;		
		
		$qry_res = $this->dbal->execReader($sql);
		
	if($qry_res)
		{
			$rec_set = $this->dbal->fetchData($qry_res, true);
			//print_r($rec_set);
		}else {
			//echo "no data";
			return "NODATA";
		}

		if($rec_set)
		{
			if($returntype == SELECT_RETURN_TYPE_JSONSTRING )
			{
				$return_str = json_encode($rec_set);				
				return $this->sanitizeBlankJSONRecordset($return_str);
			}
		}else{
			return $this->sanitizeBlankJSONRecordset();
		}		
	}
}

?>