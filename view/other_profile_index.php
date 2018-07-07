<?php
require_once __SITE_PATH . '/view/_header.php';

/* Stranica koja sluzi za prikazivanje tudeg profila.
   Korisnik moze doci na ovu stranicu samo ako klikne na neciji username.
   Tada se iz query-stringa procita username i na njemu se pozivaju funkcije u controlleru.

   Ispisuju se osobni podaci.
   Ako je korisnik vozac ispisuju se uz to i:
        - vrsta i model auta, ukupna ocjena
        - posebno ocjene + komentari

   NAPOMENA:
   -> Ako cemo omoguciti da od tudih profila mozemo vidjeti samo one od vozaca, onda se odmah ispisuju i
      podaci o vozilu / komentari, pa ne treba raditi if($driver === true)
   */


?>

 <title> Profile of other User </title>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?php
  require_once __SITE_PATH . '/view/menu.php';
  require_once __SITE_PATH . '/view/menuForLogged.php';
  require_once __SITE_PATH . '/view/menuTheRest.php';
  ?>

  <div class="content-wrapper">

	<!-- OVDJE IDE SLIKA-->

	<div class="card card-register mx-auto mt-5">
	<div class="card-header">Profile</div>
            <div class="card-body">
        		<div class="form-group">
        			USERNAME: <?php  echo $user->username; ?>
        		</div>

        		<div class="form-group">
        			BIRTH YEAR:	<?php  echo $user->year; ?>
        		</div>

        		<div class="form-group">
        			TELEPHONE: <?php echo $user->telephone; ?>
        		</div>

        		<div class="form-group">
        			E-MAIL:	<?php echo $user->mail; ?>
        		</div>

                        <?php
                        // Ako je korisnik vozac, ispisujemo jos podataka.
                        if ( $driver === true ) { ?>
                    		<div class="form-group">
                    			CAR TYPE: <?php  echo $car->car_type; ?>
                    		</div>

                    		<div class="form-group">
                    			CAR MODEL: <?php  echo $car->car_model; ?>
                    		</div>

                    		<div class="form-group">
                    			RATINGS: <?php echo $car->rating; ?>
                    		</div>
                    <?php } ?>
            </div>
	</div>

        <?php
        // ispisujemo komentare i ocjene (ako je vozac)
        if ($driver === true) { ?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">COMMENTS ABOUT THIS USER</div>
                <div class="card-body">

        <?php   for ($i = 0; $i < count($poljeKomentara); ++$i) {
                        echo '<div class="form-group">';
                        echo "user: " . $poljeKomentara[$i][0] . ",      rating: " . $poljeKomentara[$i][2] . ",      comment: " . $poljeKomentara[$i][1];
                        echo '</div>';
                {
        }?>

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
