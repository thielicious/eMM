<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<script src="scr/jq.js"></script>
	</head>
	<style>
		*{	font-family:"Courier",non-serif;
			background:#011;
			color:#0ff;
			font-weight:100;
			font-size:95%;}
		input{padding:3px; height:30px;}
		#subject{width:350px;}
		button:hover,input:hover{border-color:#0ff; color:#fff;}
		input:hover{border-color:#0ff; color:#fff;}
		input:focus{background:#000}
		textarea{width:350px;height:100px}
	</style>
	<body>
		<h1>EMAIL MANAGER - POST Demo<br>-------------------------</h1>
		<h4 style='font-size: 75%'>eMM v0.9<br>&copy; 2016 Michel Thiel</h4>
		<button id="json" onClick="window.location.href='json_demo.php'">JSON</button>
		<button id="post" onClick="window.location.href='post_demo.php'">POST</button>
		<button id="news" onClick="window.location.href='newsletter_demo.php'">NEWS</button><br><br>
		<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
			<input type="text" id="name" name="name" value="Michel Thiel" placeholder="Name" required />
			<input type="email" id="email" name="email" value="michel.thiel@gmx.net" pattern="[^@]*@[^@]*" placeholder="Email" required /><br>
			
			<input type="text" id="zip" name="zip" pattern="[0-9]*" placeholder="Postal Code/ZIP"/>
			<input type="text" id="address" name="address" placeholder="Street name and number"><br>
			<input type="url" id="website" name="website" value="http://www.claxdesign.com" placeholder="Website">
			<input type="date" id="birth" name="birth" placeholder="Birthday"><br>
			<input type="tel" id="phone" name="phone" placeholder="Telephone">
			<input type="tel" id="mobile" name="mobile" placeholder="Mobile"><br>
			<input type="text" id="bic" name="bic" placeholder="Bank account (BIC)"><br>
			
			<input type="text" id="subject" name="subject" value="Test Mail" placeholder="Subject" required /><br>
			<textarea id="content" name="content" placeholder="Message" required>This is a test message. Lorem ipsum dolor sit amet.</textarea><br>
			<input type="submit" name="send" value="Send"/><br>
			<span class="resp">
				<?php
					
					require_once "classes/aLoad.class.php";
					aload::register(["class", "inc"], "classes/");
					
					if (isset($_POST["send"])) {
						$request = new Request();
						$request->debugMode("on");
						$request->method("post");
						$request->recipient("michel.thiel@gmx.net");
						$request->emailHeader("From: THIELICIOUS - Customer enquiry from ".$request->getName());
						$request->send();
					}

				?>
			</span>
		</form>
		<script>
			$('#post').css({
				'background':'#0ff',
				'color':'#000'
			});
		</script>
	</body>
</html>
