<?php 
require_once __SITE_PATH . '/view/_header.php'; 
?>

  <title>Login</title>
</head>

<body class="bg-dark">
<?php
//require_once __SITE_PATH . '/view/upperRightCorner.php';

?>
	<div class="container">
	<div class="card card-login mx-auto mt-5">
	  <div class="card-header">Login</div>
	  <div class="card-body">
		<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=home/login">
		  <div class="form-group">
			<label for="exampleInputEmail1">Username</label>
			<input class="form-control" id="exampleInputEmail1" type="text" placeholder="Username" name="username" />
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password" name="password" />
		  </div>
		  <!--
		  <div class="form-group">
			<div class="form-check">
			  <label class="form-check-label">
				<input class="form-check-input" type="checkbox"> Remember Password</label>
			</div>
		  </div>
		  -->
		  <button type="submit" name="login" class="btn btn-primary btn-block">Log in!</button>
		</form>
		<div class="text-center">
		  <a class="d-block small mt-3" href="<?php echo __SITE_URL; ?>/index.php?rt=home/signup">Register an Account</a>
		  <!-- promijeniti href !! -->
		  <a class="d-block small" href="forgot_password.php">Forgot Password?</a>
		</div>
	  </div>
	</div>
	</div>


<?php
require_once __SITE_PATH . '/view/message.php';
require_once __SITE_PATH . '/view/_footer.php';
?>
