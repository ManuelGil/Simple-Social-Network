		<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<!-- Sign up form -->
				<!-- Include validator for bootstrap 3 -->
				<form class="form-signin" name="app" id="app" method="post" data-toggle="validator" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy'); return false; }" action="../src/modules/login.php">
					<div class="form-group lg">
						<h2 class="form-signin-heading text-center">Sign up</h2>
					</div>

					<div class="form-group lg">
						<input type="text" name="username" id="username" class="form-control" maxlength="20" pattern="[A-Za-z0-9]{5,20}" placeholder="Username" required autofocus>
	        </div>

					<div class="form-group lg">
	          <input type="password" name="password" id="password" class="form-control" maxlength="20" pattern="(?=^.{8, 20}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" placeholder="Password" required>
						<div class="help-block">UpperCase, LowerCase, Number/SpecialChar and min 8 Chars</div>
					</div>

					<div class="form-group lg">
	          <input type="password" name="cpassword" id="cpassword" class="form-control" maxlength="20" pattern="(?=^.{8, 20}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" data-match="#password" data-match-error="Your passwords don't match" placeholder="Confirm Password" required>
	        </div>

					<div class="form-group lg">
						<input type="checkbox" name="checkbox" id="agree" value="check"> I agree to the <a href="index.php?page=terms.html">Terms of Service</a>
					</div>

	        <div class="form-group in">
						<input type="submit" name="signup" id="submit" class="btn btn-lg btn-primary btn-block" value="Sign up"><br>
						<a href="index.php" class="btn btn-lg btn-primary btn-block">Back to login</a>
	        </div>
	      </form>
			</div>
    </div>
		</div>
