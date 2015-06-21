<?php
include_once BASE_PATH . '\classes\clsBase.php';
include_once BASE_PATH . '\classes\masters\cls_document_category.php';

class cls_document extends clsBase
{
	public $m_pk_document_id=0;
	public $m_fk_uk_doc_category_code="cate";
	public $m_uk_document_code="Document";
	public $m_document_name="Document";
	public $m_description="desc";	
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
			$sql = "CALL spm_iu_mst_biz_document_xml($this->m_p_xml,'".$this->m_fk_uk_doc_category_code."','".$this->m_isnested."')";
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