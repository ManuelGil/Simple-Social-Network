<!-- import Vue.js 2 for developers -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>

<?php

	/**
	 * This function load the countries
	 */
	function loadCountries($countries) {
		?>

		<script type="text/javascript">
			new Vue({
				el: '#app', // Object id
				created: function () {
					this.load() // invoke the load method in the creation state of Vue.js
				},
				data: {
					countries: [] // Array of countries
				},
				methods: {
					load: function () {
						this.countries = <?= $countries; ?> // Load the array of countries
					}
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
					items: [],	// Items array
					votes: [],	// Voted publications
					quote: '',	// Attribute to linked with search
					page: 1,	// Page number
					size: 25
				},
				methods: {
					load: function () {
						this.items = <?= $items ?>	// Load the items array
						this.votes = <?= $votes ?>	// Load the voted publications
					},
					contains: function (key) {
						for (var i = 0; i < this.votes.length; i++) { // Go through the array of voted publications
							if (this.votes[i] == key) {
								return true // If publication is voted
							}
						}
						return false // If publication isn´t voted
					},
					next: function () {
						this.page++;
					},
					prev: function () {
						this.page--;
					}
				},
				computed: {
					search: function () { // Iterates the items array and return the items that matches with the search
						return this.items.filter((item) => item.quote.includes(this.quote))
					},
					count: function () {
						return Math.ceil (this.items.length / this.size)
					},
					start: function () {
						return (this.page - 1) * this.size
					}
				}
			})
		</script>

		<?php
	}

?>
