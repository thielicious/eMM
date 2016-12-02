<?php

	class Request extends Preset implements iRequest {
		
		public function recipient($recipient) { 
			$this->recipient = $recipient;
		}

		public function method($method) {
			$this->setMethod($method);
		}

		protected function assign() {
			$mess = null;
			$n = (($this->debug == "on") ? "\n<br>" : "\n");
			
			foreach ($this->inputFields() as $field) {
				$mask = function($label = null) use ($mess, $n, $field) {
					return $n.($label ? $label : ucfirst($field)).": ".$this->fields[$field];
				};
				
				if (!is_null(($this->fields[$field]))) {
					switch ($field) {
						case "name": $mess .= $mask("From"); break;
						case "email": $mess .= $mask("eMail"); break;
						case "zip": $mess .= $mask("ZIP Code"); break;
						case "bic": $mess .= $mask("BIC"); break;
						case "address": case "website": case "subject": case "title": 
							case "firstname": case "middlename": case "lastname": case "location": 
							case "country": case "phone": case "mobile": case "fax": case "company": 
							case "facebook": case "twitter": case "birth": $mess .= $mask(); break;
						case "content": $mess .= $n.$n.$this->send->content; break;
						default: $this->msg(0, __METHOD__.": Unknown input field: {$field}".$n); break;
					}
				}
			}
			return $mess;
		}
		
		protected function setMail() {
			if ($this->debug == "on") {				
				$rep = str_repeat("&nbsp;",4);
				$this->msg(3, "eMail Test Output:");
				
				echo $rep."Recipient : ".$this->recipient."<br>"
					.$rep."Mail Header : ".$this->m_header."<br>"
					.$rep."Subject : <strong>".$this->fields["subject"]."</strong><br>"
					.$rep."Content : ".$this->message."<br>";								
			} else {
				$send = mail(
					$this->recipient,
					$this->fields["subject"],
					$this->message,
					$this->m_header
				);
				
				if ($send) {
					$this->status["sent"] = 1;
					echo "Thank you!<br> Your enquiry has been sent.<br>";
				} else {
					$this->status["fail"] = 1;
					echo "All fields are required to be sent.<br>";	
				} 
			}
		}
		
		public function getName() {
			$names = null;
			
			foreach ($this->fields as $field => $val) {
				$mask = function() use ($field) {
					$f = $this->fields[$field];
					$ifnull = is_null($f) ? null : $f;
						
					return $ifnull." ";
				};
				
				switch ($field) {
					case "title": case "name": case "firstname":
					case "middlename": case "lastname":
						$names .= $mask(); break;
					default: break;
				}
			}	
			return $names;
		}
	}
	
?>