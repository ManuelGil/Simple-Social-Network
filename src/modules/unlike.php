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
			$sql = "DELETE FROM	LIKES
					WHERE		ID_USER = :user
						AND		ID_QUOTE = :quote;";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":user", $user);
			$stmt->bindParam(":quote", $quote);
			$result = $stmt->execute();

			if ($result) {
				// Decrements the 'likes' in the publication
				$sql = "UPDATE	QUOTES
						SET		LIKES = LIKES - 1
						WHERE	ID_QUOTE = :id;";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(":id", $quote);
				$stmt->execute();

				foreach ($_SESSION["voted"] as $key => $value) {
					if ($value == $quote) {
						// Removes the publication id into the voted publications
						$_SESSION["voted"][$key] = null;
					}
				}
			}

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
