<?php
	/************************************************/
	/*	GENERAL SECTION								*/
	/************************************************/
	/**
	 * 
	 * @var Base directory for project
	 */
	define("BASE_PATH",dirname(__FILE__)) ;
	
	/************************************************/
	/*	DATABASE SECTION							*/	
	/************************************************/
	define("SELECT_MODE_VIEW",0);
	define("SELECT_MODE_TABLE",1);
	define("SELECT_MODE_SP",2);
	define("SELECT_RETURN_TYPE_ARRAY",400);
	define("SELECT_RETURN_TYPE_JSONSTRING",401);	
?>