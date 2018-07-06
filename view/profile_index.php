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
        - voznje koje jos nisu ocijenili
                - treba dodati formu u koju upise ocjenu, komentar i gumb (TO JOS TREBA)
        + poruke koje javljaju o otkazivanju rezervirane voznje
                - dodati gumb koji se klikne nakon sto korisnik procita*/
?>

 <title> Profile </title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<?php
require_once __SITE_PATH . '/view/menu.php';
?>

  <div class="content-wrapper">

	<!-- OVDJE IDE SLIKA-->

	<div class="card card-register mx-auto mt-5">
	<div class="card-header">Profile</div>
        <div class="card-body">
                <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=user/changeUserInfo">
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
        		<button type="submit" name="changeUserInfo" class="btn btn-primary btn-block">Change Profile Info!</button>
                </form>
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

        // ispisujemo komentare i ocjene
        if ($driver === true) { ?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">COMMENTS ABOUT THIS USER</div>
                <div class="card-body">

        <?php   for ($i = 0; $i < count($poljeKomentara); ++$i) {
                        echo '<div class="form-group">';
                        echo "user: " . $poljeKomentara[$i][0] . ",      rating: " . $poljeKomentara[$i][2] . ",      comment: " . $poljeKomentara[$i][1];
                        echo '</div>';
           }
          echo "</div></div>";
          // ispisujemo (buduce) voznje ovog vozaca
          if ( count($poljeMojihVoznji) > 0) {?>
                  <div class="card card-register mx-auto mt-5">
                  <div class="card-header">YOUR FUTURE DRIVES</div>
                  <div class="card-body">
          <?php  for ($i = 0; $i < count($poljeMojihVoznji); ++$i) {
                  echo '<div class="form-group">';
                  echo "From " . $poljeMojihVoznji[$i][0] . "   to: " . $poljeMojihVoznji[$i][1]. "  on: " . $poljeMojihVoznji[$i][2]
                  . "  at: " . $poljeMojihVoznji[$i][3] . " till: " . $poljeMojihVoznji[$i][4] . "  costs: " . $poljeMojihVoznji[$i][5] .  "   no. of reservations: "
                  . $poljeMojihVoznji[$i][6];
                  echo ' <button class= "otkaziVoznju" name="' . $poljeMojihVoznji[$i][7] . '" >Delete this ride</button>';
                  echo '</div>';
             }
            echo "</div></div>";
          }

        }


        $poljeRezerv = $poljeRez[0];
        $poljeBezKom = $poljeRez[1];
        $poljeIzbris = $poljeRez[2];

        // ispisujemo rezervirane voznje
        if (count($poljeRezerv) > 0) { ?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">YOUR RESERVATIONS</div>
                <div class="card-body">

        <?php   for ($i = 0; $i < count($poljeRezerv); ++$i) {
                    echo '<div class="form-group">';
                    echo 'Driver: ' . $poljeRezerv[$i][0] . ", from " . $poljeRezerv[$i][1] . "   to: " . $poljeRezerv[$i][2]
                    . "  on: " . $poljeRezerv[$i][3] . "  at: " . $poljeRezerv[$i][4] . " costs: " . $poljeRezerv[$i][6];
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
                    echo '<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=user/unesenKomentar">';
                        echo '<div class="form-group">';
                        echo 'Driver: ' . $poljeBezKom[$i][0] . ", from " . $poljeBezKom[$i][1] . "   to: " . $poljeBezKom[$i][2]
                        . "  on: " . $poljeBezKom[$i][3] . "  at: " . $poljeBezKom[$i][4] . " costs: " . $poljeBezKom[$i][6];

                        echo '<input class="form-control" class="unesiOcjenu" placeholder="Enter grade" type="text" name="'.$poljeBezKom[$i][7] .'" />';
                        echo '<input class="form-control" class="unesiKomentar" placeholder="Enter comment" type="text" name="'.$poljeBezKom[$i][7] .'" />';

                        echo ' <button class= "ocjenjenaVoznja" name="' . $poljeBezKom[$i][7] . '" >Grade this drive!</button>';
                        echo '</div>';
                    echo '</form>';
               }
              echo "</div></div>";

        }
        // ispisujemo izbrisane voznje, korisnik treba kliknuti da je procitao poruku
        if (count($poljeIzbris) > 0) { ?>
                <div class="card card-register mx-auto mt-5">
                <div class="card-header">DRIVES THAT ARE CANCELED</div>
                <div class="card-body">

        <?php   for ($i = 0; $i < count($poljeIzbris); ++$i) {
                    echo '<div class="form-group">';
                    echo 'Driver: ' . $poljeIzbris[$i][0] . ", from " . $poljeIzbris[$i][1] . "   to: " . $poljeIzbris[$i][2]
                    . "  on: " . $poljeIzbris[$i][3] . "  at: " . $poljeIzbris[$i][4] . " costs: " . $poljeIzbris[$i][6];
                    echo ' <button class= "procitanaPoruka" name="' . $poljeIzbris[$i][7] . '" >Read the message</button>';
                    echo '</div>';
               }
              echo "</div></div>";
        }

    ?>


<script>
$(document).ready( function()
{
    $( "body" ).on( "click", "button.otkaziRezervaciju", otkaziRezervaciju );
    $( "body" ).on( "click", "button.otkaziVoznju", otkaziVoznju );
    $( "body" ).on( "click", "button.procitanaPoruka", procitanaPoruka );
});
function otkaziRezervaciju(event) {
    var ret = confirm("Are you sure you want to delete this reservation?");
    if (ret === true) {
        var gumb = $(this);
        var ime = gumb.prop("name");
        $.ajax(
            {
                url: window.location.pathname + "?rt=user/otkazanaRezervacija",
                data: { idVoznje: ime},
                type: 'POST',
        		dataType: "json",
    			success: function( data )
    			{
                    window.location.reload(false);
                    //console.log("uspjesno izbrisana rezervacija");
    			}
            }
        );
    }
}

function otkaziVoznju(event) {
    var ret = confirm("Are you sure you want to delete this drive?");
    if (ret === true) {
        var gumb = $(this);
        var ime = gumb.prop("name");
        $.ajax(
            {
                url: window.location.pathname + "?rt=user/otkazanaVoznja",
                data: { idVoznje: ime},
                type: 'POST',
        		dataType: "json",
    			success: function( data )
    			{
                    window.location.reload(false);
                    //console.log("uspjesno izbrisana voznja");
    			}
            }
        );
    }
}

function procitanaPoruka(event) {
    alert("The driver canceled this drive!");

    var gumb = $(this);
    var ime = gumb.prop("name");
    $.ajax(
        {
            url: window.location.pathname + "?rt=user/procitanaPoruka",
            data: { idVoznje: ime},
            type: 'POST',
    		dataType: "json",
			success: function( data )
			{
                window.location.reload(false);
                console.log("uspjesno procitana poruka");
			}
        }
    );

}
</script>

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
