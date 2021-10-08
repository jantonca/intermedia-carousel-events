<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function render_intermedia_events_carousel (  $attributes ) {

    //Initializing Block
    $block_attributes = new IntermediaBlockCarouselEvents( $attributes );

    $args_events = array(
        'posts_per_page' => $block_attributes->EventsToDisplay,
        'start_date' => 'today',
    );
    if ( isset( $block_attributes->catSlugEvent ) && $block_attributes->catSlugEvent !=='') {
        $args_events['tax_query'] = array(
            array(
                'taxonomy' => 'tribe_events_cat',
                'field'    => 'slug',
                'terms'    => explode( ",", preg_replace( "/\s+/", "", $block_attributes->catSlugEvent ) ),
            )
        );
    }
    // The Query
    $events_query = tribe_get_events( $args_events, $full = true );

    $classes_carousel = isset( $attributes['className'] ) ? $attributes['className'] : '';

    ob_start(); // Turn on output buffering
    var_dump($block_attributes);
    /* BEGIN HTML OUTPUT */
    ?>

    <script>
        
        jQuery( document ).ready( function() {

	        'use strict';

            $( '.owl-carousel' ).owlCarousel( {

                loop: <?php echo wp_json_encode( $block_attributes->loop ); ?>,
                margin: <?php echo wp_json_encode( $block_attributes->owlItemMargin ); ?>,
                autoHeight: <?php echo wp_json_encode( $block_attributes->autoHeight ); ?>,
                center: <?php echo wp_json_encode( $block_attributes->center ); ?>,
                autoplay: <?php echo wp_json_encode( $block_attributes->autoplay ); ?>,
                autoplayTimeout: <?php echo wp_json_encode( $block_attributes->autoplayTimeout ); ?>,
                autoplayHoverPause: <?php echo wp_json_encode( $block_attributes->autoplayHoverPause ); ?>,
                responsiveClass: <?php echo wp_json_encode( $block_attributes->responsiveClass ); ?>,
                responsive: {
                    <?php echo wp_json_encode( $block_attributes->breakpointOne ); ?>: {
                        items: <?php echo wp_json_encode( $block_attributes->breakpointOneItems ); ?>,
                        nav: <?php echo wp_json_encode( $block_attributes->breakpointOneNav ); ?>,
                        loop: <?php echo wp_json_encode( $block_attributes->breakpointOneLoop ); ?>,
                    },
                    <?php echo wp_json_encode( $block_attributes->breakpointTwo ); ?>: {
                        items: <?php echo wp_json_encode( $block_attributes->breakpointTwoItems ); ?>,
                        nav: <?php echo wp_json_encode( $block_attributes->breakpointTwoNav ); ?>,
                        loop: <?php echo wp_json_encode( $block_attributes->breakpointTwoLoop ); ?>,
                    },
                    <?php echo wp_json_encode( $block_attributes->breakpointThree ); ?>: {
                        items: <?php echo wp_json_encode( $block_attributes->breakpointThreeItems ); ?>,
                        nav: <?php echo wp_json_encode( $block_attributes->breakpointThreeNav ); ?>,
                        loop: <?php echo wp_json_encode( $block_attributes->breakpointThreeLoop ); ?>,
                    },
                },
                
            } );

        } );
    
    </script>
    
    <div class="<?php echo esc_attr( $classes_carousel ); ?>" >
        <div class="owl-carousel owl-theme">
   
        <!-- events here -->
        <!-- the loop -->
        <?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>

            <?php $featured_img_url = get_the_post_thumbnail_url( get_the_ID(), $block_attributes->featuredImageCrop );  ?>
            <div class="item">
                <?php if( $featured_img_url && $featured_img_url !== '' ): ?>
                <img src="<?php echo esc_url( $featured_img_url ); ?>"/>
                <?php endif; ?>
                <div class="item-data">
                    <h3>
                        <a href="<?php echo esc_url( get_permalink() ); ?>">
                            <?php echo esc_html( get_the_title() ); ?>
                        </a>
                    </h3>
                    <?php if( tribe_get_venue() && tribe_get_venue() === '' ): ?>
                    <span class="venue"><?php echo esc_html( tribe_get_venue() ) ?></span>
                    <?php endif; ?>
                    <div class="date">
                        <span class="day"><?php echo esc_html( tribe_get_start_date( get_the_ID(), false, 'd' ) ); ?></span>
                        <span class="month"><?php echo esc_html( tribe_get_start_date( get_the_ID(), false, 'M' ) ); ?></span>
                        <span class="year"><?php echo esc_html( tribe_get_start_date( get_the_ID(), false, 'Y' ) ); ?></span>
                    </div>
                    <?php if( get_the_excerpt() && get_the_excerpt() !== '' ): ?>
                    <div class="excerpt"><?php echo esc_html( get_the_excerpt() ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
                
        <?php endwhile; ?>
        <!-- end of the loop -->
    
        </div>
    </div>
    
    <?php
    
    /* END HTML OUTPUT */
    
    $output = ob_get_contents(); // collect output
    
    ob_end_clean(); // Turn off ouput buffer

    return $output; // Print output
    
}
