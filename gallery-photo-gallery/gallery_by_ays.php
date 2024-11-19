<?php
	/*
	Plugin name: Gallery - Photo Gallery
	Plugin URI: http://ays-pro.com/
	Description: Create beautiful and full responsive image galleries with popup slideshow.
	Author: AYS Pro
	Author URI: http://ays-pro.com/
	Version:1.0.0
	*/
	defined('AYS_GALL_DS') or define('AYS_GALL_DS', DIRECTORY_SEPARATOR);

	define( 'AYS_GAL_BASENAME', plugin_basename( __FILE__ ) );
	define( 'AYS_GAL_DIR', untrailingslashit( dirname( __FILE__ ) ) );
	define( 'AYS_GAL_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );
	include('admin/gallery_admin_by_ays.php');
	include('site/gallery_site_by_ays.php');
	add_action( 'plugins_loaded', array( 'AYS_Gallery_Admin', 'get_instance' ) );
	add_action( 'plugins_loaded', array( 'AYS_Gallery_Site', 'get_instance' ) );
	function ays_gall_activation(){
	    global $wpdb;
	    /*quiz categories*/
	    $table = $wpdb->prefix . 'ays_gallery';
	    $sql="CREATE TABLE IF NOT EXISTS `".$table."` (
	      `id`        	INT(16)     UNSIGNED NOT NULL AUTO_INCREMENT,
	      `title`     	VARCHAR(256)         NOT NULL,
	      `description`	TEXT NOT NULL,
	      `images`		TEXT NOT NULL,
	      `images_titles` TEXT NOT NULL,
	      `images_descs` TEXT NOT NULL,
	      `images_alts`	TEXT NOT NULL,
	      `images_urls` TEXT NOT NULL,
	      `width`		INT(16) NOT NULL,
	      `height`		INT NOT NULL,


	      PRIMARY KEY (`id`)
	    )
	      ENGINE = MyISAM
	      DEFAULT CHARSET = utf8
	      AUTO_INCREMENT = 1";  
	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	    dbDelta( $sql );
	    add_option( 'ays_gal_db_version', $ays_db_version);
	}
	register_activation_hook( __FILE__, 'ays_gall_activation');
?>