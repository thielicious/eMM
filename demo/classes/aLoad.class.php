<?php
	
	/*
		aLoad 
		(c) 2016 by THIELICIOUS
		thielicious.github.com
		----------------------

		USAGE:
			aload::register([modules], path);

		EXAMPLE:
			aload::register(["class", "inc"], "scripts/");
		
		This example above will register all PHP files containing class and inc in the folder scripts.
		Use "all" as the first parameter to register all PHP scripts in the specified folder.
	*/


	class aLoad {
		
		private 
			$dir, $mod;

		const 
			ERR = "[!]Error ".__CLASS__.": ",
			ALL = "all";
		
		function __construct($mod, string $dir = null) {
			if (is_array($mod)) {
				foreach ($mod as $each) {
					$this->mod[] = $each;
				}
			} else if ($mod == "all") {
				$this->mod = self::ALL;
			}
			if (!is_null($dir)) {
				if (@scandir($dir)) {
					$this->dir($dir);
				} else {
					die(self::ERR."Directory name <u>".str_replace("/", "", $dir)."</u> not found.");
				}
			}
			spl_autoload_register(array($this, "load_class"));
		}
		
		private function dir(string $dir) {
			$this->dir = $dir;
		}
		
		public static function register($modules, string $dir) {
			new aLoad($modules, $dir);
		}

		private function load_class(string $class_name) {
			$scripts = function($module = null) use ($class_name) {
				$mod = $module ? ".".$module : null;
				$file = $this->dir.strtolower(str_replace("\\", "/", $class_name)).$mod.".php";
				return file_exists($file) ? require_once($file) : null;
			};
			if ($this->mod != null) {
				if (is_array($this->mod)) {
					foreach ($this->mod as $mod) {
						$scripts($mod);
					} 
				} else if ($this->mod == self::ALL) {
					$scripts();
				} else {
					die(self::ERR."Unknown parameter for module.");
				}
			} else {
				die(self::ERR."No module exists, please set a module first.");
			}
		}
	}

?>