<?php

	/*
		NEVER LET DEBUGGING ACTIVATED ON PRODUCT MODE
	*/
    define("APPLICATION_DEBUG", true);
	
	/*
		TEMPLATE FOLDER
	*/
	define("TEMPLATE_FOLDER", __DIR__."/template/");
	
	/*
	 *  CACHE FOLDER
	 */
    define("CACHE_FOLDER", APP_FOLDER."cache/");

    /*
     *  REPORT ERRORS ON EMAIL
     */
    define("APP_ERROR_REPORTING_EMAIL", false);