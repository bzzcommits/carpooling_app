<?php

class User
{
  protected $id, $username, $year, $telephone, $mail;

	function __construct( $id, $username, $year, $telephone, $mail, $image )
	{
		$this->id = $id;
		$this->username = $username;
    $this->year = $year;
    $this->telephone = $telephone;
    $this->mail = $mail;
    $this->image = $image;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

 ?>
