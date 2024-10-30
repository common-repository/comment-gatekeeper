<?php 

/*--- COMMENT GATE KEEPER SETTINGS ---*/


/*----------
OUTPUT THE GATELOCK QUESTION TO THE COMMENT FORM
------------------------------------------------------------------------------------------------------------*/

add_filter( 'comment_form_default_fields', 'lb3cgk_add_gatekeeper_fields' );

function lb3cgk_add_gatekeeper_fields( $fields ) {

	$post_id = get_the_ID();
	
	$result = TRUE;
	
	if( apply_filters( 'lb3cgk_add_gatekeeper_filter' , $result , $post_id ) ){
	
		$fields['gatekey'] = lb3cgk_output_comment_form_html();
	
	}
	
	return $fields;
}


/*----------
OUTPUT THE COMMENT FORM HTML
------------------------------------------------------------------------------------------------------------*/

function lb3cgk_output_comment_form_html(){

	$post_id = get_the_ID();
	
	$gate_array = lb3cgk_return_gatekeeper_and_gatelock( $post_id );
	
	$lb3cgk_comment_form_html = '<p class="comment-form-gatekey"><label for="gatekey">' . $gate_array['gatekeeper']. ' </label><input type="text" id="gatekey" name="gatekey" value="" size="30" /></p>';
	
	return $lb3cgk_comment_form_html;

}


/*----------
TEST THE GATEKEY AGAINST THE GATELOCK QUESTION
------------------------------------------------------------------------------------------------------------*/

add_action( 'pre_comment_on_post' , 'lb3cgk_gatekey_gatelock_test' );

function lb3cgk_gatekey_gatelock_test( $comment_post_id ){
	
	// get current spam block count
	$lb3cgk_data = get_option( 'lb3cgk_data' );

	if( !isset( $lb3cgk_data['spam-count'] ) ){
	
		$lb3cgk_data['spam-count'] = 0;
	
	}
	
	$result = TRUE;
	
	
	// check comment form value against correct answer
	
	if( apply_filters( 'lb3cgk_add_gatekeeper_filter' , $result , $comment_post_id ) ){
	
		
		$gate_array = lb3cgk_return_gatekeeper_and_gatelock( $comment_post_id );
		
		$gatelock = $gate_array['gatelock'];
		
		if( isset($_POST['gatekey'] ) ){
		
			if( '' == $_POST['gatekey']){

				// increment spam blocked count and update option
				$lb3cgk_data['spam-count']++;
				update_option( 'lb3cgk_data' , $lb3cgk_data );
				
				wp_die( __('<strong>ERROR</strong>: please enter a valid spam-filtering answer.' , 'comment-gatekeeper' ) ); //no gatekey was entered

			}
			
			$gatekey = $_POST['gatekey'];
			
		}else{
		
			// increment spam blocked count and update option
			$lb3cgk_data['spam-count']++;
			update_option( 'lb3cgk_data' , $lb3cgk_data );
				
			wp_die( __('<strong>ERROR</strong>: please enter a valid spam-filtering answer.' , 'comment-gatekeeper' ) );//gatekey was not set
			
		}
		
		$result = ( $gatekey == $gatelock );
		
		if( !$result){
		
			// increment spam blocked count and update option
			$lb3cgk_data['spam-count']++;
			update_option( 'lb3cgk_data' , $lb3cgk_data );
			
			wp_die( __('<strong>SORRY</strong>: you did not answer to gatekeeper question correctly.' , 'comment-gatekeeper' ) );
		
		}
	
	}
	
}


/*----------
RETURN THE GATEKEEPER QUESTION AND GATELOCK ANSWER FOR THE POST
------------------------------------------------------------------------------------------------------------*/

function lb3cgk_return_gatekeeper_and_gatelock( $post_id ){

/*--- Receives the post id and returns an array of the gatekeeper question and gatelock ---*/

	global $lb3cgk_options;

	$gate_array = array();
	
	$gate_array['gatekeeper'] = $lb3cgk_options['lb3cgk_gatekeeper_default'];
	$gate_array['gatelock'] = $lb3cgk_options['lb3cgk_gatelock_default'];
	
	return apply_filters('lb3cgk_return_gatekeeper_and_gatelock_filter' , $gate_array, $post_id );
	
}


/*----------
END COMMENT-FORM.PHP
------------------------------------------------------------------------------------------------------------*/