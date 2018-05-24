<?php require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/upperRightCorner.php';
require_once __SITE_PATH . '/view/menu.php';

if ($resDrive == null)
{
  echo "<p>Nema raspoloživih vožnji.</p>";
}
else {
    ?>
    <table>
    	<tr><th>Username</th><th>Start place</th><th>End place</th><th>Price</th><th>Number of available seats</th></tr>
    	<?php
    foreach( $resDrive as $x )
		 {
			    echo '<tr>' .
			     '<td>' . $x->username . '</td>' .
           '<td>' . $x->start_time . '</td>' .
           '<td>' . $x->end_time . '</td>' .
           '<td>' . $x->price . '</td>' .
			     '<td>' . $x->place_number. '</td>' .
			     '</tr>';
		 }
  }

	?>
</table>

<!--

<button type="submit" name="back" id="back">Back!</button>

-->
<?php
require_once __SITE_PATH . '/view/message.php';
require_once __SITE_PATH . '/view/_footer.php';
?>
