<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_gen_biz_client.php';
include_once BASE_PATH . '\classes\masters\cls_gen_city.php';

$action=$_REQUEST["a"]; 
$obj = new cls_gen_biz_client() ;

switch($action)
{
	//Add Records
	case "a":

		$obj->m_pk_client_id= $_REQUEST["pk_client_id"] ;
		$obj->m_fk_uk_client_type_code= $_REQUEST["fk_uk_client_type_code"] ;
		$obj->m_uk_client_code= $_REQUEST["uk_client_code"] ;
		$obj->m_client_name= $_REQUEST["client_name"] ;
		$obj->m_l_address= $_REQUEST["l_address"] ;
		$obj->m_fk_l_uk_city_code= $_REQUEST["fk_l_uk_city_code"] ;
		$obj->m_p_address= $_REQUEST["p_address"] ;
		$obj->m_fk_p_uk_city_code= $_REQUEST["fk_p_uk_city_code"] ;
		$obj->m_email= $_REQUEST["email"] ;
		$obj->m_contact_no= $_REQUEST["contact_no"] ;
		$obj->m_mobile_no= $_REQUEST["mobile_no"] ;
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
		$obj->m_pk_client_id = $_REQUEST["pk_client_id"];
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_biz_client","*","deleted='N'");
		echo  $ret;
		break;
	case "p":
		$ret = $obj->getAllMastersRequired();
		echo  $ret;
		break;
}
//$ret = $obj->Delete();


?>