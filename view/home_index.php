<?php
require_once __SITE_PATH . '/view/_header.php';
?>
	<title> Home </title>
	<style>
	  #bg{
	   margin: 0;
	   padding: 0;
	  }
	  .imgbox {
	   display: grid;
	   height: 100%;
	  }
	  .fit-picture {
	   max-width: 100%;
	   max-height: 100vh;
	   margin: auto;
	  }
    </style>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<?php
	require_once __SITE_PATH . '/view/menu.php';
	if(isset($_SESSION['user_id'])) require_once __SITE_PATH . '/view/menuForLogged.php';
	require_once __SITE_PATH . '/view/menuTheRest.php';
	?>

  <div class="content-wrapper">
    <div class="container-fluid">
	  <h2> Welcome back! </h2>
      <hr>
	  <div class="imgbox">
		<img class="fit-picture" src=" <?php echo __SITE_URL; ?>/view/car.jpg" id="bg">
	  </div>
      <p>Tu možemo ubaciti neki tekst i možemo promijeniti sliku, ovo je za probu.</p>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
	<!--             javascript!!
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
	-->
<?php
require_once __SITE_PATH . '/view/_footer.php';
?>
