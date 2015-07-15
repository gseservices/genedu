<?php

	//include_once(BASE_PATH . "\classes\dbal.php");
	/**
	 * class DBAL : Database Access Layer for MySql 5.x
	 *
	 */
	class DBAL
	{
		/**
		 * IP address / URL of server
		 *
		 * @var string
		 */
		protected $host="localhost";//"ersandeep.com";//116.73.88.162
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
		protected $pwd="root";//'edupwd';//'gsipl$1234';
		/**
		 * Database name
		 *
		 * @var string
		 */		
		protected $db="edu_soft_cmngr_psba";//"ersandee_edulive";	//"gsiplc1j_beta"
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
		var $last_err;
		
		/**
		 * Class constructor
		 *
		 * @param mysql_link_identifier $use_this_link_id
		 * @return DBAL
		 */
		function DBAL(&$use_this_link_id)
		{
			try{
				$this->myLink=$use_this_link_id;
				if ($this->myLink)
				{
				//echo "connection ok";
				}else{
				//echo "conn n_ok";
				}
								
			}catch(Exception $e){
				echo "dbal object cannot be created.. error ". $e.get_message();
				$this->WriteLog($e);
			}
		}
			
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
				$link=mysqli_connect($this->host,$this->user,$this->pwd);				
				$this->myLink= $link;
				if ($link){
					if($selectDB){
						if($dbname!=""){
							$this->db=$dbname;
						}						
						$select=mysqli_select_db($this->db);
						if ($select){
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
		
		/**
		 * Closes currently active connection, if open
		 * returns true on close success and if no active conn is there
		 * else returns false
		 *
		 * @return bool
		 * @copyright GSIPL
		 */
		function closeconnect()
		{
			try
			{
				if ($this->myLink)
				{
					return mysqli_close($this->myLink);
				}
				else{
					return true;
				}
			}
			catch (Exception $e)
			{
				$this->WriteLog($e);
			}
		}
		
		/**
		 * Execute provided sql string and return either rowid(insert), 
		 * true(success of update/delete) or false on failure
		 *
		 * @param string $sql
		 * @return mixed
		 */
		function execScalar($sql, $return_insert_id=false)
		{
			try 
			{

				$is_qry_ok = mysqli_query($this->myLink,$sql);
								
				//echo "<br>" ;
				if ($is_qry_ok)
				{	
					if($return_insert_id){
						//retriving newly inserted id
						$res_arr = $this->fetchData($is_qry_ok,FALSE,MYSQL_BOTH);
						return $res_arr[0];
					}
					else{
						return true;
					}					
				}
				else 
				{		
					echo "Error -".mysqli_error($this->myLink);
					$this->last_err= mysqli_errno($this->myLink);
					return false;
				}
				
			}
			catch(Exception $e){
				$this->WriteLog($e);
				throw $e;				
			}
		}
		function execReaderMultiDs($sql,$mode=MYSQL_ASSOC){
			try {
				if($sql != ""){
					//echo $sql;
					
					$dataset = array();
					
					if (mysqli_multi_query($this->myLink, $sql)) {
					    do {
					        /* store first result set */
					        if ($result = mysqli_use_result($this->myLink)) {
					            
								$table = array();
								
								while ($row = mysqli_fetch_array($result,$mode)) {
					                array_push($table, $row);
					            }
					            mysqli_free_result($result);
								
								array_push($dataset, $table);
					        }
					        /* print divider */
					        /*if (mysqli_more_results($this->myLink)) {
					            printf("-----------------\n");
					        }*/
					    } while (mysqli_next_result($this->myLink));
						
					}
					
					
					return $dataset;
				}
				else{
					return false;
				}
			}
			catch (Exception $e){
				echo "Exception: ". $e->getMessage();
				$this->WriteLog($e);
			}
		}
		
		/**
		 * Executes query on mysql server and returns data resource on success
		 * else, returns false
		 *
		 * @param string $sql
		 * @return mixed  data resource on success, false on failure
		 */
		function execReader($sql)
		{			
			try {
				if($sql != ""){
					//echo $sql;
					$rsrc=mysqli_query($this->myLink,$sql);
					return $rsrc;
				}
				else{
					return false;
				}
			}
			catch (Exception $e){
				echo "Exception: ". $e->getMessage();
				$this->WriteLog($e);
			}
		}
		
		/**
		 * Fetches data from a query resource
		 *
		 * @param resource $qry_resource  most probably resource returned by execReader
		 * @param result_mode[optional] $mode  can be from- MYSQL_NUM, MYSQL_ASSOC
		 * @param bool[optional] $getRowset  flag, whether to return rowset or a single row
		 * @param int[optional] $lim_from  
		 * @param int[optional] $lim_to
		 * @return mixed
		 */
		
		function fetchData($qry_resource, $getRowset=false, $mode=MYSQL_ASSOC, $lim_from=-1, $lim_to=-1)
		{			
			try{
				if($getRowset){
					$rowset = array();
					$i=1;
					while($cur_row=mysqli_fetch_array($qry_resource,$mode)){						
						array_push($rowset,$cur_row);							
					}	
					mysqli_free_result($qry_resource);	
					
					return $rowset;	
					
				}
				else{
					$row=mysqli_fetch_array($qry_resource,$mode);
					return $row;
				}				
			}
			catch(Exception $e){
				
				$this->WriteLog($e);
			}
		}
		
		/**
		 * Frees mysql data resource
		 *
		 * @param resource $qry_resource resource returned by execReader
		 * @return bool
		 */
		function freeDataResource($qry_resource)
		{
			try{
				return mysqli_free_result($qry_resource);
			}
			catch (Exception $e){
				$this->WriteLog($e);
			}
		}
		
		/**
		 * Returns data at desired row number
		 *
		 * @param resource $qry_resource
		 * @param int $row_index
		 * @return mixed  data if success, false if failure
		 */
		function SeekNFetchData($qry_resource,$row_index,$mode=MYSQL_ASSOC)
		{
			try{
				mysqli_data_seek($qry_resource,$row_index);
				$desired_row=mysqli_fetch_array($qry_resource,$mode);
				return $desired_row;
			}catch(Exception $e){
				$this->WriteLog($e);
				return false;
			}
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
?>