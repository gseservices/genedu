<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_gen_acc_ledger.php';

$action=$_REQUEST["a"];
$obj = new cls_gen_acc_ledger();

switch($action)
{
	//Add Records
	case "a":		
		$obj->m_pk_ledger_id= $_REQUEST["pk_ledger_id"] ;
		$obj->m_ledger_name= $_REQUEST["ledger_name"] ;
		$obj->m_fk_uk_branch_code= $_REQUEST["fk_uk_branch_code"] ;
		$obj->m_fk_uk_company_code= $_REQUEST["fk_uk_company_code"] ;
		$obj->m_fk_exp_grp_code= $_REQUEST["fk_exp_grp_code"] ;
		$obj->m_ledger_type= $_REQUEST["ledger_type"] ;
		$obj->m_parent_id= $_REQUEST["parent_id"] ;
		$obj->m_anchor_id= $_REQUEST["anchor_id"] ;
		$obj->m_anchor_type= $_REQUEST["anchor_type"] ;
		$obj->m_description= $_REQUEST["description"] ;
		$obj->m_opening_bal_cb= $_REQUEST["opening_bal_cb"] ;
		$obj->m_opening_bal= $_REQUEST["opening_bal"] ;
		$obj->m_current_bal_cb= $_REQUEST["current_bal_cb"] ;
		$obj->m_current_bal= $_REQUEST["current_bal"] ;
		$obj->m_is_reversed= $_REQUEST["is_reversed"] ;		
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
		$obj->m_pk_ledger_id= $_REQUEST["pk_ledger_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_acc_ledger","*","deleted='N'");
		echo  $ret;
		break;
		/***
		 * For getting dependencies, using 'p' as switch option
		 */
	case "p":
		$ret = $obj->getAllMastersRequired();
		echo  $ret;
		break;
}
//$ret = $obj->Delete();


?>