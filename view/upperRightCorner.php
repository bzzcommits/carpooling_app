<?php
if( isset( $_SESSION[ 'username' ] ) )
{
	//echo "<h1>" . $_SESSION[ 'username' ] . "</h1>";
  ?>
  <ul class="navbar-nav ml-auto">        
        
	<li class="nav-item">
	  <a id="lgout" class="nav-link" href="<?php echo __SITE_URL; ?> /index.php?rt=home">
		<i class="fa fa-fw fa-sign-out"></i> Logout </a>
	</li>
  </ul>
  
  <?php
  //echo "<h3><a id='lgout' href=\"". __SITE_URL ."/index.php?rt=home/logout\">logout</a></h3>";
}
else
{
  //echo "<h3><a href=\"". __SITE_URL ."/index.php?rt=home/login\">Log in</a></h3>" .
  //"<h3><a href=\"". __SITE_URL ."/index.php?rt=home/signup\">Sign up</a></h3>";
  ?>
	<ul class="navbar-nav ml-auto">
	
		<li class="nav-item">
		  <a class="nav-link" href="<?php echo __SITE_URL; ?> /index.php?rt=home/login">
			<i class="fa fa-sign-in"></i> Log in </a>
		</li>
		
		<li class="nav-item">
		  <a id="lgout" class="nav-link" href="<?php echo __SITE_URL; ?> /index.php?rt=home/signup">
			<i class="fa fa-user-plus"></i> Sign up </a>
		</li>

	</ul>
  <?php
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
