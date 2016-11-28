<?php

	/*
		eMM v0.9
		(c) 2016 Michel Thiel
		thielicious.github.io
		
		eMM ('eM' abbr. for eMail Manager) is a compact contact form builder including all 
		its adjustments for personal desires. This API simplifies the flexible use of several 
		input fields which will be used to send and transport data through a classical mailing 
		process. Useful for setting up customer email services and newsletters.
		
		Visit thielicious.github.io for a detailed documentation
		
		
		
		API scheme:
			eMM.class.php
			mask.class.php
			request.class.php
			news.class.php
			utilities.inc.php
			
		Methods:		
			trait debugger eMM::debugMode(switch)	:	de/enables debugging modus
			trait debugger eMM::msg(const, msg)		: 	debug messages 
			
			eMM::__construct([method])	:	starts an instance defining whether JSON or post method is set
			eMM::inputFields()			:	fetches input fields
			eMM::setMethod(method)		:	will set the method manually, if no parameter in the constructor is set yet
			eMM::decode()				:	fetches form data using POST/AJAX method
			eMM::send()					:	executes the email sending process
			
			Mask::recipient(recipient)			: 	email address of the recipient
			Mask::eMailHeader(header)			: 	email header content
			Mask::assignData(method, debugMsg)	: 	assigns input values
			Mask::send()						: 	executes the email sending process
			
			Request::assign()	: 	individual settings for eMM::assignData()
			Request::customers():	individual settings fr customers and recipients
			Request::getName()	: 	displays name of the sender, if available
			
			News::assign()		: 	individual settings for eMM::assignData()	
			News::customers()	:	individual settings for customers and recipients
			News::eMailDB()		:	database handler for fetching email data
			News::signature()	:	includes signature to the mail content
				
		_____________________________________________________________________________________________________
	*/
	
	
	require_once "utilities.inc.php";
	

	class eMM implements iBase {
		
		use debugger;
		
		protected	
			$recipient 	= null, $m_header 	= "From: Incoming Customer Enquiry",
			$message 	= null, $send 		= null,			
			$status 	= array(
				"sent" 	  => null,
				"fail"    => null,
				"mysql"	  => null
			),
			$method	 	  = array(
				"post" 	=> null,
				"json" 	=> null
			),
			$fields = array(
				"subject" 	=> null, "content" 	  => null, 		// email input
				
				"title" 	=> null, "name" 	  => null,		// names
				"firstname" => null, "middlename" => null, 
				"lastname" 	=> null,
				
				"address" 	=> null, "location"   => null,		// location
				"country" 	=> null, "zip" 		  => null,
			
				"tel" 		=> null, "mobile" 	  => null, 		// contact
				"fax" 		=> null, "email" 	  => null, 
			
				"company" 	=> null, "website" 	  => null, 		// socials
				"facebook" 	=> null, "twitter" 	  => null	
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
						$get[] = $key;
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
		
		public function setMethod($method) {
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