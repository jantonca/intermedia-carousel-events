<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function render_intermedia_events_carousel (  $attributes ) {

    //Initializing Block
    $block= new IntermediaBlockCarouselEvents( $attributes );

    if (!isset($attributes['EventsToDisplay'])):  
        $EventsToDisplay = 10;
    else:
        $EventsToDisplay =  $attributes['EventsToDisplay'];
    endif;
    $args_events = array(
        'posts_per_page' => $EventsToDisplay,
        'start_date' => 'today',
    );
    if ( isset($attributes['catSlugEvent']) && $attributes['catSlugEvent'] !=='') {
        $args_events['tax_query'] = array(
            array(
                'taxonomy' => 'tribe_events_cat',
                'field'    => 'slug',
                'terms'    => explode(",", preg_replace("/\s+/", "", $attributes['catSlugEvent'])),
            )
        );
    }
    // The Query
    $events_query = tribe_get_events( $args_events, $full = true );

    if ( !isset( $attributes['breakpointOne'] ) ):

        $attributes['breakpointOne'] = '0';

    endif;

    $classes_carousel = isset( $attributes['className'] ) ? $attributes['className'] : '';

    ob_start(); // Turn on output buffering
    /* BEGIN HTML OUTPUT */
    ?>

    <script>
        
        jQuery(document).ready(function() {

            "use strict";
            
            $('.owl-carousel').owlCarousel( {

                <?php if ( !empty( $attributes['loop'] ) ): ?>loop: <?php echo wp_json_encode( $attributes['loop'] ).','; endif; ?>
                <?php if ( !empty( $attributes['owlItemMargin'] ) ): ?>margin: <?php echo wp_json_encode( $attributes['owlItemMargin'] ).','; endif; ?>
                <?php if ( !empty( $attributes['autoHeight'] ) ): ?>autoHeight: <?php echo wp_json_encode( $attributes['autoHeight'] ).','; endif; ?>
                <?php if ( !empty( $attributes['center'] ) ): ?>center: <?php echo wp_json_encode( $attributes['center'] ).','; endif; ?>
                <?php if ( !empty( $attributes['autoplay'] ) ): ?>autoplay: <?php echo wp_json_encode( $attributes['autoplay'] ).','; endif; ?>
                <?php if ( !empty( $attributes['autoplayTimeout'] ) ): ?>autoplayTimeout: <?php echo wp_json_encode( $attributes['autoplayTimeout'] ).','; endif; ?>
                <?php if ( !empty( $attributes['autoplayHoverPause'] ) ): ?>autoplayHoverPause: <?php echo wp_json_encode( $attributes['autoplayHoverPause'] ).','; endif; ?>
                <?php if ( !empty( $attributes['responsiveClass'] ) ): ?>responsiveClass: <?php echo wp_json_encode( $attributes['responsiveClass'] ).','; endif; ?>
                responsive: {
                        <?php echo wp_json_encode( $attributes['breakpointOne'] ).':'; ?> {
                        <?php if ( isset( $attributes['breakpointOneItems'] ) ): ?>items: <?php echo wp_json_encode( $attributes['breakpointOneItems'] ).','; endif; ?>
                        <?php if ( !empty( $attributes['breakpointOneNav'] ) ): ?>nav: <?php echo wp_json_encode( $attributes['breakpointOneNav'] ).','; endif; ?>
                        <?php if ( !empty( $attributes['breakpointOneLoop'] ) ): ?>loop: <?php echo wp_json_encode( $attributes['breakpointOneLoop'] ); endif; ?>
                    },
                    <?php if ( isset($attributes['breakpointTwo'] ) ): ?><?php echo wp_json_encode( $attributes['breakpointTwo'] ).':'; ?> {
                        <?php if ( isset( $attributes['breakpointTwoItems'] ) ): ?>items: <?php echo wp_json_encode( $attributes['breakpointTwoItems'] ).','; endif; ?>
                        <?php if ( !empty( $attributes['breakpointTwoNav'] ) ): ?>nav: <?php echo wp_json_encode( $attributes['breakpointTwoNav'] ).','; endif; ?>
                        <?php if ( !empty( $attributes['breakpointTwoLoop'] ) ): ?>loop: <?php echo wp_json_encode( $attributes['breakpointTwoLoop'] ); endif; ?>
                    },<?php endif; ?>
                    <?php if ( isset( $attributes['breakpointThree'] ) ): ?><?php echo wp_json_encode( $attributes['breakpointThree'] ).':'; ?> {
                        <?php if ( isset( $attributes['breakpointThreeItems'] ) ): ?>items: <?php echo wp_json_encode( $attributes['breakpointThreeItems'] ).','; endif; ?>
                        <?php if ( !empty( $attributes['breakpointThreeNav'] ) ): ?>nav: <?php echo wp_json_encode( $attributes['breakpointThreeNav'] ).','; endif; ?>
                        <?php if ( !empty( $attributes['breakpointThreeLoop'] ) ): ?>loop: <?php echo wp_json_encode( $attributes['breakpointThreeLoop']); endif; ?>
                    }<?php endif; ?>
                }

            } );

        } );
    
    </script>
    
    <div class="<?php echo esc_attr( $classes_carousel ); ?>" >
        <div class="owl-carousel owl-theme">
   
        <!-- events here -->
        <!-- the loop -->
        <?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>

            <?php $featured_img_url = get_the_post_thumbnail_url( get_the_ID(),'full' );  ?>
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
