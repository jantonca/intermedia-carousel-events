<?php
/**
 * Plugin Name: Intermedia Events Carousel
 * Plugin URI: https://www.intermedia.com.au/
 * Description: Display Tribe events in a carousel.
 * Author: Jose Anton
 * Author URI: https://www.intermedia.com.au/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (!function_exists('self_deactivate_plugin')) {
    
    function self_deactivate_plugin (){
        
        //Plugins
        $plugin_a = '../the-events-calendar/the-events-calendar.php';
        $plugin_b = '../intermedia-carousel-events/plugin.php';

        // check for plugin using plugin name
        if ( !is_plugin_active( $plugin_a ) ) {
            $category_error = true;
        } else {
            $category_error = false;
        }
        if ( $category_error ) {
            deactivate_plugins($plugin_b);
        }
    }
    
    //add_action( 'init', 'self_deactivate_plugin' );
    
}

if ( !function_exists('intermedia_events_carousel_activate') ) {
    
    function intermedia_events_carousel_activate ( $network_wide ) {

        //Plugin path
        $plugin_a = 'the-events-calendar/the-events-calendar.php';

        // check for plugin using plugin name
        if ( !is_plugin_active( $plugin_a ) ) {
            $category_error = true;
        } else {
            $category_error = false;
        }
        
        if ( $category_error ) {

            echo '<h3>'.__('Please install The Events Calendar plugin by Tribe Events before activating. <a target="_blank" href="https://wordpress.org/plugins/the-events-calendar/">Here is the link!</a>', 'ap').'</h3>';

            //Adding @ before will prevent XDebug output
            @trigger_error(__('Please install The Events Calendar plugin by Tribe Events before activating.', 'ap'), E_USER_ERROR);
            
        }
        
    }
    register_activation_hook(__FILE__, 'intermedia_events_carousel_activate');
    
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';

require_once plugin_dir_path( __FILE__ ) . '/src/includes/class-carousel-block.php';
