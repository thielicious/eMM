<?php 

	class News extends Preset implements iNews {
		
		protected
			$customers = array();
		
		private 		
			$signature = null,
			$server,	$user,		
			$pass,		$db;
		
		
		public function __construct() {
			eMM::setMethod("post");
		}

		protected function assign() {
			$mess = null;
			$n = $this->debug == "on" ? "\n<br>" : "\n";
			
			foreach ($this->inputFields() as $field) {
				$mask = function($label = null) use ($mess, $n, $field) {
					return $n.($label ? $label : ucfirst($field)).": ".$this->fields[$field];
				};
				
				if (!is_null(($this->fields[$field]))) {
					switch ($field) {
						case "subject": break;
						case "content": $mess .= $n.$n.$this->send->content.$n.$this->signature; break;	
						default: $this->msg(0, __METHOD__.": Unknown input field: {$field}".$n); break;
					}
				}
			}
			return $mess;
		}
		
		public function eMailDB($servername, $username, $password, $database) {
			$this->server = $servername;
			$this->user = $username;
			$this->pass = $password;
			$this->db = $database;
			
			if (!is_null($servername || $username || $password || $database)) {
				$this->status["mysql"] = 1;
				if ($this->status["mysql"] == 1) {
					try {
						$con = new PDO("mysql:host={$this->server}; dbname={$this->db}", $this->user, $this->pass);
						$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$sql = $con->prepare("SELECT * from emails");
						$sql->execute();
						$sql->setFetchMode(PDO::FETCH_OBJ);
						
						foreach ($sql as $data) {
							$this->customers[$data->user] = $data->email;
						}
						if ($this->debug == "on") {
							$this->msg(3, "Registered Users:");
							foreach ($this->customers as $user => $email) {
								echo "&nbsp;&nbsp;".$user;
								echo "&nbsp;&nbsp;".$email."<br>";
							}
						}
					} catch (PDOException $e) {
						echo "SQL Error: ".$e->getMessage();
					}
				} else {
					$this->msg(0, __METHOD__.": MySQL connection has not been set yet.");
				}
			} else {
				$this->msg(0, __METHOD__.": All parameters needed.");
			}
		}
		
		public function signature($sig) {
			$this->signature = $sig;
		}
		
		protected function setMail() {
			if ($this->debug == "on") {
				$rep = str_repeat("&nbsp;",4);
				$this->msg(3, "eMail Test Output:");
				
				foreach ($this->customers as $user => $email) {
					echo "<br>".$rep."Recipient : ".$email."<br>"
						.$rep."Mail Header : ".$this->m_header."<br>"
						.$rep."Subject : <strong>".$this->fields["subject"]."</strong><br>"
						.$rep."Content : <br>Hello dear ".$user.", ".$this->message."<br>";		
				}						
			} else {
				$send = function() {
					foreach ($this->customers as $user => $email) {
						mail(
							$email,
							$this->fields["subject"],
							"Hello dear ".$user.", ".$this->message,
							$this->m_header
						);
					}
					return true;
				};
				
				if ($send() == true) {
					$this->status["sent"] = 1;
					echo "Thank you!<br> Your enquiry has been sent.<br>";
				} else {
					$this->status["fail"] = 1;
					echo "All fields are required to be sent.<br>";	
				} 
			}
		}
	}
	
?>