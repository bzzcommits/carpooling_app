<?php

class userController extends BaseController
{
	/*
	  Treba dodati:
	  -> funkcije koje su na kraju file-a
	*/

	public function index() {

		echo "username: " . $_SESSION['username'];
		echo "     user_id: " . $_SESSION['user_id'];


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






	// korisnik otkazuje neku nadolazecu voznju (klikom na gumb u profile_index.php)
	public function otkazanaRezervacija () {
		// izbrisati redak iz ratingsa (jer jedino tu pamtimo rezervacije)
		$id_voznje = (int) $_POST['idVoznje'];

		$us = new UserService;
		$us->deleteReservation( $id_voznje );

		// ne treba nista poslat
		$message = [];
		userController::sendJSONandExit( $message );
	}

	// vozac otkazuje neku svoju voznju (klikom na gumb u profile_index.php)
	public function otkazanaVoznja() {
		$id_voznje = (int) $_POST['idVoznje'];

		$us = new UserService;
		$us->deleteDrive( $id_voznje );

		// ne treba nista poslat
		$message = [];
		userController::sendJSONandExit( $message );
	}

	// korisnik je procitao poruku o nekoj voznji koju je imao rezerviranu, a vozac ju je otkazao (klikom na gumb u profile_index.php)
	public function procitanaPoruka() {

		$id_voznje = (int) $_POST['idVoznje'];

		$us = new UserService;
		$us->deleteRating( $id_voznje );

		// ne treba nista poslat
		$message = [];
		userController::sendJSONandExit( $message );
	}

	// korisnik je na svojoj stranici unio komentar i ocjenu za neku voznju (klikom na gumb u profile_index.php)
	public function unesenKomentar () {

		// tijelo funkcije
		userController::index();
	}


	public function sendJSONandExit( $message ) {
		  header( 'Content-type:application/json;charset=utf-8' );
		  echo json_encode( $message );
		  flush();
		  //exit( 0 );
	}
};

?>
