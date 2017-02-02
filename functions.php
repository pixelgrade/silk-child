<?php
/**
 * Silk Child functions and definitions
 *
 * Bellow you will find several ways to tackle the enqueue of static resources/files
 * It depends on the amount of customization you want to do
 * If you either wish to simply overwrite/add some CSS rules or JS code
 * Or if you want to replace certain files from the parent with your own (like style.css or main.js)
 *
 * @package PatchChild
 */
/**
 * Setup Silk Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */

function silk_child_theme_setup() {
	load_child_theme_textdomain( 'silk-child-theme', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'silk_child_theme_setup' );

/**
 *
 * 1. Add a Child Theme "style.css" file
 * ----------------------------------------------------------------------------
 *
 * If you want to add static resources files from the child theme, use the
 * example function written below.
 *
 */
function silk_child_enqueue_styles() {
	$theme = wp_get_theme();
	// use the parent version for cachebusting
	$parent = $theme->parent();
	if ( !is_rtl() ) {
		wp_enqueue_style( 'silk-style', get_template_directory_uri() . '/style.css', array(), $parent->get( 'Version' ) );
	} else {
		wp_enqueue_style( 'silk-style', get_template_directory_uri() . '/rtl.css', array(), $parent->get( 'Version' ) );
	}
	// Here we are adding the child style.css while still retaining
	// all of the parents assets (style.css, JS files, etc)
	wp_enqueue_style( 'silk-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array('silk-style') //make sure the the child's style.css comes after the parents so you can overwrite rules
	);
}
add_action( 'wp_enqueue_scripts', 'silk_child_enqueue_styles' );
