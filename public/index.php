<?php

	// Load application files
	require_once "../src/autoload.php";

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Fav Quote</title>

		<meta name="description" content="Fav Quote">
		<meta name="author" content="Manuell Gil">

		<!-- import bootstrap 3 -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	</head>
	<body>

		<?php
		// This file loads the pages into the modules folder
		// If page is contains into the URL, it is loaded
		if (isset($_GET["page"])) {
			// The logical location is save into @var '$page'
			$page = "../src/modules/" . $_GET["page"];

			// If page exist it is included. Else, the message 404 is displayed
			if (file_exists($page)) {
				include $page;
			} else {
				header('location: ../src/modules/404.html');
			}
		} else {
			include_once "../src/modules/welcome.php";
		}

		// Whenever there is an error, a message is displayed
		if (isset($_GET["error"])) {
			$message = str_replace("'", "", $_GET["error"]);

			// Vue.js display a message inside the message object
			echo "<div id='message' class='text-center'>{{ message }}</div><br/>";
			// Call the javascript function in the function file
			showMessage($message);
		}
		?>

		<div id="footer">
			<div class="container">
				<p class="text-muted credit text-center">&copy; 2018 <a href="https://github.com/ManuelGil/Simple-Social-Network" title="">Fav Quote</a> / <a href="index.php?page=terms.html">Terms of Service</a></p>
			</div>
		</div>

		<!-- import jquery -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"></script>
		<!-- import bootstrap javascript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<!-- import validator -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
	</body>
</html>
