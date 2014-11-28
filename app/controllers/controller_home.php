<?php
/**
 * Created by Flyonweb
 * User: Double_Web
 * Date: 11/22/2014
 * Time: 01:52
 */

    class home extends Core{


        public function show_home(){

            //$cache = $this->helper("cache");

            //$cache->add("var1", "test");

            //echo $cache->get("var2");
            VIEW::DRAW("index");

        }

    }