<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <div class="ays-gpg-heading-box">
        <div class="ays-gpg-wordpress-user-manual-box">
            <a href="https://ays-pro.com/wordpress-photo-gallery-user-manual" target="_blank" style="text-decoration: none;font-size: 13px;">
                <i class="ays_fa ays_fa_file_text"></i>
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo __("View Documentation", $this->plugin_name); ?></span>
            </a>
        </div>
    </div>
    <h1 id="ays-gpg-intro-title"><?php echo __('Please feel free to use our other awesome plugins!', $this->plugin_name); ?></h1>
    <?php $this->gpg_output_about_addons(); ?>    
    <div class="ays-gpg-see-all">
        <a href="https://ays-pro.com/wordpress" target="_blank" class="ays-gpg-all-btn"><?php echo __('See All Plugins', $this->plugin_name); ?></a>
    </div>
</div>