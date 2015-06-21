<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_biz_user_group.php';

$action=$_REQUEST["a"];
$obj = new cls_biz_user_group() ;

switch($action)
{
	//Add Records
	case "a":

		$obj->m_pk_usr_grp_id= $_REQUEST["pk_usr_grp_id"] ;
		$obj->m_user_group_code= $_REQUEST["user_group_code"] ;
		$obj->m_user_group_name= $_REQUEST["user_group_name"] ;
		$obj->m_user_group_desc= $_REQUEST["user_group_desc"] ;
		
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
		$obj->m_pk_usr_grp_id= $_REQUEST["pk_usr_grp_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_biz_user_group","*","deleted='N'");		
		echo  $ret;
		break;

}
//$ret = $obj->Delete();


?>