<?php

class AuthenticationService{
  function validateUser( $username, $password )
  {
    try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT * FROM users WHERE username = :username' );
      $st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    if( ! $row = $st->fetch() )
      return 0;

    if( !password_verify( $password, $row['password_hash'] ) )
      return -1;

    if( $row['has_registered'] !== '1' )
      return -2;

    $user = new User( $row['id'], $row['username'], $row['year'], $row['telephone'], $row['mail'], $row['image'] );
    return $user;
  }

  function signupUser( $username, $password, $email )
  {
		$db = DB::getConnection();

    try
		{
			$st = $db->prepare( 'SELECT * FROM users WHERE username = :username OR mail = :email' );
			$st->execute( array( 'username' => $username, 'email' => $email ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

    if( $st->rowCount() !== 0 )
      return 0;

    $reg_seq = '';
		for( $i = 0; $i < 20; ++$i )
			$reg_seq .= chr( rand(0, 25) + ord( 'a' ) );

    try
		{
			$st = $db->prepare( 'INSERT INTO users VALUES( DEFAULT, :username, :password, NULL, NULL, :mail, :reg_seq, 0)' );
			$st->execute( array( 'username' => $username,
				                 'password' => password_hash( $password, PASSWORD_DEFAULT ),
				                 'mail' => $email,
				                 'reg_seq'  => $reg_seq ) );
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }


    // Sad mu još pošalji mail
		$to       = $email;
		$subject  = 'Registracijski mail';
		$message  = 'Poštovani ' . $username . "!\nZa dovršetak registracije kliknite na sljedeći link: ";
		$message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/index.php?rt=home&niz=' . $reg_seq . "\n";
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		            'X-Mailer: PHP/' . phpversion();

		$isOK = mail($to, $subject, $message, $headers);

		if( !$isOK )
			return -1;

    return 1;
  }

  function registerUser( $registration_sequence )
  {
    $db = DB::getConnection();

    try
    {
      $st = $db->prepare( 'SELECT * FROM users WHERE registration_sequence = :registration_sequence' );
      $st->execute( array( 'registration_sequence' => $registration_sequence ) );
    }
    catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }

    $row = $st->fetch();

    if( $st->rowCount() !== 1 )
      return false;

    else
    {
      try
      {
        $st = $db->prepare( 'UPDATE users SET has_registered=1 WHERE registration_sequence = :registration_sequence' );
        $st->execute( array( 'registration_sequence' => $registration_sequence ) );
      }
      catch( PDOException $e ) { exit( 'Greška u bazi: ' . $e->getMessage() ); }
    }
    return true;
  }
};

 ?>
