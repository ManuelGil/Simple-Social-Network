<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<!-- Sign in form -->
			<!-- Include validator for bootstrap 3 -->
			<form class="form-signin" name="app" id="app" method="post" data-toggle="validator" action="../src/modules/login.php">

				<div class="form-group lg">
					<h2 class="form-signin-heading text-center">Please login</h2>
				</div>

				<div class="form-group lg">
					<input type="text" v-model="username" name="username" id="username" class="form-control"
						   maxlength="20" pattern="[A-Za-z0-9]{5,}"
						   placeholder="Username" required autofocus>
				</div>

				<div class="form-group lg">
					<input type="password" v-model="password" name="password" id="password" class="form-control"
						   maxlength="20" pattern="(?=^.{6,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$"
						   placeholder="Password" required>
					<div class="help-block with-errors"></div>
				</div>

				<!--
				<div class="form-group lg">
								<input type="checkbox" value="remember"> Remember me
				</div>
				-->

				<div class="form-group in">
					<input type="submit" name="signin" id="submit" class="btn btn-lg btn-primary btn-block" value="Sign in"><br>
					<a href="<?= $baseUrl; ?>/register" class="btn btn-lg btn-primary btn-block">Sing up</a>
				</div>

			</form>
		</div>
	</div>
</div>
