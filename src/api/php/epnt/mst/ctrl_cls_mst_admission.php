<?php

require_once './../../app_const.php';
include_once BASE_PATH.'/classes/masters/clsAdmission.php';

//echo "at the beginning of file with base path : " . BASE_PATH;



$action=$_REQUEST["a"];



//global $obj;
//echo "<br/>before admission object creation";
try{
	$obj = new clsAdmission() ;
	//echo "admission object created...";
}catch(Exception $ex){
	//echo "error : ".$ex;
}



//echo "before switch";



switch($action)
{
	//Add Records
	case "a":
		break;
		//Edit Records
	case "e":
		break;
		//Delete Records
	case "d":
		break;
	case "sl":
		$studentNameCriteria = "";
		$academicYear = "";
		if(isset($_REQUEST['snc']))
			$studentNameCriteria = $_REQUEST['snc'];
		if(isset($_REQUEST['ay']))
			$academicYear = $_REQUEST['ay'];
		
		$filterCriteria = "deleted='N'";
		if($studentNameCriteria)
			$filterCriteria .= " AND (firstname like '".$studentNameCriteria."%' OR surname like '" .$studentNameCriteria."%')";
		if($academicYear)
			$filterCriteria .= " AND academic_year = '". $academicYear."'";
			
		$filterCriteria .= " order by studentname";
		//echo "reached at retrieval location";
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, 
			"mstadmission",
			"prn_no,pk_admission_id,concat(firstname, concat(' ', concat(middlename, concat(' ', surname)))) as studentname,academic_year",
			$filterCriteria);
		echo  $ret;
		break;
		
	case "r":
		//echo "reached at retrieval location";
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, 
			"mstadmission",
			"*",
			"deleted='N'");
		echo  $ret;
		break;
	
	case "p":
		break;
}

function debug($str=""){
	echo $str ."<br>";
}

?>