<?php

	/*
		eMM v1.2
		(c) 2016 Michel Thiel
		thielicious.github.io
		
		eMM ('eM' abbr. for eMail Manager) is a compact contact form builder including all 
		its adjustments for personal desires. This API simplifies the flexible use of several 
		input fields which will be used to send and transport data through a classical mailing 
		process. Useful for setting up customer email services and newsletters.
		
		Visit thielicious.github.io for a detailed documentation
		
		
		
		API scheme:
			eMM.class.php
			preset.class.php
			request.class.php
			news.class.php
			utilities.inc.php
			aLoad.class.php
				
		_____________________________________________________________________________________________________
	*/
	
	
	require_once "utilities.inc.php";
	

	class eMM implements iBase {
		
		use Debugger, Fields;
		
		protected	
			$recipient 	= null, $m_header 	= "From: Incoming Customer Enquiry",
			$message 	= null, $send 		= null,			
			$success_msg = "Thank you!<br> Your enquiry has been sent.<br>",
			$fail_msg = "All fields are required to be sent.<br>",
			$status 	= array(
				"sent" 	  => null,
				"fail"    => null,
				"mysql"	  => null
			),
			$method	 	  = array(
				"post" 	=> null,
				"json" 	=> null
			);
			
		public function __construct($method = null) {
			if (!is_null($method)) {
				$this->setMethod($method);
			} 
		}
		
		protected function inputFields() {
			$get = array();
			
			if (isset($_POST["send"])) {
				if ($this->method["json"] == 1) {
					foreach (json_decode($_POST["send"]) as $key => $val) {
						if ($val != null) {
							$get[] = $key;
						}
					}
					return $get;
				}
				if ($this->method["post"] == 1) {
					foreach ($_POST as $key => $val) {
						if ($key != "send") {
							if ($val != null) {
								$get[] = $key;
							}
						}
					}
					return $get;
				}
			}
		}
		
		protected function setMethod($method) {
			if (is_null($this->method["json"]) || is_null($this->method["post"])) {
				if ($method == "post" || "json") {
					$this->method[$method] = 1;
					$this->decode();
				} else {
					$this->msg(0, __METHOD__.": Unknown method.");
				}
			} else {
				$this->msg(0, __METHOD__.": Method already set.");
			}
		}
		
		protected function decode() {
			if ($this->method["json"] == 1) {	
				$this->send = json_decode($_POST["send"]);
				$this->assignData("json", "Receiving Json Key Data...");
			} elseif($this->method["post"] == 1) {
				$this->send = json_decode(json_encode($_POST));
				$this->assignData("post", "Receiving POST Key Data...");
			}
		}
	}

?>