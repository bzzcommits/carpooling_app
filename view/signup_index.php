<?php
require_once __SITE_PATH . '/view/_header.php';
?>
  <title>Sign up</title>

</head>

<body class="bg-dark">

<?php
//require_once __SITE_PATH . '/view/upperRightCorner.php';
//require_once __SITE_PATH . '/view/menu.php';
?>

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
		  <div class="form-group">
            <label for="exampleInputUsername1">Username</label>
            <input class="form-control" id="exampleInputUsername1" type="text" placeholder="Username" name="username">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Email" name="email">
          </div>

          <div class="form-group">
            <label for="psw">Password</label>
            <input class="form-control" id="psw" type="password" placeholder="Password" name="password">
          </div>

		  <div class="form-group">
            <label for="cnf">Confirm password</label>
            <input class="form-control" id="cnf" type="password" placeholder="Confirm password" name="confirm">
			<label id="mssg"> </label>
          </div>

          <button type="submit" name="signup" id="sgnup" class="btn btn-primary btn-block">Sign up!</button>
        <div class="text-center">
          <a class="d-block small mt-3" href="<?php echo __SITE_URL; ?>/index.php?rt=home/login">Login Page</a>
      <a class="d-block small" href="<?php echo __SITE_URL; ?>/index.php?rt=home/forgotPassword">Forgot Password?</a>
	   </div>

      </div>
    </div>
  </div>

<?php
require_once __SITE_PATH . '/view/_footer.php';
?>
