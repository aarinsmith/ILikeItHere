<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>I Like It Here | Matches</title>
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
</head>
<body>

	<div class="container">

		<!-- Personal Profile Info. -->
		<div class="container">

			<div class="col-md-3">
				<img src="{image}" class="img-responsive" alt="Profile Picture">
			</div>

			<div class="col-md-3">
				<b>First Name:</b> {fname} <br />
				<b>Last Name:</b> {lname} <br />
				<b>About:</b> {blurb} <br />
			</div>

			<div class="col-md-3">
				<img src="{oimage}" class="img-responsive" alt="Profile Picture">
			</div>

			<div class="col-md-3">
				<b>First Name:</b> {ofname} <br />
				<b>Last Name:</b> {olname} <br />
				<b>About:</b> {oblurb} <br />
			</div>

		</div>
		<!-- PERSONAL PROFILE END -->

		<div class="container">
			<h1>Commonly liked locations:</h1>
			<ul>
				{matches}
					<li>{match}</li>
				{/matches}
			</ul>
			<a href="/user/{back}">Go Back</a>
		</div>
	</div>

	<!-- Custom JS -->
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/scripts.js"></script>
</body>
</html>