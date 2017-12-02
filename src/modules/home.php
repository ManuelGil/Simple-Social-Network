<?php

	// Load user session
	session_start();

	// If user is logged
	if($_SESSION["login"]) {
		// Gets the username
		$user = $_SESSION["user"];
?>

		<nav class="navbar navbar-default">
		  <div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">@<?= $user // Show the username ?></a>
		    </div>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="exit.php"><span class="glyphicon glyphicon-log-out"></span> Quit</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" name="app" id="app" method="post" action="../src/modules/post.php">
					<div class="form-group lg">
					</div>

					<!-- Object #text binded with the 'letterCount' function -->
					<div id="text" class="form-group lg">
						<div class="input-group">
							<!-- bind text entry with Vue.js Attribute 'quote' -->
						  <textarea v-model="quote" name="quote" id="quote" class="form-control custom-control" rows="3" maxlength="120" style="resize:none" placeholder="Quote" autofocus></textarea>
							<!--If quote.length == 0 then button disabled -->
							<span v-if="quote.length == 0" class="input-group-addon btn btn-primary" onclick="return false;">Send</span>
							<!--If quote.length != 0 then button enabled -->
							<span v-if="quote.length != 0" class="input-group-addon btn btn-primary" onclick="document.getElementById('app').submit();">Send</span>
						</div>
						<!--display quote.length -->
						<p class="pull-right">{{ quote && quote.length ? quote.length : 0 }}</p>
					</div>

					<!-- Object #table binded with the 'loadTable' function -->
					<div id="table" class="form-group lg">
						<!-- Search text -->
						<div class="input-group pull-right">
							<input type="text" v-model="quote" v-if="items.length" name="search" id="search" class="form-control" placeholder="Search">
						</div>
						<!-- publications -->
						<table class="table">
							<thead>
								<tr>
									<th>USER</th>
									<th>QUOTE</th>
									<th>DATE</th>
									<th>LIKES</th>
									<th>VOTE</th>
									<th>DELETE</th>
								</tr>
							</thead>
							<?php

								// Gets the database connection
								$conn = getConnection();

								try {
									// Gets the publications
									$stmt = $conn->prepare("SELECT Q.ID_QUOTE AS id, Q.QUOTE AS quote, Q.POST_DATE AS postdate, Q.LIKES AS likes, U.USERNAME AS user FROM QUOTES AS Q, USERS AS U WHERE Q.ID_USER=U.ID_USER ORDER BY likes DESC");
									$stmt->execute();
									$query = $stmt->fetchAll();

									// If publications exist
									if ($query) {
										// Gets publications in a Json Array
										$items = json_encode($query);
										?>

											<tbody>
												<!-- Go through the items that matches with the search -->
												<tr v-for="item in search">
													<!-- Show username -->
													<td>{{ item.user }}</td>
													<!-- If user is owner of post then strong text -->
													<th v-if="item.user == '<?= $user ?>'">{{ item.quote }}</th>
													<!-- If user isn't owner of post then simple text -->
													<td v-if="item.user != '<?= $user ?>'">{{ item.quote }}</td>
													<!-- date of post -->
													<td>{{ item.postdate }}</td>
													<!-- # of likes -->
													<td>{{ item.likes }}</td>
													<!-- I the user voted then button 'like' -->
													<td v-if="!contains(item.id)"><a v-bind:href="'../src/modules/like.php?id=' + item.id" class="btn btn-primary"><span class="glyphicon glyphicon-heart"></span></a></td>
													<!-- I the user voted then button 'unlike' -->
													<td v-if="contains(item.id)"><a v-bind:href="'../src/modules/unlike.php?id=' + item.id" class="btn btn-default"><span class="glyphicon glyphicon-heart"></span></a></td>
													<!-- If user is owner of post then button 'remove' -->
													<td v-if="item.user == '<?= $user ?>'"><a v-bind:href="'../src/modules/delete.php?id=' + item.id" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
												</tr>
											</tbody>

										<?php
									} else {
										// No post were finds
										echo "<tbody><td class='danger' colspan='6' align='center'>No results were obtained</td></tbody>";
									}
								} catch (PDOException $e) {
									header('location: index.php?page=home.php&error=' . $e->getMessage());
								} finally {
									// Destroy database connection
							    $conn = null;
							  }

							?>
						</table>
					</form>
				</div>
			</div>
		</div>
		</div>

<?php
		// Call the javascript functions in the function file

		// Call Vue.js 'letterCount'
		letterCount();

		// If var items is defined then call Vue.js 'loadTable'
		if (isset($items)) {
			loadTable($items, json_encode($_SESSION["voted"]));
		}
	} else {
		// If user isn't logged then redirect to index
		header("location: index.php?error=Please login");
	}

?>
