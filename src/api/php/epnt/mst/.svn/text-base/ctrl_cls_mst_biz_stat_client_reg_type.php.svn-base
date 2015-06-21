<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_mst_biz_stat_client_reg_type.php';

$action=$_REQUEST["a"];
$obj = new cls_mst_biz_stat_client_reg_type() ;

switch($action)
{
	//Add Records
	case "a":

		$obj->m_pk_stat_client_reg_type_id= $_REQUEST["pk_stat_client_reg_type_id"] ;
		$obj->m_uk_registration_code= $_REQUEST["uk_registration_code"] ;
		$obj->m_registration_type= $_REQUEST["registration_type"] ;
		$obj->m_data_type= $_REQUEST["data_type"] ;
		$obj->m_max_length= $_REQUEST["max_length"] ;
				
		$ret = $obj->Add();
		if(intval($ret)>0){
			echo  $ret;
		}else{
			echo "FAIL";
		}		
		break;
		//Edit Records
	case "e":
		//$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_biz_document_category","*","");
		break;
		//Delete Records
	case "d":
		$obj->m_pk_stat_client_reg_type_id= $_REQUEST["pk_stat_client_reg_type_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_biz_stat_client_reg_type","*","deleted='N'");
		echo  $ret;
		break;

}
?>