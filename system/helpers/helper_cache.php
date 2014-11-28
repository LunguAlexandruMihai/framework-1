<?php


    class HelperCache extends core{

        private $path = '';
        private $prefix = 'helper_';
        private $subfix = '.php';

        function __construct(){
            // set default cache path
            $this->path = CACHE_FOLDER;
        }

        /*
         * daca json este TRUE salvam in format json (daca e array)
         */
        public function add($resource, $data){
            $resource = $this->path.$this->prefix.md5($resource).$this->subfix;

            if(is_array($data)){
                $data = '<?php return '.json_encode($data).';';
            } else {
                $data = '<?php return "'.$data.'";';
            }

            if(file_put_contents($resource, $data)){
                return true;
            } else {
                $this->log_internal_errors(__FUNCTION__, __CLASS__, __FILE__, __LINE__, 'Error file_put_contents. Path: '.$resource);
                return false;
            }
        }


        /*
         * daca json este TRUE, daca avem array returnam cu json
         */
        public function get($resource, $json=true){
            $resource = $this->path.$this->prefix.md5($resource).$this->subfix;
            // get cache resource value
            if(file_exists($resource)){
                $content = include($resource);
                if(is_array($content) AND $json == true){
                    return json_encode($content);
                } else {
                    return $content;
                }
            }
        }


        /*
         * modify helper settings
         */
        public function config($setting, $value){
            // config cache
            switch($setting){
                case "cache_path": $this->path = $value; break;
                case "cache_prefix": $this->prefix = $value; break;
                case "cache_subfix": $this->subfix = $value; break;
            }
            // return true
            return true;
        }

    }


?>