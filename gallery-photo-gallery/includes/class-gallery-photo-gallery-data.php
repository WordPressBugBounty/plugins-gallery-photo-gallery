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
                if( self::get_max_id_by_table( 'gallery' ) >= 1 ){
                    // self::ays_gpg_black_friday_message( $ays_gpg_ishmar );
                    // self::ays_gallery_christmas_banner_message_2025( $ays_gpg_ishmar );
                    self::ays_gpg_new_mega_bundle_message_2026( $ays_gpg_ishmar );
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

    // New Mega Bundle 2026
    public static function ays_gpg_new_mega_bundle_message_2026($ishmar){
        if( $ishmar == 0 ){
            $content = array();

            $date = time() + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS);
            $now_date = date('M d, Y H:i:s', $date);

            $gpg_banner_date = strtotime( Gallery_Photo_Gallery_Admin::ays_gpg_update_banner_time() );

            $diff = $gpg_banner_date - $date;

            $style_attr = '';
            if( $diff < 0 ){
                $style_attr = 'style="display:none;"';
            }

            $gpg_cta_button_link = esc_url( 'https://ays-pro.com/photography-bundle?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=photography-bundle-sale-banner-' . AYS_GALLERY_VERSION );

            $content[] = '<div id="ays-gpg-new-mega-bundle-dicount-month-main" class="ays-gpg-admin-notice notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-month" class="ays_gpg_dicount_month">';

                    $content[] = '<div class="ays-gpg-dicount-wrap-box ays-gpg-dicount-wrap-text-box">';
                        $content[] = '<div>';
                            $content[] = '<div class="ays-gpg-dicount-logo-box">';
                                $content[] = '<a href="' . $gpg_cta_button_link . '" target="_blank" class="ays-gpg-sale-banner-link"><img src="' . AYS_GPG_ADMIN_URL . '/images/photography_bundle_logo_box.png"></a>';

                                $content[] = '<div>';
                                    $content[] = '<span class="ays-gpg-new-mega-bundle-title">';
                                        $content[] = sprintf(
                                        /* translators: 1: opening link wrapper with <a> tag, 2: closing </a> tag */
                                        __( '%1$s Photography Bundle %2$s', 'gallery-photo-gallery' ),
                                        '<span style="display:inline-block; margin-right:5px;"><a href="' . esc_url( $gpg_cta_button_link ) . '" target="_blank" rel="noopener noreferrer" style="color:#ffffff !important; text-decoration: underline;">',
                                        '</a></span>'
                                    );
                                    $content[] = '</span>';
                                    $content[] = '</br>';
                                    $content[] = '<span class="ays-gpg-new-mega-bundle-desc">';
                                        $content[] = __( "30 Day Money Back Guarantee", 'gallery-photo-gallery' );
                                    $content[] = '</span>';
                                $content[] = '</div>';

                                $content[] = '<div class="ays-gpg-new-mega-bundle-title-icon-row" style="display: inline-block;">';
                                    $content[] = '<img src="' . AYS_GPG_ADMIN_URL . '/images/ays-gpg-banner-sale-50.svg" class="ays-gpg-new-mega-bundle-mobile-image-display-none" style="width: 70px;">';
                                $content[] = '</div>';

                            $content[] = '</div>';

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

                                $content[] = '<div ' . $style_attr . ' id="ays-gpg-countdown">';

                                    $content[] = '<ul>';

                                    $content[] = '<li><span id="ays-gpg-countdown-days"></span></li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-hours"></span></li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-minutes"></span></li>';
                                        $content[] = '<li><span id="ays-gpg-countdown-seconds"></span></li>';
                                    $content[] = '</ul>';
                                $content[] = '</div>';

                                $content[] = '<div id="ays-gpg-countdown-content" class="emoji">';
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

            // /* New Mega Bundle Banner SCCP | Start */
            $content[] = '<style id="ays-gpg-mega-bundle-styles-inline-css">';
            $content[] = '
            div#ays-gpg-new-mega-bundle-dicount-month-main{border:0;background:#fff;border-radius:20px;box-shadow:unset;position:relative;z-index:1;min-height:80px}div#ays-gpg-new-mega-bundle-dicount-month-main.ays_gpg_dicount_info button{display:flex;align-items:center}div#ays-gpg-new-mega-bundle-dicount-month-main div#ays-gpg-dicount-month a.ays-gpg-sale-banner-link:focus{outline:0;box-shadow:0}div#ays-gpg-new-mega-bundle-dicount-month-main .btn-link{color:#007bff;background-color:transparent;display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem}div#ays-gpg-new-mega-bundle-dicount-month-main.ays_gpg_dicount_info{background-image:url("'. AYS_GPG_ADMIN_URL .'/images/ays-gpg-banner-background-50.svg");background-position:center right;background-repeat:no-repeat;background-size:cover;background-color:#5551ff;padding:1px 38px 1px 12px}#ays-gpg-new-mega-bundle-dicount-month-main .ays_gpg_dicount_month{display:flex;align-items:center;justify-content:space-between;color:#fff}#ays-gpg-new-mega-bundle-dicount-month-main .ays_gpg_dicount_month img{width:60px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-sale-banner-link{display:flex;justify-content:center;align-items:center;width:60px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box{font-size:14px;padding:12px;text-align:center}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{text-align:left;width:auto;display:flex;justify-content:space-around;align-items:flex-start}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:30%;display:flex;justify-content:center;align-items:center}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-button-box{width:20%;display:flex;justify-content:center;align-items:center;flex-direction:column}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-gpg-dicount-logo-box{display:flex;justify-content:flex-start;align-items:center;gap:20px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-title{color:#fdfdfd;font-size:19px;font-style:normal;font-weight:600;line-height:normal}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-title-icon-row{display:inline-block}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-desc{display:inline-block;color:#fff;font-size:15px;font-style:normal;font-weight:400;line-height:normal;margin-top:10px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box strong{font-size:17px;font-weight:700;letter-spacing:.8px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-color{color:#971821}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-text-decoration{text-decoration:underline}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-buy-now-button-box{display:flex;justify-content:flex-end;align-items:center;width:30%}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-button,#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-buy-now-button{align-items:center;font-weight:500}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-buy-now-button{background:#971821;border-color:#fff;display:flex;justify-content:center;align-items:center;padding:5px 15px;font-size:16px;border-radius:5px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-buy-now-button:hover{background:#7d161d;border-color:#971821}#ays-gpg-new-mega-bundle-dicount-month-main #ays-gpg-dismiss-buttons-content{display:flex;justify-content:center}#ays-gpg-new-mega-bundle-dicount-month-main #ays-gpg-dismiss-buttons-content .ays-button{margin:0!important;font-size:13px;color:#fff}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-opacity-box{width:19%}#ays-gpg-new-mega-bundle-dicount-month-main .ays-buy-now-opacity-button{padding:40px 15px;display:flex;justify-content:center;align-items:center;opacity:0}#ays-gpg-countdown-main-container .ays-gpg-countdown-container{margin:0 auto;text-align:center}#ays-gpg-countdown-main-container #ays-gpg-countdown-headline{letter-spacing:.125rem;text-transform:uppercase;font-size:18px;font-weight:400;margin:0;padding:9px 0 4px;line-height:1.3}#ays-gpg-countdown-main-container li,#ays-gpg-countdown-main-container ul{margin:0}#ays-gpg-countdown-main-container li{display:inline-block;font-size:14px;list-style-type:none;padding:14px;text-transform:lowercase}#ays-gpg-countdown-main-container li span{display:flex;justify-content:center;align-items:center;font-size:22px;min-height:40px;min-width:40px;border-radius:4.273px;border:.534px solid #f4f4f4;background:#9896ed;color:#fff}#ays-gpg-countdown-main-container .emoji{display:none;padding:1rem}#ays-gpg-countdown-main-container .emoji span{font-size:30px;padding:0 .5rem}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box li{position:relative}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box li span:after{content:":";color:#fff;position:absolute;top:0;right:-5px;font-size:40px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box li span#ays-gpg-countdown-seconds:after{content:unset}#ays-gpg-new-mega-bundle-dicount-month-main #ays-button-top-buy-now{display:flex;align-items:center;border-radius:6.409px;background:#f66123;padding:12px 32px;color:#fff;font-size:15px;font-style:normal;line-height:normal;margin:0!important}div#ays-gpg-new-mega-bundle-dicount-month-main button.notice-dismiss:before{color:#fff;content:"\f00d";font-family:fontawesome;font-size:22px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-new-mega-bundle-guaranteeicon{width:30px;margin-right:5px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-one-time-text{color:#fff;font-size:12px;font-style:normal;font-weight:600;line-height:normal}@media all and (max-width:768px){div#ays-gpg-new-mega-bundle-dicount-month-main.ays_gpg_dicount_info.notice{display:none!important;background-position:bottom right;background-repeat:no-repeat;background-size:cover;border-radius:32px}div#ays-gpg-new-mega-bundle-dicount-month-main{padding-right:0}div#ays-gpg-new-mega-bundle-dicount-month-main .ays_gpg_dicount_month{display:flex;align-items:center;justify-content:space-between;align-content:center;flex-wrap:wrap;flex-direction:column;padding:10px 0}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box{width:100%!important;text-align:center}#ays-gpg-countdown-main-container #ays-gpg-countdown-headline{font-size:15px;font-weight:600}#ays-gpg-countdown-main-container ul{font-weight:500}div#ays-gpg-countdown-main-container li{padding:10px}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-new-mega-bundle-mobile-image-display-none{display:none!important}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-new-mega-bundle-mobile-image-display-block{display:block!important;margin-top:5px}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:100%!important;text-align:center;flex-direction:column;margin-top:20px;justify-content:center;align-items:center}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box li span:after{top:unset}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:100%;display:flex;justify-content:center;align-items:center}#ays-gpg-new-mega-bundle-dicount-month-main .ays-button{margin:0 auto!important}#ays-gpg-new-mega-bundle-dicount-month-main #ays-gpg-dismiss-buttons-content .ays-button{padding-left:unset!important}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-buy-now-button-box{justify-content:center}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box .ays-buy-now-button{font-size:14px;padding:5px 10px}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-buy-now-opacity-button{display:none}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dismiss-buttons-container-for-form{position:static!important}.comparison .product img{width:70px}.ays-gpg-features-wrap .comparison a.price-buy{padding:8px 5px;font-size:11px}}@media screen and (max-width:1350px) and (min-width:768px){div#ays-gpg-new-mega-bundle-dicount-month-main.ays_gpg_dicount_info.notice{background-position:bottom right;background-repeat:no-repeat;background-size:cover}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box strong{font-size:15px}#ays-gpg-countdown-main-container li{font-size:11px}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-opacity-box{display:none}}@media screen and (max-width:1680px) and (min-width:1551px){div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:29%}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:30%}}@media screen and (max-width:1410px){#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-coupon-row{width:150px}}@media screen and (max-width:1550px) and (min-width:1400px){div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:35%}}@media screen and (max-width:1400px) and (min-width:1250px){div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:35%}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:40%}}@media screen and (max-width:1274px){#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-title{font-size:15px}}@media screen and (max-width:1200px){#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-button-box{margin-bottom:16px}#ays-gpg-countdown-main-container ul{padding-left:0}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-coupon-row{width:120px;font-size:18px}#ays-gpg-new-mega-bundle-dicount-month-main #ays-button-top-buy-now{padding:12px 20px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box{font-size:12px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box .ays-gpg-new-mega-bundle-desc{font-size:13px}}@media screen and (max-width:1076px) and (min-width:769px){#ays-gpg-countdown-main-container li{padding:10px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-coupon-row{width:100px;font-size:16px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-button-box{margin-bottom:16px}#ays-gpg-new-mega-bundle-dicount-month-main #ays-button-top-buy-now{padding:12px 15px}#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box{font-size:11px;padding:12px 0}}@media screen and (max-width:1250px) and (min-width:769px){div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-countdown-box{width:45%}div#ays-gpg-new-mega-bundle-dicount-month-main .ays-gpg-dicount-wrap-box.ays-gpg-dicount-wrap-text-box{width:35%}}';
            $content[] = '</style>';
            // /* New Mega Bundle Banner SCCP | End */

            $content = implode( '', $content );
            echo ($content);        
        }
    }

    // Christmas Banner 2025
    public static function ays_gallery_christmas_banner_message_2025($ishmar){
        if($ishmar == 0 ){
            $content = array();

           $svg_icon = '<svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0445 0C10.4587 0 10.7945 0.33579 10.7945 0.75V2.93934L12.5141 1.21967C12.807 0.92678 13.2819 0.92678 13.5748 1.21967C13.8677 1.51256 13.8677 1.98744 13.5748 2.28033L10.7945 5.06066V9.451L14.5965 7.25588L15.6142 3.45788C15.7214 3.05778 16.1326 2.82034 16.5327 2.92755C16.9328 3.03475 17.1703 3.44601 17.0631 3.84611L16.4336 6.19522L18.3296 5.10055C18.6884 4.89344 19.147 5.01635 19.3542 5.37507C19.5613 5.73379 19.4384 6.19248 19.0796 6.39959L17.1836 7.49426L19.5327 8.1237C19.9328 8.23091 20.1703 8.64216 20.0631 9.0423C19.9558 9.4424 19.5446 9.6798 19.1445 9.5726L15.3465 8.55492L11.5445 10.75L15.3467 12.9452L19.1447 11.9275C19.5448 11.8203 19.956 12.0578 20.0633 12.4579C20.1705 12.858 19.933 13.2692 19.5329 13.3764L17.1838 14.0059L19.0798 15.1005C19.4386 15.3077 19.5615 15.7663 19.3544 16.1251C19.1472 16.4838 18.6886 16.6067 18.3298 16.3996L16.4338 15.3049L17.0633 17.654C17.1705 18.0541 16.933 18.4654 16.5329 18.5726C16.1328 18.6798 15.7216 18.4424 15.6144 18.0423L14.5967 14.2443L10.7945 12.049V16.4393L13.5748 19.2197C13.8677 19.5126 13.8677 19.9874 13.5748 20.2803C13.2819 20.5732 12.807 20.5732 12.5141 20.2803L10.7945 18.5607V20.75C10.7945 21.1642 10.4587 21.5 10.0445 21.5C9.63033 21.5 9.29453 21.1642 9.29453 20.75V18.5607L7.57484 20.2803C7.28195 20.5732 6.80707 20.5732 6.51418 20.2803C6.22129 19.9874 6.22129 19.5126 6.51418 19.2197L9.29453 16.4393V12.049L5.4923 14.2443L4.47463 18.0423C4.36742 18.4424 3.95617 18.6798 3.55607 18.5726C3.15597 18.4654 2.91853 18.0541 3.02574 17.654L3.65518 15.3049L1.75916 16.3996C1.40044 16.6067 0.941743 16.4838 0.734643 16.1251C0.527533 15.7663 0.650443 15.3077 1.00916 15.1005L2.90518 14.0059L0.556073 13.3764C0.155973 13.2692 -0.081467 12.858 0.0257431 12.4579C0.132943 12.0578 0.544203 11.8203 0.944303 11.9275L4.7423 12.9452L8.54453 10.75L4.74249 8.55492L0.944493 9.5726C0.544393 9.6798 0.133143 9.4424 0.0259331 9.0423C-0.0812669 8.64216 0.156163 8.23091 0.556263 8.1237L2.90538 7.49426L1.00935 6.39959C0.650633 6.19248 0.527733 5.73379 0.734833 5.37507C0.941943 5.01635 1.40063 4.89344 1.75935 5.10055L3.65538 6.19522L3.02593 3.84611C2.91873 3.44601 3.15616 3.03475 3.55626 2.92755C3.95636 2.82034 4.36762 3.05778 4.47482 3.45788L5.49249 7.25588L9.29453 9.451V5.06066L6.51418 2.28033C6.22129 1.98744 6.22129 1.51256 6.51418 1.21967C6.80707 0.92678 7.28195 0.92678 7.57484 1.21967L9.29453 2.93934V0.75C9.29453 0.33579 9.63033 0 10.0445 0Z" fill="white" fill-opacity="0.2"/>
            </svg>
            ';

            $ays_gpg_cta_button_link = esc_url('https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=christmas-sale-banner-' . AYS_GALLERY_VERSION);

            $content[] = '<div id="ays-gpg-christmas-banner-main" class="notice notice-success is-dismissible ays-gpg-christmas-banner-info ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-christmas-banner-month" class="ays-gpg-christmas-banner-month">';
                    
                    // Background effects
                    $content[] = '<div class="ays-gpg-christmas-banner-bg-effects">';
                        $content[] = '<div class="ays-gpg-christmas-banner-bg-gradient-1"></div>';
                        $content[] = '<div class="ays-gpg-christmas-banner-bg-gradient-2"></div>';
                        
                        // Snowflakes
                        $content[] = '<div class="ays-gpg-christmas-banner-snowflake" style="left: 5%; animation-delay: 0s; animation-duration: 8s;">'. $svg_icon .'</div>';
                        $content[] = '<div class="ays-gpg-christmas-banner-snowflake" style="left: 15%; animation-delay: 2s; animation-duration: 10s;">'. $svg_icon .'</div>';
                        $content[] = '<div class="ays-gpg-christmas-banner-snowflake" style="left: 25%; animation-delay: 4s; animation-duration: 9s;">'. $svg_icon .'</div>';
                        $content[] = '<div class="ays-gpg-christmas-banner-snowflake" style="left: 75%; animation-delay: 1s; animation-duration: 11s;">'. $svg_icon .'</div>';
                        $content[] = '<div class="ays-gpg-christmas-banner-snowflake" style="left: 85%; animation-delay: 3s; animation-duration: 8s;">'. $svg_icon .'</div>';
                        $content[] = '<div class="ays-gpg-christmas-banner-snowflake" style="left: 92%; animation-delay: 5s; animation-duration: 10s;">'. $svg_icon .'</div>';
                        
                        // Sparkles
                        $content[] = '<svg class="ays-gpg-christmas-banner-sparkle" style="top: 20%; left: 8%; animation-delay: 0s; width: 14px; height: 14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
                            $content[] = '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>';
                        $content[] = '</svg>';
                        $content[] = '<svg class="ays-gpg-christmas-banner-sparkle" style="top: 60%; left: 3%; animation-delay: 0.5s; width: 10px; height: 10px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
                            $content[] = '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>';
                        $content[] = '</svg>';
                        $content[] = '<svg class="ays-gpg-christmas-banner-sparkle" style="top: 30%; right: 12%; animation-delay: 1s; width: 12px; height: 12px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
                            $content[] = '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/>';
                        $content[] = '</svg>';
                    $content[] = '</div>';

                    // Main content
                    $content[] = '<div class="ays-gpg-christmas-banner-content">';
                        $content[] = '<div class="ays-gpg-christmas-banner-left">';
                            // Gift icon with hat
                            $content[] = '<div class="ays-gpg-christmas-banner-gift-wrapper">';
                                $content[] = '<svg class="ays-gpg-christmas-banner-gift-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">';
                                    $content[] = '<rect x="3" y="8" width="18" height="4" rx="1"></rect>';
                                    $content[] = '<path d="M12 8v13"></path>';
                                    $content[] = '<path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>';
                                    $content[] = '<path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>';
                                $content[] = '</svg>';
                                $content[] = '<div class="ays-gpg-christmas-banner-hat">';
                                    $content[] = '<svg viewBox="0 0 24 24" fill="none" class="ays-gpg-christmas-banner-hat-svg">';
                                        $content[] = '<path d="M12 2L4 14h16L12 2z" fill="hsl(0 80% 45%)"></path>';
                                        $content[] = '<path d="M4 14c0 2 3.5 3 8 3s8-1 8-3" fill="hsl(0 0% 100%)"></path>';
                                        $content[] = '<circle cx="12" cy="3" r="2" fill="hsl(0 0% 100%)"></circle>';
                                    $content[] = '</svg>';
                                $content[] = '</div>';
                            $content[] = '</div>';

                            $content[] = '<div class="ays-gpg-christmas-banner-special-label">';
                                $content[] = '<div class="ays-gpg-christmas-banner-special-label-name">';
                                    $content[] = '<a href="'. $ays_gpg_cta_button_link .'" class="ays-gpg-christmas-banner-special-label-name-link" target="_blank">';
                                        $content[] = __( 'Photo Gallery', "gallery-photo-gallery" );
                                    $content[] = '</a>';
                                $content[] = '</div>';

                                $content[] = '<div>✦ ' . __( 'CHRISTMAS SPECIAL', "gallery-photo-gallery" ) . ' ✦</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-christmas-banner-center">';
                            $content[] = '<div class="ays-gpg-christmas-banner-discount-text">25% OFF</div>';
                            $content[] = '<div class="ays-gpg-christmas-banner-limited-offer">' . __( 'Limited time offer', "gallery-photo-gallery" ) . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-christmas-banner-right">';
                            $content[] = '<div class="ays-gpg-christmas-banner-coupon-box" onclick="aysGpgChristmasCopyToClipboard(\'XMAS25\')" title="' . __( 'Click to copy', "gallery-photo-gallery" ) . '">';
                                $content[] = '<span class="ays-gpg-christmas-banner-coupon-text">XMAS25</span>';
                                $content[] = '<svg class="ays-gpg-christmas-banner-copy-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">';
                                    $content[] = '<path d="M13.5 2.5H6.5C5.67 2.5 5 3.17 5 4V10C5 10.83 5.67 11.5 6.5 11.5H13.5C14.33 11.5 15 10.83 15 10V4C15 3.17 14.33 2.5 13.5 2.5ZM13.5 10H6.5V4H13.5V10ZM2.5 6.5V12.5C2.5 13.33 3.17 14 4 14H10V12.5H4V6.5H2.5Z" fill="white"/>';
                                $content[] = '</svg>';
                            $content[] = '</div>';

                            $content[] = '<a href="'. $ays_gpg_cta_button_link .'" class="ays-gpg-christmas-banner-buy-now-btn" target="_blank">';
                                $content[] = __( 'Buy Now', "gallery-photo-gallery" );
                            $content[] = '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';

                $content[] = '</div>';

                if( current_user_can( 'manage_options' ) ){
                $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                    $content[] = '<form action="" method="POST" style="position: absolute; bottom: 0; right: 0; color: #fff;">';
                            $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="color: darkgrey; font-size: 11px; padding: 0 .75rem;">'. __( "Dismiss ad", 'gallery-photo-gallery' ) .'</button>';
                            $content[] = wp_nonce_field( 'photo-gallery-sale-banner' , 'photo-gallery-sale-banner' );
                    $content[] = '</form>';
                $content[] = '</div>';
                }

            $content[] = '</div>';

            $content[] = '<script>';
            $content[] = "
                function aysGpgChristmasCopyToClipboard(text) {
                    var textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    
                    textarea.select();
                    textarea.setSelectionRange(0, 99999);
                    
                    try {
                        document.execCommand('copy');
                        aysGpgChristmasShowCopyNotification('" . __( 'Coupon code copied!', "gallery-photo-gallery" ) . "');
                    } catch (err) {
                        console.error('Failed to copy text: ', err);
                    }
                    
                    document.body.removeChild(textarea);
                }

                function aysGpgChristmasShowCopyNotification(message) {
                    var existingNotification = document.querySelector('.ays-gpg-christmas-banner-copy-notification');
                    if (existingNotification) {
                        document.body.removeChild(existingNotification);
                    }
                    
                    var notification = document.createElement('div');
                    notification.className = 'ays-gpg-christmas-banner-copy-notification';
                    notification.textContent = message;
                    document.body.appendChild(notification);
                    
                    setTimeout(function() {
                        notification.classList.add('show');
                    }, 10);
                    
                    setTimeout(function() {
                        notification.classList.remove('show');
                        setTimeout(function() {
                            if (notification.parentNode) {
                                document.body.removeChild(notification);
                            }
                        }, 300);
                    }, 2000);
                }";
            $content[] = '</script>';                

            $content[] = '<style>';
            $content[] = '
                /* Christmas banner start */

                div#ays-gpg-christmas-banner-main .btn-link {
                    background-color: transparent;
                    display: inline-block;
                    font-weight: 400;
                    text-align: center;
                    white-space: nowrap;
                    vertical-align: middle;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                    border: 1px solid transparent;
                    padding: .375rem .75rem;
                    font-size: 12px;
                    line-height: 1.5;
                    border-radius: .25rem;
                    color: rgba(255, 255, 255, .6);
                }
                
                div#ays-gpg-christmas-banner-main.ays-gpg-christmas-banner-info {
                    background: linear-gradient(to right, hsl(0, 70%, 28%), hsl(0, 65%, 38%), hsl(0, 70%, 28%));
                    padding: unset;
                    border-left: 0;
                    position: relative;
                }
                
                #ays-gpg-christmas-banner-main .ays-gpg-christmas-banner-month {
                    position: relative;
                    padding: 15px 40px;
                    overflow: hidden;
                }
                
                /* Background effects */
                .ays-gpg-christmas-banner-bg-effects {
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    pointer-events: none;
                    z-index: 1;
                }
                
                .ays-gpg-christmas-banner-bg-gradient-1 {
                    position: absolute;
                    top: 0;
                    left: 30%;
                    width: 40%;
                    height: 100%;
                    background: radial-gradient(circle, rgba(202, 43, 43, 0.5) 0%, transparent 60%);
                    opacity: 0.4;
                }
                
                .ays-gpg-christmas-banner-bg-gradient-2 {
                    position: absolute;
                    top: 0;
                    right: 15%;
                    width: 35%;
                    height: 100%;
                    background: radial-gradient(circle, rgba(246, 201, 85, 0.15) 0%, transparent 50%);
                    opacity: 0.3;
                }
                
                .ays-gpg-christmas-banner-snowflake {
                    position: absolute;
                    color: rgba(255, 255, 255, 0.2);
                    font-size: 20px;
                    animation: ays-gpg-christmas-snowfall linear infinite;
                    top: -10px;
                }
                
                @keyframes ays-gpg-christmas-snowfall {
                    0% {
                        transform: translateY(-10px) rotate(0deg);
                        opacity: 0;
                    }
                    10% {
                        opacity: 0.8;
                    }
                    90% {
                        opacity: 0.8;
                    }
                    100% {
                        transform: translateY(100%) rotate(360deg);
                        opacity: 0;
                    }
                }
                
                .ays-gpg-christmas-banner-sparkle {
                    position: absolute;
                    color: hsl(43, 90%, 65%);
                    animation: ays-gpg-christmas-twinkle 2s ease-in-out infinite;
                }
                
                @keyframes ays-gpg-christmas-twinkle {
                    0%, 100% {
                        opacity: 0.3;
                        transform: scale(0.8);
                    }
                    50% {
                        opacity: 1;
                        transform: scale(1.2);
                    }
                }
                
                /* Main content */
                .ays-gpg-christmas-banner-content {
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    z-index: 2;
                }
                
                /* Left section */
                .ays-gpg-christmas-banner-left {
                    display: flex;
                    align-items: center;
                    gap: 50px;
                }
                
                .ays-gpg-christmas-banner-gift-wrapper {
                    position: relative;
                    animation: ays-gpg-christmas-float 3s ease-in-out infinite;
                }
                
                .ays-gpg-christmas-banner-gift-icon {
                    width: 48px;
                    height: 48px;
                    color: rgba(255, 247, 237, 0.9);
                }
                
                @keyframes ays-gpg-christmas-float {
                    0%, 100% {
                        transform: translateY(0);
                    }
                    50% {
                        transform: translateY(-5px);
                    }
                }
                
                .ays-gpg-christmas-banner-hat {
                    position: absolute;
                    top: -12px;
                    right: -4px;
                    width: 24px;
                    height: 24px;
                }
                
                .ays-gpg-christmas-banner-hat-svg {
                    width: 100%;
                    height: 100%;
                }
                
                .ays-gpg-christmas-banner-special-label {
                    color: hsl(43, 90%, 65%);
                    font-size: 14px;
                    font-weight: 500;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                    /* font-family: "Outfit", sans-serif; */
                }

                .ays-gpg-christmas-banner-special-label-name {
                    color: #fffaf0;
                    text-align: center;
                }

                div#ays-gpg-christmas-banner-main .ays-gpg-christmas-banner-special-label-name-link {
                    color: #fffaf0;
                    box-shadow: unset;
                }
                
                /* Center section */
                .ays-gpg-christmas-banner-center {
                    display: flex;
                    flex-direction: row;
                    text-align: center;
                    justify-content: center;
                    align-items: center;
                    gap: 30px;
                }
                
                .ays-gpg-christmas-banner-discount-text {
                    font-family: "Outfit", sans-serif;
                    font-weight: 800;
                    font-size: 30px;
                    color: hsl(40, 100%, 97%);
                    letter-spacing: -1px;
                    line-height: 1;
                }
                
                .ays-gpg-christmas-banner-limited-offer {
                    color: rgba(255, 247, 237, 0.7);
                    font-size: 13px;
                    font-weight: 500;
                }
                
                /* Right section */
                .ays-gpg-christmas-banner-right {
                    display: flex;
                    align-items: center;
                    gap: 20px;
                }
                
                .ays-gpg-christmas-banner-coupon-box {
                    border: 2px dashed rgba(255, 255, 255, 0.4);
                    padding: 8px 16px;
                    border-radius: 6px;
                    background: rgba(255, 255, 255, 0.1);
                    cursor: pointer;
                    transition: all 0.3s;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    backdrop-filter: blur(10px);
                }
                
                .ays-gpg-christmas-banner-coupon-box:hover {
                    background: rgba(255, 255, 255, 0.2);
                    border-color: rgba(255, 255, 255, 0.6);
                    transform: translateY(-1px);
                }
                
                .ays-gpg-christmas-banner-coupon-text {
                    font-size: 16px;
                    font-weight: 700;
                    letter-spacing: 1px;
                    color: #fff;
                    font-family: monospace;
                }
                
                .ays-gpg-christmas-banner-copy-icon {
                    opacity: 0.8;
                    transition: opacity 0.3s;
                }
                
                .ays-gpg-christmas-banner-coupon-box:hover .ays-gpg-christmas-banner-copy-icon {
                    opacity: 1;
                }
                
                #ays-gpg-christmas-banner-main .ays-gpg-christmas-banner-buy-now-btn {
                    background-color: #fbe19f;
                    color: hsl(0, 72%, 35%);
                    padding: 10px 30px;
                    border-radius: 9999px;
                    font-size: 16px;
                    font-weight: 600;
                    font-family: "Outfit", sans-serif;
                    border: none;
                    cursor: pointer;
                    transition: all 0.3s;
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 30px rgba(246, 201, 85, 0.2);
                }
                
                #ays-gpg-christmas-banner-main .ays-gpg-christmas-banner-buy-now-btn:hover {
                    background-color: #f2d58c;
                    transform: scale(1.05);
                    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2), 0 0 40px rgba(246, 201, 85, 0.3);
                }
                
                .ays-gpg-christmas-banner-btn-arrow {
                    display: inline-block;
                    transition: transform 0.3s;
                }
                
                .ays-gpg-christmas-banner-buy-now-btn:hover .ays-gpg-christmas-banner-btn-arrow {
                    transform: translateX(4px);
                }
                
                /* Notification */
                .ays-gpg-christmas-banner-copy-notification {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: rgba(0, 0, 0, 0.8);
                    color: #fff;
                    padding: 12px 24px;
                    border-radius: 8px;
                    font-size: 14px;
                    z-index: 10000;
                    opacity: 0;
                    transition: opacity 0.3s;
                }
                
                .ays-gpg-christmas-banner-copy-notification.show {
                    opacity: 1;
                }
                
                /* Dismiss button */
                #ays-gpg-christmas-banner-main #ays-gpg-christmas-banner-dismiss-content {
                    display: flex;
                    justify-content: center;
                }
                
                #ays-gpg-christmas-banner-main #ays-gpg-christmas-banner-dismiss-content .ays-button {
                    margin: 0 !important;
                    font-size: 13px;
                    color: rgba(150, 147, 147, 0.69);
                }
                
                /* Responsive */
                @media (max-width: 1024px) {
                    .ays-gpg-christmas-banner-discount-text {
                        font-size: 40px;
                    }
                    .ays-gpg-christmas-banner-content {
                        flex-wrap: wrap;
                    }
                }
                
                @media (max-width: 768px) {
                    #ays-gpg-christmas-banner-main {
                        display: none !important;
                    }
                }
                /* Christmas banner end */
            ';
            $content[] = '</style>';

            $content = implode( '', $content );

            echo $content;
        }
    }

    // Black Friday
    public static function ays_gpg_black_friday_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $ays_gpg_cta_button_link = esc_url('https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gallery-free&utm_campaign=black-friday-sale-banner-' . AYS_GALLERY_VERSION);

            $content[] = '<div id="ays-gpg-dicount-black-friday-month-main" class="notice notice-success is-dismissible ays_gpg_dicount_info">';
                $content[] = '<div id="ays-gpg-dicount-black-friday-month" class="ays_gpg_dicount_month">';
                    $content[] = '<div class="ays-gpg-dicount-black-friday-box">';
                        $content[] = '<div class="ays-gpg-dicount-black-friday-wrap-box ays-gpg-dicount-black-friday-wrap-box-80" style="width: 70%;">';
                            $content[] = '<div class="">';
                                $content[] = '<div class="ays-gpg-dicount-black-friday-title-row" >' . __( 'Coupon Code', "gallery-photo-gallery" ) .' ' . '</div>';
                                $content[] = '<div class="ays-gpg-dicount-black-friday-title-row">';

                                $content[] = '
                                    <span class="ays-gpg-dicount-black-friday-banner-2025-coupon-wrapper">
                                        <span class="ays-gpg-dicount-black-friday-banner-2025-coupon-box" onclick="aysGalleryHalloweenCopyToClipboard(\'FREE2PROBF\')" title="Click to copy">
                                            <span class="ays-gpg-dicount-black-friday-banner-2025-coupon-text">FREE2PROBF</span>
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ays-gpg-dicount-black-friday-banner-2025-copy-icon">
                                                <path d="M13.5 2.5H6.5C5.67 2.5 5 3.17 5 4V10C5 10.83 5.67 11.5 6.5 11.5H13.5C14.33 11.5 15 10.83 15 10V4C15 3.17 14.33 2.5 13.5 2.5ZM13.5 10H6.5V4H13.5V10ZM2.5 6.5V12.5C2.5 13.33 3.17 14 4 14H10V12.5H4V6.5H2.5Z" fill="white"/>
                                            </svg>
                                        </span>
                                    </span>';
                                $content[] = '</div> ';
                            $content[] = '</div>';

                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-dicount-black-friday-wrap-box ays-gpg-dicount-black-friday-wrap-text-box">';
                            $content[] = '<div class="ays-gpg-dicount-black-friday-text-row">' . '30% off' . '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-dicount-black-friday-wrap-box" style="width: 25%;">';
                            $content[] = '<div id="ays-gpg-countdown-main-container">';
                                $content[] = '<div class="ays-gpg-countdown-container">';
                                    $content[] = '<div id="ays-gpg-countdown" style="display: block;">';
                                        $content[] = '<ul>';
                                            $content[] = '<li><span id="ays-gpg-countdown-days"></span>' . __( 'Days', "gallery-photo-gallery" ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-hours"></span>' . __( 'Hours', "gallery-photo-gallery" ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-minutes"></span>' . __( 'Minutes', "gallery-photo-gallery" ) . '</li>';
                                            $content[] = '<li><span id="ays-gpg-countdown-seconds"></span>' . __( 'Seconds', "gallery-photo-gallery" ) . '</li>';
                                        $content[] = '</ul>';
                                    $content[] = '</div>';
                                    $content[] = '<div id="ays-gpg-countdown-content" class="emoji" style="display: none;">';
                                        $content[] = '<span></span>';
                                        $content[] = '<span></span>';
                                        $content[] = '<span></span>';
                                        $content[] = '<span></span>';
                                    $content[] = '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '<div class="ays-gpg-dicount-black-friday-wrap-box" style="width: 25%;">';
                            $content[] = '<a href="'. $ays_gpg_cta_button_link .'" class="ays-gpg-dicount-black-friday-button-buy-now" target="_blank">' . __( 'Get Your Deal', "gallery-photo-gallery" ) . '</a>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                $content[] = '</div>';

                $content[] = '<div style="position: absolute;right: 0;bottom: 1px;"  class="ays-gpg-dismiss-buttons-container-for-form-black-friday">';
                    $content[] = '<form action="" method="POST">';
                        $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                            if( current_user_can( 'manage_options' ) ){
                                $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="height: 32px; margin-left: 0;padding-left: 0">Dismiss ad</button>';
                                $content[] = wp_nonce_field( 'photo-gallery-sale-banner' , 'photo-gallery-sale-banner' );
                            }
                        $content[] = '</div>';
                    $content[] = '</form>';
                $content[] = '</div>';
            $content[] = '</div>';

            $content[] = '<script>';
            $content[] = "
                    function aysGalleryHalloweenCopyToClipboard(text) {
                        // Create a temporary textarea element
                        var textarea = document.createElement('textarea');
                        textarea.value = text;
                        textarea.style.position = 'fixed';
                        textarea.style.opacity = '0';
                        document.body.appendChild(textarea);
                        
                        // Select and copy the text
                        textarea.select();
                        textarea.setSelectionRange(0, 99999); // For mobile devices
                        
                        try {
                            document.execCommand('copy');
                            aysGalleryHalloweenShowCopyNotification('Coupon code copied!');
                        } catch (err) {
                            console.error('Failed to copy text: ', err);
                        }
                        
                        // Remove the temporary textarea
                        document.body.removeChild(textarea);
                    }

                    function aysGalleryHalloweenShowCopyNotification(message) {
                        // Check if notification already exists
                        var existingNotification = document.querySelector('.ays-gpg-discount-black-friday-banner-2025-copy-notification');
                        if (existingNotification) {
                            document.body.removeChild(existingNotification);
                        }
                        
                        // Create notification element
                        var notification = document.createElement('div');
                        notification.className = 'ays-gpg-discount-black-friday-banner-2025-copy-notification';
                        notification.textContent = message;
                        document.body.appendChild(notification);
                        
                        // Show notification with animation
                        setTimeout(function() {
                            notification.classList.add('show');
                        }, 10);
                        
                        // Hide and remove notification after 2 seconds
                        setTimeout(function() {
                            notification.classList.remove('show');
                            setTimeout(function() {
                                if (notification.parentNode) {
                                    document.body.removeChild(notification);
                                }
                            }, 300);
                        }, 2000);
                    }";
            $content[] = '</script>';

            $content[] = '<style>';
            $content[] = '
                /* Black friday banner start */
                div#ays-gpg-dicount-black-friday-month-main *{color:#fff}div#ays-gpg-dicount-black-friday-month-main div#ays-gpg-dicount-black-friday-month a.ays-gpg-sale-banner-link:focus{outline:0;box-shadow:0}div#ays-gpg-dicount-black-friday-month-main .btn-link{background-color:transparent;display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:12px;line-height:1.5;border-radius:.25rem;color:rgba(255,255,255,.6)}div#ays-gpg-dicount-black-friday-month-main.ays_gpg_dicount_info{background-image:linear-gradient(45deg,#1e101d,#c60af4);padding:unset;border-left:0}#ays-gpg-dicount-black-friday-month-main .ays_gpg_dicount_month{position:relative;background-image:url("'. esc_attr(AYS_GPG_ADMIN_URL) .'/images/black-friday-plugins-background-image.webp");background-position:center right;background-repeat:no-repeat;background-size:100% 100%}#ays-gpg-dicount-black-friday-month-main .ays_gpg_dicount_month img{width:80px}#ays-gpg-dicount-black-friday-month-main .ays-gpg-sale-banner-link{display:flex;justify-content:center;align-items:center;width:200px}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-button-sale{font-style:normal;font-weight:600;font-size:24px;text-align:center;color:#b2ff00;text-transform:uppercase}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box{font-size:14px;padding:12px;text-align:center;width:50%;white-space:nowrap}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box strong{font-size:17px;font-weight:700;letter-spacing:.8px}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-color{color:#971821}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-text-decoration{text-decoration:underline}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box.ays-buy-now-button-box{display:flex;justify-content:flex-end;align-items:center;width:30%}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box .ays-button,#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box .ays-buy-now-button{align-items:center;font-weight:500}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box .ays-buy-now-button{background:#971821;border-color:#fff;display:flex;justify-content:center;align-items:center;padding:5px 15px;font-size:16px;border-radius:5px}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box .ays-buy-now-button:hover{background:#7d161d;border-color:#971821}#ays-gpg-dicount-black-friday-month-main #ays-gpg-dismiss-buttons-content{display:flex;justify-content:center}#ays-gpg-dicount-black-friday-month-main #ays-gpg-dismiss-buttons-content .ays-button{margin:0!important;font-size:13px;color:#969393b0}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-opacity-box{width:19%}#ays-gpg-dicount-black-friday-month-main .ays-buy-now-opacity-button{padding:40px 15px;display:flex;justify-content:center;align-items:center;opacity:0}#ays-gpg-countdown-main-container .ays-gpg-countdown-container{margin:0 auto;text-align:center}#ays-gpg-countdown-main-container #ays-gpg-countdown-headline{letter-spacing:.125rem;text-transform:uppercase;font-size:18px;font-weight:400;margin:0;padding:9px 0 4px;line-height:1.3}#ays-gpg-countdown-main-container li,#ays-gpg-countdown-main-container ul{margin:0;font-weight:600}#ays-gpg-countdown-main-container li{display:inline-block;font-size:10px;list-style-type:none;padding:10px;text-transform:uppercase}#ays-gpg-countdown-main-container li span{display:block;font-size:22px;min-height:33px}#ays-gpg-countdown-main-container .emoji{display:none;padding:1rem}#ays-gpg-countdown-main-container .emoji span{font-size:25px;padding:0 .5rem}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-box{display:flex;justify-content:space-between;align-items:center;width:95%;margin:auto}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-title-row{text-align:center;padding-right:50px;font-style:normal;font-weight:900;font-size:19px;color:#fff;}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-button-buy-now{border:none;outline:0;padding:10px 20px;font-size:22px;text-transform:uppercase;font-weight:700;text-decoration:none;background:linear-gradient(180deg,#dd0bef 0,#82008d 100%);border-radius:16px}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-text-row{text-transform:uppercase;text-shadow:-1.5px 0 #dd0bef,0 1.5px #dd0bef,1.5px 0 #dd0bef,0 -1.5px #dd0bef;font-weight:900;font-style:normal;font-size:40px;line-height:40px;color:#fff}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-text-box{position:absolute;width:25%;top:10px;bottom:0;right:0;left:0;margin:0 auto}#ays-gpg-countdown ul{padding:0}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-banner-2025-coupon-box{border:2px dashed rgba(255,255,255,.4);padding:0 12px;border-radius:6px;background:rgba(255,255,255,.1);cursor:pointer;transition:.3s;display:flex;align-items:center;justify-content:center;gap:6px;backdrop-filter:blur(10px);width:fit-content;margin:0 auto}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-banner-2025-coupon-box:hover{background:rgba(255,255,255,.2);border-color:rgba(255,255,255,.6);transform:translateY(-1px)}#ays-gpg-dicount-black-friday-month-main .ays-gpg-discount-black-friday-banner-2025-coupon-text{font-size:14px;font-weight:700;letter-spacing:1px;color:#fff;font-family:monospace}#ays-gpg-dicount-black-friday-month-main .ays-gpg-discount-black-friday-banner-2025-copy-icon{opacity:.8;transition:opacity .3s}#ays-gpg-dicount-black-friday-month-main .ays-gpg-discount-black-friday-banner-banner-2025-coupon-box:hover .ays-gpg-discount-black-friday-banner-2025-copy-icon,.ays-gpg-discount-black-friday-banner-2025-copy-notification.show{opacity:1}.ays-gpg-discount-black-friday-banner-2025-copy-notification{position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:rgba(0,0,0,.8);color:#fff;padding:12px 24px;border-radius:8px;font-size:14px;z-index:10000;opacity:0;transition:opacity .3s}@media screen and (max-width:1400px) and (min-width:1200px){div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-title-row{font-size:15px}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-text-row{font-size:27px}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-box{width:100%}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-button-buy-now{font-size:13px}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box-80{width:80%!important}}@media all and (max-width:1200px){div#ays-gpg-dicount-black-friday-month-main .ays_gpg_dicount_month{background:unset}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-text-row{font-size:30px}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-box{width:100%}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-button-buy-now{font-size:15px}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box-80{width:80%!important}}@media all and (max-width:1200px) and (min-width:1150px){div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-title-row{font-size:15px}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-button-buy-now{font-size:10px}}@media all and (max-width:1150px){div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box-80{width:80%!important}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-box{flex-direction:column}div#ays-gpg-dicount-black-friday-month-main{padding-right:0}div#ays-gpg-dicount-black-friday-month-main .ays_gpg_dicount_month{display:flex;align-items:center;justify-content:space-between;align-content:center;flex-wrap:wrap;flex-direction:column;padding:10px 0}div#ays-gpg-dicount-black-friday-month-main div.ays-gpg-dicount-black-friday-wrap-box{width:100%!important;text-align:center}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-title-row,div#ays-gpg-dicount-black-friday-month-main #ays-gpg-countdown-main-container ul{padding:0;font-size:13px}#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-button-sale,div#ays-gpg-countdown-main-container li{font-size:15px}div#ays-gpg-countdown-main-container li span{font-size:25px}div#ays-gpg-dicount-black-friday-month-main div.ays-gpg-dicount-black-friday-wrap-text-box{position:unset}#ays-gpg-countdown-main-container #ays-gpg-countdown-headline{font-size:15px;font-weight:600}#ays-gpg-countdown-main-container ul{font-weight:500}#ays-gpg-countdown-main-container li span{font-size:20px}#ays-gpg-dicount-black-friday-month-main .ays-button{margin:0 auto!important}div#ays-gpg-dicount-black-friday-month-main.ays_gpg_dicount_info.notice{background-position:bottom right;background-repeat:no-repeat;background-size:contain;display:flex;justify-content:center;background-image:linear-gradient(45deg,#1e101d,#c60af4)}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box.ays-buy-now-button-box{justify-content:center}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-wrap-box .ays-buy-now-button{font-size:14px;padding:5px 10px}div#ays-gpg-dicount-black-friday-month-main .ays-gpg-dicount-black-friday-button-buy-now{padding:10px 18px;font-size:15px}}@media all and (max-width:768px){#ays-gpg-dicount-black-friday-month-main{display:none!important}}
                ';
            $content[] = '</style>';

            $content = implode( '', $content );

            echo $content;
        }
    }

    // Halloween Bundle 2025
    public static function ays_gpg_new_halloween_bundle_message_2025($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $date = time() + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS);
            $now_date = date('M d, Y H:i:s', $date);

            $start_date = strtotime('2025-09-08 00:00:01');
            $end_date = strtotime('2025-11-07 23:59:59');
            $diff_end = $end_date - $date;

            $style_attr = '';
            if( $diff_end < 0 ){
                $style_attr = 'style="display:none;"';
            }

            $ays_gpg_cta_button_link = esc_url('https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=gpg-halloween-banner-' . AYS_GALLERY_VERSION);

            $content[] = '
                <div id="ays-gpg-halloween-banner-2025-main" class="ays-gpg-halloween-banner-2025-main ays_gpg_dicount_info notice notice-success is-dismissible">
                    <div class="ays-gpg-halloween-banner-2025-content">
                        <div class="ays-gpg-halloween-banner-2025-left">
                            <div class="ays-gpg-halloween-banner-2025-text">
                                <h2 class="ays-gpg-halloween-banner-2025-title">Boo! Grab Your <a href="'. $ays_gpg_cta_button_link .'" class="" target="_blank">Halloween Deal</a> <br/> Before It Vanishes!</h2>
                                <p class="ays-gpg-halloween-banner-2025-subtitle">Don’t get spooked by missing out!<br/> Get 25% discount using the coupon code while the magic lasts!</p>
                            </div>
                        </div>

                        <div class="ays-gpg-halloween-banner-2025-center">';

                        $content[] = '<div id="ays-gpg-halloween-banner-2025-countdown" class="ays-gpg-halloween-banner-2025-countdown" ' . $style_attr . '>';
                            $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-timer">';
                                $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-item">';
                                    $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-value" id="ays-gpg-halloween-banner-2025-days">00</div>';
                                    $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-label">' . __('days', 'gallery-photo-gallery') . '</div>';
                                $content[] = '</div>';
                                $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-separator">:</div>';
                                $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-item">';
                                    $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-value" id="ays-gpg-halloween-banner-2025-hours">00</div>';
                                    $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-label">' . __('hours', 'gallery-photo-gallery') . '</div>';
                                $content[] = '</div>';
                                $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-separator">:</div>';
                                $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-item">';
                                    $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-value" id="ays-gpg-halloween-banner-2025-minutes">00</div>';
                                    $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-label">' . __('minutes', 'gallery-photo-gallery') . '</div>';
                                $content[] = '</div>';
                                $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-separator">:</div>';
                                $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-item">';
                                    $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-value" id="ays-gpg-halloween-banner-2025-seconds">00</div>';
                                    $content[] = '<div class="ays-gpg-halloween-banner-2025-countdown-label">' . __('seconds', 'gallery-photo-gallery') . '</div>';
                                $content[] = '</div>';
                            $content[] = '</div>';
                        $content[] = '</div>';

                        $content[] = '</div>
                                                
                        <div class="ays-gpg-halloween-banner-2025-right">
                            <div class="ays-gpg-halloween-banner-2025-pumpkin">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_177_40)">
                                    <path d="M32.664 8.519C29.364 5.134 23.42 4.75 18 4.75C12.58 4.75 6.636 5.134 3.336 8.519C0.582 11.344 0 15.751 0 19.791C0 25.054 1.982 31.102 6.357 34.035C9.364 36.051 13.95 35.871 18 35.871C22.05 35.871 26.636 36.051 29.643 34.035C34.018 31.101 36 25.054 36 19.791C36 15.751 35.418 11.344 32.664 8.519Z" fill="#F4900C"/>
                                    <path d="M20.783 5.44401C20.852 5.86401 20.561 6.20801 20.136 6.20801H15.685C15.259 6.20801 14.968 5.86401 15.038 5.44401L15.783 0.972008C15.853 0.551008 16.259 0.208008 16.685 0.208008H19.136C19.562 0.208008 19.968 0.552008 20.037 0.972008L20.783 5.44401Z" fill="#3F7123"/>
                                    <path d="M20.6541 21.159L19.0561 18.563C18.7651 18.021 18.3831 17.75 17.9991 17.746C17.6161 17.75 17.2331 18.021 16.9421 18.563L15.3441 21.159C14.7571 22.252 16.2171 22.875 17.9981 22.875C19.7791 22.875 21.2411 22.251 20.6541 21.159ZM30.1621 24.351C30.1171 24.276 30.0361 24.23 29.9481 24.23H29.1071C29.0391 24.23 28.9731 24.258 28.9261 24.307L26.6951 26.641L23.9971 24.472C23.9461 24.431 23.8801 24.414 23.8121 24.419C23.7461 24.426 23.6851 24.46 23.6441 24.513L21.2361 27.575L18.1821 24.309C18.1691 24.295 18.1491 24.292 18.1341 24.281C18.1191 24.271 18.1091 24.254 18.0911 24.247C18.0851 24.245 18.0781 24.247 18.0721 24.245C18.0481 24.238 18.0251 24.24 18.0001 24.24C17.9751 24.24 17.9521 24.238 17.9281 24.246C17.9221 24.248 17.9151 24.245 17.9081 24.248C17.8901 24.255 17.8811 24.272 17.8651 24.282C17.8491 24.292 17.8301 24.295 17.8171 24.309L14.7641 27.575L12.3551 24.513C12.3141 24.46 12.2531 24.426 12.1871 24.419C12.1211 24.413 12.0541 24.431 12.0021 24.472L9.30411 26.641L7.07411 24.307C7.02711 24.258 6.96211 24.23 6.89311 24.23H6.05211C5.96511 24.23 5.88311 24.276 5.83811 24.351C5.79311 24.426 5.79011 24.519 5.83111 24.596L8.58511 29.815C8.61911 29.879 8.6781 29.925 8.7491 29.942C8.8201 29.959 8.8941 29.944 8.9521 29.902L10.9861 28.444L13.9901 32.077C14.0331 32.13 14.0961 32.162 14.1641 32.167L14.1831 32.168C14.2451 32.168 14.3041 32.146 14.3501 32.105L18.0001 28.836L21.6501 32.104C21.6961 32.145 21.7551 32.167 21.8171 32.167L21.8361 32.166C21.9041 32.161 21.9671 32.129 22.0101 32.076L25.0151 28.443L27.0491 29.901C27.1091 29.944 27.1821 29.961 27.2521 29.941C27.3221 29.924 27.3821 29.879 27.4151 29.815L30.1701 24.596C30.2101 24.519 30.2081 24.426 30.1621 24.351ZM27.9761 15.421C28.1051 17.548 27.1921 19.227 24.7711 19.374C22.3511 19.52 21.2421 17.963 21.1131 15.837C20.9841 13.711 22.3451 10.717 24.2401 10.603C26.1361 10.487 27.8481 13.294 27.9761 15.421ZM8.02411 15.421C7.89511 17.548 8.80811 19.227 11.2291 19.374C13.6491 19.52 14.7581 17.963 14.8871 15.837C15.0161 13.711 13.6551 10.717 11.7601 10.603C9.86511 10.489 8.15211 13.294 8.02411 15.421Z" fill="#642116"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_177_40">
                                    <rect width="36" height="36" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </div>



                            <div class="ays-gpg-halloween-banner-2025-discount-section">
                                <div class="ays-gpg-halloween-banner-2025-discount">25% OFF</div>
                                <div class="ays-gpg-halloween-banner-2025-coupon-wrapper">
                                    <div class="ays-gpg-halloween-banner-2025-coupon-box" onclick="aysGalleryHalloweenCopyToClipboard(\'HALLOWEEN25\')" title="Click to copy">
                                        <span class="ays-gpg-halloween-banner-2025-coupon-text">HALLOWEEN25</span>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ays-gpg-halloween-banner-2025-copy-icon">
                                            <path d="M13.5 2.5H6.5C5.67 2.5 5 3.17 5 4V10C5 10.83 5.67 11.5 6.5 11.5H13.5C14.33 11.5 15 10.83 15 10V4C15 3.17 14.33 2.5 13.5 2.5ZM13.5 10H6.5V4H13.5V10ZM2.5 6.5V12.5C2.5 13.33 3.17 14 4 14H10V12.5H4V6.5H2.5Z" fill="white"/>
                                        </svg>
                                    </div>
                                </div>
                                <a href="'. $ays_gpg_cta_button_link .'" class="ays-gpg-halloween-banner-2025-upgrade" target="_blank">Upgrade Now</a>
                            </div>';

                            if( current_user_can( 'manage_options' ) ){
                                $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                                    $content[] = '<form action="" method="POST" style="position: absolute; bottom: -5px; right: 0; color: #fff;">';
                                            $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="color: darkgrey; font-size: 11px;">'. __( "Dismiss ad", 'gallery-photo-gallery' ) .'</button>';
                                            $content[] = wp_nonce_field( 'photo-gallery-sale-banner' , 'photo-gallery-sale-banner' );
                                    $content[] = '</form>';
                                $content[] = '</div>';
                            }

                            $content[] = '
                        </div>
                    </div>
                </div>';

            $content[] = '<style id="ays-gpg-progress-banner-styles-inline-css">';
            $content[] = '
                .ays-gpg-halloween-banner-2025-main {
                    background: linear-gradient(135deg, #1A0F2E 100%, #2D1B4E 0%);
                    background-image: url("' . esc_attr( AYS_GPG_ADMIN_URL ) . '/images/halloween-banner-background-image-remove.png"), linear-gradient(135deg, #2D1B4E 0%, #1A0F2E 100%);
                    background-position: left center, center;
                    background-repeat: no-repeat, no-repeat;
                    background-size: auto 100%, cover;
                    padding: 20px 30px 20px 130px;
                    border-radius: 12px;
                    color: white;
                    margin: 20px 0;
                    border: 0;
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
                    overflow: hidden;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-content {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 30px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-left {
                    display: flex;
                    align-items: center;
                    gap: 20px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-center {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex: 1;
                    max-width: 350px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-right {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    flex-shrink: 0;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-icon {
                    flex-shrink: 0;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-pumpkin svg {
                    display: inline !important;
                    border: none !important;
                    box-shadow: none !important;
                    height: 1em !important;
                    width: 1em !important;
                    margin: 0 0.07em !important;
                    vertical-align: -0.1em !important;
                    background: none !important;
                    padding: 0 !important;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-orb {
                    width: 80px;
                    height: 80px;
                    background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    box-shadow: 0 0 30px rgba(139, 92, 246, 0.6);
                    border: 3px solid rgba(168, 85, 247, 0.4);
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-question {
                    font-size: 48px;
                    font-weight: 700;
                    color: #E9D5FF;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-bat {
                    font-size: 20px;
                    opacity: 0.8;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-bat-1 {
                    margin-left: -100px;
                    margin-top: -40px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-bat-2 {
                    margin-left: -110px;
                    margin-top: 35px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-sparkle {
                    font-size: 12px;
                    opacity: 0.7;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-sparkle-1 {
                    margin-left: -95px;
                    margin-top: -60px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-sparkle-2 {
                    margin-left: -70px;
                    margin-top: -15px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-sparkle-3 {
                    margin-left: -120px;
                    margin-top: 10px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-text {
                    flex: 1;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-title {
                    font-size: 24px;
                    font-weight: 700;
                    margin: 0 0 8px 0;
                    line-height: 1.2;
                    color: #fff;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-title a {
                    color: #FB923C;
                    text-decoration: underline;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-subtitle {
                    font-size: 16px;
                    margin: 0;
                    opacity: 0.9;
                    font-weight: 400;
                    color: #E9D5FF;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-description {
                    font-size: 14px;
                    margin: 0;
                    opacity: 0.85;
                    line-height: 1.5;
                    color: #D8B4FE;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-pumpkin {
                    font-size: 64px;
                    filter: drop-shadow(0 0 20px rgba(251, 146, 60, 0.8));
                    flex-shrink: 0;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-discount-section {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 10px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-discount {
                    font-size: 36px;
                    font-weight: 700;
                    color: #FB923C;
                    text-shadow: 0 0 20px rgba(251, 146, 60, 0.6);
                    margin: 0;
                    line-height: 1;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-coupon-wrapper {
                    margin-bottom: 5px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-coupon-box {
                    border: 2px dashed rgba(255, 255, 255, 0.4);
                    padding: 6px 12px;
                    border-radius: 6px;
                    background: rgba(255, 255, 255, 0.1);
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    backdrop-filter: blur(10px);
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-coupon-box:hover {
                    background: rgba(255, 255, 255, 0.2);
                    border-color: rgba(255, 255, 255, 0.6);
                    transform: translateY(-1px);
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-coupon-text {
                    font-size: 14px;
                    font-weight: 700;
                    letter-spacing: 1px;
                    color: #fff;
                    font-family: monospace;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-copy-icon {
                    opacity: 0.8;
                    transition: opacity 0.3s ease;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-coupon-box:hover .ays-gpg-halloween-banner-2025-copy-icon {
                    opacity: 1;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-upgrade {
                    background: linear-gradient(135deg, #FB923C 0%, #F97316 100%);
                    color: white;
                    border: none;
                    padding: 12px 28px;
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 16px rgba(251, 146, 60, 0.5);
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    text-align: center;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-upgrade:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(251, 146, 60, 0.7);
                    text-decoration: none;
                    color: white;
                }

                .ays-gpg-halloween-banner-2025-main .notice-dismiss:before {
                    color: #fff;
                }

                .ays-gpg-halloween-banner-2025-copy-notification {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: rgba(0, 0, 0, 0.8);
                    color: white;
                    padding: 12px 24px;
                    border-radius: 8px;
                    font-size: 14px;
                    z-index: 10000;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }

                .ays-gpg-halloween-banner-2025-copy-notification.show {
                    opacity: 1;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-countdown-timer {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-countdown-item {
                    background: rgba(255, 255, 255, 0.15);
                    border-radius: 8px;
                    padding: 8px 12px;
                    min-width: 60px;
                    backdrop-filter: blur(10px);
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-countdown-value {
                    font-size: 24px;
                    font-weight: 700;
                    line-height: 1;
                    margin-bottom: 4px;
                    color: #fff;
                    text-align: center;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-countdown-label {
                    font-size: 11px;
                    opacity: 0.8;
                    text-transform: lowercase;
                    text-align: center;
                }

                .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-countdown-separator {
                    font-size: 24px;
                    font-weight: 700;
                    opacity: 0.6;
                    margin: 0 4px;
                }

                @media (min-width: 1200px) {
                    .ays-gpg-halloween-banner-2025-main .wp-core-ui .notice.is-dismissible {
                        padding-right: 60px;
                    }
                }

                @media (max-width: 1200px) {

                    div.ays-gpg-halloween-banner-2025-main {
                        padding: 20px 30px;
                    }

                    div.ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-pumpkin {
                        display: none;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-subtitle,
                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-title {
                        text-align: center;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-content {
                        flex-wrap: wrap;
                        gap: 20px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-left {
                        width: 100%;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-center {
                        width: 100%;
                        max-width: 100%;
                        text-align: center;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-right {
                        width: 100%;
                        justify-content: center;
                    }
                }

                @media (max-width: 786px) {
                    #ays-gpg-halloween-banner-2025-main {
                        display: none !important;
                    }
                }

                @media (max-width: 768px) {
                    .ays-gpg-halloween-banner-2025-main {
                        padding: 15px 20px;
                        margin: 15px 0;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-title {
                        font-size: 20px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-subtitle {
                        font-size: 14px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-description {
                        font-size: 13px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-pumpkin {
                        font-size: 48px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-discount {
                        font-size: 28px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-upgrade {
                        padding: 10px 20px;
                        font-size: 14px;
                    }
                }

                @media (max-width: 480px) {
                    .ays-gpg-halloween-banner-2025-main {
                        padding: 12px 15px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-orb {
                        width: 60px;
                        height: 60px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-question {
                        font-size: 36px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-title {
                        font-size: 18px;
                    }

                    .ays-gpg-halloween-banner-2025-main .ays-gpg-halloween-banner-2025-coupon-text {
                        font-size: 12px;
                    }
                }
            ';

            $content[] = '</style>';

            $content[] = '<script>';
            $content[] = "
                    function aysGalleryHalloweenCopyToClipboard(text) {
                        // Create a temporary textarea element
                        var textarea = document.createElement('textarea');
                        textarea.value = text;
                        textarea.style.position = 'fixed';
                        textarea.style.opacity = '0';
                        document.body.appendChild(textarea);
                        
                        // Select and copy the text
                        textarea.select();
                        textarea.setSelectionRange(0, 99999); // For mobile devices
                        
                        try {
                            document.execCommand('copy');
                            aysGalleryHalloweenShowCopyNotification('Coupon code copied!');
                        } catch (err) {
                            console.error('Failed to copy text: ', err);
                        }
                        
                        // Remove the temporary textarea
                        document.body.removeChild(textarea);
                    }

                    function aysGalleryHalloweenShowCopyNotification(message) {
                        // Check if notification already exists
                        var existingNotification = document.querySelector('.ays-gpg-halloween-banner-2025-copy-notification');
                        if (existingNotification) {
                            document.body.removeChild(existingNotification);
                        }
                        
                        // Create notification element
                        var notification = document.createElement('div');
                        notification.className = 'ays-gpg-halloween-banner-2025-copy-notification';
                        notification.textContent = message;
                        document.body.appendChild(notification);
                        
                        // Show notification with animation
                        setTimeout(function() {
                            notification.classList.add('show');
                        }, 10);
                        
                        // Hide and remove notification after 2 seconds
                        setTimeout(function() {
                            notification.classList.remove('show');
                            setTimeout(function() {
                                if (notification.parentNode) {
                                    document.body.removeChild(notification);
                                }
                            }, 300);
                        }, 2000);
                    }

                    (function() {
                        var endDate = new Date('". date('Y-m-d H:i:s', $end_date) ."').getTime();
                    
                        function updateCountdown() {
                            var now = new Date().getTime();
                            var distance = endDate - now;
                            
                            if (distance < 0) {
                                clearInterval(updateCountdown);
                                document.getElementById('ays-gpg-halloween-banner-2025-progress-banner-countdown').style.display = 'none';
                                return;
                            }
                            
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            
                            function padZero(num) {
                                return num < 10 ? '0' + num : num;
                            }
                            
                            document.getElementById('ays-gpg-halloween-banner-2025-days').textContent = padZero(days);
                            document.getElementById('ays-gpg-halloween-banner-2025-hours').textContent = padZero(hours);
                            document.getElementById('ays-gpg-halloween-banner-2025-minutes').textContent = padZero(minutes);
                            document.getElementById('ays-gpg-halloween-banner-2025-seconds').textContent = padZero(seconds);
                        }
                        
                        updateCountdown();
                        setInterval(updateCountdown, 1000);
                    })()";
            $content[] = '</script>';

            $content = implode( '', $content );
            echo ($content);
        }
    }

    // Fox LMS Pro Banner
    public static function ays_gpg_discounted_licenses_banner_message($ishmar){
        if($ishmar == 0 ){
            $content = array();

            $date = time() + (int) ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS);
            $now_date = date('M d, Y H:i:s', $date);

            $start_date = strtotime('2025-09-21');
            $end_date = strtotime('2025-10-21');
            $diff_end = $end_date - $date;

            $style_attr = '';
            if( $diff_end < 0 ){
                $style_attr = 'style="display:none;"';
            }

            $total_licenses = 50;
            $progression_pattern = array(3, 2, 1, 4, 2, 3, 1, 2, 4, 3, 2, 1, 3, 2, 4, 1, 3, 2, 2, 3, 1, 2);
            $days_passed = floor(($date - $start_date) / (24 * 60 * 60));
            $used_licenses = 0;

            for ($i = 0; $i < min($days_passed, count($progression_pattern)); $i++) {
                $used_licenses += $progression_pattern[$i];
            }
            $used_licenses = min($used_licenses, $total_licenses);
            $remaining_licenses = $total_licenses - $used_licenses;
            $progress_percentage = ($used_licenses / $total_licenses) * 100;

            $ays_gpg_cta_button_link = esc_url('https://ays-pro.com/wordpress/photo-gallery?utm_source=dashboard&utm_medium=gpg-free&utm_campaign=gallery-license-banner-' . AYS_GALLERY_VERSION);

            $content[] = '<div id="ays-gpg-progress-banner-main" class="ays-gpg-progress-banner-main ays_gpg_dicount_info ays-gpg-admin-notice notice notice-success is-dismissible" ' . $style_attr . '>';
                $content[] = '<div class="ays-gpg-progress-banner-content">';
                    $content[] = '<div class="ays-gpg-progress-banner-left">';
                        $content[] = '<div class="ays-gpg-progress-banner-icon">';
                            $content[] = '<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.33325 22.6668L11.9999 13.3335L33.3333 14.6668L34.6666 36.0002L25.3333 46.6668C25.3333 46.6668 25.3346 38.6682 17.3333 30.6668C9.33192 22.6655 1.33325 22.6668 1.33325 22.6668Z" fill="#A0041E"/>
                                            <path d="M1.29739 46.6665C1.29739 46.6665 1.24939 36.0278 5.27739 31.9998C9.30539 27.9718 20.0001 28.2492 20.0001 28.2492C20.0001 28.2492 19.9987 38.6665 15.9987 42.6665C11.9987 46.6665 1.29739 46.6665 1.29739 46.6665Z" fill="#FFAC33"/>
                                            <path d="M11.9986 41.3332C14.9441 41.3332 17.3319 38.9454 17.3319 35.9998C17.3319 33.0543 14.9441 30.6665 11.9986 30.6665C9.0531 30.6665 6.66528 33.0543 6.66528 35.9998C6.66528 38.9454 9.0531 41.3332 11.9986 41.3332Z" fill="#FFCC4D"/>
                                            <path d="M47.9986 0C47.9986 0 34.6653 0 18.6653 13.3333C10.6653 20 10.6653 32 13.3319 34.6667C15.9986 37.3333 27.9986 37.3333 34.6653 29.3333C47.9986 13.3333 47.9986 0 47.9986 0Z" fill="#55ACEE"/>
                                            <path d="M35.9987 6.6665C33.8347 6.6665 31.9814 7.96117 31.144 9.81317C31.8134 9.5105 32.5507 9.33317 33.332 9.33317C36.2774 9.33317 38.6654 11.7212 38.6654 14.6665C38.6654 15.4478 38.488 16.1852 38.1867 16.8532C40.0387 16.0172 41.332 14.1638 41.332 11.9998C41.332 9.0545 38.944 6.6665 35.9987 6.6665Z" fill="black"/>
                                            <path d="M10.6667 37.3332C10.6667 37.3332 10.6667 31.9998 12.0001 30.6665C13.3334 29.3332 29.3347 16.0012 30.6667 17.3332C31.9987 18.6652 18.6654 34.6665 17.3321 35.9998C15.9987 37.3332 10.6667 37.3332 10.6667 37.3332Z" fill="#A0041E"/>
                                            </svg>';
                        $content[] = '</div>';
                        $content[] = '<div class="ays-gpg-progress-banner-text">';
                            $content[] = '<h2 class="ays-gpg-progress-banner-title">' . sprintf( __('Get the Pro Version of %s Gallery%s – 20%% OFF', 'gallery-photo-gallery'), '<a href="'. $ays_gpg_cta_button_link .'" target="_blank">', '</a>' ) . '</h2>';
                            $content[] = '<p class="ays-gpg-progress-banner-subtitle">' . __('Unlock advanced features + 30 day Money Back Guarantee', 'gallery-photo-gallery') . '</p>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                    
                    $content[] = '<div class="ays-gpg-progress-banner-center">';
                        $content[] = '<div class="ays-gpg-progress-banner-coupon">';
                            $content[] = '<div class="ays-gpg-progress-banner-coupon-box" onclick="galleryCopyToClipboard(\'FREE2PRO20\')" title="' . __('Click to copy', 'gallery-photo-gallery') . '">';
                                $content[] = '<span class="ays-gpg-progress-banner-coupon-text">FREE2PRO20</span>';
                                $content[] = '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="ays-gpg-progress-banner-copy-icon">';
                                    $content[] = '<path d="M13.5 2.5H6.5C5.67 2.5 5 3.17 5 4V10C5 10.83 5.67 11.5 6.5 11.5H13.5C14.33 11.5 15 10.83 15 10V4C15 3.17 14.33 2.5 13.5 2.5ZM13.5 10H6.5V4H13.5V10ZM2.5 6.5V12.5C2.5 13.33 3.17 14 4 14H10V12.5H4V6.5H2.5Z" fill="white"/>';
                                $content[] = '</svg>';
                            $content[] = '</div>';
                        $content[] = '</div>';
                        
                        $content[] = '<div class="ays-gpg-progress-banner-progress">';
                            $content[] = '<p class="ays-gpg-progress-banner-progress-text">' . __('Only', 'gallery-photo-gallery') . ' <span id="remaining-licenses">' . $remaining_licenses . '</span> ' . __('of 50 discounted licenses left', 'gallery-photo-gallery') . '</p>';
                            $content[] = '<div class="ays-gpg-progress-banner-progress-bar">';
                                $content[] = '<div class="ays-gpg-progress-banner-progress-fill" id="progress-fill" style="width: ' . $progress_percentage . '%;"></div>';
                            $content[] = '</div>';
                        $content[] = '</div>';
                    $content[] = '</div>';
                    
                    $content[] = '<div class="ays-gpg-progress-banner-right">';
                        $content[] = '<a href="'. $ays_gpg_cta_button_link .'" class="ays-gpg-progress-banner-upgrade" target="_blank">';
                        $content[] = '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">';
                            $content[] = '<path d="M14.6392 6.956C14.5743 6.78222 14.4081 6.66667 14.2223 6.66667H8.85565L11.9512 0.648C12.0485 0.458667 11.9983 0.227111 11.8308 0.0955556C11.7499 0.0315556 11.6525 0 11.5556 0C11.4521 0 11.3485 0.0364444 11.2654 0.108L8.00009 2.928L1.48765 8.55244C1.3472 8.67378 1.29653 8.86978 1.36142 9.04356C1.42631 9.21733 1.59209 9.33333 1.77787 9.33333H7.14454L4.04898 15.352C3.95165 15.5413 4.00187 15.7729 4.16942 15.9044C4.25031 15.9684 4.34765 16 4.44453 16C4.54809 16 4.65165 15.9636 4.73476 15.892L8.00009 13.072L14.5125 7.44756C14.6534 7.32622 14.7036 7.13022 14.6392 6.956Z" fill="white"/>';
                        $content[] = '</svg>';
                         $content[] = ' ' . __('Upgrade Now', 'gallery-photo-gallery');
                        $content[] = '</a>';
                    $content[] = '</div>';
                $content[] = '</div>';
                
                if( current_user_can( 'manage_options' ) ){
                $content[] = '<div id="ays-gpg-dismiss-buttons-content">';
                    $content[] = '<form action="" method="POST" style="position: absolute; bottom: 0; right: 0; color: #fff;">';
                            $content[] = '<button class="btn btn-link ays-button" name="ays_gpg_sale_btn" style="color: darkgrey; font-size: 11px;">'. __( "Dismiss ad", 'gallery-photo-gallery' ) .'</button>';
                            $content[] = wp_nonce_field( 'photo-gallery-sale-banner' , 'photo-gallery-sale-banner' );
                    $content[] = '</form>';
                $content[] = '</div>';
                }
            $content[] = '</div>';

            // Fox LMS Pro Banner Styles
            $content[] = '<style id="ays-gpg-progress-banner-styles-inline-css">';
            $content[] = '
                .ays-gpg-progress-banner-main {
                    background: linear-gradient(135deg, #6344ED 0%, #8C2ABE 100%);
                    padding: 20px 30px;
                    border-radius: 16px;
                    color: white;
                    position: relative;
                    margin: 20px 0;
                    box-shadow: 0 8px 32px rgba(99, 68, 237, 0.3);
                    border: 0;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-content {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 30px;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-left {
                    display: flex;
                    align-items: center;
                    gap: 20px;
                    flex: 1;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-center {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    flex: 1;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-right {
                    display: flex;
                    align-items: center;
                    gap: 20px;
                    flex-shrink: 0;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-icon {
                    font-size: 32px;
                    filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.2));
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-title {
                    font-size: 21px;
                    font-weight: 700;
                    margin: 0 0 8px 0;
                    line-height: 1.2;
                    color: #fff;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-title a {
                    text-decoration: underline;
                    color: #fff;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-subtitle {
                    font-size: 16px;
                    margin: 0;
                    opacity: 0.9;
                    font-weight: 400;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-coupon {
                    margin-bottom: 5px;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-coupon-box {
                    border: 2px dotted rgba(255, 255, 255, 0.6);
                    padding: 8px 16px;
                    border-radius: 8px;
                    background: rgba(255, 255, 255, 0.1);
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    backdrop-filter: blur(10px);
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-coupon-box:hover {
                    background: rgba(255, 255, 255, 0.2);
                    border-color: rgba(255, 255, 255, 0.8);
                    transform: translateY(-1px);
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-coupon-text {
                    font-size: 16px;
                    font-weight: 700;
                    letter-spacing: 1px;
                    color: #fff;
                    font-family: monospace;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-copy-icon {
                    opacity: 0.8;
                    transition: opacity 0.3s ease;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-coupon-box:hover .ays-gpg-progress-banner-copy-icon {
                    opacity: 1;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-progress {
                    text-align: center;
                    width: 100%;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-progress-text {
                    font-size: 14px;
                    margin: 0 0 10px 0;
                    opacity: 0.9;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-progress-bar {
                    width: 300px;
                    height: 10px;
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 4px;
                    overflow: hidden;
                    margin: 0 auto;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-progress-fill {
                    height: 100%;
                    background: linear-gradient(90deg, #4ADE80 0%, #22C55E 100%);
                    border-radius: 4px;
                    transition: width 0.8s ease;
                    width: 70%;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-upgrade {
                    background: linear-gradient(135deg, #F59E0B 0%, #F97316 100%);
                    color: white;
                    border: none;
                    padding: 12px 24px;
                    border-radius: 8px;
                    font-size: 16px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 16px rgba(245, 158, 11, 0.4);
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                }

                .ays-gpg-progress-banner-main .ays-gpg-progress-banner-upgrade:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.6);
                    text-decoration: none;
                    color: white;
                }

                .ays-gpg-progress-banner-main .notice-dismiss:before {
                    color: #fff;
                }

                /* Copy notification */
                .ays-gpg-copy-notification {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: rgba(0, 0, 0, 0.8);
                    color: white;
                    padding: 12px 24px;
                    border-radius: 8px;
                    font-size: 14px;
                    z-index: 10000;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }

                .ays-gpg-copy-notification.show {
                    opacity: 1;
                }

                @media (max-width: 1400px) {
                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-center {
                        flex-direction: column;
                    }
                }

                @media (max-width: 1200px) {
                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-content {
                        flex-direction: column;
                        gap: 20px;
                    }

                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-left {
                        width: 100%;
                        justify-content: center;
                        text-align: center;
                        flex-direction: column;
                    }

                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-center {
                        width: 100%;
                    }

                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-right {
                        width: 100%;
                        justify-content: center;
                    }
                }

                @media (max-width: 768px) {
                    #ays-gpg-progress-banner-main {
                        display: none !important;
                    }

                    .ays-gpg-progress-banner-main {
                        padding: 15px 20px;
                        margin: 15px 0;
                    }
                    
                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-title {
                        font-size: 18px;
                    }
                    
                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-subtitle {
                        font-size: 14px;
                    }
                    
                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-progress-bar {
                        width: 100%;
                        max-width: 280px;
                    }
                    
                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-upgrade {
                        padding: 10px 20px;
                        font-size: 14px;
                    }
                }

                @media (max-width: 480px) {
                    .ays-gpg-progress-banner-main {
                        padding: 12px 15px;
                    }
                    
                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-coupon-text {
                        font-size: 14px;
                    }
                    
                    .ays-gpg-progress-banner-main .ays-gpg-progress-banner-progress-bar {
                        max-width: 250px;
                    }
                }
            ';

            $content[] = '</style>';

            $content = implode( '', $content );
            echo ($content);
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
    public static function ays_gpg_black_friday_message2($ishmar){
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
