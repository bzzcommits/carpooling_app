<?php
require_once __SITE_PATH . '/view/_header.php';
/* Stranica koja sluzi za prikazivanje osobnog profila.
   Korisniku je omogucena promjena osobnih podataka (username se mijenja ak taj username nije vec zauzet).
   Ako je korisnik vozac ispisuju se:
        + vrsta i model auta, ukupna ocjena
        + posebno ocjene + komentari
        + nadolazece voznje koje je objavio
                - omogucen je gumb za otkazivanje voznje
   Za ostale se ispisuju:
        + nadolazece voznje
                - omogucen je gumb za otkaz rezervacije
        + voznje koje jos nisu ocijenili
                - treba dodati formu u koju upise ocjenu, komentar i gumb
        + poruke koje javljaju o otkazivanju rezervirane voznje
                - dodati gumb koji se klikne nakon sto korisnik procita*/
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
	<div class="card-header">Profile</div>
        <div class="card-body">
                <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=user/changeUserInfo">
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
        		<button type="submit" name="changeUserInfo" class="btn btn-primary btn-block">Change Profile Info!</button>
                </form>
                <?php
                    if($driver === false) {?>
                        <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=user/becomeADriver">
                        <button type="submit" name="becomeADriver" class="btn btn-primary btn-block">Become a Driver!</button>
                        </form>
                <?php }
                ?>
        </div>
	</div>

    <?php
        // Ako je korisnik mijenjao podatke, i bile su neke greske, ovdje ih ispisujemo
        if ( !empty($errorMsgs) ) {
                echo '<div class="card card-register mx-auto mt-5">';
                for ($i = 0; $i < count($errorMsgs); ++$i) {
                        echo  '<div class="card-header">' . $errorMsgs[$i] . '</div>' ;
                }
                 echo '</div>';
                //unset($errorMsgs);
        }

        // ispisujemo korisnike koje ovaj korisnik prati
        if ( count($poljePracenih) > 0) {?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">YOU ARE FOLLOWING THESE USERS</div>
                <div class="card-body">
                <div class="form-group">
        <?php  for ($i = 0; $i < count($poljePracenih); ++$i) {
                echo '<a href="' . __SITE_URL . '/index.php?rt=otherUser&name=' . $poljePracenih[$i] . '">' . $poljePracenih[$i] . '</a>';
                if ($i !== count($poljePracenih) - 1 )
                    echo ", ";
           }
          echo "</div></div></div>";
        }

        // ispisujemo korisnike koji prate ovog korisnika
        if ( count($poljePratitelja) > 0) {?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">THESE USERS ARE FOLLOWING YOU</div>
                <div class="card-body">
                <div class="form-group">
        <?php  for ($i = 0; $i < count($poljePratitelja); ++$i) {
                echo '<a href="' . __SITE_URL . '/index.php?rt=otherUser&name=' . $poljePratitelja[$i] . '">' . $poljePratitelja[$i] . '</a>';
                if ($i !== count($poljePratitelja) - 1 )
                    echo ", ";
           }
          echo "</div></div></div>";
        }


        // ispisujemo komentare i ocjene
        if ($driver === true) { ?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">COMMENTS ABOUT THIS USER</div>
                <div class="card-body">

        <?php   for ($i = 0; $i < count($poljeKomentara); ++$i) {
                        echo '<div class="form-group">';
                        echo "user: " . '<a href="' . __SITE_URL . '/index.php?rt=otherUser&name=' . $poljeKomentara[$i][0] . '">' . $poljeKomentara[$i][0] . '</a>'
                         . ",      rating: " . $poljeKomentara[$i][2] . ",      comment: " . $poljeKomentara[$i][1];
                        echo '</div>';
           }
          echo "</div></div>";
          // ispisujemo (buduce) voznje ovog vozaca
          if ( count($poljeMojihVoznji) > 0) {?>
                  <div class="card card-register mx-auto mt-5">
                  <div class="card-header">YOUR FUTURE DRIVES</div>
                  <div class="card-body">
          <?php  for ($i = 0; $i < count($poljeMojihVoznji); ++$i) {
                  $phpdate = strtotime($poljeMojihVoznji[$i][2]);
                  $phpdate = date( 'd M Y', $phpdate );
                  echo '<div class="form-group">';
                  echo "From " . $poljeMojihVoznji[$i][0] . "   to " . $poljeMojihVoznji[$i][1]. ",  on " . $phpdate
                  . ",  at " . $poljeMojihVoznji[$i][3] . " till " . $poljeMojihVoznji[$i][4] . ",  costs " . $poljeMojihVoznji[$i][5] .  "kn,   no. of reservations: "
                  . $poljeMojihVoznji[$i][6];
                  echo ' <button class= "otkaziVoznju" name="' . $poljeMojihVoznji[$i][7] . '" >Delete this ride</button>';
                  echo '</div>';
             }
            echo "</div></div>";
          }

          // ispisujemo prosle voznje
          if ( count($poljeProslihVoznji) > 0) {?>
                  <div class="card card-register mx-auto mt-5">
                  <div class="card-header">YOUR PAST DRIVES</div>
                  <div class="card-body">
          <?php  for ($i = 0; $i < count($poljeProslihVoznji); ++$i) {
                  $phpdate = strtotime($poljeProslihVoznji[$i][2]);
                  $phpdate = date( 'd M Y', $phpdate );
                  echo '<div class="form-group">';
                  echo "From " . $poljeProslihVoznji[$i][0] . "   to " . $poljeProslihVoznji[$i][1]. ",  on " . $phpdate
                  . ",  at " . $poljeProslihVoznji[$i][3] . " till " . $poljeProslihVoznji[$i][4] . ",  costs " . $poljeProslihVoznji[$i][5] .  "kn";
                  echo '</div>';
             }
            echo "</div></div>";
          }

        }

        // poljeRez se sastoji od tri array-a
        $poljeRezerv = $poljeRez[0];
        $poljeBezKom = $poljeRez[1];
        $poljeIzbris = $poljeRez[2];

        // ispisujemo rezervirane voznje
        if (count($poljeRezerv) > 0) { ?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">YOUR RESERVATIONS</div>
                <div class="card-body">

        <?php   for ($i = 0; $i < count($poljeRezerv); ++$i) {
                    $phpdate = strtotime($poljeRezerv[$i][3]);
                    $phpdate = date( 'd M Y', $phpdate );
                    echo '<div class="form-group">';
                    echo 'Driver: <a href="' . __SITE_URL . '/index.php?rt=otherUser&name=' .  $poljeRezerv[$i][0] . '">' .  $poljeRezerv[$i][0] . '</a>';
                    echo ", from " . $poljeRezerv[$i][1] . "   to " . $poljeRezerv[$i][2]
                    . ",  on " . $phpdate . ",  at " . $poljeRezerv[$i][4] . " till " . $poljeRezerv[$i][5] . ",  costs " . $poljeRezerv[$i][6] .  "kn";
                    // 7.element polja je drive_id. Pomocu njega i gumbda znamo koju voznju treba otkazati
                    $imeGumba = "otkaziRezervacijuBr_" . $poljeRezerv[$i][7]; // odvajamo s _ da mozemo explodat
                    echo ' <button class= "otkaziRezervaciju" name="' . $poljeRezerv[$i][7] . '" >Delete</button>';
                    echo '</div>';
           }
          echo "</div></div>";
        }
        // ispisujemo neocjenjene voznje
        if (count($poljeBezKom) > 0) { ?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">DRIVES YOU HAVEN'T GRADED</div>
                <div class="card-body">

        <?php   for ($i = 0; $i < count($poljeBezKom); ++$i) {
                    $phpdate = strtotime($poljeBezKom[$i][3]);
                    $phpdate = date( 'd M Y', $phpdate );
                    echo '<div class="form-group">';
                    echo 'Driver: <a href="' . __SITE_URL . '/index.php?rt=otherUser&name=' .   $poljeBezKom[$i][0] . '">' .   $poljeBezKom[$i][0] . '</a>';
                    echo ", from " . $poljeBezKom[$i][1] . "   to " . $poljeBezKom[$i][2]
                    . ",  on " . $phpdate . ",  at " . $poljeBezKom[$i][4] . " till " . $poljeBezKom[$i][5] . ",  costs " . $poljeBezKom[$i][6] .  "kn";

                    echo '<input class="form-control" id="ocjena" placeholder="Enter grade" type="text" />';
                    echo '<input class="form-control" id="komentar" placeholder="Enter comment" type="text" />';

                    echo ' <button class="ocjenjenaVoznja" name="'. $poljeBezKom[$i][7] .'">Grade this drive!</button>';
                    echo '</div>';
               }
              echo "</div></div>";

        }
        // ispisujemo izbrisane voznje, korisnik treba kliknuti da je procitao poruku
        if (count($poljeIzbris) > 0) { ?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">DRIVES THAT ARE CANCELED</div>
                <div class="card-body">

        <?php   for ($i = 0; $i < count($poljeIzbris); ++$i) {
                    $phpdate = strtotime($poljeIzbris[$i][3]);
                    $phpdate = date( 'd M Y', $phpdate );
                    echo '<div class="form-group">';
                    echo 'Driver: <a href="' . __SITE_URL . '/index.php?rt=otherUser&name=' .   $poljeIzbris[$i][0] . '">' .    $poljeIzbris[$i][0] . '</a>';
                    echo ", from " . $poljeIzbris[$i][1] . "   to " . $poljeIzbris[$i][2]. ",  on " . $phpdate
                    . ",  at " . $poljeIzbris[$i][4] . " till " . $poljeIzbris[$i][5] . ",  costs " . $poljeIzbris[$i][6] .  "kn";
                    echo ' <button class= "procitanaPoruka" name="' . $poljeIzbris[$i][7] . '" >Read the message</button>';
                    echo '</div>';

               }
              echo "</div></div>";
        }

    ?>


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
