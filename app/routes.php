<?php

    /*
        CHECK FOR INDEX INCLUSION
    */
    if(!defined("SECURITY_INDEX")) die();

    /*
    $url->get("profil/{id}[alnum]/", function(){
        print_r(func_get_args());
    });
    */
    /*$url->get("profil/{id}[alnum]/", "home@show_home");*/
    $url->get("/", "home@show_home");