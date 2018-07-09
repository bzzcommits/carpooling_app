
		<!-- promijeniti href !! -->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Contact">
          <a class="nav-link" href="<?php echo __SITE_URL; ?>/index.php?rt=contact">
            <i class="fa fa-info-circle"></i>
            <span id="contact" class="nav-link-text">Contact</span>
          </a>
        </li>

	  </ul>
		<!-- tipka za sakriti menu, ostaviti samo ikone, treba napraviti js
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          id="sidenavToggler" 
          <a class="nav-link text-center" id="sakrijMenu">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul> -->

      <?php
	  require_once __SITE_PATH . '/view/upperRightCorner.php';
	  ?>

    </div>
  </nav>
