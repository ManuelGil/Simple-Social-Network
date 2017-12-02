<?php

	// Load application files
	require_once "../autoload.php";

	if (isset($_POST['signin']) == 'Sign in') {
		// Gets username and password
		$user = htmlentities(trim($_POST['username']));
		$pass = htmlentities(trim($_POST['password']));

		// Gets the database connection
		$conn = getConnection();

		try {
			// Gets the user into the database
			$stmt = $conn->prepare("SELECT * FROM USERS WHERE USERNAME=:user");
			$stmt->bindParam(":user", $user);
			$stmt->execute();
			$query = $stmt->fetchObject();

			// If user exist
			if ($query) {
				// If password is correct
				if (password_verify($pass, $query->PASSWORD)) {
					// "Start" user session
					session_start();
					$_SESSION["login"] = TRUE;
					$_SESSION["id"] = $query->ID_USER;
					$_SESSION["user"] = $query->USERNAME;
					$_SESSION['voted'] = array();

					// Redirect to homepage
					header('location: ../../public/index.php?page=home.php');
				} else {
					// Password wrong
					header('location: ../../public/index.php?error=The password you have entered is wrong.');
				}
			} else {
				// Username wrong
				header('location: ../../public/index.php?error=The user specified does not exist.');
			}
		} catch (PDOException $e) {
      header('location: ../../public/index.php?error=' . $e->getMessage());
    } finally {
			// Destroy the database connection
      $conn = null;
    }
	} elseif(isset($_POST['signup'])=='Sign up') {
		// Gets username and password
		$user = htmlentities(trim($_POST['username']));
		$pass = password_hash(htmlentities(trim($_POST['password'])), PASSWORD_DEFAULT);

		// Gets the database connection
		$conn = getConnection();

		try {
			// Sets the user into the database
			$stmt = $conn->prepare("INSERT INTO USERS(USERNAME, PASSWORD) VALUES(:user, :pass)");
			$stmt->bindParam(":user", $user);
			$stmt->bindParam(":pass", $pass);
			$stmt->execute();

			// Redirect to index
			header('location: ../../public/index.php?error=Your account has been successfully created.');
		} catch (PDOException $e) {
			header('location: ../../public/index.php?error=' . $e->getMessage());
    } finally {
			// Destroy the database connection
      $conn = null;
    }
	}

?>
