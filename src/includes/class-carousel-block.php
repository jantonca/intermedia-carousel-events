<?php

class IntermediaBlockCarouselEvents {

    // Properties
    public $attributes;

    function __construct( $attributes ) {

        foreach ( $attributes as $attribute => $value ) {

            if ( $value !== '' ) {

                $this->$attribute = $value;

            }

        }
	}

}