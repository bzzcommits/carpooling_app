<?php

class Car{
        protected $car_type, $car_model, $rating;

        function __construct( $car_type, $car_model, $rating )
	{
		$this->car_type = $car_type;
		$this->car_model = $car_model;
		$this->rating = $rating;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}
?>
