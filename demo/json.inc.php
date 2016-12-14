<?php

	require_once "classes/aLoad.class.php";

	if (isset($_POST["send"])) {
		if ($_POST["send"] != "Send") {
			$request = new Request();
			$request->debugMode("on");
			$request->method("json");
			$request->recipient("michel.thiel@gmx.net");
			$request->emailHeader("From: THIELICIOUS - Customer enquiry from ".$request->getName());
			$request->send();
		}
	}

?>