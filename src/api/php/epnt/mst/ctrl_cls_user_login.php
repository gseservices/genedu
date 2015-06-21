<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_user_login.php';

$action=$_REQUEST["a"];
$obj = new cls_user_login() ;

switch($action)
{
	//Add Records
	case "a":

		$obj->m_user_name= $_REQUEST["user_name"] ;
		$obj->m_password= $_REQUEST["password"] ;	
		
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
		break;
	case "r":
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_gen_user","*","deleted='N'");
		echo  $ret;
		break;
}
?>