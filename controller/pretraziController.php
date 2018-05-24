<?php

class PretraziController extends BaseController
{
	public function index()
	{
		$this->registry->template->show( 'drive_index' );
	}

	public function searchResults()
	{
		$ls = new CarService();

		// Ako nam forma nije u $_POST poslala autora u ispravnom obliku, preusmjeri ponovno na formu.
		if( !isset( $_POST['start_place'] ) || !preg_match( '/^[a-zA-Z -]+$/', $_POST['start_place'] )
		 		|| !isset( $_POST['end_place'] ) || !preg_match( '/^[a-zA-Z -]+$/', $_POST['end_place'] )
				|| !isset( $_POST['date'] ) || !preg_match( '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST['date'] ))   
		{
			header( 'Location: ' . __SITE_URL . '/index.php?rt=pretrazi/index');
			exit();
		}
		//if (isset($_POST['back'])) $this->registry->template->show( 'drive_index' );

		$this->registry->template->resDrive = $ls->searchDrive( $_POST['start_place'], $_POST['end_place'], $_POST['date'] );
		$this->registry->template->show( 'drive_search' );
	}


};

?>
