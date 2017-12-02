<?php

  // Load application files
  require_once "../autoload.php";

  session_start();

	if (isset($_POST['quote'])) {
    // Gets post
		$quote = htmlentities(trim($_POST['quote']));
    // Gets the user id
    $id = (int) $_SESSION["id"];

    // Gets the database connection
		$conn = getConnection();

		try {
      // Adds the publication in the database
			$stmt = $conn->prepare("INSERT INTO QUOTES(QUOTE, ID_USER) VALUES(:quote, :id)");
			$stmt->bindParam(":quote", $quote);
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
