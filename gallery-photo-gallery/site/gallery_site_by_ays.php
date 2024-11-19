<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class AYS_Gallery_Site{
    protected static $instance = null;
    private function __construct() {
        $this->setup_constants();
        add_shortcode( 'gallery_p_gallery', array($this,'gallery_p_gallery_shortcode_generate'));
        add_action( 'wp_enqueue_scripts', array($this,'ays_site_styles') );
    }
    public function setup_constants() {
        if (!defined('AYS_GALL_SITE_DIR')) {
            define('AYS_GALL_SITE_DIR', dirname(__FILE__));
        }
        if (!defined('AYS_GALL_SITE_URL')) {
            define('AYS_GALL_SITE_URL', plugins_url(plugin_basename(dirname(__FILE__))));
        }
    }
    public function gallery_p_gallery_shortcode_generate($attributes){
        global $wpdb;
        $ays_gall_id = null;
        if( !array_key_exists( 'id', $attributes ) ) {
            $ays_gall_id = "No id provided in shortcode.";
        }
        else{
            $ays_gall_id = $attributes["id"];
        }
        $ays_gall_table_name = $wpdb->prefix."ays_gallery";
        $ays_result = $wpdb->get_row("SELECT * FROM ".$ays_gall_table_name." WHERE id=".$ays_gall_id);
        $ays_gall_title = $ays_result->title;
        $ays_gall_desc = $ays_result->description;
        $ays_gall_images_array = explode("***",$ays_result->images);
        $ays_gall_images_title_array = explode("***",$ays_result->images_titles);
        $ays_gall_images_descs_array = explode("***",$ays_result->images_descs);
        $ays_gall_images_alts_array = explode("***",$ays_result->images_alts);
        $ays_gall_images_urls_array = explode("***",$ays_result->images_urls);
        $ays_gall_width = $ays_result->width;
        $ays_gall_height = $ays_result->height;

        $ays_gall_site_path_1 ='<div id="container"><center><h2 id="combination">'.$ays_gall_title.'</h2><h4>'.$ays_gall_desc.'</h4></center>
    <ul>';
        $ays_gall_site_path_2 = null;
        foreach ($ays_gall_images_array as $ays_ind => $ays_gall_img) {
            $ays_gall_site_path_2 .='<li><a href="'.$ays_gall_img.'" data-imagelightbox="f"><img src="'.$ays_gall_img.'" alt="'.$ays_gall_images_alts_array[$ays_ind].'" title="'.$ays_gall_images_title_array[$ays_ind].'" ays_desc="'.$ays_gall_images_descs_array[$ays_ind].'" ays_url="'.$ays_gall_images_urls_array[$ays_ind].'"/></a></li>';
        }
        $ays_gall_site_path_3 = '</ul></div>';
?>
        <script>
        jQuery( function()
    {
        var
            // ACTIVITY INDICATOR

            activityIndicatorOn = function()
            {
                jQuery( '<div id="imagelightbox-loading"><div></div></div>' ).appendTo( 'body' );
            },
            activityIndicatorOff = function()
            {
                jQuery( '#imagelightbox-loading' ).remove();
            },


            // OVERLAY

            overlayOn = function()
            {
                jQuery( '<div id="imagelightbox-overlay"></div>' ).appendTo( 'body' );
            },
            overlayOff = function()
            {
                jQuery( '#imagelightbox-overlay' ).remove();
            },


            // CLOSE BUTTON

            closeButtonOn = function( instance )
            {
                jQuery( '<button type="button" id="imagelightbox-close" title="Close"></button>' ).appendTo( 'body' ).on( 'click touchend', function(){ jQuery( this ).remove(); instance.quitImageLightbox(); return false; });
            },
            closeButtonOff = function()
            {
                jQuery( '#imagelightbox-close' ).remove();
            },


            // CAPTION

            captionOn = function()
            {
                var ays_title = jQuery( 'a[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'title' );
                var ays_desc = jQuery( 'a[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'ays_desc' );
                var ays_url = jQuery( 'a[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"] img' ).attr( 'ays_url' );
                if( ays_title.length > 0 )
                    jQuery( '<div id="imagelightbox-caption"><a class="ays_cap_link" target="_blank" href="'+ays_url+'">' + ays_title + "|"+ ays_desc+ '</a></div>' ).appendTo( 'body' );
            },
            captionOff = function()
            {
                jQuery( '#imagelightbox-caption' ).remove();
            },


            // NAVIGATION

            navigationOn = function( instance, selector )
            {
                var images = jQuery( selector );
                if( images.length )
                {
                    var nav = jQuery( '<div id="imagelightbox-nav"></div>' );
                    for( var i = 0; i < images.length; i++ )
                        nav.append( '<button type="button"></button>' );

                    nav.appendTo( 'body' );
                    nav.on( 'click touchend', function(){ return false; });

                    var navItems = nav.find( 'button' );
                    navItems.on( 'click touchend', function()
                    {
                        var jQuerythis = jQuery( this );
                        if( images.eq( jQuerythis.index() ).attr( 'href' ) != jQuery( '#imagelightbox' ).attr( 'src' ) )
                            instance.switchImageLightbox( jQuerythis.index() );

                        navItems.removeClass( 'active' );
                        navItems.eq( jQuerythis.index() ).addClass( 'active' );

                        return false;
                    })
                    .on( 'touchend', function(){ return false; });
                }
            },
            navigationUpdate = function( selector )
            {
                var items = jQuery( '#imagelightbox-nav button' );
                items.removeClass( 'active' );
                items.eq( jQuery( selector ).filter( '[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"]' ).index( selector ) ).addClass( 'active' );
            },
            navigationOff = function()
            {
                jQuery( '#imagelightbox-nav' ).remove();
            },


            // ARROWS

            arrowsOn = function( instance, selector )
            {
                var jQueryarrows = jQuery( '<button type="button" class="imagelightbox-arrow imagelightbox-arrow-left"></button><button type="button" class="imagelightbox-arrow imagelightbox-arrow-right"></button>' );

                jQueryarrows.appendTo( 'body' );

                jQueryarrows.on( 'click touchend', function( e )
                {
                    e.preventDefault();

                    var jQuerythis  = jQuery( this ),
                        jQuerytarget    = jQuery( selector + '[href="' + jQuery( '#imagelightbox' ).attr( 'src' ) + '"]' ),
                        index   = jQuerytarget.index( selector );

                    if( jQuerythis.hasClass( 'imagelightbox-arrow-left' ) )
                    {
                        index = index - 1;
                        if( !jQuery( selector ).eq( index ).length )
                            index = jQuery( selector ).length;
                    }
                    else
                    {
                        index = index + 1;
                        if( !jQuery( selector ).eq( index ).length )
                            index = 0;
                    }

                    instance.switchImageLightbox( index );
                    return false;
                });
            },
            arrowsOff = function()
            {
                jQuery( '.imagelightbox-arrow' ).remove();
            };


        //  WITH ACTIVITY INDICATION

        jQuery( 'a[data-imagelightbox="a"]' ).imageLightbox(
        {
            onLoadStart:    function() { activityIndicatorOn(); },
            onLoadEnd:      function() { activityIndicatorOff(); },
            onEnd:          function() { activityIndicatorOff(); }
        });


        //  WITH OVERLAY & ACTIVITY INDICATION

        jQuery( 'a[data-imagelightbox="b"]' ).imageLightbox(
        {
            onStart:     function() { overlayOn(); },
            onEnd:       function() { overlayOff(); activityIndicatorOff(); },
            onLoadStart: function() { activityIndicatorOn(); },
            onLoadEnd:   function() { activityIndicatorOff(); }
        });


        //  WITH "CLOSE" BUTTON & ACTIVITY INDICATION

        var instanceC = jQuery( 'a[data-imagelightbox="c"]' ).imageLightbox(
            {
                quitOnDocClick: false,
                onStart:        function() { closeButtonOn( instanceC ); },
                onEnd:          function() { closeButtonOff(); activityIndicatorOff(); },
                onLoadStart:    function() { activityIndicatorOn(); },
                onLoadEnd:      function() { activityIndicatorOff(); }
            });


        //  WITH CAPTION & ACTIVITY INDICATION

        jQuery( 'a[data-imagelightbox="d"]' ).imageLightbox(
        {
            onLoadStart: function() { captionOff(); activityIndicatorOn(); },
            onLoadEnd:   function() { captionOn(); activityIndicatorOff(); },
            onEnd:       function() { captionOff(); activityIndicatorOff(); }
        });


        //  WITH ARROWS & ACTIVITY INDICATION

        var selectorG = 'a[data-imagelightbox="g"]';
        var instanceG = jQuery( selectorG ).imageLightbox(
            {
                onStart:        function(){ arrowsOn( instanceG, selectorG ); },
                onEnd:          function(){ arrowsOff(); activityIndicatorOff(); },
                onLoadStart:    function(){ activityIndicatorOn(); },
                onLoadEnd:      function(){ jQuery( '.imagelightbox-arrow' ).css( 'display', 'block' ); activityIndicatorOff(); }
            });


        //  WITH NAVIGATION & ACTIVITY INDICATION

        var selectorE = 'a[data-imagelightbox="e"]';
        var instanceE = jQuery( selectorE ).imageLightbox(
            {
                onStart:     function() { navigationOn( instanceE, selectorE ); },
                onEnd:       function() { navigationOff(); activityIndicatorOff(); },
                onLoadStart: function() { activityIndicatorOn(); },
                onLoadEnd:   function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
            });


        //  ALL COMBINED

        var selectorF = 'a[data-imagelightbox="f"]';
        var instanceF = jQuery( selectorF ).imageLightbox(
            {
                onStart:        function() { overlayOn(); closeButtonOn( instanceF ); arrowsOn( instanceF, selectorF ); },
                onEnd:          function() { overlayOff(); captionOff(); closeButtonOff(); arrowsOff(); activityIndicatorOff(); },
                onLoadStart:    function() { captionOff(); activityIndicatorOn(); },
                onLoadEnd:      function() { captionOn(); activityIndicatorOff(); jQuery( '.imagelightbox-arrow' ).css( 'display', 'block' ); }
            });


        //  DYNAMICALLY ADDED ITEMS

        var instanceH = jQuery( 'a[data-imagelightbox="h"]' ).imageLightbox(
            {
                quitOnDocClick: false,
                onStart:        function() { closeButtonOn( instanceH ); },
                onEnd:          function() { closeButtonOff(); activityIndicatorOff(); },
                onLoadStart:    function() { activityIndicatorOn(); },
                onLoadEnd:      function() { activityIndicatorOff(); }
            });

        jQuery( '.js--add-dynamic ' ).on( 'click', function( e )
        {
            e.preventDefault();
            var items = jQuery( '.js--dynamic-items' );
            instanceH.addToImageLightbox( items.find( 'a' ) );
            jQuery( '.js--dynamic-place' ).append( items.find( 'li' ).detach() );
            jQuery( this ).remove();
            items.remove();
        });

    });

        </script>
        <?php
        return $ays_gall_site_path_1.$ays_gall_site_path_2.$ays_gall_site_path_3;

    }
    
    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    public function ays_site_styles(){
        wp_enqueue_script('jquery');
        wp_register_script('ays_site_script',AYS_GALL_SITE_URL.'/js/imagelightbox.min.js');
        wp_enqueue_script('ays_site_script');
        wp_register_script('ays_site_gall_script',AYS_GALL_SITE_URL.'/js/main.js');
        wp_enqueue_script('ays_site_gall_script');
        wp_register_style('ays_site_style',AYS_GALL_SITE_URL.'/css/main.css');
        wp_enqueue_style( 'ays_site_style');
        wp_register_style('ays_site_gall_style',AYS_GALL_SITE_URL.'/css/ays_gall_site.css');
        wp_enqueue_style( 'ays_site_gall_style');
    }
}

