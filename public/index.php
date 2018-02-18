<?php

	// Load user session
	session_start();

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

		<div class="container-fluid">
			<div class="row">

				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<?php
							// If user is logged
							if (isset($_SESSION["login"])) {
								// Gets the username
								$user = $_SESSION["user"];
								echo "<a class='navbar-brand' href='index.php?page=home'>Home</a>"; // Show the username
							} else {
								echo "<a class='navbar-brand' href='index.php'>Home</a>"; // Show the username
							}
							?>
						</div>
						<ul class="nav navbar-nav navbar-right">
							<?php
							// If user is logged
							if (isset($_SESSION["login"])) {
								$guid = $_SESSION["guid"];
								?>

								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
										@<?= $user; ?><span class="caret"></span>
									</a>
									<ul class="dropdown-menu" role="menu">
										<li>
											<a href="index.php?page=profile&guid=<?= $guid; ?>"><span class="glyphicon glyphicon-user"></span> Profile</a>
										</li>
										<li>
											<a href="../src/modules/exit.php"><span class="glyphicon glyphicon-log-out"></span> Quit</a>
										</li>
									</ul>
								</li>

								<?php
							}
							?>

						</ul>
					</div>
				</nav>

				<?php
				// Whenever there is an error, a message is displayed
				if (isset($_SESSION["message"]) && !empty($_SESSION["message"])) {
					$message = $_SESSION["message"];

					echo "<div class='alert alert-danger alert-dismissable fade in' role='alert'>";
					echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
					echo "<div class='text-center'>$message</div>";
					echo "</div>";

					unset($_SESSION["message"]);
				}

				// This file loads the pages into the modules folder
				// If page is contains into the URL, it is loaded
				if (isset($_GET["page"])) {
					// The logical location is save into @var '$page'
					$page = "../src/modules/" . $_GET["page"] . ".php";

					// If page exist it is included. Else, the message 404 is displayed
					if (file_exists($page)) {
						include_once $page;
					} else {
						include_once '../src/modules/404.php';
					}
				} else {
					if (isset($_SESSION["login"])) {
						include_once '../src/modules/home.php';
					} else {
						include_once '../src/modules/welcome.php';
					}
				}
				?>

			</div>
		</div>

		<div class="footer-copyright">
			<div class="container">
				<p class="text-muted credit text-center">&copy; <?= date('Y') ?> <a href="https://github.com/ManuelGil/Simple-Social-Network" title="">Fav Quote</a> / <a href="index.php?page=terms">Terms of Service</a></p>
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
