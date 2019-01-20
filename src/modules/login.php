<?php

	// Load user session
	session_start();

	// Load application files
	require_once "../autoload.php";

	if (isset($_POST['signin']) == 'Sign in') {
		// Gets username and password
		$user = trim($_POST['username']);
		$pass = trim($_POST['password']);

		// Gets the database connection
		$conn = getConnection();

		try {
			// Gets the user into the database
			$sql = "SELECT	*
					FROM	USERS
					WHERE	USERNAME = :user;";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":user", $user);
			$stmt->execute();
			$query = $stmt->fetchObject();

			// If user exist
			if ($query) {
				// If password is correct
				if (password_verify($pass, $query->PASSWORD)) {
					$id = $query->ID_USER;
					// "Start" user session
					$_SESSION["login"] = TRUE;
					$_SESSION["id"] = $id;
					$_SESSION["guid"] = $query->GUID;
					$_SESSION["user"] = $query->USERNAME;

					$sql = "SELECT	*
							FROM	LIKES
							WHERE	ID_USER = :id;";
					$stmt = $conn->prepare($sql);
					$stmt->bindParam(":id", $id);
					$stmt->execute();
					$array = $stmt->fetchAll();

					foreach ($array as $key => $value) {
						$_SESSION["voted"][] = $value["ID_QUOTE"];
					}

					// Redirect to homepage
					header('location: ../../public/home');
				} else {
					// Password wrong
					$_SESSION["message"] = "The password you have entered is wrong.";

					// Redirect to index
					header('location: ../../public/index.php');
				}
			} else {
				// Username wrong
				$_SESSION["message"] = "The user specified does not exist.";

				// Redirect to index
				header('location: ../../public/index.php');
			}
		} catch (PDOException $e) {
			$_SESSION["message"] = "<strong>DataBase Error</strong>: The user could not be found.<br>" . $e->getMessage();

			// Redirect to index
			header('location: ../../public/index.php');
		} catch (Exception $e) {
			$_SESSION["message"] = "<strong>General Error</strong>: The user could not be found.<br>" . $e->getMessage();

			// Redirect to index
			header('location: ../../public/index.php');
		} finally {
			// Destroy the database connection
			$conn = null;
		}
	} elseif (isset($_POST['signup']) == 'Sign up') {
		// Unique ID
		$guid = uniqid();
		// Gets username and password
		$user = trim($_POST['username']);
		$pass = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
		// Date of created
		$created = date('Y-m-d');
		// Country ID
		$country = (int) trim($_POST['country']);

		// Gets the database connection
		$conn = getConnection();

		try {
			// Sets the user into the database
			$sql = "INSERT INTO	USERS(GUID, USERNAME, PASSWORD, CREATED_AT, ID_COUNTRY)
					VALUES		(:guid, :user, :pass, :created, :country);";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(":guid", $guid);
			$stmt->bindParam(":user", $user);
			$stmt->bindParam(":pass", $pass);
			$stmt->bindParam(":created", $created);
			$stmt->bindParam(":country", $country);
			$result = $stmt->execute();

			if ($result === false) {
				$_SESSION["message"] = "Your account cannot be created at this time. Please try again later.";
			}

			// Redirect to index
			header('location: ../../public/index.php');
		} catch (PDOException $e) {
			$_SESSION["message"] = "<strong>DataBase Error</strong>: The user could not be created.<br>" . $e->getMessage();

			// Redirect to index
			header('location: ../../public/register');
		} catch (Exception $e) {
			$_SESSION["message"] = "<strong>General Error</strong>: The user could not be created.<br>" . $e->getMessage();

			// Redirect to index
			header('location: ../../public/register');
		} finally {
			// Destroy the database connection
			$conn = null;
		}
	} else {
		// Redirect to index
		header('location: ../../public/index.php');
	}

?>
