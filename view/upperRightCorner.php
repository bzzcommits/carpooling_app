<?php
if( isset( $_SESSION[ 'username' ] ) )
{
  echo "<h1>" . $_SESSION[ 'username' ] . "</h1>" . 
  "<h3><a href=\"". __SITE_URL ."/index.php?rt=home/logout\">logout</a></h3>";
}
else
{
  echo "<h3><a href=\"". __SITE_URL ."/index.php?rt=home/login\">Log in</a></h3>" .
  "<h3><a href=\"". __SITE_URL ."/index.php?rt=home/signup\">Sign up</a></h3>";
}
?>

<!--
  <form method="post" action="?php echo __SITE_URL; ?>/index.php?rt=home/login">
    <button type="submit" name="login">Log in!</button>
  </form>
  <form method="post" action="?php echo __SITE_URL; ?>/index.php?rt=home/signup">
    <button type="submit" name="signup">Sign up!</button>
  </form>
-->
