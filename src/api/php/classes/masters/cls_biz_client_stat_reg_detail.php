<?php
include_once BASE_PATH . '\classes\clsBase.php';
include_once BASE_PATH . '\classes\masters\cls_gen_biz_client.php';
include_once BASE_PATH . '\classes\masters\cls_gen_biz_stat_client_reg_type.php';

class cls_biz_client_stat_reg_detail extends clsBase
{
	public $m_pk_client_reg_det_id = 0;
	public $m_fk_uk_client_code = "";
	public $m_fk_uk_registration_code = "";
	public $m_particuler = "";
	public $m_description = "";
	public $mCreatedBy = 2;
	public $mUpdatedby = 2;
	public $m_p_xml = "";
	public $m_isnested = "N";
	public $dbal;

	function __construct()
	{
		parent::connect();
		$this->dbal= new DBAL($this->myLink);
	}

	public function Add()
	{
		try{
			$sql = 'CALL spm_iu_mst_biz_client_stat_reg_detail_xml("'.$this->m_p_xml.'")';
			//echo $sql;
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
			$sql = 'CALL spm_iu_mst_biz_client_stat_reg_detail_xml("'.$this->m_p_xml.'","'.$this->m_fk_uk_client_code.'", "'.$this->m_isnested.'")';
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
			$sql = "CALL spt_sfd_trsc_biz_workout_log(".$this->m_pk_client_work_detail_id.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
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
	public function getAllMastersRequired(){
		try {
			$req_deps ['client_reg_details'] = "";
			//Client Details
			$jsonClient = "";
			$objClient =  new cls_gen_biz_client();
			$jsonClient = $objClient->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_biz_client','uk_client_code,client_name', "");
			$req_deps ['client'] = $jsonClient ;
			$objClient = null;
			//Reg Type
			$jsonRegType= "";
			$objRegType=  new cls_gen_biz_stat_client_reg_type();
			$jsonRegType = $objRegType->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_biz_stat_client_reg_type','uk_registration_code, registration_type', "");
			$req_deps ['reg_type'] = $jsonRegType;
			$objRegType = null;
			
			return json_encode($req_deps);

		} catch (Exception $e) {
			$this->WriteLog($ex);
		}
	}
}
?>