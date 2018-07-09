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
        <button id="search_drive" class="btn btn-primary btn-block">Search for a drive</button>
      </div>
      <div class="col-md-6">
        <button id="offer_drive" class="btn btn-primary btn-block">Offer drive</button>
      </div>
    </div>
  </div>

    <div class="card card-register mx-auto mt-5">
      <div class="card-body">
    		<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=pretrazi/searchResults">
    			<div class="form-group">
    				<label for="StartPlace">Start</label>
    				<input class="form-control" id="StartPlace" type="text" placeholder="Enter start place" name="start_place" />
    			</div>

    			<div class="form-group">
    				<label for="EndPlace">Destination</label>
    				<input class="form-control" id="EndPlace" type="text" placeholder="Enter destination" name="end_place" />
    			</div>

    			<div class="form-group">
    				<label for="Date">Date (yyyy-mm-dd)</label>
    				<input class="form-control" id="Date" type="text" placeholder="Enter date" name="date" />
    			</div>

          Sorted by
          <select name="sort" id="sort">
            <option value="price">price</option>
            <option value="rating">rating</option>
          </select> <br/><br/>

    			<button type="submit" name="search" class="btn btn-primary btn-block">Search</button>
    		</form>
      </div>
	</div>

  <?php
  //require_once __SITE_PATH . '/view/drive_search.php';
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
<script src="<?php echo __SITE_URL;?>/js/skripta2.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvLGiyFyIoKmyEGYIfDWk-IxAxq2zvfwA&libraries=places&callback=initMap">
</script>
