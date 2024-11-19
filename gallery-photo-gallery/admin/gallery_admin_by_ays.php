<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AYS_Gallery_Admin{
    protected static $instance = null;
    
    private function __construct() {
        $this->setup_constants();
        add_action('admin_menu', array($this, 'ays_gall_menu_generate'));
        add_action('admin_enqueue_scripts',array($this,'ays_gall_admin_scripts_styles'));
    }

    public function setup_constants() {
        if (!defined('AYS_GALL_DIR')) {
            define('AYS_GALL_DIR', dirname(__FILE__));
        }
        if (!defined('AYS_GALL_URL')) {
            define('AYS_GALL_URL', plugins_url(plugin_basename(dirname(__FILE__))));
        }
        if(!defined('AYS_GALL_FILE')){
            define( 'AYS_GALL_FILE', AYS_GALL_DIR . 'gallery_admin_by_ays.php' );
        }
    }

    function ays_gall_menu_generate(){
    	$icon_url = AYS_GALL_URL . '/images/gall_icon.png';
        add_options_page('Gallery - Photo Gallery','Gallery - Photo Gallery','manage_options','ays_gall_main',array($this,'ays_gall_main'));
        add_menu_page('Gallery - Photo Gallery', 'Gallery - Photo Gallery', 'manage_options', 'ays_gall_main',array($this,'ays_gall_main'),$icon_url);
    }
    function ays_gall_main(){
        include_once( AYS_GALL_DIR . '/classes/AYS_Gall_Main.php' );
        if(!isset($_GET["action"])){
        	AYS_Gall_Main::AYS_Gallery_Main();
        }
        if(isset($_GET["action"]) && $_GET["action"] == "create"){
        	AYS_Gall_Main::create();
        }
        if(isset($_GET["action"]) && $_GET["action"] == "edit"){
        	AYS_Gall_Main::edit();
        }
    }
    function ays_gall_admin_scripts_styles(){
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_register_style('ays_animate_style',AYS_GALL_URL.'/css/ays_animate.css');
        wp_enqueue_style( 'ays_animate_style');
        wp_register_style('ays_banner_style',AYS_GALL_URL.'/css/ays_banner.css');
        wp_enqueue_style( 'ays_banner_style');
        wp_register_style('ays_admin_style',AYS_GALL_URL.'/css/ays_admin.css');
        wp_enqueue_style( 'ays_admin_style');
        wp_register_script('ays_admin_script',AYS_GALL_URL.'/js/ays_admin_js.js');
        wp_enqueue_script('ays_admin_script');
        wp_register_script('ays_ays_script',AYS_GALL_URL.'/js/ays.js');
        wp_enqueue_script('ays_ays_script');
        wp_enqueue_style('ays_ays',AYS_GALL_URL.'/css/ays.css');
        wp_enqueue_style( 'ays_ays');
        wp_enqueue_style('ays_ays-theme',AYS_GALL_URL.'/css/ays-theme.css');
        wp_enqueue_style( 'ays_ays-theme');
        wp_enqueue_media();
    }	
    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}