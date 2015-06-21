<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_document_category.php';

$action=$_REQUEST["a"];
$obj = new cls_document_category() ;

switch($action)
{
	//Add Records
	case "a":

		$obj->m_pk_doc_category_id= $_REQUEST["pk_doc_category_id"] ;
		$obj->m_uk_doc_category_code=$_REQUEST["uk_doc_category_code"];
		$obj->m_doc_category_name=$_REQUEST["doc_category_name"];
		$obj->m_description=$_REQUEST["description"];

		$ret = $obj->Add();
		if(intval($ret)>0){
			echo  $ret;
		}else{
			echo "FAIL";
		}
		//alert("InAdd");
		break;
		//Edit Records
	case "e":
		//$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_biz_document_category","*","");
		break;
		//Delete Records
	case "d":
		$obj->m_pk_doc_category_id= $_REQUEST["pk_doc_category_id"] ;
		$obj->m_deleted_by=$_REQUEST["deleted_by"];
		$obj->m_deletedtype="s";

		$ret = $obj->Delete();
		echo $ret;
		if(intval($ret)>0){
			echo  $ret;
		}else{
			echo "FAIL";
		}	
		
		break;
	case "r":
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_biz_document_category","*","deleted='N'");
		echo  $ret;
		break;

}
//$ret = $obj->Delete();


?>