<?php

    $time_start = microtime(true);

	/*	CHECK THAT THIS IS INDEX	*/
	define("SECURITY_INDEX", true);
	
	/*	APPLICATION PATHS	*/
	define("APP_FOLDER", __DIR__."/app/");
	define("SYSTEM_FOLDER", __DIR__."/system/");
	define("CONTENT_FOLDER", __DIR__."/content/");


	
	
	/*	RUN SYSTEM BOOTLOADER 	*/
	if(file_exists(SYSTEM_FOLDER."bootloader.php")){
		include(SYSTEM_FOLDER."bootloader.php");
	} else die();


    $time_end = microtime(true);
    $time = $time_end - $time_start;

    //echo "Executed time: $time seconds\n";