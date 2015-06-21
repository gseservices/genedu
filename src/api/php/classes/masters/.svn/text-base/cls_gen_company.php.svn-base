<?php

include_once BASE_PATH . '\classes\clsBase.php';

class cls_gen_company extends clsBase
{	
	public $m_pk_company_id=0;
	public $m_firm_name="";
	public $m_uk_comp_code="";
	public $m_comp_reg_no="";
	public $m_address1="";
	public $m_address2="";
	public $m_city_name="";
	public $m_phono_no="";
	public $m_pin="";
	public $m_fax="";
	public $m_emailId="";
	public $m_PAN="";
	public $m_TAN="";
	public $m_auth_sign="";
	public $m_com_logo="";
	public $m_bst_no="";
	public $m_cst_no="";
	public $m_vat_tin_no="";
	public $m_service_tax_no="";
	public $m_lbt_no="";
	public $m_drug_lic_no="";
	public $m_p_xml="";
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
			//echo  "Add Function";		
			
			$sql = "CALL spm_iu_mst_gen_company(".$this->m_pk_company_id.",'".$this->m_firm_name."','".$this->m_uk_comp_code."','".$this->m_comp_reg_no."','".$this->m_address1."','".$this->m_address2."','".$this->m_city_name."','".$this->m_phono_no."','".$this->m_pin."','".$this->m_fax."','".$this->m_emailId."','".$this->m_PAN."','".$this->m_TAN."','".$this->m_auth_sign."','".$this->m_com_logo."','".$this->m_bst_no."','".$this->m_cst_no."','".$this->m_vat_tin_no."','".$this->m_service_tax_no."','".$this->m_lbt_no."','".$this->m_drug_lic_no."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
			//echo $sql;
			$result = $this->dbal->execScalar($sql,TRUE);
			return $result;
		}catch (Exception $ex)
		{
			$this->WriteLog($ex);
		}
	}
	
	public function Update()
	{
		try{
			$sql = "CALL spm_iu_mst_gen_company(".$this->m_pk_company_id.",'".$this->m_firm_name."','".$this->m_uk_comp_code."','".$this->m_comp_reg_no."','".$this->m_address1."','".$this->m_address2."','".$this->m_city_name."','".$this->m_phono_no."','".$this->m_pin."','".$this->m_fax."','".$this->m_emailId."','".$this->m_PAN."','".$this->m_TAN."','".$this->m_auth_sign."','".$this->m_com_logo."','".$this->m_bst_no."','".$this->m_cst_no."','".$this->m_vat_tin_no."','".$this->m_service_tax_no."','".$this->m_lbt_no."','".$this->m_drug_lic_no."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_sfd_mst_gen_company(".$this->m_pk_company_id.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
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
}
?>