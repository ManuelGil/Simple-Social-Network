<?php

	// If user is logged
	if (isset($_SESSION["login"])) {
		// Gets the username
		$guid = $_GET["guid"];

		// Gets the database connection
		$conn = getConnection();

		try {
			$stmt = $conn->prepare("SELECT U.ID_USER AS id, U.USERNAME AS user, U.CREATED_AT AS created, C.COUNTRY AS country FROM USERS AS U, COUNTRIES AS C WHERE U.ID_COUNTRY = C.ID_COUNTRY AND U.GUID = :guid");
			$stmt->bindParam(":guid", $guid);
			$stmt->execute();
			$query = $stmt->fetchObject();

			// If user exist
			if ($query) {
				$id = $query->id;
				$user = $query->user;
				$created = date_create($query->created);
				$country = $query->country;
			} else {
				// GUID wrong
				$_SESSION["message"] = "The user specified does not exist.";

				// Redirect to index
				header('location: index.php');
			}
		} catch (PDOException $e) {

			$_SESSION["message"] = "<strong>DataBase Error</strong>: The user could not be found.<br>" . $e->getMessage();

			// Redirect to index
			header('location: index.php');
		} catch (Exception $e) {
			$_SESSION["message"] = "<strong>General Error</strong>: The user could not be found.<br>" . $e->getMessage();

			// Redirect to index
			header('location: index.php');
		} finally {
			// Destroy the database connection
			$conn = null;
		}

?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form class="form-horizontal" name="app" id="app">

                    <div class="form-group lg">
                        <h2>@<?= $user; ?></h2>
                        <span style="color: gray;"><span class="glyphicon glyphicon-map-marker"></span> <?= $country; ?></span><br />
                        <span style="color: gray;">Joined <?= date_format($created, "F j, Y"); ?></span>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>QUOTE</th>
                                    <th>DATE</th>
                                    <th>TIME</th>
                                    <th>LIKES</th>
                                    <th>VOTE</th>
                                </tr>
                            </thead>

							<?php

							// Gets the database connection
							$conn = getConnection();

							try {
								// Gets the publications
								$stmt = $conn->prepare("SELECT ID_QUOTE AS id, QUOTE AS quote, POST_DATE AS postdate, POST_TIME AS posttime, LIKES AS likes FROM QUOTES WHERE ID_USER = :id ORDER BY postdate DESC");
								$stmt->bindParam(":id", $id);
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
                                            <!-- If user is owner of post then strong text -->
                                            <td>{{ item.quote }}</td>
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
                                        </tr>
                                    </tbody>

									<?php

								} else {
									// No post were finds
									echo "<tbody><td class='danger' colspan='5' align='center'>No results were obtained</td></tbody>";
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
