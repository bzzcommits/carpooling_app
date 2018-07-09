<?php
require_once __SITE_PATH . '/view/_header.php';
?>

<title> Profile </title>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
    <?php
     require_once __SITE_PATH . '/view/menu.php';
     require_once __SITE_PATH . '/view/menuForLogged.php';
     require_once __SITE_PATH . '/view/menuTheRest.php';
     ?>

  <div class="content-wrapper">

	<div class="card card-register mx-auto mt-5">
	<div class="card-header">Become a Driver</div>
        <div class="card-body">
                <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=user/updateDriverInfo">
                <div class="form-group">
        			CAR TYPE: <input class="form-control" id="newCarType" type="text" placeholder="Enter Car Type" name="newCarType" />
        		</div>

        		<div class="form-group">
        			CAR MODEL:	<input class="form-control" id="newCarModel" type="text" placeholder="Enter Car Model" name="newCarModel" />
        		</div>
        		<button type="submit" name="newDriver" class="btn btn-primary btn-block">Become a driver!</button>
                </form>
        </div>
	</div>


    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright &copy; 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
  </div>

<?php
require_once __SITE_PATH . '/view/_footer.php';
?>