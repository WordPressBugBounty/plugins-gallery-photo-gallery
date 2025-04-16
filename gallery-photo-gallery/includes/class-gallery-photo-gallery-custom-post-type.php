<?php
/**
 * The admin-facing custom post type functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      6.1.3
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/includes
 */

/**
 * The admin-facing custom post type functionality of the plugin.
 *
 * Defines the plugin name, version, flush version, name prefix
 *
 * @package    Gallery_Photo_Gallery
 * @subpackage Gallery_Photo_Gallery/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Gallery_Custom_Post_Type {

    private $plugin_name;
    private $version;
    private $ays_gallery_flush_version;
    public  $name_prefix;

    public function __construct($plugin_name, $version){
        $this->plugin_name = $plugin_name;
        $this->name_prefix = 'ays-';
        $this->version = $version;
        $this->ays_gallery_flush_version = '1.0.0';
        add_action( 'init', array( $this, 'ays_gallery_register_custom_post_type' ) );
    }

    public function ays_gallery_register_custom_post_type(){
        $args = array(
            'public'  => true,
            'rewrite' => true,
            'show_in_menu' => false,
            'exclude_from_search' => false, 
            'show_ui' => false,
            'show_in_nav_menus' => false,
            'show_in_rest' => false
        );

        register_post_type( 'ays-gallery', $args );
        $this->ays_gallery_custom_rewrite_rule();
        $this->ays_gallery_flush_permalinks();
    }

    public static function ays_gallery_add_custom_post($args, $update = true){
        
        $gallery_id    = (isset($args['gallery_id']) && $args['gallery_id'] != '' && $args['gallery_id'] != 0) ? esc_attr($args['gallery_id']) : '';
        $gallery_title = (isset($args['gallery_title']) && $args['gallery_title'] != '') ? esc_attr($args['gallery_title']) : '';
        $author_id  = (isset($args['author_id']) && $args['author_id'] != '') ? esc_attr($args['author_id']) : get_current_user_id();

        $post_content = '[gallery_p_gallery id="'.$gallery_id.'"]';

        $new_post = array(
            'post_title'    => $gallery_title,
            'post_author'   => $author_id,
            'post_type'     => 'ays-gallery', // Custom post type name is -> ays-gallery
            'post_content'  => $post_content,
            'post_status'   => 'draft',
            'post_date'     => current_time( 'mysql' ),
        );
        $post_id = wp_insert_post($new_post);
        if($update){
            if(isset($post_id) && $post_id > 0){
                self::update_galleries_table_custom_post_id($post_id, $gallery_id);
            }
        }
        return $post_id;
    }

    public static function update_galleries_table_custom_post_id($custom_post_id, $gallery_id){
        global $wpdb;
        $table = esc_sql( $wpdb->prefix . "ays_gallery" );
        $result = $wpdb->update(// phpcs:ignore WordPress.DB.DirectDatabaseQuery
            $table,
            array('custom_post_id' => $custom_post_id),
            array('id' => $gallery_id),
            array('%d'),
            array('%d')
        );
    }

    public function ays_gallery_flush_permalinks(){
        if ( get_site_option( 'ays_gallery_flush_version' ) != $this->ays_gallery_flush_version ) {
            flush_rewrite_rules();
        }
        update_option( 'ays_gallery_flush_version', $this->ays_gallery_flush_version );            
    }
    
    public function ays_gallery_custom_rewrite_rule() {
        add_rewrite_rule(
            'ays-gallery/([^/]+)/?',
            'index.php?post_type=ays-gallery&name=$matches[1]',
            'top'
        );
    }
}
