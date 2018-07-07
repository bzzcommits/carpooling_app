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
        <!-- Promjena osobnog profila i podataka o vozilu -->
	<div class="card card-register mx-auto mt-5">
	<div class="card-header">Profile</div>
	<div class="card-body">
		<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=user/updateUserInfo">

                                <!-- OVDJE IDE SLIKA-->
                                <!-- treba omoguciti da se promijeni / ucita nova slika -->

                        <div class="form-group">
				<label for="changeUsername">USERNAME</label>
				<input class="form-control" id="changeUsername" type="text" placeholder="Enter new username" name="changeUsername" />
			</div>

			<div class="form-group">
				<label for="changeYear">BIRTH YEAR</label>
				<input class="form-control" id="changeYear" type="text" placeholder="Enter new year" name="changeYear" />
			</div>

			<div class="form-group">
				<label for="changeTelephone">TELEPHONE</label>
				<input class="form-control" id="changeTelephone" type="text" placeholder="Enter new telephone number" name="changeTelephone" />
			</div>

			<div class="form-group">
				<label for="changeMail">E-MAIL</label>
				<input class="form-control" id="changeMail" type="text" placeholder="Enter new e-mail" name="changeMail" />
			</div>

                        <div class="form-group">
				<label for="changeCarType">CAR TYPE</label>
				<input class="form-control" id="changeCarType" type="text" placeholder="Enter new car type" name="changeCarType" />
			</div>

			<div class="form-group">
				<label for="changeCarModel">CAR MODEL</label>
				<input class="form-control" id="changeCarModel" type="text" placeholder="Enter new car model" name="changeCarModel" />
			</div>

			<button type="submit" name="saveChange" class="btn btn-primary btn-block">Save changes!</button>
			<button type="submit" name="dropChange" class="btn btn-primary btn-block">Drop changes!</button>
		</form>
	</div>

  <!-- Odvojena forma za uploadanje slike jer se treba koristiti drugačiji enctype kad se šalju datoteke, a ne onaj defaultni. -->
  <div class="card-header">Profile image</div>
    <div class="card-body">
    <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=user/updateImage" enctype="multipart/form-data">
      <div class="form-group">
        <span class="btn btn-default btn-file">
          <input type="file" id="imageToUpload" name="imageToUpload">
        </span>
      </div>
      <button type="submit" name="uploadNew" class="btn btn-primary btn-block">Upload new image!</button>
      <button type="submit" name="deleteImage" class="btn btn-primary btn-block">Delete current image!</button>
    </form></br></br>
	</div>
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
  </div>

<?php
require_once __SITE_PATH . '/view/message.php';
require_once __SITE_PATH . '/view/_footer.php';
?>
