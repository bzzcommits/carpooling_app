<?php
require_once __SITE_PATH . '/view/_header.php';
?>
  <title>Forgot password</title>

</head>

<body class="bg-dark">
<?php
//require_once __SITE_PATH . '/view/upperRightCorner.php';
?>

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <div class="text-center mt-4 mb-5">
          <h4>Forgot your password?</h4>
          <p>Enter your email address and we will send you instructions on how to reset your password.</p>
        </div>

		<!-- postaviti action !! -->
        <form  method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=home/reset">
          <div class="form-group">
            <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email address" name="reset_email">
          </div>
		  <button type="submit" name="reset" class="btn btn-primary btn-block">Reset Password</button>
        </form>

        <div class="text-center">
          <a class="d-block small mt-3" href="<?php echo __SITE_URL; ?>/index.php?rt=home/signup"> Register an Account </a>
          <a class="d-block small" href="<?php echo __SITE_URL; ?>/index.php?rt=home/login"> Login Page </a>
        </div>
      </div>
    </div>
  </div>

<?php
require_once __SITE_PATH . '/view/_footer.php';
?>
