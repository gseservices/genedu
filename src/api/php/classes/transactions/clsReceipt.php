<?php

include_once BASE_PATH . '/classes/clsBase.php';

//echo "at the beginning of clsReceipt";

class clsReceipt extends clsBase
{
	
	public $m_pk_receipt_id = 0;
	public $m_pk_receipt_code = "";
	public $m_fk_company_code = "";
	public $m_rcpt_no = 0;
	public $m_fk_admission_id = 0;
	public $m_receipt_date = "";
	public $m_pay_mode = "";

	// procedure parameters
	public $varreceip_code = "";
	public $varfk_admission_id = 0;
	public $varrcpt_no = "";
	public $varreciept_date = "";
	public $varpay_mode = "";
	public $varch_dd_ac_no = "";
	public $varch_dd_no = "";
	public $varch_dd_date = "";
	public $varch_dd_bbranch = "";
	public $varch_dd_bank = "";
	public $varch_dd_status = "";
	public $varprevious_balance = 0;
	public $varpaid_amt = 0;
	public $varcurrent_balance = 0;
	public $varremark = "";
	public $varcreated_by = 0;
	public $varmodified_by = 0;
	public $varpk_reciept_id = 0;
	public $varrcpt_type = "";
	public $varis_admission = "";
	public $varcollegetype = "";
	public $p_xml = "";
	public $var_is_rcpt_no_manual = "N";// default value is N
	public $varreciept_code_return = "";
	




	public $dbal;
	

	function __construct()
	{
		parent::connect();
		//echo "creating dbal object";
		
		$this->dbal= new DBAL($this->myLink);
	}

	public function Add()
	{
		try{			
			$sql = "CALL `spt_iu_transmfeesreciept`(";
			$sql .= "'". $this->varreceip_code ."'";
			$sql .= ",". "'" . $this->varrcpt_no . "'";
			$sql .= ",". "" . $this->varfk_admission_id . "";
			$sql .= ",". "'" . $this->varreciept_date . "'";
			$sql .= ",". "'" . $this->varpay_mode . "'";
			$sql .= ",". "'" . $this->varch_dd_ac_no . "'";
			$sql .= ",". "'" . $this->varch_dd_no . "'";
			$sql .= ",". "'" . $this->varch_dd_date . "'";
			$sql .= ",". "'" . $this->varch_dd_bbranch . "'";
			$sql .= ",". "'" . $this->varch_dd_bank . "'";
			$sql .= ",". "'" . $this->varch_dd_status . "'";
			$sql .= ",". "" . $this->varprevious_balance . "";
			$sql .= ",". "" . $this->varpaid_amt . "";
			$sql .= ",". "" . $this->varcurrent_balance . "";
			$sql .= ",". "'" . $this->varremark . "'";
			$sql .= ",". "" . $this->varcreated_by . "";
			$sql .= ",". "" . $this->varmodified_by . "";
			$sql .= ",". "" . $this->varpk_reciept_id . "";
			$sql .= ",". "'" . $this->varrcpt_type . "'";
			$sql .= ",". "'" . $this->varis_admission . "'";
			$sql .= ",". "'" . $this->varcollegetype . "'";
			$sql .= ",". "'" . $this->p_xml . "'";
			$sql .= ",". "'" . $this->var_is_rcpt_no_manual . "'";
			$sql .= ",". "@varreciept_code_return";
			 
			$sql .= ");select @varreciept_code_return;";
			
			//$sql = "CALL `spt_iu_test`(3, 'test3')";
			//echo $sql;  
			
			$tableNames = array ("t1","t2","rcpt_code");
			
			$result = $this->dbal->execReaderMultiDs($sql,$tableNames);
			
			//print_r($result);
			echo "count : ".count($result[rcpt_code][0]);
			
			echo $result[rcpt_code][0]."<br/>";
			
			echo $result[rcpt_code][0][0]."<br/>";
			echo $result[rcpt_code][0]["@varreciept_code_return"]."<br/>";
			echo $result[2][0][0]."<br />";
			/*if($result){
				$sql = "select @varreciept_code_return";
				$result = $this->dbal->execScalar($sql, false);
			}*/
			$return_str="INIT";
			if(!$result){
				$return_str = $this->sanitizeBlankJSONRecordset();
			}
			else{
				$returntype =SELECT_RETURN_TYPE_JSONSTRING;
				
				if($returntype == SELECT_RETURN_TYPE_JSONSTRING){
					$return_str = json_encode($result);	
				}
			}
			return $return_str;
			
			//return $result;
		}catch (Exception $ex)
		{
			echo $ex->getMessage();
			$this->WriteLog($ex);
		}
	}

	public function Update()
	{
		try{
			//$sql = "CALL spm_iu_mst_biz_document(".$this->m_pk_document_id.",'".$this->m_fk_uk_doc_category_code."','".$this->m_uk_document_code."','".$this->m_document_name."','".$this->m_description."',".$this->mCreatedBy.",".$this->mUpdatedby.",'".$this->m_p_xml."')";
			$sql = "CALL spm_iu_mst_biz_document_xml('".$this->m_p_xml."','".$this->m_fk_uk_doc_category_code."','".$this->m_isnested."')";
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
			$sql = "CALL spm_sfd_mst_biz_document(".$this->m_pk_document_id.",".$this->m_deleted_by.",'".$this->m_deletedtype."')";
			//echo "Delete sql : ".$sql ;
			$result = $this->dbal->execScalar($sql,false);
			return $result;
		}catch (Exception $ex)
		{
			$this->WriteLog($ex);
		}
	}

public function GetData($mode = SELECT_MODE_VIEW, $returntype =SELECT_RETURN_TYPE_JSONSTRING, $dbobj="",$projectionList="*",$filter="", $isMultiQuery = false, $tableNames = array())
	{		

		switch($mode)
		{
			case SELECT_MODE_VIEW:
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . (($filter == "")? "" : " WHERE " . $filter);				 
				break;
			case SELECT_MODE_TABLE :
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . (($filter == "")? "" : " WHERE " . $filter);		 
				$sql .= " limit 0,1000";
				break;
			case SELECT_MODE_SP:
				$sql = "CALL ". $dbobj;
				$sql .= ($filter == "" ?  "" : "(". $filter .")");
				//echo "CALL ".$dbobj."(". $filter .")";
				//echo "".$sql;
				break;
			default:
				$sql = " SELECT ". $projectionList ." FROM ". $dbobj . ($filter == "")? "" : " WHERE " . $filter;
				$sql .= " limit 0,1000";
				break;
		}		
		//echo "after switch ".$sql;
		//$sql = " SELECT ". $projectionList ." FROM ". $dbobj ;//. ($filter == "")? "" : " WHERE " . $filter;		
		//echo $sql;
		
		if($isMultiQuery){
			
			$tableNames = array ("studentInfo","feesInfo","installmentInfo");
			
			$dataset = $this->dbal->execReaderMultiDs($sql,$tableNames);
			//print_r($dataset);
			$return_str = "";
			if($dataset)
			{
				/*$counter = 0;
				$rec_set = $dataset[$tableNames[$counter]];
				//echo "starting do while loop...<br />";
				do{
					
					if($rec_set)
					{
						//print_r($rec_set);
						//echo "<br />";
						if($returntype == SELECT_RETURN_TYPE_JSONSTRING )
						{
							$temp_str = json_encode($rec_set);	
							//echo $temp_str . "<br />";			
							$return_str .= ($return_str == "" ? "" : ",") . $this->sanitizeBlankJSONRecordset($temp_str);
						}
					}else{
						$return_str .= $this->sanitizeBlankJSONRecordset();
					}		
					//echo $counter;
					$counter++;
					
				}while($rec_set = $dataset[$tableNames[$counter]]);
				*/
				
				if(!$dataset)
					$return_str = $this->sanitizeBlankJSONRecordset();
				else{
					if($returntype == SELECT_RETURN_TYPE_JSONSTRING){
						$return_str = json_encode($dataset);	
					}
				}
				
				return  $return_str ;
				//print_r($rec_set);
				
			}else {
				//echo "no data";
				return "NODATA";
			}	
			
		}
		
		

		
		
		
		
		
		
		
		
		
		
		
		//echo 'result printed...';
		return;
		
		$qry_res = $this->dbal->execReader($sql);
		
		/*do{
			$rec_set = $this->dbal->fetchData($qry_res, true);
			print_r($rec_set);
		}while($rec_set);
		
		echo "<br />------<br />";*/
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
			$req_deps ['doc_cat'] = "";
			//Doc Category
			$jsonDocCat= "";
			$objDocCat =  new cls_document_category();
			$jsonDocCat = $objDocCat->GetData(SELECT_MODE_TABLE,SELECT_RETURN_TYPE_JSONSTRING,'mst_biz_document_category','uk_doc_category_code, doc_category_name', "");
			$req_deps ['doc_cat'] = $jsonDocCat;
			$objDocCat = null;			
			//Parent Ledger
				
			return json_encode($req_deps);
				
		} catch (Exception $e) {
			$this->WriteLog($ex);
		}
	}	
}
?>