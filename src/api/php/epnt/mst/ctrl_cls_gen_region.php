<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_gen_region.php';

$action=$_REQUEST["a"];
$obj = new cls_gen_region() ;

switch($action)
{
	//Add Records
	case "a":

		$obj->m_pk_region_id= $_REQUEST["pk_region_id"] ;
		$obj->m_fk_uk_comp_code= $_REQUEST["fk_uk_comp_code"] ;
		$obj->m_uk_region_code= $_REQUEST["uk_region_code"] ;
		$obj->m_region= $_REQUEST["region"] ;
		$obj->m_region_manager= $_REQUEST["region_manager"] ;
		$obj->m_description= $_REQUEST["description"] ;
		
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
		$obj->m_pk_region_id= $_REQUEST["pk_region_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_gen_region","*","deleted='N'");
		echo  $ret;
		break;
	case "p":
		$ret = $obj->getAllMastersRequired();
		echo  $ret;
		break;
}
//$ret = $obj->Delete();


?>