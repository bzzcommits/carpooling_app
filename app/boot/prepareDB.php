<!-- NEDOVRSENO -->

<?php

// Manualno inicijaliziramo bazu ako vec nije.
require_once 'db.class.php';

$db = DB::getConnection();

$has_tables = false;

try
{
	$st = $db->prepare(
		'SHOW TABLES LIKE :tblname'
	);

	$st->execute( array( 'tblname' => 'users' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'drivers' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'drive' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

	$st->execute( array( 'tblname' => 'ratings' ) );
	if( $st->rowCount() > 0 )
		$has_tables = true;

}
catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }


if( $has_tables )
{
	exit( 'Tablice users / drivers / drive / ratings vec postoje. Obrisite ih pa probajte ponovno.' );
}


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS users (' .
		'id int(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'username varchar(20) NOT NULL,' .
		'password varchar(20) NOT NULL,'.
		'year varchar(30) NOT NULL,' .
		'telephone varchar(30) NOT NULL,' .
		'mail varchar(30) NOT NULL,' .
		'registration_sequence varchar(20) NOT NULL,' .
		'has_registered int)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create users]: " . $e->getMessage() ); }

echo "Napravio tablicu users.<br />";

try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS drivers (' .
		'driver_id int(2) NOT NULL PRIMARY KEY,' .
		'car_type varchar(20) NOT NULL,' .
		'car_model varchar(20) NOT NULL,' .
		'rating int(4) NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create drivers]: " . $e->getMessage() ); }

echo "Napravio tablicu drivers.<br />";


try
{
	$st = $db->prepare(
		'CREATE TABLE IF NOT EXISTS drive (' .
		'drive_id int(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
		'driver_id int(2) NOT NULL,' .
		'quack varchar(140) NOT NULL,' .
		'date DATETIME NOT NULL)'
	);

	$st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create drive]: " . $e->getMessage() ); }

echo "Napravio tablicu drive.<br />";


// Ubaci neke korisnike unutra
try
{
	$st = $db->prepare( 'INSERT INTO dz2_users(username, password_hash, email, registration_sequence, has_registered) VALUES (:username, :password, %'a@b.com%', %'abc%', %'1%')' );

	$st->execute( array( 'username' => 'federer', 'password' => password_hash( 'mirka', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'username' => 'nadal', 'password' => password_hash( 'rafa', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'username' => 'cilic', 'password' => password_hash( 'care', PASSWORD_DEFAULT ) ) );
	$st->execute( array( 'username' => 'billgates', 'password' => password_hash( 'mirkosoft', PASSWORD_DEFAULT ) ) );
}
catch( PDOException $e ) { exit( "PDO error [insert dz2_users]: " . $e->getMessage() ); }

echo "Ubacio u tablicu dz2_users.<br />";


// Ubaci neke followere unutra (ovo nije bas pametno ovako raditi, preko hardcodiranih id-eva usera)
try
{
	$st = $db->prepare( 'INSERT INTO dz2_follows(id_user, id_followed_user) VALUES (:id1, :id2)' );

	$st->execute( array( 'id1' => '1', 'id2' => '2' ) ); // fed -> nad
	$st->execute( array( 'id1' => '2', 'id2' => '1' ) ); // nad -> fed
	$st->execute( array( 'id1' => '3', 'id2' => '1' ) ); // cil -> fed
 	$st->execute( array( 'id1' => '1', 'id2' => '4' ) ); // fed -> bil
	$st->execute( array( 'id1' => '4', 'id2' => '1' ) ); // bil -> fed
}
catch( PDOException $e ) { exit( "PDO error [dz2_follows]: " . $e->getMessage() ); }

echo "Ubacio u tablicu dz2_follows.<br />";


// Ubaci neke quackove unutra (ovo nije bas pametno ovako raditi, preko hardcodiranih id-eva usera)
try
{
	$st = $db->prepare( 'INSERT INTO dz2_quacks(id_user, quack, date) VALUES (:id_user, :quack, :date)' );

	$st->execute( array( 'id_user' => 1, 'quack' => 'Welcoming @nadal and @cilic in #Paris at #RolandGarros', 'date' => '2018-04-17 12:45:00') );
	$st->execute( array( 'id_user' => 1, 'quack' => 'Thank you for the kind words, @BillGates. Honored. #TIME', 'date' => '2018-04-19 19:23:45') );
	$st->execute( array( 'id_user' => 2, 'quack' => 'Last chance to win a trip to #Paris and meet me in person with one of your friends!', 'date' => '2018-04-25 17:45:00') );
	$st->execute( array( 'id_user' => 2, 'quack' => 'Another final in #Monaco and very happy! Better luck next year @cilic!', 'date' => '2018-04-10 12:23:00') );
	$st->execute( array( 'id_user' => 3, 'quack' => 'Congrats to @nadal! Still had a good time in #Monaco #homeawayfromhome', 'date' => '2018-04-10 12:22:45') );
	$st->execute( array( 'id_user' => 3, 'quack' => 'See you at another #Wimbledon final, @federer!', 'date' => '2018-04-10 12:32:45') );
	$st->execute( array( 'id_user' => 4, 'quack' => 'I am a big fan of @federer! Please don\'t miss #Monaco and #Paris next year!', 'date' => '2018-04-11 22:10:00') );
	$st->execute( array( 'id_user' => 4, 'quack' => 'Well done @nadal! #Monaco Good luck at #RolandGarros', 'date' => '2018-04-11 23:55:00') );
	$st->execute( array( 'id_user' => 3, 'quack' => 'I\'m sorry to share that I won\'t be playing at the #MadridOpen due to knee pains.', 'date' => '2018-04-14 12:00:05') );
	$st->execute( array( 'id_user' => 3, 'quack' => 'The best day ever! #justmarried', 'date' => '2018-04-21 12:00:00') );
}
catch( PDOException $e ) { exit( "PDO error [dz2_quacks]: " . $e->getMessage() ); }

echo "Ubacio u tablicu dz2_quacks.<br />";

?>
