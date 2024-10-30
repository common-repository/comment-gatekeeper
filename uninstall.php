<?php

// delete options upon uninstall

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();


delete_option( 'lb3cgk_settings' );
delete_option( 'lb3cgk_data' );