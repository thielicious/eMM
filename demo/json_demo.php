<!DOCTPYPE html>
	<head>
		<meta charset="utf-8">
		<script src="scr/jq.js"></script>
		<script src="scr/eMM.js"></script>
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
		input:focus{background:#000}
		textarea{width:350px;height:100px}
	</style>
	<body>
		<h1>EMAIL MANAGER - Json Demo<br>-------------------------</h1>
		<h4 style='font-size: 75%'>eMM v0.9<br>&copy; 2016 Michel Thiel</h4>
		<button id="json" onClick="window.location.href='json_demo.php'">JSON</button>
		<button id="post" onClick="window.location.href='post_demo.php'">POST</button>
		<button id="news" onClick="window.location.href='newsletter_demo.php'">NEWS</button><br><br>
		<form>
			<input type="text" name="name" value="Michel Thiel" placeholder="Name" required />
			<input type="email name="email" value="michel.thiel@gmx.net" pattern="[^@]*@[^@]*" placeholder="Email" required /><br>
			
			<input type="text" name="zip" pattern="[0-9]*" placeholder="Postal Code/ZIP"/>
			<input type="text" name="address" placeholder="Street name and number"><br>
			<input type="url" name="website" value="http://www.claxdesign.com" placeholder="Website">
			<input type="date" name="birth" placeholder="Birthday"><br>
			<input type="tel" name="phone" placeholder="Telephone">
			<input type="tel" name="mobile" placeholder="Mobile"><br>
			<input type="text" name="bic" placeholder="Bank account (BIC)"><br>
			
			<input type="text" name="subject" value="Test Mail" /><br>
			<textarea name="content" placeholder="Message" required>This is a test message. Lorem ipsum dolor sit amet.</textarea><br>
			<input type="submit" name="send" value="Send"/><br>
			<span class="result"></span>
		</form>
		<script>
			$(function() {
				$('#json').css({
					'background':'#0ff',
					'color':'#000'
				});

				$('form').eMM({
					resp	: '.result', 
					php		: 'json.inc.php'
				});
			});
		</script>
	</body>
</html>