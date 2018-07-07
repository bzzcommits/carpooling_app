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
                - posebno ocjene + komentar
                        ( za nas projekt, stavimo da ispise sve ocjene, buduci da ih nece biti puno;
                          inace, mogle bi staviti da ispise samo zadnjih 10 ocjena, pa da user moze sam kliknuti da mu izbaci jos komentare
                          -> ovisi ako stignemo) */
	public function index()
	{

		$username = $_GET['name'];

		$us = new UserService;
		$user_id =$us->getIdByUsername($username);

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
