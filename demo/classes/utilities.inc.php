<?php
 
	interface iBase {
		
		public function __construct();
		public function debugMode($switch);
	}
	
	
	
	interface iPreset {
		
		public function eMailHeader($header);
		public function send();
	}
		
		
		
	interface iRequest {
		
		public function method($method);
		public function recipient($recipient);
		public function getName();
	}
	
	
	
	interface iNews {
		
		public function __construct();
		public function eMailDB($servername, $username, $password, $database);
		public function signature($sig);
	}
	
	
	trait Fields {
		
		protected
			$fields = array(
				"subject" 	=> null, "content" 	  => null, 		// email input
				
				"title" 	=> null, "name" 	  => null,		// names
				"firstname" => null, "middlename" => null, 
				"lastname" 	=> null,
				
				"birth" 	=> null,							// birth
				
				"address" 	=> null, "location"   => null,		// location
				"country" 	=> null, "zip" 		  => null,
				"bic" 		=> null, 
			
				"phone" 	=> null, "mobile" 	  => null, 		// contact
				"fax" 		=> null, "email" 	  => null, 
			
				"company" 	=> null, "website" 	  => null, 		// socials
				"facebook" 	=> null, "twitter" 	  => null	
			);
	}
	
	
	trait Debugger {
		
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