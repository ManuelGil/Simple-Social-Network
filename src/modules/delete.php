<?php

	// Load application files
	require_once "../autoload.php";

	if (isset($_GET['id'])) {
		// Gets the publication id
    $id = (int) $_GET['id'];

		// Gets the database connection
		$conn = getConnection();

		try {
			// Deletes the publication in the database
			$stmt = $conn->prepare("DELETE FROM QUOTES WHERE ID_QUOTE=:id");
			$stmt->bindParam(":id", $id);
			$stmt->execute();

			// Redirect to homepage
			header('location: ../../public/index.php?page=home.php');
		} catch (PDOException $e) {
			header('location: ../../public/index.php?page=home.php&error=' . $e->getMessage());
    } finally {
			// Destroy the database connection
      $conn = null;
    }
	}

?>
