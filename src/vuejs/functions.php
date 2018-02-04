<!-- import Vue.js 2 for developers -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>

<?php

	/**
	 * This function display a error message inside the message object
	 * @param String $message - The error message
	 */
	function showMessage($message) {
		?>

		<script type="text/javascript">
			var app = new Vue({
				el: '#message', // Object id
				data: {
					message: '<?= $message ?>' // Error message
				}
			})
		</script>

		<?php
	}

	/**
	 * This function obtain a text entry
	 */
	function letterCount() {
		?>

		<script type="text/javascript">
			var app = new Vue({
				el: '#text', // Object id
				data: {
					quote: '' // Text entry
				}
			})
		</script>

		<?php
	}

	/**
	 * This function manages the publications table
	 * @param  JSONArray $items - Contains the items array
	 * @param  JSONArray $votes - Contains the array that identifies the voted publications
	 */
	function loadTable($items, $votes) {
		?>

		<script type="text/javascript">
			var app = new Vue({
				el: '#table', // Object id
				created: function () {
					this.load() // invoke the load method in the creation state of Vue.js
				},
				data: {
					items: [], // Items array
					votes: [], // Voted publications
					quote: '' // Attribute to linked with search
				},
				methods: {
					load: function () {
						this.items = <?= $items ?>, // Load the items array
								this.votes = <?= $votes ?> // Load the voted publications
					},
					contains: function (key) {
						for (var i = 0; i < this.votes.length; i++) { // Go through the array of voted publications
							if (this.votes[i] == key) {
								return true // If publication is voted
							}
						}
						return false // If publication isn´t voted
					}
				},
				computed: {
					search: function () { // Iterates the items array and return the items that matches with the search
						return this.items.filter((item) => item.quote.includes(this.quote))
					}
				}
			})
		</script>

		<?php
	}

?>
