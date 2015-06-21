<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_gen_trsc_acc_vouchers.php';

$action=$_REQUEST["a"];
//global $obj;
$obj = new cls_gen_trsc_acc_vouchers();

switch($action)
{
	//Add Records
	case "a":
		$obj->m_pk_vch_id=$_REQUEST["pk_vch_id"];
		$obj->m_uk_fk_branch_code=$_REQUEST["uk_fk_branch_code"];
		$obj->m_fk_acnt_trans_code=$_REQUEST["fk_acnt_trans_code"];
		$obj->m_vch_sr_no=$_REQUEST["vch_sr_no"];
		$obj->m_vch_date=$_REQUEST["vch_date"];
		$obj->m_fk_debit_ledger_id=$_REQUEST["fk_debit_ledger_id"];
		$obj->m_fk_credit_ledger_id=$_REQUEST["fk_credit_ledger_id"];
		$obj->m_amount=$_REQUEST["amount"];
		$obj->m_chq_no=$_REQUEST["chq_no"];
		$obj->m_chk_date=$_REQUEST["chk_date"] ;
		$obj->m_fk_bank_acnt_id=$_REQUEST["fk_bank_acnt_id"] ;
		$obj->m_chq_status=$_REQUEST["chq_status"] ;
		$obj->m_narration=$_REQUEST["narration"] ;
		$obj->m_remarks=$_REQUEST["remarks"] ;
		$obj->m_prep_by=$_REQUEST["prep_by"] ;
		$obj->m_checked_by=$_REQUEST["checked_by"] ;
		$obj->m_approved_by=$_REQUEST["approved_by"] ;
		$obj->m_rcvd_by=$_REQUEST["rcvd_by"] ;
		$obj->m_anchor_id=0;
		$obj->m_anchor_type="type";
		$obj->m_fk_comp_code=$_REQUEST["fk_comp_code"] ;
		
		$jsonData = $_REQUEST["p_xml"];
		/*$keys[0]="pk_vch_det_id" ;		
		$keys[1]="fk_ledger_id" ;
		$keys[2]="cr_dr" ;
		$keys[3]="prev_bal" ;
		$keys[4]="amount" ;
		$keys[5]="post_bal" ;
		$keys[6]="remark" ;*/

		$obj->m_p_xml= '"'.prepareXMLForDocumentsUnderVoucherDetails($jsonData).'"';
		//$obj->m_p_xml= $obj->prepareXMLForSP(htmlspecialchars_decode ($jsonData),"trsc_acc_voucher_det" , $keys,$obj->logged_in_user_id);
		//echo  $obj->prepareXMLForSP(htmlspecialchars_decode ($jsonData),"trsc_acc_voucher_det" , $keys,$obj->logged_in_user_id);
		//echo "XML".'"'.prepareXMLForDocumentsUnderVoucherDetails($jsonData).'"';
		$obj->m_isnested = "N";
			
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
		$obj->m_pk_client_work_detail_id= $_REQUEST["pk_client_work_detail_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "trsc_acc_vouchers","*","");
		echo  $ret;
		break;
	case "p":
		$ret = $obj->getAllMastersRequired();
		echo  $ret;
		break;
}

function debug($str=""){
	echo $str ."<br>";
}

function prepareXMLForDocumentsUnderVoucherDetails($jsonData)
{
	//echo $jsonData;
	 $vouchers =  json_decode($jsonData,TRUE);
	//print_r($vouchers);
	
	$XMLString="<trsc_acc_voucher_det>";
	$index = 0;
	foreach ($vouchers as $obj)
	{
	print_r($vouchers[0]);
	$XMLString=$XMLString . "<row>";			
	$XMLString=$XMLString . "<field name='fk_vch_id'>0</field>";
	$XMLString=$XMLString . "<field name='fk_ledger_id'>1</field>";//debug($XMLString);//". $obj->{"fk_debit_ledger_id"} ."
	$XMLString=$XMLString . "<field name='cr_dr'>'D'</field>";
	$XMLString=$XMLString . "<field name='prev_bal'>0</field>";
	$XMLString=$XMLString . "<field name='amount'>1000</field>";
	$XMLString=$XMLString . "<field name='post_bal'>0</field>";
	$XMLString=$XMLString . "<field name='remark'>remark</field>";
	$XMLString=$XMLString . "<field name='created_by'>1</field>";
	$XMLString=$XMLString . "<field name='modified_by'>1</field>";	
	$XMLString=$XMLString . "</row>";
	
	$index ++;
	}
	$XMLString=$XMLString . "</trsc_acc_voucher_det>";
	return $XMLString;

}
?>