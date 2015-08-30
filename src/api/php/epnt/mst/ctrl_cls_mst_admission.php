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
		
		$filterCriteria = "m.deleted='N'";
		
		if($studentNameCriteria){
			if(is_numeric($studentNameCriteria)){
			//if(is_int(is_numeric($studentNameCriteria))){
				//echo "hi2";
				$filterCriteria .= " AND prn_no =".$studentNameCriteria;
				//echo "hi 3";
			}
				
			else
				$filterCriteria .= " AND (firstname like '".$studentNameCriteria."%' OR middlename like '".$studentNameCriteria."%' OR surname like '" .$studentNameCriteria."%'" .")";		
		}else{
			$filterCriteria = "No filter criteria";
		}
				
		if($academicYear)
			$filterCriteria .= " AND academic_year = '". $academicYear."'";
		
				
		$filterCriteria .= " order by studentname";
		//echo "reached at retrieval location";
		/*$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, 
			"mstadmission", // inner join mstcourse c on mstadmission.fk_course_id = c.courseId",
			"prn_no,pk_admission_id,concat(firstname, concat(' ', concat(middlename, concat(' ', surname)))) as studentname,academic_year", //,c.coursecode",
			$filterCriteria);*/
			
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING,
			"mstadmission m inner join mstcourse c on m.fk_course_id = c.courseId",
			"prn_no,pk_admission_id,concat(firstname, concat(' ', concat(middlename, concat(' ', surname)))) as studentname,academic_year,c.`coursecode`,(select div_name from mstdivision where pk_div_id=m.fk_division_id) as student_div",
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