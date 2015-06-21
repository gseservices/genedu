<?php
include_once BASE_PATH . '\classes\clsBase.php';
include_once BASE_PATH . '\classes\masters\cls_gen_company.php';
include_once BASE_PATH . '\classes\masters\cls_gen_branch.php';
include_once BASE_PATH . '\classes\masters\cls_gen_acc_ledger.php';
include_once BASE_PATH . '\classes\masters\cls_gen_user.php';

class cls_gen_trsc_acc_vouchers extends clsBase
{
	public $m_pk_vch_id=0;
	public $m_uk_fk_branch_code="";
	public $m_fk_acnt_trans_code="";
	public $m_vch_sr_no=0;
	public $m_vch_date="";
	public $m_fk_debit_ledger_id=0;
	public $m_fk_credit_ledger_id=0;
	public $m_amount=0;
	public $m_chq_no="";
	public $m_chk_date="";
	public $m_fk_bank_acnt_id=0;
	public $m_chq_status="";
	public $m_narration="";
	public $m_remarks="";
	public $m_prep_by=0;
	public $m_checked_by=0;
	public $m_approved_by=0;
	public $m_rcvd_by=0;
	public $m_anchor_id=0;
	public $m_anchor_type="";
	public $m_fk_comp_code="";
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
			$sql = "CALL spt_iu_trsc_acc_vouchers(".$this->m_pk_vch_id.",'".$this->m_uk_fk_branch_code."','".$this->m_fk_acnt_trans_code."',".$this->m_vch_sr_no.",'".$this->m_vch_date."',".$this->m_fk_debit_ledger_id.",".$this->m_fk_credit_ledger_id.",".$this->m_amount.",'".$this->m_chq_no."','".$this->m_chk_date."',".$this->m_fk_bank_acnt_id.",'".$this->m_chq_status."','".$this->m_narration."','".$this->m_remarks."',".$this->m_prep_by.",".$this->m_checked_by.",".$this->m_approved_by.",".$this->m_rcvd_by.",".$this->m_anchor_id.",'".$this->m_anchor_type."','".$this->m_fk_comp_code."',".$this->mCreatedBy.",".$this->mUpdatedby.",$this->m_p_xml)";
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
			$sql = "CALL spt_iu_trsc_acc_vouchers(".$this->m_pk_vch_id.",'".$this->m_uk_fk_branch_code."','".$this->m_fk_acnt_trans_code."',".$this->m_vch_sr_no.",'".$this->m_vch_date."',".$this->m_fk_debit_ledger_id.",".$this->m_fk_credit_ledger_id.",".$this->m_amount.",'".$this->m_chq_no."','".$this->m_chk_date."',".$this->m_fk_bank_acnt_id.",'".$this->m_chq_status."','".$this->m_narration."','".$this->m_remarks."',".$this->m_prep_by.",".$this->m_checked_by.",".$this->m_approved_by.",".$this->m_rcvd_by.",".$this->m_anchor_id.",'".$this->m_anchor_type."','".$this->m_fk_comp_code."',".$this->mCreatedBy.",".$this->mUpdatedby.",'".$this->m_p_xml."')";
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
			$req_deps ['client_work_out'] = "";
			//Company
			$jsonCompany = "";
			$objCompany =  new cls_gen_company();
			$jsonCompany = $objCompany->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_company','uk_comp_code, firm_name', "");
			$req_deps ['company'] = $jsonCompany;
			$objCompany = null;
			//Branch
			$jsonBranch = "";
			$objBranch =  new cls_gen_branch();
			$jsonBranch = $objBranch->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_branch','uk_branch_code, branch_name', "");
			$req_deps ['branch'] = $jsonBranch;
			$objBranch = null;
			//User
			$jsonUser = "";
			$objUser =  new cls_gen_user();
			$jsonUser = $objUser->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_user','pk_user_id, user_name', "");
			$req_deps ['user'] = $jsonUser;
			$objUser = null;
			//Ledger
			$jsonLedger = "";
			$objLedger =  new cls_gen_acc_ledger();
			$jsonLedger = $objLedger->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_acc_ledger','pk_ledger_id, ledger_name', "");
			$req_deps ['ledger'] = $jsonLedger;
			$objLedger = null;
			//Bank Account Number
			$jsonBankAccNo = "";
			$objBankAccNo =  new cls_gen_acc_ledger();
			$jsonBankAccNo = $objBankAccNo->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_gen_bank_account','pk_bankacc_id, account_no', "");
			$req_deps ['bank_acc_no'] = $jsonBankAccNo;
			$objBankAccNo = null;
			//Trans Code
			$jsonTransCode = "";
			$objTransCode =  new cls_gen_acc_ledger();
			$jsonTransCode = $objTransCode->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_acc_voucher_type','trans_code, trans_name', "");	
			$req_deps ['trans_code'] = $jsonTransCode;
			$objTransCode = null;
			//Parent Ledger

			return json_encode($req_deps);

		} catch (Exception $e) {
			$this->WriteLog($ex);
		}
	}
}
?>