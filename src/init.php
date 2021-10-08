<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function intermedia_events_carousel_cgb_block_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'intermedia_events_carousel-cgb-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ), // Dependency to include the CSS after it.
		null
	);

	// Register block editor script for backend.
	wp_register_script(
		'intermedia_events_carousel-cgb-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		null,
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'intermedia_events_carousel-cgb-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'intermedia_events_carousel-cgb-block-js',
		'iceGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
			'imgCrops' => IntermediaBlockCarouselEvents::get_registered_crops_attachments()
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	$block = json_decode(
		file_get_contents( __DIR__ . '/block/block.json' ), // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		true
	);
	register_block_type(
		'cgb/block-intermedia-display-events', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'intermedia_events_carousel-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'intermedia_events_carousel-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'intermedia_events_carousel-cgb-block-editor-css',
			// Callback function for the dynamic block front-end
			'render_callback' => 'render_intermedia_events_carousel',
			'attributes'      => $block['attributes'],
		)
	);
}

// Hook: Block assets.
add_action( 'init', 'intermedia_events_carousel_cgb_block_assets' );

function events_frontend_scripts() {
    
    if ( has_block( 'cgb/block-intermedia-display-events' ) ) {

        wp_enqueue_style(
                'owl.carousel.min',
                plugins_url( 'dist/assets/owl.carousel.min.css', dirname( __FILE__ ) )
        );

        wp_enqueue_style(
                'owl.theme.default.min',
                plugins_url( 'dist/assets/owl.theme.default.min.css', dirname( __FILE__ ) )
        );
        
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', plugins_url( 'dist/assets/jquery.min.js', dirname( __FILE__ ) ), false, NULL, false );
        wp_enqueue_script( 'jquery' );
        
        wp_enqueue_script(
                'owl.carousel.min',
                plugins_url( 'dist/assets/owl.carousel.min.js', dirname( __FILE__ ) ),
                '', '', true
        );

    }
        
}
add_action( 'wp_enqueue_scripts', 'events_frontend_scripts' );

//enqueue latest jQuery on the back end
function enqueue_scripts_back_end(){
	wp_register_script( 'jquery', plugins_url( 'dist/assets/jquery.min.js', dirname( __FILE__ ) ), false, NULL, true );
}
add_action('admin_enqueue_scripts','enqueue_scripts_back_end');

function events_admin_scripts() {

        wp_enqueue_style(
                'owl.carousel.min',
                plugins_url( 'dist/assets/owl.carousel.min.css', dirname( __FILE__ ) )
        );

        wp_enqueue_style(
                'owl.theme.default.min',
                plugins_url( 'dist/assets/owl.theme.default.min.css', dirname( __FILE__ ) )
        );

        wp_enqueue_script(
                'owl.carousel.min',
                plugins_url( 'dist/assets/owl.carousel.min.js', dirname( __FILE__ ) ),
                '', '', true
		);
		
}
add_action( 'admin_enqueue_scripts', 'events_admin_scripts' );

require_once( __DIR__ . '/block/block.php');
