<?php
    $gallery_page_url = sprintf('?page=%s', 'gallery-photo-gallery');
    $add_new_url = sprintf('?page=%s&action=%s', 'gallery-photo-gallery', 'add');
?>

<div class="wrap">
    <div class="ays-gpg-heading-box">
        <div class="ays-gpg-wordpress-user-manual-box">
            <a href="https://ays-pro.com/wordpress-photo-gallery-user-manual" target="_blank" style="text-decoration: none;font-size: 13px;">
                <i class="ays_fa ays_fa_file_text"></i>
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo __("View Documentation", 'gallery-photo-gallery'); ?></span>
            </a>
        </div>
    </div>
    <div class="ays-gallery-photo-gallery-heart-beat-main-heading ays-gallery-photo-gallery-heart-beat-main-heading-container">
        <h1 class="ays-gallery-photo-gallery-wrapper ays_heart_beat">
            <?php echo esc_html( get_admin_page_title() ); ?> <i class="far fa-heart animated"></i>
        </h1>
    </div>
    <div class="ays-gallery-faq-main">
        <h2>
            <?php echo __("How to create a simple gallery in 3 steps with the help of the", 'gallery-photo-gallery' ) .
            ' <strong>'. __("Gallery Photo Gallery", 'gallery-photo-gallery' ) .'</strong> '.
            __("plugin.", 'gallery-photo-gallery' ); ?>
            
        </h2>
        <fieldset>
            <div class="ays-gallery-ol-container">
                <ol>
                    <li>
                        <?php echo __( "Go to the", 'gallery-photo-gallery' ) . ' <a href="'. $gallery_page_url .'" target="_blank">'. __( "Galleries" , 'gallery-photo-gallery' ) .'</a> ' .  __( "page and build your first gallery by clicking on the", 'gallery-photo-gallery' ) . ' <a href="'. $add_new_url .'" target="_blank">'. __( "Add New" , 'gallery-photo-gallery' ) .'</a> ' .  __( "button", 'gallery-photo-gallery' ); ?>,
                    </li>
                    <li>
                        <?php echo __( "Fill out the information by adding a title, images and so on.", 'gallery-photo-gallery' ); ?>
                    </li>
                    <li>
                        <?php echo __( "Copy the", 'gallery-photo-gallery' ) . ' <strong>'. __( "shortcode" , 'gallery-photo-gallery' ) .'</strong> ' .  __( "of the gallery and paste it into any post․", 'gallery-photo-gallery' ); ?> 
                    </li>
                </ol>
            </div>
            <div class="ays-gallery-p-container">
                <p><?php echo __("Congrats! You have already created your first gallery." , 'gallery-photo-gallery'); ?></p>
            </div>
        </fieldset>
    </div>  
    <br>

    <div class="ays-gallery-community-wrap">
        <div class="ays-gallery-community-title">
            <h4><?php echo __( "Community", 'gallery-photo-gallery' ); ?></h4>
        </div>
        <div class="ays-gallery-community-container">
            <div class="ays-gallery-community-item">
                <div>
                    <a href="https://www.youtube.com/channel/UC-1vioc90xaKjE7stq30wmA" target="_blank" class="ays-gallery-community-item-cover">
                        <i class="ays-gallery-community-item-img ays_fa ays_fa_youtube_play"></i>
                    </a>
                </div>
                <h3 class="ays-gallery-community-item-title"><?php echo __( "YouTube community", 'gallery-photo-gallery' ); ?></h3>
                <p class="ays-gallery-community-item-desc"><?php echo __("Our YouTube community  guides you to step by step tutorials about our products and not only...", 'gallery-photo-gallery'); ?></p>
                <div class="ays-gallery-community-item-footer">
                    <a href="https://www.youtube.com/channel/UC-1vioc90xaKjE7stq30wmA" target="_blank" class="button"><?php echo __( "Subscribe", 'gallery-photo-gallery' ); ?></a>
                </div>
            </div>
            <div class="ays-gallery-community-item">
                <a href="https://wordpress.org/support/plugin/gallery-photo-gallery/" target="_blank" class="ays-gallery-community-item-cover" style="color: #0073aa;">
                    <i class="ays-gallery-community-item-img ays_fa ays_fa_wordpress"></i>
                </a>
                <h3 class="ays-gallery-community-item-title"><?php echo __( "Best Free Support", 'gallery-photo-gallery' ); ?></h3>
                <p class="ays-gallery-community-item-desc"><?php echo __( "With the Free version, you get a lifetime usage for the plugin, however, you will get new updates and support for only 1 month.", 'gallery-photo-gallery' ); ?></p>
                <div class="ays-gallery-community-item-footer">
                    <a href="https://wordpress.org/support/plugin/gallery-photo-gallery/" target="_blank" class="button"><?php echo __( "Join", 'gallery-photo-gallery' ); ?></a>
                </div>
            </div>
            <div class="ays-gallery-community-item">
                <a href="https://ays-pro.com/contact" target="_blank" class="ays-gallery-community-item-cover" style="color: #ff0000;">                    
                    <i class="ays-gallery-community-item-img ays_fa ays_fa_users" aria-hidden="true"></i>
                </a>
                <h3 class="ays-gallery-community-item-title"><?php echo __( "Premium support", 'gallery-photo-gallery' ); ?></h3>
                <p class="ays-gallery-community-item-desc"><?php echo __( "Get 12 months updates and support for the Business package and lifetime updates and support for the Developer package.", 'gallery-photo-gallery' ); ?></p>
                <div class="ays-gallery-community-item-footer">
                    <a href="https://ays-pro.com/contact" target="_blank" class="button"><?php echo __( "Contact", 'gallery-photo-gallery' ); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var acc = document.getElementsByClassName("ays-gallery-asked-question__header");
    var i;
    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        
        var panel = this.nextElementSibling;
        
        
        if (panel.style.maxHeight) {
          panel.style.maxHeight = null;
          this.children[1].children[0].style.transform="rotate(0deg)";
        } else {
          panel.style.maxHeight = panel.scrollHeight + "px";
          this.children[1].children[0].style.transform="rotate(180deg)";
        } 
      });
    }
</script>
