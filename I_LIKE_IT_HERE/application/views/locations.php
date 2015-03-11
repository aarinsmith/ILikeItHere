<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>I Like It Here | User Profile</title>
	<link rel="stylesheet" href="/css/styles.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
</head>
<body>

	<div class="container">

		<!-- Personal Profile Info. -->
		<div class="container">

			<div class="col-md-3">
				<img src="{profilePic}" class="img-responsive" alt="Profile Picture">
			</div>

			<div class="col-md-3">
				<b>First Name:</b> {fName} <br />
				<b>Last Name:</b> {lName} <br />
				<b>About:</b> {blurb} <br />
			</div>

			<div class="col-md-3">

			</div>

			<div class="col-md-3">
			</div>

		</div>
		<!-- PERSONAL PROFILE END -->

		<div class="container">
			<h1>Users Locations:</h1>
			<ul>
				{locations}
					<li>{location}</li>
				{/locations}
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