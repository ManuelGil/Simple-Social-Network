<?php

	// If user is logged
	if (isset($_SESSION["login"])) {
		// Gets the username
		$user = $_SESSION["user"];

?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" name="app" id="app" method="post" action="../src/modules/post.php">

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
						<div class="form-group lg">
							<!-- Search text -->
							<div class="input-group pull-right">
								<input type="text" v-model="quote" v-if="items.length" name="search" id="search" class="form-control" placeholder="Search">
							</div>
						</div>

						<!-- publications -->
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>USER</th>
										<th>QUOTE</th>
										<th>DATE</th>
										<th>TIME</th>
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
									$stmt = $conn->prepare("SELECT Q.ID_QUOTE AS id, Q.QUOTE AS quote, Q.POST_DATE AS postdate, Q.POST_TIME AS posttime, Q.LIKES AS likes, U.GUID AS guid, U.USERNAME AS user FROM QUOTES AS Q, USERS AS U WHERE Q.ID_USER = U.ID_USER ORDER BY likes DESC");
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
												<td><a v-bind:href="'index.php?page=profile&guid=' + item.guid">@{{ item.user }}</a></td>
												<!-- If user is owner of post then strong text -->
												<th v-if="item.user == '<?= $user ?>'">{{ item.quote }}</th>
												<!-- If user isn't owner of post then simple text -->
												<td v-if="item.user != '<?= $user ?>'">{{ item.quote }}</td>
												<!-- date of post -->
												<td>{{ item.postdate }}</td>
												<!-- time of post -->
												<td>{{ item.posttime }}</td>
												<!-- # of likes -->
												<td>{{ item.likes }}</td>
												<!-- I the user voted then button 'like' -->
												<td v-if="!contains(item.id)"><a v-bind:href="'../src/modules/like.php?id=' + item.id" class="btn btn-primary"><span class="glyphicon glyphicon-heart"></span></a></td>
												<!-- I the user voted then button 'unlike' -->
												<td v-if="contains(item.id)"><a v-bind:href="'../src/modules/unlike.php?id=' + item.id" class="btn btn-default"><span class="glyphicon glyphicon-heart"></span></a></td>
												<!-- If user is owner of post then button 'remove' -->
												<td><a v-if="item.user == '<?= $user ?>'" v-bind:href="'../src/modules/delete.php?id=' + item.id" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
											</tr>
										</tbody>

										<?php

									} else {
										// No post were finds
										echo "<tbody><td class='danger' colspan='7' align='center'>No results were obtained</td></tbody>";
									}
								} catch (PDOException $e) {
									$_SESSION["message"] = "<strong>DataBase Error</strong>: No results were obtained.<br>" . $e->getMessage();

									// Redirect to homepage
									header('location: ../../public/index.php?page=home');
								} catch (Exception $e) {
									$_SESSION["message"] = "<strong>General Error</strong>: No results were obtained.<br>" . $e->getMessage();

									// Redirect to homepage
									header('location: ../../public/index.php?page=home');
								} finally {
									// Destroy the database connection
									$conn = null;
								}

								?>

							</table>
						</div>
					</div>
				</form>
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
		$_SESSION["message"] = "Please login";

		// If user isn't logged then redirect to index
		header('location: index.php');
	}

?>
