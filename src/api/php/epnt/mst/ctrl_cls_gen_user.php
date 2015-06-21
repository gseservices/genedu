<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_gen_user.php';

$action=$_REQUEST["a"];
$obj = new cls_gen_user() ;

switch($action)
{
	//Add Records
	case "a":

		$obj->m_pk_user_id=$_REQUEST["pk_user_id"] ;
		$obj->m_uk_user_code=$_REQUEST["uk_user_code"] ;
		$obj->m_user_name=$_REQUEST["user_name"] ;
		$obj->m_password=$_REQUEST["password"] ;
		$obj->m_description=$_REQUEST["description"] ;
		
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
		$obj->m_pk_user_id=$_REQUEST["pk_user_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_gen_user","*","deleted='N'");
		echo  $ret;
		break;

}
//$ret = $obj->Delete();


?>