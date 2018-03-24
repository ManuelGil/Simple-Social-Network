<?php

	// Load user session
	session_start();

	// Load application files
	require_once "../autoload.php";

	if (isset($_GET['id'])) {
		// Gets the publication id
		$quote = (int) $_GET['id'];
		$user = (int) $_SESSION["id"];

		// Gets the database connection
		$conn = getConnection();

		try {
			$stmt = $conn->prepare("INSERT INTO LIKES (ID_USER, ID_QUOTE) VALUES (:user, :quote)");
			$stmt->bindParam(":user", $user);
			$stmt->bindParam(":quote", $quote);
			$result = $stmt->execute();

			if ($result) {
				// Increments the 'likes' in the publication
				$stmt = $conn->prepare("UPDATE QUOTES SET LIKES = LIKES + 1 WHERE ID_QUOTE = :id");
				$stmt->bindParam(":id", $quote);
				$stmt->execute();

				// Adds the publication id into the voted publications
				$_SESSION["voted"][] = $quote;
			}

			// Redirect to homepage
			header('location: ../../public/index.php?page=home');
		} catch (PDOException $e) {
			$_SESSION["message"] = "<strong>DataBase Error</strong>: No results were obtained.<br>" . $e->getMessage();

			// Redirect to homepage
			header('location: ../../public/index.php?page=home');
		} catch (Exception $e) {
			$_SESSION["message"] = "<strong>General Error</strong>: No results were obtained.<br>" . $e->getMessage();

			// Redirect to homepage
			header('location: ../../public/index.php?page=home');
		} finally {
			// Destroy the database connection
			$conn = null;
		}
	}

?>
