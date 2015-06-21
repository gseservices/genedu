<?php
include_once BASE_PATH . '\classes\clsBase.php';
include_once BASE_PATH . '\classes\masters\cls_gen_city.php';

class cls_gen_biz_client extends clsBase
{
	public $m_pk_client_id=0;
	public $m_fk_uk_client_type_code="";
	public $m_uk_client_code="";
	public $m_client_name="";
	public $m_l_address="";
	public $m_fk_l_uk_city_code="";
	public $m_p_address="";
	public $m_fk_p_uk_city_code="";
	public $m_email="";
	public $m_contact_no="";
	public $m_mobile_no="";
	public $m_description="";
	public $m_deletedtype='s';
	public $m_deleted_by=1;
	public $m_p_xml="";

	public $dbal;

	function __construct()
	{
		parent::connect();
		$this->dbal= new DBAL($this->myLink);
	}

	public function Add()
	{
		try{
			$this->mUpdatedby=1;
			$this->mCreatedBy=1;
				
			$sql = "CALL spm_iu_mst_biz_client(".$this->m_pk_client_id.",'".$this->m_fk_uk_client_type_code."','".$this->m_uk_client_code."','".$this->m_client_name."','".$this->m_l_address."','".$this->m_fk_l_uk_city_code."','".$this->m_p_address."','".$this->m_fk_p_uk_city_code."','".$this->m_email."','".$this->m_contact_no."','".$this->m_mobile_no."','".$this->m_description."',".$this->mCreatedBy.",".$this->mUpdatedby.",'".$this->m_p_xml."')";
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
			$sql = "CALL spm_iu_mst_biz_client(".$this->m_pk_client_id.",'".$this->m_uk_client_code."','".$this->m_client_name."','".$this->m_l_address."','".$this->m_fk_l_uk_city_code."','".$this->m_p_address."','".$this->m_fk_p_uk_city_code."','".$this->m_email."','".$this->m_contact_no."','".$this->m_mobile_no."','".$this->m_description."',".$this->mCreatedBy.",".$this->mUpdatedby.",'".$this->m_p_xml."')";
				
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
			$sql = "CALL spm_sfd_mst_biz_client(".$this->m_pk_client_id.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
			//echo "Delete sql : ".$sql ;
			$result = $this->dbal->execScalar($sql,false);
			return $result;
		}catch (Exception $ex)
		{
			$this->WriteLog($ex);
		}

	}
	public function getAllMastersRequired(){
		try {
			$req_deps ['client_details'] = "";
			//Client Type
			$jsonClientType = "";
			$objClientType =  new cls_gen_city();
			$jsonClientType = $objClientType->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_biz_client_type','uk_client_type_code,client_type_name', "");
			$req_deps ['client_type'] = $jsonClientType;
			$objClientType = null;
			//City
			$jsonCity = "";
			$objCity =  new cls_gen_city();
			$jsonCity = $objCity->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_city','uk_city_code, city_name', "");
			$req_deps ['city'] = $jsonCity;			
			$objCity = null;
			//Parent Ledger
	
			return json_encode($req_deps);
	
		} catch (Exception $e) {
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