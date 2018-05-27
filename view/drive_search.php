<?php 
if ( !isset($resDrive) )
	return;
elseif ($resDrive == null)
{
  echo "<p>Nema raspoloživih vožnji.</p>";
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
                  <th>Start time</th>
                  <th>ETA</th>
                  <th>Price</th>
                  <th>Number of available seats</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Userame</th>
                  <th>Start time</th>
                  <th>ETA</th>
                  <th>Price</th>
                  <th>Number of available seats</th>

                </tr>
              </tfoot>
              <tbody>
			  
				<?php
					foreach( $resDrive as $x ){
						echo '<tr>' .
							 '<td>' . $x->username . '</td>' .
						     '<td>' . $x->start_time . '</td>' .
						     '<td>' . $x->end_time . '</td>' .
						     '<td>' . $x->price . '</td>' .
						     '<td>' . $x->place_number. '</td>' .
							 '</tr>';
				    }
				?>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
<?php
}
?>