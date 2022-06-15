	<!-- Navigation -->
	<div class="container">
		<?php
		$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
		$select_profile->execute([$admin_id]);
		$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
		?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			<img src="assets/img/logo-dict.png" width="40" height="40" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			<a class="navbar-brand" href="admin_page.php">Department of Information and Communication Technology</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>


			<div class="collapse navbar-collapse" id="navbarResponsive">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<span class="nav-link">Welcome |
							<?= $fetch_profile['name']; ?>
						</span>
					</li>
				</ul>
			</div>

			<div class="flex-shrink-0 dropdown">
				<a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="" width="40" height="40" class="rounded-circle">
				</a>
				<ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 34px, 0px);" data-popper-placement="bottom-end">

					<li style="text-align:center">
						<img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="" width="40" height="40" class="rounded-circle"> <br>
						<?= $fetch_profile['email']; ?> <br>
						<?= $fetch_profile['user_type']; ?>
					</li>
					<li></li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li><a class="dropdown-item" href="admin_profile_settings.php">Profile Settings</a></li>
					<li><a class="dropdown-item" href="administrative-settings.php">Administrative Settings</a></li>

					<li></li>
					<li>
						<hr class="dropdown-divider">
					</li>
					<li><a class="dropdown-item" href="model/login/logout.php">Sign out</a></li>
				</ul>
			</div>
		</nav>

	</div>