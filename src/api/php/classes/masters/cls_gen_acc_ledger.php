<?php
include_once BASE_PATH . '\classes\clsBase.php';
include_once BASE_PATH . '\classes\masters\cls_gen_acc_expense_group.php';
include_once BASE_PATH . '\classes\masters\cls_gen_company.php';
include_once BASE_PATH . '\classes\masters\cls_gen_branch.php';

class cls_gen_acc_ledger extends clsBase
{
	
	public $m_pk_ledger_id=0;
	public $m_ledger_name="Ledger";
	public $m_fk_uk_branch_code="BranchCode";
	public $m_fk_uk_company_code="CompCode";
	public $m_fk_exp_grp_code="GrpCode";
	public $m_ledger_type="LedgerType";
	public $m_parent_id=0;
	public $m_anchor_id=0;
	public $m_anchor_type="AnchorType";
	public $m_description="Remark";
	public $m_opening_bal_cb="openBal";
	public $m_opening_bal=0;
	public $m_current_bal_cb="CurrBal";
	public $m_current_bal=0;
	public $m_is_reversed="Y";
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
			$sql = "CALL spm_iu_mst_acc_ledger(".$this->m_pk_ledger_id.",'".$this->m_ledger_name."','".$this->m_fk_uk_branch_code."','".$this->m_fk_uk_company_code."','".$this->m_fk_exp_grp_code."','".$this->m_ledger_type."',".$this->m_parent_id.",".$this->m_anchor_id.",'".$this->m_anchor_type."','".$this->m_description."','".$this->m_opening_bal_cb."',".$this->m_opening_bal.",'".$this->m_current_bal_cb."',".$this->m_current_bal.",'".$this->m_is_reversed."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_iu_mst_acc_ledger(".$this->m_pk_ledger_id.",'".$this->m_ledger_name."','".$this->m_fk_uk_branch_code."','".$this->m_fk_uk_company_code."','".$this->m_fk_exp_grp_code."','".$this->m_ledger_type."',".$this->m_parent_id.",".$this->m_anchor_id.",'".$this->m_anchor_type."','".$this->m_description."','".$this->m_opening_bal_cb."',".$this->m_opening_bal.",'".$this->m_current_bal_cb."',".$this->m_current_bal.",'".$this->m_is_reversed."',".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_sfd_mst_acc_ledger(".$this->m_pk_ledger_id.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
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
			$req_deps ['exp_group'] = ""; 
			//Exp Group
			$jsonExpGrp = "";
			$objExpGrp =  new cls_gen_acc_expense_group();
			$jsonExpGrp = $objExpGrp->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_acc_expense_group','uk_eh_code, eh_name', "fk_uk_company_code = 'GSIPL'");
			$req_deps ['exp_group'] = $jsonExpGrp;
			$objExpGrp = null;
			//Company
			$jsonCompany = "";
			$objCompany =  new cls_gen_company();
			$jsonCompany = $objCompany->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_company','uk_comp_code, firm_name', "");			
			$req_deps ['company'] = $jsonCompany;
			$objCompany = null;
			//Branch
			$jsonBranch = "";			
			$objBranch =  new cls_gen_branch();
			$jsonBranch  = $objBranch->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_branch','pk_branch_id, branch_name', "fk_uk_comp_code = 'GSIPL'");
			$req_deps ['branch'] = $jsonBranch ;
			$objBranch = null;
			//Ledger
			$jsonLedger = "";
			$objLedger =  new cls_gen_branch();
			$jsonLedger = $objLedger->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_acc_ledger','pk_ledger_id,ledger_name', "");
			$req_deps ['ledger'] = $jsonLedger ;
			$objLedger = null;
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