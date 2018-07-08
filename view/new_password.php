<?php
require_once __SITE_PATH . '/view/_header.php';
?>
  <title>New password</title>

</head>

<body class="bg-dark">
<?php
//require_once __SITE_PATH . '/view/upperRightCorner.php';
?>

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-body">
        <div class="text-center mt-4 mb-5">
          <div>Enter new password,<div id="newpassus"><?php echo $_GET['npusername'];?></div></div>
        </div>

          <div class="form-group">
            <input class="form-control" id="newpass" type="password"  placeholder="New password">
          </div>
		      <button type="submit" name="reset" class="btn btn-primary btn-block" id="newpassbtn">Change Password</button>

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
