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
    public static function get_registered_crops_attachments() {
		
		$image_subsizes = array_keys( wp_get_registered_image_subsizes() );
		
		return $image_subsizes;
		
	}

}