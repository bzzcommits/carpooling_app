<?php

class UserService
{
	/* Funkcija koja vraca informacije o korisniku s korisnickim imenom $username
			-> za trenutnog korisnika pozivamo sa $_SESSION['username'] */
	function getProfileInfo ( $username ) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id, year, telephone, mail, image FROM users WHERE username LIKE :username');
			$st->execute( array('username' => $username) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function  getProfileInfo:  ' . $e->getMessage() );
		}

		$row = $st->fetch();
		$info = new User($row['id'], $username, $row['year'], $row['telephone'],  $row['mail'], $row['image']);
		return $info;
	}

	function getYear ( $username ) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT year FROM users WHERE username LIKE :username');
			$st->execute( array('username' => $username) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getYear:  ' . $e->getMessage() );
		}

		$row = $st->fetch();
		$year = $row['year'];

		return $year;
	}
	function getTelephone ( $username ) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT telephone FROM users WHERE username LIKE :username');
			$st->execute( array('username' => $username) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getTelephone:  ' . $e->getMessage() );
		}

		$row = $st->fetch();
		$telephone = $row['telephone'];

		return $telephone;
	}
	function getMail ( $username ) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT mail FROM users WHERE username LIKE :username');
			$st->execute( array('username' => $username) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getMail:  ' . $e->getMessage() );
		}

		$row = $st->fetch();
		$mail = $row['mail'];

		return $mail;
	}


	/* Funkcija koja za zadani $id, vrati $username ( i jedna koja radi obratno)
			-> nisam sigurna da ce nam ovo trebati (moguce za komentare + ocjene), ali zasad nek ostane tu */
	function getUsernameById ( $id ) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT username FROM users WHERE id LIKE :id');
			$st->execute( array('id' => $id) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getUsernameById:  ' . $e->getMessage() );
		}

		$row = $st->fetch();
		$username = $row['username'];
		return $username;
	}
	function getIdByUsername ( $username ) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id FROM users WHERE username LIKE :username');
			$st->execute( array('username' => $username) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getIdByUsername:  ' . $e->getMessage() );
		}

		$row = $st->fetch();
		$id = $row['id'];
		return $id;
	}

	/* Slijede funkcije koje vracaju promjene u bazi posebno year, telephone, mail trenutno logiranog korisnika.
		   - koriste se kod promjene podataka na osobnom profilu trenutno logiranog korisnika
		   - vraca false ako je username zauzet, true u suprotnom
	   Buduci da ce se ionako pozivati kao: changeUsername($_SESSION['username']), mozemo promijeniti da f-je ne primaju argumente*/
	function changeUsername ( $username ) {
		// prvo provjerimo je li novo korisnicko ime zauzeto
		$newUsername = $_POST['changeUsername'];
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT id FROM users WHERE username LIKE :username');
			$st->execute( array('username' => $newUsername) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function changeUsername:  ' . $e->getMessage() );
		}
		$row = $st->fetch();
		if( $row !== false ) {
			return false;
		}
		// novi username nije zauzet -> ubacujemo ga u bazu
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('UPDATE users SET username=:newusername WHERE username=:username');
			$st->execute( array('newusername'=>$newUsername, 'username' => $username) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function changeUsername:  ' . $e->getMessage() );
		}
		// na kraju moramo jos promijeniti username u $_SESSION
		$_SESSION['username'] = $newUsername;

		return true;

	}
	function changeYear ( $username ) {
		$newYear = $_POST['changeYear'];
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('UPDATE users SET year=:newYear WHERE username=:username');
			$st->execute( array('newYear'=>$newYear, 'username' => $username) );
		}
		catch( PDOException $e )
		{
			return false;
			//exit( 'PDO error in class UserService function changeYear:  ' . $e->getMessage() );
		}
		return true;
	}
	function changeTelephone ( $username ) {
		$newTelephone = $_POST['changeTelephone'];
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('UPDATE users SET telephone=:newTelephone WHERE username=:username');
			$st->execute( array('newTelephone'=>$newTelephone, 'username' => $username) );
		}
		catch( PDOException $e )
		{
			return false;
			//exit( 'PDO error in class UserService function changeTelephone:  ' . $e->getMessage() );
		}
		return true;
	}
	function changeMail ( $username ) {
		$newMail = $_POST['changeMail'];
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('UPDATE users SET mail=:newMail WHERE username=:username');
			$st->execute( array('newMail'=>$newMail, 'username' => $username) );
		}
		catch( PDOException $e )
		{
			return false;
			//exit( 'PDO error in class UserService function changeMail:  ' . $e->getMessage() );
		}
		return true;
	}

	/*Za zadani username vraca je li vozac (true) ili nije (false)
		-> treba nam da znamo da li moramo ispisati komentare i ocjene*/
	function isDriver($id) {
		// provjerimo nalazi li se taj id u vozacima
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT driver_id FROM drivers WHERE driver_id LIKE :id');
			$st->execute( array('id' => $id) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function isDriver:  ' . $e->getMessage() );
		}
		$row = $st->fetch();
		if ($row === false)
			return false;
		else
			return true;
	}


	function getCarInfo ( $id ) {
  		try
  		{
  			$db = DB::getConnection();
  			$st = $db->prepare('SELECT car_type, car_model, rating FROM drivers WHERE driver_id LIKE :id');
  			$st->execute( array('id' => $id) );
  		}
  		catch( PDOException $e )
  		{
  			exit( 'PDO error in class UserService function  getCarInfo:  ' . $e->getMessage() );
  		}

  		$row = $st->fetch();
  		$car = new Car($row['car_type'], $row['car_model'], $row['rating']);
  		return $car;
  	}

	/*Mozemo (ne moramo) promijeniti: da controller prvo dobije id pomocu getIdByUsername, pa onda s
	  tim id-om zove ove gettere i "settere", da se ne kopira nepotrebno kod gdje se prvo pomocu
	  username-a uzima id*/
	/*NAPOMENA: nisam na pocetku skuzila da pamtimo id u sessionu, pa sam svugdje slala id.
				Nije greska, ali se radi nepotreban posao.
				(Anastasija)*/
	function getCarType($id){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT car_type FROM drivers WHERE driver_id LIKE :id');
			$st->execute( array('id' => $id) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getCarType:  ' . $e->getMessage() );
		}
		$row = $st->fetch();
		$car_type = $row['car_type'];
		return $car_type;
	}
	function getCarModel($id){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT car_model FROM drivers WHERE driver_id LIKE :id');
			$st->execute( array('id' => $id) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getCarModel:  ' . $e->getMessage() );
		}
		$row = $st->fetch();
		$car_model = $row['car_model'];
		return $car_model;
	}
	function getRating($id){
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT rating FROM drivers WHERE driver_id LIKE :id');
			$st->execute( array('id' => $id) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getCarModel:  ' . $e->getMessage() );
		}
		$row = $st->fetch();
		$rating = $row['rating'];
		return $rating;
	}

	function changeCarType($id) {
		$newCarType = $_POST['changeCarType'];
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('UPDATE drivers SET car_type=:newCarType WHERE driver_id=:driver_id');
			$st->execute( array('newCarType'=>$newCarType, 'driver_id' => $id) );
		}
		catch( PDOException $e )
		{
			return false;
			//exit( 'PDO error in class UserService function changeCarType:  ' . $e->getMessage() );
		}
		return true;
	}
	function changeCarModel($id) {
		$newCarModel = $_POST['changeCarModel'];
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('UPDATE drivers SET car_model=:newCarModel WHERE driver_id=:driver_id');
			$st->execute( array('newCarModel'=>$newCarModel, 'driver_id' => $id) );
		}
		catch( PDOException $e )
		{
			return false;
			//exit( 'PDO error in class UserService function changeCarModel:  ' . $e->getMessage() );
		}
		return true;
	}

	function changeImage($username, $image) {
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('UPDATE users SET image=:image WHERE username=:username');
			$st->execute( array('image'=>$image, 'username' => $username) );
		}
		catch( PDOException $e )
		{
			return false;
			//exit( 'PDO error in class UserService function changeImage:  ' . $e->getMessage() );
		}
		return true;
	}

	function deleteImage($username){
		try
		{
			$db = DB::getConnection();
			$st1 = $db->prepare('SELECT image FROM users WHERE username=:username');
			$st2 = $db->prepare('UPDATE users SET image="" WHERE username=:username');
			$st1->execute( array('username' => $username) );
			$st2->execute( array('username' => $username) );
		}
		catch( PDOException $e )
		{
			return false;
			exit( 'PDO error in class UserService function deleteImage:  ' . $e->getMessage() );
		}
		$row = $st1->fetch();
		$imageName = $row['image'];
		return $imageName;
	}

	function getComments($id) {
		// prvo nademo sve voznje ovog korisnika (koje su vec prosle)
		$trenutniDatum = date("Y-m-d");	// trenutni datum i vrijeme
		$trenutnoVrijeme = date("H:i");
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT drive_id FROM drive WHERE driver_id=:id
					    AND date<:trenutnidatum1
					    OR (date=:trenutnidatum2 AND end_time<:trenutnoVrijeme)');
			$st->execute( array('id' => $id, 'trenutnidatum1'=> $trenutniDatum,
					    'trenutnidatum2'=> $trenutniDatum, 'trenutnoVrijeme' => $trenutnoVrijeme) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getComments (id-voznji):  ' . $e->getMessage() );
		}

		$poljeId = array();
		foreach( $st->fetchAll() as $row ){
			$poljeId[] = $row['drive_id'];
		}
		$poljeKomentara = array();
		for ($i = 0; $i < count($poljeId); ++$i) {
			// nakon toga, za svaku voznju spremimo ocjenu+komentar+username -> vracamo to polje (objekata klase Comments iz user.class.php)
			try
			{
				$db = DB::getConnection();
				$st = $db->prepare('SELECT user_id, comment, rating FROM ratings WHERE drive_id=:drive_id');
				$st->execute( array('drive_id' => $poljeId[$i]) );
			}
			catch( PDOException $e )
			{
				exit( 'PDO error in class UserService function getComments:  ' . $e->getMessage() );
			}
			foreach( $st->fetchAll() as $row ){
				$tempKom = array();
				$tempKom[] = UserService::getUsernameById($row['user_id']);
				$tempKom[] = $row['comment'];
				$tempKom[] = $row['rating'];
				$poljeKomentara[] = $tempKom;
			}
		}
		return $poljeKomentara;
	}

	function getReservationsAndNoComment($id) {
		// nadi sve voznje_id, gdje nije postavljena ocjena
		// -> ako se voznja nalazi u tablici deleted_drive, spremi ga u polje poruka koje korisnik mora procitati
		// -> ako je datum voznje prosao, spremi ga u polje voznji koje vozac jos nije ocijenio
		// -> ako datum voznje jos nije prosao, znaci da je to trenutno rezervirana voznja
		// Dakle, voznje cemo spremati u tri polja.
		// kao povratnu vrijednost, f-ja salje polje koje se sastoji od ta tri polja.
		// u viewu cemo ispisat sve tri: i rezervacije i voznje bez komentara i otkazane voznje
		$trenutniDatum = date("Y-m-d");	// trenutni datum i vrijeme
		$trenutnoVrijeme = date("H:i");

		// nadi sve id-jeve iz deleted_drive
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT drive_id FROM deleted_drive');
			$st->execute();
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getReservations:  ' . $e->getMessage() );
		}
		$izbrisaniElementi = array();
		foreach( $st->fetchAll() as $row )
			$izbrisaniElementi[] = $row['drive_id'];

		// nadi sve voznje bez ratinga koje je ovaj vozac prijavio
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT drive_id FROM ratings WHERE user_id LIKE :id AND rating LIKE :rating');
			$st->execute( array('id' => $id, 'rating' => "") );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getReservations:  ' . $e->getMessage() );
		}

		$poljeIzbrisanih = array();
		$poljeRezerviranih = array();
		$poljeBezKomentara = array();

		foreach( $st->fetchAll() as $row ) {
			if ( in_array($row['drive_id'], $izbrisaniElementi) ){
				// izvuci podatke iz tablice izbrisanih
				try
				{
					$db = DB::getConnection();
					$st = $db->prepare('SELECT drive_id, driver_id, start_place, end_place, date, start_time, end_time, price FROM deleted_drive WHERE drive_id LIKE :id');
					$st->execute( array('id' => $row['drive_id']) );
				}
				catch( PDOException $e )
				{
					exit( 'PDO error in class UserService function getReservations:  ' . $e->getMessage() );
				}
				$row2 = $st->fetch();
				$username = UserService::getUsernameById($row2['driver_id']);
				$voznja = array ($username, $row2['start_place'], $row2['end_place'], $row2['date'], $row2['start_time'], $row2['end_time'], $row2['price'], $row2['drive_id']);
				$poljeIzbrisanih[] = $voznja;
			}
			else{
				try
				{
					$db = DB::getConnection();
					$st1 = $db->prepare('SELECT drive_id, driver_id, start_place, end_place, date, start_time, end_time, price FROM drive WHERE drive_id LIKE :id');
					$st1->execute( array('id' => $row['drive_id']) );
				}
				catch( PDOException $e )
				{
					exit( 'PDO error in class UserService function getReservations:  ' . $e->getMessage() );
				}
				$row1 = $st1->fetch();
				$username = UserService::getUsernameById($row1['driver_id']);

				$voznja = array ($username, $row1['start_place'], $row1['end_place'], $row1['date'], $row1['start_time'], $row1['end_time'], $row1['price'], $row1['drive_id']);
				if ($trenutniDatum > $row1['date'] || ($trenutniDatum === $row1['date'] && $trenutnoVrijeme > $row1['vrijeme']))
					$poljeBezKomentara[] = $voznja;
				else
					$poljeRezerviranih[] = $voznja;
			}
		}
		$polje = array ($poljeRezerviranih, $poljeBezKomentara, $poljeIzbrisanih);
		return $polje;
	}

	// vraca nadolazece voznje
	function getMyDrives($id) {
		$trenutniDatum = date("Y-m-d");	// trenutni datum i vrijeme
		$trenutnoVrijeme = date("H:i");
		$poljeVoznji = array();

		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT drive_id, start_place, end_place, date, start_time, end_time, price FROM drive WHERE driver_id=:id
					    AND date>:trendatum1
					    OR (date=:trendatum2 AND start_time>:trenvrijeme)');
			$st->execute( array('id' => $id, 'trendatum1' => $trenutniDatum, 'trendatum2' => $trenutniDatum, 'trenvrijeme' => $trenutnoVrijeme) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function getMyDrives:  ' . $e->getMessage() );
		}
		foreach($st->fetchAll() as $row) {
			// pronadi koliko je ljudi vec rezerviralo
			try
			{
				$db = DB::getConnection();
				$st1 = $db->prepare('SELECT user_id FROM ratings  WHERE drive_id LIKE :id');	// alt. upit-> grupna f-ja mysql (count?)
				$st1->execute( array('id' => $row['drive_id']) );
			}
			catch( PDOException $e )
			{
				exit( 'PDO error in class UserService function getMyDrives:  ' . $e->getMessage() );
			}
			$broj = 0;
			foreach($st1->fetchAll() as $row1)
				++$broj;

			$voznja = array ($row['start_place'], $row['end_place'], $row['date'], $row['start_time'], $row['end_time'], $row['price'], $broj, $row['drive_id']);
			$poljeVoznji[] = $voznja;
		}

		return $poljeVoznji;
	}

	function deleteReservation($id_voznje) {
		$id = UserService::getIdByUsername($_SESSION['username']);
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('DELETE FROM ratings WHERE drive_id LIKE :drive_id AND user_id LIKE :user_id');
			$st->execute( array('drive_id' => $id_voznje, 'user_id' => $id) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function deleteReservation:  ' . $e->getMessage() );
		}
	}

	function deleteDrive($id_voznje) {
		// preseli voznju $id_voznje iz drive u deleted_drive

		// izvadi voznju iz drive
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT start_place, end_place, date, start_time, end_time, price FROM drive WHERE drive_id LIKE :drive_id');
			$st->execute( array('drive_id' => $id_voznje, ) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function deleteDrive:  ' . $e->getMessage() );
		}
		$row = $st->fetch();
		$voznja = array ($row['start_place'], $row['end_place'], $row['date'], $row['start_time'], $row['end_time'], $row['price']);

		//obrisi voznju u drive
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('DELETE FROM drive WHERE drive_id LIKE :drive_id');
			$st->execute( array('drive_id' => $id_voznje) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function deleteDrive:  ' . $e->getMessage() );
		}

		// ubaci voznju u deleted_drive
		try{
			$st = $db->prepare( 'INSERT INTO deleted_drive (drive_id, driver_id, start_place, end_place, date, start_time, end_time, price)
								 VALUES (:drive_id, :driver_id, :startp, :endp, :date, :startt, :endt, :price)' );
			$st->execute( array( 'drive_id' => $id_voznje,
								 'driver_id' => UserService::getIdByUsername($_SESSION['username']),
								 'startp' => $voznja[0],
								 'endp' => $voznja[1],
								 'date' => $voznja[2],
								 'startt' => $voznja[3],
								 'endt' => $voznja[4],
								 'price' => $voznja[5]) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function deleteDrive:  ' . $e->getMessage() );
		}

	}

	function deleteRating($id_voznje) {
		// izbrisi redak iz ratingsa
		$id = UserService::getIdByUsername($_SESSION['username']);
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('DELETE FROM ratings WHERE drive_id LIKE :drive_id AND user_id LIKE :user_id');
			$st->execute( array('drive_id' => $id_voznje, 'user_id' => $id) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function deleteRating:  ' . $e->getMessage() );
		}

		// + ako nema vise te voznje u ratingsima, izbrisi iz deleted
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare('SELECT drive_id FROM ratings WHERE drive_id LIKE :drive_id');
			$st->execute( array('drive_id' => $id_voznje) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error in class UserService function deleteRating:  ' . $e->getMessage() );
		}
		$row = $st->fetch();
		if ( $row === false ) {
			try
			{
				$db = DB::getConnection();
				$st = $db->prepare('DELETE FROM deleted_drive WHERE drive_id LIKE :drive_id');
				$st->execute( array('drive_id' => $id_voznje) );
			}
			catch( PDOException $e )
			{
				exit( 'PDO error in class UserService function deleteRating:  ' . $e->getMessage() );
			}

		}
	}
};
?>
