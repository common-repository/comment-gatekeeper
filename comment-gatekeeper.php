<?php
/*
Plugin Name: Comment Gatekeeper
Plugin URI: http://makesenseofitall.com
Description: Insert a question and answer field to your comment form to block spam comments
Author: Stuart Sequeira
Author URI: http://lb3computingsolutions.com/about/
Version: 1.1.1
Text Domain: comment-gatekeeper
*/

define('LB3CGK_VERSION', '1.1.1');

/*----------
DEFINE CONSTANTS
---------------------------------------------------------------------------------------------------------*/
 
// plugin folder url
if(!defined('LB3CGK_PLUGIN_URL')) {
	define('LB3CGK_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}

// plugin folder path
if(!defined('LB3CGK_PLUGIN_DIR')) {
	define('LB3CGK_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
}

// plugin root file
if(!defined('LB3CGK_PLUGIN_FILE')) {
	define('LB3CGK_PLUGIN_FILE', __FILE__);
}




/*----------
GLOBALS
-----*/

$lb3cgk_gatekeeper_default = apply_filters( 'lb3cgk_gatekeeper_default' , "What is your quest" );

$lb3cgk_gatelock_default = apply_filters( 'lb3cgk_gatelock_default' , "to seek the holy grail" );

$lb3cgk_options = get_option('lb3cgk_settings');

if(!isset($lb3cgk_options['lb3cgk_gatekeeper_default']) ){

	$lb3cgk_options['lb3cgk_gatekeeper_default'] = $lb3cgk_gatekeeper_default;

}

if(!isset($lb3cgk_options['lb3cgk_gatelock_default']) ){

	$lb3cgk_options['lb3cgk_gatelock_default'] = $lb3cgk_gatelock_default;

}


/*----------
INCLUDES
----------------------------------------------------------------------------------------------------------*/

/*----------
Create options pages and settings required 
------*/

include_once( LB3CGK_PLUGIN_DIR . '/includes/settings.php'); 


/*----------
Modify the comment form to add the gatelock question
-----*/
include_once( LB3CGK_PLUGIN_DIR . '/includes/comment-form.php'); 



/*----------
LANGUAGE
--------------------------------------------------------------------------------------------------------------*/

add_action('plugins_loaded', 'lb3cgk_load_lang');

function lb3cgk_load_lang() {
	 
	/** Set our unique textdomain string */
	$textdomain = 'comment-gatekeeper';
	 
	/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
	$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );
	 
	/** Set filter for WordPress languages directory */
	$wp_lang_dir = apply_filters(
		'lb3cgk_wp_lang_dir',
		WP_LANG_DIR . '/'.basename( dirname( __FILE__ ) ).'/' . $textdomain . '-' . $locale . '.mo'
	);
	 
	/** Translations: First, look in WordPress' "languages" folder = custom & update-secure! */
	load_textdomain( $textdomain, $wp_lang_dir );
	 
	/** Translations: Secondly, look in plugin's "lang" folder = default */
	$plugin_dir = basename( dirname( __FILE__ ) );
	$lang_dir = apply_filters( 'lb3cgk_lang_dir', $plugin_dir . '/lang/' );
	load_plugin_textdomain( $textdomain, FALSE, $lang_dir );
 
}