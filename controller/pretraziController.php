<?php

class PretraziController extends BaseController
{
	public function index()
	{
		$this->registry->template->show( 'drive_index' );
	}

	public function offers()
	{
		$this->registry->template->show( 'drive_offer' );
	}

	public function searchResults()
	{
		$ls = new CarService();

		// Ako nam forma nije u $_POST poslala podatke u ispravnom obliku, preusmjeri ponovno na formu.
		if( !isset( $_POST['start_place'] ) || !preg_match( '/^[a-zA-Z -]+$/', $_POST['start_place'] )
		 		|| !isset( $_POST['end_place'] ) || !preg_match( '/^[a-zA-Z -]+$/', $_POST['end_place'] )
				|| !isset( $_POST['date'] ) || !preg_match( '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST['date']))
		{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=pretrazi/index' );
			exit();
		}
		if (isset($_POST['back'])) $this->registry->template->show( 'drive_index' );

		//dodala sam ovo da mogu ispisivati u naslov tablice - Ema
		$_SESSION['start_place'] = $_POST['start_place'];
		$_SESSION['end_place'] = $_POST['end_place'];
		$_SESSION['date'] = $_POST['date'];

		$this->registry->template->resDrive = $ls->searchDrive( strtolower($_POST['start_place']), strtolower($_POST['end_place']), $_POST['date'], $_POST['sort']);
		$this->registry->template->show( 'drive_search' );
	}


	public function rezerviraj()
	{
		$ls = new CarService();
		$this->registry->template->resDrive = $ls->reserveDrive($_POST['rezervacija']);
		$this->registry->template->show( 'drive_index' );
	}

	  public function newOffer(){

		 // provjeriti, trebalo bi mozda napraviti bolji preg_match, tako da na prvom mj
		 // mora biti barem 1 slovo, ne moze poceti razmakom ili crticom
		 //i mozda bi trebalo napraviti da aplikacija nije case sensitive za pretragu i unos,
		 // npr ja cu unositi sve s malim slovima, pa pretrazivati sve s malim

		 //preg match za date uzeti u obzir veljacu i 30 i 31 dan
		 //preg match za vrijeme uzeti 00, 01, 02, .. 09, 10, 11, 12, .. 19, 20, 21, 22, ..

		 if ( !isset( $_POST['start_place_new'] ) || !preg_match( '/^[a-zA-Z -]+$/', $_POST['start_place_new'] )
			 || !isset( $_POST['end_place_new'] ) || !preg_match( '/^[a-zA-Z -]+$/', $_POST['end_place_new'] )
			 || !isset( $_POST['date_new'] ) || !preg_match( '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST['date_new'] ) //|| !preg_match( '/^20[1-9][0-9]-((((0[13578])|(1[02]))-((0[1-9])|([12][0-9])|(3[0-1])))|((0[469]|11)-((0[1-9])|([12][0-9])|30))|(02-((0[1-9])|([12][0-9])))))$/', $_POST['date_new'] )
			 || !isset( $_POST['start_time_new'] ) || !preg_match( '/^(([0-1][0-9])|(2[0-3])):[0-5][0-9]$/', $_POST['start_time_new'] )
			 || !isset( $_POST['end_time_new'] ) || !preg_match( '/^(([0-1][0-9])|(2[0-3])):[0-5][0-9]$/', $_POST['end_time_new'] )
			 || !isset( $_POST['price_new'] ) || !preg_match( '/^[1-9][0-9]*$/', $_POST['price_new'] )
			 || !isset( $_POST['seats_new'] ) || !preg_match( '/^[1-9][0-9]*$/', $_POST['seats_new'] ) )
		{
			//$message = "Unos nije bio dobar, molimo poku�ajte ponovno. ";
			//provjeriti je li message globalna, kako joj se pristupa
			// i provjeriti hoce li trebati promijeniti header, kad se izmijeni stranica Drive
			echo 'Unos nije bio dobar.. ';
			header( 'Location: ' . __SITE_URL . '/index.php?rt=pretrazi/index' );
			exit();
		}
        
		$drive = new Drive( $_SESSION['user_id'], $_POST['start_place_new'],
							$_POST['end_place_new'], $_POST['date_new'], $_POST['start_time_new'],
							$_POST['end_time_new'], $_POST['price_new'],
							$_POST['seats_new'], $_SESSION['username'], null, null);

		$car = new CarService();

		$this->registry->template->newDrive = $car->offerDrive( $drive );
		$this->registry->template->show( 'drive_index' );
	 }
};

?>
