<?php
require_once __SITE_PATH . '/view/_header.php';

/* NAPOMENA: ovo jos nisam testirala, buduci da se prvo mora omoguciti klikanje na ime (Anastasija)

   TREBA:
    - dodati gumb "Follow this user" (treba onda dodati i pripadne f-je u model i controller)


   Stranica koja sluzi za prikazivanje tudeg profila.
   Korisnik moze doci na ovu stranicu samo ako klikne na neciji username.
   Tada se iz query-stringa procita username i na njemu se pozivaju funkcije u controlleru.

   Ispisuju se osobni podaci.
   Ako je korisnik vozac ispisuju se uz to i:
        - vrsta i model auta, ukupna ocjena
        - posebno ocjene + komentari
        - povijest proslih voznji
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

	<div class="card card-register mx-auto mt-5">
  	<div class="card-header">
      <div class="nextTo">Profile</div>
      <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=user/<?php if ($follow) echo "un"?>follow&name=<?php  echo $user->username; ?>">
          <button type="submit" id="followbtn" class="btn btn-primary btn-block"><?php echo ($follow ? "Unf" : "F") ?>ollow <?php  echo $user->username; ?></button>
      </form>
    </div>
          <div class="card-body">
            <div class="form-group">
              <img id="jej" src="user_images/<?php echo $user->image !== "" ? $user->username . "/" . $user->image : "avatar.png" ?>" alt="Something went wrong.">
            </div>
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
                    			CAR TYPE: <?php  echo $car[0]; ?>
                    		</div>

                    		<div class="form-group">
                    			CAR MODEL: <?php  echo $car[1]; ?>
                    		</div>

                    		<div class="form-group">
                    			RATINGS: <?php if ($car[2] === 0 ) echo 'no ratings yet'; else echo number_format( (float) $car[2], 2, '.', ''); ?>
                    		</div>
                    <?php } ?>
            </div>
	</div>

        <?php
        if ($driver === true) {
                // ispisujemo komentare i ocjene
                if ( count($poljeKomentara) > 0 ) {   ?>
                    <div class="card card-register mx-auto mt-5">
                    <div class="card-header">COMMENTS ABOUT THIS USER</div>
                    <div class="card-body">

             <?php  for ($i = 0; $i < count($poljeKomentara); ++$i) {
                        echo '<div class="form-group">';
                        echo "user: " . '<a href="' . __SITE_URL . '/index.php?rt=otherUser&name=' . $poljeKomentara[$i][0] . '">' . $poljeKomentara[$i][0] . '</a>'
                         . ",      rating: " . $poljeKomentara[$i][2] . ",      comment: " . $poljeKomentara[$i][1];
                        echo '</div>';
                    }
                    echo "</div></div>";
                }
                //ispisujemo prosle voznje
                if ( count($poljeProslihVoznji) > 0 ) {?>
                    <div class="card card-register mx-auto mt-5">
                    <div class="card-header">HISTORY OF DRIVES</div>
                    <div class="card-body">
             <?php  for ($i = 0; $i < count($poljeProslihVoznji); ++$i) {
                         $phpdate = strtotime($poljeProslihVoznji[$i][2]);
                         $phpdate = date( 'd M Y', $phpdate );

                        echo '<div class="form-group">';
                        echo "From " . $poljeProslihVoznji[$i][0] . "   to " . $poljeProslihVoznji[$i][1]. ",  on " . $phpdate
                        . ",  at " . $poljeProslihVoznji[$i][3] . " till " . $poljeProslihVoznji[$i][4] . "  costs " . $poljeProslihVoznji[$i][5] . "kn";
                        echo '</div>';
                       }
                       echo "</div></div>";
                }

        }?>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright Â© 2018</small>
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
