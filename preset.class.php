<?php
	
	abstract class Preset extends eMM implements iPreset {
		
		public function eMailHeader($header) { 
			$this->m_header = $header."\r\n";
		}
		
		protected function assignData($method, $debugMsg) {
			if (isset($_POST["send"])) {
				if ($this->method[$method]) {
					foreach ($this->inputFields() as $field => $name) {
						foreach (array_keys($this->fields) as $same) {
							if ($name == $same) {
								$this->fields[$name] = $this->send->$name;
							}
						}
					}	
					
					if ($this->debug == "on") {
						$this->msg(3, $debugMsg);
						foreach ($this->inputFields() as $field) {
							echo $field."<br>";
						}
					}
					$this->message = $this->assign();
				} else {
					$this->msg(0, __METHOD__.": No method is set.");
				}
			} else {
				$this->msg(0, __METHOD__.": No data received.");
			}
		}
		
		public function send() { 
			$errMsg = function($prop) {
				$this->msg(0, __METHOD__.": ".$prop." currently not set.");
				echo "Error - Could not send Email: '".$prop."' is not defined.<br>";
			};
			
			if (isset($_POST["send"])) {		
				if ($this->debug == "on") {
					$this->msg(3, "Total Input Fields:");
					echo "<pre>";
					print_r($this->fields);
					echo "</pre>";
				}
				
				if (count($this->inputFields()) != 0) {
					if (!is_null($this->fields["subject"]) && !is_null($this->message)) {
						if (!is_null($this->recipient) || !is_null($this->customers)) {
							$this->setMail();
						} elseif (is_null($this->recipient)) {
							$errMsg("Recipient");
						} elseif (is_null($this->customers)) {
							$errMsg("Users");
						} 
					} elseif (is_null($this->fields["subject"])) {
						$errMsg("Subject");
					} elseif (is_null($this->message)) {
						$errMsg("Message");
					}
				} 
			} else {
				$this->msg(0, __METHOD__.": No data received.");
			}
		}
		
		abstract protected function assign();
		
		abstract protected function setMail();
	}
?>