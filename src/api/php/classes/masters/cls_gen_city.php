<?php
include_once BASE_PATH . '\classes\clsBase.php';

class cls_gen_city extends clsBase
{
	public $m_cityId=0;
	public $m_cityName="";
	public $m_district_id=0;
	public $m_deletedtype='s';
	public $m_deleted_by=1;

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
				
			$sql = "CALL spm_iu_mst_city(".$this->m_cityId.",'".$this->m_city_name."','".$this->m_district_id."','".$this->m_password."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_iu_mst_city(".$this->m_cityId.",'".$this->m_city_name."','".$this->m_district_id."','".$this->m_password."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_sfd_mst_city(".$this->m_cityId.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
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
			$req_deps ['city'] = "";
			//City
			$jsonCity = "";
			$objCity =  new cls_gen_city();
			$jsonCity = $objCity->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_city','uk_city_code, city_name', "");
			$req_deps ['l_city'] = $jsonCity;
			$req_deps ['p_city'] = $jsonCity;
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