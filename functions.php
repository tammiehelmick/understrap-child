<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );





function stray_animals_filter_form_shortcode() {
    ob_start(); // start output buffering
    ?>
    <!-- filter form HTML -->
    <form id="stray-animals-filter-form">
        <!-- dropdown for animal type -->
        <select name="animal_type" id="animal_type">
            <option value="">Animal Type</option>
			<option value="cat">Cat</option>
            <option value="dog">Dog</option>
            <option value="other">Other</option>
        </select>
        
        <!-- dropdown for gender -->
        <select name="gender" id="gender">
            <option value="">Gender</option>
			<option value="female">Female</option>
			<option value="male">Male</option>
        </select>
        
        <!-- dropdown for age group -->
        <select name="age_group" id="age_group">
            <option value="">Age Group</option>
			<option value="young">Young</option>
			<option value="adult">Adult</option>
			<option value="senior">Senior</option>
        </select>
        
        <!-- dropdown for size type -->
        <select name="size" id="size">
            <option value="">Size</option>
			<option value="small size">Small Size</option>
			<option value="medium size">Medium Size</option>
			<option value="large size">Large Size</option>
			<option value="extra large size">Extra Large Size</option>
        </select>
        
        <!-- dropdown for microchip status -->
        <select name="microchip_status" id="microchip_status">
            <option value="">Microchip Status</option>
			<option value="microchipped">Microchipped</option>
			<option value="not microchipped">Not Microchipped</option>
        </select>
        
        <!-- submit button -->
        <input type="submit" value="Search">
    </form>

    <!-- container for results -->
    <div id="stray-animals-results">
        <!-- Filtered results will be displayed here -->
    </div>
    <?php
    return ob_get_clean(); // return the buffer content
}
add_shortcode('stray_animals_filter_form', 'stray_animals_filter_form_shortcode');




function enqueue_stray_animals_scripts() {
    wp_enqueue_script('stray-animals-ajax', get_stylesheet_directory_uri() . '/js/stray-animals-ajax.js', array('jquery'), null, true);
    wp_localize_script('stray-animals-ajax', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_stray_animals_scripts');




function filter_stray_animals_callback() {
    // Validate and sanitize inputs
    // Perform query based on filter parameters
    // Generate HTML for results
    // Echo the results
    wp_die(); // End AJAX request
}
add_action('wp_ajax_filter_stray_animals', 'filter_stray_animals_callback');
add_action('wp_ajax_nopriv_filter_stray_animals', 'filter_stray_animals_callback');



