<?php
require_once '.\..\..\app_const.php';
include_once BASE_PATH . '\classes\masters\cls_biz_client_stat_reg_detail.php';

$action=$_REQUEST["a"];
$obj = new cls_biz_client_stat_reg_detail() ;

switch($action)
{
	//Add Records
	case "a":
		
		$jsonData = $_REQUEST["p_xml"];		 
		//prepareXMLForDocumentsUnderDocCat(htmlspecialchars_decode ($jsonData))
		$keys[0]="pk_client_reg_det_id";
		$keys[1]="fk_uk_client_code";
		$keys[2]="fk_uk_registration_code";
		$keys[3]="particuler";
		$keys[4]="description";		
						
		$obj->m_p_xml= $obj->prepareXMLForSP(htmlspecialchars_decode ($jsonData),"mst_biz_client_stat_reg_detail" , $keys,$obj->logged_in_user_id);		
		echo  $obj->prepareXMLForSP(htmlspecialchars_decode ($jsonData),"trsc_biz_client_work_planner" , $keys,$obj->logged_in_user_id);
		$obj->m_isnested = "N";
			
		$ret = $obj->Add();
		//echo ("valret". $ret);
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
		$obj->m_pk_client_reg_det_id = $_REQUEST["pk_client_reg_det_id"] ;
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
		$filter ="";
		if(isset($_REQUEST["client_filter"])){
			$filter = htmlspecialchars_decode($_REQUEST["client_filter"]);
		}
		//echo $filter ;
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, "vm_for_mst_biz_client_stat_reg_detail","*",$filter);
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

?>