<!DOCTPYPE html>
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
		<h1>EMAIL MANAGER - NEWSLETTER Demo<br>-------------------------</h1>
		<h4 style='font-size: 75%'>eMM v0.9<br>&copy; 2016 Michel Thiel</h4>
		<button id="json" onClick="window.location.href='json_demo.php'">JSON</button>
		<button id="post" onClick="window.location.href='post_demo.php'">POST</button>
		<button id="news" onClick="window.location.href='newsletter_demo.php'">NEWS</button><br><br>
		<form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
			<input type="text" id="subject" name="subject" value="THIELICIOUS - Notification" placeholder="Subject" required /><br>
			<textarea id="content" name="content" placeholder="Message" required>we have new offers to show you. Come and check out our <a href="#">website</a>!
			</textarea><br>
			<input type="submit" name="send" value="Send"/><br>
			<span class="resp">
				<?php

					require_once "classes/aLoad.class.php";
					aload::register(["class", "inc"], "classes/");

					if (isset($_POST["send"])) {
						$news = new News();
						$news->debugMode("on");
						$news->signature(
							"------signature------
							<br>Michel Thiel<br>
							www.thielicious.com<br>
							---------------------"
						);
						$news->emailHeader("From: THIELICIOUS - Notification");
						$news->emailDB("localhost", "root", "", "emails");
						$news->send();
					}

				?>
			</span>
		</form>
		<script>
			$('#news').css({
				'background':'#0ff',
				'color':'#000'
			});
		</script>
	</body>
</html>