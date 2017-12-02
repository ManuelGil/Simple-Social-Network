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
		<link href="css/bootstrap.min.css" rel="stylesheet">
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
        $message = str_replace ( "'", "",$_GET["error"]);

        // Vue.js display a message inside the message object
        echo "<div id='message' class='text-center'>{{ message }}</div><br/>";
        // Call the javascript function in the function file
        showMessage($message);
      }

  	?>

    <div id="footer">
      <div class="container">
				<p class="text-muted credit text-center">&copy; 2017 <a href="https://github.com/ManuelGil/Simple-Social-Network" title="">Fav Quote</a> / <a href="index.php?page=terms.html">Terms of Service</a></p>
			</div>
    </div>

    <!-- import jquery -->
    <script src="js/jquery.min.js"></script>
    <!-- import bootstrap javascript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- import validator -->
    <script src="js/validator.min.js"></script>
  </body>
</html>
