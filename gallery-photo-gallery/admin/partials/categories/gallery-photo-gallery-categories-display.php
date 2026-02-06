<?php

    if (isset($_GET['error'])) {
        if ($_GET['error'] === 'nonce') {
            echo '<div class="notice notice-error ays-gpg-notice"><p>' . __('Security check failed. Please try again.', 'gallery-photo-gallery') . '</p></div>';
        } elseif ($_GET['error'] === 'permissions') {
            echo '<div class="notice notice-error ays-gpg-notice"><p>' . __('You do not have sufficient permissions.', 'gallery-photo-gallery') . '</p></div>';
        }
    }

    $action = ( isset($_GET['action']) ) ? sanitize_text_field( $_GET['action'] ) : '';
    $id     = ( isset($_GET['gallery_category']) ) ? absint( sanitize_text_field( $_GET['gallery_category'] ) ) : null;

    if( $action == 'duplicate' && !is_null($id) && isset( $_GET['_wpnonce'] ) ){

        if (!current_user_can('manage_options')) {
            wp_redirect(add_query_arg('error', 'permissions', admin_url('admin.php?page=' . sanitize_text_field($_REQUEST['page']))));
            exit;
        }

        $this->cats_obj->duplicate_image_categories( $id );
    }

    $plus_icon_svg = "<span class=''><img src='". esc_url(AYS_GPG_ADMIN_URL) ."/images/icons/plus-icon.svg'></span>";
?>
<div class="wrap ays-gpg-list-table">
    <div class="ays-gpg-heading-box">
        <div class="ays-gpg-wordpress-user-manual-box">
            <a href="https://ays-pro.com/wordpress-photo-gallery-user-manual" target="_blank" style="text-decoration: none;font-size: 13px;">
                <i class="ays_fa ays_fa_file_text"></i>
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo __("View Documentation", 'gallery-photo-gallery'); ?></span>
            </a>
        </div>
    </div>
    <h1 class="wp-heading-inline">
        <?php
            echo esc_html( get_admin_page_title() );            
        ?>
    </h1>
    <div class="ays-gpg-add-new-button-box">
        <?php
            echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action button-primary ays-gpg-add-new-button ays-gpg-add-new-button-new-design"> %s '  . __('Add New', 'gallery-photo-gallery') . '</a>', esc_attr( $_REQUEST['page'] ), 'add', $plus_icon_svg);
        ?>
    </div>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder">
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <form method="post">
                        <?php
                            $this->cats_obj->prepare_items();
                            $search = __( "Search", 'gallery-photo-gallery' );
                            $this->cats_obj->search_box($search, $this->plugin_name);
                            $this->cats_obj->display();
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <br class="clear">
    </div>

    <div class="ays-gpg-add-new-button-box">
        <?php
            echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action button-primary ays-gpg-add-new-button ays-gpg-add-new-button-new-design"> %s '  . __('Add New', 'gallery-photo-gallery') . '</a>', esc_attr( $_REQUEST['page'] ), 'add', $plus_icon_svg);
        ?>
    </div>
</div>
