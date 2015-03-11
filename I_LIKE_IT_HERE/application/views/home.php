<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>I Like It Here</title>
	<link rel="stylesheet" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>
<body>

	<div class="container">

		<!-- Header -->
		<div class="container">

			<div class="col-md-3">
				<img src="{logo}" class="img-responsive" alt="Profile Picture">
			</div>

			<div class="col-md-3">
				Demo Application for plenty of fish hackathon.
			</div>

			<div class="col-md-3">
			</div>

			<div class="col-md-3">
			</div>

		</div>
		<!-- HEADER END -->

		<!-- Potential Match List -->
		<div class="container">
			<table class="table">
				<th>
					<td>First Name</td>
					<td>Last Name</td>
					<td></td>
					<td></td>
					<td></td>
				</th>
				{users}
				<tr class="click-row" data-href="/user/{id}">
					<td></td>
					<td>{fname}</td>
					<td>{lname}</td>
				</tr>
				{/users}
			</table>
		</div>
		<!-- POTENTIAL MATCH LIST END -->
	</div>

	<!-- Custom JS -->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>