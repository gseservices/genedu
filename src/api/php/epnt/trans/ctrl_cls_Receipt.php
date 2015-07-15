<?php

require_once './../../app_const.php';
include_once BASE_PATH.'/classes/transactions/clsReceipt.php';

//echo "at the beginning of file with base path : " . BASE_PATH;



$action=$_REQUEST["a"];
$prn = $_REQUEST['p'];
$academic_year = $_REQUEST['ay'];
//echo "academic year : ". $academic_year;


//global $obj;
//echo "<br/>before receipt object creation";
try{
	$obj = new clsReceipt() ;
	//echo "receipt object created...";
}catch(Exception $ex){
	//echo "error : ".$ex;
}



//echo "before switch";

if(isset($_POST['a'])){
	$action = $_POST['a'];
	
	switch($action){
		case "a": // add new record
			if(isset($_POST['varreceip_code']))
				$obj->varreceip_code = $_POST['varreceip_code'];
			if(isset($_POST['varrcpt_no']))
				$obj->varrcpt_no = $_POST['varrcpt_no'];
			if(isset($_POST['varfk_admission_id']))
				$obj->varfk_admission_id = $_POST['varfk_admission_id'];
			if(isset($_POST['varreciept_date']))
				$obj->varreciept_date = $_POST['varreciept_date'];
			if(isset($_POST['varpay_mode']))
				$obj->varpay_mode = $_POST['varpay_mode'];
			if(isset($_POST['varch_dd_ac_no']))
				$obj->varrch_dd_ac_no = $_POST['varch_dd_ac_no'];
			if(isset($_POST['varch_dd_no']))
				$obj->varch_dd_no = $_POST['varch_dd_no'];
			if(isset($_POST['varch_dd_date']))
				$obj->varch_dd_date = $_POST['varch_dd_date'];
			if(isset($_POST['varch_dd_bbranch']))
				$obj->varch_dd_bbranch = $_POST['varch_dd_bbranch'];	
			if(isset($_POST['varch_dd_bank']))
				$obj->varch_dd_bank = $_POST['varch_dd_bank'];
			if(isset($_POST['varch_dd_status']))
				$obj->varch_dd_status = $_POST['varch_dd_status'];
			if(isset($_POST['varprevious_balance']))
				$obj->varprevious_balance = $_POST['varprevious_balance'];
			if(isset($_POST['varpaid_amt']))
				$obj->varpaid_amt = $_POST['varpaid_amt'];
			if(isset($_POST['varremark']))
				$obj->varremark = $_POST['varremark'];
			if(isset($_POST['varcreated_by']))
				$obj->varcreated_by = $_POST['varcreated_by'];
			if(isset($_POST['varmodified_by']))
				$obj->varmodified_by = $_POST['varmodified_by'];
			if(isset($_POST['varpk_reciept_id']))
				$obj->varpk_reciept_id = $_POST['varpk_reciept_id'];
			if(isset($_POST['varrcpt_type']))
				$obj->varrcpt_type = $_POST['varrcpt_type'];
			if(isset($_POST['varis_admission']))
				$obj->varis_admission = $_POST['varis_admission'];
			if(isset($_POST['varcollegetype']))
				$obj->varcollegetype = $_POST['varcollegetype'];
			if(isset($_POST['p_xml']))
				$obj->p_xml = $_POST['p_xml'];
			if(isset($_POST['var_is_rcpt_no_manual']))
				$obj->var_is_rcpt_no_manual = $_POST['var_is_rcpt_no_manual'];
			
			$ret = $obj->Add();
			if(intval($ret)>0){
				echo  $ret;
			}else{
				echo "FAIL";
			}
			break;

	}
}


switch($action)
{
	//Add Records
	case "a":
		
	/*	$jsonData = $_REQUEST["p_xml"];
		
		//prepareXMLForDocumentsUnderDocCat(htmlspecialchars_decode ($jsonData))
		$keys[0]="pk_document_id";		
		$keys[1]="uk_document_code";
		$keys[2]="document_name";
		$keys[3]="description";
				
		$obj->m_p_xml= '"'.$obj->prepareXMLForSP(htmlspecialchars_decode ($jsonData),"mst_biz_document" , $keys,$obj->logged_in_user_id).'"';		
		$obj->m_fk_uk_doc_category_code= $_REQUEST["fk_uk_doc_category_code"] ;
		//echo  $obj->prepareXMLForSP(htmlspecialchars_decode ($jsonData),"mst_biz_document" , $keys,$obj->logged_in_user_id);
		$obj->m_isnested = "N";
			
		$ret = $obj->Add();
		if(intval($ret)>0){
			echo  $ret;
		}else{
			echo "FAIL";
		}*/
		//alert("InAdd");
		break;
		//Edit Records
	case "e":
		//$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_biz_document_category","*","");
		break;
		//Delete Records
	case "d":
		/*$obj->m_pk_document_id= $_REQUEST["pk_document_id"] ;
		$obj->m_deleted_by=$_REQUEST["deleted_by"];
		$obj->m_deletedtype="s";

		$ret = $obj->Delete();
		echo $ret;
		if(intval($ret)>0){
			echo  $ret;
		}else{
			echo "FAIL";
		}*/

		break;
	case "r":
		//echo "reached at retrieval location";
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, 
			"view_for_reciept",
			"pk_reciept_id, `Reciept Code`, `Reciept No`, fk_admission_id, `Reciept Date`, `Pay Mode`, addTotalFees, paid_amt, current_balance, rcpt_type, created_on, PRN, `Student Name`, `Academic Year` ","");
		echo  $ret;
		break;
	case "rp":
		//echo "reached at retrieval location";
		$ret = $obj->GetData(SELECT_MODE_SP, SELECT_RETURN_TYPE_JSONSTRING, 
			"spt_get_fees_details_for_prn",
			"",
			"".$prn.",'".$academic_year."'" );
		echo  $ret;
		break;
	case "p":
		/*$ret = $obj->getAllMastersRequired();
		echo  $ret;*/
		break;
}

function prepareXMLForDocumentsUnderDocCat($jsonData)
{
	/*echo $jsonData;
	$documents =  json_decode($jsonData,TRUE);
	print_r($documents);
	$XMLString="<mst_biz_document>";
	$index = 0;
	foreach ($documents as $obj)
	{	
		debug("Line: " . $index . $XMLString);	
		$XMLString=$XMLString . "<row>";
		//debug($XMLString);
		$XMLString=$XMLString . "<field name='fk_uk_doc_category_code'>". $obj->{"fk_uk_doc_category_code"} ."</field>";
		//debug($XMLString);
		$XMLString=$XMLString . "<field name='uk_document_code'>". $obj->{"uk_document_code"} ."</field>";//debug($XMLString);		
		$XMLString=$XMLString . "<field name='document_name'>". $obj->{"document_name"} ."</field>";//debug($XMLString);
		$XMLString=$XMLString . "<field name='description'>". $obj->{"description"} ."</field>";//debug($XMLString);
		$XMLString=$XMLString . "<field name='created_by'>1</field>";//debug($XMLString);
		$XMLString=$XMLString . "<field name='modified_by'>1</field>";//debug($XMLString);
		$XMLString=$XMLString . "</row>";//debug($XMLString);
		$index ++;//debug($XMLString);
	}
	$XMLString=$XMLString . "</mst_biz_document>";
	echo $XMLString;*/
	
}

function debug($str=""){
	echo $str ."<br>";
}
//$ret = $obj->Delete();


?>