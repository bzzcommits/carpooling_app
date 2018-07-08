<?php

class userController extends BaseController
{
	public function index() {
		$us = new UserService;
		$user_id =$us->getIdByUsername($_SESSION['username']);

		if ($us->isDriver($user_id) === true){
			$this->registry->template->driver = true;
			$this->registry->template->car = $us->getCarInfo($user_id);
			$this->registry->template->poljeKomentara = $us->getComments($user_id);
			$this->registry->template->poljeMojihVoznji = $us->getMyDrives($user_id);
			$this->registry->template->poljeProslihVoznji = $us->historyOfDrives($user_id);
		}
		else
			$this->registry->template->driver = false;

		$this->registry->template->poljePratitelja = $us->getFollowers($user_id);
		$this->registry->template->poljePracenih = $us->getFollowing($user_id);
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


	// Ovdje se mijenjaju dimenzije slike na zadane dimenzije.
	public function resizeImage($sourceImage,$sourceImageWidth,$sourceImageHeight) {
		$resizeWidth = 220; $resizeHeight = 250;
		$destinationImage = imagecreatetruecolor($resizeWidth,$resizeHeight);
		imagecopyresampled($destinationImage,$sourceImage,0,0,0,0,$resizeWidth,$resizeHeight,$sourceImageWidth,$sourceImageHeight);
		// Ovo ispod mijenja boju pozadine slike u bijelu, ali ostaje crni obrub oko slike nakon toga pa ipak ne koristim.
		// $white = imagecolorallocate($destinationImage, 255, 255, 255);
		// imagefill($destinationImage, 0, 0, $white);
		return $destinationImage;
	}

	public function updateImage() {
		$us = new UserService;

		$errorMsg = array();
		if(isset($_POST["uploadNew"])) {
			$target_dir = "user_images/" . $_SESSION['username'];
			if (!file_exists($target_dir )){
	    		mkdir($target_dir, 0777, true);
			}
			//print_r($_FILES);
			$target_file = $target_dir . "/" . basename($_FILES["imageToUpload"]["name"]);
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			$errorMsg = array();
			$uploadOk = 0;
			$image = $_FILES["imageToUpload"]["tmp_name"];
			$imageProperties = getimagesize($image);

	    	if($imageProperties === false)
	      		$errorMsg[] = "Sorry, file is not an image.";

			// Postoji li slika s istim imenom na RP2 serveru?
			else if (file_exists($target_file))
				$errorMsg[] = "Sorry, file already exists.";

			// Provjeri veličinu.
			else if ($_FILES["imageToUpload"]["size"] > 1000000)
				$errorMsg[] = "Sorry, your file is too large.";

			// Dozvoli ove formate slike.
			else if( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
				$errorMsg[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed." . $imageFileType;
			else
				$uploadOk = 1;

			// Resizeanje slike.
			if ($uploadOk === 1) {
				$sourceImageWidth = $imageProperties[0];
				$sourceImageHeight = $imageProperties[1];

				// move_uploaded_file($imageLayer, $target_file); <-> imagejpeg($imageLayer,$target_file);
				switch ($imageFileType){
					case "jpg":
					 $image = imagecreatefromjpeg($image);
					 $image = $this->resizeImage($image,$sourceImageWidth,$sourceImageHeight);
					 imagejpeg($image,$target_file);
					 break;
					case "jpeg":
					 $image = imagecreatefromjpeg($image);
					 $image = $this->resizeImage($image,$sourceImageWidth,$sourceImageHeight);
					 imagejpeg($image,$target_file);
					 break;
					case "gif":
					 $image = imagecreatefromgif($image);
					 $image = $this->resizeImage($image,$sourceImageWidth,$sourceImageHeight);
					 imagegif($image,$target_file);
					 break;
					case "png":
					 $image = imagecreatefrompng($image);
					 $image = $this->resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight);
					 imagepng($image,$target_file);
					 break;
				}

				$imagename = basename( $_FILES["imageToUpload"]["name"]);
				if ( $us->changeImage( $_SESSION['username'], $imagename ) === false ){
					$errorMsg[] = "Error while updating image name.";
					$this->registry->template->errorMsgs = $errorMsg;
				}
				//else
					//userController::index();
			}
			else{
				$this->registry->template->errorMsgs = $errorMsg;
				//echo "</br>" . $errorMsg;
			}
		}
		else if (isset($_POST["deleteImage"])){
			$imageName = $us->deleteImage( $_SESSION['username'] );
			if ($imageName  === false ) {
				$errorMsg[] = "Error while deleting image name.";
				$this->registry->template->errorMsgs =  $errorMsg;
				//echo "</br>" . $errorMsg;
			}
			else{
				unlink("user_images/" . $_SESSION['username'] . "/" . $imageName);
				//userController::index();
			}
		}
		userController::index();
	}


	public function becomeADriver() {
		$this->registry->template->show( 'new_driver' );
	}

	public function updateDriverInfo() {

		$us = new UserService;
		$user_id =$us->getIdByUsername($_SESSION['username']);

		if ( isset($_POST['saveChange']) ) {
			$flag = 0;
			$errorMsg = array();
			if ( isset($_POST['CarType']) && $_POST['CarType'] !== "" ){
				$car_type = $_POST['CarType'];
				$flag += 1;
			}
			else {
				$errorMsg[] = "You have to enter the car type";
			}

			if ( isset($_POST['CarModel']) && $_POST['CarModel'] !=="" ){
				$car_model = $_POST['CarModel'];
				$flag += 1;
			}
			else {
				$errorMsg[] = "You have to enter the car model";
			}

			if ($flag === 2)
				$us->newDriver($car_type, $car_model);

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

		$id_voznje = (int) $_POST['idVoznje'];
		$ocjena = (int) $_POST['ocjena'];
		$komentar = $_POST['komentar'];

		$us = new UserService;
		$us->insertComment( $id_voznje, $ocjena, $komentar );

		$message = [];
		userController::sendJSONandExit( $message );
	}


	public function sendJSONandExit( $message ) {
		  header( 'Content-type:application/json;charset=utf-8' );
		  echo json_encode( $message );
		  flush();
		  //exit( 0 );
	}

	public function follow(){
		$us = new UserService;
		$us->startFollowing($_GET['name']);
		header( 'Location: ' . __SITE_URL . '/index.php?rt=otherUser&name=' . $_GET['name'] );
	}

	public function unfollow(){
		$us = new UserService;
		$us->stopFollowing($_GET['name']);
		header( 'Location: ' . __SITE_URL . '/index.php?rt=otherUser&name=' . $_GET['name'] );
	}
};

?>
