<?php
	
	/*
		CHECK FOR INDEX INCLUSION
	*/
	if(!defined("SECURITY_INDEX")) die();


    /*
     *  INCLUDE APP CONFIG
     */
    if(file_exists(APP_FOLDER."configs/_app.php")) {
        include(APP_FOLDER . "configs/_app.php");
    }
    else die();

	
	/*
		INCLUDE FRAMEWORK CORE
	*/
	if(file_exists(SYSTEM_FOLDER."class_core.php")){
		include(SYSTEM_FOLDER."class_core.php");
		$c = new Core;
	}
	else
		if(APPLICATION_DEBUG == true)
			die("<b>System Core not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);
	

    /*
     *  INCLUDE APP MODULES
     */
    if(file_exists(APP_FOLDER."appmodules.php")){

        foreach(include(APP_FOLDER."appmodules.php") as $mod){
           switch($mod){
               case "database":
                   // INCLUDE DATABASE
                   if(file_exists(SYSTEM_FOLDER."class_database.php")){

                       // LOAD AND CONNECT TO DATABASE
                       if(file_exists(APP_FOLDER."configs/_database.php")) {
                           include(SYSTEM_FOLDER."class_database.php");

                           $db = new database(include(APP_FOLDER."configs/_database.php"));

                       }
                       else
                           if(APPLICATION_DEBUG == true)
                               die("<b>DATABASE CONFIGURATION not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);


                   }
                   else
                       if(APPLICATION_DEBUG == true)
                           die("<b>DATABASE CORE not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);

               break;

               // CHECK FOR MODULE
               default:
                    if(file_exists(SYSTEM_FOLDER."modules/".$mod."/controller_".$mod.".php")){
                        include(SYSTEM_FOLDER."modules/".$mod."/controller_".$mod.".php");
                    }
                    else
                        if(APPLICATION_DEBUG == true)
                            die("<b>MODULE ".$mod." not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);
               break;
           }
        }
    }
    else
        if(APPLICATION_DEBUG == true)
            die("<b>APP MODULES not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);



    /*
     *  INCLUDE URL CLASS
     */
    if(file_exists(SYSTEM_FOLDER."class_url.php")){
        include(SYSTEM_FOLDER."class_url.php");
        $url = new Url;
        define("BASE_URL", $url->base_url);
    }
    else
        if(APPLICATION_DEBUG == true)
            die("<b>URL CLASS not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);

	/*
		INCLUDE ROUTES
	*/
	if(file_exists(APP_FOLDER."routes.php")){
		include(APP_FOLDER."routes.php");
	}
	
