<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_gen_employee.php';

$action=$_REQUEST["a"];
$obj = new cls_gen_employee() ;

switch($action)
{
	//Add Records
	case "a":

		$obj->m_pk_employee_id= $_REQUEST["pk_employee_id"] ;
		$obj->m_uk_employee_code= $_REQUEST["uk_employee_code"] ;
		$obj->m_group_type= $_REQUEST["group_type"] ;
		$obj->m_f_name= $_REQUEST["f_name"] ;
		$obj->m_m_name= $_REQUEST["m_name"] ;
		$obj->m_l_name= $_REQUEST["l_name"] ;
		$obj->m_l_address= $_REQUEST["l_address"] ;
		$obj->m_fk_l_city_code= $_REQUEST["fk_l_city_code"] ;
		$obj->m_p_address= $_REQUEST["p_address"] ;
		$obj->m_contact_no= $_REQUEST["contact_no"] ;
		$obj->m_mobile_no= $_REQUEST["mobile_no"] ;
		$obj->m_fk_p_city_code= $_REQUEST["fk_p_city_code"] ;
		$obj->m_joning_date= $_REQUEST["joning_date"] ;
		$obj->m_dob= $_REQUEST["dob"] ;
		$obj->m_gender= $_REQUEST["gender"] ;
		$obj->m_bank_account_no= $_REQUEST["bank_account_no"] ;
		$obj->m_bank_name= $_REQUEST["bank_name"] ;
		$obj->m_bank_branch= $_REQUEST["bank_branch"] ;
		$obj->m_ifcf_no= $_REQUEST["ifcf_no"] ;
		$obj->m_basic_salary= $_REQUEST["basic_salary"] ;
		$obj->m_extra_salary= $_REQUEST["extra_salary"] ;
		
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
		$obj->m_pk_employee_id= $_REQUEST["pk_employee_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_gen_employee","*","deleted='N'");
		echo  $ret;
		break;
	case "p":
		$ret = $obj->getAllMastersRequired();
		echo  $ret;
		break;
}
//$ret = $obj->Delete();


?>