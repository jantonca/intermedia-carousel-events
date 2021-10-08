/* eslint-disable jsx-a11y/alt-text */
/* eslint-disable jsx-a11y/anchor-is-valid */
/* eslint-disable react/jsx-no-comment-textnodes */
/* eslint-disable react/jsx-key */
/**
 * BLOCK: intermedia-display-events
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './editor.scss';
import './style.scss';
//Internal dependencies
import metadata from './block.json';
const { attributes } = metadata;
const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const {
	InspectorControls,
} = wp.blockEditor;
const {
	PanelBody,
	PanelRow,
	RangeControl,
	ToggleControl,
	TextControl,
	SelectControl,
} = wp.components;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'cgb/block-intermedia-display-events', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Intermedia Display Events' ), // Block title.
	icon: 'tickets', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Intermedia Display Events' ),
	],
	//----------------SUPPORTS----------------------------------------
	// Enable or disable support for low-level features
	supports: {
		// Turn off ability to edit HTML of block content
		html: false,
		// Turn off reusable block feature
		reusable: false,
		// Add alignwide and alignfull options
		align: true,
	},
	// Register block styles.
	styles: [
		// Mark style as default.
		{
			name: 'Landscape',
			label: __( 'Landscape view items' ),
			isDefault: true,
		},
		{
			name: 'Portrait',
			label: __( 'Portrait view items' ),
		},
		{
			name: 'Overlay',
			label: __( 'Image Overlays view items' ),
		},
	],
	//----------------ATTRIBUTES----------------------------------------
	// Set up data model for custom block
	attributes,
	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: ( props ) => {
		// eslint-disable-next-line no-shadow
		const { attributes, setAttributes } = props;
		const createJqueryFunction = () => {
			jQuery( document ).ready( function() {
				'use strict';

				jQuery( '.owl-carousel' ).owlCarousel( {

					loop: attributes.loop,
					margin: attributes.owlItemMargin,
					autoHeight: attributes.autoHeight,
					center: attributes.center,
					autoplay: attributes.autoplay,
					autoplayTimeout: attributes.autoplayTimeout,
					autoplayHoverPause: attributes.autoplayHoverPause,
					responsiveClass: attributes.responsiveClass,
					responsive: {
						0: {
							items: attributes.breakpointOneItems,
							nav: attributes.breakpointOneNav,
							loop: attributes.breakpointThreeLoop,
						},
						300: {
							items: attributes.breakpointTwoItems,
							nav: attributes.breakpointTwoNav,
							loop: attributes.breakpointThreeLoop,
						},
						500: {
							items: attributes.breakpointThreeItems,
							nav: attributes.breakpointThreeNav,
							loop: attributes.breakpointThreeLoop,
						},
					},
				} );
			} );
		};

		const createItemCarousel = () => {
			const item = [];
			const dateToday = new Date();
			const months = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];
			//const myDomain = window.location.hostname;
			//const protocol = window.location.protocol;
			// protocol + '//' + myDomain + '/wp-content/plugins/intermedia-display-events-by-category/src/block/img/default_image.png';
			const imagesFilepath = 'https://via.placeholder.com/400x400.png/666666/ffffff?text=Intermedia+Display+Events+by+category';
			for ( let n = 0; n <= 10; n++ ) {
				item.push(
					<div className="item">
						<img src={ imagesFilepath } />
						<div className="item-data">
							<h3>
								<a href="#">
									Title Event { n + 1 }
								</a>
							</h3>
							<span className="venue">Location { n + 1 } </span>
							<a className="date" href="#">
								<span className="day">{ dateToday.getDay() }</span>
								<span className="month"> { months[ dateToday.getMonth() ] }</span>
								<span className="year"> { dateToday.getFullYear() }</span>
							</a>
						</div>
					</div>
				);
			}

			return item;
		};

		return (
			[
				<InspectorControls>
					<PanelBody title="Next Events Config">
						<PanelRow>
							<RangeControl
								className="events-number-control"
								label="Events to Display"
								help="Select the number of events to display. Example: 10"
								value={ attributes.EventsToDisplay }
								onChange={ value => setAttributes( { EventsToDisplay: value } ) }
								initialPosition={ attributes.EventsToDisplay } min={ 1 } max={ 20 } step={ 1 }
							/>
						</PanelRow>
						<PanelRow>
							<TextControl
								label="Category slug"
								help="Filter the query by category slug. Example: my-category-slug"
								value={ attributes.catSlugEvent }
								onChange={ ( catSlugEvent ) => setAttributes( { catSlugEvent } ) }
							/>
						</PanelRow>
						<PanelRow>
							<SelectControl
								className="crops"
								label={ __( 'Feature Image Sizes:' ) }
								help="Select a crop for the featured image. If no crops available the default is 'full'"
								value={ attributes.featuredImageCrop }
								onChange={ ( value ) => {
									setAttributes( { featuredImageCrop: value } );
								} }
								options={ window.iceGlobal.imgCrops && window.iceGlobal.imgCrops.map( size => {
									return { value: size, label: size };
								} )
								}
							/>
						</PanelRow>
					</PanelBody>
					<PanelBody title="Owl Carouel Settings">
						<PanelRow>
							<RangeControl
								className="margin-range-control"
								label="Margin"
								help="margin-right(px) on item. Example: 10"
								value={ attributes.owlItemMargin }
								onChange={ value => setAttributes( { owlItemMargin: value } ) }
								initialPosition={ 10 } min={ 0 } max={ 100 } step={ 1 }
							/>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								className="loop-toggle-control"
								label="Slider Loop"
								help="Infinity loop. Duplicate last and first items to get loop illusion."
								checked={ attributes.loop }
								onChange={ () => setAttributes( { loop: ! attributes.loop } ) }
							/>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								className="auto-height-toggle-control"
								label="Slider autoHeight"
								help="At the moment works only with 1 item on screen. The plan is to calculate all visible items and change height according to heighest item."
								checked={ attributes.autoHeight }
								onChange={ () => setAttributes( { autoHeight: ! attributes.autoHeight } ) }
							/>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								className="responsive-class-toggle-control"
								label="Slider responsiveClass"
								help="Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element."
								checked={ attributes.responsiveClass }
								onChange={ () => setAttributes( { responsiveClass: ! attributes.responsiveClass } ) }
							/>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								className="center-class-toggle-control"
								label="Slider center"
								help="Add center to setup."
								checked={ attributes.center }
								onChange={ () => setAttributes( { center: ! attributes.center } ) }
							/>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								className="autoplay-class-toggle-control"
								label="Slider autoplay"
								help="Autoplay."
								checked={ attributes.autoplay }
								onChange={ () => setAttributes( { autoplay: ! attributes.autoplay } ) }
							/>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								className="autoplay-class-toggle-control"
								label="Slider autoplay hover pause"
								help="Pause on mouse hover."
								checked={ attributes.autoplayHoverPause }
								onChange={ () => setAttributes( { autoplayHoverPause: ! attributes.autoplayHoverPause } ) }
							/>
						</PanelRow>
						<PanelRow>
							<RangeControl
								className="autoplay-timeout-range-control"
								label="Autoplay Timeout"
								help="Autoplay interval timeout. Example: 5000 (ms)"
								value={ attributes.autoplayTimeout }
								onChange={ value => setAttributes( { autoplayTimeout: value } ) }
								initialPosition={ 5000 } min={ 100 } max={ 10000 } step={ 100 }
							/>
						</PanelRow>

					</PanelBody>
					<PanelBody title="Owl responsive Config">
						<RangeControl
							className="breakpoints-timeout-range-control"
							label="Breakpoint One"
							help="Example: 0"
							value={ attributes.breakpointOne }
							onChange={ value => setAttributes( { breakpointOne: value } ) }
							initialPosition={ 0 } min={ 0 } max={ 3000 } step={ 1 }
						/>
						<RangeControl
							className="breakpoints-timeout-range-control"
							label="Breakpoint Two"
							help="Example: 600"
							value={ attributes.breakpointTwo }
							onChange={ value => setAttributes( { breakpointTwo: value } ) }
							initialPosition={ 0 } min={ 0 } max={ 3000 } step={ 1 }
						/>
						<RangeControl
							className="breakpoints-timeout-range-control"
							label="Breakpoint Three"
							help="Example: 1000"
							value={ attributes.breakpointThree }
							onChange={ value => setAttributes( { breakpointThree: value } ) }
							initialPosition={ 0 } min={ 0 } max={ 3000 } step={ 1 }
						/>

						<RangeControl
							className="breakpoints-items-timeout-range-control"
							label="Breakpoint One Items"
							help="Example: 1"
							value={ attributes.breakpointOneItems }
							onChange={ value => setAttributes( { breakpointOneItems: value } ) }
							initialPosition={ 1 } min={ 1 } max={ 10 } step={ 1 }
						/>
						<RangeControl
							className="breakpoints-items-timeout-range-control"
							label="Breakpoint Two Items"
							help="Example: 2"
							value={ attributes.breakpointTwoItems }
							onChange={ value => setAttributes( { breakpointTwoItems: value } ) }
							initialPosition={ 2 } min={ 1 } max={ 10 } step={ 1 }
						/>
						<RangeControl
							className="breakpoints-items-timeout-range-control"
							label="Breakpoint Three Items"
							help="Example: 3"
							value={ attributes.breakpointThreeItems }
							onChange={ value => setAttributes( { breakpointThreeItems: value } ) }
							initialPosition={ 3 } min={ 1 } max={ 10 } step={ 1 }
						/>
						<ToggleControl
							className="breakpoints-loop-class-toggle-control"
							label="Breakpoint One Loop"
							help="Loop in breakpoint."
							checked={ attributes.breakpointOneLoop }
							onChange={ () => setAttributes( { breakpointOneLoop: ! attributes.breakpointOneLoop } ) }
						/>
						<ToggleControl
							className="breakpoints-loop-class-toggle-control"
							label="Breakpoint Two Loop"
							help="Loop in breakpoint."
							checked={ attributes.breakpointTwoLoop }
							onChange={ () => setAttributes( { breakpointTwoLoop: ! attributes.breakpointTwoLoop } ) }
						/>
						<ToggleControl
							className="breakpoints-loop-class-toggle-control"
							label="Breakpoint Three Loop"
							help="Loop in breakpoint."
							checked={ attributes.breakpointThreeLoop }
							onChange={ () => setAttributes( { breakpointThreeLoop: ! attributes.breakpointThreeLoop } ) }
						/>
						<ToggleControl
							className="breakpoints-nav-class-toggle-control"
							label="Breakpoint One Nav"
							help="Nav in breakpoint."
							checked={ attributes.breakpointOneNav }
							onChange={ () => setAttributes( { breakpointOneNav: ! attributes.breakpointOneNav } ) }
						/>
						<ToggleControl
							className="breakpoints-nav-class-toggle-control"
							label="Breakpoint Two Nav"
							help="Nav in breakpoint."
							checked={ attributes.breakpointTwoNav }
							onChange={ () => setAttributes( { breakpointTwoNav: ! attributes.breakpointTwoNav } ) }
						/>
						<ToggleControl
							className="breakpoints-nav-class-toggle-control"
							label="Breakpoint Three Nav"
							help="Nav in breakpoint."
							checked={ attributes.breakpointThreeNav }
							onChange={ () => setAttributes( { breakpointThreeNav: ! attributes.breakpointThreeNav } ) }
						/>
					</PanelBody>

				</InspectorControls>,
				createJqueryFunction(),
				<div className={ props.className }>
					<div className="owl-carousel owl-theme">
						{ createItemCarousel() }
					</div>
				</div>,
			]
		);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: () => {
		return null;
	},
} );
