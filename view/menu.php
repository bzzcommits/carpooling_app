<!--
<nav>
  <ul>
    <li><a href="<?php //echo __SITE_URL; ?>/index.php?rt=home">Home</a></li>
    <li><a href="<?php //echo __SITE_URL; ?>/index.php?rt=pretrazi">Pretraži</a></li>
    <li><a href="<?php //echo __SITE_URL; ?>/index.php?rt=profil">Profil</a></li>
  </ul>
</nav>
-->
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav" >
    <div class="collapse navbar-collapse" id="navbarResponsive">
	
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
	  
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=home">
            <i class="fa fa-home" aria-hidden="true"></i>
            <span class="nav-link-text">Home</span>
          </a>
        </li>
		
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Profile">
          <a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=user">
            <i class="fa fa-user-circle"></i>
            <span class="nav-link-text">Profile</span>
          </a>
        </li>
		
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Drive">
          <a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=pretrazi">
            <i class="fa fa-car" aria-hidden="true"></i>
            <span class="nav-link-text">Drive</span>
          </a>
        </li>
        
		<!-- promijeniti href !! -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Contact">
          <a class="nav-link" href="">
            <i class="fa fa-info-circle"></i>
            <span class="nav-link-text">Contact</span>
          </a>
        </li>
		
	  </ul>
		<!-- tipka za sakriti menu, ostaviti samo ikone, treba napraviti js -->
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>  
	  
      <?php
	  require_once __SITE_PATH . '/view/upperRightCorner.php';
	  ?>
	  
    </div>
  </nav>
