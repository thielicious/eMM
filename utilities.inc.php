<?php
 
	interface iBase {
		
		public function debugMode($switch);
		public function setMethod($method);
	}
	
	
	
	interface iPreset {
		
		public function recipient($recipient);
		public function eMailHeader($header);
		public function send();
	}
		
		
		
	interface iRequest {
		
		public function getName();
	}
	
	
	
	interface iNews {
		
		public function eMailDB($servername, $username, $password, $database);
		public function signature($sig);
	}
	
	
	
	trait debugger {
		
		protected $debug = "off";
		
		public function debugMode($switch) {	
			switch ($switch) {
				case "on" : 
					$this->debug = $switch;
					$this->msg(2, "debugMode is on."); break;
				case "off": $this->debug = $switch; break;
				default   : echo "<span style=\"color:red\">[ERROR] </span>: Unknown parameter > ".$switch;
			}
		}
		
		protected function msg($const, $msg) {
			if ($this->debug == "on") {
				$mask = function($kind, $col) use ($msg) {	
					echo "<span style='color:".$col."'>".$kind."</span>".$msg."<br>";
				};
				
				switch ($const) {
					case 0: $mask("[ERROR] ", "red", $msg); break;
					case 1: $mask("[SUCCESS] ", "yellow", $msg); break;
					case 2: $mask("[NOTICE] ", "lightblue", $msg); break;
					case 3: $mask("[DEBUG] ", "lightblue", $msg); break;
				}
			} 
		}
	}

?>