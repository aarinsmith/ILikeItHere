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
				<b><a href="/locations/{userid}">View All Locations</a></b>
			</div>

			<div class="col-md-3">

			</div>

			<div class="col-md-3">
			<a href="/">Go Back</a>
			</div>

		</div>
		<!-- PERSONAL PROFILE END -->

		<!-- Potential Match List -->
		<div class="container">
			<table class="table">
				<th>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Your match %</td>
					<td></td>
					<td>Their match %</td>
				</th>
				{matches}
				<tr
				class="click-row"
				data-href="/user/<?php echo $this->session->id; ?>/displaymatches/{id}">
					<td></td>
					<td>{fname}</td>
					<td>{lname}</td>
					<td>{us}</td>
					<td></td>
					<td>{them}</td>
				</tr>
				{/matches}
			</table>
		</div>
		<!-- POTENTIAL MATCH LIST END -->
	</div>

	<!-- Custom JS -->
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/scripts.js"></script>
</body>
</html>