<?php

	class Core{
	
		var $internal_errors = array();

		
		private function log_internal_errors($function, $file, $line, $message = ''){
			$this->internal_errors[] = array(	"err_function" => $function,
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
						$content = '<table style="width:100%;"><thead><tr><th>ERROR ID</th><th>FILE</th><th>LINE</th><th>FUNCTION</th><th>MESSAGE</th></tr></thead><tbody>';
						foreach($this->internal_errors as $id => $info){
							$content .= "<tr><td>".$id."</td><td>".$info['err_file']."</td><td>".$info['err_line']."</td><td>".$info['err_function']."</td><td>".$info['err_message']."</td></tr>";
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
		
		
		private function stylization_message($text, $background = 'red'){
			return '<div style="width:100%;"><div style="width:90%;background-color:'.$background.';color:white;padding:10px;text-align:center;margin:20px auto 20px auto;">'.$text.'</div></div>';
		}
	}