<?php

/*--- COMMENT GATE KEEPER SETTINGS ---*/


/*----------
CREATE OPTIONS PAGE AND GET SETTINGS FOR SITE-WIDE VALUES
------------------------------------------------------------------------------------------------------------*/

/*----------
CREATE OPTIONS FIELD AND SECTION
	Insert these options onto a menu page
	Currently, menu page is a custom settings page created under the Ninja Forms main menu page
-----*/

add_action( 'admin_init' , 'lb3cgk_create_sitewide_settings');

function lb3cgk_create_sitewide_settings(){

	/*--- Set up settings names ---*/
	
	$section_id = 'lb3cgk_settings_section'; //id for our section
	$section_title = __( 'Comment Gatekeeper Settings' , 'comment-gatekeeper' ); // title our section
	$section_output_function = 'lb3cgk_settings_section_output'; // function to output section html
	
	$option_name = 'lb3cgk_settings'; // name of our option array
	
	$do_settings_section = 'discussion'; //on which page should our new section go
	
	
	/*--- Add Settings Section ---*/
	
	add_settings_section(
		$section_id
		, $section_title
		, $section_output_function
		, $do_settings_section	
	);
	
	/*--- Create array to add each sitewide option ---*/
	
	$options_array = array();
	
	
	//default gatelock question
	
	$options_array['challenge_question' ] = array(
		'field_id' 		=> 'lb3cgk_gatekeeper_default',
		'field_title' 	=> __( 'Default comment gatekeeper question' , 'comment-gatekeeper' )
		,'field_output_function' 	=> 'lb3cgk_gatekeeper_default_field_output'
	
	);	
	
	//default gatelock
	
	$options_array['gatelock' ] = array(
		'field_id' 		=> 'lb3cgk_gatelock_default',
		'field_title' 	=> __( 'Default gatelock' , 'comment-gatekeeper' )
		,'field_output_function' 	=> 'lb3cgk_gatelock_default_field_output'
	
	);	
	
	/*--- Loop through each option array to add a field to a do_settings_section ---*/
	
	foreach( $options_array as $option){
	
		add_settings_field(
			$option[ 'field_id' ]//unique id for field
			, $option[ 'field_title' ]//field title
			, $option[ 'field_output_function' ]//function callback
			, $do_settings_section //on which page should our new field go
			, $section_id //in which settings section should our new field go
			//,$section='default'
			//,$args=array()
		);

	}
	/*--- register setting ---*/

		
	register_setting( $do_settings_section, $option_name, 'lb3cgk_validate_settings'); //whitelists our setting 	
	
} // end lb3cgk_create_sitewide_settings


/*----------
Output the settings section tagline 
-----*/

function lb3cgk_settings_section_output(){

	// get current spam block count
	$lb3cgk_data = get_option( 'lb3cgk_data' );

	if( !isset( $lb3cgk_data['spam-count'] ) ){
	
		$lb3cgk_data['spam-count'] = 0;
	
	}
	
	echo __("Please complete these site-wide comment gatekeeper settings" , 'comment-gatekeeper' )
		. '<br />'
		. __("Sor far, this plugin has blocked ")
		. number_format( $lb3cgk_data['spam-count'] )
		. __( " spam comments for you." );
	
} // end lb3cgk_settings_section_output


/*----------
Output the gatelock question settings form html
-----*/

function lb3cgk_gatekeeper_default_field_output(){

	global $lb3cgk_options;
	
ob_start(); ?>

	<input 
		id="lb3cgk_gatekeeper_default"
		name="lb3cgk_settings[lb3cgk_gatekeeper_default]"
		size = "50"
		type="text" 
		value = "<?php if(isset( $lb3cgk_options['lb3cgk_gatekeeper_default'] )){  echo $lb3cgk_options['lb3cgk_gatekeeper_default'];}?>" 
	/>
	<label for="lb3cgk_gatekeeper_default"><?php _e('This is the default question that will be posed to a potential commenter' , 'comment-gatekeeper'); ?></label>
	
<?php echo ob_get_clean();

} //end lb3cgk_gatekeeper_default_field_output


/*----------
Output the settings section gatelock html
-----*/

function lb3cgk_gatelock_default_field_output(){

	global $lb3cgk_options;
	
ob_start(); ?>

	<input 
		id="lb3cgk_gatelock_default"
		name="lb3cgk_settings[lb3cgk_gatelock_default]"
		size = "50"
		type="text" 
		value = "<?php if(isset( $lb3cgk_options['lb3cgk_gatelock_default'] )){  echo $lb3cgk_options['lb3cgk_gatelock_default'];}?>" 
	/>
	<label for="lb3cgk_gatelock_default"><?php _e( 'This is the correct answer that will allow the comment to pass' , 'comment-gatekeeper') ;?></label>
<?php echo ob_get_clean();

} //end lb3cgk_gatelock_default_field_output


/*----------
Validate the values before saving to database
-----*/

function lb3cgk_validate_settings( $input ){

	$output = array();
	
	foreach( $input as $key => $value ){
	
		if( isset( $input[$key] ) ){
		
			$output[$key] = strip_tags( stripslashes( $input[$key] ) );
		
		}// endif
	
	} //end foreach

	return apply_filters( 'lb3cgk_validate_settings' , $output, $input );
	
} // end lb3cgk_validate_settings

