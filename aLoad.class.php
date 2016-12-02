<?php

	namespace eMM;

	class aLoad {
		
		private $class_dir;
		
		public function __construct($dir = null) {
			if (!is_null($dir)) {
				if (@scandir($dir) === true) {
					$this->class_dir = $dir."/";
				} else {
					die(__CLASS__.": Directory name <u>".str_replace("/", "", $dir)."</u> not found.");
				}
			}
			spl_autoload_register(array($this, "load_class"));
		}
		
		public function classDir($dir) {
			$this->class_dir = $dir;
		}
		
		public static function register($dir = null) {
			new aLoad($dir);
		}

		private function load_class($class_name) {
			$file = $this->class_dir.strtolower(str_replace("\\", "/", $class_name)).".class.php";
			if(file_exists($file)) {
				require_once($file);
			}
		}
	}
	
		
	$aload = new \eMM\aLoad();
	$aload->classDir("classes/");
	\eMM\aLoad::register();

?>