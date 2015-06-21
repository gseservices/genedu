<?php
include_once BASE_PATH . '\classes\clsBase.php';
include_once BASE_PATH . '\classes\masters\cls_gen_city.php';

class cls_gen_employee extends clsBase
{
	public $m_pk_employee_id=0;
	public $m_uk_employee_code="";
	public $m_group_type="";
	public $m_f_name="";
	public $m_m_name="";
	public $m_l_name="";
	public $m_l_address="";
	public $m_fk_l_city_code="";
	public $m_p_address="";
	public $m_contact_no="";
	public $m_mobile_no="";
	public $m_fk_p_city_code="";
	public $m_joning_date="";
	public $m_dob="";
	public $m_gender="";
	public $m_bank_account_no="";
	public $m_bank_name="";
	public $m_bank_branch="";
	public $m_ifcf_no="";
	public $m_basic_salary=0;
	public $m_extra_salary=0;
	public $mCreatedBy=2;
	public $mUpdatedby=2;
	public $m_p_xml="";
	public $m_isnested="N";

	public $dbal;

	function __construct()
	{
		parent::connect();
		$this->dbal= new DBAL($this->myLink);
	}

	public function Add()
	{
		try{
			$sql = "CALL spm_iu_mst_gen_employee(".$this->m_pk_employee_id.",'".$this->m_uk_employee_code."','".$this->m_group_type."','".$this->m_f_name."','".$this->m_m_name."','".$this->m_l_name."','".$this->m_l_address."','".$this->m_fk_l_city_code."','".$this->m_p_address."','".$this->m_contact_no."','".$this->m_mobile_no."','".$this->m_fk_p_city_code."','".$this->m_joning_date."','".$this->m_dob."','".$this->m_gender."','".$this->m_bank_account_no."','".$this->m_bank_name."','".$this->m_bank_branch."','".$this->m_ifcf_no."',".$this->m_basic_salary.",".$this->m_extra_salary.",".$this->mCreatedBy.",".$this->mUpdatedby.")";
			//echo $sql ;
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
			$sql = "CALL spm_iu_mst_gen_employee(".$this->m_pk_employee_id.",'".$this->m_uk_employee_code."','".$this->m_group_type."','".$this->m_f_name."','".$this->m_m_name."','".$this->m_l_name."','".$this->m_l_address."','".$this->m_fk_l_city_code."','".$this->m_p_address."','".$this->m_contact_no."','".$this->m_mobile_no."','".$this->m_fk_p_city_code."','".$this->m_joning_date."','".$this->m_dob."','".$this->m_gender."','".$this->m_bank_account_no."','".$this->m_bank_name."','".$this->m_bank_branch."','".$this->m_ifcf_no."',".$this->m_basic_salary.",".$this->m_extra_salary.",".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_sfd_mst_gen_employee(".$this->m_pk_employee_id.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
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
			$req_deps ['city'] = "";
			//Designation
			$jsonDesignation = "";
			$objDesignation =  new cls_gen_city();
			$jsonDesignation = $objDesignation->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_designation','designation_name,uk_designation_code', "");
			$req_deps ['designation'] = $jsonDesignation;
			$objDesignation = null;
			//City
			$jsonCity = "";
			$objCity =  new cls_gen_city();
			$jsonCity = $objCity->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_city','uk_city_code, city_name', "");
			$req_deps ['city'] = $jsonCity;
			$objCity = null;			

			return json_encode($req_deps);

		} catch (Exception $e) {
			$this->WriteLog($ex);
		}
	}
}

?>