<?php

require_once './../../app_const.php';
include_once BASE_PATH.'/classes/masters/clsCourse.php';

//echo "at the beginning of file with base path : " . BASE_PATH;



$action=$_REQUEST["a"];



//global $obj;
//echo "<br/>before college type object creation";
try{
	$obj = new clsCourse() ;
	//echo "college type object created...";
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
	case "r":
		//echo "reached at retrieval location";
		$ret = $obj->GetData(SELECT_MODE_TABLE, SELECT_RETURN_TYPE_JSONSTRING, 
			"mstcourse",
			"courseId, courseName, courseType, mediumid, coursecode",
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