<?php
require_once __SITE_PATH . '/view/_header.php';
?>

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
        <button id="search_drive" class="btn btn-primary btn-block">Search for a drive</button>
      </div>
      <div class="col-md-6">
        <button id="offer_drive" class="btn btn-primary btn-block">Offer drive</button>
      </div>
    </div>
  </div>

	 <div class="card card-register mx-auto mt-5">
    <div class="card-body">
	<!-- promijeniti action !! -->
		<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=pretrazi/newoffer">
			<div class="form-group">
				<label for="StartPlaceNew">Start</label>
				<input class="form-control" id="StartPlaceNew" type="text" placeholder="Enter start place" name="start_place_new" />
			</div>

			<div class="form-group">
				<label for="EndPlaceNew">Destination</label>
				<input class="form-control" id="EndPlaceNew" type="text" placeholder="Enter destination" name="end_place_new" />
			</div>

			<div class="form-group">
				<label for="DateNew">Date (yyyy-mm-dd)</label>
				<input class="form-control" id="DateNew" type="text" placeholder="Enter date" name="date_new" />
			</div>

			<div class="form-group">
				<label for="TimeStartNew">Starting time (hh:mm)</label>
				<input class="form-control" id="TimeStartNew" type="text" placeholder="Enter starting time" name="start_time_new" />
			</div>

			<div class="form-group">
				<label for="TimeEndNew">Estimated time of arrival (hh:mm)</label>
				<input class="form-control" id="TimeEndNew" type="text" placeholder="Enter estimated time of arriving" name="end_time_new" />
			</div>

			<div class="form-group">
				<label for="PriceNew">Price </label>
				<input class="form-control" id="PriceNew" type="text" placeholder="Enter price" name="price_new" />
			</div>

			<div class="form-group">
				<label for="SeatsNew">Number of available seats</label>
				<input class="form-control" id="SeatsNew" type="text" placeholder="Enter number" name="seats_new" />
			</div>

			<button type="submit" name="offer" class="btn btn-primary btn-block">Offer</button>
		</form>

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
require_once __SITE_PATH . '/view/_footer.php';
?>
<script src="<?php echo __SITE_URL;?>/js/skripta3.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvLGiyFyIoKmyEGYIfDWk-IxAxq2zvfwA&libraries=places&callback=initMap2">
</script>