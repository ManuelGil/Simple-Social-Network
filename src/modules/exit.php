<?php

	// Destroy the user session
	session_start();
	session_destroy();
	header("location: ../../public/");

?>
