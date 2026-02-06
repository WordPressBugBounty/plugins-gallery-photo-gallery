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

        if(false === strpos($hook_suffix, $this->plugin_name))
            return;

        wp_enqueue_style( $this->plugin_name . "-banner", plugin_dir_url( __FILE__ ) . 'css/gallery-photo-gallery-banner.css', array(), $this->version, 'all' );

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

            wp_enqueue_script( $this->plugin_name . "sweetalert-js", plugin_dir_url( __FILE__ ) . 'js/sweetalert2.all.min.js', array( 'jquery' ), $this->version, true );

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
            'selectUser'         => __( 'Select user', 'gallery-photo-gallery'),
            'pleaseEnterMore'    => __( "Please enter 1 or more characters", 'gallery-photo-gallery' ),
            'searching'          => __( "Searching...", 'gallery-photo-gallery' ),
            'loader_message'     => __('Just a moment...', 'gallery-photo-gallery'),            
            "emptyEmailError"    => __( 'Email field is empty', 'gallery-photo-gallery'),
            "invalidEmailError"  => __( 'Invalid Email address', 'gallery-photo-gallery'),           
            'activated'          => __( "Activated", 'gallery-photo-gallery' ),
            'errorMsg'           => __( "Error", 'gallery-photo-gallery' ),
            'loadResource'       => __( "Can't load resource.", 'gallery-photo-gallery' ),
            'somethingWentWrong' => __( "Maybe something went wrong.", 'gallery-photo-gallery' ),
            'greateJob'          => __( 'Great job', 'gallery-photo-gallery'),
            'formMoreDetailed'   => __( 'For more detailed configuration visit', 'gallery-photo-gallery'),
            'greate'             => __( 'Great!', 'gallery-photo-gallery'),
        ));

        $gpg_banner_date = self::ays_gpg_update_banner_time();
        wp_localize_script( $this->plugin_name, 'galleryLangObj', array(
            'gpgBannerDate'             => $gpg_banner_date,
            'copied'                    => esc_html__( 'Copied!', 'gallery-photo-gallery'),
            'clickForCopy'              => esc_html__( 'Click for copy.', 'gallery-photo-gallery'),
            'addGif'                    => esc_html__( 'Add Gif', 'gallery-photo-gallery'),
            'somethingWentWrong'        => esc_html__( "Maybe something went wrong.", 'gallery-photo-gallery' ),
            'errorMsg'                  => esc_html__( "Error", 'gallery-photo-gallery' ),
            'youCanUseThisShortcodeTop' => esc_html__( 'Your Gallery is Created!', 'gallery-photo-gallery'),
            'youGalleriesIsCreated'       => esc_html__('Your Gallery is Created!', 'gallery-photo-gallery'),
            'youCanUseThisShortcodeBtm' => esc_html__( 'Copy the generated shortcode and paste it into any post or page to display Gallery.', 'gallery-photo-gallery'),
            'youCanUuseThisShortcode'   => esc_html__( 'Copy the generated shortcode and paste it into any post or page to display Gallery', 'gallery-photo-gallery'),
            'greateJob'                 => esc_html__( 'Great job', 'gallery-photo-gallery'),
            'editGalleryPage'           => esc_html__( 'edit gallery page', 'gallery-photo-gallery'),
            'formMoreDetailed'          => esc_html__( 'For more detailed configuration visit', 'gallery-photo-gallery'),
            'editGalleryPage'           => esc_html__( 'edit gallery page', 'gallery-photo-gallery'),
            'greate'                    => esc_html__( 'Done!', 'gallery-photo-gallery'),
            'thumbsUpGreat'             => esc_html__( 'Thumbs up, great!', 'gallery-photo-gallery'),
            'preivewGallery'            => esc_html__( 'Preview Gallery', 'gallery-photo-gallery' ),
            'successCopyCoupon'         => esc_html__( "Coupon code copied!", 'gallery-photo-gallery' ),
            'failedCopyCoupon'          => esc_html__( "Failed to copy coupon code", 'gallery-photo-gallery' ),

        ) );
        
        $cats = $this->ays_get_gallery_image_categories();
        wp_localize_script($this->plugin_name,  'ays_gpg_admin', array(
            'categories' => $cats,
            'nextGalleryPage' => __( 'Are you sure you want to go to the next gallery page?', 'gallery-photo-gallery'),
            'prevGalleryPage' => __( 'Are you sure you want to go to the previous gallery page?', 'gallery-photo-gallery'),
        ));
        wp_enqueue_script( $this->plugin_name.'-wp-color-picker-alpha', plugin_dir_url( __FILE__ ) . 'js/wp-color-picker-alpha.min.js',array( 'wp-color-picker' ),$this->version, true );

        $color_picker_strings = array(
            'clear'            => __( 'Clear', 'gallery-photo-gallery' ),
            'clearAriaLabel'   => __( 'Clear color', 'gallery-photo-gallery' ),
            'defaultString'    => __( 'Default', 'gallery-photo-gallery' ),
            'defaultAriaLabel' => __( 'Select default color', 'gallery-photo-gallery' ),
            'pick'             => __( 'Select Color', 'gallery-photo-gallery' ),
            'defaultLabel'     => __( 'Color value', 'gallery-photo-gallery' ),
        );
        wp_localize_script( $this->plugin_name.'-wp-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );
	}

    /**
     * De-register JavaScript files for the admin area.
     *
     * @since    1.0.0
     */
    public function disable_scripts($hook_suffix) {
        if (false !== strpos($hook_suffix, $this->plugin_name)) {
            if (is_plugin_active('ai-engine/ai-engine.php')) {
                wp_deregister_script('mwai');
                wp_deregister_script('mwai-vendor');
                wp_dequeue_script('mwai');
                wp_dequeue_script('mwai-vendor');
            }

            if (is_plugin_active('html5-video-player/html5-video-player.php')) {
                wp_dequeue_style('h5vp-admin');
                wp_dequeue_style('fs_common');
            }

            if (is_plugin_active('panorama/panorama.php')) {
                wp_dequeue_style('bppiv_admin_custom_css');
                wp_dequeue_style('bppiv-custom-style');
            }

            if (is_plugin_active('wp-social/wp-social.php')) {
                wp_dequeue_style('wp_social_select2_css');
                wp_deregister_script('wp_social_select2_js');
                wp_dequeue_script('wp_social_select2_js');
            }

            if (is_plugin_active('real-media-library-lite/index.php')) {
                wp_dequeue_style('real-media-library-lite-rml');
            }

            // Theme | Pixel Ebook Store
            wp_dequeue_style('pixel-ebook-store-free-demo-content-style');

            // Theme | Interactive Education
            wp_dequeue_style('interactive-education-free-demo-content-style');

            // Theme | Phlox 2.17.6
            wp_dequeue_style('auxin-admin-style');
        }
    }

    public function ays_gpg_disable_all_notice_from_plugin() {
        if (!function_exists('get_current_screen')) {
            return;
        }

        $screen = get_current_screen();

        if (empty($screen) || strpos($screen->id, $this->plugin_name) === false) {
            return;
        }

        global $wp_filter;

        // Keep plugin-specific notices
        $our_plugin_notices = array();

        $exclude_functions = [
            'general_gpg_admin_notice',
        ];

        if (!empty($wp_filter['admin_notices'])) {
            foreach ($wp_filter['admin_notices']->callbacks as $priority => $callbacks) {
                foreach ($callbacks as $key => $callback) {
                    // For class-based methods
                    if (
                        is_array($callback['function']) &&
                        is_object($callback['function'][0]) &&
                        get_class($callback['function'][0]) === __CLASS__
                    ) {
                        $our_plugin_notices[$priority][$key] = $callback;
                    }                    
                    elseif (
                        is_array($callback['function']) &&
                        is_object($callback['function'][0]) &&
                        get_class($callback['function'][0]) === 'Photo_Gallery_Data'
                    ) {
                        $our_plugin_notices[$priority][$key] = $callback;
                    }
                    // For standalone functions
                    elseif (
                        is_string($callback['function']) &&
                        in_array($callback['function'], $exclude_functions)
                    ) {
                        $our_plugin_notices[$priority][$key] = $callback;
                    }
                }
            }
        }

        // Remove all notices
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');

        // Re-add only your plugin's notices
        foreach ($our_plugin_notices as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                add_action('admin_notices', $callback['function'], $priority);
            }
        }
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
            __('Photo Gallery', 'gallery-photo-gallery'), 
            __('Photo Gallery', 'gallery-photo-gallery'), 
            'manage_options', 
            $this->plugin_name, 
            array($this, 'display_plugin_setup_page'), AYS_GPG_ADMIN_URL . 'images/icons/icon-gpg-128x128.svg', 6);
        add_action( "load-$hook_gallery", array( $this, 'screen_option_gallery' ) );
        add_action( "load-$hook_gallery", array( $this, 'add_tabs' ));
        
        $hook_gallery = add_submenu_page(
            $this->plugin_name,
            __('All Galleries', 'gallery-photo-gallery'),
            __('All Galleries', 'gallery-photo-gallery'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );
        add_action( "load-$hook_gallery", array( $this, 'screen_option_gallery' ) );

        $hook_add_new = add_submenu_page(
            $this->plugin_name,
            __('Add new', 'gallery-photo-gallery'),
            __('Add new', 'gallery-photo-gallery'),
            'manage_options',
            $this->plugin_name . '-add-new',
            array($this, 'display_plugin_add_new_gallery_page')
        );
        add_action( "load-$hook_add_new", array( $this, 'add_tabs' ));

        $hook_image_categories = add_submenu_page(
            $this->plugin_name,
            __('Image Categories', 'gallery-photo-gallery'),
            __('Image Categories', 'gallery-photo-gallery'),
            'manage_options',
            $this->plugin_name . '-categories',
            array($this, 'display_plugin_gpg_categories_page')
        );
        add_action("load-$hook_image_categories", array($this, 'screen_option_gallery_cats'));
        add_action( "load-$hook_image_categories", array( $this, 'add_tabs' ));


        $hook_gallery_categories = add_submenu_page(
            $this->plugin_name,
            __('Gallery Categories', 'gallery-photo-gallery'),
            __('Gallery Categories', 'gallery-photo-gallery'),
            'manage_options',
            $this->plugin_name . '-gpg-categories',
            array($this, 'display_plugin_gallery_categories_page')
        );
        add_action("load-$hook_gallery_categories", array($this, 'screen_option_gallery_categories'));
        add_action( "load-$hook_gallery_categories", array( $this, 'add_tabs' ));

        $hook_settings = add_submenu_page( $this->plugin_name,
            __('General Settings', 'gallery-photo-gallery'),
            __('General Settings', 'gallery-photo-gallery'),
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_plugin_gallery_settings_page') 
        );
        add_action("load-$hook_settings", array($this, 'screen_option_settings'));        
        add_action( "load-$hook_settings", array( $this, 'add_tabs' ));

        $hook_howtouse = add_submenu_page(
            $this->plugin_name,
            __('How to use', 'gallery-photo-gallery'),
            __('How to use', 'gallery-photo-gallery'),
            'manage_options',
            $this->plugin_name . '-dashboard',
            array($this, 'display_plugin_how_to_use_page')
        );
        add_action( "load-$hook_howtouse", array( $this, 'add_tabs' ));

        $hook_ourproducts = add_submenu_page(
            $this->plugin_name,
            __('Our products', 'gallery-photo-gallery'),
            __('Our products', 'gallery-photo-gallery'),
            'manage_options',
            $this->plugin_name . '-featured-plugins',
            array($this, 'display_plugin_gpg_featured_plugins_page')
        );
        add_action( "load-$hook_ourproducts", array( $this, 'add_tabs' ));

        $hook_profeatures = add_submenu_page(
            $this->plugin_name,
            __('PRO Features', 'gallery-photo-gallery'),
            __('PRO Features', 'gallery-photo-gallery'),
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
            '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', 'gallery-photo-gallery') . '</a>',
            '<a href="https://ays-demo.com/wordpress-photo-gallery-plugin-free-demo/" target="_blank">' . __('Demo', 'gallery-photo-gallery') . '</a>',
            '<a href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard-gallery&utm_medium=free-gallery&utm_campaign=buy-now-gallery" target="_blank" class="ays-admin-plugins-upgrade-link" style="font-weight:bold;">' . __('Upgrade 30% Sale', 'gallery-photo-gallery') . '</a>
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
                    ', 'gallery-photo-gallery'),
                'content' =>
                    '<h2>' . __( 'Gallery Information', 'gallery-photo-gallery') . '</h2>' .
                    '<p>' .
                        __( 'Photo Gallery is a cool responsive image gallery plugin with awesome layout options, stunning gallery and album views, designed with features that allow you not to just show photos in a beautiful way but to deliver the message hidden in them.',  'gallery-photo-gallery' ).'</p>'
            )
        );
    
        $screen->set_help_sidebar(
            '<p><strong>' . __( 'For more information:', 'gallery-photo-gallery') . '</strong></p>' .
            '<p>
                <a href="https://www.youtube.com/watch?v=4-TU48pc0R4" target="_blank">' . __( 'YouTube video tutorials' , 'gallery-photo-gallery' ) . '</a>
            </p>' .
            '<p>
                <a href="https://ays-pro.com/wordpress-photo-gallery-user-manual" target="_blank">' . __( 'Documentation', 'gallery-photo-gallery' ) . '</a>
            </p>' .
            '<p>
                <a href="https://ays-pro.com/wordpress/photo-gallery" target="_blank">' . __( 'Photo Gallery plugin Premium version', 'gallery-photo-gallery' ) . '</a>
            </p>' .
            '<p>
                <a href="https://ays-demo.com/wordpress-photo-gallery-plugin-pro-demo/" target="_blank">' . __( 'Photo Gallery plugin demo', 'gallery-photo-gallery' ) . '</a>
            </p>'
        );
    }

    public function add_plugin_row_meta( $meta, $file ) {

        if ($file == AYS_GPG_BASENAME) {
            $meta[] = '<a href="https://wordpress.org/support/plugin/gallery-photo-gallery/" target="_blank">' . esc_html__( 'Free Support', 'gallery-photo-gallery' ) . '</a>';
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
        $this->settings_obj = new Gallery_Settings_Actions( $this->plugin_name );
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
            'label'   => __('Galleries', 'gallery-photo-gallery'),
            'default' => 20,
            'option'  => 'galleries_per_page'
        ];

        add_screen_option( $option, $args );
        $this->gallery_obj = new Galleries_List_Table($this->plugin_name);
    }

    public function screen_option_gallery_cats() {
        $option = 'per_page';
        $args   = array(
            'label'   => __('Image categories', 'gallery-photo-gallery'),
            'default' => 5,
            'option'  => 'gallery_categories_per_page',
        );

        add_screen_option($option, $args);
        $this->cats_obj = new Gpg_Categories_List_Table($this->plugin_name);
    }

    public function screen_option_gallery_categories() {
        $option = 'per_page';
        $args   = array(
            'label'   => __('Gallery categories', 'gallery-photo-gallery'),
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
                <title><?php echo __( 'Gallery Photo Gallery', 'gallery-photo-gallery' ); ?></title>
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
                    <span class="ays-gpg-footer-link-row"><a href="https://wordpress.org/support/plugin/gallery-photo-gallery/" target="_blank"><?php echo __( "Support", 'gallery-photo-gallery'); ?></a></span>
                    <span class="ays-gpg-footer-slash-row">/</span>
                    <span class="ays-gpg-footer-link-row"><a href="https://ays-pro.com/wordpress-photo-gallery-user-manual" target="_blank"><?php echo __( "Docs", 'gallery-photo-gallery'); ?></a></span>
                    <span class="ays-gpg-footer-slash-row">/</span>
                    <span class="ays-gpg-footer-link-row"><a href="https://ays-demo.com/gallery-plugin-survey/" target="_blank"><?php echo __( "Suggest a Feature", 'gallery-photo-gallery'); ?></a></span>
                </div>
                <p style="font-size:13px;text-align:center;font-style:italic;">
                    <span style="margin-left:0px;margin-right:10px;" class="ays_heart_beat"><i class="far fa-heart animated"></i></span>
                    <span><?php echo __( "If you love our plugin, please do big favor and rate us on", 'gallery-photo-gallery'); ?></span> 
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
                    $content[] = '<span>'. __("Message Variables" , 'gallery-photo-gallery') .'</span>';
                    $content[] = '<a class="ays_help" data-toggle="tooltip" data-html="true" title="'. __("Insert your preferred message variable into the editor by clicking." , 'gallery-photo-gallery') .'">';
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

    public static function ays_gpg_update_banner_time(){

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
            wp_send_json_error( esc_html__( 'Plugin activation is disabled for you on this site.', 'gallery-photo-gallery' ) );
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
                    wp_send_json_success( esc_html__( 'Plugin activated.', 'gallery-photo-gallery' ) );
                } else {
                        ( esc_html__( 'Addon activated.', 'gallery-photo-gallery' ) );
                }
            }
        }

        if ( $type === 'plugin' ) {
            wp_send_json_error( esc_html__( 'Could not activate the plugin. Please activate it on the Plugins page.', 'gallery-photo-gallery' ) );
        }

        wp_send_json_error( esc_html__( 'Could not activate the addon. Please activate it on the Plugins page.', 'gallery-photo-gallery' ) );
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

        $generic_error = esc_html__( 'There was an error while performing your request.', 'gallery-photo-gallery' );
        $type          = ! empty( $_POST['type'] ) ? sanitize_key( $_POST['type'] ) : '';

        // Check if new installations are allowed.
        if ( ! self::ays_gpg_can_install( $type ) ) {
            wp_send_json_error( $generic_error );
        }

        $error = $type === 'plugin'
            ? esc_html__( 'Could not install the plugin. Please download and install it manually.', 'gallery-photo-gallery' )
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
            $result['msg'] = $type === 'plugin' ? esc_html__( 'Plugin installed.', 'gallery-photo-gallery' ) : "";

            wp_send_json_success( $result );
        }

        // Activate the plugin silently.
        $activated = activate_plugin( $plugin_basename );
        remove_action( 'activated_plugin', array( 'ays_sccp_activation_redirect_method', 'poll_maker_activation_redirect_method' ), 100 );

        if ( ! is_wp_error( $activated ) ) {

            $result['is_activated'] = true;
            $result['msg']          = $type === 'plugin' ? esc_html__( 'Plugin installed and activated.', 'gallery-photo-gallery' ) : esc_html__( 'Addon installed and activated.', 'gallery-photo-gallery' );

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
            'fox-lms',
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
            'fox-lms/fox-lms.php'        => array(
                'icon'        => $images_url . 'icon-fox-lms-128x128.png',
                'name'        => __( 'Fox LMS', 'gallery-photo-gallery' ),
                'desc'        => __( 'Build and manage online courses directly on your WordPress site.', 'gallery-photo-gallery' ),
                'desc_hidden' => __( 'With the FoxLMS plugin, you can create, sell, and organize courses, lessons, and quizzes, transforming your website into a dynamic e-learning platform.', 'gallery-photo-gallery' ),
                'wporg'       => 'https://wordpress.org/plugins/fox-lms/',
                'buy_now'     => 'https://foxlms.com/pricing/?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=fox-lms-our-products-page',
                'url'         => $plugin_url_arr['fox-lms'],
            ),
            'quiz-maker/quiz-maker.php'        => array(
                'icon'        => $images_url . 'quiz-128x128.png',
                'name'        => __( 'Quiz Maker', 'gallery-photo-gallery' ),
                'desc'        => __( 'With our Quiz Maker plugin it’s easy to make a quiz in a short time.', 'gallery-photo-gallery' ),
                'desc_hidden' => __( 'You to add images to your quiz, order unlimited questions. Also you can style your quiz to satisfy your visitors.', 'gallery-photo-gallery' ),
                'wporg'       => 'https://wordpress.org/plugins/quiz-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/quiz-maker/',
                'url'         => $plugin_url_arr['quiz-maker'],
            ),
            'survey-maker/survey-maker.php'        => array(
                'icon'        => $images_url . 'survey-128x128.png',
                'name'        => __( 'Survey Maker', 'gallery-photo-gallery' ),
                'desc'        => __( 'Make amazing online surveys and get real-time feedback quickly and easily.', 'gallery-photo-gallery' ),
                'desc_hidden' => __( 'Learn what your website visitors want, need, and expect with the help of Survey Maker. Build surveys without limiting your needs.', 'gallery-photo-gallery' ),
                'wporg'       => 'https://wordpress.org/plugins/survey-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/survey-maker',
                'url'         => $plugin_url_arr['survey-maker'],
            ),
            'poll-maker/poll-maker-ays.php'        => array(
                'icon'        => $images_url . 'poll-128x128.png',
                'name'        => __( 'Poll Maker', 'gallery-photo-gallery' ),
                'desc'        => __( 'Create amazing online polls for your WordPress website super easily.', 'gallery-photo-gallery' ),
                'desc_hidden' => __( 'Build up various types of polls in a minute and get instant feedback on any topic or product.', 'gallery-photo-gallery' ),
                'wporg'       => 'https://wordpress.org/plugins/poll-maker/',
                'buy_now'     => 'https://ays-pro.com/wordpress/poll-maker/',
                'url'         => $plugin_url_arr['poll-maker'],
            ),
            'ays-popup-box/ays-pb.php'        => array(
                'icon'        => $images_url . 'popup-128x128.png',
                'name'        => __( 'Popup Box', 'gallery-photo-gallery' ),
                'desc'        => __( 'Popup everything you want! Create informative and promotional popups all in one plugin.', 'gallery-photo-gallery' ),
                'desc_hidden' => __( 'Attract your visitors and convert them into email subscribers and paying customers.', 'gallery-photo-gallery' ),
                'wporg'       => 'https://wordpress.org/plugins/ays-popup-box/',
                'buy_now'     => 'https://ays-pro.com/wordpress/popup-box/',
                'url'         => $plugin_url_arr['ays-popup-box'],
            ),
            'secure-copy-content-protection/secure-copy-content-protection.php'        => array(
                'icon'        => $images_url . 'sccp-128x128.png',
                'name'        => __( 'Secure Copy Content Protection', 'gallery-photo-gallery' ),
                'desc'        => __( 'Disable the right click, copy paste, content selection and copy shortcut keys on your website.', 'gallery-photo-gallery' ),
                'desc_hidden' => __( 'Protect web content from being plagiarized. Prevent plagiarism from your website with this easy to use plugin.', 'gallery-photo-gallery' ),
                'wporg'       => 'https://wordpress.org/plugins/secure-copy-content-protection/',
                'buy_now'     => 'https://ays-pro.com/wordpress/secure-copy-content-protection/',
                'url'         => $plugin_url_arr['secure-copy-content-protection'],
            ),
            'personal-dictionary/personal-dictionary.php'        => array(
                'icon'        => $images_url . 'pd-logo-128x128.png',
                'name'        => __( 'Personal Dictionary', 'gallery-photo-gallery' ),
                'desc'        => __( 'Allow your students to create personal dictionary, study and memorize the words.', 'gallery-photo-gallery' ),
                'desc_hidden' => __( 'Allow your users to create their own digital dictionaries and learn new words and terms as fastest as possible.', 'gallery-photo-gallery' ),
                'wporg'       => 'https://wordpress.org/plugins/personal-dictionary/',
                'buy_now'     => 'https://ays-pro.com/wordpress/personal-dictionary/',
                'url'         => $plugin_url_arr['personal-dictionary'],
            ),
            'chart-builder/chart-builder.php'        => array(
                'icon'        => $images_url . 'chartify-150x150.png',
                'name'        => __( 'Chart Builder', 'gallery-photo-gallery' ),
                'desc'        => __( 'Chart Builder plugin allows you to create beautiful charts', 'gallery-photo-gallery' ),
                'desc_hidden' => __( ' and graphs easily and quickly.', 'gallery-photo-gallery' ),
                'wporg'       => 'https://wordpress.org/plugins/chart-builder/',
                'buy_now'     => 'https://ays-pro.com/wordpress/chart-builder/',
                'url'         => $plugin_url_arr['chart-builder'],
            ),
            'easy-form/easy-form.php'        => array(
                'icon'        => $images_url . 'easyform-150x150.png',
                'name'        => __( 'Easy Form', 'gallery-photo-gallery' ),
                'desc'        => __( 'Choose the best WordPress form builder plugin. ', 'gallery-photo-gallery' ),
                'desc_hidden' => __( 'Create contact forms, payment forms, surveys, and many more custom forms. Build forms easily with us.', 'gallery-photo-gallery' ),
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
                $plugin_data['status_text']  = esc_html__( 'Active', 'gallery-photo-gallery' );
                // Button text/status.
                $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-gpg-card__btn-info disabled';
                $plugin_data['action_text']  = esc_html__( 'Activated', 'gallery-photo-gallery' );
                $plugin_data['plugin_src']   = esc_attr( $plugin );
            } else {
                // Status text/status.
                $plugin_data['status_class'] = 'status-installed';
                $plugin_data['status_text']  = esc_html__( 'Inactive', 'gallery-photo-gallery' );
                // Button text/status.
                $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-gpg-card__btn-info';
                $plugin_data['action_text']  = esc_html__( 'Activate', 'gallery-photo-gallery' );
                $plugin_data['plugin_src']   = esc_attr( $plugin );
            }
        } else {
            // Doesn't exist, install.
            // Status text/status.
            $plugin_data['status_class'] = 'status-missing';

            if ( isset( $details['act'] ) && 'go-to-url' === $details['act'] ) {
                $plugin_data['status_class'] = 'status-go-to-url';
            }
            $plugin_data['status_text'] = esc_html__( 'Not Installed', 'gallery-photo-gallery' );
            // Button text/status.
            $plugin_data['action_class'] = $plugin_data['status_class'] . ' ays-gpg-card__btn-info';
            $plugin_data['action_text']  = esc_html__( 'Install Plugin', 'gallery-photo-gallery' );
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
                                '. esc_html_e( 'WordPress.org', 'gallery-photo-gallery' ) .'
                                <span aria-hidden="true" class="dashicons dashicons-external"></span>
                            </a>';
                        }
            $content .='
                        <a target="_blank" href="'. esc_url( $plugin_data['details']['buy_now'] ) .'" class="ays-gpg-card__btn-primary">'. __('Buy Now', 'gallery-photo-gallery') .'</a>
                    </div>
                </div>';
        }
        $install_plugin_nonce = wp_create_nonce( $this->plugin_name . '-install-plugin-nonce' );
        $content .= '<input type="hidden" id="ays_gpg_ajax_install_plugin_nonce" name="ays_gpg_ajax_install_plugin_nonce" value="'. $install_plugin_nonce .'">';
        $content .= '</div>';

        echo $content;
    }

    public function ays_gpg_black_friady_popup_box(){
        if(!empty($_REQUEST['page']) && sanitize_text_field( $_REQUEST['page'] ) != $this->plugin_name . "-admin-dashboard"){
            if(false !== strpos( sanitize_text_field( $_REQUEST['page'] ), $this->plugin_name)){

                $flag = true;

                if( isset($_COOKIE['aysGpgBlackFridayPopupCount']) && intval($_COOKIE['aysGpgBlackFridayPopupCount']) >= 2 ){
                    $flag = false;
                }

                $ays_gpg_cta_button_link = esc_url('https://ays-pro.com/photography-bundle?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=mega-bundle-popup-black-friday-sale-' . AYS_GALLERY_VERSION);

                if( $flag ){
                ?>
                <div class="ays-gpg-black-friday-popup-overlay" style="opacity: 0; visibility: hidden; display: none;">
                  <div class="ays-gpg-black-friday-popup-dialog">
                    <div class="ays-gpg-black-friday-popup-content">
                      <div class="ays-gpg-black-friday-popup-background-pattern">
                        <div class="ays-gpg-black-friday-popup-pattern-row">
                          <div class="ays-gpg-black-friday-popup-pattern-text">SALE SALE SALE</div>
                          <div class="ays-gpg-black-friday-popup-pattern-text">SALE SALE SALE</div>
                        </div>
                        <div class="ays-gpg-black-friday-popup-pattern-row">
                          <div class="ays-gpg-black-friday-popup-pattern-text">SALE SALE SALE</div>
                          <div class="ays-gpg-black-friday-popup-pattern-text">SALE SALE SALE</div>
                        </div>
                        <div class="ays-gpg-black-friday-popup-pattern-row">
                          <div class="ays-gpg-black-friday-popup-pattern-text">SALE SALE SALE</div>
                          <div class="ays-gpg-black-friday-popup-pattern-text">SALE SALE SALE</div>
                        </div>
                        <div class="ays-gpg-black-friday-popup-pattern-row">
                          <div class="ays-gpg-black-friday-popup-pattern-text">SALE SALE SALE</div>
                          <div class="ays-gpg-black-friday-popup-pattern-text">SALE SALE SALE</div>
                        </div>
                      </div>
                      
                      <button class="ays-gpg-black-friday-popup-close" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M18 6 6 18"></path>
                          <path d="m6 6 12 12"></path>
                        </svg>
                      </button>
                      
                      <div class="ays-gpg-black-friday-popup-badge">
                        <div class="ays-gpg-black-friday-popup-badge-content">
                          <div class="ays-gpg-black-friday-popup-badge-text-sm"><?php echo esc_html__( 'Up to', 'gallery-photo-gallery' ); ?></div>
                          <div class="ays-gpg-black-friday-popup-badge-text-lg">50%</div>
                          <div class="ays-gpg-black-friday-popup-badge-text-md"><?php echo esc_html__( 'OFF', 'gallery-photo-gallery' ); ?></div>
                        </div>
                      </div>
                      
                      <div class="ays-gpg-black-friday-popup-main-content">
                        <div class="ays-gpg-black-friday-popup-hashtag"><?php echo esc_html__( '#BLACKFRIDAY', 'gallery-photo-gallery' ); ?></div>
                        <h1 class="ays-gpg-black-friday-popup-title-mega"><?php echo esc_html__( 'PHOTOGRAPHY', 'gallery-photo-gallery' ); ?></h1>
                        <h1 class="ays-gpg-black-friday-popup-title-bundle"><?php echo esc_html__( 'BUNDLE', 'gallery-photo-gallery' ); ?></h1>
                        <div class="ays-gpg-black-friday-popup-offer-label">
                          <h2 class="ays-gpg-black-friday-popup-offer-text"><?php echo esc_html__( 'BLACK FRIDAY OFFER', 'gallery-photo-gallery' ); ?></h2>
                        </div>
                        <p class="ays-gpg-black-friday-popup-description"><?php echo esc_html__( 'Get our exclusive plugins in one bundle', 'gallery-photo-gallery' ); ?></p>
                        <a href="<?php echo esc_url($ays_gpg_cta_button_link); ?>" target="_blank" class="ays-gpg-black-friday-popup-cta-btn"><?php echo esc_html__( 'Get Photography Bundle', 'gallery-photo-gallery' ); ?></a>
                      </div>
                    </div>
                  </div>
                </div>
                <script type="text/javascript">
                    (function() {
                      var overlay = document.querySelector('.ays-gpg-black-friday-popup-overlay');
                      var closeBtn = document.querySelector('.ays-gpg-black-friday-popup-close');
                      var learnMoreBtn = document.querySelector('.ays-gpg-black-friday-popup-learn-more');
                      var ctaBtn = document.querySelector('.ays-gpg-black-friday-popup-cta-btn');

                      // Cookie helper functions
                      function setCookie(name, value, days) {
                        var expires = "";
                        if (days) {
                          var date = new Date();
                          date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                          expires = "; expires=" + date.toUTCString();
                        }
                        document.cookie = name + "=" + (value || "") + expires + "; path=/";
                      }

                      function getCookie(name) {
                        var nameEQ = name + "=";
                        var ca = document.cookie.split(';');
                        for (var i = 0; i < ca.length; i++) {
                          var c = ca[i];
                          while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                          if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                        }
                        return null;
                      }

                      // Get current show count from cookie
                      var showCount = parseInt(getCookie('aysGpgBlackFridayPopupCount') || '0', 10);
                      var maxShows = 2;

                      // Show popup function
                      function showPopup() {
                        if (overlay && showCount < maxShows) {
                          overlay.classList.add('ays-gpg-black-friday-popup-active');
                          showCount++;
                          // Update cookie with new count (expires in 30 days)
                          setCookie('aysGpgBlackFridayPopupCount', showCount.toString(), 30);
                        }
                      }

                      // Close popup function
                      function closePopup(e) {
                        if (e) {
                          e.preventDefault();
                          e.stopPropagation();
                        }
                        if (overlay) {
                          overlay.classList.remove('ays-gpg-black-friday-popup-active');
                        }
                      }

                      // Determine timing based on show count
                      if (showCount === 0) {
                        // First time - show after 30 seconds
                        setTimeout(function() {
                          showPopup();
                        }, 30000);
                      } else if (showCount === 1) {
                        // Second time - show after 200 seconds
                        setTimeout(function() {
                          showPopup();
                        }, 200000);
                      }
                      // If showCount >= 2, don't show popup at all

                      // Close button
                      if (closeBtn) {
                        closeBtn.addEventListener('click', function(e) {
                          closePopup(e);
                        });
                      }

                      // Learn more button
                      if (learnMoreBtn) {
                        learnMoreBtn.addEventListener('click', function(e) {
                          closePopup(e);
                        });
                      }

                      // CTA button (optional - if you want it to close popup too)
                      if (ctaBtn) {
                        ctaBtn.addEventListener('click', function(e) {
                          // You can add redirect logic here if needed
                          // window.location.href = 'your-url';
                        });
                      }

                      // Close on overlay click
                      if (overlay) {
                        overlay.addEventListener('click', function(e) {
                          if (e.target === overlay) {
                            closePopup(e);
                          }
                        });
                      }

                      // Close on Escape key
                      document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && overlay && overlay.classList.contains('ays-gpg-black-friday-popup-active')) {
                          closePopup();
                        }
                      });
                    })();
                </script>
                <style>
                    .ays-gpg-black-friday-popup-overlay{position:fixed;top:0;left:0;right:0;bottom:0;z-index:9999;background-color:rgba(0,0,0,.8);display:flex;align-items:center;justify-content:center;opacity:0;visibility:hidden;transition:opacity .2s,visibility .2s}.ays-gpg-black-friday-popup-overlay.ays-gpg-black-friday-popup-active{display:flex!important;opacity:1!important;visibility:visible!important}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-dialog{position:relative;max-width:470px;width:100%;border-radius:8px;overflow:hidden;background:0 0;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);transform:scale(.95);transition:transform .2s}.ays-gpg-black-friday-popup-overlay.ays-gpg-black-friday-popup-active .ays-gpg-black-friday-popup-dialog{transform:scale(1)}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-content{position:relative;width:470px;height:410px;background:linear-gradient(to right bottom,#c056f5,#f042f0,#7d7de8);overflow:hidden}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-background-pattern{position:absolute;top:0;left:0;right:0;bottom:0;opacity:.07;pointer-events:none;transform:rotate(-12deg) translateY(32px);overflow:hidden}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-pattern-row{display:flex;gap:16px;margin-bottom:16px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-pattern-text{color:#fff;font-weight:900;font-size:96px;white-space:nowrap;line-height:1}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-close{position:absolute;top:16px;right:16px;z-index:9999;background:0 0;border:none;color:rgba(255,255,255,.8);cursor:pointer;padding:4px;transition:color .2s;line-height:0}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-close:hover,.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-learn-more:hover{color:#fff}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge{position:absolute;top:32px;right:32px;width:96px;height:96px;background-color:#d4fc79;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);animation:3s ease-in-out infinite ays-gpg-black-friday-popup-float}@keyframes ays-gpg-black-friday-popup-float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-content{text-align:center}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-sm{color:#1a1a1a;font-weight:900;font-size:24px;line-height:1}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-lg{color:#1a1a1a;font-weight:900;font-size:30px;line-height:1;margin-top:4px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-md{color:#1a1a1a;font-weight:900;font-size:20px;line-height:1}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-main-content{position:relative;z-index:10;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:0 48px;text-align:center}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-hashtag{color:rgba(255,255,255,.9);font-weight:700;font-size:14px;margin-bottom:16px;letter-spacing:.1em}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-title-mega{color:#fff;font-weight:900;font-size:27px;line-height:1;margin:0 0 12px;text-shadow:0 4px 6px rgba(0,0,0,.1)}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-title-bundle{color:#fff;font-weight:900;font-size:27px;line-height:1;margin:0 0 24px;text-shadow:0 4px 6px rgba(0,0,0,.1)}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-offer-label{background-color:#000;padding:12px 32px;margin-bottom:24px;display:inline-block}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-offer-text{color:#fff;font-weight:700;font-size:20px;letter-spacing:.05em;margin:0}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-description{color:rgba(255,255,255,.95);font-size:18px;font-weight:500;margin:0 0 32px!important}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-cta-btn{display:inline-flex;align-items:center;justify-content:center;height:48px;background-color:#fff;color:#a855f7;font-size:18px;font-weight:700;border:none;border-radius:24px;padding:0 40px;cursor:pointer;box-shadow:0 20px 25px -5px rgba(0,0,0,.1);transition:.2s;text-decoration:none}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-cta-btn:hover{background-color:rgba(255,255,255,.9);box-shadow:0 25px 50px -12px rgba(0,0,0,.25);transform:scale(1.05)}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-learn-more{background:0 0;border:none;color:rgba(255,255,255,.9);font-size:14px;text-decoration:underline;text-underline-offset:4px;cursor:pointer;padding:8px;margin-top:16px;transition:color .2s}@media (max-width:768px){.ays-gpg-black-friday-popup-overlay{display:none!important}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-content{width:90vw;max-width:400px;height:380px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-main-content{padding:0 32px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge{width:80px;height:80px;top:24px;right:24px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-sm{font-size:20px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-lg{font-size:26px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-md,.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-offer-text{font-size:18px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-title-bundle,.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-title-mega{font-size:48px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-description{font-size:16px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-pattern-text{font-size:72px}}@media (max-width:480px){.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-content{width:95vw;max-width:340px;height:360px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-main-content{padding:0 24px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge{width:70px;height:70px;top:20px;right:20px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-sm,.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-offer-text{font-size:16px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-lg{font-size:22px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-badge-text-md{font-size:14px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-hashtag{font-size:12px;margin-bottom:12px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-title-bundle,.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-title-mega{font-size:40px;margin-bottom:8px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-offer-label{padding:10px 24px;margin-bottom:20px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-description{font-size:15px;margin-bottom:24px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-cta-btn{font-size:16px;height:44px;padding:0 32px}.ays-gpg-black-friday-popup-overlay .ays-gpg-black-friday-popup-pattern-text{font-size:60px}}
                </style>
                <?php
                }
            }
        }
    }
}
