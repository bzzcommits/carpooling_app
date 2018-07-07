
<?php
require_once __SITE_PATH . '/view/_header.php';
?>

<!--
<form method="post" action="<?php //echo __SITE_URL; ?>/index.php?rt=pretrazi/searchResults">
	Start:
	<input type="text" name="start_place" /> <br/>
  Destionation:
  <input type="text" name="end_place" /> <br />
  Date (yyyy-mm-dd):
  <input type="text" name="date" /> <br/>

	<button type="submit">Traži</button>
</form>
-->

  <title> Drive </title>

</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <?php
  require_once __SITE_PATH . '/view/menu.php';
  require_once __SITE_PATH . '/view/menuForLogged.php';
  require_once __SITE_PATH . '/view/menuTheRest.php';
  ?>

  <div class="content-wrapper">

	<div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
				<!-- pomocu js napraviti da je taj kliknut prilikom ucitavanja stranice -->
                <button name="search_drive" class="btn btn-primary btn-block">Search for a drive</button>
              </div>
              <div class="col-md-6">
                <button name="offer_drive" class="btn btn-primary btn-block">Offer drive</button>
              </div>
            </div>
          </div>

<?php
//if ( !isset($resDrive) )
	//return;
if ($resDrive == null || !isset($resDrive))
{
  echo "<p>There are no available drives.</p> <br/>";
 ?>
 <form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=pretrazi/searchResults">
	 <button type="submit" name="back" class="btn btn-primary btn-block">Back</button>
 </form>
 <?php
}
else {
    ?>
	<div class="content-wrapper">
	<div class="container-fluid">
	<div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>
		  <?php echo $_SESSION['start_place'] . " - " . $_SESSION['end_place'] . ". "; ?>
		  All drives on day <?php echo $_SESSION['date'] . ". ";?>
		</div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Userame</th>
                  <th>Rating</th>
                  <th>Start time</th>
                  <th>ETA</th>
                  <th>Price</th>
                  <th>Number of available seats</th>
									<th>Reservation</th>
                </tr>
              </thead>
              <tbody>

				<?php
					foreach( $resDrive as $x ){
						echo '<tr>' .
							 '<td>' . $x->username . '</td>' .
               '<td>' . $x->rating . '</td>' .
						   '<td>' . $x->start_time . '</td>' .
						   '<td>' . $x->end_time . '</td>' .
						   '<td>' . $x->price . '</td>' .
						   '<td>' . $x->place_number. '</td>' .
							'<td> <form method="post" action="' . __SITE_URL . '/index.php?rt=pretrazi/rezerviraj">
		 							<button type="submit" name="rezervacija" value="' . $x->drive_id . '" class="btn btn-primary btn-block">Reserve now!</button>
		 						</form> </td>' .
							 '</tr>';
				    }
				?>

              </tbody>
            </table>

						<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=pretrazi/searchResults">
							<button type="submit" name="back" class="btn btn-primary btn-block">Back</button>
						</form>

          </div>
        </div>
      </div>
    </div>
</div>
<?php
}
?>

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
