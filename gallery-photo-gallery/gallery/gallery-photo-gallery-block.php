<?php
    /**
     * Enqueue front end and editor JavaScript
     */

    function ays_gpg_gutenberg_scripts() {        
        global $current_screen;
        global $wp_version;
        $version1 = $wp_version;
        $operator = '>=';
        $version2 = '5.3.1';
        $versionCompare = aysGalleryVersionCompare($version1, $operator, $version2);
        if( ! $current_screen ){
            return null;
        }

        if( ! $current_screen->is_block_editor ){
            return null;
        }

        // wp_enqueue_script( AYS_GALLERY_NAME, AYS_GPG_PUBLIC_URL . '/js/gallery-photo-gallery-public.js', array('jquery'), AYS_GALLERY_VERSION, true);        

        // Enqueue the bundled block JS file
        if( $versionCompare ){
            wp_enqueue_script(
                'gallery-photo-gallery-block-js',
                AYS_GPG_BASE_URL ."/gallery/gallery-photo-gallery-block-new.js",
                array( 'jquery', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ),
                AYS_GALLERY_VERSION, true
            );
        }
        else{
            wp_enqueue_script(
                'gallery-photo-gallery-block-js',
                AYS_GPG_BASE_URL ."/gallery/gallery-photo-gallery-block.js",
                array( 'jquery', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ),
                AYS_GALLERY_VERSION, true
            );
        }
        
        // wp_enqueue_style( AYS_GALLERY_NAME, AYS_GPG_PUBLIC_URL . '/css/gallery-photo-gallery-public.css', array(), AYS_GALLERY_VERSION, 'all');

        // Enqueue the bundled block CSS file
        if( $versionCompare ){            
            wp_enqueue_style(
                'gallery-photo-gallery-block-css',
                AYS_GPG_BASE_URL ."/gallery/gallery-photo-gallery-block-new.css",
                array(),
                AYS_GALLERY_VERSION, 'all'
            );
        }
        else{            
            wp_enqueue_style(
                'gallery-photo-gallery-block-css',
                AYS_GPG_BASE_URL ."/gallery/gallery-photo-gallery-block.css",
                array(),
                AYS_GALLERY_VERSION, 'all'
            );
        }
    }

    function ays_gpg_gutenberg_block_register() {
        
        global $wpdb;
        $block_name = 'gallery';
        $block_namespace = 'gallery-photo-gallery/' . $block_name;
        
        $sql = "SELECT * FROM ". $wpdb->prefix . "ays_gallery";
        $results = $wpdb->get_results($sql, "ARRAY_A");
        
        register_block_type(
            $block_namespace, 
            array(
                'render_callback'   => 'gallery_p_gallery_render_callback',
                'editor_script'     => 'gallery-photo-gallery-block-js',
                'style'             => 'gallery-photo-gallery-block-css',
                'attributes'	    => array(
                    'idner' => $results,
                    'metaFieldValue' => array(
                        'type'  => 'integer', 
                    ),
                    'shortcode' => array(
                        'type'  => 'string',				
                    ),
                    'className' => array(
                        'type'  => 'string',
                    ),
                    'openPopupId' => array(
                        'type'  => 'string',
                    ),
                ),                
            )
        );       
    }    
    
    function gallery_p_gallery_render_callback( $attributes ) { 

        $ays_html = "<div class='ays-gallery-render-callback-box'></div>";

        if(isset($attributes["metaFieldValue"]) && $attributes["metaFieldValue"] === 0) {
            return $ays_html;
        }

        if(isset($attributes["shortcode"]) && $attributes["shortcode"] != '') {
            // $ays_html = do_shortcode( $attributes["shortcode"] );
            $ays_html = $attributes["shortcode"] ;
        }
        return $ays_html;
    }

    function aysGalleryVersionCompare($version1, $operator, $version2) {
    
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

    if(function_exists("register_block_type")){
            // Hook scripts function into block editor hook
        add_action( 'enqueue_block_editor_assets', 'ays_gpg_gutenberg_scripts' );
        add_action( 'init', 'ays_gpg_gutenberg_block_register' );
    }

    function ays_gpg_is_chat_available() {

        // Define the working days and working hours
        $workingDays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        $startHour = 9; // 09:00 AM
        $endHour = 18;  // 06:00 PM

        // Get the current WordPress time (in server's timezone)
        $currentTime = current_time('timestamp'); // Server's current time in WordPress timezone

        // Get the server's GMT offset (in hours)
        $gmtOffset = get_option('gmt_offset'); // e.g., -4 for GMT-4 or +3 for GMT+3

        // Convert the server's time to your desired timezone
        // Calculate the difference between the server's time and our time
        $desiredOffset = 4;
        $offsetDifference = $desiredOffset - $gmtOffset;

        // Adjust the time based on the offset difference
        $adjustedTime = $currentTime + ($offsetDifference * 3600); // Add or subtract hours

        // Create a DateTime object from the adjusted time
        $adjustedDateTime = date('Y-m-d H:i:s', $adjustedTime); // Format it in a readable format

        // Get the day of the week and the hour in the adjusted time
        $dayOfWeek = date('l', strtotime($adjustedDateTime)); // e.g., 'Monday'
        $hour = (int) date('G', strtotime($adjustedDateTime)); // Get the hour in 24-hour format

        // Check if the current time is within working hours and working days
        if (in_array($dayOfWeek, $workingDays) && $hour >= $startHour && $hour < $endHour) {
            return true; // Chat is available
        } else {
            return false; // Chat is not available
        }
    }