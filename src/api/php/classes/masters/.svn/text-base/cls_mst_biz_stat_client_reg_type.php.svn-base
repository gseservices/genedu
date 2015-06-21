<?php
include_once BASE_PATH . '\classes\clsBase.php';

class cls_mst_biz_stat_client_reg_type extends clsBase
{

	public $m_pk_stat_client_reg_type_id=0;
	public $m_uk_registration_code="";
	public $m_registration_type="";
	public $m_data_type="";
	public $m_max_length=0;
	public $mCreatedBy=1;
	public $mUpdatedby=1;

	public $dbal;

	function __construct()
	{
		parent::connect();
		$this->dbal= new DBAL($this->myLink);
	}

	public function Add()
	{
		try{
			$sql = "CALL spm_iu_mst_biz_stat_client_reg_type(". $this->m_pk_stat_client_reg_type_id .",'". $this->m_uk_registration_code."','" . $this->m_registration_type."','". $this->m_data_type."',".$this->m_max_length.",". $this->mCreatedBy .",".$this->mUpdatedby .")" ;
			$result = $this->dbal->execScalar($sql,false);
			return $result;
		}catch (Exception $ex)
		{
			$this->WriteLog($ex);
		}
	}

	public function Update()
	{
		try{
			$sql = "CALL spm_iu_mst_biz_stat_client_reg_type(". $this->m_pk_stat_client_reg_type_id .",'". $this->m_uk_registration_code."','" . $this->m_registration_type."','". $this->m_data_type."',".$this->m_max_length.",". $this->mCreatedBy .",".$this->mUpdatedby .")" ;
			$result = $this->dbal->execScalar($sql,false);
			echo $result;
		}catch (Exception $ex)
		{
			$this->WriteLog($ex);
		}

	}

	public function Delete()
	{
		try{
			$sql = "CALL spm_sfd_mst_biz_stat_client_reg_type(".$this->m_pk_stat_client_reg_type_id .",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
			//echo "Delete sql : ".$sql ;
			$result = $this->dbal->execScalar($sql,false);
			return $result;
		}catch (Exception $ex)
		{
			$this->WriteLog($ex);
		}
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
		//echo $sql;
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