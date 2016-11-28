<?php

	class aLoad {
		
		private $class_dir = "classes/";
		
		public function __construct($dir = NULL) {
			if (!is_null($dir)) {
				if (@scandir($dir) === TRUE) {
					$this->class_dir = $dir."/";
				} else {
					die(__CLASS__.": Directory name <u>".str_replace("/", "", $dir)."</u> not found.");
				}
			}
			
			spl_autoload_register(array($this, "load_class"));
		}

		public static function register($dir = NULL) {
			new aLoad($dir);
		}

		private function load_class($class_name) {
			$file = $this->class_dir.strtolower(str_replace("\\", "/", $class_name)).".class.php";
			
			if(file_exists($file)) {
				require_once($file);
			}
		}
	}

	aLoad::register();

?>