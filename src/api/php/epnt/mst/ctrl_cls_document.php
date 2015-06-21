<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\clsReceipt.php';

$action=$_REQUEST["a"];
//global $obj;
$obj = new clsReceipt() ;

switch($action)
{
	//Add Records
	case "a":
		
		$jsonData = $_REQUEST["p_xml"];
		
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
		}
		//alert("InAdd");
		break;
		//Edit Records
	case "e":
		//$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "mst_biz_document_category","*","");
		break;
		//Delete Records
	case "d":
		$obj->m_pk_document_id= $_REQUEST["pk_document_id"] ;
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
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "transmfeesreciept","pk_reciept_id, receip_code, fk_company_code, rcpt_no, fk_admission_id, reciept_date, pay_mode","");
		echo  $ret;
		break;
	case "p":
		$ret = $obj->getAllMastersRequired();
		echo  $ret;
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