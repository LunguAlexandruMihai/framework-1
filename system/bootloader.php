<?php
	
	/*
		CHECK FOR INDEX INCLUSION
	*/
	if(!defined("SECURITY_INDEX")) die();

    /*
     *  START SESSION
     */
    session_start();
    session_regenerate_id();

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
		$app = new Core;
	}
	else
		if(APPLICATION_DEBUG == true)
			die("<b>System Core not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);
        else die();


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
                            else die();

                   }
                   else
                       if(APPLICATION_DEBUG == true)
                           die("<b>DATABASE CORE not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);
                       else die();

               break;


               // CHECK FOR MODULE
               default:
                    if(file_exists(SYSTEM_FOLDER."modules/".$mod."/controller_".$mod.".php")){
                        include(SYSTEM_FOLDER."modules/".$mod."/controller_".$mod.".php");
                    }
                    else
                        if(APPLICATION_DEBUG == true)
                            die("<b>MODULE ".$mod." not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);
                        else die();
               break;
           }
        }
    }
    else
        if(APPLICATION_DEBUG == true)
            die("<b>APP MODULES not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);
        else die();



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
        else die();


    // includem template engine-ul
    if(file_exists(SYSTEM_FOLDER."class_template.php")){
        include(SYSTEM_FOLDER."class_template.php");
        $view = new RainTPL();
        raintpl::configure("base_url", BASE_URL );
        raintpl::configure("cache_dir", APP_FOLDER."cache/tmp/" );
        raintpl::configure("tpl_dir", APP_FOLDER."views/" );
        raintpl::configure("php_enabled", true );
        raintpl::configure("path_replace", false );
    }
    else
        if(APPLICATION_DEBUG == true)
            die("<b>TEMPLATE CLASS not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);
        else die();


    // includem clasa cu functiile generale
    if(file_exists(SYSTEM_FOLDER."class_functions.php")) {
        include SYSTEM_FOLDER . "class_functions.php";
    }


	/*
		INCLUDE ROUTES
	*/
	if(file_exists(APP_FOLDER."routes.php")){
		include(APP_FOLDER."routes.php");
	} else {
        if(APPLICATION_DEBUG == true)
            die("<b>APP ROUTES not found!</b> &nbsp; <b>FILE:</b> <i>".__FILE__."</i> &nbsp; <b>LINE:</b> ".__LINE__);
        else die();
    }


    /*
     *  CHECK IF ROUTED OR SHOW 404 ERROR
     */
    if($url->check_routed() == false){
        if(empty($url->on_404))
            $app->response(404);
        else
            $app->response(404, $url->on_404);
        die();
    }


    /*
     *  DEBUG MODE
     */
    if(APPLICATION_DEBUG == true && count($app->internal_errors) != 0){ echo($app->show_errors("style")); }