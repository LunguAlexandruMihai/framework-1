<?php
/**
 * Created by Flyonweb
 * User: Double_Web
 * Date: 11/21/2014
 * Time: 11:10
 */

class Url extends Core{

    // current request uri
    public $request = '';

    // current base url
    public $base_url = '';

    // full url
    public $current_url = '';




    // cand se initializeaza clasa, preluam ce se ceere
    function __construct(){
        $this->base_url = $this->get_base_url();
        $this->request = $this->get_url();
        $this->current_url = $this->base_url.$this->request;
    }

    /*
     *  Get current request string
     */
    private function get_url(){
        return substr("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", strlen($this->base_url));
    }


    /*
     *  Get BASE URL
     */
    private function get_base_url(){
        /* First we need to get the protocol the website is using */
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https://' : 'http://';

        /* returns /myproject/index.php */
        $path = $_SERVER['PHP_SELF'];

        /*
         * returns an array with:
         * Array (
         *  [dirname] => /myproject/
         *  [basename] => index.php
         *  [extension] => php
         *  [filename] => index
         * )
         */
        $path_parts = pathinfo($path);
        $directory = $path_parts['dirname'];
        /*
         * If we are visiting a page off the base URL, the dirname would just be a "/",
         * If it is, we would want to remove this
         */
        $directory = ($directory == "/") ? "" : $directory;

        /* Returns localhost OR mysite.com */
        $host = $_SERVER['HTTP_HOST'];

        /*
         * Returns:
         * http://localhost/mysite
         * OR
         * https://mysite.com
         */
        return $protocol . $host . $directory . "/";
    }


    /*
     * Functia pentru Rutare
     *
     *
     */
    public function get($patern, $new)
    {
        if($patern == '/'){ $patern = ''; }
        $patern = explode("/", $patern);
        $request = explode("/", $this->request);

        if (count($patern) == count($request)) {

            $nums = count($patern);

            $check = true;

            $data = array();

            for ($i = 0; $i < $nums; $i++) {

                if ($patern[$i] != $request[$i]) {

                    // EXTRACT LABEL NAME
                    $startpos = strpos($patern[$i], "{") + strlen("{");
                    if ($startpos !== false) {
                        $endpos = strpos($patern[$i], "}", $startpos);
                        if ($endpos !== false) {
                            $label_name = substr($patern[$i], $startpos, $endpos - $startpos);
                        } else {
                            $check = false;
                            break;
                        }
                    } else {
                        $check = false;
                        break;
                    }

                    // EXTRACT LABEL ATTRIBUTES
                    $startpos = strpos($patern[$i], "[") + strlen("]");
                    if ($startpos !== false) {
                        $endpos = strpos($patern[$i], "]", $startpos);
                        if ($endpos !== false) {
                            $attribute = substr($patern[$i], $startpos, $endpos - $startpos);
                        } else {
                            $check = false;
                            break;
                        }
                    } else {
                        $check = false;
                        break;
                    }

                    $pass = false;

                    switch ($attribute) {
                        // NUMERIC (42, 1337, 0x539, 02471, 0b10100111001, 1337e0 9.1)
                        case "num":
                            if (is_numeric($request[$i])) {
                                $pass = true;
                                break;
                            }
                            break;

                        // DIGITS (Checks if all of the characters in the provided string, text, are numerical)
                        case "digits";
                            if (ctype_digit($request[$i])) {
                                $pass = true;
                                break;
                            }
                            break;

                        // LOWERCASE (Check for lowercase character(s))
                        case "lower":
                            if (ctype_lower($request[$i])) {
                                $pass = true;
                                break;
                            }
                            break;

                        // UPPERCASE (Check for uppercase character(s))
                        case "upper":
                            if (ctype_upper($request[$i])) {
                                $pass = true;
                                break;
                            }
                            break;

                        // ALPHA (Check for alphabetic character(s))
                        case "alpha":
                            if (ctype_alpha($request[$i])) {
                                $pass = true;
                                break;
                            }
                            break;

                        // ALPHANUMERIC (Checks if all of the characters in the provided string, text, are alphanumeric)
                        case "alnum":
                            if (ctype_alnum($request[$i])) {
                                $pass = true;
                                break;
                            }
                            break;
                    }


                    if (!$pass) {
                        $check = false;
                        break;
                    }

                    $data[$label_name] = $request[$i];


                }

            }


            // NOT MATCHING
            if ($check == false) { return false; }



            // VEDEM CUM VREA USERUL SA FACEM REDIRECTAREA

            // APELAM FUNCRIA DACA EXISTA
            if(is_callable($new)){

                echo call_user_func_array($new, $data);
                return true;


            } else {

                $x = explode("@", $new);
                if(count($x) == 2) {
                    // INCERCAM SA APELAM O PROCEDURA DIN CONTROLLER
                    if (file_exists(APP_FOLDER."controllers/controller_".$x[0].".php")){
                        include(APP_FOLDER."controllers/controller_".$x[0].".php");
                        $obj = new $x[0]();

                        // include model
                        if(file_exists(APP_FOLDER."models/model_".$x[0].".php"))
                            include(APP_FOLDER."models/model_".$x[0].".php");

                        // run controller
                        echo call_user_func(array($obj, $x[1]));
                    }


                } else {
                    return false;
                }
            }




            /*
            // PUT DATA TO GET
            foreach ($data as $key => $val) {
                $_GET[$key] = $val;
            }

            print_r($_GET);
            */
        } else {
            // NOT MATCHING
            return false;
        }

    }
}