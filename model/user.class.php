<?php

class User
{
  protected $id, $username, $year, $telephone, $mail;

	function __construct( $id, $username, $year, $telephone, $mail )
	{
		$this->id = $id;
		$this->username = $username;
    $this->year = $year;
    $this->telephone = $telephone;
    $this->mail = $mail;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

 ?>
