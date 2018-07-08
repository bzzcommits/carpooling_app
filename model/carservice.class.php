<?php

class CarService
{
	function searchDrive( $start_place, $end_place, $date, $sort)
	{
		if ($_POST['sort'] === 'price')
		{
			try
			{

				$db = DB::getConnection();
				$st = $db->prepare( 'SELECT drive.driver_id, drive.start_place, drive.end_place, drive.`date`, drive.start_time,
					drive.end_time, drive.price, drive.place_number, users.username, drive.drive_id
					FROM drive, drivers, users
					WHERE drive.driver_id=drivers.driver_id AND drive.driver_id=users.id AND drive.start_place=:start_place AND drive.end_place=:end_place AND drive.`date`=:date_
					ORDER BY drive.price');

				$st->execute( array( 'start_place' => $start_place, 'end_place' => $end_place, 'date_' => $date) );
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		}
		else
		{
			try
			{

				$db = DB::getConnection();
				$st = $db->prepare( 'SELECT drive.driver_id, drive.start_place, drive.end_place, drive.`date`, drive.start_time,
					drive.end_time, drive.price, drive.place_number, users.username, drive.drive_id
					FROM drive, drivers, users
					WHERE drive.driver_id=drivers.driver_id AND drive.driver_id=users.id AND drive.start_place=:start_place AND drive.end_place=:end_place AND drive.`date`=:date_
					ORDER BY drivers.realrating DESC');

				$st->execute( array( 'start_place' => $start_place, 'end_place' => $end_place, 'date_' => $date ) );
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
		}
		if ( $st->rowCount() === 0 ) return null;
		$arr = array();
		foreach ( $st->fetchAll() as $row )
		{
            try
			{

				$db = DB::getConnection();
				$st1 = $db->prepare( 'SELECT realrating
                    FROM drivers
					WHERE driver_id = :id');

				$st1->execute( array( 'id' => $row['driver_id'] ) );
			}
			catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }
            $rr = $st1->fetch();
            if ( $rr['realrating'] == 0 )
                $rating = "not rated yet";
            else
                $rating = (float)$rr['realrating'];
			$arr[] = new Drive( $row['driver_id'], $row['start_place'], $row['end_place'], $row['date'], $row['start_time'], $row['end_time'],
							    $row['price'], $row['place_number'], $row['username'], $rating, $row['drive_id'] );
		}
		return $arr;
	}

	function reserveDrive ($drive_id)
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO ratings(drive_id, user_id, comment, rating)
								VALUES (:drive_id, :user_id, "nema", -1)' );
			$st->execute( array( 'drive_id' => $drive_id, 'user_id' => $_SESSION['user_id']) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error ' . $e->getMessage() );
		}
	}

	//tu cemo unositi nove voznju
	function offerDrive ( $drive )
	{	//drive_id napraviti da se automatski povećava
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO drive(driver_id, start_place, end_place, ' .
								'`date`, start_time, end_time, price, place_number) VALUES ' .
								' (:dr_id, :place1, :place2, :datum, :time1, :time2, :price, :seats)' );
			$st->execute( array( 'dr_id' => $drive->driver_id,
								 'place1' => strtolower($drive->start_place),
								 'place2' => strtolower($drive->end_place),
								 'datum' => $drive->date,
								 'time1' => $drive->start_time,
								 'time2' => $drive->end_time,
								 'price' => $drive->price,
								 'seats' => $drive->place_number) );
		}
		catch( PDOException $e )
		{
			exit( 'PDO error ' . $e->getMessage() );
		}
	}

}
