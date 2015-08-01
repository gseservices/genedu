<?php

include_once(BASE_PATH . "/classes/dbal.php");

//echo "at the beginning of clsbase";
//OnClick="return validateGeneralNotice();"
abstract class clsBase
{
	/**
	 * IP address / URL of server
	 *
	 * @var string
	 */
	protected $host="192.168.1.101";//"ersandeep.com";//116.73.88.162
	/**
	 * mysql Username
	 *
	 * @var string
	 */
	protected $user="root";//"ersandee_eduusr"; //"gsiplc1j_beta";
	/**
	 * mysql Password for user
	 *
	 * @var string
	 */
	protected $pwd="admin";//'edupwd';//'gsipl$1234';
	/**
	 * Database name
	 *
	 * @var string
	 */		
	protected $db="edu_soft_cmngr_psba_web";//"ersandee_edulive";	//"gsiplc1j_beta"
	/**
	 * mysql link identifier
	 *
	 * @var  link_identifier
	 */
	var $myLink;
	/**
	 * Holds description of last error occured
	 *
	 * @var string
	 */
	public $logged_in_user_id=1;
	public $last_err;

	public $mCreatedBy;
	public $mCreatedOn;
	public $mUpdatedby;
	public $mUpdatedOn;
	public $mDeleted;

	abstract protected function Add();
	abstract protected function Update();
	abstract protected function Delete();
	abstract protected function GetData();
	/**
	 * Attempts to connect mysql server and selects default database(optional)
	 *
	 * @param bool[optional] $selectDB flag, whether to perform selectdb() or not
	 * @param string[optional] $dbname database name
	 * @return mixed true if link and db selection is successful else false
	 * @copyright GSIPL
	*/
	function connect($selectDB=true,$dbname="")
	{
		try {
			if(MysqlLink::$current_active_link){					
				$link=MysqlLink::$current_active_link;
			}else{
				$link=mysqli_connect($this->host,$this->user,$this->pwd);
				MysqlLink::$current_active_link = $link;				
			} 
				
			$this->myLink= $link;
			//				unset($link);
			if ($link){
				if($selectDB){
					if($dbname!=""){
						$this->db=$dbname;
					}
						
					$select=mysqli_select_db( $this->myLink,$this->db);
					if ($select){
						//echo "Connection set from base class\n";
						return true;
					}
					else{
						return false;
					}
				}
				return true;
			}
			else {
				return false;
			}
		}
		catch (Exception $e){
			$this->WriteLog($e);
		}
	}

	function clsBase()
	{
		if($this->checkUserSession())
		{
			$this->connect();
		}else{
			echo "INVSES";
			die();
		}		
	}
	
	function checkUserSession()
	{		
		return true;
	}
	
	function sanitizeBlankJSONRecordset($strJSON="")
	{
		if($strJSON == "")
		{
			return "[]";
		}else{
			return $strJSON; 
		}
	}
	
	/**
	 * @param string $jsonData.<br>
	 * JSON formatted string to be converted in xml.
	 * @param string $root_element.<br> 
	 * Name of root element in xml.
	 * @param array<string> $keys. <br>
	 * Array of field names ideally for preparing xml
	 * @param int $user_id <br>
	 * Currently logged in user id
	 * @return string<br>
	 * Returns xml string which can be passed to SP
	 */
	function prepareXMLForSP($jsonData,$root_element,$keys,$user_id){		
		$json_arr =  json_decode($jsonData);		
		
		$XMLString="<$root_element>";		
		foreach ($json_arr as $obj)
		{			
			$XMLString=$XMLString . "<row>";			
			foreach($keys as $key)
			{
				$XMLString=$XMLString . "<field name='".$key."'>". $obj->{"$key"} ."</field>";				
			}			
			$XMLString=$XMLString . "<field name='created_by'>$user_id</field>";
			$XMLString=$XMLString . "<field name='modified_by'>$user_id</field>";
			$XMLString=$XMLString . "</row>";
			$index ++;
		}
		$XMLString=$XMLString . "</$root_element>";
		return $XMLString;		
	}

	/**
	 * Write error log and event log, update error related vars
	 *
	 * @param Exception $exception
	 */
	function WriteLog(&$exception)
	{
		$e=new Exception();
		$e=$exception;
		$this->last_err = mysqli_errno($this->myLink)."::". $e->getMessage();
	}
}

/**
 * @author SDP
 * Class to hold Mysql Active Connection Objects
 */
class MysqlLink
{	
	/**
	 * @var static var holding cuttent active link
	 */
	static $current_active_link;
}
?>