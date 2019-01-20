<?php

	// Load user session
	session_start();

	// Load application files
	require_once "../autoload.php";

	if (isset($_POST["quote"])) {
		// Gets post
		$quote = trim($_POST["quote"]);
		// Gets the user id
		$id = (int) $_SESSION["id"];
		// Date of created
		$date = date('Y-m-d');
		// Time of created
		$time = date('H:i:s');

		// Gets the database connection
		$conn = getConnection();

		try {
			// Adds the publication in the database
			$sql = "INSERT INTO	QUOTES (QUOTE, POST_DATE, POST_TIME, ID_USER)
					VALUES		(:quote, :postdate, :posttime, :id);";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":quote", $quote);
			$stmt->bindParam(":postdate", $date);
			$stmt->bindParam(":posttime", $time);
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			// Redirect to homepage
			header('location: ../../public/home');
		} catch (PDOException $e) {
			$_SESSION["message"] = "<strong>DataBase Error</strong>: No results were obtained.<br>" . $e->getMessage();

			// Redirect to homepage
			header('location: ../../public/home');
		} catch (Exception $e) {
			$_SESSION["message"] = "<strong>General Error</strong>: No results were obtained.<br>" . $e->getMessage();

			// Redirect to homepage
			header('location: ../../public/home');
		} finally {
			// Destroy the database connection
			$conn = null;
		}
	}

?>
