<?php require_once __SITE_PATH . '/view/_header.php';
require_once __SITE_PATH . '/view/upperRightCorner.php';
require_once __SITE_PATH . '/view/menu.php';
?>

<form method="post" action="<?php echo __SITE_URL; ?>/index.php?rt=pretrazi/searchResults">
	Start:
	<input type="text" name="start_place" /> <br/>
  Destionation:
  <input type="text" name="end_place" /> <br />
  Date (yyyy-mm-dd):
  <input type="text" name="date" /> <br/>

	<button type="submit">Traži</button>
</form>

<?php
require_once __SITE_PATH . '/view/message.php';
require_once __SITE_PATH . '/view/_footer.php';
?>
