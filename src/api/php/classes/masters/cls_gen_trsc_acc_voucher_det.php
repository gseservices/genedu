<?php
include_once BASE_PATH . '\classes\clsBase.php';

class cls_gen_trsc_acc_voucher_det extends clsBase
{	
	public $m_pk_vch_det_id=0;
	public $m_fk_vch_id=0;
	public $m_fk_ledger_id=0;
	public $m_cr_dr=0;
	public $m_prev_bal=0;
	public $m_amount=0;
	public $m_post_bal=0;
	public $m_remark="";
				
	public $dbal;

	function __construct()
	{
		parent::connect();
		$this->dbal= new DBAL($this->myLink);
	}

	public function Add()
	{
		try{
			$sql = "CALL spm_iu_trsc_acc_voucher_det(".$this->m_pk_vch_det_id.",".$this->m_fk_vch_id.",".$this->m_fk_ledger_id.",".$this->m_cr_dr.",".$this->m_prev_bal.",".$this->m_amount.",".$this->m_post_bal.",'".$this->m_remark."',".$this->mCreatedBy.",".$this->mCreatedBy.",".$this->mUpdatedby.")";
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
			$sql = "CALL spm_iu_trsc_acc_voucher_det(".$this->m_pk_vch_det_id.",".$this->m_fk_vch_id.",".$this->m_fk_ledger_id.",".$this->m_cr_dr.",".$this->m_prev_bal.",".$this->m_amount.",".$this->m_post_bal.",'".$this->m_remark."',".$this->mCreatedBy.",".$this->mCreatedBy.",".$this->mUpdatedby.")";
			$result = $this->dbal->execScalar($sql,false);
			echo $result;
		}catch (Exception $ex)
		{
			$this->WriteLog($ex);
		}
	}

	public function Delete()
	{
		//$this->
	}

	public function GetData($mode = SELECT_MODE_VIEW, $returntype =SELECT_RETURN_TYPE_JSONSTRING, $dbobj="",$projectionList="*",$filter="")
	{		
		switch($mode)
		{
			case SELECT_MODE_VIEW:
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . ($filter == "")? "" : " WHERE " . $filter;
				break;
			case SELECT_MODE_TABLE :
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . ($filter == "")? "" : " WHERE " . $filter;
				break;
			case SELECT_MODE_SP:
				$sql = "CALL ". $dbobj . ($filter == "")? "" : "(". $filter .")";
				break;
			default:
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . ($filter == "")? "" : " WHERE " . $filter;
				break;
		}
		
		$sql = " SELECT ". $projectionList ." FROM ". $dbobj ;//. ($filter == "")? "" : " WHERE " . $filter;		

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