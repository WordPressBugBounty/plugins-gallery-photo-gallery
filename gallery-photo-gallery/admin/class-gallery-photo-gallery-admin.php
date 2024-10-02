<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/admin
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Gallery_Photo_Gallery_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $gallery_obj;
    private $cats_obj;
    private $gallery_cats_obj;
    private $settings_obj;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_filter( 'set-screen-option', array( __CLASS__, 'set_screen' ), 10, 3 );
        $per_page_array = array(
            'galleries_per_page',
            'gallery_categories_per_page',
            'gallery_gpg_categories_per_page',
        );
        foreach($per_page_array as $option_name){
            add_filter('set_screen_option_'.$option_name, array(__CLASS__, 'set_screen'), 10, 3);
        }

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook_suffix) {
        
	    wp_enqueue_style( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'wp-color-picker' );
        
        wp_enqueue_style( $this->plugin_name . "-banner", plugin_dir_url( __FILE__ ) . 'css/gallery-photo-gallery-banner.css', array(), $this->version, 'all' );

        if(false === strpos($hook_suffix, $this->plugin_name))
            return;

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gallery_Photo_Gallery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gallery_Photo_Gallery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.4.1/css/all.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . "-font-awesome", plugin_dir_url( __FILE__ ) . 'css/fontawesome.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . "-bootstrap", plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . "-select2", plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all');        
        wp_enqueue_style( $this->plugin_name."-mosaic.css", plugin_dir_url( __FILE__ ) . 'css/jquery.mosaic.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name."-masonry.css", plugin_dir_url( __FILE__ ) . 'css/masonry.pkgd.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gallery-photo-gallery-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'animate.css', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook_suffix) {
        global $wp_version;
        
        $version1 = $wp_version;
        $operator = '>=';
        $version2 = '5.5';
        $versionCompare = $this->versionCompare($version1, $operator, $version2);

        if ($versionCompare) {
            wp_enqueue_script( $this->plugin_name.'-wp-load-scripts', plugin_dir_url(__FILE__) . 'js/ays-wp-load-scripts.js', array(), $this->version, true);
        }

        wp_enqueue_script( $this->plugin_name . "banner", plugin_dir_url( __FILE__ ) . 'js/gallery-photo-gallery-banner.js', array( 'jquery' ), $this->version, true );

        if (false !== strpos($hook_suffix, "plugins.php")){

            wp_enqueue_script( $this->plugin_name . "sweetalert-js", plugin_dir_url( __FILE__ ) . 'js/gallery-photo-gallery-sweetalert2.all.min.js', array( 'jquery' ), $this->version, true );

            wp_enqueue_script( $this->plugin_name . '-adminjs', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, true );
            wp_localize_script($this->plugin_name . '-adminjs',  'ays_gpg_admin_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
        }
        
        if(false === strpos($hook_suffix, $this->plugin_name))
            return;
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gallery_Photo_Gallery_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gallery_Photo_Gallery_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_media();
        
		wp_enqueue_script( $this->plugin_name . "-popper", plugin_dir_url( __FILE__ ) . 'js/popper.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_style($this->plugin_name . "-codemirror", plugin_dir_url( __FILE__ ) . 'css/codemirror.css', array(), $this->version, 'all');
        wp_enqueue_script( $this->plugin_name . "-bootstrap", plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . "-select2", plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, true );        
        wp_enqueue_script( $this->plugin_name . "-sweetalert-js", plugin_dir_url( __FILE__ ) . 'js/sweetalert2.all.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . "-imagesloaded", plugin_dir_url( __FILE__ ) . 'js/imagesloaded.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name."-mosaic.js", plugin_dir_url( __FILE__ ) . 'js/jquery.mosaic.min.js', array( 'jquery', 'wp-color-picker'  ), $this->version, true );
		wp_enqueue_script( $this->plugin_name."-masonry.js", plugin_dir_url( __FILE__ ) . 'js/masonry.pkgd.min.js', array( 'jquery', 'wp-color-picker'  ), $this->version, true );
		wp_enqueue_script( $this->plugin_name."-cookie.js", plugin_dir_url( __FILE__ ) . 'js/cookie.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gallery-photo-gallery-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );

        wp_localize_script($this->plugin_name, 'gallery_ajax', array(
            'ajax_url'           => admin_url('admin-ajax.php'),            
            'selectUser'         => __( 'Select user', $this->plugin_name),
            'pleaseEnterMore'    => __( "Please enter 1 or more characters", $this->plugin_name ),
            'searching'          => __( "Searching...", $this->plugin_name ),
            'loader_message'     => __('Just a moment...', $this->plugin_name),            
            "emptyEmailError"    => __( 'Email field is empty', $this->plugin_name),
            "invalidEmailError"  => __( 'Invalid Email address', $this->plugin_name),           
            'activated'          => __( "Activated", $this->plugin_name ),
            'errorMsg'           => __( "Error", $this->plugin_name ),
            'loadResource'       => __( "Can't load resource.", $this->plugin_name ),
            'somethingWentWrong' => __( "Maybe something went wrong.", $this->plugin_name ),
            'greateJob'          => __( 'Great job', $this->plugin_name),
            'formMoreDetailed'   => __( 'For more detailed configuration visit', $this->plugin_name),
            'greate'             => __( 'Great!', $this->plugin_name),
        ));

        $gpg_banner_date = $this->ays_gpg_update_banner_time();
        wp_localize_script( $this->plugin_name, 'galleryLangObj', array(
            'gpgBannerDate'             => $gpg_banner_date,
            'copied'                    => __( 'Copied!', $this->plugin_name),
            'clickForCopy'              => __( 'Click for copy.', $this->plugin_name),
            'addGif'                    => __( 'Add Gif', $this->plugin_name),
            'somethingWentWrong'        => __( "Maybe something went wrong.", $this->plugin_name ),
            'errorMsg'                  => __( "Error", $this->plugin_name ),
            'youCanUseThisShortcodeTop' => __( 'Your Gallery is Created!', $this->plugin_name),
            'youCanUseThisShortcodeBtm' => __( 'Copy the generated shortcode and paste it into any post or page to display Gallery.', $this->plugin_name),
            'greateJob'                 => __( 'Great job', $this->plugin_name),
            'formMoreDetailed'          => __( 'For more detailed configuration visit', $this->plugin_name),
            'editGalleryPage'           => __( 'edit gallery page', $this->plugin_name),
            'greate'                    => __( 'Done!', $this->plugin_name),
            'thumbsUpGreat'             => __( 'Thumbs up, great!', $this->plugin_name),

        ) );
        
        $cats = $this->ays_get_gallery_image_categories();
        wp_localize_script($this->plugin_name,  'ays_gpg_admin', array(
            'categories' => $cats,
            'nextGalleryPage' => __( 'Are you sure you want to go to the next gallery page?', $this->plugin_name),
            'prevGalleryPage' => __( 'Are you sure you want to go to the previous gallery page?', $this->plugin_name),
        ));
        wp_enqueue_script( $this->plugin_name.'-wp-color-picker-alpha', plugin_dir_url( __FILE__ ) . 'js/wp-color-picker-alpha.min.js',array( 'wp-color-picker' ),$this->version, true );

        $color_picker_strings = array(
            'clear'            => __( 'Clear', $this->plugin_name ),
            'clearAriaLabel'   => __( 'Clear color', $this->plugin_name ),
            'defaultString'    => __( 'Default', $this->plugin_name ),
            'defaultAriaLabel' => __( 'Select default color', $this->plugin_name ),
            'pick'             => __( 'Select Color', $this->plugin_name ),
            'defaultLabel'     => __( 'Color value', $this->plugin_name ),
        );
        wp_localize_script( $this->plugin_name.'-wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );
	}

    function codemirror_enqueue_scripts($hook) {
        if (false === strpos($hook, $this->plugin_name)){
            return;
        }
        if(function_exists('wp_enqueue_code_editor')){
            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array(
                'type' => 'text/css',
                'codemirror' => array(
                    'inputStyle' => 'contenteditable',
                    'theme' => 'cobalt',
                )
            ));

            wp_enqueue_script('wp-theme-plugin-editor');
            wp_localize_script('wp-theme-plugin-editor', 'cm_gpg_settings', $cm_settings);
        
            wp_enqueue_style('wp-codemirror');
        }
    }

    function versionCompare($version1, $operator, $version2) {
   
        $_fv = intval ( trim ( str_replace ( '.', '', $version1 ) ) );
        $_sv = intval ( trim ( str_replace ( '.', '', $version2 ) ) );
       
        if (strlen ( $_fv ) > strlen ( $_sv )) {
            $_sv = str_pad ( $_sv, strlen ( $_fv ), 0 );
        }
       
        if (strlen ( $_fv ) < strlen ( $_sv )) {
            $_fv = str_pad ( $_fv, strlen ( $_sv ), 0 );
        }
       
        return version_compare ( ( string ) $_fv, ( string ) $_sv, $operator );
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */

    public function add_plugin_admin_menu() {
        
        $hook_gallery = add_menu_page( 
            __('Photo Gallery', $this->plugin_name), 
            __('Photo Gallery', $this->plugin_name), 
            'manage_options', 
            $this->plugin_name, 
            array($this, 'display_plugin_setup_page'), AYS_GPG_ADMIN_URL . 'images/icons/icon-gpg-128x128.svg', 6);
        add_action( "load-$hook_gallery", array( $this, 'screen_option_gallery' ) );
        add_action( "load-$hook_gallery", array( $this, 'add_tabs' ));
        
        $hook_gallery = add_submenu_page(
            $this->plugin_name,
            __('All Galleries', $this->plugin_name),
            __('All Galleries', $this->plugin_name),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );
        add_action( "load-$hook_gallery", array( $this, 'screen_option_gallery' ) );

        $hook_add_new = add_submenu_page(
            $this->plugin_name,
            __('Add new', $this->plugin_name),
            __('Add new', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-add-new',
            array($this, 'display_plugin_add_new_gallery_page')
        );
        add_action( "load-$hook_add_new", array( $this, 'add_tabs' ));

        $hook_image_categories = add_submenu_page(
            $this->plugin_name,
            __('Image Categories', $this->plugin_name),
            __('Image Categories', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-categories',
            array($this, 'display_plugin_gpg_categories_page')
        );
        add_action("load-$hook_image_categories", array($this, 'screen_option_gallery_cats'));
        add_action( "load-$hook_image_categories", array( $this, 'add_tabs' ));


        $hook_gallery_categories = add_submenu_page(
            $this->plugin_name,
            __('Gallery Categories', $this->plugin_name),
            __('Gallery Categories', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-gpg-categories',
            array($this, 'display_plugin_gallery_categories_page')
        );
        add_action("load-$hook_gallery_categories", array($this, 'screen_option_gallery_categories'));
        add_action( "load-$hook_gallery_categories", array( $this, 'add_tabs' ));

        $hook_settings = add_submenu_page( $this->plugin_name,
            __('General Settings', $this->plugin_name),
            __('General Settings', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_gallery_settings_page') 
        );
        add_action("load-$hook_settings", array($this, 'screen_option_settings'));        
        add_action( "load-$hook_settings", array( $this, 'add_tabs' ));

        $hook_howtouse = add_submenu_page(
            $this->plugin_name,
            __('How to use', $this->plugin_name),
            __('How to use', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-dashboard',
            array($this, 'display_plugin_how_to_use_page')
        );
        add_action( "load-$hook_howtouse", array( $this, 'add_tabs' ));

        $hook_ourproducts = add_submenu_page(
            $this->plugin_name,
            __('Our products', $this->plugin_name),
            __('Our products', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-featured-plugins',
            array($this, 'display_plugin_gpg_featured_plugins_page')
        );
        add_action( "load-$hook_ourproducts", array( $this, 'add_tabs' ));

        $hook_profeatures = add_submenu_page(
            $this->plugin_name,
            __('PRO Features', $this->plugin_name),
            __('PRO Features', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-pro-features',
            array($this, 'display_plugin_gpg_features_page')
        );
        add_action( "load-$hook_profeatures", array( $this, 'add_tabs' ));
        

    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */

        $gallery_ajax_deactivate_plugin_nonce = wp_create_nonce( 'gallery-ajax-deactivate-plugin-nonce' );

        $settings_link = array(
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
            '<a href="https://ays-demo.com/wordpress-photo-gallery-plugin-free-demo/" target="_blank">' . __('Demo', $this->plugin_name) . '</a>',
            '<a href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard-gallery&utm_medium=free-gallery&utm_campaign=buy-now-gallery" target="_blank" class="ays-admin-plugins-upgrade-link" style="font-weight:bold;">' . __('Upgrade 30% Sale', $this->plugin_name) . '</a>
            <input type="hidden" id="ays_gpg_ajax_deactivate_plugin_nonce" name="ays_gpg_ajax_deactivate_plugin_nonce" value="' . $gallery_ajax_deactivate_plugin_nonce .'">',
        );
        return array_merge(  $settings_link, $links );

    }

    public function add_tabs() {
        $screen = get_current_screen();
    
        if ( ! $screen) {
            return;
        }
    
        $screen->add_help_tab(
            array(
                'id'      => 'gpg_help_tab',
                'title'   => __( 'General Information:
                    '),
                'content' =>
                    '<h2>' . __( 'Gallery Information', $this->plugin_name) . '</h2>' .
                    '<p>' .
                        __( 'Photo Gallery is a cool responsive image gallery plugin with awesome layout options, stunning gallery and album views, designed with features that allow you not to just show photos in a beautiful way but to deliver the message hidden in them.',  $this->plugin_name ).'</p>'
            )
        );
    
        $screen->set_help_sidebar(
            '<p><strong>' . __( 'For more information:', $this->plugin_name) . '</strong></p>' .
            '<p>
                <a href="https://www.youtube.com/watch?v=4-TU48pc0R4" target="_blank">' . __( 'YouTube video tutorials' , $this->plugin_name ) . '</a>
            </p>' .
            '<p>
                <a href="https://ays-pro.com/wordpress-photo-gallery-user-manual" target="_blank">' . __( 'Documentation', $this->plugin_name ) . '</a>
            </p>' .
            '<p>
                <a href="https://ays-pro.com/wordpress/photo-gallery" target="_blank">' . __( 'Photo Gallery plugin Premium version', $this->plugin_name ) . '</a>
            </p>'
        );
    }

    public function add_plugin_row_meta($meta, $file) {

        if ($file == AYS_GPG_BASENAME) {
            $meta[] = '<a href="https://wordpress.org/support/plugin/gallery-photo-gallery/" target="_blank">' . esc_html__( 'Free Support', $this->plugin_name ) . '</a>';
        }

        return $meta;
    }


    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {
        $this->settings_obj = new Gallery_Settings_Actions($this->plugin_name);
        $action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
        switch ( $action ) {
            case 'add':
                include_once( 'partials/actions/gallery-photo-gallery-admin-actions.php' );
                break;
            case 'edit':
                include_once( 'partials/actions/gallery-photo-gallery-admin-actions.php' );
                break;
            default:
                include_once( 'partials/gallery-photo-gallery-admin-display.php' );
        }
    }

    public function display_plugin_gpg_categories_page(){
        $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
            case 'add':
                include_once('partials/categories/actions/gallery-photo-gallery-categories-actions.php');
                break;
            case 'edit':
                include_once('partials/categories/actions/gallery-photo-gallery-categories-actions.php');
                break;
            default:
                include_once('partials/categories/gallery-photo-gallery-categories-display.php');
        }
    }  

    public function display_plugin_gallery_categories_page(){
        $action = (isset($_GET['action'])) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
            case 'add':
                include_once('partials/gallery-categories/actions/gallery-photo-gallery-gpg-categories-actions.php');
                break;
            case 'edit':
                include_once('partials/gallery-categories/actions/gallery-photo-gallery-gpg-categories-actions.php');
                break;
            default:
                include_once('partials/gallery-categories/gallery-photo-gallery-gpg-categories-display.php');
        }
    }    

    public function screen_option_settings() {
        $this->settings_obj = new Gallery_Settings_Actions($this->plugin_name);
    }

    public function display_plugin_gallery_settings_page(){
        include_once('partials/settings/gallery-photo-gallery-settings.php');
    }

    public function display_plugin_gpg_features_page()
    {
        include_once('partials/features/gallery-photo-gallery-features-display.php');
    }
    public function display_plugin_how_to_use_page()
    {
        include_once('partials/how-to-use/gallery-photo-gallery-how-to-use.php');
    }
    
    public function display_plugin_gpg_featured_plugins_page()
    {
        include_once('partials/features/gallery-photo-gallery-featured-plugins.php');
    }

    public static function set_screen( $status, $option, $value ) {
        return $value;
    }


    public function screen_option_gallery() {
        $option = 'per_page';
        $args   = [
            'label'   => __('Galleries', $this->plugin_name),
            'default' => 20,
            'option'  => 'galleries_per_page'
        ];

        add_screen_option( $option, $args );
        $this->gallery_obj = new Galleries_List_Table($this->plugin_name);
    }

    public function screen_option_gallery_cats() {
        $option = 'per_page';
        $args   = array(
            'label'   => __('Image categories', $this->plugin_name),
            'default' => 5,
            'option'  => 'gallery_categories_per_page',
        );

        add_screen_option($option, $args);
        $this->cats_obj = new Gpg_Categories_List_Table($this->plugin_name);
    }

    public function screen_option_gallery_categories() {
        $option = 'per_page';
        $args   = array(
            'label'   => __('Gallery categories', $this->plugin_name),
            'default' => 5,
            'option'  => 'gallery_gpg_categories_per_page',
        );

        add_screen_option($option, $args);
        $this->gallery_cats_obj = new Gallery_Categories_List_Table($this->plugin_name);
    }

    public static function ays_get_gallery_image_categories(){
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_gallery_categories";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    public static function ays_get_gallery_categories(){
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}ays_gpg_gallery_categories";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    public static function ays_get_gpg_options(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'ays_gallery';
        $res = $wpdb->get_results("SELECT id, title, width, height FROM ".$table_name."");
        $aysGlobal_array = array();

        foreach($res as $ays_res_options){
            $aysStatic_array = array();
            $aysStatic_array[] = $ays_res_options->id;
            $aysStatic_array[] = $ays_res_options->title;
            $aysStatic_array[] = $ays_res_options->width;
            $aysStatic_array[] = $ays_res_options->height;
            $aysGlobal_array[] = $aysStatic_array;
        }
        return $aysGlobal_array;
      }
    
    function ays_gpg_register_tinymce_plugin($plugin_array) {

        $this->settings_obj = new Gallery_Settings_Actions($this->plugin_name);

        // General Settings | options
        $gen_options = ($this->settings_obj->ays_get_setting('options') === false) ? array() : json_decode( stripcslashes($this->settings_obj->ays_get_setting('options') ), true);

        // Show gallery button to Admins only
        $gen_options['show_gpg_button_to_admin_only'] = isset($gen_options['show_gpg_button_to_admin_only']) ? sanitize_text_field( $gen_options['show_gpg_button_to_admin_only'] ) : 'off';
        $show_gpg_button_to_admin_only = (isset($gen_options['show_gpg_button_to_admin_only']) && sanitize_text_field( $gen_options['show_gpg_button_to_admin_only'] ) == "on") ? true : false;

        if ( $show_gpg_button_to_admin_only ) {

            if( current_user_can( 'manage_options' ) ){
                $plugin_array['ays_gpg_button_mce'] = AYS_GPG_BASE_URL .'/ays_gpg_shortcode.js';
            }

        } else {
            $plugin_array['ays_gpg_button_mce'] = AYS_GPG_BASE_URL .'/ays_gpg_shortcode.js';
        }

        return $plugin_array;
    }
    
    function ays_gpg_add_tinymce_button($buttons) {
        $buttons[] = "ays_gpg_button_mce";
        return $buttons;
    }
    
    function gen_ays_gpg_shortcode_callback() {
        $shortcode_data = $this->ays_get_gpg_options();

        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title><?php echo __( 'Gallery Photo Gallery', $this->plugin_name ); ?></title>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
                <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>

                <?php
                    wp_print_scripts('jquery');
                ?>
                <base target="_self">
            </head>
            <body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" dir="ltr" class="forceColors">
                <div class="select-sb">

              <table align="center">
                  <tr>
                    <td><label for="ays_gpg">Gallery</label></td>
                    <td>
                      <span>
                        <select id="ays_gpg" style="padding: 2px; height: 25px; font-size: 16px;width:100%;">
                            <option>--Select Gallery--</option>
                                <?php foreach($shortcode_data as $index=>$data)
                                    echo '<option id="'.$data[0].'" value="'.$data[0].'" mw="'.$data[2].'" mh="'.$data[3].'" class="ays_gpg_options">'.$data[1].'</option>';
                                ?>
                        </select>
                        </span>
                    </td>
                  </tr>
              </table>
                </div>
                <div class="mceActionPanel">
                    <input type="submit" id="insert" name="insert" value="Insert" onClick="gpg_insert_shortcode();"/>
                </div>
            <script type="text/javascript">
                function gpg_insert_shortcode() {
                    var tagtext = '[gallery_p_gallery id="' + document.getElementById('ays_gpg')[document.getElementById('ays_gpg').selectedIndex].id + '"]';
                    window.tinyMCE.execCommand('mceInsertContent', false, tagtext);
                    tinyMCEPopup.close();
                }
              </script>

            </body>
          </html>
          <?php
          die();
      }
    
    
    public function ays_get_all_image_sizes() {
        $image_sizes = array();
        global $_wp_additional_image_sizes;
        $default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );

        foreach ( $default_image_sizes as $size ) {
            $image_sizes[$size]['width']	= intval( get_option( "{$size}_size_w") );
            $image_sizes[$size]['height'] = intval( get_option( "{$size}_size_h") );
            $image_sizes[$size]['crop']	= get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
        }

        if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) )
            $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );

        return $image_sizes;
    }

    public static function ays_restriction_string($type, $x, $length){
        $output = "";
        switch($type){
            case "char":                
                if(strlen($x)<=$length){
                    $output = $x;
                } else {
                    $output = substr($x,0,$length) . '...';
                }
                break;
            case "word":
                $res = explode(" ", $x);
                if(count($res)<=$length){
                    $output = implode(" ",$res);
                } else {
                    $res = array_slice($res,0,$length);
                    $output = implode(" ",$res) . '...';
                }
            break;
        }
        return $output;
    }
    
    public function vc_before_init_actions() {
        require_once( AYS_GPG_DIR.'pb_templates/gallery_photo_gallery_wpbvc.php' );
    }

    public function gpg_el_widgets_registered() {
        // We check if the Elementor plugin has been installed / activated.
        wp_enqueue_style( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
        if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
            // get our own widgets up and running:
            // copied from widgets-manager.php
            if ( class_exists( 'Elementor\Plugin' ) ) {
                if ( is_callable( 'Elementor\Plugin', 'instance' ) ) {
                    $elementor = Elementor\Plugin::instance();
                    if ( isset( $elementor->widgets_manager ) ) {
                        if ( method_exists( $elementor->widgets_manager, 'register_widget_type' ) ) {
                            $widget_file   = 'plugins/elementor/gallery_photo_gallery_elementor.php';
                            $template_file = locate_template( $widget_file );
                            if ( !$template_file || !is_readable( $template_file ) ) {
                                $template_file = AYS_GPG_DIR.'pb_templates/gallery_photo_gallery_elementor.php';
                            }
                            if ( $template_file && is_readable( $template_file ) ) {
                                require_once $template_file;
                                Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor\Widget_GPG_Custom_Elementor_Thing() );
                            }
                        }
                    }
                }
            }
        }
    }

    public function deactivate_plugin_option(){     

        // Run a security check.
        check_ajax_referer( 'gallery-ajax-deactivate-plugin-nonce', sanitize_key( $_REQUEST['_ajax_nonce'] ) );

        // Check for permissions.
        if ( ! current_user_can( 'manage_options' ) ) {
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
            echo json_encode(array(
                'option' => ''
            ));
            wp_die();
        }   

        if( is_user_logged_in() ) {
            $request_value = esc_sql( sanitize_text_field( $_REQUEST['upgrade_plugin'] ) );
            $upgrade_option = get_option('ays_gallery_photo_gallery_upgrade_plugin','');
            if($upgrade_option === ''){
                add_option('ays_gallery_photo_gallery_upgrade_plugin',$request_value);
            }else{
                update_option('ays_gallery_photo_gallery_upgrade_plugin',$request_value);
            }
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
            echo json_encode(array(
                'option' => get_option('ays_gallery_photo_gallery_upgrade_plugin', '')
            ));
            wp_die();
        } else {
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
            echo json_encode(array(
                'option' => ''
            ));
            wp_die();
        }
    }

    public function gallery_admin_footer($a){
        if(isset($_REQUEST['page'])){
            if(false !== strpos( sanitize_text_field( $_REQUEST['page'] ), $this->plugin_name)){
                ?>
                <div class="ays-gpg-footer-support-box">
                    <span class="ays-gpg-footer-link-row"><a href="https://wordpress.org/support/plugin/gallery-photo-gallery/" target="_blank"><?php echo __( "Support", $this->plugin_name); ?></a></span>
                    <span class="ays-gpg-footer-slash-row">/</span>
                    <span class="ays-gpg-footer-link-row"><a href="https://ays-pro.com/wordpress-photo-gallery-user-manual" target="_blank"><?php echo __( "Docs", $this->plugin_name); ?></a></span>
                    <span class="ays-gpg-footer-slash-row">/</span>
                    <span class="ays-gpg-footer-link-row"><a href="https://ays-demo.com/gallery-plugin-survey/" target="_blank"><?php echo __( "Suggest a Feature", $this->plugin_name); ?></a></span>
                </div>
                <p style="font-size:13px;text-align:center;font-style:italic;">
                    <span style="margin-left:0px;margin-right:10px;" class="ays_heart_beat"><i class="far fa-heart animated"></i></span>
                    <span><?php echo __( "If you love our plugin, please do big favor and rate us on", $this->plugin_name); ?></span> 
                    <a target="_blank" href='https://wordpress.org/support/plugin/gallery-photo-gallery/reviews/'>WordPress.org</a>
                    <a target="_blank" class="ays-rated-link" href='https://wordpress.org/support/plugin/gallery-photo-gallery/reviews/'>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                        <span class="ays-dashicons ays-dashicons-star-empty"></span>
                    </a>
                    <span class="ays_heart_beat"><i class="far fa-heart animated"></i></span>
                </p>
            <?php
            }
        }
    }

    public static function validateDate($date, $format = 'Y-m-d H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function ays_gpg_restriction_string($type, $x, $length){
        $output = "";
        switch($type){
            case "char":                
                if(strlen($x)<=$length){
                    $output = $x;
                } else {
                    $output = substr($x,0,$length) . '...';
                }
                break;
            case "word":
                $res = explode(" ", $x);
                if(count($res)<=$length){
                    $output = implode(" ",$res);
                } else {
                    $res = array_slice($res,0,$length);
                    $output = implode(" ",$res) . '...';
                }
            break;
        }
        return $output;
    }

    public static function get_gpg_listtables_title_length( $listtable_name ) {
        global $wpdb;

        $settings_table = $wpdb->prefix . "ays_gallery_settings";
        $sql = "SELECT meta_value FROM ".$settings_table." WHERE meta_key = 'options'";
        $result = $wpdb->get_var($sql);
        $options = ($result == "") ? array() : json_decode(stripcslashes($result), true);

        $listtable_title_length = 5;
        if(! empty($options) ){
            switch ( $listtable_name ) {
                case 'galleries':
                    $listtable_title_length = (isset($options['galleries_title_length']) && intval($options['galleries_title_length']) != 0) ? absint(intval($options['galleries_title_length'])) : 5;
                    break;
                 case 'image_categories':
                    $listtable_title_length = (isset($options['gpg_image_categories_title_length']) && intval($options['gpg_image_categories_title_length']) != 0) ? absint(sanitize_text_field($options['gpg_image_categories_title_length'])) : 5;
                    break;  
                 case 'gallery_categories':
                    $listtable_title_length = (isset($options['gpg_categories_title_length']) && intval($options['gpg_categories_title_length']) != 0) ? absint(sanitize_text_field($options['gpg_categories_title_length'])) : 5;
                    break;               
                default:
                    $listtable_title_length = 5;
                    break;
            }
            return $listtable_title_length;
        }
        return $listtable_title_length;
    }

    public function get_next_or_prev_gallery_by_id( $id, $type = "next" ) {
        global $wpdb;

        $gallery_table = esc_sql( $wpdb->prefix . "ays_gallery" );

        $where = array();
        $where_condition = "";

        $id     = (isset( $id ) && $id != "" && absint($id) != 0) ? absint( sanitize_text_field( $id ) ) : null;
        $type   = (isset( $type ) && $type != "") ? sanitize_text_field( $type ) : "next";

        if ( is_null( $id ) || $id == 0 ) {
            return null;
        }

        switch ( $type ) {            
            case 'prev':
                $where[] = ' `id` < ' . $id . ' ORDER BY `id` DESC ';;
                break;
            case 'next':
            default:
                $where[] = ' `id` > ' . $id;
                break;
        }

        if( ! empty($where) ){
            $where_condition = " WHERE " . implode( " AND ", $where );
        }

        $sql = "SELECT `id` FROM {$gallery_table} ". $where_condition ." LIMIT 1;";
        $results = $wpdb->get_row( $sql, 'ARRAY_A' );

        return $results;

    }

    public function get_next_or_prev_gallery_cat_by_id( $id, $type = "next" ) {
        global $wpdb;

        $gallery_cat_table = esc_sql( $wpdb->prefix . "ays_gallery_categories" );

        $where = array();
        $where_condition = "";

        $id     = (isset( $id ) && $id != "" && absint($id) != 0) ? absint( sanitize_text_field( $id ) ) : null;
        $type   = (isset( $type ) && $type != "") ? sanitize_text_field( $type ) : "next";

        if ( is_null( $id ) || $id == 0 ) {
            return null;
        }

        switch ( $type ) {            
            case 'prev':
                $where[] = ' `id` < ' . $id . ' ORDER BY `id` DESC ';
                break;
            case 'next':
            default:
                $where[] = ' `id` > ' . $id;
                break;
        }

        if( ! empty($where) ){
            $where_condition = " WHERE " . implode( " AND ", $where );
        }

        $sql = "SELECT `id` FROM {$gallery_cat_table} ". $where_condition ." LIMIT 1;";
        $results = $wpdb->get_row( $sql, 'ARRAY_A' );

        return $results;

    }

    public function get_next_or_prev_gallery_gpg_cat_by_id( $id, $type = "next" ) {
        global $wpdb;

        $gallery_cat_table = esc_sql( $wpdb->prefix . "ays_gpg_gallery_categories" );

        $where = array();
        $where_condition = "";

        $id     = (isset( $id ) && $id != "" && absint($id) != 0) ? absint( sanitize_text_field( $id ) ) : null;
        $type   = (isset( $type ) && $type != "") ? sanitize_text_field( $type ) : "next";

        if ( is_null( $id ) || $id == 0 ) {
            return null;
        }

        switch ( $type ) {            
            case 'prev':
                $where[] = ' `id` < ' . $id . ' ORDER BY `id` DESC ';
                break;
            case 'next':
            default:
                $where[] = ' `id` > ' . $id;
                break;
        }

        if( ! empty($where) ){
            $where_condition = " WHERE " . implode( " AND ", $where );
        }

        $sql = "SELECT `id` FROM {$gallery_cat_table} ". $where_condition ." LIMIT 1;";
        $results = $wpdb->get_row( $sql, 'ARRAY_A' );

        return $results;

    }

    public function ays_gpg_author_user_search() {
        $search = isset($_REQUEST['search']) && $_REQUEST['search'] != '' ? sanitize_text_field( $_REQUEST['search'] ) : null;
        $checked = isset($_REQUEST['val']) && $_REQUEST['val'] !='' ? sanitize_text_field( $_REQUEST['val'] ) : null;

        $args = 'search=';
        if($search !== null){
            $args .= '*';
            $args .= $search;
            $args .= '*';
        }

        $users = get_users($args);

        $content_text = array(
            'results' => array()
        );

        foreach ($users as $key => $value) {
            if ($checked !== null) {
                if ( !is_array( $checked ) ) {
                    $checked2 = $checked;
                    $checked = array();
                    $checked[] = absint($checked2);
                }
                if (in_array($value->ID, $checked)) {
                    continue;
                }else{
                    $content_text['results'][] = array(
                        'id' => $value->ID,
                        'text' => $value->data->display_name,
                    );
                }
            }else{
                $content_text['results'][] = array(
                    'id' => $value->ID,
                    'text' => $value->data->display_name,
                );
            }
        }

        ob_end_clean();
        echo json_encode($content_text);
        wp_die();
    }

    public function ays_gallery_generate_message_vars_html( $gallery_message_vars ) {
        $content = array();
        $var_counter = 0; 

        $content[] = '<div class="ays-gpg-message-vars-box">';
            $content[] = '<div class="ays-gpg-message-vars-icon">';
                $content[] = '<div>';
                    $content[] = '<i class="ays_fa ays_fa_link"></i>';
                $content[] = '</div>';
                $content[] = '<div>';
                    $content[] = '<span>'. __("Message Variables" , $this->plugin_name) .'</span>';
                    $content[] = '<a class="ays_help" data-toggle="tooltip" data-html="true" title="'. __("Insert your preferred message variable into the editor by clicking." , $this->plugin_name) .'">';
                        $content[] = '<i class="fas fa-info-circle"></i>';
                    $content[] = '</a>';
                $content[] = '</div>';
            $content[] = '</div>';
            $content[] = '<div class="ays-gpg-message-vars-data">';
                foreach($gallery_message_vars as $var => $var_name){
                    $var_counter++;
                    $content[] = '<label class="ays-gpg-message-vars-each-data-label">';
                        $content[] = '<input type="radio" class="ays-gpg-message-vars-each-data-checker" hidden id="ays_gpg_message_var_count_'. $var_counter .'" name="ays_gpg_message_var_count">';
                        $content[] = '<div class="ays-gpg-message-vars-each-data">';
                            $content[] = '<input type="hidden" class="ays-gpg-message-vars-each-var" value="'. $var .'">';
                            $content[] = '<span>'. $var_name .'</span>';
                        $content[] = '</div>';
                    $content[] = '</label>';
                }
            $content[] = '</div>';
        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public static function get_gallery_max_id( $table ) {
        global $wpdb;
        $db_table = $wpdb->prefix . 'ays_'.$table;;

        $sql = "SELECT MAX(id) FROM {$db_table}";

        $result = intval( $wpdb->get_var( $sql ) );

        return $result;
    }

    public function display_plugin_add_new_gallery_page() {
        $add_new_gpg_url = admin_url('admin.php?page=' . $this->plugin_name . '&action=add');
        wp_redirect($add_new_gpg_url);
    }

    public function ays_gpg_dismiss_button(){

        $data = array(
            'status' => false,
        );

        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'ays_gpg_dismiss_button') { 
            if( (isset( $_REQUEST['_ajax_nonce'] ) && wp_verify_nonce( $_REQUEST['_ajax_nonce'], 'photo-gallery-sale-banner' )) && current_user_can( 'manage_options' )){
                update_option('ays_gpg_sale_btn', 1);
                update_option('ays_gpg_sale_date', current_time( 'mysql' ));
                $data['status'] = true;
            }
        }

        ob_end_clean();
        $ob_get_clean = ob_get_clean();
        echo json_encode($data);
        wp_die();
    }

    public function ays_gpg_update_banner_time(){

        $date = time() + ( 3 * 24 * 60 * 60 ) + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS);
        // $date = time() + ( 60 ) + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS); // for testing | 1 min
        $next_3_days = date('M d, Y H:i:s', $date);

        $ays_gpg_banner_time = get_option('ays_gpg_banner_time');

        if ( !$ays_gpg_banner_time || is_null( $ays_gpg_banner_time ) ) {
            update_option('ays_gpg_banner_time', $next_3_days ); 
        }

        $get_ays_gpg_banner_time = get_option('ays_gpg_banner_time');

        $val = 60*60*24*0.5; // half day
        // $val = 60; // for testing | 1 min

        $current_date = current_time( 'mysql' );
        $date_diff = strtotime($current_date) - intval(strtotime($get_ays_gpg_banner_time));

        $days_diff = $date_diff / $val;
        if(intval($days_diff) > 0 ){
            update_option('ays_gpg_banner_time', $next_3_days);
        }

        return $get_ays_gpg_banner_time;
    }

    /**
     * Determine if the plugin/addon installations are allowed.
     *
     * @since 1.3.9
     *
     * @param string $type Should be `plugin` or `addon`.
     *
     * @return bool
     */
    public static function ays_gpg_can_install( $type ) {

        return self::ays_gpg_can_do( 'install', $type );
    }

    /**
     * Determine if the plugin/addon activations are allowed.
     *
     * @since 1.3.9
     *
     * @param string $type Should be `plugin` or `addon`.
     *
     * @return bool
     */
    public static function ays_gpg_can_activate( $type ) {

        return self::ays_gpg_can_do( 'activate', $type );
    }

    /**
     * Determine if the plugin/addon installations/activations are allowed.
     *
     * @since 1.3.9
     *
     * @param string $what Should be 'activate' or 'install'.
     * @param string $type Should be `plugin` or `addon`.
     *
     * @return bool
     */
    public static function ays_gpg_can_do( $what, $type ) {

        if ( ! in_array( $what, array( 'install', 'activate' ), true ) ) {
            return false;
        }

        if ( ! in_array( $type, array( 'plugin', 'addon' ), true ) ) {
            return false;
        }

        $capability = $what . '_plugins';

        if ( ! current_user_can( $capability ) ) {
            return false;
        }

        // Determine whether file modifications are allowed and it is activation permissions checking.
        if ( $what === 'install' && ! wp_is_file_mod_allowed( 'ays_gpg_can_install' ) ) {
            return false;
        }

        // All plugin checks are done.
        if ( $type === 'plugin' ) {
            return true;
        }
        return false;
    }

    /**
     * Activate plugin.
     *
     * @since 1.0.0
     * @since 1.3.9 Updated the permissions checking.
     */
    public function ays_gpg_activate_plugin() {

        // Run a security check.
        check_ajax_referer( $this->plugin_name . '-install-plugin-nonce', sanitize_key( $_REQUEST['_ajax_nonce'] ) );

        // Check for permissions.
        if ( ! current_user_can( 'activate_plugins' ) ) {
            wp_send_json_error( esc_html__( 'Plugin activation is disabled for you on this site.', $this->plugin_name ) );
        }

        $type = 'addon';

        if ( isset( $_POST['plugin'] ) ) {

            if ( ! empty( $_POST['type'] ) ) {
                $type = sanitize_key( $_POST['type'] );
            }

            $plugin   = sanitize_text_field( wp_unslash( $_POST['plugin'] ) );
            $activate = activate_plugins( $plugin );

            if ( ! is_wp_error( $activate ) ) {
                if ( $type === 'plugin' ) {
                    wp_send_json_success( esc_html__( 'Plugin activated.', $this->plugin_name ) );
                } else {
                        ( esc_html__( 'Addon activated.', $this->plugin_name ) );
                }
            }
        }

        if ( $type === 'plugin' ) {
            wp_send_json_error( esc_html__( 'Could not activate the plugin. Please activate it on the Plugins page.', $this->plugin_name ) );
        }

        wp_send_json_error( esc_html__( 'Could not activate the addon. Please activate it on the Plugins page.', $this->plugin_name ) );
    }

    /**
     * Install addon.
     *
     * @since 1.0.0
     * @since 1.3.9 Updated the permissions checking.
     */
    public function ays_gpg_install_plugin() {

        // Run a security check.
        check_ajax_referer( $this->plugin_name . '-install-plugin-nonce', sanitize_key( $_REQUEST['_ajax_nonce'] ) );

        $generic_error = esc_html__( 'There was an error while performing your request.', $this->plugin_name );
        $type          = ! empty( $_POST['type'] ) ? sanitize_key( $_POST['type'] ) : '';

        // Check if new installations are allowed.
        if ( ! self::ays_gpg_can_install( $type ) ) {
            wp_send_json_error( $generic_error );
        }

        $error = $type === 'plugin'
            ? esc_html__( 'Could not install the plugin. Please download and install it manually.', $this->plugin_name )
            : "";

        $plugin_url = ! empty( $_POST['plugin'] ) ? esc_url_raw( wp_unslash( $_POST['plugin'] ) ) : '';

        if ( empty( $plugin_url ) ) {
            wp_send_json_error( $error );
        }

        // Prepare variables.
        $url = esc_url_raw(
            add_query_arg(
                [
                    'page' => 'gallery-photo-gallery-featured-plugins',
                ],
                admin_url( 'admin.php' )
            )
        );

        ob_start();
        $creds = request_filesystem_credentials( $url, '', false, false, null );

        // Hide the filesystem credentials form.
        ob_end_clean();

        // Check for file system permissions.
        if ( $creds === false ) {
            wp_send_json_error( $error );
        }
        
        if ( ! WP_Filesystem( $creds ) ) {
            wp_send_json_error( $error );
        }

        /*
         * We do not need any extra credentials if we have gotten this far, so let's install the plugin.
         */
        require_once AYS_GPG_DIR . 'includes/admin/class-gallery-photo-gallery-upgrader.php';
        require_once AYS_GPG_DIR . 'includes/admin/class-gallery-photo-gallery-install-skin.php';
        require_once AYS_GPG_DIR . 'includes/admin/class-gallery-photo-gallery-skin.php';


        // Do not allow WordPress to search/download translations, as this will break JS output.
        remove_action( 'upgrader_process_complete', array( 'Language_Pack_Upgrader', 'async_upgrade' ), 20 );

        // Create the plugin upgrader with our custom skin.
        $installer = new GalleryPhotoGallery\Helpers\GalleryPhotoGalleryPluginSilentUpgrader( new Gallery_Photo_Gallery_Install_Skin() );

        // Error check.
        if ( ! method_exists( $installer, 'install' ) ) {
            wp_send_json_error( $error );
        }

        $installer->install( $plugin_url );

        // Flush the cache and return the newly installed plugin basename.
        wp_cache_flush();

        $plugin_basename = $installer->plugin_info();

        if ( empty( $plugin_basename ) ) {
            wp_send_json_error( $error );
        }

        $result = array(
            'msg'          => $generic_error,
            'is_activated' => false,
            'basename'     => $plugin_basename,
        );

        // Check for permissions.
        if ( ! current_user_can( 'activate_plugins' ) ) {
            $result['msg'] = $type === 'plugin' ? esc_html__( 'Plugin installed.', $this->plugin_name ) : "";

            wp_send_json_success( $result );
        }

        // Activate the plugin silently.
        $activated = activate_plugin( $plugin_basename );
        remove_action( 'activated_plugin', array( 'ays_sccp_activation_redirect_method', 'poll_maker_activation_redirect_method' ), 100 );

        if ( ! is_wp_error( $activated ) ) {

            $result['is_activated'] = true;
            $result['msg']          = $type === 'plugin' ? esc_html__( 'Plugin installed and activated.', $this->plugin_name ) : esc_html__( 'Addon installed and activated.', $this->plugin_name );

            wp_send_json_success( $result );
        }

        // Fallback error just in case.
        wp_send_json_error( $result );
    }

    /**
     * List of AM plugins that we propose to install.
     *
     * @since 1.3.9
     *
     * @return array
     */
    protected function gpg_get_am_plugins() {
        if ( !isset( $_SESSION ) ) {
            session_start();
        }

        $images_url = AYS_GPG_ADMIN_URL . '/images/icons/';

        $plugin_slug = array(
            'quiz-maker',
            'survey-maker',
            'poll-maker',
            'ays-popup-box',
            'secure-copy-content-protection',
            'personal-dictionary',
            'chart-builder',
            'easy-form',
        );

        $plugin_url_arr = array();
        foreach ($plugin_slug as $key => $slug) {
            if ( isset( $_SESSION['ays_gpg_our_product_links'] ) && !empty( $_SESSION['ays_gpg_our_product_links'] ) 
                && isset( $_SESSION['ays_gpg_our_product_links'][$slug] ) && !empty( $_SESSION['ays_gpg_our_product_links'][$slug] ) ) {
                $plugin_url = (isset( $_SESSION['ays_gpg_our_product_links'][$slug] ) && $_SESSION['ays_gpg_our_product_links'][$slug] != "") ? esc_url( $_SESSION['ays_gpg_our_product_links'][$slug] ) : "";
            } else {
                $latest_version = $this->ays_gpg_get_latest_plugin_version($slug);
                $plugin_url = 'https://downloads.wordpress.org/plugin/'. $slug .'.zip';
                if ( $latest_version != '' ) {
                    $plugin_url = 'https://downloads.wordpress.org/plugin/'. $slug .'.'. $latest_version .'.zip';
                    $_SESSION['ays_gpg_our_product_links'][$slug] = $plugin_url;
                }
            }

            $plugin_url_arr[$slug] = $plugin_url;
        }

        $plugins_array = array(
           'quiz-maker/quiz-maker.php'        => array(
                'icon'        => $images_url . 'quiz-128x128.png',
                'name'        => __( 'Quiz Maker', $this->plugin_name ),
                'desc'        => __( 'With our Quiz Maker plugin it’s easy to make a quiz in a short time.', $this->plugin_name ),
                'desc_hidden' => __( 'You to add images to your quiz, order unlimited questions. Also you can style your quiz to satisfy your visitors.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/quiz-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/quiz-maker/',
                'url'         => $plugin_url_arr['quiz-maker'],
            ),
            'survey-maker/survey-maker.php'        => array(
                'icon'        => $images_url . 'survey-128x128.png',
                'name'        => __( 'Survey Maker', $this->plugin_name ),
                'desc'        => __( 'Make amazing online surveys and get real-time feedback quickly and easily.', $this->plugin_name ),
                'desc_hidden' => __( 'Learn what your website visitors want, need, and expect with the help of Survey Maker. Build surveys without limiting your needs.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/survey-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/survey-maker',
                'url'         => $plugin_url_arr['survey-maker'],
            ),
            'poll-maker/poll-maker-ays.php'        => array(
                'icon'        => $images_url . 'poll-128x128.png',
                'name'        => __( 'Poll Maker', $this->plugin_name ),
                'desc'        => __( 'Create amazing online polls for your WordPress website super easily.', $this->plugin_name ),
                'desc_hidden' => __( 'Build up various types of polls in a minute and get instant feedback on any topic or product.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/poll-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/poll-maker/',
                'url'         => $plugin_url_arr['poll-maker'],
            ),
            'ays-popup-box/ays-pb.php'        => array(
                'icon'        => $images_url . 'popup-128x128.png',
                'name'        => __( 'Popup Box', $this->plugin_name ),
                'desc'        => __( 'Popup everything you want! Create informative and promotional popups all in one plugin.', $this->plugin_name ),
                'desc_hidden' => __( 'Attract your visitors and convert them into email subscribers and paying customers.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/ays-popup-box/',
                'buy_now'     => 'https://ays-pro.com/wordpress/popup-box/',
                'url'         => $plugin_url_arr['ays-popup-box'],
            ),
            'secure-copy-content-protection/secure-copy-content-protection.php'        => array(
                'icon'        => $images_url . 'sccp-128x128.png',
                'name'        => __( 'Secure Copy Content Protection', $this->plugin_name ),
                'desc'        => __( 'Disable the right click, copy paste, content selection and copy shortcut keys on your website.', $this->plugin_name ),
                'desc_hidden' => __( 'Protect web content from being plagiarized. Prevent plagiarism from your website with this easy to use plugin.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/secure-copy-content-protection/',
                'buy_now'     => 'https://ays-pro.com/wordpress/secure-copy-content-protection/',
                'url'         => $plugin_url_arr['secure-copy-content-protection'],
            ),
            'personal-dictionary/personal-dictionary.php'        => array(
                'icon'        => $images_url . 'pd-logo-128x128.png',
                'name'        => __( 'Personal Dictionary', $this->plugin_name ),
                'desc'        => __( 'Allow your students to create personal dictionary, study and memorize the words.', $this->plugin_name ),
                'desc_hidden' => __( 'Allow your users to create their own digital dictionaries and learn new words and terms as fastest as possible.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/personal-dictionary/',
                'buy_now'     => 'https://ays-pro.com/wordpress/personal-dictionary/',
                'url'         => $plugin_url_arr['personal-dictionary'],
            ),
            'chart-builder/chart-builder.php'        => array(
                'icon'        => $images_url . 'chartify-150x150.png',
                'name'        => __( 'Chart Builder', $this->plugin_name ),
                'desc'        => __( 'Chart Builder plugin allows you to create beautiful charts', $this->plugin_name ),
                'desc_hidden' => __( ' and graphs easily and quickly.', $this->plugin_name ),
                'wporg'       => 'https://wordpress.org/plugins/chart-builder/',
                'buy_now'     => 'https://ays-pro.com/wordpress/chart-builder/',
                'url'         => $plugin_url_arr['chart-builder'],
            ),
            'easy-form/easy-form.php'        => array(
                'icon'        => $images_url . 'easyform-150x150.png',
                'name'        => __( 'Easy Form', 'chart-builder' ),
                'desc'        => __( 'Choose the best WordPress form builder plugin. ', 'chart-builder' ),
                'desc_hidden' => __( 'Create contact forms, payment forms, surveys, and many more custom forms. Build forms easily with us.', 'chart-builder' ),
                'wporg'       => 'https://wordpress.org/plugins/easy-form/',
                'buy_now'     => 'https://ays-pro.com/wordpress/easy-form',
                'url'         => $plugin_url_arr['easy-form'],
            ),
        );

        return $plugins_array;
    }

    protected function ays_gpg_get_latest_plugin_version( $slug ){

        if ( is_null( $slug ) || empty($slug) ) {
            return "";
        }

        $version_latest = "";

        if ( ! function_exists( 'plugins_api' ) ) {
              require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
        }

        // set the arguments to get latest info from repository via API ##
        $args = array(
            'slug' => $slug,
            'fields' => array(
                'version' => true,
            )
        );

        /** Prepare our query */
        $call_api = plugins_api( 'plugin_information', $args );

        /** Check for Errors & Display the results */
        if ( is_wp_error( $call_api ) ) {
            $api_error = $call_api->get_error_message();
        } else {

            //echo $call_api; // everything ##
            if ( ! empty( $call_api->version ) ) {
                $version_latest = $call_api->version;
            }
        }

        return $version_latest;
    }

    /**
     * Get AM plugin data to display in the Addons section of About tab.
     *
     * @since 6.4.0.4
     *
     * @param string $plugin      Plugin slug.
     * @param array  $details     Plugin details.
     * @param array  $all_plugins List of all plugins.
     *
     * @return array
     */
    protected function gpg_get_plugin_data( $plugin, $details, $all_plugins ) {

        $have_pro = ( ! empty( $details['pro'] ) && ! empty( $details['pro']['plug'] ) );
        $show_pro = false;

        $plugin_data = array();

        if ( $have_pro ) {
            if ( array_key_exists( $plugin, $all_plugins ) ) {
                if ( is_plugin_active( $plugin ) ) {
                    $show_pro = true;
                }
            }
            if ( array_key_exists( $details['pro']['plug'], $all_plugins ) ) {
                $show_pro = true;
            }
            if ( $show_pro ) {
                $plugin  = $details['pro']['plug'];
                $details = $details['pro'];
            }
        }

        if ( array_key_exists( $plugin, $all_plugins ) ) {
            if ( is_plugin_active( $plugin ) ) {
                // Status text/status.
                $plugin_data['status_class'] = 'status-active';
                $plugin_data['status_text']  = esc_html__( 'Active', $this->plugin_name );
                // Button text/status.
                $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-gpg-card__btn-info disabled';
                $plugin_data['action_text']  = esc_html__( 'Activated', $this->plugin_name );
                $plugin_data['plugin_src']   = esc_attr( $plugin );
            } else {
                // Status text/status.
                $plugin_data['status_class'] = 'status-installed';
                $plugin_data['status_text']  = esc_html__( 'Inactive', $this->plugin_name );
                // Button text/status.
                $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-gpg-card__btn-info';
                $plugin_data['action_text']  = esc_html__( 'Activate', $this->plugin_name );
                $plugin_data['plugin_src']   = esc_attr( $plugin );
            }
        } else {
            // Doesn't exist, install.
            // Status text/status.
            $plugin_data['status_class'] = 'status-missing';

            if ( isset( $details['act'] ) && 'go-to-url' === $details['act'] ) {
                $plugin_data['status_class'] = 'status-go-to-url';
            }
            $plugin_data['status_text'] = esc_html__( 'Not Installed', $this->plugin_name );
            // Button text/status.
            $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-gpg-card__btn-info';
            $plugin_data['action_text']  = esc_html__( 'Install Plugin', $this->plugin_name );
            $plugin_data['plugin_src']   = esc_url( $details['url'] );
        }

        $plugin_data['details'] = $details;

        return $plugin_data;
    }

    /**
     * Display the Addons section of About tab.
     *
     * @since 1.3.9
     */
    public function gpg_output_about_addons() {

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $all_plugins          = get_plugins();
        $am_plugins           = $this->gpg_get_am_plugins();
        $can_install_plugins  = self::ays_gpg_can_install( 'plugin' );
        $can_activate_plugins = self::ays_gpg_can_activate( 'plugin' );

        $content = '';
        $content.= '<div class="ays-gpg-cards-block">';
        foreach ( $am_plugins as $plugin => $details ){

            $plugin_data = $this->gpg_get_plugin_data( $plugin, $details, $all_plugins );
            $plugin_ready_to_activate = $can_activate_plugins
                && isset( $plugin_data['status_class'] )
                && $plugin_data['status_class'] === 'status-installed';
            $plugin_not_activated     = ! isset( $plugin_data['status_class'] )
                || $plugin_data['status_class'] !== 'status-active';

            $plugin_action_class = ( isset( $plugin_data['action_class'] ) && esc_attr( $plugin_data['action_class'] ) != "" ) ? esc_attr( $plugin_data['action_class'] ) : "";

            $plugin_action_class_disbaled = "";
            if ( strpos($plugin_action_class, 'status-active') !== false ) {
                $plugin_action_class_disbaled = "disbaled='true'";
            }

            $content .= '
                <div class="ays-gpg-card">
                    <div class="ays-gpg-card__content flexible">
                        <div class="ays-gpg-card__content-img-box">
                            <img class="ays-gpg-card__img" src="'. esc_url( $plugin_data['details']['icon'] ) .'" alt="'. esc_attr( $plugin_data['details']['name'] ) .'">
                        </div>
                        <div class="ays-gpg-card__text-block">
                            <h5 class="ays-gpg-card__title">'. esc_html( $plugin_data['details']['name'] ) .'</h5>
                            <p class="ays-gpg-card__text">'. wp_kses_post( $plugin_data['details']['desc'] ) .'
                                <span class="ays-gpg-card__text-hidden">
                                    '. wp_kses_post( $plugin_data['details']['desc_hidden'] ) .'
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="ays-gpg-card__footer">';
                        if ( $can_install_plugins || $plugin_ready_to_activate || ! $details['wporg'] ) {
                            $content .= '<button class="'. esc_attr( $plugin_data['action_class'] ) .'" data-plugin="'. esc_attr( $plugin_data['plugin_src'] ) .'" data-type="plugin" '. $plugin_action_class_disbaled .'>
                                '. wp_kses_post( $plugin_data['action_text'] ) .'
                            </button>';
                        }
                        elseif ( $plugin_not_activated ) {
                            $content .= '<a href="'. esc_url( $details['wporg'] ) .'" target="_blank" rel="noopener noreferrer">
                                '. esc_html_e( 'WordPress.org', $this->plugin_name ) .'
                                <span aria-hidden="true" class="dashicons dashicons-external"></span>
                            </a>';
                        }
            $content .='
                        <a target="_blank" href="'. esc_url( $plugin_data['details']['buy_now'] ) .'" class="ays-gpg-card__btn-primary">'. __('Buy Now', $this->plugin_name) .'</a>
                    </div>
                </div>';
        }
        $install_plugin_nonce = wp_create_nonce( $this->plugin_name . '-install-plugin-nonce' );
        $content.= '<input type="hidden" id="ays_gpg_ajax_install_plugin_nonce" name="ays_gpg_ajax_install_plugin_nonce" value="'. $install_plugin_nonce .'">';
        $content.= '</div>';

        echo $content;
    }
}
