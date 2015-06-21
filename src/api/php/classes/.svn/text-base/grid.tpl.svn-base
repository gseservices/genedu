<?php
 /******************************************************************************************************\
 *   																									*
 *	Name 		:	grid.php																			*
 *	Purpose		:	Class for generating data grid														*
 *	Dependancy	:	DBAL class; Grid CSS script															*
 *	Author		:	Ram M Lohare, GSIPL																	*
 *																										*
 \******************************************************************************************************/


	//-- Requires/Include section
//	require_once("../class/dbal.php");

	/**
	 * Class for generating data managing grid
	 * Version			: 1.1
	 * Update Remarks	: grid using ajax 
	 */
	class DataGrid
	{
		//-- Grid Name i.e ID and NAME on output
		var $GRID_Name ="gridGSIPL";
		var $GRID_RepeatAfter=0;		// var for Grid Header repeat after n no of rows
		

		//-- Grid Data Source and Related params
		var $GDSR_srcSqlQuery="";
		var $GDSR_srcDataLink=null;
		var $GDSR_srcData=null;
		var $GDSR_fetchRowsLimit=-1;
		var $GDSR_srcDataKeyField="";

		//-- Grid Data Page Limits
		var $GDPL_reclimFrom=0;
		var $GDPL_reclimTo=25;
		var $GDPL_pageMaxRows=25;


		//-- Grid Design Parameters
		var $GDP_cssPath ="../css/grid.css";
		var $GDP_width ="100%";
		var $GDP_useAlternateRowColors =true;
		var $GDP_rowbgHoverColor ="";// "#CCFF55";
		var $GDP_rowbgOddColor ="";//"#CCCCCC";
		var $GDP_rowbgEvenColor ="";//"#FFFFCC";
		var $GDP_headerbgColor ="";//"#CCCCCC";//"#E7FFCE";//"#FFFF99";
		var $GDP_cssRowNormal="";
		var $GDP_cssColHeader ="ColHeader";
		var $GDP_cssRowText ="RowText";
		var $GDP_colCount = 0;
		var $GDP_colHeaders = array();
		var $GDP_colWidths = array();
		var $GDP_colAlign = array();
		var $GDP_hiddenCols = array();	//Input hidden column indices
		var $GDP_gridAlign= "center";
		var $GDP_srNoStartsFrom = 0;	//Sr No starts from 0 by default,
										//for page 2 suppose it starts from 11
		var $GDP_isFixHeaders;            //whether table headres are fixed (not scrolling)
		var $GDP_tBodyHeight;            //Height of the Table(Content) body
		var $GDP_isWrapText=true;            // set word wrapping true default true
		var $GDP_isFixTableLayout=false;            // sets column widths fixed when set to true 

		//-- Grid Capabilities Flags
		var $GCF_enableSelect=true;		//Enables select with sr no
		var $GCF_selectScript="";		//script for selection
		var $GCF_selectColumnNo=1;		//default is first index column 

		var $GCF_enableEdit=true;
		var $GCF_editScript="";

		var $GCF_enableDelete=true;
		var $GCF_deleteScript="";

		var $GCF_enablePrint=false;
		var $GCF_printScript="";
		var $GCF_enableSearch=false;
		var $GCF_enableSrNos=false;

		var $GCF_enableExtraCol=false;	//Enable extra column for textbox, view ApproveIndent.php for demo
		var $GCF_extraColHeader="";
		var $GCF_qtyIndex=-1;			//quantity column index to compare value of approval with

		//-- Defining form action constants
		private $FORM_ACTION_ADD = 0;
		private $FORM_ACTION_MOD = 1;
		private $FORM_ACTION_DEL = 2;
		private $FORM_ACTION_ADD_SUBMIT = 3;
		private $FORM_ACTION_MOD_SUBMIT = 4;
		private $FORM_ACTION_DEL_SUBMIT = 5;
		private $FORM_ACTION_ADD_SUBMIT_RESULT = 6;
		private $FORM_ACTION_MOD_SUBMIT_RESULT = 7;
		private $FORM_ACTION_DEL_SUBMIT_RESULT = 8;

		//-- Conditional styling parameters
		var $GCS_styleType = "row";
		var $GCS_styleSubjectIndex;		//Subject means-> column index on which condition would be checked
		var $GCS_hashConditionStyle;     // this is two dimension array (keys are values to check and related values are css class to apply when contion true.
		var $GCS_enableConditionalStyling=false;


		//-- ++ Grid Initialisation ++

		/**
		 * Class constructor
		 *
		 * @param string  Id or Name of grid
		 * @return DataGrid
		 */
		function DataGrid($gridName="")
		{
			if($gridName != ""){
				$this->GRID_Name = $gridName;
			}
		}

		/**
		 * Enter description here...
		 *
		 * @param unknown_type $srcData
		 * @param unknown_type $srcDataLink
		 * @param unknown_type $srcSqlQuery
		 * @param unknown_type $fetchRowsLimit
		 */
		function SetDataSourceAndRelated(
										$srcData=null,
										$srcDataKeyField="",
										$srcDataLink=null,
										$srcSqlQuery="",
										$fetchRowsLimit=-1)
		{
			$this->GDSR_srcData = $srcData;
			$this->GDSR_srcDataKeyField = $srcDataKeyField;
			$this->GDSR_srcDataLink = $srcDataLink;
			$this->GDSR_srcSqlQuery = $srcSqlQuery;
			$this->GDSR_fetchRowsLimit = $fetchRowsLimit;
		}

		/**
		 * Enter description here...
		 *
		 * @param unknown_type $pageMaxRows
		 * @param unknown_type $limLower
		 * @param unknown_type $limUpper
		 */
		function SetPageLimits(
								$pageMaxRows=25,
								$reclimFrom=0,
								$reclimTo=25)
		{
			$this->GDPL_reclimFrom = $limLower;
			$this->GDPL_reclimTo = $limUpper;
			$this->GDPL_pageMaxRows = $pageMaxRows;
		}

		/**
		 * Enter description here...
		 *
		 * @param unknown_type $cssPath
		 * @param unknown_type $gridwidth
		 * @param unknown_type $useAlternateRowColors
		 * @param unknown_type $rowOddColor
		 * @param unknown_type $rowEvenColor
		 * @param unknown_type $headerbgColor
		 * @param unknown_type $cssColHeader
		 * @param unknown_type $cssRowText
		 */
		function SetDesignAspects(
								$colHeaders,
								$colWidths,
								$colCount,
								$colAlign,
								$hiddenCols,	//input indices comma separated format (1,2,3)
								$cssPath="../css/grid.css",
								$gridwidth="100%",
								$srNoStartsFrom=0,
								$useAlternateRowColors=true,
								$rowHoverColor="",//"#E4EDF3",
								$rowOddColor="",//"#E4EDF3",	//"#ccffcc",#D2D7DA"
								$rowEvenColor="",//"#E4ECF7",		//"#BBCED9",
								$headerbgColor="",//"#648CA2",		//"#CCFFCC",//"#336699",//"#FFFF99",
								$cssColHeader="ColHeader",
								$cssRowText="RowText",
								$isFixHeaders=false,
								$tBodyHeight="500px",
								$isWrapText=true,                 // In true= wrap text or false=dont wrap format 
								$fixTableLayout=false            //Fix the column widths when set to true
								)
		{
			$this->GDP_colHeaders = $colHeaders;
			$this->GDP_colWidths = $colWidths;
			$this->GDP_colAlign = $colAlign;
			$this->GDP_hiddenCols = (strlen($hiddenCols)>0?explode(",",$hiddenCols):explode(",","-1"));	//prepare hidden column indices array, provide "" / "-1" for default
			$this->GDP_cssPath = $cssPath;
			$this->GDP_width = $gridwidth;
			$this->GDP_srNoStartsFrom = $srNoStartsFrom;
			$this->GDP_useAlternateRowColors = $useAlternateRowColors;
			$this->GDP_rowbgHoverColor = $rowHoverColor;
			$this->GDP_rowbgOddColor = $rowOddColor;
			$this->GDP_rowbgEvenColor = $rowEvenColor;
			$this->GDP_headerbgColor = $headerbgColor;
			$this->GDP_cssColHeader = "ColHeader";
			$this->GDP_cssRowText =$cssRowText;    // changed latter "rowtext" to $cssRowText 
			$this->GDP_colCount = $colCount ;
			$this->GDP_isFixHeaders =$isFixHeaders ;
			$this->GDP_tBodyHeight = $tBodyHeight ;
			$this->GDP_isWrapText = $isWrapText ;
			$this->GDP_isFixTableLayout = $fixTableLayout ;
		}

		/**
		 * Enter description here...
		 *
		 * @param unknown_type $enableSrNos
		 * @param unknown_type $enableEdit
		 * @param unknown_type $editScript
		 * @param unknown_type $enableDelete
		 * @param unknown_type $deleteScript
		 * @param unknown_type $enablePrint
		 * @param unknown_type $printScript
		 * @param unknown_type $enableSearch
		 */
		function SetGridCapabilities(
									$enableSrNos=true,
									$enableEdit=true,
									$editScript="",
									$enableDelete=true,
									$deleteScript=true,
									$enableSelect=true,
									$selectScript="",
									$enableExtraCol=false,
									$extraColHeader="",
									$qty_index=-1,
									$enablePrint=false,
									$printScript="",
									$enableSearch=false)
		{
			$this->GCF_enableSelect=$enableSelect;
			$this->GCF_selectScript=$selectScript;

			$this->GCF_enableEdit=$enableEdit;
			$this->GCF_editScript=$editScript;

			$this->GCF_enableDelete=$enableDelete;
			$this->GCF_deleteScript=$deleteScript;

			$this->GCF_enableExtraCol=$enableExtraCol;
			$this->GCF_extraColHeader=$extraColHeader;
			$this->GCF_qtyIndex=$qty_index;

			$this->GCF_enablePrint=$enablePrint;
			$this->GCF_printScript=$printScript;
			$this->GCF_enableSearch=$enableSearch;
			$this->GCF_enableSrNos=$enableSrNos;
		}
		// get parameter to apply conditional formating  css class to grid.
		function setConditionalStylingParams(
											$enableConditionalStyling=false,
											$styleType="row",
											$styleSubjectIndex=0,
											$hashConditionStyle=null
											)
		{			
			$this->GCS_enableConditionalStyling = $enableConditionalStyling;
			$this->GCS_styleType = $styleType;
			$this->GCS_styleSubjectIndex= $styleSubjectIndex;		//Subject means-> column index on which condition would be checked
			$this->GCS_hashConditionStyle=$hashConditionStyle;					
		}

		//-- ++ Grid Generation ++

		/**
		 * Getting data to show in grid
		 *
		 * @return mixed  Data set if available else false
		 */
		private function GetData()
		{
			try{

				if(isset($this->GDSR_srcData)){					//- If dataset is readily provided, return dataset

					return $this->GDSR_srcData;

				}elseif ($this->GDSR_srcSqlQuery != ""){		//- If sql string is supplied, chk link

					if($this->GDSR_srcDataLink){				//-- If link active, fetch data

						$oDBAL = new DBAL($this->GDSR_srcDataLink);
						$rsrc = $oDBAL->execReader($this->GDSR_srcSqlQuery);
						$data = $oDBAL->fetchData($rsrc, true, MYSQL_ASSOC, $this->GDPL_reclimFrom, $this->GDPL_reclimTo);

						return $data;
					}
				}else{

					return false;
				}

			}catch(Exception $e){

			}
		}

		function GetGeneratedHTMLforPrint($cbEnable=false,$nextIteration=false)
		{
			//Getting data
			$dataset = $this->GetData();
			$num_records=count($dataset);


			//-- Starting grid area
			$output = "<table id='$this->GRID_Name' name='$this->GRID_Name'".($this->GDP_isFixTableLayout?" style='table-layout:fixed;'":'')." width='$this->GDP_width' align='$this->GDP_gridAlign'  border='1' cellspacing='0'>\n";    //I have removed this form table  style='border-collapse:collapse;'


			//-- Setting column header
			//--- Getting column count
			$columnCount = $this->GDP_colCount + $this->GCF_enableSrNos + $this->GCF_enableEdit + $this->GCF_enableDelete + $this->GCF_enablePrint + $this->GCF_enableExtraCol;


			//--- Removing flag related count
			$columnCount = $this->GDP_colCount;

			
			
			
			
			//-----Header row 
			$output .= "\t<tr bgcolor='$this->GDP_headerbgColor'>\n";

			//--- Chking if check boxes are enabled
			if($cbEnable){
				$output .= "\t\t<th class='$this->GDP_cssColHeader'>Select</th>";
				$columnCount = $columnCount + 1;
			}
			
			//--- Chking if Sr. Nos. are enabled
			if($this->GCF_enableSrNos){
				$output .= "\t\t<th class='$this->GDP_cssColHeader'>Sr. No.</th>";
				$columnCount = $columnCount + 1;
			}

			//--- Writing column headers
			for($col_index=0; $col_index<=$columnCount-1; $col_index++){
				//echo "Index : ".$col_index. " is ".(in_array($col_index,$this->GDP_hiddenCols)?"available":"unavailable");
				if(($col_index==($columnCount-1)) && $this->GCF_enableExtraCol)
					$output .= "\t\t<th class='$this->GDP_cssColHeader' align='center' style=' visibility:".(in_array($col_index,$this->GDP_hiddenCols)?"hidden;width:0px;":"visible; width:80px;")."' >". $this->GCF_extraColHeader ."</th>";
				else
					$output .= "\t\t<th class='$this->GDP_cssColHeader' align='center' style=' visibility:".(in_array($col_index,$this->GDP_hiddenCols)?"hidden;width:0px;":"visible; width:".$this->GDP_colWidths[$col_index] .";")."' >". $this->GDP_colHeaders[$col_index] ."</th>";
				
			}
			
			
			//Is editing enabled
			if($this->GCF_enableEdit){
				
				$output .= "<th class='$this->GDP_cssColHeader' align='center' style='width:10px'>Edit</th>";
			}
			//Is deleting enabled
			if($this->GCF_enableDelete){
				$output .= "<th class='$this->GDP_cssColHeader' align='center' style='width:10px'>Delete</th>";
			}
			//Is printing enabled
			if($this->GCF_enablePrint){
				$output .= "<th class='$this->GDP_cssColHeader' align='center' style='width:10px'>View</th>";
			}
			//--- Ending column headers
			$output .= "\n\t</tr>\n";
			//------Header row end
			
			//--- Ending column headers
			$output .= "\n\t</tr>\n";
			//------Header row end
			//print("Whether Enable Fix".$this->GDP_isFixHeaders);
			// For Fix table headers.
			if($this->GDP_isFixHeaders)
				$output .="<tbody style='OVERFLOW-y:scroll;OVERFLOW-x:hidden;height:".$this->GDP_tBodyHeight.";'>";   // For scrolling only data without headers
				
			
			//-- Spitting data to grid
			$rowcount = count($dataset);

			$row_is_alternate = false;
			for($row_index=0; $row_index<$rowcount; $row_index++)
			{
				
				if($cbEnable==false && $this->GRID_RepeatAfter!=0)
				{
				//-----Header row Repeat check and print
				if($row_index>0 && ($row_index % $this->GRID_RepeatAfter==0))
				{
					//-----Header row 
					$output .= "\t<tr><td height='25px' colspan='".($columnCount+1)."'></td></tr>";
					
					$output .= "\t<tr bgcolor='$this->GDP_headerbgColor'>\n";
		
					//--- Chking if check boxes are enabled
					if($cbEnable){
						$output .= "\t\t<th class='$this->GDP_cssColHeader'>Select</th>";
					}
					
					//--- Chking if Sr. Nos. are enabled
					if($this->GCF_enableSrNos){
						$output .= "\t\t<th class='$this->GDP_cssColHeader'>Sr. No.</th>";
					}
		
					//--- Writing column headers
					for($col_index=0; $col_index<=$columnCount-1; $col_index++){
						//echo "Index : ".$col_index. " is ".(in_array($col_index,$this->GDP_hiddenCols)?"available":"unavailable");
						if(($col_index==($columnCount-1)) && $this->GCF_enableExtraCol)
							$output .= "\t\t<th class='$this->GDP_cssColHeader' align='center' style=' visibility:".(in_array($col_index,$this->GDP_hiddenCols)?"hidden;width:0px;":"visible; width:80px;")."' >". $this->GCF_extraColHeader ."</th>";
						else
							$output .= "\t\t<th class='$this->GDP_cssColHeader' align='center' style=' visibility:".(in_array($col_index,$this->GDP_hiddenCols)?"hidden;width:0px;":"visible; width:".  $this->GDP_colWidths[$col_index] .";")."' >". $this->GDP_colHeaders[$col_index] ."</th>";
					}
					
					
				}
				//-----Header row Repeat check and print end
				}
				
				
				if($row_is_alternate){
					$row_bg_color=$this->GDP_rowbgEvenColor;
					$row_is_alternate = false;
				}else{
					$row_bg_color=$this->GDP_rowbgOddColor;
					$row_is_alternate = true;
				}

				$row = $dataset[$row_index];
				
				//set conditional css class to row if conditional style is true   
				//check conditional style is enabled yes then check style type if it is Row then search conditional column value in arry and it will return key(css class) for sucessful searched value.     
				
				$searchedValueKey=($this->GCS_enableConditionalStyling==true?($this->GCS_styleType=="Row"?array_search(trim($row[$this->GCS_styleSubjectIndex]),$this->GCS_hashConditionStyle):false):false);
				if($searchedValueKey)     //when search is successful set its key to td class.
					$this->GDP_cssRowText=$searchedValueKey;
				else	
					$this->GDP_cssRowText="RowText";   //I need to change it later to $this->GCS_hashConditionStyle[*]
				
				//conditional css styling end here 
				
				//--- Starting row
				$output .= "\t<tr style='height:20px'id='hoverrowTemp' bgcolor='".$row_bg_color."'>\n";
				
				// --- check check boxes are enabels or not ---//
				if($cbEnable){
//					if($this->GCF_enableSelect)
//					{
//						$output .= "\t\t<td  class='$this->GDP_cssRowText' style='width:50px' align='center'> <a href='#' onclick='editData(". $row[$this->GDSR_srcDataKeyField] .");' style=' cursor:hand;'>$srno</a></td>";
//					}
//					else
//					{
						$output .= "\t\t<td  class==true?)='$this->GDP_cssRowText' style='width:50px' align='center'> <input class='chkBox' type='checkbox' id='cb$row_index'  name='cb$row_index' value='".$row[$this->GDSR_srcDataKeyField]."' /> </td>";
//					}
				}
				
				// --- check sr.no enabels or not ---//
				if($this->GCF_enableSrNos){
					$srno = $this->GDP_srNoStartsFrom + $this->GDPL_reclimFrom + $row_index + 1;
					if($this->GCF_enableSelect)
					{
						$output .= "\t\t<td id=td$row_index class='$this->GDP_cssRowText' style='width:50px' align='center'> <a href='#' id='".$this->GRID_Name."_selectRow' Pid=". $row[$this->GDSR_srcDataKeyField] ." style=' cursor:hand;'>$srno</a></td>";
					}
					else
					{
						$output .= "\t\t<td  class='$this->GDP_cssRowText' style='width:50px'> $srno </td>";
					}
				}
				for ($col_index=0; $col_index<=$columnCount-1; $col_index++)
				{
					/*---------------- Not needed for this application --------------------
					//set conditional css class to cell if conditional style is true   
					//check conditional style is enabled yes then check style type if it is Cell then search conditional column value in arry and it will return key(css class) for sucessful searched value.     
					$this->GDP_cssRowText="RowText";    // default css
					if($successKey=($this->GCS_enableConditionalStyling==true?($this->GCS_styleType=="Cell"?($this->GCS_styleSubjectIndex==$col_index?array_search(trim($row[$col_index]),$this->GCS_hashConditionStyle):false):false):false))
						$this->GDP_cssRowText=$successKey;              //if value is searched then set it's key as class
					//conditional css styling end here
					*/
					if(($col_index==($columnCount-1)) && $this->GCF_enableExtraCol)
					{
						$output .= "<td ".($this->GDP_isWrapText?"":"nowrap='nowrap'")." class=''  style='text-align:center; visibility:".(in_array($col_index,$this->GDP_hiddenCols)?"hidden; width:0px":"visible;width:*;")."' align='center'><a href='#' ><img id='".$this->GRID_Name."_selectRow'  name='".$this->GRID_Name."_selectRow' Pid=". $row[$this->GDSR_srcDataKeyField]." src='images/view.png' width='15px' height='15px' /></a></td>";
					}
					else
					{
						if($col_index==1 && $this->GCF_enableEdit)
							$output .= ($this->GCF_enableSrNos?"":"\t\t") . "<td   ".($this->GDP_isWrapText?"":"nowrap='nowrap'")." class='$this->GDP_cssRowText'  style='text-align:". $this->GDP_colAlign[$col_index] ."; visibility:".(in_array($col_index,$this->GDP_hiddenCols)?"hidden; width:0px":"visible;width:". $this->GDP_colWidths[$col_index] ).";'>". $row[$col_index] ."</td>";//<a href='#' onclick='editData(". $row[$this->GDSR_srcDataKeyField] .");' style='cursor:hand;'>". $row[$col_index] ."</a></td>";						
						else 
						{
							if(strlen($row[$col_index])>3 && (strpos($row[$col_index], '/')==0 || strpos($row[$col_index], '/')==(strlen($row[$col_index])-1)))
								$output .= ($this->GCF_enableSrNos?"":"\t\t") . "<td id=td$col_index".($this->GDP_isWrapText?"":"nowrap='nowrap'")." class='$this->GDP_cssRowText'  style='text-align:". $this->GDP_colAlign[$col_index] ."; visibility:".(in_array($col_index,$this->GDP_hiddenCols)?"hidden; width:0px":"visible;width:". $this->GDP_colWidths[$col_index] ).";'>". str_replace('/','',$row[$col_index]) ."</td>";
							else
								$output .= ($this->GCF_enableSrNos?"":"\t\t") . "<td  ".($this->GDP_isWrapText?"":"nowrap='nowrap'")." class='$this->GDP_cssRowText'  style='text-align:". $this->GDP_colAlign[$col_index] ."; visibility:".(in_array($col_index,$this->GDP_hiddenCols)?"hidden; width:0px":"visible;width:". $this->GDP_colWidths[$col_index] ).";'>". ($row[$col_index]!="/" && $row[$col_index]!="0 %" ? $row[$col_index] :"") ."</td>";
						}
					}
				}
				
				//Is editing enableed
				if($this->GCF_enableEdit){
					
					$output .= "<td class='$this->GDP_cssColHeader' align='center' style='width:10px'><a href='#'  style='cursor:hand;'><img alt='Edit' id='".$this->GRID_Name."_editData' Pid=". $row[$this->GDSR_srcDataKeyField] ." src='Images/edit.png' width='15px' height='15px'/></a></td>";
				}
				//Is deleting enableed
				if($this->GCF_enableDelete){
					$output .= "<td class='$this->GDP_cssColHeader' align='center' style='width:10px'><a href='#' ><img alt='Delete' id='".$this->GRID_Name."_deleteData' Pid=". $row[$this->GDSR_srcDataKeyField] ." src='Images/delete.png' width='15px' height='15px'  style='text-decoration:none; cursor:hand;'/></a></td>";
				}
				//Is printing enabled
				if($this->GCF_enablePrint){
					$output .= "<td class='$this->GDP_cssColHeader' align='center' style='width:10px'><a href='#'  style='cursor:hand;'><img alt='viewMore' id='".$this->GRID_Name."_viewMore' Pid=". $row[$this->GDSR_srcDataKeyField] ." src='Images/viewMore.png' width='15px' height='15px'/></a></td>";
				}

				//--- Ending row
				$output .= "\n \t </tr> \n";
				
			}
			
			if($this->GDP_isFixHeaders)
				$output .="</tbody>";	//close table body 
			//-- Ending grid area
			$output .= "</table>\n";
			//Clearing cache
			//header("Cache-Control: no-cache, must-revalidate");   //JPA has commented this because it giving error.
			
			return $output;
		}
		
		
		
		
		
	}
?>