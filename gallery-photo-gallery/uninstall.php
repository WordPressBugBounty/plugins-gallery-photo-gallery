<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
$option_name = 'ays_gal_db_version';
 
delete_option( $option_name );
 
// For site options in Multisite
delete_site_option( $option_name );  
 
// Drop a custom db table
global $wpdb;
$table = $wpdb->prefix . 'ays_gallery';
$wpdb->query( "DROP TABLE IF EXISTS ".$table );