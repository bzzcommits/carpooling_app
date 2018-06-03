<?php

class userController extends BaseController
{
	/*Kod ucitavanja Profile stranice, ispisuju se podaci iz baze
	  Ako je vozac, ispisuju se dodatne stvari.

	  Treba dodati:
	  -> funkcije koje su na kraju file-a

	*/

	public function index() {

		$us = new UserService;
		$user_id =$us->getIdByUsername($_SESSION['username']);

		if ($us->isDriver($user_id) === true){
			$this->registry->template->driver = true;
			$this->registry->template->car = $us->getCarInfo($user_id);
			$this->registry->template->poljeKomentara = $us->getComments($user_id);
			$this->registry->template->poljeMojihVoznji = $us->getMyDrives($user_id);
		}
		else
			$this->registry->template->driver = false;

		$this->registry->template->poljeRez = $us->getReservationsAndNoComment($user_id);
		$this->registry->template->user = $us->getProfileInfo($_SESSION['username']);
		$this->registry->template->show( 'profile_index' );

	}


	public function changeUserInfo() {
		$this->registry->template->show( 'profile_update' );
	}
	public function updateUserInfo() {

		$us = new UserService;
		$user_id =$us->getIdByUsername($_SESSION['username']);

		if ( isset($_POST['saveChange']) ) {
			$errorMsg = array();
			if ( isset($_POST['changeUsername']) && $_POST['changeUsername'] !== "" ){
				if ( $us->changeUsername($_SESSION['username'] ) === false ) {
					$errorMsg[] = "This username is already taken";
				}
			}
			if ( isset($_POST['changeYear']) && $_POST['changeYear'] !=="" ){
				if ( $us->changeYear(  $_SESSION['username'] ) === false ) {
					$errorMsg[] = "Error in updating the Year";
				}
			}
			if ( isset($_POST['changeTelephone']) && $_POST['changeTelephone'] !=="" ){
				if ( $us->changeTelephone( $_SESSION['username'] ) === false ) {
					$errorMsg[] = "Error in updating the Telephone";
				}
			}
			if ( isset($_POST['changeMail']) && $_POST['changeMail'] !=="" ){
				if ( $us->changeMail( $_SESSION['username'] ) === false ) {
					$errorMsg[] = "Error in updating the E-Mail";
				}
			}
			if ( isset($_POST['changeCarType']) && $_POST['changeCarType'] !=="" ){
				if ( $us->changeCarType(  $user_id ) === false ) {
					$errorMsg[] = "Error in updating the car type";
				}
			}
			if ( isset($_POST['changeCarModel']) && $_POST['changeCarModel'] !=="" ){
				if ( $us->changeCarModel(  $user_id ) === false ) {
					$errorMsg[] = "Error in updating the car model";
				}
			}
			$this->registry->template->errorMsgs = $errorMsg;
		}

		userController::index();
	}





	/*FUNKCIJE KOJE JOS TREBA NAPISATI*/

	// korisnik otkazuje neku nadolazecu voznju (klikom na gumb u profile_index.php)
	public function otkazanaRezervacija () {

		// tijelo funkcije
		userController::index();

	}

	// vozac otkazuje neku svoju voznju (klikom na gumb u profile_index.php)
	public function otkazanaVoznja() {

		// tijelo funkcije
		userController::index();
	}

	// korisnik je procitao poruku o nekoj voznji koju je imao rezerviranu, a vozac ju je otkazao (klikom na gumb u profile_index.php)
	//	-> treba obrisati pripadni redak iz tablice
	public function procitanaPoruka() {

		// tijelo funkcije
		userController::index();
	}

	// korisnik je na svojoj stranici unio komentar i ocjenu za neku voznju (klikom na gumb u profile_index.php)
	public function unesenKomentar () {

		// tijelo funkcije
		userController::index();
	}
};

?>
