<?php

	class Core{
	
		var $internal_errors = array();


        // load a helper
        public function helper($helper_name){
            // CHECK IF EXISTS
            if (file_exists(SYSTEM_FOLDER."helpers/helper_".$helper_name.".php")) {
                include(SYSTEM_FOLDER."helpers/helper_".$helper_name.".php");
                $helper_name = 'Helper'.ucfirst($helper_name);
                return new $helper_name();
            } else {
                $this->log_internal_errors(__FUNCTION__, __CLASS__, __FILE__, __LINE__, 'There is no helper <b>'.$helper_name."</b> in ".SYSTEM_FOLDER."helpers/helper_".$helper_name.".php");
                return false;
            }
        }


        // check php module exists
        public function php_module_exists($module_name){

        }

        protected function log_internal_errors($function, $class, $file, $line, $message = ''){
			$this->internal_errors[] = array(	"err_function" => $function,
                                                "err_class" => $class,
												"err_file" => $file,
												"err_line" => $line,
												"err_message" => $message
											);
		}
		
		
		/*
			METHODS:
				default - return array error
				style - return a HTML table stylized with errors
				
			STOP
				- true: show errors on screen and stop
				- false: return errors
		*/
		public function show_errors($method = "default", $stop = false){
			if(!empty($this->internal_errors)){
				switch($method){
					
					case "default":
						if($stop == false)
							return $this->internal_errors;
						else
							echo "<pre>".print_r($this->internal_errors, true)."</pre>";
					break;
					
					
					case "style":
						$content = '<table style="width:100%;background-color: indianred;color:white;border:5px palevioletred solid;"><thead><tr><th>ERROR ID</th><th>FILE</th><th>LINE</th><th>FUNCTION</th><th>MESSAGE</th></tr></thead><tbody>';
						foreach($this->internal_errors as $id => $info){
							$content .= "<tr><td><center>".$id."</center></td><td><center>".$info['err_file']."</center></td><td><center>".$info['err_line']."</center></td><td><center>".$info['err_function']."</center></td><td><center>".$info['err_message']."</center></td></tr>";
						}
						$content .= '</tbody></table>';
						
						if($stop == false)
							return $content;
						else
							echo $content;
					break;
					
					default:
						die($this->stylization_message("This method doesn't exist!<br/><b>LINE:</b> ".__LINE__."<br/><b>FILE:</b> ".__FILE__));
					break;
				}
			} else {
                switch($method) {
                    case "default":
                        return array();
                        break;
                    case "style":
                        return $this->stylization_message("There are no errors !", "green");
                        break;
                }
			}
		}


        /*
         *  SHOW LAST ERROR (only message)
         */
        public function show_error(){
            if(!empty($this->internal_errors)){
                return $this->internal_errors[count($this->internal_errors)-1]['err_message'];
            } else return false;
        }
		
		private function stylization_message($text, $background = 'red'){
			return '<div style="width:100%;"><div style="width:90%;background-color:'.$background.';color:white;padding:10px;text-align:center;margin:20px auto 20px auto;">'.$text.'</div></div>';
		}
	}