<?php


	class loader {
		
		/*
		 * app side types:
		 * - front_emd
		 * - admin
		 * - request
		 */
		public $app_side = 'front_end';
	 
		public function __construct($side = 'front_end'){
				$this->app_side = $side;
		}
	 
		public function helper($helper_name) {
			
			if($this->app_side == 'front_end')
					$helper_path = 'system/helpers/helper_'.$helper_name . ".php";
			elseif($this->app_side == 'admin')
					$helper_path = '../system/helpers/helper_'.$helper_name . ".php";
			elseif($this->app_side == 'request')
					$helper_path = '../../system/helpers/helper_'.$helper_name . ".php";
			else
					die("Invalid AppSide ! ".__FILE__." from ".__DIR__." <b>line: ".__LINE__."</b>.");
			
			if (file_exists($helper_path)) {
				include_once($helper_path);
			} 
	 
			return new $helper_name();
	 
		}
	 

	}

?>