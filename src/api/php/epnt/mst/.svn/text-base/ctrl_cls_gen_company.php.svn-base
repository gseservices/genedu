<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_gen_company.php';

$action=$_REQUEST["a"];
$obj = new cls_gen_company() ;

switch($action)
{
	//Add Records
	case "a":

	 $obj->m_pk_company_id=$_REQUEST["pk_company_id"] ;
	 $obj->m_firm_name=$_REQUEST["firm_name"] ;
	 $obj->m_uk_comp_code=$_REQUEST["uk_comp_code"] ;
	 $obj->m_comp_reg_no=$_REQUEST["comp_reg_no"] ;
	 $obj->m_address1=$_REQUEST["address1"] ;
	 $obj->m_address2=$_REQUEST["address2"] ;
	 $obj->m_city_name=$_REQUEST["city_name"] ;
	 $obj->m_phono_no=$_REQUEST["phono_no"] ;
	 $obj->m_pin=$_REQUEST["pin"] ;
	 $obj->m_fax=$_REQUEST["fax"] ;
	 $obj->m_emailId=$_REQUEST["emailId"] ;
	 $obj->m_PAN=$_REQUEST["PAN"] ;
	 $obj->m_TAN=$_REQUEST["TAN"] ;
	 $obj->m_auth_sign=$_REQUEST["auth_sign"] ;
	 $obj->m_com_logo=$_REQUEST["com_logo"] ;
	 $obj->m_bst_no=$_REQUEST["bst_no"] ;
	 $obj->m_cst_no=$_REQUEST["cst_no"] ;
	 $obj->m_vat_tin_no=$_REQUEST["vat_tin_no"] ;
	 $obj->m_service_tax_no=$_REQUEST["service_tax_no"] ;
	 $obj->m_lbt_no=$_REQUEST["lbt_no"] ;
	 $obj->m_drug_lic_no=$_REQUEST["drug_lic_no"] ;
		
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
		$obj->m_pk_company_id=$_REQUEST["pk_company_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_gen_company","*","deleted='N'");
		echo  $ret;
		break;

}
//$ret = $obj->Delete();


?>