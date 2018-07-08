<?php
/*
	Controller koji je zaduzen za view: other_profile_index.php
        Samo ispisuje podatke o tom drugom korisniku.
*/

class otherUserController extends BaseController
{
	/*Ovo je jedina funkcija.
          Sprema osobne podatke drugog username-a.
          Ako je taj username i vozac, sprema i:
                - ukupnu ocjenu
                - posebno ocjene + komentar */
	public function index()
	{
		$username = $_GET['name'];
		if ( $username === $_SESSION['username'] )
			header( 'Location: ' . __SITE_URL . '/index.php?rt=user' );

		$us = new UserService;
		$user_id =$us->getIdByUsername($username);

		// Kako bih znala trebam li ispisati Follow ili Unfollow button.
		$this->registry->template->follow = $us->checkIfFollowing($_GET['name']);

		if ($us->isDriver($user_id) === true){
			$this->registry->template->driver = true;
			$this->registry->template->car = $us->getCarInfo($user_id);
			$this->registry->template->poljeKomentara = $us->getComments($user_id);
			$this->registry->template->poljeProslihVoznji = $us->historyOfDrives($user_id);
			$this->registry->template->poljeMojihVoznji = $us->getMyDrives($user_id);
		}
		else
			$this->registry->template->driver = false;

		$this->registry->template->user = $us->getProfileInfo($username);
		$this->registry->template->show( 'other_profile_index' );

	}

};

?>
