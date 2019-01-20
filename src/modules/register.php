<?php

	// Gets the database connection
	$conn = getConnection();

	try {
		// Gets the countries
		$sql = "SELECT		ID_COUNTRY AS id,
							ISO AS iso,
							COUNTRY AS country
				FROM		COUNTRIES
				ORDER BY	iso ASC;";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		$query = $stmt->fetchAll();

		$countries = json_encode($query);
	} catch (PDOException $e) {
		$_SESSION["message"] = "<strong>DataBase Error</strong>: No results were obtained.<br>" . $e->getMessage();

		// Redirect to homepage
		header('location: ../../public/index.php');
	} catch (Exception $e) {
		$_SESSION["message"] = "<strong>General Error</strong>: No results were obtained.<br>" . $e->getMessage();

		// Redirect to homepage
		header('location: ../../public/index.php');
	} finally {
		// Destroy the database connection
		$conn = null;
	}

?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<!-- Sign up form -->
				<!-- Include validator for bootstrap 3 -->
				<form class="form-signin" name="app" id="app" method="post" data-toggle="validator" onsubmit="if (document.getElementById('agree').checked) {
							return true;
						} else {
							alert('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy');
							return false;
						}" action="../src/modules/login.php">

					<div class="form-group lg">
						<h2 class="form-signin-heading text-center">Sign up</h2>
					</div>

					<div class="form-group lg">
						<input type="text" name="username" id="username" class="form-control"
							   maxlength="20" pattern="[A-Za-z0-9]{5,}"
							   placeholder="Username" required autofocus>
						<div class="help-block with-errors"></div>
					</div>

					<div class="form-group lg">
						<input type="password" name="password" id="password" class="form-control"
							   maxlength="20" pattern="(?=^.{6,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$"
							   placeholder="Password" required>
						<div class="help-block with-errors"></div>
						<div class="help-block">Password must contain at least contain uppercase letters, lowercase letters, numbers and a minimum of 6 characters</div>
					</div>

					<div class="form-group lg">
						<input type="password" name="cpassword" id="cpassword" class="form-control"
							   maxlength="20" data-match="#password" data-match-error="Your passwords don't match"
							   placeholder="Confirm Password" required>
						<div class="help-block with-errors"></div>
					</div>

					<div class="form-group">
						<select class="form-control" name="country">
							<option v-for="country in countries" :value="country.id">{{country.iso}} - {{country.country}} </option>
						</select>
					</div>

					<div class="form-group lg">
						<input type="checkbox" name="checkbox" id="agree" value="check"> I agree to the <a href="<?= $baseUrl; ?>/terms">Terms of Service</a>
					</div>

					<div class="form-group in">
						<input type="submit" name="signup" id="submit" class="btn btn-lg btn-primary btn-block" value="Sign up"><br>
						<a href="<?= $baseUrl; ?>" class="btn btn-lg btn-primary btn-block">Back to login</a>
					</div>

				</form>
			</div>
		</div>
	</div>

<?php

	loadCountries($countries);

?>
