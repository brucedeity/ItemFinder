<!DOCTYPE html>
<html>
<head>
	<title>ItemFinder Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
			border: 1px solid #ddd;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		h2 {
			margin-top: 0;
		}

		.error-msg {
			color: red;
		}
	</style>
</head>
<body>
	<div class="container">
		<h2 class="text-center">ItemFinder Results</h2>
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<form id="search-form">
					<div class="form-group">
						<label for="itemId">Enter an item ID:</label>
						<input type="text" id="itemId" name="itemId" class="form-control">
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-primary">Search</button>
					</div>
				</form>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<div id="search-results"></div>
				<div id="error-msg" class="error-msg"></div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('#search-form').submit(function(event) {
				event.preventDefault();
				var itemId = $('#itemId').val();
				$.ajax({
					url: 'search.php',
					type: 'GET',
					data: {itemId: itemId},
					success: function(response) {
						$('#search-results').html(response);
						$('#error-msg').html('');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						$('#error-msg').html('Error: ' + textStatus + ' - ' + errorThrown);
					}
				});
			});
		});
	</script>

</body>
</html>
