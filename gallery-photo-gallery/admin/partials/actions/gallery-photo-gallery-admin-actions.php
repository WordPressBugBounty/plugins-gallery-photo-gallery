<?php
global $wpdb;
if (!isset($_COOKIE['ays_gpg_page_tab_free'])) {
    setcookie('ays_gpg_page_tab_free', 'tab_0', time() + 3600);
}
if(isset($_GET['ays_gpg_settings_tab'])){
    $ays_gpg_tab = sanitize_key( $_GET['ays_gpg_settings_tab'] );
}else{
    $ays_gpg_tab = 'tab1';
}
$action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
$heading = '';
$id = ( isset( $_GET['gallery'] ) ) ? absint( sanitize_text_field( $_GET['gallery'] ) ) : null;

$user_id = get_current_user_id();
$user = get_userdata($user_id);
$author = array(
    'id' => $user->ID,
    'name' => $user->data->display_name
);
$get_all_galleries = Photo_Gallery_Data::get_galleries();
$g_options = array(
    'columns_count'         => '3',
    'view_type'             => 'grid',
    "border_radius"         => "0",
    "enable_border_radius_mobile" => "on",
    "border_radius_mobile"  => "0",
    "admin_pagination"      => "all",
    "hover_zoom"            => "no",
    "show_gal_title"        => "on",
    "show_gal_desc"         => "on",
    "images_hover_effect"   => "simple",
    "hover_dir_aware"       => "slide",
    "images_border"         => "",
    "images_border_width"   => "1",
    "images_border_style"   => "solid",
    "images_border_color"   => "#000000",
    "hover_effect"          => "fadeIn",
    "hover_opacity"         => "0.5",
    "image_sizes"           => "full_size",
    "lightbox_color"        => "rgba(0,0,0,0)",
    "images_orderby"        => "noordering",
    "hover_icon"            => "search_plus",
    "show_title"            => "",
    "show_title_on"         => "gallery_image",
    "title_position"        => "bottom",
    "show_with_date"        => "",
    "images_distance"       => "5",
    "images_loading"        => "all_loaded",
    "gallery_loader"        => "flower",
    "hover_icon_size"       => "20",
    "thumbnail_title_size"  => "12",
    "thumb_height_mobile"   => "170",
    "thumb_height_desktop"  => "260",
    "enable_light_box"      => "off",
    "ays_filter_cat"        => "off",
    "filter_thubnail_opt"   => "none",
    "enable_filter_thubnail_opt_mobile" => "none",
    "filter_thubnail_opt_mobile" => "on",
    "ordering_asc_desc"     => "ascending",
    "custom_class"          => "",
    "link_on_whole_img"     => "off",
    "create_date"           => current_time( 'mysql' ),
    "author"                => $author,
    'gpg_create_author'     => $user_id,
);
$g_l_options = array(
    "lightbox_counter"      => "true",
    "lightbox_autoplay"     => "true",
    "lb_pause"              => "5000",
    "lb_show_caption"       => "true",
    "filter_lightbox_opt"   => "none",
    "enable_filter_lightbox_opt_mobile"   => "on",
    "filter_lightbox_opt_mobile"   => "none",
);
$gallery = array(
    "id"                => "",
    "title"             => "Demo title",
    "description"       => "Demo description",
    "images"            => "",
    "images_titles"     => "",
    "images_descs"      => "",
    "images_alts"       => "",
    "images_urls"       => "",
    "categories_id"     => "",
    "category_ids"      => "",
    "width"             => "",
    "height"            => "1000",
    "published"         => 1,
    "options"           => json_encode($g_options,true),
    "lightbox_options"  => json_encode($g_l_options,true),
    "custom_css"        => "",
    "images_dates"      => "",
);
switch( $action ) {
    case 'add':
        $heading = __('Add new gallery', 'gallery-photo-gallery');
        break;
    case 'edit':
        $heading = __('Edit gallery', 'gallery-photo-gallery');
        $gallery = $this->gallery_obj->get_gallery_by_id($id);
        break;
}

$gallery_message_vars = array(  
    '%%user_first_name%%'                       => __("User's First Name", 'gallery-photo-gallery'),
    '%%user_last_name%%'                        => __("User's Last Name", 'gallery-photo-gallery'),
    '%%user_display_name%%'                     => __("User's Display Name", 'gallery-photo-gallery'),
    '%%user_nickname%%'                         => __("User's Nickname", 'gallery-photo-gallery'),
    '%%user_website_url%%'                      => __("User's Website URL", 'gallery-photo-gallery'),
    '%%user_wordpress_email%%'                  => __("User's WordPress profile email", 'gallery-photo-gallery'),
    '%%user_wordpress_roles%%'                  => __("User's Wordpress Roles", 'gallery-photo-gallery'),
    '%%user_ip_address%%'                       => __("User's IP address", 'gallery-photo-gallery'),
    '%%user_id%%'                               => __("User's ID", 'gallery-photo-gallery'),
    '%%gallery_id%%'                            => __("Gallery ID", 'gallery-photo-gallery'),
    '%%current_gallery_title%%'                 => __("Gallery Title", 'gallery-photo-gallery'),
    '%%current_gallery_images_count%%'          => __("Gallery Images Count", 'gallery-photo-gallery'),
    '%%current_gallery_author%%'                => __("Gallery Author", 'gallery-photo-gallery'),
    '%%current_gallery_author_email%%'          => __("Gallery Author Email", 'gallery-photo-gallery'),
    '%%current_gallery_author_display_name%%'   => __("Gallery Author Display Name", 'gallery-photo-gallery'),
    '%%creation_date%%'                         => __("Gallery Creation Date", 'gallery-photo-gallery'),
    '%%current_date%%'                          => __("Current Date", 'gallery-photo-gallery'),
    '%%current_gallery_page_link%%'             => __("Gallery page link", 'gallery-photo-gallery'),
    '%%admin_email%%'                           => __("Admin Email", 'gallery-photo-gallery'),
    '%%post_author_nickname%%'                  => __("Post Author Nickname", 'gallery-photo-gallery'),
    '%%post_author_email%%'                     => __("Post Author Email", 'gallery-photo-gallery'),
    '%%post_author_display_name%%'              => __("Post Author Display Name", 'gallery-photo-gallery'),
    '%%post_author_first_name%%'                => __("Post Author First Name", 'gallery-photo-gallery'),
    '%%post_author_last_name%%'                 => __("Post Author Last Name", 'gallery-photo-gallery'),
    '%%post_author_website_url%%'               => __("Post Author Website URL", 'gallery-photo-gallery'),
    '%%post_title%%'                            => __("Post Title", 'gallery-photo-gallery'),
    '%%post_id%%'                               => __("Post ID", 'gallery-photo-gallery'),
    '%%site_title%%'                            => __("Site Title", 'gallery-photo-gallery'),
    '%%home_page_url%%'                         => __("Home page URL", 'gallery-photo-gallery'),
);

// Gallery categories IDs
$category_ids = isset( $gallery['category_ids'] ) && $gallery['category_ids'] != '' ? $gallery['category_ids'] : '';
$category_ids = $category_ids == '' ? array() : explode( ',', $category_ids );

$gallery_message_vars_html = $this->ays_gallery_generate_message_vars_html( $gallery_message_vars );

if(isset($_POST["ays-submit"]) || isset($_POST["ays-submit-top"])){
    $_POST["id"] = $id;
    $this->gallery_obj->add_or_edit_gallery($_POST);
}
if(isset($_POST["ays-apply"]) || isset($_POST["ays-apply-top"])){
    $_POST["id"] = $id;
    $_POST["submit_type"] = 'apply';
    $this->gallery_obj->add_or_edit_gallery($_POST);
}

$next_gallery_id = "";
$prev_gallery_id = "";
if ( isset( $id ) && !is_null( $id ) ) {
    $next_gallery = $this->get_next_or_prev_gallery_by_id( $id, "next" );
    $next_gallery_id = (isset( $next_gallery['id'] ) && $next_gallery['id'] != "") ? absint( $next_gallery['id'] ) : null;
    $prev_gallery = $this->get_next_or_prev_gallery_by_id( $id, "prev" );
    $prev_gallery_id = (isset( $prev_gallery['id'] ) && $prev_gallery['id'] != "") ? absint( $prev_gallery['id'] ) : null;
}

$gallery_published = (isset( $gallery['published'] ) && $gallery['published'] != "" ) ? esc_attr( absint( $gallery['published'] ) ) : 1;

$this_site_path = trim(get_site_url(), "https:");
$gal_options            = json_decode($gallery['options'], true);
$gal_lightbox_options   = json_decode($gallery['lightbox_options'], true);

$show_gal_title = (!isset($gal_options['show_gal_title'])) ? 'on' : $gal_options['show_gal_title'];
$show_gal_desc = (!isset($gal_options['show_gal_desc'])) ? 'on' : $gal_options['show_gal_desc'];

$admin_pagination = (!isset($gal_options['admin_pagination']) ||
                     $gal_options['admin_pagination'] == null ||
                     $gal_options['admin_pagination'] == '') ? "all" : $gal_options['admin_pagination'];
$ays_hover_zoom = (!isset($gal_options['hover_zoom']) ||
                   $gal_options['hover_zoom'] == null ||
                   $gal_options['hover_zoom'] == '') ? "no" : $gal_options['hover_zoom'];

//Hover zoom animation Speed
$hover_zoom_animation_speed = (isset($gal_options['hover_zoom_animation_speed']) && $gal_options['hover_zoom_animation_speed'] !== '') ? abs($gal_options['hover_zoom_animation_speed']) : 0.5;

// Hover animation Speed
$hover_animation_speed = (isset($gal_options['hover_animation_speed']) && $gal_options['hover_animation_speed'] !== '') ? abs($gal_options['hover_animation_speed']) : 0.5;

// Enable Hover animation Speed Mobile
$gal_options['enable_hover_animation_speed_mobile'] = isset($gal_options['enable_hover_animation_speed_mobile']) && $gal_options['enable_hover_animation_speed_mobile'] == 'off' ? 'off' : 'on';
$enable_hover_animation_speed_mobile = $gal_options['enable_hover_animation_speed_mobile'] == 'on' ?  true : false;

// Hover animation Speed Mobile
$hover_animation_speed_mobile = isset( $gal_options['hover_animation_speed_mobile'] ) && $gal_options['hover_animation_speed_mobile'] != '' ? abs( $gal_options['hover_animation_speed_mobile'] ) : $hover_animation_speed;

//Hover scale animation Speed
$hover_scale_animation_speed = (isset($gal_options['hover_scale_animation_speed']) && $gal_options['hover_scale_animation_speed'] !== '') ? abs($gal_options['hover_scale_animation_speed']) : 1;

$ays_hover_scale = (!isset($gal_options['hover_scale']) ||
                   $gal_options['hover_scale'] == null ||
                   $gal_options['hover_scale'] == '') ? "no" : $gal_options['hover_scale'];
$show_thumb_title_on = (!isset($gal_options['show_title_on']) || 
                       $gal_options['show_title_on'] == false ||
                       $gal_options['show_title_on'] == "") ? "gallery_image" : $gal_options['show_title_on'];
$thumb_title_position = (!isset($gal_options['title_position']) || 
                       $gal_options['title_position'] == false ||
                       $gal_options['title_position'] == "") ? "bottom" : $gal_options['title_position'];
$ays_images_hover_effect = (!isset($gal_options['images_hover_effect']) || 
                            $gal_options['images_hover_effect'] == '' ||
                            $gal_options['images_hover_effect'] == null) ? 'simple' : $gal_options['images_hover_effect'];
$ays_images_hover_dir_aware = (!isset($gal_options['hover_dir_aware']) ||
                              $gal_options['hover_dir_aware'] == null ||
                              $gal_options['hover_dir_aware'] == "") ? "slide" : $gal_options['hover_dir_aware'];
$ays_images_border = (!isset($gal_options['images_border'])) ? '' : $gal_options['images_border'];
$ays_images_border_width    = (!isset($gal_options['images_border_width'])) ? '1' : $gal_options['images_border_width'];
$ays_images_border_style    = (!isset($gal_options['images_border_style'])) ? 'solid' : $gal_options['images_border_style'];
$ays_images_border_color    = (!isset($gal_options['images_border_color'])) ? '#000000' : esc_attr(stripslashes( $gal_options['images_border_color'] ));
$ays_gallery_loader  = (!isset($gal_options['gallery_loader'])) ? "flower" : $gal_options['gallery_loader'];

if ($ays_gallery_loader == 'default') {
    $ays_gallery_loader = "flower";
}

// Gallery loader text value
$gallery_loader_text_value = (isset($gal_options['gallery_loader_text_value']) && $gal_options['gallery_loader_text_value'] != '') ? stripslashes(esc_attr($gal_options['gallery_loader_text_value'])) : '';

// Gallery loader custom gif value
$gallery_loader_custom_gif = (isset($gal_options['gallery_loader_custom_gif']) && $gal_options['gallery_loader_custom_gif'] != '') ? stripslashes(esc_url($gal_options['gallery_loader_custom_gif'])) : '';

// Gallery loader custom gif width
$gallery_loader_custom_gif_width = (isset($gal_options['gallery_loader_custom_gif_width']) && $gal_options['gallery_loader_custom_gif_width'] != '') ? absint( intval( $gal_options['gallery_loader_custom_gif_width'] ) ) : 100;

$ays_gpg_view_type = (!isset($gal_options['view_type']) || $gal_options['view_type'] == "") ? "grid" : $gal_options['view_type'];

// Gallery Border radius
$ays_gpg_border_radius = !isset($gal_options['border_radius']) || $gal_options['border_radius'] == "" ? "0" : ($gal_options['border_radius']);

// Enable Gallery Border radius Mobile
$gal_options['enable_border_radius_mobile'] = isset($gal_options['enable_border_radius_mobile']) && $gal_options['enable_border_radius_mobile'] == 'off' ? 'off' : 'on';
$enable_ays_gpg_border_radius_mobile = $gal_options['enable_border_radius_mobile'] == 'on' ?  true : false;

// Gallery Border radius Mobile
$ays_gpg_border_radius_mobile = isset( $gal_options['border_radius_mobile'] ) && $gal_options['border_radius_mobile'] != '' ? stripslashes ( esc_attr( $gal_options['border_radius_mobile'] ) ) : $ays_gpg_border_radius;

$ays_gpg_hover_icon_size = !isset($gal_options['hover_icon_size']) ? "20" : ($gal_options['hover_icon_size']);
$ays_gpg_thumbnail_title_size = !isset($gal_options['thumbnail_title_size']) ? "12" : ($gal_options['thumbnail_title_size']);
$ays_thumb_height_mobile = !isset($gal_options['thumb_height_mobile']) ? "170" : ($gal_options['thumb_height_mobile']);
$ays_thumb_height_desktop = !isset($gal_options['thumb_height_desktop']) ? "260" : ($gal_options['thumb_height_desktop']);

$ays_gpg_lightbox_counter           = (!isset($gal_lightbox_options['lightbox_counter'])) ? "true" : $gal_lightbox_options['lightbox_counter'];
$ays_gpg_lightbox_autoplay          = (!isset($gal_lightbox_options['lightbox_autoplay'])) ? "true" : $gal_lightbox_options['lightbox_autoplay'];
$ays_gpg_lightbox_pause             = (!isset($gal_lightbox_options['lb_pause'])) ? "5000" : $gal_lightbox_options['lb_pause'];
$ays_gpg_show_caption               = (!isset($gal_lightbox_options['lb_show_caption'])) ? "true" : $gal_lightbox_options['lb_show_caption'];

$ays_gpg_lg_keypress = (!isset($gal_lightbox_options["lb_keypress"])) ? "true" : $gal_lightbox_options["lb_keypress"];
$ays_gpg_lg_esckey = (!isset($gal_lightbox_options["lb_esckey"])) ? "true" : $gal_lightbox_options["lb_esckey"];
$ays_gpg_hide_progress_line = (!isset($gal_lightbox_options["hide_progress_line"])) ? "true" : $gal_lightbox_options["hide_progress_line"];

//Progress Line color
$ays_gpg_progress_line_color = isset($gal_lightbox_options['progress_line_color']) ? esc_attr(stripslashes($gal_lightbox_options['progress_line_color'])) : '#a90707';

//Enable Gallery Progress Line color Mobile
$gal_lightbox_options['enable_progress_line_color_mobile'] = isset( $gal_lightbox_options['enable_progress_line_color_mobile'] ) && $gal_lightbox_options['enable_progress_line_color_mobile'] == 'off' ? 'off' : 'on';
$enable_ays_gpg_progress_line_color_mobile = $gal_lightbox_options['enable_progress_line_color_mobile'] == 'on' ?  true : false;

// Filter for thumbnail
$filter_thubnail_opt = ( isset( $gal_options['filter_thubnail_opt'] ) && $gal_options['filter_thubnail_opt'] != "" ) ? esc_attr( $gal_options['filter_thubnail_opt'] ) : "none";

// Enable Filter for thumbnail Mobile
$gal_options['enable_filter_thubnail_opt_mobile'] = isset($gal_options['enable_filter_thubnail_opt_mobile']) && $gal_options['enable_filter_thubnail_opt_mobile'] == 'off' ? 'off' : 'on';
$enable_filter_thubnail_opt_mobile = $gal_options['enable_filter_thubnail_opt_mobile'] == 'on' ?  true : false;

// Filter for thumbnail Mobile
$filter_thubnail_opt_mobile = isset( $gal_options['filter_thubnail_opt_mobile'] ) && $gal_options['filter_thubnail_opt_mobile'] != '' ? stripslashes ( esc_attr( $gal_options['filter_thubnail_opt_mobile'] ) ) : $filter_thubnail_opt;

// Filter for lightbox
$filter_lightbox_opt = ( isset( $gal_lightbox_options['filter_lightbox_opt'] ) && $gal_lightbox_options['filter_lightbox_opt'] != "" ) ? esc_attr( $gal_lightbox_options['filter_lightbox_opt'] ) : "none";

// Enable Filter for lightbox Mobile
$gal_lightbox_options['enable_filter_lightbox_opt_mobile'] = isset($gal_lightbox_options['enable_filter_lightbox_opt_mobile']) && $gal_lightbox_options['enable_filter_lightbox_opt_mobile'] == 'off' ? 'off' : 'on';
$enable_filter_lightbox_opt_mobile = $gal_lightbox_options['enable_filter_lightbox_opt_mobile'] == 'on' ?  true : false;

// Filter for lightbox Mobile
$filter_lightbox_opt_mobile = isset( $gal_lightbox_options['filter_lightbox_opt_mobile'] ) && $gal_lightbox_options['filter_lightbox_opt_mobile'] != '' ? stripslashes ( esc_attr( $gal_lightbox_options['filter_lightbox_opt_mobile'] ) ) : $filter_lightbox_opt;

//Gallery Progress Line color Mobile
$ays_gpg_progress_line_color_mobile = isset( $gal_lightbox_options['progress_line_color_mobile'] ) && $gal_lightbox_options['progress_line_color_mobile'] != '' ? esc_attr( $gal_lightbox_options['progress_line_color_mobile'] ) : $ays_gpg_progress_line_color;

// Gallery image position
$gallery_img_position = (isset($gal_options['gallery_img_position']) && $gal_options['gallery_img_position'] != 'center-center') ? $gal_options['gallery_img_position'] : 'center-center';
$gallery_img_position = (isset($gal_options['gallery_img_position_l']) && isset($gal_options['gallery_img_position_r'])) ? $gal_options['gallery_img_position_l'].'-'.$gal_options['gallery_img_position_r'] : $gallery_img_position;

// Enable image position mobile
$enable_gallery_img_position_mobile = isset($gal_options['enable_gallery_img_position_mobile']) && $gal_options['enable_gallery_img_position_mobile'] == 'on' ? true : false;

// Image position mobile
if (isset($gal_options['gallery_img_position_mobile'])) {
    $gallery_img_position_mobile = $gal_options['gallery_img_position_mobile'] !== '' ? stripslashes( esc_attr($gal_options['gallery_img_position_mobile']) ) : 'center-center';
} else {
    $gallery_img_position_mobile = $gallery_img_position;
}

$image_sizes = $this->ays_get_all_image_sizes();
$image_no_photo = AYS_GPG_ADMIN_URL .'images/no-photo.png';

$gallery_categories = $this->ays_get_gallery_image_categories();
$categories = $this->ays_get_gallery_categories();

$img_load_effect = isset($gal_options['img_load_effect']) ? $gal_options['img_load_effect'] : 'fadeIn';

$ordering_asc_desc = (isset($gal_options['ordering_asc_desc']) && $gal_options['ordering_asc_desc'] != '') ? $gal_options['ordering_asc_desc'] : 'ascending';
$custom_class = (isset($gal_options['custom_class']) && $gal_options['custom_class'] != "") ? sanitize_text_field( $gal_options['custom_class'] ) : '';
$gpg_height_width_ratio = isset($gal_options['height_width_ratio']) ? $gal_options['height_width_ratio'] : '1';

$responsive_width = (!isset($gal_options['resp_width'])) ? 'on' : $gal_options['resp_width'];

// Enable RTL Direction
$enable_rtl_direction = (isset($gal_options['enable_rtl_direction']) && $gal_options['enable_rtl_direction'] == 'on') ? $gal_options['enable_rtl_direction'] : 'off';

// Enable RTL Direction mobile
if ( isset($gal_options['enable_rtl_direction_mobile']) ) {
    $enable_rtl_direction_mobile = $gal_options['enable_rtl_direction_mobile'] == 'on' ? 'on' : 'off';
} else {
    $enable_rtl_direction_mobile = $enable_rtl_direction;
}

// Enable search image
$enable_search_img = ( isset( $gal_options['enable_search_img'] ) && $gal_options['enable_search_img'] == 'on' ) ? $gal_options['enable_search_img'] : 'off';

// Enable search image mobile
if ( isset( $gal_options['enable_search_img_mobile'] ) ) {
    $enable_search_img_mobile = $gal_options['enable_search_img_mobile'] == 'on' ? 'on' : 'off';
} else {
    $enable_search_img_mobile = $enable_search_img;
}

$loading_type = (isset($gal_options['images_loading']) && $gal_options['images_loading'] != '') ? $gal_options['images_loading'] : "all_loaded"; 

$redirect_type = (isset($gal_options['redirect_url_tab']) && $gal_options['redirect_url_tab'] != '') ? $gal_options['redirect_url_tab'] : "_blank"; 

//Thumbnail title Background color
$thumbnail_title_bg_color = isset($gal_options['lightbox_color']) ? esc_attr(stripslashes($gal_options['lightbox_color'])) : 'rgba(0,0,0,0)';

//Enable thumbnail title Background color Mobile
$gal_options['enable_lightbox_color_mobile'] = isset( $gal_options['enable_lightbox_color_mobile'] ) && $gal_options['enable_lightbox_color_mobile'] == 'off' ? 'off' : 'on';
$enable_thumbnail_title_bg_color_mobile = $gal_options['enable_lightbox_color_mobile'] == 'on' ?  true : false;

//Thumbnail title Background color Mobile
$thumbnail_title_bg_color_mobile = isset( $gal_options['lightbox_color_mobile'] ) && $gal_options['lightbox_color_mobile'] != '' ? esc_attr( $gal_options['lightbox_color_mobile'] ) : $thumbnail_title_bg_color;

//Thumbnail title color
$thumbnail_title_color = isset($gal_options['ays_gpg_title_color']) ? esc_attr(stripslashes($gal_options['ays_gpg_title_color'])) : '#fff';

//Enable thumbnail title color Mobile
$gal_options['enable_ays_gpg_title_color_mobile'] = isset( $gal_options['enable_ays_gpg_title_color_mobile'] ) && $gal_options['enable_ays_gpg_title_color_mobile'] == 'off' ? 'off' : 'on';
$enable_thumbnail_title_color_mobile = $gal_options['enable_ays_gpg_title_color_mobile'] == 'on' ?  true : false;

//Thumbnail title color Mobile
$thumbnail_title_color_mobile = isset( $gal_options['ays_gpg_title_color_mobile'] ) && $gal_options['ays_gpg_title_color_mobile'] != '' ? esc_attr( $gal_options['ays_gpg_title_color_mobile'] ) : $thumbnail_title_color;

//Gallery title color
$gallery_title_color = isset($gal_options['ays_gallery_title_color']) ? esc_attr(stripslashes($gal_options['ays_gallery_title_color'])) : '#000';

//Enable Gallery title color Mobile
$gal_options['enable_ays_gallery_title_color_mobile'] = isset( $gal_options['enable_ays_gallery_title_color_mobile'] ) && $gal_options['enable_ays_gallery_title_color_mobile'] == 'off' ? 'off' : 'on';
$enable_gallery_title_color_mobile = $gal_options['enable_ays_gallery_title_color_mobile'] == 'on' ?  true : false;

//Gallery title color Mobile
$gallery_title_color_mobile = isset( $gal_options['ays_gallery_title_color_mobile'] ) && $gal_options['ays_gallery_title_color_mobile'] != '' ? esc_attr( $gal_options['ays_gallery_title_color_mobile'] ) : $gallery_title_color;

//Gallery description color
$gallery_desc_color = isset($gal_options['ays_gallery_desc_color']) ? esc_attr(stripslashes($gal_options['ays_gallery_desc_color'])) : '#000';

//Enable Gallery description color Mobile
$gal_options['enable_ays_gallery_desc_color_mobile'] = isset( $gal_options['enable_ays_gallery_desc_color_mobile'] ) && $gal_options['enable_ays_gallery_desc_color_mobile'] == 'off' ? 'off' : 'on';
$enable_gallery_desc_color_mobile = $gal_options['enable_ays_gallery_desc_color_mobile'] == 'on' ?  true : false;

//Gallery description color Mobile
$gallery_desc_color_mobile = isset( $gal_options['ays_gallery_desc_color_mobile'] ) && $gal_options['ays_gallery_desc_color_mobile'] != '' ? esc_attr( $gal_options['ays_gallery_desc_color_mobile'] ) : $gallery_desc_color;

//filter by cat anim
$ays_gpg_filter_cat_anim = isset($gal_options['ays_gpg_filter_cat_anim']) ? sanitize_text_field($gal_options['ays_gpg_filter_cat_anim']) : 'fadeIn';

$gpg_create_date = (isset($gal_options['create_date']) && $gal_options['create_date'] != '') ? $gal_options['create_date'] : "0000-00-00 00:00:00";

if(isset($gal_options['author']) && $gal_options['author'] != 'null'){
    if ( ! is_array( $gal_options['author'] ) ) {
        $gal_options['author'] = json_decode($gal_options['author'], true);
        $gpg_author = $gal_options['author'];
    } else {
        $gpg_author = array_map( 'stripslashes', $gal_options['author'] );
    }
} else {
    $gpg_author = array('name' => 'Unknown');
}

// Custom CSS
$ays_gpg_custom_css = (isset($gallery['custom_css']) && $gallery['custom_css'] != '') ? stripslashes( esc_attr( $gallery['custom_css'] ) ) : '';

// General Settings | options
$gen_options = ($this->settings_obj->ays_get_setting('options') === false) ? array() : json_decode( stripcslashes($this->settings_obj->ays_get_setting('options') ), true);

// WP Editor height
$gpg_wp_editor_height = (isset($gen_options['gpg_wp_editor_height']) && $gen_options['gpg_wp_editor_height'] != '') ? absint( sanitize_text_field($gen_options['gpg_wp_editor_height']) ) : 100 ;

// Change the author of the current gallery
$change_gpg_create_author = (isset($gal_options['gpg_create_author']) && $gal_options['gpg_create_author'] != '') ? absint( sanitize_text_field( $gal_options['gpg_create_author'] ) ) : $user_id;

// Images distance
$images_distance = (isset($gal_options['images_distance']) && $gal_options['images_distance'] != '') ? absint( intval( $gal_options['images_distance'] ) ) : '5';

if( $change_gpg_create_author  && $change_gpg_create_author > 0 ){
    global $wpdb;
    $users_table = esc_sql( $wpdb->prefix . 'users' );

    $sql_users = "SELECT ID,display_name FROM {$users_table} WHERE ID = {$change_gpg_create_author}";

    $ays_gpg_create_author_data = $wpdb->get_row($sql_users, "ARRAY_A");

    if( is_null( $ays_gpg_create_author_data ) || empty($ays_gpg_create_author_data) ){
        $change_gpg_create_author = $user_id;
        $ays_gpg_create_author_data = array(
            "ID" => $user_id,
            "display_name" => $user->data->display_name,
        );
    }

} else {
    $change_gpg_create_author = $user_id;
    $ays_gpg_create_author_data = array(
        "ID" => $user_id,
        "display_name" => $user->data->display_name,
    );
}

$loader_iamge = "<span class='display_none ays_gpg_loader_box'><img src='". AYS_GPG_ADMIN_URL ."/images/loaders/loading.gif'></span>";

$gpg_accordion_svg_html = '
<div class="ays-gpg-accordion-arrow-box">
    <svg class="ays-gpg-accordion-arrow ays-gpg-accordion-arrow-down" version="1.2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" overflow="visible" preserveAspectRatio="none" viewBox="0 0 24 24" width="32" height="32">
        <g>
            <path xmlns:default="http://www.w3.org/2000/svg" d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z" fill="#008cff" vector-effect="non-scaling-stroke" />
        </g>
    </svg>
</div>';
?>

<div class="wrap">
    <div class="ays-gpg-heading-box">
        <div class="ays-gpg-wordpress-user-manual-box">
            <a href="https://ays-pro.com/wordpress-photo-gallery-user-manual" target="_blank" style="text-decoration: none;font-size: 13px;">
                <i class="ays_fa ays_fa_file_text"></i>
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo esc_html__("View Documentation", 'gallery-photo-gallery'); ?></span>
            </a>
        </div>
    </div>
    <div class="container-fluid">
    <form id="ays-gpg-form" method="post">
    <input type="hidden" id="ays_submit_name">
    <input type="hidden" name="ays_gpg_settings_tab" value="<?php echo esc_attr($ays_gpg_tab); ?>">
    <input type="hidden" name="ays_gpg_create_date" value="<?php echo $gpg_create_date; ?>">    
    <input type="hidden" name="ays_gpg_author" value="<?php echo esc_attr(json_encode($gpg_author, JSON_UNESCAPED_SLASHES)); ?>">
    <h1 class="wp-heading-inline">
        <?php echo $heading; ?>        
    </h1>
    <div class="ays_save_buttons_content">
        <input type="submit" name="ays-submit-top" class="ays-submit button action-button button-primary ays-gpg-save-comp" value="<?php echo __("Save and close", 'gallery-photo-gallery');?>" gpg_submit_name="ays-submit" />        
        <input type="submit" name="ays-apply-top" class="ays-submit action-button button ays-gpg-save-comp" id="ays-button-top-apply" title="Ctrl + s" data-toggle="tooltip" data-delay='{"show":"1000"}' value="<?php echo __("Save", 'gallery-photo-gallery');?>" gpg_submit_name="ays-apply"/>
        <?php echo $loader_iamge; ?>
    </div>
    <div>        
        <div class="ays-gallery-subtitle-main-box">
            <p class="ays-subtitle">                
                <?php if(isset($id) && count($get_all_galleries) > 1):?>
                    <span class="ays-subtitle-inner-galleries-page ays-gallery-open-gpgs-list">
                        <strong class="ays_gallery_title_in_top"><?php echo esc_attr( stripslashes( $gallery["title"] ) ); ?></strong>
                        <img src="<?php echo esc_url( AYS_GPG_ADMIN_URL ).'/images/icons/list-icon.svg'; ?>">
                    </span>
                <?php endif; ?>
            </p>
            <?php if(isset($id) && count($get_all_galleries) > 1):?>
                <div class="ays-gallery-gpgs-data">
                    <?php $var_counter = 0; foreach($get_all_galleries as $var => $var_name): if( intval($var_name['id']) == $id ){continue;} $var_counter++; ?>
                        <?php ?>
                        <label class="ays-gallery-message-vars-each-data-label">
                            <input type="radio" class="ays-gallery-gpgs-each-data-checker" hidden id="ays_gallery_message_var_count_<?php echo $var_counter; ?>" name="ays_gallery_message_var_count">
                            <div class="ays-gallery-gpgs-each-data">
                                <input type="hidden" class="ays-gallery-gpgs-each-var" value="<?php echo $var; ?>">
                                <a href="?page=gallery-photo-gallery&action=edit&gallery=<?php echo $var_name['id']?>" target="_blank" class="ays-gallery-go-to-gpgs"><span><?php echo stripslashes(esc_attr($var_name['title'])); ?></span></a>
                            </div>
                        </label>              
                    <?php endforeach ?>
                </div>                        
            <?php endif; ?>
        </div>
        <?php if($id !== null): ?>
        <div class="row">
            <div class="col-sm-3">
                <label> <?php echo esc_html__( "Shortcode text for editor", 'gallery-photo-gallery' ); ?> </label>
            </div>
            <div class="col-sm-9">
                <p style="font-size:14px; font-style:italic;">
                    <?php echo esc_html__("To insert the Gallery into a page, post or text widget, copy shortcode", 'gallery-photo-gallery'); ?>
                    <strong class="ays-gallery-shortcode-box" onClick="selectElementContents(this)" data-toggle="tooltip" title="<?php echo esc_attr__('Click for copy.', 'gallery-photo-gallery');?>" style="font-size:16px; font-style:normal;"><?php echo "[gallery_p_gallery id=".$id."]"; ?></strong>
                    <?php echo " " . esc_html__( "and paste it at the desired place in the editor.", 'gallery-photo-gallery'); ?>
                </p>
            </div>
        </div>
        <?php endif;?>
    </div>
    <hr>
    <?php
        echo "<style>
                .ays_ays_img {
                    display: block;
                    width: 100%;
                    height: 100%;
                    background-image: url('".AYS_GPG_ADMIN_URL .'images/no-photo.png'."');
                    background-size: cover;
                    background-position: center center;
                }
            </style>";
    ?>
    <div class="ays-gpg-top-menu-wrapper">
        <div class="ays_gpg_menu_left" data-scroll="0"><i class="ays_fa ays_fa_angle_left"></i></div>
        <div class="ays-gpg-top-menu">
            <div class="nav-tab-wrapper ays-gpg-top-tab-wrapper">
                <a href="#tab1" data-tab="tab1" class="nav-tab <?php echo ($ays_gpg_tab == 'tab1') ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html__("Images", 'gallery-photo-gallery');?>
                </a>
                <a href="#tab2" data-tab="tab2" class="nav-tab <?php echo ($ays_gpg_tab == 'tab2') ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html__("Settings", 'gallery-photo-gallery');?>
                </a>
                <a href="#tab3" data-tab="tab3" class="nav-tab <?php echo ($ays_gpg_tab == 'tab3') ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html__("Styles", 'gallery-photo-gallery');?>
                </a>
                <a href="#tab4" data-tab="tab4" class="nav-tab <?php echo ($ays_gpg_tab == 'tab4') ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html__("Lightbox settings", 'gallery-photo-gallery');?>
                </a>
                <a href="#tab5" data-tab="tab5" class="nav-tab <?php echo ($ays_gpg_tab == 'tab5') ? 'nav-tab-active' : ''; ?>">
                    <?php echo esc_html__("Lightbox effects", 'gallery-photo-gallery');?>
                </a>
            </div>  
        </div>              
        <div class="ays_gpg_menu_right" data-scroll="-1"><i class="ays_fa ays_fa_angle_right"></i></div>
    </div>
    <div id="tab1" class="ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab1') ? 'ays-gallery-tab-content-active' : ''; ?>">
        <br>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="gallery_title">
                    <?php echo esc_html__("Gallery Title", 'gallery-photo-gallery');?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("In this field is noted the name of the gallery", 'gallery-photo-gallery' ); ?>">
                       <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <input type="text" required name="gallery_title" id="gallery_title" class="ays-text-input" placeholder="<?php echo esc_attr__("Gallery Title", 'gallery-photo-gallery');?>" value="<?php echo stripslashes(htmlentities($gallery["title"])); ?>"/>
            </div>
        </div>
        <hr/>
        <div class="ays-field ays-gpg-desc-message-vars-parent">
            <label for="gallery_description">
                <?php echo esc_html__("Gallery Description", 'gallery-photo-gallery');?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This section is noted for the description of the gallery. You can use Variables (General Settings) to insert user data here.", 'gallery-photo-gallery' ); ?>">
                   <i class="fas fa-info-circle"></i>
                </a>
                <p class="ays_gpg_small_hint_text_for_message_variables">
                    <span><?php echo esc_html__( "To see all Message Variables " , 'gallery-photo-gallery' ); ?></span>
                    <a href="?page=gallery-photo-gallery-settings&ays_gpg_tab=tab3" target="_blank"><?php echo esc_html__( "click here" , 'gallery-photo-gallery' ); ?></a>
                </p>
            </label>
            <?php
                echo $gallery_message_vars_html;
                $content = stripslashes(wpautop($gallery['description']));
                $editor_id = 'gallery_description';
                $settings = array(
                    'editor_height' => $gpg_wp_editor_height, 
                    'textarea_name' => 'gallery_description', 
                    'editor_class' => 'ays-textarea', 
                    'media_buttons' => true
                );
                wp_editor($content, $editor_id, $settings);
            ?>
        </div>
        <hr/>
        <div class="form-group row">
            <div class="col-sm-2">
                <label>
                    <?php echo esc_html__('Status', 'gallery-photo-gallery'); ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__('Published OR Unpublished. Choose whether the gallery is active or not. If you choose Unpublished option, the gallery won’t be shown anywhere in your website (You don’t need to remove shortcodes).','gallery-photo-gallery'); ?>">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <input type="radio" id="ays_gpg_publish" name="ays_gpg_publish"
                           value="1" <?php echo ($gallery_published == '') ? "checked" : ""; ?>  <?php echo ($gallery_published == '1') ? 'checked' : ''; ?>/>
                    <label class="form-check-label"
                           for="ays_gpg_publish"> <?php echo esc_html__('Published', 'gallery-photo-gallery'); ?> </label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="ays_gpg_unpublish" name="ays_gpg_publish"
                           value="0" <?php echo ($gallery_published == '0') ? 'checked' : ''; ?>/>
                    <label class="form-check-label"
                           for="ays_gpg_unpublish"> <?php echo esc_html__('Unpublished', 'gallery-photo-gallery'); ?> </label>
                </div>
            </div>
        </div>
        <hr/>
        <p class="ays-subtitle"><?php echo  esc_html__('Add Images', 'gallery-photo-gallery') ?></p>
        <h6><?php echo  esc_html__('Upload images for your gallery', 'gallery-photo-gallery') ?></h6>        
        <button type="button" class="ays-add-multiple-images button"><?php echo esc_html__("Add multiple images +", 'gallery-photo-gallery'); ?></button>        
        <button type="button" class="ays_bulk_del_images button" disabled><?php echo esc_html__("Delete", 'gallery-photo-gallery'); ?></button>
        <button type="button" class="ays_select_all_images button"><?php echo esc_html__("Select all", 'gallery-photo-gallery'); ?></button>
        <input type="hidden" id="ays_image_lang_title" value="<?php echo esc_attr__("It shows the name of the inserted picture", 'gallery-photo-gallery' ); ?>">
        <input type="hidden" id="ays_image_lang_alt" value="<?php echo esc_attr__("This field shows the alternate text when the picture is not loaded or not found", 'gallery-photo-gallery' ); ?>">
        <input type="hidden" id="ays_image_lang_desc" value="<?php echo esc_attr__("This field shows the description of the chosen image", 'gallery-photo-gallery' ); ?>">
        <input type="hidden" id="ays_image_lang_url" value="<?php echo esc_attr__("This section is for the URL address", 'gallery-photo-gallery' ); ?>">
        <input type="hidden" id="ays_image_cat" value="<?php echo esc_attr__("Select image categories", 'gallery-photo-gallery' ); ?>">
        <hr/>
        <div class="ays_gpg_page_sort">
            <div id="ays_gpg_pagination">
                <select name="ays_admin_pagination" id="ays_admin_pagination">
                    <option <?php echo $admin_pagination == "all" ? "selected" : ""; ?> value="all"><?php echo esc_html__( "All", 'gallery-photo-gallery' ); ?></option>
                    <option <?php echo $admin_pagination == "5" ? "selected" : ""; ?> value="5"><?php echo esc_html__( "5", 'gallery-photo-gallery' ); ?></option>
                    <option <?php echo $admin_pagination == "10" ? "selected" : ""; ?> value="10"><?php echo esc_html__( "10", 'gallery-photo-gallery' ); ?></option>
                    <option <?php echo $admin_pagination == "15" ? "selected" : ""; ?> value="15"><?php echo esc_html__( "15", 'gallery-photo-gallery' ); ?></option>
                    <option <?php echo $admin_pagination == "20" ? "selected" : ""; ?> value="20"><?php echo esc_html__( "20", 'gallery-photo-gallery' ); ?></option>
                    <option <?php echo $admin_pagination == "25" ? "selected" : ""; ?> value="25"><?php echo esc_html__( "25", 'gallery-photo-gallery' ); ?></option>
                    <option <?php echo $admin_pagination == "30" ? "selected" : ""; ?> value="30"><?php echo esc_html__( "30", 'gallery-photo-gallery' ); ?></option>
                </select>            
                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field is for the creation of pagination", 'gallery-photo-gallery' ); ?>">
                   <i class="fas fa-info-circle"></i>
                </a>
                <span class="ays_gpg_image_hover_icon_text"><?php echo esc_html__( "Image pagination", 'gallery-photo-gallery' ); ?></span>
            </div>
            <div id="ays_gpg_sort_cont">    
            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Change the ordering", 'gallery-photo-gallery' ); ?>">
                   <i class="fas fa-info-circle"></i>
                </a>            
                <button class="ays_gpg_sort">
                   <i class="fas fa-exchange-alt"></i>
               </button>
                              
            </div>
        </div>
        <hr/>
        <div class="paged_ays_accordion">
        <?php
            if($id == null) :
        ?>
        <ul class="ays-accordion">
            <li class="ays-accordion_li">
                <input type="hidden" name="ays-image-path[]">
                <div class="ays-image-attributes">
                    <div class='ays-move-images_div'><i class="ays-move-images"></i></div>
                    <div class='ays_image_div'>
                        <div class="ays_image_add_div">
                            <span class="ays_ays_img"></span>
                            <div class="ays_image_add_icon"><i class="ays-upload-btn"></i></div>
                        </div>
                        <div class="ays_image_thumb">
                            <div class="ays_image_edit_div"><i class="ays_image_edit"></i></div>
                            <div class='ays_image_thumb_img'><img></div>
                        </div>
                    </div>
                    <div class="ays_image_attr_item_cat">
                        <div class="ays_image_attr_item_parent">
                            <div class="ays_image_attr_item">
                                <label>
                                    <?php echo esc_html__("Title", 'gallery-photo-gallery');?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("It shows the name of the inserted picture", 'gallery-photo-gallery' ); ?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="ays_img_title" type="text" name="ays-image-title[]" placeholder="<?php echo esc_attr__("Image title", 'gallery-photo-gallery');?>"/>
                            </div>
                            <div class="ays_image_attr_item">
                                <label>
                                    <?php echo esc_html__("Alt", 'gallery-photo-gallery');?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field shows the alternate text when the picture is not loaded or not found", 'gallery-photo-gallery' ); ?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="ays_img_alt" type="text" name="ays-image-alt[]" placeholder="<?php echo esc_attr__("Image alt", 'gallery-photo-gallery');?>"/>
                            </div>
                            <div class="ays_image_attr_item">
                                <label>
                                    <?php echo esc_html__("Description", 'gallery-photo-gallery');?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field shows the description of the chosen image", 'gallery-photo-gallery' ); ?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="<?php echo esc_attr__("Image description", 'gallery-photo-gallery');?>"/>
                            </div>
                            <div class="ays_image_attr_item">
                                <label>
                                    <?php echo esc_html__("URL", 'gallery-photo-gallery');?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This section is for the URL address", 'gallery-photo-gallery' ); ?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="<?php echo esc_attr__("URL", 'gallery-photo-gallery');?>"/>
                            </div>
                        </div>
                        <div class="ays_image_cat">
                            <label>
                                <?php echo esc_html__("Image Category", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Select image categories", 'gallery-photo-gallery' ); ?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                            <select class="ays-category form-control" multiple="multiple">
                                <?php                                
                                foreach ( $gallery_categories as $gallery_category ) {
                                    echo "<option value='".$gallery_category['id']."'>".$gallery_category['title']."</option>";
                                }                                            
                                ?>
                            </select>
                            <input type="hidden" class="for_select_name" name="ays_gallery_category[]">
                        </div>
                    </div>
                    <input type="hidden" name="ays-image-date[]" class="ays_img_date"/>
                    <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>
                    <div class='ays-delete-image_div'><i class="ays-delete-image"></i></div>
                </div>
            </li>
        </ul>
            <?php
                else:
                    $images              = explode( "***", $gallery["images"] );
                    $images_titles       = explode( "***", $gallery["images_titles"] );
                    $images_descriptions = explode( "***", $gallery["images_descs"] );
                    $images_alts         = explode( "***", $gallery["images_alts"] );
                    $images_urls         = explode( "***", $gallery["images_urls"] );
                    $images_dates        = explode( "***", $gallery["images_dates"] );
                    $gal_cat_ids  = isset($gallery['categories_id']) && $gallery['categories_id'] != '' ? explode( "***", $gallery["categories_id"] ) : array();
                    if($admin_pagination != "all"){
                        $pages = intval(ceil(count($images)/$admin_pagination));
                        $qanak = 0;
                        if(isset($_COOKIE['ays_gpg_page_tab_free'])){
                            $ays_page_cookie = explode("_", $_COOKIE['ays_gpg_page_tab_free']);
                            if($ays_page_cookie[1] >= $pages){
                                unset($_COOKIE['ays_gpg_page_tab_free']);
                                setcookie('ays_gpg_page_tab_free', "", time() - 3600, "/");
                                setcookie('ays_gpg_page_tab_free', 'tab_'.($pages-1), time() + 3600);
                                $_COOKIE['ays_gpg_page_tab_free'] = 'tab_'.($pages-1);
                            }
                        }
                        for($i = 0; $i < $pages; $i++){
                            $accordion_active = (isset($_COOKIE['ays_gpg_page_tab_free']) && $_COOKIE['ays_gpg_page_tab_free'] == "tab_".($i)) ? 'ays_accordion_active' : '';
                ?>
                <ul class="ays-accordion ays_accordion <?php echo $accordion_active; ?>" id="page_<?php echo $i; ?>">
                <?php
                    for ($key = $qanak, $j = 0; $key < count($images); $key++, $j++ ) {
                        if($j >= $admin_pagination){
                            $qanak = $key;
                            break;
                        }

                        if(strpos(trim($images[$key], "https:"), $this_site_path) !== false){
                            $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE `post_type` = 'attachment' AND `guid` = '".$images[$key]."'";
                            $result_img =  $wpdb->get_results( $query, "ARRAY_A" );
                            if(!empty($result_img)){
                                $img_thmb_size = wp_get_attachment_image_src($result_img[0]['ID'],  'thumbnail');
                                if($img_thmb_size === false){
                                   $img_thmb_size = $images[$key];
                                }else{
                                   $img_thmb_size = !empty($img_thmb_size) ? $img_thmb_size[0] : $image_no_photo;
                                }
                            }else{
                                $img_thmb_size = $images[$key];
                            }
                        }else{
                            $img_thmb_size = $images[$key];
                        }
                        $img_thmb_html = !empty($img_thmb_size) ? '<img class="ays_ays_img" style="background-image:none;" src="'.$img_thmb_size.'">' : '<img class="ays_ays_img">';
                        ?>
                        <li class="ays-accordion_li">
                            <input type="hidden" name="ays-image-path[]" value="<?php echo $images[$key]; ?>">
                            <div class="ays-image-attributes">
                                <div class='ays-move-images_div'><i class="ays-move-images"></i></div>
                                <div class='ays_image_div'>
                                    <div class="ays_image_thumb" style="display: block; position: relative;">
                                        <div class="ays_image_edit_div" style="position: absolute;"><i class="ays_image_edit"></i></div>
                                        <div class='ays_image_thumb_img'><?php echo $img_thmb_html; ?></div>
                                    </div>
                                </div>
                                <div class="ays_image_attr_item_cat">
                                    <div class="ays_image_attr_item_parent">
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo esc_html__("Title", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("It shows the name of the inserted picture", 'gallery-photo-gallery' ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_title" type="text" name="ays-image-title[]" placeholder="<?php echo esc_attr__("Image title", 'gallery-photo-gallery');?>" value="<?php echo stripslashes(esc_attr($images_titles[$key])); ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo esc_html__("Alt", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field shows the alternate text when the picture is not loaded or not found", 'gallery-photo-gallery' ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_alt" type="text" name="ays-image-alt[]" placeholder="<?php echo esc_attr__("Image alt", 'gallery-photo-gallery');?>" value="<?php echo stripslashes(esc_attr($images_alts[$key])); ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo esc_html__("Description", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field shows the description of the chosen image", 'gallery-photo-gallery' ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="<?php echo esc_attr__("Image description", 'gallery-photo-gallery');?>" value="<?php echo stripslashes(esc_attr($images_descriptions[$key])); ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo esc_html__("URL", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This section is for the URL address", 'gallery-photo-gallery' ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="<?php echo esc_attr__("URL", 'gallery-photo-gallery');?>" value="<?php echo esc_attr($images_urls[$key]); ?>"/>
                                        </div>
                                    </div>
                                    <div class="ays_image_cat">
                                        <label>
                                            <?php echo esc_html__("Image Category", 'gallery-photo-gallery');?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Select image categories", 'gallery-photo-gallery' ); ?>">
                                               <i class="fas fa-info-circle"></i>
                                            </a>
                                        </label>
                                        <select class="ays-category form-control" multiple="multiple">
                                            <?php
                                            $gal_cats_ids = isset($gal_cat_ids[$key]) && $gal_cat_ids[$key] != '' ? explode( ",", $gal_cat_ids[$key] ) : array();
                                            foreach ( $gallery_categories as $gallery_category ) {
                                                $checked = (in_array($gallery_category['id'], $gal_cats_ids)) ? "selected" : "";
                                                echo "<option value='".$gallery_category['id']."' ".$checked.">".$gallery_category['title']."</option>";
                                            }                                            
                                            ?>
                                        </select>
                                        <input type="hidden" class="for_select_name" name="ays_gallery_category[]">
                                    </div>
                                </div>
                                <input type="hidden" name="ays-image-date[]" class="ays_img_date" value="<?php echo $images_dates[$key]; ?>" />
                                <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>
                                <div class='ays-delete-image_div'><i class="ays-delete-image"></i></div>
                            </div>
                        </li>
                        <?php
                        }
                    ?>
                </ul>
                    <?php 
                        }
                    }else{
                ?>
                <ul class="ays-accordion">
                <?php                    
                    foreach ( $images as $key => $image ) {
                        if(strpos(trim($images[$key], "https:"), $this_site_path) !== false){
                            $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE `post_type` = 'attachment' AND `guid` = '".$images[$key]."'";
                            $result_img =  $wpdb->get_results( $query, "ARRAY_A" );
                            if(!empty($result_img)){
                                $img_thmb_size = wp_get_attachment_image_src($result_img[0]['ID'],  'thumbnail');
                                if($img_thmb_size === false){
                                   $img_thmb_size = $images[$key];
                                }else{
                                   $img_thmb_size = !empty($img_thmb_size) ? $img_thmb_size[0] : $image_no_photo;
                                }
                            }else{
                                $img_thmb_size = $images[$key];
                            }
                        }else{
                            $img_thmb_size = $images[$key];
                        }

                        $img_thmb_html = !empty($img_thmb_size) ? '<img class="ays_ays_img" style="background-image:none;" src="'.$img_thmb_size.'">' : '<img class="ays_ays_img">';
                        ?>
                        <li class="ays-accordion_li">
                            <input type="hidden" name="ays-image-path[]" value="<?php echo $image; ?>">
                            <div class="ays-image-attributes">
                                <div class='ays-move-images_div'><i class="ays-move-images"></i></div>
                                <div class='ays_image_div'>                                
                                    <div class="ays_image_thumb" style="display: block; position: relative;">
                                        <div class="ays_image_edit_div" style="position: absolute;"><i class="ays_image_edit"></i></div>
                                        <div class='ays_image_thumb_img'>
                                            <?php echo $img_thmb_html; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="ays_image_attr_item_cat">
                                    <div class="ays_image_attr_item_parent">
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo esc_html__("Title", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("It shows the name of the inserted picture", 'gallery-photo-gallery' ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_title" type="text" name="ays-image-title[]" placeholder="<?php echo esc_attr__("Image title", 'gallery-photo-gallery');?>" value="<?php echo stripslashes(esc_attr($images_titles[$key])); ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo esc_html__("Alt", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field shows the alternate text when the picture is not loaded or not found", 'gallery-photo-gallery' ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_alt" type="text" name="ays-image-alt[]" placeholder="<?php echo esc_attr__("Image alt", 'gallery-photo-gallery');?>" value="<?php echo stripslashes(esc_attr($images_alts[$key])); ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo esc_html__("Description", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field shows the description of the chosen image", 'gallery-photo-gallery' ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>                                    
                                            </label>
                                            <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="<?php echo esc_attr__("Image description", 'gallery-photo-gallery');?>" value="<?php echo stripslashes(esc_attr($images_descriptions[$key])); ?>"/>
                                        </div>
                                        <div class="ays_image_attr_item">
                                            <label>
                                                <?php echo esc_html__("URL", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This section is for the URL address", 'gallery-photo-gallery' ); ?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="<?php echo esc_attr__("URL", 'gallery-photo-gallery');?>" value="<?php echo esc_attr($images_urls[$key]); ?>"/>
                                        </div>
                                    </div>
                                    <div class="ays_image_cat">
                                        <label>
                                            <?php echo esc_html__("Image Category", 'gallery-photo-gallery');?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Select image categories", 'gallery-photo-gallery' ); ?>">
                                               <i class="fas fa-info-circle"></i>
                                            </a>
                                        </label>
                                        <select class="ays-category form-control" multiple="multiple">
                                            <?php
                                            $gal_cats_ids = isset($gal_cat_ids[$key]) && $gal_cat_ids[$key] != '' ? explode( ",", $gal_cat_ids[$key] ) : array();
                                            foreach ( $gallery_categories as $gallery_category ) {
                                                $checked = (in_array($gallery_category['id'], $gal_cats_ids)) ? "selected" : "";
                                                echo "<option value='".$gallery_category['id']."' ".$checked.">".$gallery_category['title']."</option>";
                                            }                                            
                                            ?>
                                        </select>
                                        <input type="hidden" class="for_select_name" name="ays_gallery_category[]">
                                    </div>
                                </div>
                                <input type="hidden" name="ays-image-date[]" class="ays_img_date" value="<?php echo $images_dates[$key]; ?>" /> 
                                <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>
                                <div class='ays-delete-image_div'><i class="ays-delete-image"></i></div>
                            </div>
                        </li>
                        <?php
                        }
                    }
                endif;
            ?>
            </ul>
            </div>
            <div class="ays_admin_pages">
                <ul>
                    <?php
                        if($admin_pagination != "all"){
                            if($pages > 0){
                                for($page = 0; $page < $pages; $page++ ){
                                    if(isset($_COOKIE['ays_gpg_page_tab_free']) && $_COOKIE['ays_gpg_page_tab_free'] == "tab_".($page)){
                                        $page_active = 'ays_page_active';
                                    }else{                                        
                                        $page_active = '';
                                    }
                                    echo "<li><a class='ays_page $page_active' data-tab='tab_".($page)."' href='#page_".($page)."'>".($page+1)."</a></li>";
                                }
                            }
                        }
                    ?>
                </ul>
            </div>            
		</div>
		<div id="tab2" class="ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab2') ? 'ays-gallery-tab-content-active' : ''; ?>">            
            <div class="ays-gpg-accordion-options-main-container" data-collapsed="false">
                <div class="ays-gpg-accordion-container">
                    <?php echo $gpg_accordion_svg_html; ?>
                    <p class="ays-subtitle ays-gpg-subtitle" style="margin-top:0;"><?php echo esc_html__( 'General options', 'gallery-photo-gallery' ); ?></p>
                </div>
                <hr class="ays-gpg-bolder-hr"/>
                <div class="ays-gpg-accordion-options-box">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_gallery_cat">
                                <?php echo esc_html__('Gallery categories', 'gallery-photo-gallery'); ?>
                                <a class="ays_help" data-toggle="tooltip" data-html="true" title="<?php
                                    echo sprintf(
                                        /* translators: %1$s: HTML tag start, %2$s: HTML tag end */
                                        __('Choose the category/categories your gallery belongs to. To create a category, go to the %1$sCategories%2$s page.','gallery-photo-gallery'),
                                        '<strong>',
                                        '</strong>'
                                    );
                                    ?>">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <select id="ays_gallery_cat" name="ays_gallery_cat[]" multiple>
                                <option></option>
                                <?php
                                foreach ($categories as $key => $category) {
                                    $selected = in_array( $category['id'], $category_ids ) ? "selected" : "";
                                    echo '<option value="' . esc_attr($category["id"]) . '" ' . esc_attr($selected) . '>' . stripslashes( esc_attr($category['title']) ) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div> <!-- Gallery Category -->
                    <hr/>
                    <div class="form-group row ays_toggle_parent">
                        <div class="col-sm-3">
                            <label for="ays_filter_cat">
                                <?php echo esc_html__("Enable filter by image categories", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("You can decide whether to show the filter by category of the gallery or not. This option is compatible only with the Grid layout.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-1 ays_divider_left">
                            <input type="checkbox" id="ays_filter_cat" class="ays_toggle_checkbox" name="ays_filter_cat" <?php echo (isset($gal_options['ays_filter_cat']) && $gal_options['ays_filter_cat'] == "on") ? "checked" : ""; ?> />
                        </div>
                        <div class="col-sm-8 ays_toggle_target ays_divider_left <?php echo isset($gal_options['ays_filter_cat']) && $gal_options['ays_filter_cat'] == "on" ? '' : 'display_none'; ?>">

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="ays_filter_cat_animation">
                                        <?php echo esc_html__("Categories filter animation", 'gallery-photo-gallery');?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Choose the animation of the images displaying while filtering them by categories.", 'gallery-photo-gallery');?>">
                                           <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-8 ays_divider_left">
                                    <select id="ays_filter_cat_animation" class="ays-text-input ays-text-input-short" name="ays_filter_cat_animation">
                                        <optgroup label="Fading Entrances">
                                            <option <?php echo 'fadeIn' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="fadeIn">Fade In</option>
                                            <option <?php echo 'fadeInDown' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="fadeInDown">Fade In Down</option>
                                            <option <?php echo 'fadeInLeft' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="fadeInLeft">Fade In Left</option>
                                            <option <?php echo 'fadeInRight' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="fadeInRight">Fade In Right</option>
                                            <option <?php echo 'fadeInUp' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="fadeInUp">Fade In Up</option>
                                        </optgroup>
                                        <optgroup label="Sliding Entrances">
                                            <option <?php echo ($ays_gpg_filter_cat_anim == "slideInUp") ? "selected" : ""; ?> value="slideInUp"><?php echo esc_html__("Slide Up", 'gallery-photo-gallery');?></option>
                                            <option <?php echo ($ays_gpg_filter_cat_anim == "slideInDown") ? "selected" : ""; ?> value="slideInDown"><?php echo esc_html__("Slide Down", 'gallery-photo-gallery');?></option>
                                            <option <?php echo ($ays_gpg_filter_cat_anim == "slideInLeft") ? "selected" : ""; ?> value="slideInLeft"><?php echo esc_html__("Slide Left", 'gallery-photo-gallery');?></option>
                                            <option <?php echo ($ays_gpg_filter_cat_anim == "slideInRight") ? "selected" : ""; ?> value="slideInRight"><?php echo esc_html__("Slide Right", 'gallery-photo-gallery');?></option>
                                        </optgroup>                                
                                        <optgroup label="Zoom Entrances">
                                            <option <?php echo 'zoomIn' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="zoomIn">Zoom In</option> 
                                            <option <?php echo 'zoomInDown' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="zoomInDown">Zoom In Down</option> 
                                            <option <?php echo 'zoomInLeft' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="zoomInLeft">Zoom In Left</option> 
                                            <option <?php echo 'zoomInRight' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="zoomInRight">Zoom In Right</option> 
                                            <option <?php echo 'zoomInUp' == $ays_gpg_filter_cat_anim ? 'selected' : ''; ?> value="zoomInUp">Zoom In Up</option> 
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>            
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Show gallery head", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("You can decide whether to show the title and description of the gallery or not", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Show gallery title ", 'gallery-photo-gallery');?>
                                <input type="checkbox" class="" name="ays_gpg_title_show" <?php
                                   echo ($show_gal_title == "on") ? "checked" : ""; ?>/>
                                <a class="ays_help poqr_tooltip" data-toggle="tooltip" title="<?php echo esc_attr__("If it is marked it will show the title", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Show gallery description ", 'gallery-photo-gallery');?>
                                <input type="checkbox" class="" name="ays_gpg_desc_show" <?php
                                   echo ($show_gal_desc == "on") ? "checked" : ""; ?>/>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("If it is marked it will show the description", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_image_sizes">
                                <?php echo esc_html__("Thumbnail Size", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The size of the image in the thumbnail", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">            
                            <select name="ays_image_sizes" id="ays_image_sizes">
                                <option value="full_size"><?php echo esc_html__( 'Full size', 'gallery-photo-gallery' ); ?></option>
                                <?php
                                    foreach($image_sizes as $key => $size):
                                ?>
                                    <option <?php echo $gal_options["image_sizes"] == $key ? 'selected' : ''; ?> value="<?php echo $key; ?>">
                                        <?php 
                                            $name = ucfirst($key); 
                                            echo "$name ({$size['width']}x{$size['height']})"; 
                                        ?>
                                    </option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_images_ordering">
                                <?php echo esc_html__("Images order by", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field arranges the images by parameters of title, date, random", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-3 ays_divider_left">				
                            <select name="ays_images_ordering" class="ays-text-input ays-text-input-short" id="ays_images_ordering">
                                <option <?php echo ($gal_options['images_orderby'] == "noordering") ? "selected" : ""; ?> value="noordering"><?php echo esc_html__("No ordering", 'gallery-photo-gallery');?></option>
                                <option <?php echo ($gal_options['images_orderby'] == "title") ? "selected" : ""; ?> value="title"><?php echo esc_html__("Title", 'gallery-photo-gallery');?></option>
                                <option <?php echo ($gal_options['images_orderby'] == "date") ? "selected" : ""; ?> value="date"><?php echo esc_html__("Date", 'gallery-photo-gallery');?></option>
                                <option <?php echo ($gal_options['images_orderby'] == "random") ? "selected" : ""; ?> value="random"><?php echo esc_html__("Random", 'gallery-photo-gallery');?></option>
                            </select>
                        </div>
                        <div class="col-sm-6">                
                            <select name="ays_gpg_ordering_asc_desc" class="ays-text-input ays-text-input-short" id="ays_gpg_ordering_asc_desc" <?php echo ($gal_options['images_orderby'] == "random" || $gal_options['images_orderby'] == "noordering") ? "style='display:none;'" : ""; ?>>
                                <option <?php echo ($ordering_asc_desc == "ascending") ? "selected" : ""; ?> value="ascending"><?php echo esc_html__("Ascending", 'gallery-photo-gallery');?></option>
                                <option <?php echo ($ordering_asc_desc == "descending") ? "selected" : ""; ?> value="descending"><?php echo esc_html__("Descending", 'gallery-photo-gallery');?></option>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Images loading", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The images are loaded according to two principles: already loaded gallery with images and at first opens gallery after then the images", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div>
                                <label class="ays_gpg_image_hover_icon" id="gpg_image_global_loading"><?php echo esc_html__("Global loading ", 'gallery-photo-gallery');?>
                                    <input type="radio" id="ays_gpg_images_global_loading" name="ays_images_loading" value="all_loaded"
                                    <?php echo ($loading_type == "all_loaded") ? "checked" : ""; ?> />
                                </label>
                                <label class="ays_gpg_image_hover_icon" id="gpg_image_lazy_loading"><?php echo esc_html__("Lazy loading ", 'gallery-photo-gallery');?> <input type="radio" id="ays_gpg_images_lazy_loading" name="ays_images_loading" value="current_loaded" <?php echo ($loading_type == "current_loaded") ? "checked" : ""; ?>/></label>
                            </div>
                        </div>
                    </div>
                    <hr class="ays_hide_hr" />
                    <div class="form-group row show_load_effect">
                        <div class="col-sm-3">
                            <label for="gallery_img_loading_effect">
                                <?php echo esc_html__("Images loading effect", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Choose Images loading animation", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <select id="gallery_img_loading_effect" class="ays-text-input ays-text-input-short" name="ays_img_load_effect">
                                <optgroup label="Fading Entrances">
                                    <option <?php echo 'fadeIn' == $img_load_effect ? 'selected' : ''; ?> value="fadeIn">Fade In</option>
                                    <option <?php echo 'fadeInDown' == $img_load_effect ? 'selected' : ''; ?> value="fadeInDown">Fade In Down</option>
                                    <option <?php echo 'fadeInLeft' == $img_load_effect ? 'selected' : ''; ?> value="fadeInLeft">Fade In Left</option>
                                    <option <?php echo 'fadeInRight' == $img_load_effect ? 'selected' : ''; ?> value="fadeInRight">Fade In Right</option>
                                    <option <?php echo 'fadeInUp' == $img_load_effect ? 'selected' : ''; ?> value="fadeInUp">Fade In Up</option>
                                </optgroup>
                                <optgroup label="Sliding Entrances">
                                    <option <?php echo ($img_load_effect == "slideInUp") ? "selected" : ""; ?> value="slideInUp"><?php echo esc_html__("Slide Up", 'gallery-photo-gallery');?></option>
                                    <option <?php echo ($img_load_effect == "slideInDown") ? "selected" : ""; ?> value="slideInDown"><?php echo esc_html__("Slide Down", 'gallery-photo-gallery');?></option>
                                    <option <?php echo ($img_load_effect == "slideInLeft") ? "selected" : ""; ?> value="slideInLeft"><?php echo esc_html__("Slide Left", 'gallery-photo-gallery');?></option>
                                    <option <?php echo ($img_load_effect == "slideInRight") ? "selected" : ""; ?> value="slideInRight"><?php echo esc_html__("Slide Right", 'gallery-photo-gallery');?></option>
                                </optgroup>                                
                                <optgroup label="Zoom Entrances">
                                    <option <?php echo 'zoomIn' == $img_load_effect ? 'selected' : ''; ?> value="zoomIn">Zoom In</option> 
                                    <option <?php echo 'zoomInDown' == $img_load_effect ? 'selected' : ''; ?> value="zoomInDown">Zoom In Down</option> 
                                    <option <?php echo 'zoomInLeft' == $img_load_effect ? 'selected' : ''; ?> value="zoomInLeft">Zoom In Left</option> 
                                    <option <?php echo 'zoomInRight' == $img_load_effect ? 'selected' : ''; ?> value="zoomInRight">Zoom In Right</option> 
                                    <option <?php echo 'zoomInUp' == $img_load_effect ? 'selected' : ''; ?> value="zoomInUp">Zoom In Up</option> 
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Redirect URL", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" data-html="true"
                                    title="<?php
                                        echo esc_attr__('Specify the opening method of the Image URLs:','gallery-photo-gallery') .
                                        "<ul style='list-style-type: circle;padding-left: 20px;'>".
                                            "<li>". esc_attr (__('Current tab։ Enable this option in order to open the URL in the same tab','gallery-photo-gallery')) ."</li>".
                                            "<li>". esc_attr (__('New tab։ Enable this option in order to redirect the URL to a new tab','gallery-photo-gallery')) ."</li>".                                    
                                        "</ul>";
                                    ?>">
                                    <i class="fas fa-info-circle"></i>
                                </a>                        
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div>
                                <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("New Tab", 'gallery-photo-gallery');?>
                                    <input type="radio" id="gpg_redirect_url_new_tab" name="gpg_redirect_url_tab" value="_blank" <?php echo ($redirect_type == "_blank") ? "checked" : ""; ?>/>
                                </label>
                                <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Current Tab", 'gallery-photo-gallery');?>
                                    <input type="radio" id="gpg_redirect_url_current_tab" name="gpg_redirect_url_tab" value="_self"
                                    <?php echo ($redirect_type == "_self") ? "checked" : ""; ?> />
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr/>           
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="show_title">
                                <?php echo esc_html__("Show title on thumbnail", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The name of the image is written in the below of it", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label class="ays_gpg_image_hover_icon"><?php echo esc_html__( "Show title ", 'gallery-photo-gallery'); ?><input type="checkbox" id="show_title" class="" name="ays_gpg_show_title" <?php echo ($gal_options['show_title'] == "on") ? "checked" : ""; ?>/></label>
                                </div>
                                <div class="col-sm-9 show_with_date ays_divider_left">
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label >
                                                <?php echo esc_html__("Show on", 'gallery-photo-gallery'); ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("If you choose the case of Thumbnail hover the title will appear when the mouse cursor stops on the image, otherwise the title by default will appear at the bottom of the image.", 'gallery-photo-gallery');?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                        </div>
                                        <div class="col-sm-8 ays_divider_left">
                                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__( "Thumbnail hover ", 'gallery-photo-gallery'); ?><input type="radio" class="ays_gpg_show_title_on" name="ays_gpg_show_title_on" <?php echo ($show_thumb_title_on == "image_hover") ? "checked" : ""; ?> value="image_hover"/></label>
                                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__( "Gallery thumbnail ", 'gallery-photo-gallery'); ?><input type="radio" class="ays_gpg_show_title_on" name="ays_gpg_show_title_on" <?php echo ($show_thumb_title_on == "gallery_image") ? "checked" : ""; ?> value="gallery_image"/></label>
                                        </div>                                
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label >
                                                <?php echo esc_html__("Image title position", 'gallery-photo-gallery');?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Show title: in the bottom or on top", 'gallery-photo-gallery');?>">
                                                   <i class="fas fa-info-circle"></i>
                                                </a>
                                            </label>
                                        </div>
                                        <div class="col-sm-8 ays_divider_left">
                                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Bottom", 'gallery-photo-gallery');?> <input type="radio" class="image_title_position_bottom" name="image_title_position" <?php echo ($thumb_title_position == "bottom") ? "checked" : ""; ?> value="bottom"/></label>
                                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Top", 'gallery-photo-gallery');?> <input type="radio" class="image_title_position_top" name="image_title_position" <?php echo ($thumb_title_position == "top") ? "checked" : ""; ?> value="top"/></label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label><?php echo esc_html__( "Show with date ", 'gallery-photo-gallery'); ?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("If you choose the Show with a date of adding the image to the gallery will appear on the date with the title.", 'gallery-photo-gallery');?>">
                                                       <i class="fas fa-info-circle"></i>
                                                    </a>
                                            </label>
                                        </div>    
                                        <div class="col-sm-8 ays_divider_left">
                                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Yes", 'gallery-photo-gallery');?> <input type="radio" class="image_title_position_bottom" name="ays_gpg_show_with_date" <?php echo ($gal_options['show_with_date'] == "on") ? "checked" : ""; ?> value="on"/></label>
                                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("No", 'gallery-photo-gallery');?> <input type="radio" class="image_title_position_bottom" name="ays_gpg_show_with_date" <?php echo ($gal_options['show_with_date'] == "") ? "checked" : ""; ?> value=""/></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="light_box">
                                <?php echo esc_html__("Disable lightbox", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("By checking this option it will disable lightbox on image click", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <input type="checkbox" id="light_box" class="" name="av_light_box" <?php echo (isset($gal_options['enable_light_box']) && $gal_options['enable_light_box'] == "on") ? "checked" : ""; ?> />
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="link_on_whole_img">
                                <?php echo esc_html__("Make a link on the whole image", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Make a URL redirection while clicking on any spot on the image container. Please note that the option works when the Disable lightbox option is activated.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <input type="checkbox" id="link_on_whole_img" class="" name="link_on_whole_img" <?php echo (isset($gal_options['link_on_whole_img']) && $gal_options['link_on_whole_img'] == "on") ? "checked" : ""; ?> />
                        </div>
                    </div>    
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="gpg_search_img">
                                <?php echo esc_html__("Enable search for image", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This option is not compatible with the Mosaic layout.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left ays_gpg_pc_and_mobile_container">
                            <div class="ays_gpg_pc_and_mobile_container ays_gpg_pc_and_mobile_container_cb">
                                <div class="ays_gpg_option_for_desktop">
                                    <span class="ays_gpg_current_device_name" style="<?php echo ($enable_search_img == 'on' || $enable_search_img_mobile == 'on') ? 'display: block' : '' ?>"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></span>
                                    <p class="onoffswitch">                                        
                                        <input type="checkbox" id="gpg_search_img" class="ays-gpg-onoffswitch-checkbox" name="gpg_search_img" value="on" <?php echo ( $enable_search_img == 'on' ) ? 'checked' : ''; ?> />
                                    </p>
                                </div>
                                <div class="ays_gpg_option_for_mobile_device ays_gpg_option_for_mobile_device_cb ays_divider_left <?php echo ($enable_search_img == 'on' || $enable_search_img_mobile == 'on') ? 'show' : '' ?>">
                                    <span class="ays_gpg_current_device_name" style="<?php echo ($enable_search_img == 'on' || $enable_search_img_mobile == 'on') ? 'display: block' : '' ?>"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></span>
                                    <p class="onoffswitch" style="margin:0;">
                                        <input type="checkbox" id="gpg_search_img_mobile" class="ays-gpg-onoffswitch-checkbox" name="gpg_search_img_mobile" value="on" <?php echo ( $enable_search_img_mobile == 'on' ) ? 'checked' : ''; ?> />
                                    </p>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="gallery_width">
                                <?php echo esc_html__("Gallery Width", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This field shows the width of the Gallery", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left ays_gpg_display_flex_width">
                            <div>
                               <input type="number" id="gallery_width" class="ays-text-input ays-text-input-short" name="gallery_width" placeholder="<?php echo esc_attr__("Gallery Width", 'gallery-photo-gallery');?>" value="<?php echo $gallery["width"] == 0 ? '' : $gallery["width"]; ?>"/>
                            <span class="ays_gpg_image_hover_icon_text"><?php echo esc_html__("For 100% leave blank", 'gallery-photo-gallery');?></span>
                            </div>
                            <div class="ays_gpg_dropdown_max_width">
                                <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                            </div>
                        </div>
                    </div>
                   
                    <?php
                        $bacel = $gal_options['view_type'] == 'grid' ? "style='display: flex;'" : "style='display: none;'";
                        $resp_width = $responsive_width == "on" && $gal_options['view_type'] == 'grid' ? true : false;

                        if ($resp_width) {
                            $height_width_ratio = "style='display: flex;'";
                            $thumb_height = "style='display: none;'";
                        }else{
                            $height_width_ratio = "style='display: none;'";
                            $thumb_height = "style='display: flex;'";
                        }

                        switch ($gal_options['view_type']) {
                            case 'mosaic':
                                $pakel1 = "style='display: none;'";
                                $pakel2 = "style='display: none;'";
                                break;
                            case 'masonry':
                                $pakel1 = "style='display: none;'";
                                $pakel2 = "style='display: block;'";
                                break;
                            
                            default:
                                $pakel1 = "style='display: block;'";
                                $pakel2 = "style='display: block;'";
                                break;
                        }
                        
                    ?>
                    <hr class="hr_pakel" <?php echo $pakel1;?> >
                    <div class="form-group row" id="ays_gpg_resp_width" <?php echo $bacel;?>>
                        <div class="col-sm-3">
                            <label for="gpg_resp_width">
                                <?php echo esc_html__("Responsive Width/Height", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Enable the option if you want to assign the values to height and weight by ratio.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <input type="checkbox" id="gpg_resp_width" class="" name="gpg_resp_width" <?php echo ($responsive_width == "on") ? "checked" : ""; ?> />
                        </div>
                    </div>
                    <hr class="hr_pakel" <?php echo $pakel1;?> >
                    <div class="form-group row bacel" id="ays_height_width_ratio" <?php echo $height_width_ratio;?>>
                        <div class="col-sm-3">
                            <label for="gpg_height_width_ratio">
                                <?php echo esc_html__("Height / Width ratio", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("This ratio indicates the quantitative relation between height and width. For example, if you give 1.2 value to ratio while the width is 300, then the height will be 300x1.2=360.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <input type="number" class="ays-text-input ays-text-input-short ays_gpg_height_width_ratio" name="gpg_height_width_ratio" id="gpg_height_width_ratio" step="0.1" value="<?php echo $gpg_height_width_ratio; ?>" placeholder="Example: 1 or 1.2 ...">
                        </div>
                    </div>
                    
                    <div id="ays-thumb-height" class="form-group row pakel3" <?php echo $thumb_height;?>>
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Thumbnails height", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The height of the thumbnails of the Gallery", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="ays_thumb_height_desktop">
                                        <?php echo esc_html__("On desktop", 'gallery-photo-gallery'); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the thumbnails height of the gallery for desktop devices.", 'gallery-photo-gallery');?>">
                                           <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-10 ays_gpg_display_flex_width ays_divider_left">
                                    <div>
                                       <input type="number" id="ays_thumb_height_desktop" name="ays-thumb-height-desktop" class="ays-text-input ays-text-input-short" value="<?php echo $ays_thumb_height_desktop; ?>"/>
                                    </div>
                                    <div class="ays_gpg_dropdown_max_width">
                                        <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="ays_thumb_height_mobile">
                                        <?php echo esc_html__("On mobile", 'gallery-photo-gallery'); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the thumbnails height of the gallery for mobile devices.", 'gallery-photo-gallery');?>">
                                           <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>                        
                                <div class="col-sm-10 ays_gpg_display_flex_width ays_divider_left">
                                    <div>
                                       <input type="number" id="ays_thumb_height_mobile" name="ays-thumb-height-mobile" class="ays-text-input ays-text-input-short" value="<?php echo $ays_thumb_height_mobile; ?>"/>
                                    </div>
                                    <div class="ays_gpg_dropdown_max_width">
                                        <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div id="ays-columns-count" class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_columns_count">
                                <?php echo esc_html__("Columns count", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The counts of the columns of the Gallery", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="ays_columns_count">
                                        <?php echo esc_html__("On desktop", 'gallery-photo-gallery'); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the columns count of the gallery for desktop devices.", 'gallery-photo-gallery');?>">
                                           <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-10 ays_gpg_display_flex_width ays_divider_left">
                                    <input type="number" id="ays_columns_count" name="ays-columns-count" class="ays-text-input ays-text-input-short" placeholder="<?php echo esc_attr__("Default", 'gallery-photo-gallery');?>: 3" value="<?php echo isset($gal_options['columns_count']) ? $gal_options['columns_count'] : 3; ?>"/>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="ays_thumb_height_mobile">
                                        <?php echo esc_html__("On mobile", 'gallery-photo-gallery'); ?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the columns count of the gallery for mobile devices.", 'gallery-photo-gallery');?>">
                                           <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>                        
                                <div class="col-sm-10 ays_gpg_display_flex_width ays_divider_left">
                                    <input type="number" id="ays_columns_count_mobile" name="ays-columns-count-mobile" class="ays-text-input ays-text-input-short" placeholder="<?php echo esc_attr__("Default", 'gallery-photo-gallery');?>: 1" value="<?php echo isset($gal_options['columns_count_mobile']) ? $gal_options['columns_count_mobile'] : 1; ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="display: <?php echo $gal_options['view_type'] == 'mosaic' ? 'none' : 'block'; ?>;">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_galery_enable_rtl_direction">
                                <?php echo esc_html__('Use RTL Direction','gallery-photo-gallery')?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__('Enable Right to Left direction for the text. This option is intended for the Arabic language.','gallery-photo-gallery')?>">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left ays_gpg_pc_and_mobile_container">
                            <div class="ays_gpg_pc_and_mobile_container ays_gpg_pc_and_mobile_container_cb">
                                <div class="ays_gpg_option_for_desktop">
                                    <span class="ays_gpg_current_device_name" style="<?php echo ($enable_rtl_direction == 'on' || $enable_rtl_direction_mobile == 'on') ? 'display: block' : '' ?>"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></span>
                                    <p class="onoffswitch">
                                        <input type="checkbox" id="ays_galery_enable_rtl_direction" class="ays-gpg-onoffswitch-checkbox" name="ays_galery_enable_rtl_direction" value="on" <?php echo ( $enable_rtl_direction == 'on' ) ? 'checked' : ''; ?> />
                                    </p>
                                </div>
                                <div class="ays_gpg_option_for_mobile_device ays_gpg_option_for_mobile_device_cb ays_divider_left <?php echo ($enable_rtl_direction == 'on' || $enable_rtl_direction_mobile == 'on') ? 'show' : '' ?>">
                                    <span class="ays_gpg_current_device_name" style="<?php echo ($enable_rtl_direction == 'on' || $enable_rtl_direction_mobile == 'on') ? 'display: block' : '' ?>"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></span>
                                    <p class="onoffswitch" style="margin:0;">
                                        <input type="checkbox" name="ays_galery_enable_rtl_direction_mobile" class="ays-gpg-onoffswitch-checkbox" id="ays_galery_enable_rtl_direction_mobile" <?php echo ( $enable_rtl_direction_mobile == 'on' ) ? 'checked' : ''; ?> />
                                    </p>
                                </div>
                            </div>
                        </div>                        
                    </div> <!-- Use RTL direction -->
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_gallery_create_author">
                                <?php echo esc_html__('Change the author of the current gallery','gallery-photo-gallery'); ?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__('You can change the author who created the current gallery to your preferred one. You need to write the User ID here. Please note, that in case you write an ID, by which there are no users found, the changes will not be applied and the previous author will remain the same.','gallery-photo-gallery'); ?>">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">                    
                            <select class="ays-text-input ays-text-input-short select2-container-200-width" id='ays_gallery_create_author'name='ays_gallery_create_author'>
                                <option value=""><?php echo esc_html__('Select User','gallery-photo-gallery')?></option>
                                <?php
                                    echo "<option value='" . $ays_gpg_create_author_data['ID'] . "' selected>" . $ays_gpg_create_author_data['display_name'] . "</option>";
                                ?>
                            </select>
                        </div>
                    </div> <!-- Change the author of the current gallery -->
                    <hr/>   
                    <div class="ays_gpg_pagination_types">
                        <div class="col-sm-12 only_pro">
                            <div class="pro_features">
                                <div>                            
                                    <a href="https://ays-pro.com/wordpress/photo-gallery/" target="_blank" class="ays-gpg-new-upgrade-button-link">
                                        <div class="ays-gpg-new-upgrade-button-box">
                                            <div>
                                                <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_locked_24x24.svg'?>">
                                                <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_unlocked_24x24.svg'?>" class="ays-gpg-new-upgrade-button-hover">
                                            </div>
                                            <div class="ays-gpg-new-upgrade-button"><?php echo esc_html__("Upgrade", 'gallery-photo-gallery'); ?></div>
                                        </div>
                                    </a>
                                    <div class="ays-gpg-center-big-main-button-box ays-gpg-new-big-button-flex">
                                        <div class="ays-gpg-center-big-upgrade-button-box">
                                            <a href="https://ays-pro.com/wordpress/photo-gallery/" target="_blank" class="ays-gpg-new-upgrade-button-link">
                                                <div class="ays-gpg-center-new-big-upgrade-button">
                                                    <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_locked_24x24.svg'?>" class="ays-gpg-new-button-img-hide">
                                                    <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_unlocked_24x24.svg'?>" class="ays-gpg-new-upgrade-button-hover">  
                                                    <?php echo esc_html__("Upgrade", 'gallery-photo-gallery'); ?>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>                
                            <div class="form-group row" style="padding-top:15px;">
                                <div class="col-sm-3">
                                    <label for="gallery_pagination">
                                        <?php echo esc_html__("Pagination", 'gallery-photo-gallery');?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("You will be able to choose the way of the pagination. By default it is none, so all the images will loaded in the Front-end.", 'gallery-photo-gallery');?>">
                                        <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-9 ays_divider_left">
                                    <div>
                                        <label class="ays_gpg_image_hover_icon" id="gpg_pagination_none"><?php echo esc_html__("None", 'gallery-photo-gallery');?>
                                            <input type="radio" id="gpg_pagination_none" name="ays_gpg_pagination" value="none"/>
                                        </label>
                                        <label class="ays_gpg_image_hover_icon" id="gpg_pagination_simple"><?php echo esc_html__("Simple", 'gallery-photo-gallery');?> 
                                            <input type="radio" id="gpg_pagination_simple" name="ays_gpg_pagination" value="simple"/>
                                        </label>
                                        <label class="ays_gpg_image_hover_icon" id="gpg_pagination_load_more"><?php echo esc_html__("Load More ", 'gallery-photo-gallery');?> 
                                            <input type="radio" id="gpg_pagination_load_more" name="ays_gpg_pagination" checked value="load_more"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="form-group row show_load_effect_simple">
                                <div class="col-sm-3">
                                    <label for="gallery_img_per_page_simple">
                                        <?php echo esc_html__("Images per page", 'gallery-photo-gallery');?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Set the exact number of images you want to be displayed on each page", 'gallery-photo-gallery');?>">
                                        <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="number" class="ays-text-input ays-text-input-short" name="gallery_img_per_page_simple" id="gallery_img_per_page_simple" min=1 value="">
                                </div>
                            </div>
                            <div class="show_load_effect_load_more" style="padding-bottom: 15px;">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="gallery_img_per_page_load_more">
                                            <?php echo esc_html__("Images per page", 'gallery-photo-gallery');?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Choose the number of images you want to be displayed at the beginning", 'gallery-photo-gallery');?>">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-9 ays_divider_left">
                                        <input type="number" class="ays-text-input ays-text-input-short" name="gallery_img_per_page_load_more" id="gallery_img_per_page_load_more" min=1 value="">
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <label for="gallery_img_per_load">
                                            <?php echo esc_html__("Images per load", 'gallery-photo-gallery');?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Choose how many images will be loaded after clicking on the ''Load More'' button", 'gallery-photo-gallery');?>">
                                            <i class="fas fa-info-circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-9 ays_divider_left">
                                        <input type="number" class="ays-text-input ays-text-input-short" name="gallery_img_per_load" id="gallery_img_per_load" min=1 value="">
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div><!-- Gallery pagination -->		  
                    <hr/>
                </div>
            </div>
        </div>
        <?php
            $view_type_names = array(
                "grid"      => "grid.PNG",
                "mosaic"    => "mosaic.png",
                "masonry"   => "masonry.png",
                "view_1"    => "view_1.png",
                "view_2"    => "view_2.png",
                "view_3"    => "view_3.png",
                "view_4"    => "view_4.png",
                "view_5"    => "view_5.png",
                "view_6"    => "view_6.png",
                "view_7"    => "view_7.png",
                "view_8"    => "view_8.png",
                "view_9"    => "view_9.png",
                "view_10"   => "view_10.png",
                "view_11"   => "view_11.png",
                "view_12"   => "view_12.png",
                "view_13"   => "view_13.png",
                "view_14"   => "view_14.png",
                "view_15"   => "view_15.png",
                "view_16"   => "view_16.png",
                "view_17"   => "view_17.png",
                "view_18"   => "view_18.png",
                "view_19"   => "view_19.png",
                "view_20"   => "view_20.png",
                "view_21"   => "view_21.png",
                "view_22"   => "view_22.png",
                "view_23"   => "view_23.png",
                "view_24"   => "view_24.png",
                "fb_view_1" => "fb_view_1.PNG",
                "fb_view_2" => "fb_view_2.PNG",
                "fb_view_3" => "fb_view_3.PNG"
            );

            $view_type_urls = array(
                "view_1"    => "photo-gallery-view-1",
                "view_2"    => "photo-gallery-view-2",
                "view_3"    => "photo-gallery-view-3",
                "view_4"    => "photo-gallery-view-4",
                "view_5"    => "photo-gallery-view-5",
                "view_6"    => "photo-gallery-view-6",
                "view_7"    => "photo-gallery-view-7",
                "view_8"    => "photo-gallery-view-8",
                "view_9"    => "photo-gallery-view-9",
                "view_10"   => "photo-gallery-view-10",
                "view_11"   => "photo-gallery-view-11",
                "view_12"   => "photo-gallery-view-12",
                "view_13"   => "photo-gallery-view-13",
                "view_14"   => "photo-gallery-view-14",
                "view_15"   => "photo-gallery-view-15",
                "view_16"   => "photo-gallery-view-16",
                "view_17"   => "photo-gallery-view-17",
                "view_18"   => "photo-gallery-view-18",
                "view_19"   => "photo-gallery-view-19",
                "view_20"   => "photo-gallery-view-20",
                "view_21"   => "photo-gallery-view-21",
                "view_22"   => "photo-gallery-view-22",
                "view_23"   => "photo-gallery-view-23",
                "view_24"   => "photo-gallery-view-24",
                "fb_view_1" => "photo-gallery-view-25",
                "fb_view_2" => "photo-gallery-view-26",
                "fb_view_3" => "photo-gallery-view-27"
            );
        ?>
        <div id="tab3" class="ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab3') ? 'ays-gallery-tab-content-active' : ''; ?>">            
            <div class="ays-gpg-accordion-options-main-container" data-collapsed="false">
                <div class="ays-gpg-accordion-container">
                    <?php echo $gpg_accordion_svg_html; ?>
                    <p class="ays-subtitle ays-gpg-subtitle" style="margin-top:0;"><?php echo esc_html__( 'Style options', 'gallery-photo-gallery' ); ?></p>
                </div>
                <hr class="ays-gpg-bolder-hr"/>
                <div class="ays-gpg-accordion-options-box">
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Gallery view type", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo  esc_attr__('This section notes the type of the Gallery that is in what sequence should the pictures be', 'gallery-photo-gallery') ?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div>
                                <?php
                                    foreach($view_type_names as $key => $name):
                                ?>
                                <label class="ays_gpg_view_type_radio">
                                    <input type="radio" class="ays-view-type" name="ays-view-type" 
                                           <?php echo ($ays_gpg_view_type == $key) ? "checked" : ""; ?>
                                           <?php echo ("grid" == $key || "mosaic" == $key || "masonry" == $key) ? "" : "disabled"; ?>
                                           value="<?php echo $key; ?>"/>
                                    <?php if($key == "grid" || $key == "mosaic" || $key == "masonry"): ?>
                                    <span>
                                        <?php echo ucfirst( $key )." "; ?>
                                    </span>
                                    <?php endif; ?>
                                    <?php if($key == "grid" || $key == "mosaic" || $key == "masonry"): ?>
                                    <img src="<?php echo AYS_GPG_ADMIN_URL . "images/" . $name; ?>">
                                    <?php else: ?>
                                    <a href="https://ays-demo.com/<?php echo $view_type_urls[$key]; ?>/" target="_blank" style="display: block;" class="ays_disabled" title="<?php echo esc_html__("This feature available only in PRO version!!!", 'gallery-photo-gallery'); ?>">
                                        <div>Pro</div>
                                        <img src="<?php echo AYS_GPG_ADMIN_URL . "images/" . $name; ?>">
                                        <span class="ays_gpg_view_type_pro_demo">Demo</span>
                                    </a>
                                    <?php endif; ?>
                                </label>
                                <?php
                                    endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Images hover effect", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Effect intended for hover according to animation", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div>
                                <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Simple animation ", 'gallery-photo-gallery');?>
                                    <input type="radio" class="ays_hover_effect_radio ays_hover_effect_radio_simple" name="ays_images_hover_effect" <?php
                                       echo ($ays_images_hover_effect == "simple") ? "checked" : ""; ?> value="simple"/>
                                </label>
                                <label class="ays_gpg_image_hover_icon" style="<?php echo ($gal_options['view_type'] == "masonry") ? "color: rgb(204, 204, 204);" : ""; ?>"><?php echo esc_html__("Direction-aware ", 'gallery-photo-gallery');?> <input type="radio" class="ays_hover_effect_radio ays_hover_effect_radio_dir_aware" name="ays_images_hover_effect" <?php echo ($ays_images_hover_effect == "dir_aware") ? "checked" : ""; ?> <?php echo ($gal_options['view_type'] == "masonry") ? "disabled='disabled'" : ""; ?> value="dir_aware"/></label>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="ays-field ays_effect_simple">
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="gallery_img_hover_simple">
                                    <?php echo esc_html__("Images hover animation", 'gallery-photo-gallery');?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Hover appearing animation of the images of Gallery", 'gallery-photo-gallery');?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-3 ays_divider_left">
                                <select id="gallery_img_hover_simple" class="ays-text-input ays-text-input-short" name="ays_hover_simple">
                                    <optgroup label="Fading Entrances">
                                        <option <?php echo 'fadeIn'      == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeIn">Fade In</option>
                                        <option <?php echo 'fadeInDown'  == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeInDown">Fade In Down</option>
                                        <option <?php echo 'fadeInLeft'  == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeInLeft">Fade In Left</option>
                                        <option <?php echo 'fadeInRight' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeInRight">Fade In Right</option>
                                        <option <?php echo 'fadeInUp'    == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="fadeInUp">Fade In Up</option>
                                    </optgroup>
                                    <optgroup label="Sliding Entrances">
                                        <option <?php echo ($gal_options['hover_effect'] == "slideInUp") ? "selected" : ""; ?> value="slideInUp"><?php echo esc_html__("Slide Up", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ($gal_options['hover_effect'] == "slideInDown") ? "selected" : ""; ?> value="slideInDown"><?php echo esc_html__("Slide Down", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ($gal_options['hover_effect'] == "slideInLeft") ? "selected" : ""; ?> value="slideInLeft"><?php echo esc_html__("Slide Left", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ($gal_options['hover_effect'] == "slideInRight") ? "selected" : ""; ?> value="slideInRight"><?php echo esc_html__("Slide Right", 'gallery-photo-gallery');?></option>
                                    </optgroup>                                
                                    <optgroup label="Zoom Entrances">
                                        <option <?php echo 'zoomIn' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomIn">Zoom In</option> 
                                        <option <?php echo 'zoomInDown' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomInDown">Zoom In Down</option> 
                                        <option <?php echo 'zoomInLeft' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomInLeft">Zoom In Left</option> 
                                        <option <?php echo 'zoomInRight' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomInRight">Zoom In Right</option> 
                                        <option <?php echo 'zoomInUp' == $gal_options['hover_effect'] ? 'selected' : ''; ?> value="zoomInUp">Zoom In Up</option> 
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-sm-2 ays_divider_left">
                                <div class="gpg_animation_demo">
                                    <div class="gpg_animation_demo_text ">
                                        <?php echo esc_html__("Hover animation preview", 'gallery-photo-gallery');?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 ays_animation_preview_block"> 
                                <a class="ays_animation_preview">                            
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <div class="ays-field ays_effect_dir_aware">
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="gallery_img_hover_dir_aware">
                                    <?php echo esc_html__("Images hover animation", 'gallery-photo-gallery');?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Hover appearing animation of the images of Gallery", 'gallery-photo-gallery');?>">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                </label>
                            </div>
                            <div class="col-sm-3 ays_divider_left">
                                <select id="gallery_img_hover_dir_aware" class="ays-text-input ays-text-input-short" name="ays_hover_dir_aware">
                                    <option <?php echo 'slide' == $ays_images_hover_dir_aware ? 'selected' : ''; ?> value="slide"><?php echo esc_html__("Slide", 'gallery-photo-gallery');?></option>
                                    <option <?php echo 'rotate3d' == $ays_images_hover_dir_aware ? 'selected' : ''; ?> value="rotate3d"><?php echo esc_html__("Rotate 3D", 'gallery-photo-gallery');?></option>
                                </select>
                            </div>
                            <div class="col-sm-6" style="position: initial;">                    
                                <div class="gpg_animation_demo_dAware demo_<?php echo $ays_images_hover_dir_aware; ?>">
                                    <div class="text_before_effect gpg_animation_demo_text" style="background: revert; color:#3c434a;">
                                        <?php echo esc_html__("Hover this preview block", 'gallery-photo-gallery');?>
                                    </div>
                                    <div class="gpg_animation_demo_text ays_hover_mask">
                                        <?php echo esc_html__("Hover animation preview", 'gallery-photo-gallery');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_gpg_hover_animation_speed">
                                <span>
                                    <?php echo  esc_html__('Images hover animation speed', 'gallery-photo-gallery') ?>
                                    <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the animation speed of the image.", 'gallery-photo-gallery'); ?>">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </span>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="ays_toggle_mobile_parent">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ( $enable_hover_animation_speed_mobile ) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 200px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                    <div class="ays_gpg_display_flex_width">
                                        <input id="ays_gpg_hover_animation_speed" type="number" class="ays-text-input ays-text-input-short" name="ays_gpg_hover_animation_speed" value="<?php echo $hover_animation_speed; ?>" step="0.1">
                                    </div>
                                </div>
                                <div class="ays_toggle_target ays_gpg_title_color_mobile_container" style=" <?php echo ( $enable_hover_animation_speed_mobile ) ? '' : 'display:none'; ?>">
                                    <hr>
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 200px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                    <div class="ays_gpg_display_flex_width">
                                        <input id="ays_gpg_hover_animation_speed_mobile" type="number" class="ays-text-input ays-text-input-short" name="ays_gpg_hover_animation_speed_mobile" value="<?php echo $hover_animation_speed_mobile; ?>" step="0.1">
                                    </div>
                                </div>
                                <div class="ays_gpg_mobile_settings_container">
                                    <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable_ays_gpg_hover_animation_speed_mobile" name="enable_ays_gpg_hover_animation_speed_mobile" <?php echo $enable_hover_animation_speed_mobile ? 'checked' : '' ?> >
                                    <label for="enable_ays_gpg_hover_animation_speed_mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="gallery_img_position">
                                <?php echo esc_html__("Image position", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The position image of the gallery", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="gpg_position_block col-sm-9 ays_divider_left ays_toggle_parent">
                            <div class="ays_gpg_img_position_tables_container" style="display: flex;">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ( $enable_gallery_img_position_mobile ) ? '' : 'display: none;'; ?> text-align: center; margin-bottom: 10px; max-width: 120px;"><?php echo esc_html__( 'Desktop', 'gallery-photo-gallery' ); ?></div>
                                    <table id="ays-gpg-position-table" data-flag="gpg_image_position">
                                        <tr>
                                            <td data-value="left-top" data-id='1' title="Left Top"></td>
                                            <td data-value="top-center"data-id='2' title="Top Center"></td>
                                            <td data-value="right-top" data-id='3' title="Right Top"></td>
                                        </tr>
                                        <tr>
                                            <td data-value="left-center" data-id='4' title="Left Center"></td>
                                            <td id="gpg_position_center" data-value="center-center" data-id='5' title="Center Center"></td>
                                            <td data-value="right-center" data-id='6' title="Right Center"></td>
                                        </tr>
                                        <tr>
                                            <td data-value="left-bottom" data-id='7' title="Left Bottom"></td>
                                            <td data-value="center-bottom" data-id='8' title="Center Bottom"></td>
                                            <td data-value="right-bottom" data-id='9' title="Right Bottom"></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="gallery_img_position" id="ays-gpg-position-val" value="<?php echo $gallery_img_position; ?>" class="ays-gpg-position-val-class">
                                </div>
                                <div class="ays_toggle_target ays_divider_left ays_gpg_img_position_mobile_container" style=" <?php echo ( $enable_gallery_img_position_mobile ) ? '' : 'display:none'; ?>">
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 120px;"><?php echo esc_html__( 'Mobile', 'gallery-photo-gallery' ); ?></div>
                                    <table id="ays-gpg-position-table-mobile" data-flag="gpg_image_position_mobile">
                                        <tr>
                                            <td data-value="left-top" data-id='1'></td>
                                            <td data-value="top-center"data-id='2'></td>
                                            <td data-value="right-top" data-id='3'></td>
                                        </tr>
                                        <tr>
                                            <td data-value="left-center" data-id='4'></td>
                                            <td id="pb_position_center" data-value="center-center" data-id='5'></td>
                                            <td data-value="right-center" data-id='6'></td>
                                        </tr>
                                        <tr>
                                            <td data-value="left-bottom" data-id='7'></td>
                                            <td data-value="center-bottom" data-id='8'></td>
                                            <td data-value="right-bottom" data-id='9'></td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="gallery_img_position_mobile" id="ays-gpg-position-mobile-val" value="<?php echo $gallery_img_position_mobile; ?>" class="ays-gpg-position-mobile-val-class">
                                </div>
                            </div>
                            <div class="ays_gpg_mobile_settings_container">
                                <input type="checkbox" class="ays_toggle_checkbox ays-gpg-onoffswitch-checkbox" id="enable_gallery_img_position_mobile" name="enable_gallery_img_position_mobile" <?php echo $enable_gallery_img_position_mobile ? 'checked' : ''; ?>>
                                <label for="enable_gallery_img_position_mobile" class="<?php echo $enable_gallery_img_position_mobile ? 'active' : '' ?>" ><?php echo esc_html__( 'Use a different setting for Mobile', 'gallery-photo-gallery' ) ?></label>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Images hover opacity", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The transparency degree of the image hover", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-3 ays_divider_left gpg_range_div">
                            <div>
                                <input class="gpg_opacity_demo_val form-control-range" id="formControlRange" name="ays-gpg-image-hover-opacity" type="range" min="0" max="1" step="0.01" value="<?php echo isset($gal_options['hover_opacity']) ? $gal_options['hover_opacity'] : '0.5'; ?>">
                            </div>                    
                        </div>
                        <div class="col-sm-6 ays_divider_left">                    
                            <div class="gpg_opacity_demo"><?php echo esc_html__("Hover opacity preview", 'gallery-photo-gallery');?></div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Images hover color", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The color of the image hover", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <input name="ays-gpg-hover-color" class="ays_gpg_hover_color" data-alpha="true" type="text" value="<?php echo isset($gal_options['hover_color']) ? esc_attr(stripslashes($gal_options['hover_color'])) : '#000000'; ?>" data-default-color="#000000">
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Images hover zoom effect", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("During image hover, the zoom effect of the image", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div>
                                <label class="ays_gpg_image_hover_icon ays_gpg_hover_zoom"><?php echo esc_html__("Yes ", 'gallery-photo-gallery'); ?><input name="ays_gpg_hover_zoom" type="radio" value="yes" <?php echo ($ays_hover_zoom == "yes") ? "checked" : ''; ?>></label>
                                <label class="ays_gpg_image_hover_icon ays_gpg_hover_zoom"><?php echo esc_html__("No ", 'gallery-photo-gallery'); ?><input name="ays_gpg_hover_zoom" type="radio" value="no" <?php echo ($ays_hover_zoom == "no") ? "checked" : ''; ?>></label>
                            </div>                
                            <hr class="hover_zoom_animation_speed <?php echo $ays_hover_zoom == "yes" ? "" : "display_none"?>">
                            <div class="form-group row hover_zoom_animation_speed <?php echo $ays_hover_zoom == "yes" ? "" : "display_none"?>">
                                <div class="col-sm-2">
                                    <label for="ays_gpg_hover_zoom_animation_speed">
                                        <span>
                                            <?php echo  esc_html__('Animation speed', 'gallery-photo-gallery') ?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the animation speed of the zoom effect of the image.", 'gallery-photo-gallery'); ?>">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-10 ays_divider_left">
                                    <input id="ays_gpg_hover_zoom_animation_speed" type="number" class="ays-text-input ays-text-input-short" name="gpg_hover_zoom_animation_speed" value="<?php echo $hover_zoom_animation_speed; ?>" step="0.1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Images hover scale box shadow effect", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("During image hover, the scale box shadow effect of the image", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div>
                                <label class="ays_gpg_image_hover_icon ays_gpg_hover_scale"><?php echo esc_html__("Yes ", 'gallery-photo-gallery'); ?><input name="ays_gpg_hover_scale" type="radio" value="yes" <?php echo ($ays_hover_scale == "yes") ? "checked" : ''; ?>></label>
                                <label class="ays_gpg_image_hover_icon ays_gpg_hover_scale"><?php echo esc_html__("No ", 'gallery-photo-gallery'); ?><input name="ays_gpg_hover_scale" type="radio" value="no" <?php echo ($ays_hover_scale == "no") ? "checked" : ''; ?>></label>
                            </div>
                            <hr class="hover_scale_animation_speed <?php echo $ays_hover_scale == "yes" ? "" : "display_none"?>">
                            <div class="form-group row hover_scale_animation_speed <?php echo $ays_hover_scale == "yes" ? "" : "display_none"?>">
                                <div class="col-sm-2">
                                    <label for="ays_gpg_hover_scale_animation_speed">
                                        <span>
                                            <?php echo  esc_html__('Animation speed', 'gallery-photo-gallery') ?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the animation speed of the scale effect of the image.", 'gallery-photo-gallery'); ?>">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-10 ays_divider_left">
                                    <input id="ays_gpg_hover_scale_animation_speed" type="number" class="ays-text-input ays-text-input-short" name="gpg_hover_scale_animation_speed" value="<?php echo $hover_scale_animation_speed; ?>" step="0.1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_gpg_filter_thubnail">
                                <?php echo esc_html__("Choose filter for thumbnail", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The filter property defines visual effects to images of Gallery", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="ays_toggle_mobile_parent">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ( $enable_filter_thubnail_opt_mobile ) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 200px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                    <select id="ays_gpg_filter_thubnail" class="ays-text-input ays-text-input-short" name="ays_gpg_filter_thubnail_opt">
                                        <option <?php echo $filter_thubnail_opt == "none" ? "selected" : ""; ?> value="none"><?php echo esc_html__("Default none", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt == "blur" ? "selected" : ""; ?> value="blur"><?php echo esc_html__("Blur", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt == "brightness" ? "selected" : ""; ?> value="brightness"><?php echo esc_html__("Brightness", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt == "contrast" ? "selected" : ""; ?> value="contrast"><?php echo esc_html__("Contrast", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt == "grayscale" ? "selected" : ""; ?> value="grayscale"><?php echo esc_html__("Grayscale", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt == "hue_rotate" ? "selected" : ""; ?> value="hue_rotate"><?php echo esc_html__("Hue Rotate", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt == "invert" ? "selected" : ""; ?> value="invert"><?php echo esc_html__("Invert", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt == "saturate" ? "selected" : ""; ?> value="saturate"><?php echo esc_html__("Saturate", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt == "sepia" ? "selected" : ""; ?> value="sepia"><?php echo esc_html__("Sepia", 'gallery-photo-gallery');?></option>
                                    </select>
                                </div>
                                <div class="ays_toggle_target ays_gpg_filter_thubnail_opt_mobile_container" style=" <?php echo ( $enable_filter_thubnail_opt_mobile ) ? '' : 'display:none'; ?>">
                                    <hr>
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 200px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                    <select id="ays_gpg_filter_thubnail_mobile" class="ays-text-input ays-text-input-short" name="ays_gpg_filter_thubnail_opt_mobile">
                                        <option <?php echo $filter_thubnail_opt_mobile == "none" ? "selected" : ""; ?> value="none"><?php echo esc_html__("Default none", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt_mobile == "blur" ? "selected" : ""; ?> value="blur"><?php echo esc_html__("Blur", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt_mobile == "brightness" ? "selected" : ""; ?> value="brightness"><?php echo esc_html__("Brightness", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt_mobile == "contrast" ? "selected" : ""; ?> value="contrast"><?php echo esc_html__("Contrast", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt_mobile == "grayscale" ? "selected" : ""; ?> value="grayscale"><?php echo esc_html__("Grayscale", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt_mobile == "hue_rotate" ? "selected" : ""; ?> value="hue_rotate"><?php echo esc_html__("Hue Rotate", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt_mobile == "invert" ? "selected" : ""; ?> value="invert"><?php echo esc_html__("Invert", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt_mobile == "saturate" ? "selected" : ""; ?> value="saturate"><?php echo esc_html__("Saturate", 'gallery-photo-gallery');?></option>
                                        <option <?php echo $filter_thubnail_opt_mobile == "sepia" ? "selected" : ""; ?> value="sepia"><?php echo esc_html__("Sepia", 'gallery-photo-gallery');?></option>
                                    </select>
                                </div>
                                <div class="ays_gpg_mobile_settings_container">
                                    <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable_ays_gpg_filter_thubnail_opt_mobile" name="enable_ays_gpg_filter_thubnail_opt_mobile" <?php echo $enable_filter_thubnail_opt_mobile ? 'checked' : '' ?>>
                                    <label for="enable_ays_gpg_filter_thubnail_opt_mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Loader style", 'gallery-photo-gallery'); ?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Choose your desired loader icon that will appear while the Gallery is loading.", 'gallery-photo-gallery'); ?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left ays_gpg_toggle_loader_parent">
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="flower" <?php echo ($ays_gallery_loader == 'flower') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/flower.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="ball" <?php echo ($ays_gallery_loader == 'ball') ? 'checked' : ''; ?> />
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/ball.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="bars" <?php echo ($ays_gallery_loader == 'bars') ? 'checked' : ''; ?> />
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/bars.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="curved_bar" <?php echo ($ays_gallery_loader == 'curved_bar') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/curved_bar.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="react" <?php echo ($ays_gallery_loader == 'react') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/react.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="gallery" <?php echo ($ays_gallery_loader == 'gallery') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/gallery.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="fracox" <?php echo ($ays_gallery_loader == 'fracox') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/fracox.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="fracoxner" <?php echo ($ays_gallery_loader == 'fracoxner') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/fracoxner.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="frik" <?php echo ($ays_gallery_loader == 'frik') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/frik.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="clock_frik" <?php echo ($ays_gallery_loader == 'clock_frik') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/clock_frik.svg' ?>">
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="false" data-type="loader" type="radio" value="in_yan" <?php echo ($ays_gallery_loader == 'in_yan') ? 'checked' : ''; ?>>
                                <img style="width: 50px;" src="<?php echo AYS_GPG_PUBLIC_URL.'/images/in_yan.svg' ?>">
                            </label>
                            <hr/>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="true" data-type="text" type="radio" value="text" <?php echo ($ays_gallery_loader == 'text') ? 'checked' : ''; ?>>
                                <div class="ays_gpg_loader_text">
                                    <?php echo esc_html__( "Text" , 'gallery-photo-gallery' ); ?>
                                </div>
                                <div class="ays_gpg_toggle_loader_target <?php echo ($ays_gallery_loader == 'text') ? '' : 'display_none' ?>" data-type="text">
                                    <input type="text" class="ays-text-input" data-type="text" id="ays_gpg_loader_text_value" name="ays_gpg_loader_text_value" value="<?php echo $gallery_loader_text_value; ?>">
                                </div>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input name="ays_gpg_loader" class="ays_gpg_toggle_loader_radio" data-flag="true" data-type="gif" type="radio" value="custom_gif" <?php echo ($ays_gallery_loader == 'custom_gif') ? 'checked' : ''; ?>>
                                <div class="ays_gpg_loader_custom_gif">
                                    <?php echo esc_html__( "Gif" , 'gallery-photo-gallery' ); ?>
                                </div>
                                <div class="ays_gpg_toggle_loader_target ays-image-wrap <?php echo ($ays_gallery_loader == 'custom_gif') ? '' : 'display_none' ?>" data-type="gif">
                                    <a href="javascript:void(0)" style="<?php echo ($gallery_loader_custom_gif == '') ? 'display:inline-block' : 'display:none'; ?>" class="ays-add-image add_gallery_loader_custom_gif"><?php echo esc_html__('Add Gif', 'gallery-photo-gallery'); ?></a>
                                    <input type="hidden" class="ays-image-path" id="ays_gallery_loader_custom_gif" name="ays_gallery_loader_custom_gif" value="<?php echo $gallery_loader_custom_gif; ?>"/>
                                    <div class="ays-gpg-image-container" style="<?php echo ($gallery_loader_custom_gif == '') ? 'display:none' : 'display:block'; ?>">
                                        <span class="ays-edit-img ays-edit-gallery-loader-custom-gif">
                                            <i class="fa fa_pencil_square_o"></i>
                                        </span>
                                        <span class="add_gallery_loader_custom_gif ays-remove-gallery-loader-custom-gif"></span>
                                        <img  src="<?php echo $gallery_loader_custom_gif; ?>" class="img_gallery_loader_custom_gif"/>
                                    </div>
                                </div>
                                <div class="ays_gpg_toggle_loader_target ays_gif_loader_width_container <?php echo ($ays_gallery_loader == 'custom_gif') ? 'display_flex' : 'display_none'; ?>" data-type="gif" style="margin: 10px;">
                                    <div>
                                        <label for='ays_gallery_loader_custom_gif_width'>
                                            <?php echo esc_html__('Width (px)', 'gallery-photo-gallery'); ?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__('Custom Gif width in pixels. It accepts only numeric values.','gallery-photo-gallery'); ?>">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div style="margin-left: 5px;">
                                        <input type="number" class="ays-text-input" id='ays_gallery_loader_custom_gif_width' name='ays_gallery_loader_custom_gif_width' value="<?php echo ( $gallery_loader_custom_gif_width ); ?>"/>
                                    </div>
                                </div>
                            </label>
                        </div>                
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Images hover icon", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("During hover, the icon seen on the image", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <?php 
                                if($gal_options['hover_icon'] == false || $gal_options['hover_opacity'] == ''){
                                    $ays_hover_icon = 'search_plus';
                                }else{
                                    $ays_hover_icon = $gal_options['hover_icon'];
                                }
                            ?>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="none" <?php echo $ays_hover_icon == 'none' ? 'checked' : ''; ?> />
                                <i>None</i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="search_plus" <?php echo $ays_hover_icon == 'search_plus' ? 'checked' : ''; ?> />
                                <i class="fas fa-search-plus"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="search" <?php echo $ays_hover_icon == 'search' ? 'checked' : ''; ?>/>
                                <i class="fas fa-search"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="plus" <?php echo $ays_hover_icon == 'plus' ? 'checked' : ''; ?>/>
                                <i class="fas fa-plus"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="plus_circle" <?php echo $ays_hover_icon == 'plus_circle' ? 'checked' : ''; ?>/>
                                <i class="fas fa-plus-circle"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="plus_square_fas" <?php echo $ays_hover_icon == 'plus_square_fas' ? 'checked' : ''; ?>/>
                                <i class="fas fa-plus-square"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="plus_square_far" <?php echo $ays_hover_icon == 'plus_square_far' ? 'checked' : ''; ?>/>
                                <i class="far fa-plus-square"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="expand" <?php echo $ays_hover_icon == 'expand' ? 'checked' : ''; ?>/>
                                <i class="fas fa-expand"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="image_fas" <?php echo $ays_hover_icon == 'image_fas' ? 'checked' : ''; ?>/>
                                <i class="fas fa-image"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="image_far" <?php echo $ays_hover_icon == 'image_far' ? 'checked' : ''; ?>/>
                                <i class="far fa-image"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="images_fas" <?php echo $ays_hover_icon == 'images_fas' ? 'checked' : ''; ?>/>
                                <i class="fas fa-images"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="images_far" <?php echo $ays_hover_icon == 'images_far' ? 'checked' : ''; ?>/>
                                <i class="far fa-images"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="eye_fas" <?php echo $ays_hover_icon == 'eye_fas' ? 'checked' : ''; ?>/>
                                <i class="fas fa-eye"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="eye_far" <?php echo $ays_hover_icon == 'eye_far' ? 'checked' : ''; ?>/>
                                <i class="far fa-eye"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="camera_retro" <?php echo $ays_hover_icon == 'camera_retro' ? 'checked' : ''; ?>/>
                                <i class="fas fa-camera-retro"></i>
                            </label>
                            <label class="ays_gpg_image_hover_icon">
                                <input type="radio" name="ays-gpg-image-hover-icon" value="camera" <?php echo $ays_hover_icon == 'camera' ? 'checked' : ''; ?>/>
                                <i class="fas fa-camera"></i>
                            </label>
                            <p class="ays_gpg_image_hover_icon_text"><span><?php echo esc_html__("Select icon for the gallery images", 'gallery-photo-gallery');?></span></p>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays-gpg-hover-icon-size">
                                <?php echo esc_html__("Images hover icon size", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the image hover icon size in pixels.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left ays_gpg_display_flex_width">
                            <div>
                                <input name="ays-gpg-hover-icon-size" id="ays-gpg-hover-icon-size" class="ays-text-input ays-text-input-short" type="number" value="<?php echo $ays_gpg_hover_icon_size; ?>">
                            </div>
                            <div class="ays_gpg_dropdown_max_width">
                                <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays-gpg-images-distance">
                                <?php echo esc_html__("Images distance", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The distance among images with pixels", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left ays_gpg_display_flex_width">
                            <div>
                                <input name="ays-gpg-images-distance" id="ays-gpg-images-distance" class="ays-text-input ays-text-input-short" type="number" value="<?php echo $images_distance; ?>">
                            </div>
                            <div class="ays_gpg_dropdown_max_width">
                                <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_gpg_images_border">
                                <?php echo esc_html__("Images border", 'gallery-photo-gallery'); ?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The distance among images with pixels", 'gallery-photo-gallery'); ?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <input id="ays_gpg_images_border" name="ays_gpg_images_border" class="" type="checkbox" <?php echo ($ays_images_border == 'on') ? 'checked' : ''; ?>>
                            <div class="ays_gpg_border_options">
                                <div class="ays_gpg_border_options_div ays_gpg_display_flex_width">
                                    <div>
                                       <input type="number" class="ays_gpg_images_border_width" style="width: 50px;" min="0" max="10" maxlength="2" name="ays_gpg_images_border_width" value="<?php echo $ays_images_border_width; ?>" onkeypress="if(this.value.length==2) return false;">
                                    </div>
                                    <div class="ays_gpg_dropdown_max_width">
                                        <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                                    </div>                            
                                </div>
                                <div class="ays_gpg_border_options_div gpg_images_border_style">
                                    <select name="ays_gpg_images_border_style">
                                    <option value="solid" <?php echo $ays_images_border_style == "solid" ? 'selected' : ''; ?>>Solid</option>
                                    <option value="dashed" <?php echo $ays_images_border_style == "dashed" ? 'selected' : ''; ?>>Dashed</option>
                                    <option value="dotted" <?php echo $ays_images_border_style == "dotted" ? 'selected' : ''; ?>>Dotted</option>
                                    <option value="double" <?php echo $ays_images_border_style == "double" ? 'selected' : ''; ?>>Double</option>
                                    <option value="groove" <?php echo $ays_images_border_style == "groove" ? 'selected' : ''; ?>>Groove</option>
                                    <option value="ridge" <?php echo $ays_images_border_style == "ridge" ? 'selected' : ''; ?>>Ridge</option>
                                    <option value="inset" <?php echo $ays_images_border_style == "inset" ? 'selected' : ''; ?>>Inset</option>
                                    <option value="outset" <?php echo $ays_images_border_style == "outset" ? 'selected' : ''; ?>>Outset</option>
                                    <option value="none" <?php echo $ays_images_border_style == "none" ? 'selected' : ''; ?>>None</option>
                                </select>
                                </div>
                                <div class="ays_gpg_border_options_div">
                                    <input name="ays_gpg_border_color" class="ays_gpg_border_color" type="text" data-alpha="true" value="<?php echo $ays_images_border_color; ?>" data-default-color="#000000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays-gpg-images-border-radius">
                                <?php echo esc_html__("Images border radius", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The degree of borders curvature of images", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="ays_toggle_mobile_parent">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ($enable_ays_gpg_border_radius_mobile) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 200px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                    <div class="ays_gpg_display_flex_width">
                                        <div>
                                            <input name="ays-gpg-images-border-radius" id="ays-gpg-images-border-radius" class="ays-text-input ays-text-input-short" type="number" value="<?php echo $ays_gpg_border_radius; ?>">
                                        </div>
                                        <div class="ays_gpg_dropdown_max_width">
                                            <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                                        </div>
                                    </div>
                                </div>
                                <div class="ays_toggle_target ays_gpg_title_color_mobile_container" style=" <?php echo ( $enable_ays_gpg_border_radius_mobile ) ? '' : 'display:none'; ?>">
                                    <hr>
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 200px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                    <div class="ays_gpg_display_flex_width">
                                        <div>
                                            <input name="ays-gpg-images-border-radius-mobile" id="ays-gpg-images-border-radius-mobile" class="ays-text-input ays-text-input-short" type="number" value="<?php echo $ays_gpg_border_radius_mobile; ?>">
                                        </div>
                                        <div class="ays_gpg_dropdown_max_width">
                                            <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                                        </div>
                                    </div>
                                </div>
                                <div class="ays_gpg_mobile_settings_container">
                                    <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable-ays-gpg-images-border-radius-mobile" name="enable_ays_gpg_images_border_radius_mobile" <?php echo $enable_ays_gpg_border_radius_mobile ? 'checked' : '' ?> >
                                    <label for="enable-ays-gpg-images-border-radius-mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="ays_gpg_thumbnail_title_size">
                                <?php echo esc_html__("Thumbnail title icon size", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Specify the thumbnail image hover icon size in pixels.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>               
                        <div class="col-sm-9 ays_divider_left ays_gpg_display_flex_width">
                            <div>
                                <input name="ays_gpg_thumbnail_title_size" id="ays_gpg_thumbnail_title_size" class="ays-text-input ays-text-input-short" type="number" value="<?php echo $ays_gpg_thumbnail_title_size; ?>">
                            </div>
                            <div class="ays_gpg_dropdown_max_width">
                                <input type="text" value="px" class="ays-gpg-form-hint-for-size" disabled="">
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for='ays_gallery_title_color'>
                                <?php echo esc_html__("Gallery title text color", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The color of the Gallery title", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="ays_toggle_mobile_parent">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ($enable_gallery_title_color_mobile) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                    <input type="text" id="ays_gallery_title_color" name="ays_gallery_title_color" data-alpha="true" value="<?php echo $gallery_title_color; ?>" data-default-color="#000">
                                </div>
                                <div class="ays_toggle_target ays_gpg_title_color_mobile_container" style=" <?php echo ( $enable_gallery_title_color_mobile ) ? '' : 'display:none'; ?>">
                                    <hr>
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                    <input type="text" id="ays_gallery_title_color_mobile" name="ays_gallery_title_color_mobile" data-alpha="true" value="<?php echo $gallery_title_color_mobile; ?>" data-default-color="#000">
                                </div>
                                <div class="ays_gpg_mobile_settings_container">
                                    <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable_ays_gallery_title_color_mobile" name="enable_ays_gallery_title_color_mobile" <?php echo $enable_gallery_title_color_mobile ? 'checked' : '' ?>>
                                    <label for="enable_ays_gallery_title_color_mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for='ays_gallery_desc_color'>
                                <?php echo esc_html__("Gallery description text color", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The color of the Gallery description", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="ays_toggle_mobile_parent">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ($enable_gallery_desc_color_mobile) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                    <input type="text" id="ays_gallery_desc_color" name="ays_gallery_desc_color" data-alpha="true" value="<?php echo $gallery_desc_color; ?>" data-default-color="#000">
                                </div>
                                <div class="ays_toggle_target ays_gpg_desc_color_mobile_container" style=" <?php echo ( $enable_gallery_desc_color_mobile ) ? '' : 'display:none'; ?>">
                                    <hr>
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                    <input type="text" id="ays_gallery_desc_color_mobile" name="ays_gallery_desc_color_mobile" data-alpha="true" value="<?php echo $gallery_desc_color_mobile; ?>" data-default-color="#000">
                                </div>
                                <div class="ays_gpg_mobile_settings_container">
                                    <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable_ays_gallery_desc_color_mobile" name="enable_ays_gallery_desc_color_mobile" <?php echo $enable_gallery_desc_color_mobile ? 'checked' : '' ?>>
                                    <label for="enable_ays_gallery_desc_color_mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label>
                                <?php echo esc_html__("Background color of the Gallery thumbnail title", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The color of the background of the Gallery Thumbnail title", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="ays_toggle_mobile_parent">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ( $enable_thumbnail_title_bg_color_mobile ) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                    <input name="ays-gpg-lightbox-color" id="ays-gpg-lightbox-color" class="ays_gpg_lightbox_color" data-alpha="true" type="text" value="<?php echo $thumbnail_title_bg_color; ?>" data-default-color="rgba(0,0,0,0)">
                                </div>
                                <div class="ays_toggle_target ays_gpg_desc_color_mobile_container" style=" <?php echo ( $enable_thumbnail_title_bg_color_mobile ) ? '' : 'display:none'; ?>">
                                    <hr>
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                    <input name="ays-gpg-lightbox-color-mobile" id="ays-gpg-lightbox-color-mobile" class="ays_gpg_lightbox_color_mobile" data-alpha="true" type="text" value="<?php echo $thumbnail_title_bg_color_mobile; ?>" data-default-color="rgba(0,0,0,0)">
                                </div>
                                <div class="ays_gpg_mobile_settings_container">
                                    <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable-ays-gpg-lightbox-color-mobile" name="enable-ays-gpg-lightbox-color-mobile" <?php echo $enable_thumbnail_title_bg_color_mobile ? 'checked' : '' ?>>
                                    <label for="enable-ays-gpg-lightbox-color-mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for='ays_gpg_thumbnail_title_color'>
                                <?php echo esc_html__("Thumbnail title text color", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Choose the color of the title text on the thumbnail. Make it transparent if you want.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <div class="ays_toggle_mobile_parent">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ( $enable_thumbnail_title_color_mobile ) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                    <input id="ays_gpg_thumbnail_title_color" name="ays_gpg_thumbnail_title_color" data-alpha="true" type="text" value="<?php echo $thumbnail_title_color; ?>" data-default-color="#ffffff">
                                </div>
                                <div class="ays_toggle_target ays_gpg_desc_color_mobile_container" style=" <?php echo ( $enable_thumbnail_title_color_mobile ) ? '' : 'display:none'; ?>">
                                    <hr>
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                    <input id="ays_gpg_thumbnail_title_color_mobile" name="ays_gpg_thumbnail_title_color_mobile" data-alpha="true" type="text" value="<?php echo $thumbnail_title_color_mobile; ?>" data-default-color="#ffffff">
                                </div>
                                <div class="ays_gpg_mobile_settings_container">
                                    <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable_ays_gpg_thumbnail_title_color_mobile" name="enable_ays_gpg_thumbnail_title_color_mobile" <?php echo $enable_thumbnail_title_color_mobile ? 'checked' : '' ?>>
                                    <label for="enable_ays_gpg_thumbnail_title_color_mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="custom_class">
                                <?php echo esc_html__("Custom class", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Custom HTML class for gallery container. You can use your class for adding your custom styles for gallery container.", 'gallery-photo-gallery' ); ?>">
                                <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <input type="text" name="ays_custom_class" id="custom_class" class="ays-text-input ays-text-input-short" placeholder="<?php echo esc_attr__("myClass myAnotherClass...", 'gallery-photo-gallery');?>" value="<?php echo esc_attr($custom_class); ?>"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="gallery_custom_css">
                                <?php echo esc_html__("Custom CSS", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("You can add your CSS", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <textarea class="ays-textarea" name="gallery_custom_css" id="gallery_custom_css"><?php echo $ays_gpg_custom_css ?></textarea>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label for="reset_to_default">
                                <?php echo esc_html__('Reset styles', 'gallery-photo-gallery') ?>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?php echo esc_attr__('Reset styles to default values', 'gallery-photo-gallery') ?>">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-9 ays_divider_left">
                            <button type="button" class="ays-button button-secondary"
                                    id="reset_to_default"><?php echo esc_html__("Reset", 'gallery-photo-gallery') ?>
                            </button>
                        </div>
                    </div>
                    <hr/>
                </div>
            </div>
        </div>
        <div id="tab4" class="ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab4') ? 'ays-gallery-tab-content-active' : ''; ?>">            
            <div class="ays-gpg-accordion-options-main-container" data-collapsed="false">
                <div class="ays-gpg-accordion-container">
                    <?php echo $gpg_accordion_svg_html; ?>
                    <p class="ays-subtitle ays-gpg-subtitle" style="margin-top:0;"><?php echo esc_html__( 'Lightbox options', 'gallery-photo-gallery' ); ?></p>
                </div>
                <hr class="ays-gpg-bolder-hr"/>
                <div class="ays-gpg-accordion-options-box">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>
                                <?php echo esc_html__("Images counter", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?php echo esc_attr__('Enable this option to show the number of images while sliding them.', 'gallery-photo-gallery') ?>">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-10 ays_divider_left">
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Enable ", 'gallery-photo-gallery');?>
                                <input type="radio" class="" name="ays_gpg_lightbox_counter" <?php echo ($ays_gpg_lightbox_counter == "true") ? "checked" : ""; ?> value="true"/>
                            </label>
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Disable ", 'gallery-photo-gallery');?> 
                                <input type="radio" class="" name="ays_gpg_lightbox_counter" <?php echo ($ays_gpg_lightbox_counter == "false") ? "checked" : ""; ?> value="false"/>
                            </label>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>
                                <?php echo esc_html__("Show caption in lightbox", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?php echo esc_attr__('Enable this option to display the image caption in the lightbox.', 'gallery-photo-gallery') ?>">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-10 ays_divider_left">
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Enable ", 'gallery-photo-gallery');?>
                                <input type="radio" class="" name="ays_gpg_show_caption" <?php echo ($ays_gpg_show_caption == "true") ? "checked" : ""; ?> value="true"/>
                            </label>
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Disable ", 'gallery-photo-gallery');?> 
                                <input type="radio" class="" name="ays_gpg_show_caption" <?php echo ($ays_gpg_show_caption == "false") ? "checked" : ""; ?> value="false"/>
                            </label>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>
                                <?php echo esc_html__("Images slide show", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip"
                                   title="<?php echo esc_attr__('Enable this option to automatically slide through the Images.', 'gallery-photo-gallery') ?>">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-2 ays_divider_left">
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Enable ", 'gallery-photo-gallery');?>
                                <input type="radio" class="ays_enable_disable" name="ays_gpg_lightbox_autoplay" <?php echo ($ays_gpg_lightbox_autoplay == "true") ? "checked" : ""; ?> value="true"/>
                            </label>
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Disable ", 'gallery-photo-gallery');?> 
                                <input type="radio" class="ays_enable_disable" name="ays_gpg_lightbox_autoplay" <?php echo ($ays_gpg_lightbox_autoplay == "false") ? "checked" : ""; ?> value="false"/>
                            </label>
                        </div>
                        <div class="col-sm-8 ays_hidden ays_divider_left">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="ays_gpg_lightbox_pause">
                                        <?php echo esc_html__("Slide duration", 'gallery-photo-gallery');?>
                                    </label>
                                </div>                        
                                <div class="col-sm-9 ays_gpg_display_flex_width ays_divider_left">
                                    <div>
                                       <input type="number" class="ays-text-input" name="ays_gpg_lightbox_pause" id="ays_gpg_lightbox_pause" value="<?php echo $ays_gpg_lightbox_pause; ?>" />
                                        <span class="ays_gpg_image_hover_icon_text"><?php echo esc_html__("1 sec = 1000 ms", 'gallery-photo-gallery');?></span>
                                    </div>
                                    <div class="ays_gpg_dropdown_max_width">
                                        <input type="text" value="ms" class="ays-gpg-form-hint-for-size" disabled="">
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label>
                                        <?php echo esc_html__("Hide Progress Line", 'gallery-photo-gallery');?>
                                    </label>
                                </div>                        
                                <div class="col-sm-9 ays_divider_left">                            
                                    <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Enable ", 'gallery-photo-gallery');?>
                                        <input type="radio" class="" name="ays_gpg_hide_progress_line" <?php echo ($ays_gpg_hide_progress_line == "true") ? "checked" : ""; ?> value="true"/>
                                    </label>
                                    <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Disable ", 'gallery-photo-gallery');?> 
                                        <input type="radio" class="" name="ays_gpg_hide_progress_line" <?php echo ($ays_gpg_hide_progress_line == "false") ? "checked" : ""; ?> value="false"/>
                                    </label>                            
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for='ays_gpg_progress_line_color'>
                                        <?php echo esc_html__("Progress Line color", 'gallery-photo-gallery');?>
                                        <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The color of the Progress Line", 'gallery-photo-gallery');?>">
                                           <i class="fas fa-info-circle"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-sm-9 ays_divider_left">
                                    <div class="ays_toggle_mobile_parent">
                                        <div>
                                            <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ( $enable_ays_gpg_progress_line_color_mobile ) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                            <input type="text" id="ays_gpg_progress_line_color" name="ays_gpg_progress_line_color" data-alpha="true" value="<?php echo $ays_gpg_progress_line_color; ?>" data-default-color="#a90707">
                                        </div>
                                        <div class="ays_toggle_target ays_gpg_progress_line_color_mobile_container" style=" <?php echo ( $enable_ays_gpg_progress_line_color_mobile ) ? '' : 'display:none'; ?>">
                                            <hr>
                                            <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 100px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                            <input type="text" id="ays_gpg_progress_line_color_mobile" name="ays_gpg_progress_line_color_mobile" data-alpha="true" value="<?php echo $ays_gpg_progress_line_color_mobile; ?>" data-default-color="#a90707">
                                        </div>
                                        <div class="ays_gpg_mobile_settings_container">
                                            <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable_ays_gpg_progress_line_color_mobile" name="enable_ays_gpg_progress_line_color_mobile" <?php echo $enable_ays_gpg_progress_line_color_mobile ? 'checked' : '' ?>>
                                            <label for="enable_ays_gpg_progress_line_color_mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="ays_gpg_filter_lightbox">
                                <?php echo esc_html__("Choose filter for lightbox", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("The filter property defines visual effects to images of Gallery", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-10 ays_divider_left">
                            <div class="ays_toggle_mobile_parent">
                                <div>
                                    <div class="ays_gpg_current_device_name ays_gpg_current_device_name_pc_default_on ays_gpg_current_device_name_pc show ays_toggle_target" style="<?php echo ( $enable_filter_lightbox_opt_mobile ) ? '' : 'display: none;' ?> text-align: center; margin-bottom: 10px; max-width: 200px;"><?php echo esc_html__('PC', 'gallery-photo-gallery') ?></div>
                                    <select id="ays_gpg_filter_lightbox" class="ays-text-input ays-text-input-short" name="ays_gpg_filter_lightbox_opt">
                                        <option <?php echo ( $filter_lightbox_opt == "none" ) ? "selected" : ""; ?> value="none"><?php echo esc_html__("None", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt == "blur" ) ? "selected" : ""; ?> value="blur"><?php echo esc_html__("Blur", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt == "brightness" ) ? "selected" : ""; ?> value="brightness"><?php echo esc_html__("Brightness", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt == "contrast" ) ? "selected" : ""; ?> value="contrast"><?php echo esc_html__("Contrast", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt == "grayscale" ) ? "selected" : ""; ?> value="grayscale"><?php echo esc_html__("Grayscale", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt == "hue_rotate" ) ? "selected" : ""; ?> value="hue_rotate"><?php echo esc_html__("Hue Rotate", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt == "invert" ) ? "selected" : ""; ?> value="invert"><?php echo esc_html__("Invert", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt == "saturate" ) ? "selected" : ""; ?> value="saturate"><?php echo esc_html__("Saturate", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt == "sepia" ) ? "selected" : ""; ?> value="sepia"><?php echo esc_html__("Sepia", 'gallery-photo-gallery');?></option>
                                    </select>
                                </div>
                                <div class="ays_toggle_target ays_gpg_filter_thubnail_opt_mobile_container" style=" <?php echo ( $enable_filter_lightbox_opt_mobile ) ? '' : 'display:none'; ?>">
                                    <hr>
                                    <div class="ays_gpg_current_device_name show" style="text-align: center; margin-bottom: 10px; max-width: 200px;"><?php echo esc_html__('Mobile', 'gallery-photo-gallery') ?></div>
                                    <select id="ays_gpg_filter_lightbox_mobile" class="ays-text-input ays-text-input-short" name="ays_gpg_filter_lightbox_opt_mobile">
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "none" ) ? "selected" : ""; ?> value="none"><?php echo esc_html__("None", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "blur" ) ? "selected" : ""; ?> value="blur"><?php echo esc_html__("Blur", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "brightness" ) ? "selected" : ""; ?> value="brightness"><?php echo esc_html__("Brightness", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "contrast" ) ? "selected" : ""; ?> value="contrast"><?php echo esc_html__("Contrast", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "grayscale" ) ? "selected" : ""; ?> value="grayscale"><?php echo esc_html__("Grayscale", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "hue_rotate" ) ? "selected" : ""; ?> value="hue_rotate"><?php echo esc_html__("Hue Rotate", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "invert" ) ? "selected" : ""; ?> value="invert"><?php echo esc_html__("Invert", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "saturate" ) ? "selected" : ""; ?> value="saturate"><?php echo esc_html__("Saturate", 'gallery-photo-gallery');?></option>
                                        <option <?php echo ( $filter_lightbox_opt_mobile == "sepia" ) ? "selected" : ""; ?> value="sepia"><?php echo esc_html__("Sepia", 'gallery-photo-gallery');?></option>
                                    </select>
                                </div>
                                <div class="ays_gpg_mobile_settings_container">
                                    <input type="checkbox" class="ays_toggle_mobile_checkbox" id="enable_ays_gpg_filter_lightbox_opt_mobile" name="enable_ays_gpg_filter_lightbox_opt_mobile" <?php echo $enable_filter_lightbox_opt_mobile ? 'checked' : '' ?>>
                                    <label for="enable_ays_gpg_filter_lightbox_opt_mobile" ><?php echo esc_html__('Use a different setting for Mobile', 'gallery-photo-gallery') ?></label>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label>
                                <?php echo esc_html__("Allow key control", 'gallery-photo-gallery');?>
                                <a class="ays_help" data-toggle="tooltip" title="<?php echo esc_attr__("Enable this option to allow your users to navigate through images via key control.", 'gallery-photo-gallery');?>">
                                   <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                        </div>
                        <div class="col-sm-2 ays_divider_left">
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Enable ", 'gallery-photo-gallery');?>
                                <input type="radio" class="ays_enable_disable" name="ays_gpg_lg_keypress" <?php echo ($ays_gpg_lg_keypress == "true") ? "checked" : ""; ?> value="true"/>
                            </label>
                            <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Disable ", 'gallery-photo-gallery');?> 
                                <input type="radio" class="ays_enable_disable" name="ays_gpg_lg_keypress" <?php echo ($ays_gpg_lg_keypress == "false") ? "checked" : ""; ?> value="false"/>
                            </label>
                        </div>
                        <div class="col-sm-8 ays_hidden ays_divider_left">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label><?php echo esc_html__("Allow Esc key", 'gallery-photo-gallery');?></label>
                                </div>
                                <div class="col-sm-9 ays_divider_left">
                                    <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Enable ", 'gallery-photo-gallery');?>
                                        <input type="radio" class="" name="ays_gpg_lg_esckey" <?php echo ($ays_gpg_lg_esckey == "true") ? "checked" : ""; ?> value="true"/>
                                    </label>
                                    <label class="ays_gpg_image_hover_icon"><?php echo esc_html__("Disable ", 'gallery-photo-gallery');?> 
                                        <input type="radio" class="" name="ays_gpg_lg_esckey" <?php echo ($ays_gpg_lg_esckey == "false") ? "checked" : ""; ?> value="false"/>
                                    </label>
                                </div>
                            </div>                    
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 only_pro">
                            <div class="pro_features">
                                <div>                            
                                    <a href="https://ays-pro.com/wordpress/photo-gallery/" target="_blank" class="ays-gpg-new-upgrade-button-link">
                                        <div class="ays-gpg-new-upgrade-button-box">
                                            <div>
                                                <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_locked_24x24.svg'?>">
                                                <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_unlocked_24x24.svg'?>" class="ays-gpg-new-upgrade-button-hover">
                                            </div>
                                            <div class="ays-gpg-new-upgrade-button"><?php echo esc_html__("Upgrade", 'gallery-photo-gallery'); ?></div>
                                        </div>
                                    </a>
                                    <div class="ays-gpg-center-big-main-button-box ays-gpg-new-big-button-flex">
                                        <div class="ays-gpg-center-big-upgrade-button-box">
                                            <a href="https://ays-pro.com/wordpress/photo-gallery/" target="_blank" class="ays-gpg-new-upgrade-button-link">
                                                <div class="ays-gpg-center-new-big-upgrade-button">
                                                    <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_locked_24x24.svg'?>" class="ays-gpg-new-button-img-hide">
                                                    <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_unlocked_24x24.svg'?>" class="ays-gpg-new-upgrade-button-hover">  
                                                    <?php echo esc_html__("Upgrade", 'gallery-photo-gallery'); ?>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img class="pro_img_style" src="<?php echo AYS_GPG_ADMIN_URL; ?>images/features/lighbox_settings.png">
                        </div>
                    </div>
                    <hr/>
                </div>
            </div>
        </div>
        <div id="tab5" class="only_pro ays-gallery-tab-content <?php echo ($ays_gpg_tab == 'tab5') ? 'ays-gallery-tab-content-active' : ''; ?>" style="padding-top: 15px;">
            <div class="ays-gpg-accordion-options-main-container" data-collapsed="false">
                <div class="ays-gpg-accordion-container">
                    <?php echo $gpg_accordion_svg_html; ?>
                    <p class="ays-subtitle ays-gpg-subtitle" style="margin-top:0;"><?php echo esc_html__( 'Lightbox effects', 'gallery-photo-gallery' ); ?></p>
                </div>
                <hr class="ays-gpg-bolder-hr"/>
                <div class="ays-gpg-accordion-options-box">
                    <div class="pro_features">
                        <div>                    
                            <a href="https://ays-pro.com/wordpress/photo-gallery/" target="_blank" class="ays-gpg-new-upgrade-button-link">
                                <div class="ays-gpg-new-upgrade-button-box">
                                    <div>
                                        <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_locked_24x24.svg'?>">
                                        <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_unlocked_24x24.svg'?>" class="ays-gpg-new-upgrade-button-hover">
                                    </div>
                                    <div class="ays-gpg-new-upgrade-button"><?php echo esc_html__("Upgrade", 'gallery-photo-gallery'); ?></div>
                                </div>
                            </a>
                            <div class="ays-gpg-center-big-main-button-box ays-gpg-new-big-button-flex">
                                <div class="ays-gpg-center-big-upgrade-button-box">
                                    <a href="https://ays-pro.com/wordpress/photo-gallery/" target="_blank" class="ays-gpg-new-upgrade-button-link">
                                        <div class="ays-gpg-center-new-big-upgrade-button">
                                            <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_locked_24x24.svg'?>" class="ays-gpg-new-button-img-hide">
                                            <img src="<?php echo AYS_GPG_ADMIN_URL.'/images/icons/gpg_unlocked_24x24.svg'?>" class="ays-gpg-new-upgrade-button-hover">  
                                            <?php echo esc_html__("Upgrade", 'gallery-photo-gallery'); ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img class="pro_img_style" src="<?php echo AYS_GPG_ADMIN_URL; ?>images/features/lighbox_effects.png">
                <hr/>
                </div>
            </div>
        </div>
        <div class="form-group row ays-galleries-button-box">
            <div class="ays-question-button-first-row" style="padding: 0;">
            <?php
                wp_nonce_field('ays_gallery_action', 'ays_gallery_action');
                $other_attributes = array();
                $buttons_html = '';
                $buttons_html .= '<div class="ays_save_buttons_content">';
                    $buttons_html .= '<div class="ays_submit_button ays_save_buttons_box">';
                    echo $buttons_html;
            ?>
                <input type="submit" name="ays-submit" class="button ays-submit ays-button button-primary ays-gpg-save-comp" value="<?php echo esc_attr__("Save and close", 'gallery-photo-gallery');?>" gpg_submit_name="ays-submit" />            
                <input type="submit" name="ays-apply" id="ays_submit_apply" class="button ays-button ays-submit ays-gpg-save-comp" title="Ctrl + s" data-toggle="tooltip" data-delay='{"show":"1000"}' value="<?php echo esc_attr__("Save", 'gallery-photo-gallery');?>" gpg_submit_name="ays-apply"/>
                <?php echo $loader_iamge; ?> 
            <?php
                        
                    $buttons_html = '</div>';
                    echo $buttons_html;
                $buttons_html = "</div>";
                echo $buttons_html; 
            ?>
            </div>
            <div class="ays-gallery-button-second-row">
            <?php
                if ( $prev_gallery_id != "" && !is_null( $prev_gallery_id ) ) {

                    $other_attributes = array(
                        'id' => 'ays-gallery-prev-button',
                        'href' => sprintf( '?page=%s&action=%s&gallery=%d', esc_attr( $_REQUEST['page'] ), 'edit', absint( $prev_gallery_id ) )
                    );
                    submit_button(__('Previous Gallery', 'gallery-photo-gallery'), 'button button-primary ays-button ays-gallery-loader-banner', 'ays_gallery_prev_button', false, $other_attributes);
                }
                if ( $next_gallery_id != "" && !is_null( $next_gallery_id ) ) {

                    $other_attributes = array(
                        'id' => 'ays-gallery-next-button',
                        'href' => sprintf( '?page=%s&action=%s&gallery=%d', esc_attr( $_REQUEST['page'] ), 'edit', absint( $next_gallery_id ) )
                    );
                    submit_button(__('Next Gallery', 'gallery-photo-gallery'), 'button button-primary ays-button ays-gallery-loader-banner', 'ays_gallery_next_button', false, $other_attributes);
                }
            ?>
            </div>
        </div>
		        
        <button type="button" class="ays_gallery_live_preview" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php echo esc_attr__("View your gallery in live preview. In the preview you can’t see Thumbnail size and Image order changes.", 'gallery-photo-gallery');?>" data-original-title="<?php echo esc_attr__("Gallery preview", 'gallery-photo-gallery');?>"><i class="fas fa-search-plus"></i></button>    
        <button class="ays_gallery_live_save" type="submit" name="ays-apply" data-container="body" data-toggle="popover" data-placement="top" data-content="" data-original-title="<?php echo esc_attr__("Save", 'gallery-photo-gallery');?>"><i class="far fa-save" gpg_submit_name="ays-apply"></i></button>
        <input type="hidden" id="ays_gpg_admin_url" value="<?php echo AYS_GPG_ADMIN_URL; ?>"/>
    </form>
    </div>
    
    <!--  Start modal preview -->
    <div class="ays_gallery_live_preview_popup">
        <a class="ays_live_preview_close"><i class="ays_gpg_fa ays_gpg_fa_times_circle"></i></a>
        <div class='ays_gallery_container'>
        </div>
        <div class="ays_gpg_live_overlay"></div>
    </div>
    <!--  End modal preview -->
</div>