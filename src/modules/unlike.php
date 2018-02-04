<?php

	// Load user session
	session_start();

	// Load application files
	require_once "../autoload.php";

	if (isset($_GET['id'])) {
		// Gets the publication id
		$id = (int) $_GET['id'];

		// Gets the database connection
		$conn = getConnection();

		try {
			// Decrements the 'likes' in the publication
			$stmt = $conn->prepare("UPDATE QUOTES SET LIKES=LIKES-1 WHERE ID_QUOTE=:id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			foreach (array_keys($_SESSION["voted"], $id) as $key) {
				// Removes the publication id into the voted publications
				unset($_SESSION["voted"][$key]);
			}

			// Redirect to homepage
			header('location: ../../public/index.php?page=home.php');
		} catch (PDOException $e) {
			header('location: ../../public/index.php?page=home.php&error=' . $e->getMessage());
		} finally {
			// Redirect to homepage
			$conn = null;
		}
	}

?>
