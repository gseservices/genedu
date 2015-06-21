<?php
include_once BASE_PATH . '\classes\clsBase.php';
include_once BASE_PATH . '\classes\masters\cls_gen_company.php';

class cls_gen_acc_expense_group extends clsBase
{
	Public $m_pk_exp_group_id=0;
	Public $m_uk_eh_code="Code";
	Public $m_fk_uk_company_code="CompCode";
	Public $m_eh_name="Name";
	Public $m_fk_uk_ehunder_code="underCode";
	Public $m_description="remark";
	Public $m_group_type="groupType";
	Public $m_exp_section="expSection";
	Public $m_is_taxable="taxable";
	Public $m_taxes="isTaxes";
	Public $m_anchor_id=0;
	Public $m_anchor_type="anchorType";
	public $mCreatedBy=2;
	public $mUpdatedby=2;

	public $dbal;

	function __construct()
	{
		parent::connect();
		$this->dbal= new DBAL($this->myLink);
	}

	public function Add()
	{
		try{
			$sql = "CALL spm_iu_mst_acc_expense_group(".$this->m_pk_exp_group_id.",'".$this->m_uk_eh_code."','".$this->m_fk_uk_company_code."','".$this->m_eh_name."','".$this->m_fk_uk_ehunder_code."','".$this->m_description."','".$this->m_group_type."','".$this->m_exp_section."','".$this->m_is_taxable."','".$this->m_taxes."',".$this->m_anchor_id.",'".$this->m_anchor_type."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_iu_mst_acc_expense_group(".$this->m_pk_exp_group_id.",'".$this->m_uk_eh_code."','".$this->m_fk_uk_company_code."','".$this->m_eh_name."','".$this->m_fk_uk_ehunder_code."','".$this->m_description."','".$this->m_group_type."','".$this->m_exp_section."','".$this->m_is_taxable."','".$this->m_taxes."',".$this->m_anchor_id.",'".$this->m_anchor_type."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_sfd_mst_acc_expense_group(".$this->m_pk_exp_group_id.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";			
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
			$req_deps ['client_work_out'] = "";
						
			//Company
			$jsonCompany = "";
			$objCompany =  new cls_gen_company();
			$jsonCompany = $objCompany->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_company','uk_comp_code, firm_name', "");
			$req_deps ['company'] = $jsonCompany;
			$objCompany = null;
			//EH Under Code
			$jsonEHUnder = "";
			$objEHUnder =  new cls_gen_acc_expense_group();
			$jsonEHUnder = $objEHUnder->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_acc_expense_group','uk_eh_code, eh_name', "");
			$req_deps ['eh_under'] = $jsonEHUnder;
			$objEHUnder = null;

			return json_encode($req_deps);

		} catch (Exception $e) {
			$this->WriteLog($ex);
		}
	}
}
?>