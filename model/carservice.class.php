<?php

class CarService
{

	function getUsernameFromId ( $id_driver )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT username FROM users WHERE id=:id_driver');
			$st->execute( array( 'id_driver' => $id_driver ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$row = $st->fetch();
		if( $row === false )
			return null;
		else
			return $row['username'] ;
	}

	function searchDrive( $start_place, $end_place, $date )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT driver_id, start_place, end_place, `date`, start_time, end_time, price, place_number FROM drive WHERE start_place=:start_place AND end_place=:end_place AND `date`=:date_' );
			$st->execute( array( 'start_place' => $start_place, 'end_place' => $end_place, 'date_' => $date ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		if ($st->rowCount() === 0) return null;
		$arr = array();
		while ($row = $st->fetch())
		{

			$username = $this->getUsernameFromId ($row['driver_id']);
			$arr[] = new Drive( $row['driver_id'], $row['start_place'], $row['end_place'], $row['date'], $row['start_time'], $row['end_time'], $row['price'], $row['place_number'], $username );
		}
		return $arr;
	}
	//tu cemo unositi nove voznju
	function offerDrive ( $drive )
	{
		try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'INSERT INTO drive(driver_id, start_place, end_place, ' . 
								'`date`, start_time, end_time, price, place_number) VALUES ' . 
								' (:dr_id, :place1, :place2, :datum, :time1, :time2, :price, :seats)' );
			$st->execute( array( 'dr_id' => $_SESSION['id_user'], 
								 'place1' => $drive->start_place, 
								 'place2' => $drive->end_place, 
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
