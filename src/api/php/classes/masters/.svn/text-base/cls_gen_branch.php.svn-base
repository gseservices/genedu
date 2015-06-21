<?php
include_once BASE_PATH . '\classes\clsBase.php';
include_once BASE_PATH . '\classes\masters\cls_gen_company.php';
include_once BASE_PATH . '\classes\masters\cls_gen_region.php';

class cls_gen_branch extends clsBase
{
	public $m_pk_branch_id=0;
	public $m_fk_uk_region_code=0;
	public $m_uk_branch_code="";
	public $m_branch_name="";
	public $m_manager_id=0;
	public $m_branch_manager="";
	public $m_description="";
	public $m_fk_uk_comp_code="";	
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
			$sql = "CALL spm_iu_mst_gen_branch(".$this->m_pk_branch_id.",'".$this->m_fk_uk_region_code."','".$this->m_uk_branch_code."','".$this->m_branch_name."',".$this->m_manager_id.",'".$this->m_branch_manager."','".$this->m_description."','".$this->m_fk_uk_comp_code."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_iu_mst_gen_branch(".$this->m_pk_branch_id.",".$this->fk_uk_region_code.",'".$this->m_uk_branch_code."','".$this->m_branch_name."',".$this->m_manager_id.",'".$this->m_branch_manager."','".$this->m_description."','".$this->m_fk_uk_comp_code."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			
			$sql = "CALL spm_sfd_mst_gen_branch(".$this->m_pk_doc_category_id.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
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
			$req_deps ['company'] = "";			
			//Company
			$jsonCompany = "";
			$objCompany =  new cls_gen_company();
			$jsonCompany = $objCompany->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_company','uk_comp_code, firm_name', "");
			$req_deps ['company'] = $jsonCompany;
			$objCompany = null;
			//Region
			$jsonRegion = "";
			$objRegion =  new cls_gen_region();
			$jsonRegion  = $objRegion->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_region','uk_region_code, region', "fk_uk_comp_code = 'GSIPL'");
			$req_deps ['region'] = $jsonRegion ;
			$objRegion = null;
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