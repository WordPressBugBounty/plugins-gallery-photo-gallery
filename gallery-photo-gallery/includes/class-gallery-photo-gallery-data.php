<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Photo_Gallery_Data {    

    public static function ays_gpg_sale_baner(){

        if(isset($_POST['ays_gpg_sale_btn']) && (isset( $_POST['photo-gallery-sale-banner'] ) && wp_verify_nonce( $_POST['photo-gallery-sale-banner'], 'photo-gallery-sale-banner' )) &&
              current_user_can( 'manage_options' )){        
            update_option('ays_gpg_sale_btn', 1);
            update_option('ays_gpg_sale_date', current_time( 'mysql' ));
        }

        if(isset($_POST['ays_gpg_sale_btn_for_two_months'])){
            update_option('ays_gpg_sale_btn_for_two_months', 1);
            update_option('ays_gpg_sale_date', current_time( 'mysql' ));
        }

        $ays_gpg_sale_date = get_option('ays_gpg_sale_date');
       
        $ays_gpg_sale_two_months = get_option('ays_gpg_sale_btn_for_two_months');

        $val = 60*60*24*5;
        if($ays_gpg_sale_two_months == 1){
            $val = 60*60*24*61;
        }

        $current_date = current_time( 'mysql' );
        $date_diff = strtotime($current_date) -  intval(strtotime($ays_gpg_sale_date)) ;
       
        $days_diff = $date_diff / $val;

        if(intval($days_diff) > 0 ){
         
            update_option('ays_gpg_sale_btn', 0);
            update_option('ays_gpg_sale_btn_for_two_months', 0);
        }

       
        $ays_gpg_ishmar = intval(get_option('ays_gpg_sale_btn'));
        $ays_gpg_ishmar += intval(get_option('ays_gpg_sale_btn_for_two_months'));
        if($ays_gpg_ishmar == 0 ){
            if (isset($_GET['page']) && strpos($_GET['page'], AYS_GALLERY_NAME) !== false) {
                if( self::get_max_id_by_table( 'gallery' ) > 1 ){
                    self::ays_gpg_sale_new_message( $ays_gpg_ishmar );
                }
            }
        }
    }    


    public static function ays_autoembed( $content ) {
        global $wp_embed;

        if ( is_null( $content ) ) {
            return $content;
        }

        $content = stripslashes( wpautop( $content ) );
        $content = $wp_embed->autoembed( $content );
        if ( strpos( $content, '[embed]' ) !== false ) {
            $content = $wp_embed->run_shortcode( $content );
        }
        $content = do_shortcode( $content );
        return $content;
    }
    
    public static function get_galleries(){
        global $wpdb;        
        $galleries_table = $wpdb->prefix . 'ays_gallery';
        $sql = "SELECT id,title
                FROM {$galleries_table}";

        $galleries = $wpdb->get_results( $sql , "ARRAY_A" );

        return $galleries;
    }

    // New Mega Bundle 2024
    public static function ays_gpg_new_mega_bundle_message_2024( $ishmar ){
        if($ishmar == 0 ){
            $content = array();
            $content[] = '<div id="ays-gpg-new-mega-bundle-dicount-month-main-2024" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-month" class="ays_gpg_dicount_month">';

                    $content[] = '<div class="ays-gpg-discount-box-sale-image"></div>';
                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-text-box">';

                        $content[] = '<div class="ays-gpg-dicount-wrap-text-box-texts">';
                            $content[] = '<div>
                                            <a href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard-gallery&utm_medium=free-gallery&utm_campaign=sale-banner-gallery" target="_blank" style="color:#30499B;">
                                            <span class="ays-gpg-new-mega-bundle-limited-text">Limited</span> Offer for </a> <br> 
                                            
                                            <span style="font-size: 19px;">Photo Gallery</span>
                                          </div>';
                        $content[] = '</div>';

                        $content[] = '<div style="font-size: 17px;">';
                            $content[] = '<img style="width: 24px;height: 24px;" src="' . esc_attr(AYS_GPG_ADMIN_URL) . '/images/icons/guarantee-new.png">';
                            $content[] = '<span style="padding-left: 4px; font-size: 14px; font-weight: 600;"> 30 Day Money Back Guarantee</span>';
                            
                        $content[] = '</div>';

                       

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-gpg-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                                    if( current_user_can( 'manage_options' ) ){
                                        $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0; color: #30499B;
                                        ">Dismiss ad</button>';
                                        $content[] = wp_nonce_field( AYS_GALLERY_NAME . '-sale-banner' , AYS_GALLERY_NAME . '-sale-banner' );
                                    }
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-gpg-countdown-main-container">';
                            $content[] = '<div class="ays-gpg-countdown-container">';

                                $content[] = '<div id="ays-gpg-countdown">';

                                    $content[] = '<div style="font-weight: 500;">';
                                        $content[] = __( "Offer ends in:", 'gallery-photo-gallery' );
                                    $content[] = '</div>';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-gpg-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-gpg-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-button-box">';
                        $content[] = '<a href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard-gallery&utm_medium=free-gallery&utm_campaign=sale-banner-gallery" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now !', 'gallery-photo-gallery' ) . '</a>';
                        $content[] = '<span >' . __( 'One-time payment', 'gallery-photo-gallery' ) . '</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo html_entity_decode(esc_html( $content ));
        }        
    }

    // Black Friday 2024
    public static function ays_gpg_black_friday_message_2024($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-gpg-black-friday-bundle-dicount-month-main" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-month" class="ays_gpg_dicount_month">';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-gpg-countdown-main-container">';
                            $content[] = '<div class="ays-gpg-countdown-container">';

                                $content[] = '<div id="ays-gpg-countdown">';

                                    $content[] = '<div>';
                                        $content[] = __( "Offer ends in:", 'gallery-photo-gallery' );
                                    $content[] = '</div>';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-gpg-countdown-days"></span>'. __( "Days", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-hours"></span>'. __( "Hours", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-minutes"></span>'. __( "Minutes", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-seconds"></span>'. __( "Seconds", 'gallery-photo-gallery' ) .'</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-gpg-countdown-content" class="emoji">';
                                    $content[] = '<span></span>';
                                    $content[] = '<span></span>';
                                    $content[] = '<span></span>';
                                    $content[] = '<span></span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-text-box">';
                        $content[] = '<div>';

                            $content[] = '<span class="ays-gpg-black-friday-bundle-title">';
                                $content[] = __( "<span><a href='https://ays-pro.com/photography-bundle?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=black-friday-mega-bundle-sale-banner' class='ays-gpg-black-friday-bundle-title-link' target='_blank'>Black Friday Sale</a></span>", 'gallery-photo-gallery' );
                            $content[] = '</span>';

                            $content[] = '</br>';

                            $content[] = '<span class="ays-gpg-black-friday-bundle-desc">';
                                $content[] = '<a class="ays-gpg-black-friday-bundle-desc" href="https://ays-pro.com/photography-bundle?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=black-friday-mega-bundle-sale-banner" class="ays-gpg-black-friday-bundle-title-link" target="_blank">';
                                    $content[] = __( "50% OFF", 'gallery-photo-gallery' );
                                $content[] = '</a>';
                            $content[] = '</span>';
                        $content[] = '</div>';

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-gpg-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                                if( current_user_can( 'manage_options' ) ){
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">'. __( "Dismiss ad", 'gallery-photo-gallery' ) .'</button>';
                                    $content[] = wp_nonce_field( 'photo-gallery-sale-banner' ,  'photo-gallery-sale-banner' );
                                }
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-text-box">';
                        $content[] = '<span class="ays-gpg-black-friday-bundle-title">';
                            $content[] = '<a class="ays-gpg-black-friday-bundle-title-link" href="https://ays-pro.com/photography-bundle?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=black-friday-mega-bundle-sale-banner" target="_blank">';
                                $content[] = __( 'Photography Bundle', 'gallery-photo-gallery' );
                            $content[] = '</a>';
                        $content[] = '</span>';
                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-button-box">';
                        $content[] = '<a href="https://ays-pro.com/photography-bundle?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=black-friday-mega-bundle-sale-banner" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Get Your Deal', 'gallery-photo-gallery' ) . '</a>';
                        $content[] = '<span class="ays-gpg-dicount-one-time-text">';
                            $content[] = __( "One-time payment", 'gallery-photo-gallery' );
                        $content[] = '</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }

    // Christmas Top Banner 2024
    public static function ays_gpg_christmas_top_message_2024( $ishmar ){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-gpg-christmas-top-bundle-dicount-month-main" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-month" class="ays_gpg_dicount_month">';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-gpg-countdown-main-container">';
                            $content[] = '<div class="ays-gpg-countdown-container">';

                                $content[] = '<div id="ays-gpg-countdown">';

                                    $content[] = '<div>';
                                        $content[] = __( "Offer ends in:", 'gallery-photo-gallery' );
                                    $content[] = '</div>';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-gpg-countdown-days"></span>'. __( "Days", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-hours"></span>'. __( "Hours", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-minutes"></span>'. __( "Minutes", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-seconds"></span>'. __( "Seconds", 'gallery-photo-gallery' ) .'</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-gpg-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-text-box">';
                        $content[] = '<div>';

                            $content[] = '<span class="ays-gpg-christmas-top-bundle-title">';
                                $content[] = "<span><a href='https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=christmas-sale-banner".AYS_GALLERY_VERSION."' class='ays-gpg-christmas-top-bundle-title-link' target='_blank'>";
                                $content[] = __( 'Christmas Sale', 'gallery-photo-gallery' );
                                $content[] = "</a></span>";
                            $content[] = '</span>';

                            $content[] = '</br>';

                            $content[] = '<span class="ays-gpg-christmas-top-bundle-desc">';
                                $content[] = '<a class="ays-gpg-christmas-top-bundle-desc" href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=christmas-sale-banner'.AYS_GALLERY_VERSION.'" class="ays-gpg-christmas-top-bundle-title-link" target="_blank">';
                                    $content[] = __( "20% Extra OFF", 'gallery-photo-gallery' );
                                $content[] = '</a>';
                            $content[] = '</span>';
                        $content[] = '</div>';

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-gpg-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                                if( current_user_can( 'manage_options' ) ){
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">'. __( "Dismiss ad", 'gallery-photo-gallery' ) .'</button>';
                                    $content[] = wp_nonce_field( 'photo-gallery-sale-banner' ,  'photo-gallery-sale-banner' );
                                }
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-christmas-top-bundle-coupon-text-box">';
                        $content[] = '<div class="ays-gpg-christmas-top-bundle-coupon-row">';
                            $content[] = 'xmas20off';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-christmas-top-bundle-text-row">';
                            $content[] = __( '20% Extra Discount Coupon', 'gallery-photo-gallery' );
                        $content[] = '</div>';
                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-button-box">';
                        $content[] = '<a href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=christmas-sale-banner'.AYS_GALLERY_VERSION.'" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Get Your Deal', 'gallery-photo-gallery' ) . '</a>';
                        $content[] = '<span class="ays-gpg-dicount-one-time-text">';
                            $content[] = __( "One-time payment", 'gallery-photo-gallery' );
                        $content[] = '</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }

    // New Banner 2025
    public static function ays_gpg_new_banner_message_2025($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $gpg_cta_button_link = esc_url( 'https://ays-pro.com/photography-bundle?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=photography-bundle-2025-sale-banner-' . AYS_GALLERY_VERSION );

            $content[] = '<div id="ays-gpg-new-mega-bundle-2025-dicount-month-main" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-month" class="ays_gpg_dicount_month">';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-text-box">';
                        $content[] = '<div>';

                            $content[] = '<span class="ays-gpg-new-mega-bundle-2025-title">';
                                $content[] = __( "<span><a href='". $gpg_cta_button_link ."' target='_blank' style='color:#ffffff; text-decoration: underline;'>Photography Bundle</a></span>", 'gallery-photo-gallery' );
                            $content[] = '</span>';

                            $content[] = '</br>';

                            $content[] = '<span class="ays-gpg-new-mega-bundle-2025-desc">';
                                $content[] = __( "30 Day Money Back Guarantee", 'gallery-photo-gallery' );
                            $content[] = '</span>';
                        $content[] = '</div>';

                        $content[] = '<div>';
                                $content[] = '<img class="ays-gpg-new-mega-bundle-guaranteeicon" src="' . AYS_GPG_ADMIN_URL . '/images/ays-gpg-mega-bundle-2025-discount.svg" style="width: 80px;">';
                        $content[] = '</div>';

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-gpg-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                                if( current_user_can( 'manage_options' ) ){
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">'. __( "Dismiss ad", 'gallery-photo-gallery' ) .'</button>';
                                    $content[] = wp_nonce_field( 'photo-gallery-sale-banner' ,  'photo-gallery-sale-banner' );
                                }
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-gpg-countdown-main-container">';
                            $content[] = '<div class="ays-gpg-countdown-container">';

                                $content[] = '<div id="ays-gpg-countdown">';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-gpg-countdown-days"></span>'. __( "Days", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-hours"></span>'. __( "Hours", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-minutes"></span>'. __( "Minutes", 'gallery-photo-gallery' ) .'</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-seconds"></span>'. __( "Seconds", 'gallery-photo-gallery' ) .'</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-gpg-countdown-content" class="emoji">';
                                    $content[] = '<span></span>';
                                    $content[] = '<span></span>';
                                    $content[] = '<span></span>';
                                    $content[] = '<span></span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    /*$content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-top-bundle-coupon-text-box">';
                            $content[] = '<span>freetopro10off</span>';
                            $content[] = '<strong>10% extra coupon</strong>';
                    $content[] = '</div>';*/

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-button-box">';
                        $content[] = '<a href="'. $gpg_cta_button_link .'" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now', 'gallery-photo-gallery' ) . '</a>';
                        $content[] = '<span class="ays-gpg-dicount-one-time-text">';
                            $content[] = __( "One-time payment", 'gallery-photo-gallery' );
                        $content[] = '</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );
            echo wp_kses_post($content);
        }
    }

    // New Mega Bundle
    public static function ays_gpg_sale_new_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $gpg_cta_button_link = esc_url( 'https://ays-pro.com/photography-bundle?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=photography-bundle-2025-sale-banner-' . AYS_GALLERY_VERSION );

            $content[] = '<div id="ays-gpg-new-mega-bundle-dicount-month-main" class="ays-gpg-admin-notice notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-month" class="ays_gpg_dicount_month">';
                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-text-box">';
                        $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-text-boxes">';
                        $content[] = '<div>';
                            $content[] = '<span class="ays-gpg-new-mega-bundle-title">';
                                 $content[] = "<span><a href='". $gpg_cta_button_link ."' target='_blank' style='color:#ffffff; text-decoration: underline;'>Photography Bundle</a></span>";
                            $content[] = '</span>';                                
                        $content[] = '</div>';
                        $content[] = '<div>';
                            $content[] = '<img src="' . AYS_GPG_ADMIN_URL . '/images/ays-gpg-banner-sale-50.svg" style="width: 70px;">';
                        $content[] = '</div>';
                        
                        $content[] = '</div>'; 
                        $content[] = '<div>';
                                $content[] = '<img class="ays-gpg-new-mega-bundle-guaranteeicon" src="' . AYS_GPG_ADMIN_URL . '/images/gallery-guaranteeicon.svg" style="width: 30px;">';
                                $content[] = '<span class="ays-gpg-new-mega-bundle-desc">';
                                    $content[] = __( "30 Days Money Back Guarantee", 'gallery-photo-gallery' );
                                $content[] = '</span>';
                            $content[] = '</div>';                     

                        $content[] = '<div style="position: absolute;right: 10px;bottom: 1px;" class="ays-gpg-dismiss-buttons-container-for-form">';

                            $content[] = '<form action="" method="POST">';
                                $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                                    $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">Dismiss ad</button>';
                                    $content[] = wp_nonce_field( 'photo-gallery-sale-banner' ,  'photo-gallery-sale-banner' );
                                $content[] = '</div>';
                            $content[] = '</form>';
                            
                        $content[] = '</div>';

                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-countdown-box">';

                        $content[] = '<div id="ays-gpg-countdown-main-container">';
                            $content[] = '<div class="ays-gpg-countdown-container">';

                                $content[] = '<div id="ays-gpg-countdown">';

                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-gpg-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-gpg-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';
                        $content[] = '</div>';
                            
                    $content[] = '</div>';                    

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-button-box">';
                        $content[] = '<a href="'. $gpg_cta_button_link .'" class="button button-primary ays-button" id="ays-button-top-buy-now" target="_blank">' . __( 'Buy Now', 'gallery-photo-gallery' ) . '</a>';
                        $content[] = '<span class="ays-gpg-dicount-one-time-text">';
                            $content[] = __( "One-time payment", 'gallery-photo-gallery' );
                        $content[] = '</span>';
                    $content[] = '</div>';
                $content[] = '</div>';
            $content[] = '</div>';

            // /* New Mega Bundle Banner Gallery | Start */
            $content[] = '<style id="ays-gpg-mega-bundle-styles-inline-css">';
            $content[] = 'div#ays-gpg-new-mega-bundle-dicount-month-main{border:0;background:#fff;border-radius:20px;box-shadow:unset;position:relative;z-index:1;min-height:80px}div#ays-gpg-new-mega-bundle-dicount-month-main.ays_gpg_dicount_info button{display:flex;align-items:center}div#ays-gpg-new-mega-bundle-dicount-month-main div#ays-gpg-dicount-month a.ays-gpg-sale-banner-link:focus{outline:0;box-shadow:0}div#ays-gpg-new-mega-bundle-dicount-month-main .btn-link{color:#007bff;background-color:transparent;display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem}div#ays-gpg-new-mega-bundle-dicount-month-main.ays_gpg_dicount_info{background-image:url("' . esc_attr( AYS_GPG_ADMIN_URL ) . '/images/ays-gpg-banner-background-50.svg");background-position:center right;background-repeat:no-repeat;background-size:cover;background-color:unset;border:none}#ays-gpg-new-mega-bundle-dicount-month-main .ays_gpg_dicount_month{display:flex;align-items:center;justify-content:space-between;color:#fff}#ays-gpg-new-mega-bundle-dicount-month-main .ays_gpg_dicount_month img{width:80px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-sale-banner-link{display:flex;justify-content:center;align-items:center;width:200px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box{font-size:14px;padding:12px;text-align:center}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{text-align:left}.ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-boxes{display:flex}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:30%;display:flex;justify-content:flex-start;align-items:center}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-button-box{width:20%;display:flex;justify-content:center;align-items:center;flex-direction:column}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-title{color:#fdfdfd;font-size:16.8px;font-style:normal;font-weight:600;line-height:normal}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-desc{color:#fff;font-size:15px;font-style:normal;font-weight:400;line-height:normal}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box strong{font-size:17px;font-weight:700;letter-spacing:.8px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-color{color:#971821}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-text-decoration{text-decoration:underline}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-buy-now-button-box{display:flex;justify-content:flex-end;align-items:center;width:30%}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-button,#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-buy-now-button{align-items:center;font-weight:500}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-buy-now-button{background:#971821;border-color:#fff;display:flex;justify-content:center;align-items:center;padding:5px 15px;font-size:16px;border-radius:5px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-buy-now-button:hover{background:#7d161d;border-color:#971821}#ays-gpg-new-mega-bundle-dicount-month-main #ays-gpg-dismiss-buttons-content{display:flex;justify-content:center}#ays-gpg-new-mega-bundle-dicount-month-main #ays-gpg-dismiss-buttons-content .ays-button{margin:0!important;font-size:13px;color:#fff}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-opacity-box{width:19%}#ays-gpg-new-mega-bundle-dicount-month-main .ays-buy-now-opacity-button{padding:40px 15px;display:flex;justify-content:center;align-items:center;opacity:0}#ays-gpg-countdown-main-container .ays-gpg-countdown-container{margin:0 auto;text-align:center}#ays-gpg-countdown-main-container #ays-gpg-countdown-headline{letter-spacing:.125rem;text-transform:uppercase;font-size:18px;font-weight:400;margin:0;padding:9px 0 4px;line-height:1.3}#ays-gpg-countdown-main-container li,#ays-gpg-countdown-main-container ul{margin:0}#ays-gpg-countdown-main-container li{display:inline-block;font-size:14px;list-style-type:none;padding:14px;text-transform:uppercase}#ays-gpg-countdown-main-container li span{display:flex;justify-content:center;align-items:center;font-size:40px;min-height:62px;min-width:62px;border-radius:4.273px;border:.534px solid #f4f4f4;background:#9896ed}#ays-gpg-countdown-main-container .emoji{display:none;padding:1rem}#ays-gpg-countdown-main-container .emoji span{font-size:30px;padding:0 .5rem}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box li{position:relative}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box li span:after{content:":";color:#fff;position:absolute;top:10px;right:-5px;font-size:40px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box li span#ays-gpg-countdown-seconds:after{content:unset}#ays-gpg-new-mega-bundle-dicount-month-main #ays-button-top-buy-now{display:flex;align-items:center;border-radius:6.409px;background:#f66123;padding:12px 32px;color:#fff;font-size:12.818px;font-style:normal;font-weight:800;line-height:normal;margin:0!important}div#ays-gpg-new-mega-bundle-dicount-month-main button.notice-dismiss:before{color:#fff;content:"\f00d";font-family:fontawesome;font-size:22px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-new-mega-bundle-guaranteeicon{width:30px;margin-right:5px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-one-time-text{color:#fff;font-size:12px;font-style:normal;font-weight:600;line-height:normal}@media all and (max-width:768px){div#ays-gpg-new-mega-bundle-dicount-month-main{padding-right:0;padding-left:0}#ays-gpg-countdown-main-container li{font-size:12px;padding:12px}.ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-boxes{flex-direction:column}#ays-gpg-countdown-main-container li span{font-size:26px;min-height:50px;min-width:50px}div#ays-gpg-new-mega-bundle-dicount-month-main .ays_gpg_dicount_month{display:flex;align-items:center;justify-content:space-between;align-content:center;flex-wrap:wrap;flex-direction:column;padding:10px 0}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box{width:100%!important;text-align:center}#ays-gpg-countdown-main-container #ays-gpg-countdown-headline{font-size:15px;font-weight:600}#ays-gpg-countdown-main-container ul{font-weight:500}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:100%!important;text-align:center;flex-direction:column;margin-top:20px;justify-content:center;align-items:center}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box li span:after{top:unset}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:100%;display:flex;justify-content:center;align-items:center}#ays-gpg-new-mega-bundle-dicount-month-main .ays-button{margin:0 auto!important}div#ays-gpg-new-mega-bundle-dicount-month-main.ays_gpg_dicount_info.notice{background-position:-20px center;background-repeat:no-repeat;background-size:cover}#ays-gpg-new-mega-bundle-dicount-month-main #ays-gpg-dismiss-buttons-content .ays-button{padding-left:unset!important}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-buy-now-button-box{justify-content:center}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-buy-now-button{font-size:14px;padding:5px 10px}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-buy-now-opacity-button{display:none}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dismiss-buttons-container-for-form{position:static!important}.comparison .product img{width:70px}.ays-gpg-features-wrap .comparison a.price-buy{padding:8px 5px;font-size:11px}}@media screen and (max-width:1305px) and (min-width:768px){div#ays-gpg-new-mega-bundle-dicount-month-main.ays_gpg_dicount_info.notice{background-position:bottom right;background-repeat:no-repeat;background-size:cover}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box strong{font-size:15px}#ays-gpg-countdown-main-container li{font-size:11px}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-opacity-box{display:none}}@media screen and (max-width:1400px) and (min-width:1200px){div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:35%}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:40%}div#ays-gpg-countdown-main-container li span{font-size:30px;min-height:50px;min-width:50px}}@media screen and (max-width:1680px) and (min-width:1551px){div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:29%}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:30%}}@media screen and (max-width:1550px) and (min-width:1400px){div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:31%}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:35%}}@media screen and (max-width:1274px){div#ays-gpg-countdown-main-container li span{font-size:25px;min-height:40px;min-width:40px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-title{font-size:15px}}@media screen and (max-width:1200px){#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-button-box{margin-bottom:16px}#ays-gpg-countdown-main-container ul{padding-left:0}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-coupon-row{width:120px;font-size:18px}#ays-gpg-new-mega-bundle-dicount-month-main #ays-button-top-buy-now{padding:12px 20px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box{font-size:12px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-desc{font-size:13px}}@media screen and (max-width:1076px) and (min-width:769px){#ays-gpg-countdown-main-container li{padding:10px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-coupon-row{width:100px;font-size:16px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-button-box{margin-bottom:16px}#ays-gpg-new-mega-bundle-dicount-month-main #ays-button-top-buy-now{padding:12px 15px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box{font-size:11px;padding:12px 0}}@media screen and (max-width:1250px) and (min-width:769px){div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:45%}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:35%}div#ays-gpg-countdown-main-container li span{font-size:30px;min-height:50px;min-width:50px}}';

            $content[] = '</style>';
            // /* New Mega Bundle Banner Sccp | End */

            $content = implode( '', $content );
            echo $content;
        }
    }    

    public static function ays_gpg_sale_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-gpg-dicount-month-main" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-month" class="ays_gpg_dicount_month">';                    
                    $content[] = '<a href="https://ays-pro.com/wordpress/photo-gallery" target="_blank" class="ays-gpg-sale-banner-link"><img src="' . AYS_GPG_ADMIN_URL . '/images/gallery.png"></a>';
                    $content[] = '<div class="ays-gpg-dicount-wrap-box">';

                        $content[] = '<strong style="font-weight: bold;">';
                            $content[] = __( "Limited Time <span class='ays-gpg-dicount-wrap-color'>20%</span> SALE on <span><a href='https://ays-pro.com/wordpress/photo-gallery' target='_blank' class='ays-gpg-dicount-wrap-color ays-gpg-dicount-wrap-text-decoration' style='display:block;'>Photo Gallery</a></span>", 'gallery-photo-gallery' );
                        $content[] = '</strong>';
                        $content[] = '<strong>';
                                $content[] = __( "Hurry up! <a href='https://ays-pro.com/wordpress/photo-gallery' target='_blank'>Check it out!</a>", 'gallery-photo-gallery' );
                        $content[] = '</strong>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box">';

                        $content[] = '<div id="ays-gpg-countdown-main-container">';
                            $content[] = '<div class="ays-gpg-countdown-container">';

                                $content[] = '<div id="ays-gpg-countdown">';
                                    $content[] = '<ul>';
                                        $content[] = '<li><span id="ays-gpg-countdown-days"></span>days</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-hours"></span>Hours</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-minutes"></span>Minutes</li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-seconds"></span>Seconds</li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-gpg-countdown-content" class="emoji">';
                                    $content[] = '<span>🚀</span>';
                                    $content[] = '<span>⌛</span>';
                                    $content[] = '<span>🔥</span>';
                                    $content[] = '<span>💣</span>';
                                $content[] = '</div>';

                            $content[] = '</div>';                           

                        $content[] = '</div>';
                            
                    $content[] = '</div>';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-buy-now-button-box">';
                        $content[] = '<a href="https://ays-pro.com/wordpress/photo-gallery" class="button button-primary ays-buy-now-button" id="ays-button-top-buy-now" target="_blank" style="" >' . __( 'Buy Now !', 'gallery-photo-gallery' ) . '</a>';
                    $content[] = '</div>';              

                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;" class="ays-gpg-dismiss-buttons-container-for-form">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-gpg-dismiss-buttons-content">';                         
                            $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0; color: #979797;">Dismiss ad</button>';
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';

            $content[] = '</div>';

            $content = implode( '', $content );
            echo $content;
        }
    }

    public static function ays_gpg_helloween_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-gpg-dicount-month-main-helloween" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-month-helloween" class="ays_gpg_dicount_month_helloween">';
                    $content[] = '<div class="ays-gpg-dicount-wrap-box-helloween-limited">';

                        $content[] = '<p>';
                            $content[] = __( "Limited Time 
                            <span class='ays-gpg-dicount-wrap-color-helloween' style='color:#b2ff00;'>20%</span> 
                            <span>
                                SALE on
                            </span> 
                            <br>
                            <span style='' class='ays-gpg-helloween-bundle'>
                                <a href='https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard-gallery&utm_medium=free-gallery&utm_campaign=sale-banner-gallery' target='_blank' class='ays-gpg-dicount-wrap-color-helloween ays-gpg-dicount-wrap-text-decoration-helloween' style='display:block; color:#b2ff00;margin-right:6px;'>
                                    Photo Gallery
                                </a>
                            </span>", 'gallery-photo-gallery' );
                        $content[] = '</p>';
                        $content[] = '<p>';
                                $content[] = __( "Hurry up! 
                                                <a href='https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard-gallery&utm_medium=free-gallery&utm_campaign=sale-banner-gallery' target='_blank' style='color:#ffc700;'>
                                                    Check it out!
                                                </a>", 'gallery-photo-gallery' );
                        $content[] = '</p>';
                            
                    $content[] = '</div>';

                    
                    $content[] = '<div class="ays-gpg-helloween-bundle-buy-now-timer">';
                        $content[] = '<div class="ays-gpg-dicount-wrap-box-helloween-timer">';
                            $content[] = '<div id="ays-gpg-countdown-main-container" class="ays-gpg-countdown-main-container-helloween">';
                                $content[] = '<div class="ays-gpg-countdown-container-helloween">';
                                    $content[] = '<div id="ays-gpg-countdown">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><p><span id="ays-gpg-countdown-days"></span><span>days</span></p></li>';
                                            $content[] = '<li><p><span id="ays-gpg-countdown-hours"></span><span>Hours</span></p></li>';
                                            $content[] = '<li><p><span id="ays-gpg-countdown-minutes"></span><span>Mins</span></p></li>';
                                            $content[] = '<li><p><span id="ays-gpg-countdown-seconds"></span><span>Secs</span></p></li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';

                                    $content[] = '<div id="ays-gpg-countdown-content" class="emoji">';
                                        $content[] = '<span>🚀</span>';
                                        $content[] = '<span>⌛</span>';
                                        $content[] = '<span>🔥</span>';
                                        $content[] = '<span>💣</span>';
                                    $content[] = '</div>';

                                $content[] = '</div>';

                            $content[] = '</div>';
                                
                        $content[] = '</div>';
                        $content[] = '<div class="ays-gpg-dicount-wrap-box ays-buy-now-button-box-helloween">';
                            $content[] = '<a href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard-gallery&utm_medium=free-gallery&utm_campaign=sale-banner-gallery" class="button button-primary ays-buy-now-button-helloween" id="ays-button-top-buy-now-helloween" target="_blank" style="" >' . __( 'Buy Now !', 'gallery-photo-gallery' ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';

                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-gpg-dismiss-buttons-container-for-form-helloween">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-gpg-dismiss-buttons-content-helloween">';
                            $content[] = '<button class="btn btn-link ays-button-helloween" name="ays_gpg_sale_btn" style="">Dismiss ad</button>';
                            $content[] = wp_nonce_field( 'photo-gallery-sale-banner' ,  'photo-gallery-sale-banner' );
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );

            echo $content;
        }
    }

    // Black Friday
    public static function ays_gpg_black_friday_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-gpg-dicount-black-friday-month-main" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-black-friday-month" class="ays_gpg_dicount_month">';
                    $content[] = '<div class="ays-gpg-dicount-black-friday-box">';
                        $content[] = '<div class="ays-gpg-dicount-black-friday-wrap-box ays-gpg-dicount-black-friday-wrap-box-80" style="width: 70%;">';
                            $content[] = '<div class="ays-gpg-dicount-black-friday-title-row">' . __( 'Limited Time', 'gallery-photo-gallery' ) .' '. '<a href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=black-friday-sale-banner" class="ays-gpg-dicount-black-friday-button-sale" target="_blank">' . __( 'Sale', 'gallery-photo-gallery' ) . '</a>' . '</div>';
                            $content[] = '<div class="ays-gpg-dicount-black-friday-title-row">' . __( 'Photo Gallery', 'gallery-photo-gallery' ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-dicount-black-friday-wrap-box ays-gpg-dicount-black-friday-wrap-text-box">';
                            $content[] = '<div class="ays-gpg-dicount-black-friday-text-row">' . __( '20% off', 'gallery-photo-gallery' ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-dicount-black-friday-wrap-box" style="width: 25%;">';
                            $content[] = '<div id="ays-gpg-countdown-main-container">';
                                $content[] = '<div class="ays-gpg-countdown-container">';
                                    $content[] = '<div id="ays-gpg-countdown" style="display: block;">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><span id="ays-gpg-countdown-days">0</span>' . __( 'Days', 'gallery-photo-gallery' ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-hours">0</span>' . __( 'Hours', 'gallery-photo-gallery' ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-minutes">0</span>' . __( 'Minutes', 'gallery-photo-gallery' ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-seconds">0</span>' . __( 'Seconds', 'gallery-photo-gallery' ) . '</li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';
                                    $content[] = '<div id="ays-gpg-countdown-content" class="emoji" style="display: none;">';
                                        $content[] = '<span>🚀</span>';
                                        $content[] = '<span>⌛</span>';
                                        $content[] = '<span>🔥</span>';
                                        $content[] = '<span>💣</span>';
                                    $content[] = '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-dicount-black-friday-wrap-box" style="width: 25%;">';
                            $content[] = '<a href="https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=black-friday-sale-banner" class="ays-gpg-dicount-black-friday-button-buy-now" target="_blank">' . __( 'Get Your Deal', 'gallery-photo-gallery' ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-gpg-dismiss-buttons-container-for-form-black-friday">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-gpg-dismiss-buttons-content-black-friday">';
                            $content[] = '<button class="btn btn-link ays-button-black-friday" name="ays_gpg_sale_btn" style="">' . __( 'Dismiss ad', 'gallery-photo-gallery' ) . '</button>';
                            $content[] = wp_nonce_field( 'photo-gallery-sale-banner' ,  'photo-gallery-sale-banner' );
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>'; 
            $content[] = '</div>';

            $content = implode( '', $content );

            echo $content;
        }
    }

     // Christmas banner
    public static function ays_gpg_christmas_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $content[] = '<div id="ays-gpg-dicount-christmas-month-main" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-christmas-month" class="ays_gpg_dicount_month">';
                    $content[] = '<div class="ays-gpg-dicount-christmas-box">';
                        $content[] = '<div class="ays-gpg-dicount-christmas-wrap-box ays-gpg-dicount-christmas-wrap-box-80">';
                            $content[] = '<div class="ays-gpg-dicount-christmas-title-row">' . __( 'Limited Time', 'gallery-photo-gallery' ) .' '. '<a href="https://ays-pro.com/wordpress/photo-gallery" class="ays-gpg-dicount-christmas-button-sale" target="_blank">' . __( '20%', 'gallery-photo-gallery' ) . '</a>' . ' SALE</div>';
                            $content[] = '<div class="ays-gpg-dicount-christmas-title-row">' . __( 'Photo Gallery Plugin', 'gallery-photo-gallery' ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-dicount-christmas-wrap-box" style="width: 25%;">';
                            $content[] = '<div id="ays-gpg-countdown-main-container">';
                                $content[] = '<div class="ays-gpg-countdown-container">';
                                    $content[] = '<div id="ays-gpg-countdown" style="display: block;">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><span id="ays-gpg-countdown-days"></span>' . __( 'Days', 'gallery-photo-gallery' ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-hours"></span>' . __( 'Hours', 'gallery-photo-gallery' ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-minutes"></span>' . __( 'Minutes', 'gallery-photo-gallery' ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-seconds"></span>' . __( 'Seconds', 'gallery-photo-gallery' ) . '</li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';
                                    $content[] = '<div id="ays-gpg-countdown-content" class="emoji" style="display: none;">';
                                        $content[] = '<span>🚀</span>';
                                        $content[] = '<span>⌛</span>';
                                        $content[] = '<span>🔥</span>';
                                        $content[] = '<span>💣</span>';
                                    $content[] = '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-dicount-christmas-wrap-box" style="width: 25%;">';
                            $content[] = '<a href="https://ays-pro.com/wordpress/photo-gallery" class="ays-gpg-dicount-christmas-button-buy-now" target="_blank">' . __( 'BUY NOW!', 'gallery-photo-gallery' ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-gpg-dismiss-buttons-container-for-form-christmas">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-gpg-dismiss-buttons-content-christmas">';
                            $content[] = '<button class="btn btn-link ays-button-christmas" name="ays_gpg_sale_btn" style="">' . __( 'Dismiss ad', 'gallery-photo-gallery' ) . '</button>';
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content = implode( '', $content );

            echo $content;
        }
    }

    public static function get_max_id_by_table( $table ) {
        global $wpdb;
        $gallery_table = $wpdb->prefix . 'ays_'. $table;

        $sql = "SELECT max(id) FROM {$gallery_table}";

        $result = intval($wpdb->get_var($sql));

        return $result;
    }
}
