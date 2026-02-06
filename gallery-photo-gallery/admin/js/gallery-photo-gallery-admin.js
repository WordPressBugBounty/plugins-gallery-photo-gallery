(function( $ ) {
	'use strict';

    $.fn.goToNormal = function() {
        $('html, body').animate({
            scrollTop: this.offset().top - 200 + 'px'
        }, 'normal');
        return this; // for chaining...
    }

	$(document).ready(function(){        

        $(document).on('click', '.notice-dismiss', function(e){
            let linkModified = location.href.split('?')[1].split('&');
            for(let i = 0; i < linkModified.length; i++){
                if(linkModified[i].split("=")[0] == "status"){
                    linkModified.splice(i, 1);
                }
            }
            linkModified = linkModified.join('&');
            window.history.replaceState({}, document.title, '?'+linkModified);
        });
        
        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function(e){
            let elemenetID = $(this).attr('href');
            let active_tab = $(this).attr('data-tab');
            $(document).find('.nav-tab-wrapper a.nav-tab').each(function(){
            if( $(this).hasClass('nav-tab-active') ){
                $(this).removeClass('nav-tab-active');
            }
            });
            $(this).addClass('nav-tab-active');
                $(document).find('.ays-gallery-tab-content').each(function(){
                if( $(this).hasClass('ays-gallery-tab-content-active') )
                    $(this).removeClass('ays-gallery-tab-content-active');
            });
            $(document).find("[name='ays_gpg_settings_tab']").val(active_tab);
            $('.ays-gallery-tab-content' + elemenetID).addClass('ays-gallery-tab-content-active');
            e.preventDefault();
        });

        // Toggle mobile settings start
        $(document).on('change', '.ays_toggle_mobile_checkbox', function (e) {
            var state = $(this).prop('checked');
            let parent = $(this).parents('.ays_toggle_mobile_parent');
            switch (state) {
                case true:
                    parent.find('.ays_toggle_target').show(250);
                    break;
                case false:
                    parent.find('.ays_toggle_target').hide(250);
                    break;
            }
        });

        $(document).on('change', '.ays_toggle_checkbox', function (e) {
            let state = $(this).prop('checked');
            let parent = $(this).parents('.ays_toggle_parent');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });
        
        $(document).find('.ays_admin_pages a.ays_page').on('click', function(e){
            let elemenetID = $(this).attr('href');
            let active_tab = $(this).attr('data-tab');
            $(document).find('.ays_admin_pages a.ays_page').each(function(){
            if( $(this).hasClass('ays_page_active') ){
                $(this).removeClass('ays_page_active');
            }
            });
            $(this).addClass('ays_page_active');
                $(document).find('.ays_accordion').each(function(){
                if( $(this).hasClass('ays_accordion_active') )
                    $(this).removeClass('ays_accordion_active');
            });
            deleteCookie('ays_gpg_page_tab_free');
            setCookie('ays_gpg_page_tab_free', active_tab, {
                expires: 3600,
                path: '/'
            })
            $('.paged_ays_accordion .ays_accordion' + elemenetID).addClass('ays_accordion_active');
            e.preventDefault();
        });

        if($(document).find('.ays-gpg-top-menu').width() <= $(document).find('div.ays-gpg-top-tab-wrapper').width()){
            $(document).find('.ays_gpg_menu_left').css('display', 'flex');
            $(document).find('.ays_gpg_menu_right').css('display', 'flex');
        }
        $(window).resize(function(){
            if($(document).find('.ays-gpg-top-menu').width() < $(document).find('div.ays-gpg-top-tab-wrapper').width()){
                $(document).find('.ays_gpg_menu_left').css('display', 'flex');
                $(document).find('.ays_gpg_menu_right').css('display', 'flex');
            }else{
                $(document).find('.ays_gpg_menu_left').css('display', 'none');
                $(document).find('.ays_gpg_menu_right').css('display', 'none');
                $(document).find('div.ays-gpg-top-tab-wrapper').css('transform', 'translate(0px)');
            }
        });
        let menuItemWidths0 = [];
        let menuItemWidths = [];
        $(document).find('.ays-gpg-top-tab-wrapper .nav-tab').each(function(){
            let $this = $(this);
            menuItemWidths0.push($this.outerWidth());
        });
        
        for(let i = 0; i < menuItemWidths0.length; i+=2){
            if(menuItemWidths0.length <= i+1){
                menuItemWidths.push(menuItemWidths0[i]);
            }else{
                menuItemWidths.push(menuItemWidths0[i]+menuItemWidths0[i+1]);
            }
        }
        let menuItemWidth = 0;
        for(let i = 0; i < menuItemWidths.length; i++){
            menuItemWidth += menuItemWidths[i];
        }
        menuItemWidth = menuItemWidth / menuItemWidths.length;
        $(document).on('click', '.ays_gpg_menu_left', function(){
            let scroll = parseInt($(this).attr('data-scroll'));
            scroll -= menuItemWidth;
            if(scroll < 0){
                scroll = 0;
            }
            $(document).find('div.ays-gpg-top-tab-wrapper').css('transform', 'translate(-'+scroll+'px)');
            $(this).attr('data-scroll', scroll);
            $(document).find('.ays_gpg_menu_right').attr('data-scroll', scroll);
        });
        $(document).on('click', '.ays_gpg_menu_right', function(){
            let scroll = parseInt($(this).attr('data-scroll'));
            let howTranslate = $(document).find('div.ays-gpg-top-tab-wrapper').width() - $(document).find('.ays-gpg-top-menu').width();
            howTranslate += 7;
            if(scroll == -1){
                scroll = menuItemWidth;
            }            
            scroll += menuItemWidth;
            if(scroll > howTranslate){
                scroll = howTranslate;
            }
            $(document).find('div.ays-gpg-top-tab-wrapper').css('transform', 'translate(-'+scroll+'px)');
            $(this).attr('data-scroll', scroll);
            $(document).find('.ays_gpg_menu_left').attr('data-scroll', scroll);
        });

        $(document).find('#ays-gpg-lightbox-color').wpColorPicker();
        $(document).find('#ays-gpg-lightbox-color-mobile').wpColorPicker();
        $(document).find('#ays_gallery_title_color').wpColorPicker();
        $(document).find('#ays_gallery_title_color_mobile').wpColorPicker();
        $(document).find('#ays_gallery_desc_color').wpColorPicker();
        $(document).find('#ays_gallery_desc_color_mobile').wpColorPicker();
        $(document).find('#ays_gpg_thumbnail_title_color').wpColorPicker();
        $(document).find('#ays_gpg_thumbnail_title_color_mobile').wpColorPicker();
        $(document).find('#ays_gpg_progress_line_color').wpColorPicker();
        $(document).find('#ays_gpg_progress_line_color_mobile').wpColorPicker();
        $(document).find('#ays-gpg-hover-color').wpColorPicker();
        $(document).find('#ays-gpg-hover-color-mobile').wpColorPicker();
        $(document).find('#ays_gpg_border_color').wpColorPicker();
        $(document).find('#ays_gpg_border_color_mobile').wpColorPicker();
        $(document).find('.ays_gallery_live_preview').hover(function () {
            $('.ays_gallery_live_preview').popover('show');
        }, function () {
            $('.ays_gallery_live_preview').popover('hide');
        });
        $(document).find('.ays_gallery_live_save').hover(function () {
            $('.ays_gallery_live_save').popover('show');
        }, function () {
            $('.ays_gallery_live_save').popover('hide');
        });
		let current_fs, next_fs, previous_fs; //fieldsets
		let left, opacity, scale; //fieldset properties which we will animate
		let animating; //flag to prevent quick multi-click glitches
        
        $(document).find('#gpg_opacity_demo').css('opacity', $(document).find('#formControlRange').val());
        $(document).on('input', '#formControlRange', function(){
            $(document).find('#gpg_opacity_demo').css('opacity', $(this).val());
        });

        $(document).find('#gpg_opacity_demo_mobile').css('opacity', $(document).find('#formControlRangeMobile').val());
        $(document).on('input', '#formControlRangeMobile', function(){
            $(document).find('#gpg_opacity_demo_mobile').css('opacity', $(this).val());
        });
        
		$(document).on('click', '.ays-add-multiple-images', function(e){
			openMediaUploader_forMultiple(e, $(this));
		});        

        setTimeout(function(){
            if($(document).find('#gallery_custom_css').length > 0){
                let CodeEditor = null;
                if(wp.codeEditor){
                    CodeEditor = wp.codeEditor.initialize($(document).find('#gallery_custom_css'), cm_gpg_settings);
                }
                if(CodeEditor !== null){
                    CodeEditor.codemirror.on('change', function(e, ev){
                        $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                        $(document).find('#gallery_custom_css').val(CodeEditor.codemirror.display.input.div.innerText);
                    });
                }

            }
        }, 500);
        $(document).find('a[href="#tab3"]').on('click', function (e) {        
            setTimeout(function(){
                if($(document).find('#gallery_custom_css').length > 0){
                    var ays_custom_css = $(document).find('#gallery_custom_css').html();
                    if(wp.codeEditor){
                        $(document).find('#gallery_custom_css').next('.CodeMirror').remove();
                        var CodeEditor = wp.codeEditor.initialize($(document).find('#gallery_custom_css'), cm_gpg_settings);                        
                        CodeEditor.codemirror.on('change', function(e, ev){
                            $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
                            $(document).find('#gallery_custom_css').val(CodeEditor.codemirror.display.input.div.innerText);
                        });
                        ays_custom_css = CodeEditor.codemirror.getValue();
                        $(document).find('#gallery_custom_css').html(ays_custom_css);
                    }
                }
            }, 500);            
        });

        $(document).find('#gallery_title').on('input', function(e){
            var val = stripHTML($(this).val());
            $(document).find('.ays_gpg_title_in_top').html(val);
        });

        $(document).click( function(e){
            create_submit_name(e);
        });

        $(document).on('submit', '#ays-gpg-form', function(e){
            create_select_category_name(e, $(this));
        });
		
		$(document).on('click', '.ays-add-video', function(e){
			openMediaUploader_forVideo(e, $(this));
		});
		
		$("#ays_admin_pagination").on('change', function(e){
			$(document).find('#ays_submit_apply').trigger("click");
		});

        $(document).find('#gallery_title').on('input', function(e){
            var gpgTitleVal = $(this).val();
            var gpgTitle = aysGallerystripHTML( gpgTitleVal );
            $(document).find('.ays_gallery_title_in_top').html( gpgTitle );
        });
        
        $("#ays_images_ordering").on('change', function(e){
            if ($(this).val() == 'random' || $(this).val() == 'noordering') {
                $(document).find('#ays_gpg_ordering_asc_desc').hide();
            }else{
                $(document).find('#ays_gpg_ordering_asc_desc').show();
            }
        });        
        
        $(".ays_gpg_sort").on('click', function(e){
            e.preventDefault();
            var page_value = $( "#ays_admin_pagination" ).val();
            if (page_value == "all") {
                var accordion_ul = $('.ays-accordion'); // your parent ul element
                accordion_ul.children().each(function(i,li){
                    accordion_ul.prepend(li)
                });                
            }else{
                var accordion_ul_avtive = $('.ays_accordion_active'); // your parent ul element
                accordion_ul_avtive.children().each(function(i,li){
                    accordion_ul_avtive.prepend(li)
                }); 
            }            
        });
		
        if($(document).find('#show_title').prop('checked')){
            $(document).find('.show_with_date').css('display', 'inline-block');
        }else{            
            $(document).find('.show_with_date').css('display', 'none');
        }
        
        if($(document).find('input.ays_hover_effect_radio:checked').val() == "simple" ){
            $(document).find('.ays_effect_simple').show();
            $(document).find('.ays_effect_dir_aware').hide();
        }
        
        if($(document).find('input.ays_hover_effect_radio:checked').val() == "dir_aware" ){
            $(document).find('.ays_effect_simple').hide();
            $(document).find('.ays_effect_dir_aware').show();
        }
        $(document).find('input.ays_hover_effect_radio').on('click', function(){
            if($(document).find('input.ays_hover_effect_radio:checked').val() == "simple" ){
                $(document).find('.ays_effect_simple').show(500);
                $(document).find('.ays_effect_dir_aware').hide(150);
            }

            if($(document).find('input.ays_hover_effect_radio:checked').val() == "dir_aware" ){
                $(document).find('.ays_effect_simple').hide(150);
                $(document).find('.ays_effect_dir_aware').show(500);
            }
        });

        // Images loading effect --AV--
        if($(document).find('input#ays_gpg_images_lazy_loading:checked').val() == "current_loaded" ){
            $(document).find('.show_load_effect').show();
            $(document).find('.ays_hide_hr').show();
        }
        
        if($(document).find('input#ays_gpg_images_global_loading:checked').val() == "all_loaded" ){
            $(document).find('.show_load_effect').hide();
            $(document).find('.ays_hide_hr').hide();
        }

        $(document).find('label#gpg_image_lazy_loading').on('click', function(){
            $(document).find('.show_load_effect').show(500);
            $(document).find('.ays_hide_hr').show(500);
        });

        $(document).find('label#gpg_image_global_loading').on('click', function(){
            $(document).find('.show_load_effect').hide(150);
            $(document).find('.ays_hide_hr').hide(150);
        });
        // ----
        
        $(document).find('.ays-category').select2();

        $(document).find('#ays_gallery_cat').select2({
            placeholder: 'Select category'
        });

		$(document).find('#ays-view-type').select2({
			placeholder: 'Select view'
		});
		$(document).find('#gallery_img_hover_simple').select2({
			placeholder: 'Select animation'
		});
		$(document).find('#gallery_img_hover_dir_aware').select2({
			placeholder: 'Select animation'
		});
		$(document).find('.ays_gpg_border_options > select').select2({
			placeholder: 'Select border style'
		});

        $(document).find('#ays_gallery_create_author').select2({
            placeholder: gallery_ajax.selectUser,
            minimumInputLength: 1,
            allowClear: true,
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                searching: function() {
                    return gallery_ajax.searching;
                },
                inputTooShort: function () {
                    return gallery_ajax.pleaseEnterMore;
                }
            },
            ajax: {
                url: gallery_ajax.ajax_url,
                dataType: 'json',
                data: function (response) {
                    var checkedUsers = $(document).find('#ays_gallery_create_author').val();
                    return {
                        action: 'ays_gpg_author_user_search',
                        search: response.term,
                        val: checkedUsers,
                    };
                },
            }
        });
        
        $(document).find('#show_title').on('click', function(){
            if($(document).find('#show_title').prop('checked')){
                $(document).find('.show_with_date').css('display', 'inline-block');
            }else{            
                $(document).find('.show_with_date').css('display', 'none');
            }
        });
        
        $(document).find('#gpg_resp_width').on('click', function(){
            if($(document).find('#gpg_resp_width').prop('checked')){
                $(document).find('.pakel3').css('display', 'none');
                $(document).find('.bacel').css('display', 'flex');
            }else{            
                $(document).find('.pakel3').css('display', 'flex');
                $(document).find('.bacel').css('display', 'none');
            }
        });
        
        
        $(document).find('input.ays_enable_disable:checked').each(function(){
            if($(this).val() == "true" ){
                $(this).parent().parent().parent().find(".ays_hidden").show();
            }else{
                $(this).parent().parent().parent().find(".ays_hidden").hide();
            }
        });
        
        $(document).find('input.ays_enable_disable').on('click', function(){
            if($(this).parent().parent().find('input.ays_enable_disable:checked').val() == "true" ){
                $(this).parent().parent().parent().find(".ays_hidden").show(500);
            }
            if($(this).parent().parent().find('input.ays_enable_disable:checked').val() == "false" ){
                $(this).parent().parent().parent().find(".ays_hidden").hide(150);
            }
        });
        
        $(document).on('click', '#ays_gpg_images_border', function(e){
            if($(document).find('#ays_gpg_images_border').prop('checked')){
                $(document).find('.ays_gpg_border_options').css('display', "block");
            }else{
                $(document).find('.ays_gpg_border_options').css('display', "none");
            }
        });
        
        if($(document).find('#ays_gpg_images_border').prop('checked')){
            $(document).find('.ays_gpg_border_options').css('display', "block");
        }else{
            $(document).find('.ays_gpg_border_options').css('display', "none");
        }
        $(document).find('.ays_gpg_images_border_width').on('input', function(){
            if($(this).val() > 10){
                $(this).css('box-shadow', '0px 0px 5px red');
                $(this).val(10);
            }else{
                $(this).css('box-shadow', 'none');
            }
            if($(this).val() < 0){
                $(this).val(0);
                $(this).css('box-shadow', '0px 0px 5px red');
            }else{
                $(this).css('box-shadow', 'none');
            }
        });
        
		$(document).on('click', '.ays_image_add_icon', function(e){
			openMediaUploader(e, $(this), 'ays_image_add_icon');
		});
		
		$(document).on('click', '.ays_select_all_images', function(e){            
            $(document).find('.ays_del_li').prop("checked", "true");            
            if($(document).find('.ays_bulk_del_images').prop('disabled')){
                $(document).find('.ays_bulk_del_images').removeAttr('disabled');
            }
            $(this).addClass("ays_clear_images");
            $(this).removeClass("ays_select_all_images");
		});
		
		
		$(document).on('click', '.ays_clear_images', function(e){            
            $(document).find('.ays_del_li').removeAttr("checked");	
            if(!$(document).find('.ays_bulk_del_images').prop('disabled')){
                $(document).find('.ays_bulk_del_images').prop('disabled', "true");
            }
            $(this).addClass("ays_select_all_images");
            $(this).removeClass("ays_clear_images");
		});
		
		$(document).on('click', '.ays_image_edit', function(e){
			openMediaUploader(e, $(this), 'ays_image_edit');
		});
		$(document).on('click', 'ul.ays-accordion li .ays_del_li', function(e){
            if($(document).find('.ays_bulk_del_images').prop('disabled')){
                $(document).find('.ays_bulk_del_images').removeAttr('disabled');
            }
            if($(document).find('ul.ays-accordion li .ays_del_li:checked').length == 0){
                $(document).find('.ays_bulk_del_images').attr('disabled','disabled');
            }

		});

        $(document).find('#gallery_img_hover_simple').on('change', function(){
            $(document).find('.gpg_animation_demo_text').css({"animation-name": $(this).val()});
            setTimeout(function () {
                $(document).find('.gpg_animation_demo_text').css('animation-name','');                
            }, 350);
        });

        $(document).find('.ays_animation_preview').on('click', function(){
            let animationVal = $(document).find('#gallery_img_hover_simple').val();
            $(document).find('.gpg_animation_demo_text').css({"animation-name":animationVal});
            setTimeout(function () {
                $(document).find('.gpg_animation_demo_text').css('animation-name','');                
            }, 350);
        });

        $(document).find('#gallery_img_hover_dir_aware').on('change', function(){
            $(document).find('.gpg_animation_demo_dAware').removeClass('demo_slide').removeClass('demo_rotate3d');
            $(document).find('.gpg_animation_demo_dAware').addClass('demo_' + $(this).val());
            $(document).find('.gpg_animation_demo_text.ays_hover_mask').attr('style','').attr('class','gpg_animation_demo_text ays_hover_mask');
        });

        $(document)
            .find(".gpg_animation_demo_dAware")
            .hover(
                function (e) {                    
                    var admin_menu_width = parseInt($(document).find('#wpcontent').css('padding-left')) + parseInt($(document).find('#wpcontent').css('margin-left'));
                    var ays_x = (e.pageX - admin_menu_width) - this.offsetLeft;
                    var ays_y = e.pageY - this.offsetTop;                    
                    var ays_edge = ays_closestEdge(ays_x, ays_y, this.clientWidth, this.clientHeight);
                    var ays_overlay = $(this).find("div.ays_hover_mask");
                    var ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                    switch (ays_edge) {
                        case "top":
                            if ($(this).hasClass('demo_rotate3d')) {
                                ays_overlay.css("display", "flex");
                                ays_overlay.attr("class", "gpg_animation_demo_text ays_hover_mask animated in-top");
                            }else{
                                ays_overlay.css("display", "flex");
                                ays_overlay.css("animation", "slideInDown .3s");
                            }
                            break;
                        case "right":
                            if ($(this).hasClass('demo_rotate3d')) {
                                ays_overlay.css("display", "flex");
                                ays_overlay.attr("class", "gpg_animation_demo_text ays_hover_mask animated in-right");
                            }else{
                                ays_overlay.css("display", "flex");
                                ays_overlay.css("animation", "slideInRight .3s");
                            }                           
                            break;
                        case "bottom":
                            if ($(this).hasClass('demo_rotate3d')) {
                                ays_overlay.css("display", "flex");
                                ays_overlay.attr("class", "gpg_animation_demo_text ays_hover_mask animated in-bottom");
                            }else{
                                ays_overlay.css("display", "flex");
                                ays_overlay.css("animation", "slideInUp .3s");
                            }
                            break;
                        case "left":
                            if ($(this).hasClass('demo_rotate3d')) {
                                ays_overlay.css("display", "flex");
                                ays_overlay.attr("class", "gpg_animation_demo_text ays_hover_mask animated in-left");
                            }else{
                                ays_overlay.css("display", "flex");
                                ays_overlay.css("animation", "slideInLeft .3s");
                            }                            
                            break;
                    }
                },
                function (e) {
                    var admin_menu_width = parseInt($(document).find('#wpcontent').css('padding-left')) + parseInt($(document).find('#wpcontent').css('margin-left'));
                    var ays_x = (e.pageX - admin_menu_width) - this.offsetLeft;
                    var ays_y = e.pageY - this.offsetTop;
                    var ays_edge = ays_closestEdge(ays_x, ays_y, this.clientWidth, this.clientHeight);
                    var ays_overlay = $(this).find("div.ays_hover_mask");
                    var ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                    switch (ays_edge) {
                        case "top":
                            if ($(this).hasClass('demo_rotate3d')) {
                                ays_overlay.attr("class", "gpg_animation_demo_text ays_hover_mask animated out-top");
                                setTimeout(function () {
                                    ays_overlay.css("opacity", "0");
                                }, 350);
                            }else{
                                ays_overlay.css("animation", "slideOutUp .3s");
                                setTimeout(function () {
                                    ays_overlay.css("display", "none");
                                }, 250);
                            }
                            break;
                        case "right":
                            if ($(this).hasClass('demo_rotate3d')) {
                                ays_overlay.attr("class", "gpg_animation_demo_text ays_hover_mask animated out-right");
                                setTimeout(function () {
                                    ays_overlay.css("opacity", "0");
                                }, 350);
                            }else{
                                ays_overlay.css("animation", "slideOutRight .3s");
                                setTimeout(function () {
                                    ays_overlay.css("display", "none");
                                }, 250);
                            }                            
                            break;
                        case "bottom":
                            if ($(this).hasClass('demo_rotate3d')) {
                                ays_overlay.attr("class", "gpg_animation_demo_text ays_hover_mask animated out-bottom");
                                setTimeout(function () {
                                    ays_overlay.css("opacity", "0");
                                }, 350);
                            }else{
                                ays_overlay.css("animation", "slideOutDown .3s");
                                setTimeout(function () {
                                    ays_overlay.css("display", "none");
                                }, 250);
                            }                            
                            break;
                        case "left":
                            if ($(this).hasClass('demo_rotate3d')) {
                                ays_overlay.attr("class", "gpg_animation_demo_text ays_hover_mask animated out-left");
                                setTimeout(function () {
                                    ays_overlay.css("opacity", "0");
                                }, 570);
                            }else{
                                ays_overlay.css("animation", "slideOutLeft .3s");
                                setTimeout(function () {
                                    ays_overlay.css("display", "none");
                                }, 250);
                            }                            
                            break;
                    }
                }
            );            
                 
        $(document).find('#gallery_img_hover_dir_aware').on('change', function(){
            if($(this).find("option:selected").val() == "rotate3d"){
                $(document).find('input[name="ays-gpg-images-border-radius"]').val(0);
                $(document).find('input[name="ays-gpg-images-border-radius-mobile"]').val(0);
                $(document).find('input[name="ays-gpg-images-border-radius"]').prop('disabled', true);
                $(document).find('input[name="ays-gpg-images-border-radius-mobile"]').prop('disabled', true);
            }else{
                $(document).find('input[name="ays-gpg-images-border-radius"]').prop('disabled', false);
                $(document).find('input[name="ays-gpg-images-border-radius-mobile"]').prop('disabled', false);
            }
        });
        
        if( $(document).find(".ays_hover_effect_radio:checked").val() == "dir_aware" && $(document).find('#gallery_img_hover_dir_aware option:selected').val() == "rotate3d" ){
            $(document).find('input[name="ays-gpg-images-border-radius"]').val(0);
            $(document).find('input[name="ays-gpg-images-border-radius-mobile"]').val(0);
            $(document).find('input[name="ays-gpg-images-border-radius"]').prop('disabled', true);
            $(document).find('input[name="ays-gpg-images-border-radius-mobile"]').prop('disabled', true);
        }else{
            $(document).find('input[name="ays-gpg-images-border-radius"]').prop('disabled', false);
            $(document).find('input[name="ays-gpg-images-border-radius-mobile"]').prop('disabled', false);
        }        
        
		$(document).on('click', '.ays_bulk_del_images', function(e){
            let accordion = $(document).find('ul.ays-accordion'),
				accordion_el = $(document).find('ul.ays-accordion li .ays_del_li'),
				accordion_el_length = accordion_el.length;
            accordion_el.each(function(){
                if($(this).prop('checked')){
                    $(this).parents("li").css({
                        'animation-name': 'slideOutLeft',
                        'animation-duration': '.3s'
                    });
                    let a = $(this);
                    setTimeout(function(){
                        a.parents('li').remove();
                    }, 300);
                }
            });
            setTimeout(function(){
                if($(document).find('ul.ays-accordion li').length == 0){
                    $(document).find('div.ays_admin_pages').remove();
                }
            }, 310);
            $(document).find('.ays_bulk_del_images').attr('disabled','disabled');
		});
		

		/*$(document).find('.ays-add-images').on('click', function(e){

            e.preventDefault();
			let accordion = $(document).find('ul.ays-accordion'),
				accordion_el = $(document).find('ul.ays-accordion li'),
				accordion_el_length = accordion_el.length,
                ays_title_tooltip = $(document).find("#ays_image_lang_title").val(),
                ays_alt_tooltip = $(document).find("#ays_image_lang_alt").val(),
                ays_desc_tooltip = $(document).find("#ays_image_lang_desc").val(),
                ays_url_tooltip = $(document).find("#ays_image_lang_url").val(),
                noimage_path = $(document).find('#noimage_path').val();
                if(accordion.length > 1){
                    accordion = $(document).find('ul.ays-accordion.ays_accordion_active');
                }
				let newLi = '<li>' +
                    '           <input type="hidden" name="ays-image-path[]">' +
					'			<div class="ays-image-attributes">' +
                    '               <div class="ays-move-images_div"><i class="ays-move-images"></i></div>' +
                    '               <div class="ays_image_div">' +
                    '                   <div class="ays_image_add_div">' +
                    '                       <span class="ays_ays_img"></span>' +
                    '                       <div class="ays_image_add_icon"><i class="ays-upload-btn"></i></div>' +
                    '                   </div>' +
                    '                   <div class="ays_image_thumb" style="display: none;">' +
                    '                       <div class="ays_image_edit_div"><i class="ays_image_edit"></i></div>' +
                    '                       <div class="ays_image_thumb_img"><img></div>' +                    
                    '                   </div>' +
                    '               </div>' + 
                    '               <div class="ays_image_attr_item_cat">' +
                    '                    <div class="ays_image_attr_item_parent">' +
                    '                       <div class="ays_image_attr_item">' +
                    '                   <label>Image title'+
                    '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_title_tooltip+'">'+
                    '                       <i class="fas fa-info-circle"></i>'+
                    '                    </a></label>' +
					'	                <input class="ays_img_title" type="text" name="ays-image-title[]" placeholder="Image title"/>' +
                    '                   </div>' +
                    '                   <div class="ays_image_attr_item">' +
                    '                   <label>Image alt'+
                    '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_alt_tooltip+'">'+
                    '                       <i class="fas fa-info-circle"></i>'+
                    '                    </a></label>' +
                    '                   <input class="ays_img_alt" type="text" name="ays-image-alt[]" placeholder="Image alt"/>' +
                    '                   </div>' +
                    '                   <div class="ays_image_attr_item">' +
                    '                   <label>Image description'+
                    '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_desc_tooltip+'">'+
                    '                       <i class="fas fa-info-circle"></i>'+
                    '                    </a></label>' +
                    '                   <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="Image description"/>' +
                    '                   </div>' +
                    '                   <div class="ays_image_attr_item">' +
                    '                   <label>URL'+
                    '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_url_tooltip+'">'+
                    '                       <i class="fas fa-info-circle"></i>'+
                    '                    </a></label>' +
                    '                   <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="URL"/>' +
                    '                   </div>' +
                    '               </div>' +

                    '               <input type="hidden" name="ays-image-date[]" class="ays_img_date"/>' +
                    '               <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>'+
                    '               <div class="ays-delete-image_div"><i class="ays-delete-image"></i></div>' +
					'           </div>' +                    
					'         </li>';

				accordion.prepend(newLi);
                $('[data-toggle="tooltip"]').tooltip();
		});*/


        $('.open-lightbox').on('click', function (e) {
            e.preventDefault();
            var image = $(this).attr('href');
            $('html').addClass('no-scroll');
            $('.ays-gpg-row ').append('<div class="lightbox-opened"><img src="' + image + '"></div>');
        });

        $('body').on('click', '.lightbox-opened', function () {
            $('html').removeClass('no-scroll');
            $('.lightbox-opened').remove();
        });
        
        $(document).find('ul.ays-accordion').sortable({
            handle: '.ays-move-images',
			axis: 'y',
			opacity: 0.8,
			placeholder: 'clone',
            cursor: 'move'
        });

		$(document).on('click', '.ays-delete-image', function(){
            $(this).parent().parent().parent().css({
                'animation-name': 'slideOutLeft',
                'animation-duration': '.3s'
            });
            var a = $(this);
            setTimeout(function(){
                a.parent().parent().parent().remove();
            }, 300);
		});

        $(document).on('click', '.delete a[href]', function(){
            return confirm('Do you want to delete?');
        });

        function openMediaUploader(e,element, where){
            e.preventDefault();
            let aysGalleryUploader = wp.media.frames.items = wp.media({
                title: 'Upload image',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: ['image']
                },
                multiple: false,
                frame: 'select',
            }).on('select', function(e){
				if(where == 'ays_image_add_icon'){
                    var state = aysGalleryUploader.state();
                    var selection = selection || state.get('selection');
                    if (! selection) return;
                    
                    var attachment = selection.first();
                    var display = state.display(attachment).toJSON();
                    attachment = attachment.toJSON();
                    
                    var d = new Date()
                    var date = d.getTime();
                    date = Math.floor(date/1000);

                    var imgurl = attachment.url;

                    if (attachment.sizes.thumbnail != undefined) {
                        var thumbnail_imgurl = attachment.sizes['thumbnail'].url;
                    }else{
                        var thumbnail_imgurl = attachment.sizes['full'].url;
                    }

					element.parent().parent().children('.ays_image_thumb').children('.ays_image_thumb_img').children('img').attr('src', thumbnail_imgurl);
                    element.parent().parent().children('.ays_image_thumb').css({'display':'block','position':'relative'});//av
					element.parent().parent().children('.ays_image_thumb').children('.ays_image_edit_div').css('position','absolute');//av
                    element.parent().parent().parent().parent().children('input[type="hidden"]').val(imgurl);                    
                    element.parent().parent().parent().find('.ays_img_title').val(attachment.title);
                    element.parent().parent().parent().find('.ays_img_alt').val(attachment.title);
                    element.parent().parent().parent().find('.ays_img_date').val(date);
					element.parent().parent().children('.ays_image_add_div').remove();   

				}else{
					if(where == 'ays_image_edit'){	
                        var state = aysGalleryUploader.state();
                        var selection = selection || state.get('selection');
                        if (! selection) return;

                        var attachment = selection.first();
                        var display = state.display(attachment).toJSON();

                        attachment = attachment.toJSON();
                        
                        var d = new Date()
                        var date = d.getTime();
                        date = Math.floor(date/1000);

                        var imgurl = attachment.url;

                        if ( attachment.sizes.thumbnail != undefined ) {
                            var thumbnail_imgurl = attachment.sizes['thumbnail'].url;
                        }else{
                            var thumbnail_imgurl = attachment.sizes['full'].url;
                        }                        

						element.parent().parent().children('.ays_image_thumb_img').children('img').attr('src', thumbnail_imgurl);
						element.parent().parent().parent().parent().parent().children('input[type="hidden"]').val(imgurl);
                        element.parent().parent().parent().parent().children('.ays_image_attr_item').find('.ays_img_title').val(attachment.title);
                        element.parent().parent().parent().parent().children('.ays_image_attr_item').find('.ays_img_alt').val(attachment.title);
                        element.parent().parent().parent().parent().find('.ays_img_date').val(date);
					    element.parent().parent().children('ays_image_thumb_img').children('img').css('background-image', 'none');
                        
					}
				}
			}).open();
            return false;

        }
        
        function openMediaUploader_forVideo(e,element){
            e.preventDefault();
            let aysUploader = wp.media.frames.aysUploader = wp.media({
                title: 'Upload video',
                button: {
                    text: 'Upload'
                },
                multiple: false,
                library: {
                    type: ['video']
                },
                frame:    "video",
                state:    "video-details"
            }).on('select', function() {
                var state = aysUploader.state();
                var selection = selection || state.get('selection');
                if (! selection) return;

                var attachment = selection.first();
                var display = state.display(selection).toJSON();

                var attachment = selection.toJSON();
			}).open();
            return;
        }

        function create_submit_name(e){
            var submit_name = $(document).find('#ays_submit_name');
            var element_type = e.target.getAttribute('gpg_submit_name');
            if (element_type !== null) {
                submit_name.attr('name', element_type);
            }
        }

        function create_select_category_name(e,element){
            e.preventDefault();
            var sel_cat_val = '';
            var sel_cat = $(document).find('select.ays-category');
            sel_cat.each(function(){
                if ($(this).val() !== null) {
                    sel_cat_val = $(this).val().join();
                }else{
                    sel_cat_val = '';
                }

                var select_name =  $(this).parent().find('.for_select_name');
                select_name.val(sel_cat_val);
            });
            
            $(document).find("#ays-gpg-form")[0].submit();
        }

        function openMediaUploader_forMultiple(e,element){
            e.preventDefault();
            let aysUploader = wp.media.frames.aysUploader = wp.media({
                title: 'Upload images',
                button: {
                    text: 'Upload'
                },
                multiple: true,
                library: {
                    type: ['image']
                },
                frame:    "select"
            }).on('select', function() {
                var state = aysUploader.state();
                var selection = selection || state.get('selection');
                if (! selection) return;

                var attachment = selection.first();
                var display = state.display(selection).toJSON();

                var attachment = selection.toJSON();
                var d = new Date()
                var date = d.getTime();
                date = Math.floor(date/1000);

                for(let i=0; i<attachment.length; i++){
                    let accordion = $(document).find('ul.ays-accordion'),
                    accordion_el = $(document).find('ul.ays-accordion li'),
                    ays_title_tooltip = $(document).find("#ays_image_lang_title").val(),
                    ays_alt_tooltip = $(document).find("#ays_image_lang_alt").val(),
                    ays_desc_tooltip = $(document).find("#ays_image_lang_desc").val(),
                    ays_url_tooltip = $(document).find("#ays_image_lang_url").val(),
                    ays_img_cat_tooltip = $(document).find("#ays_image_cat").val(),
                    accordion_el_length = accordion_el.length;
                        if(accordion.length > 1){
                            accordion = $(document).find('ul.ays-accordion.ays_accordion_active');
                        }
                        let newListImage = '<li class="ays-accordion_li">' +
                        '           <input type="hidden" name="ays-image-path[]" value="'+attachment[i].url+'">' +
                        '           <div class="ays-image-attributes">' +
                        '               <div class="ays-move-images_div"><i class="ays-move-images"></i></div>' +
                        '               <div class="ays_image_div">' +                        
                        '                   <div class="ays_image_thumb" style="display: block; position: relative;">' +
                        '                       <div class="ays_image_edit_div" style="position: absolute;"><i class="ays_image_edit"></i></div>' +
                        '                       <div class="ays_image_thumb_img"><img class="ays_ays_img" alt="" src="'+attachment[i].url+'"></div>' +                    
                        '                   </div>' +
                        '               </div>' + 
                        '               <div class="ays_image_attr_item_cat">' +
                            '               <div class="ays_image_attr_item_parent">' +
                            '                   <div class="ays_image_attr_item">' +
                        '                   <label>Title'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_title_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <input class="ays_img_title" type="text" name="ays-image-title[]" value="'+(attachment[i].title)+'" placeholder="Image title"/>' +
                        '               </div>' +
                        '               <div class="ays_image_attr_item">' +
                        '                   <label>Alt'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_alt_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <input class="ays_img_alt" type="text" name="ays-image-alt[]" value="'+(attachment[i].title)+'" placeholder="Image alt"/>' +
                        '               </div>' +
                        '               <div class="ays_image_attr_item">' +
                        '                   <label>Description'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_desc_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <input class="ays_img_desc" type="text" name="ays-image-description[]" placeholder="Image description"/>' +
                        '               </div>' +
                        '               <div class="ays_image_attr_item">' +
                        '                   <label>URL'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_url_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <input class="ays_img_url" type="url" name="ays-image-url[]" placeholder="URL"/>' +
                        '                   </div>' +
                        '               </div>' +
                        '               <div class="ays_image_cat">' +
                        '                   <label>Image Category'+
                        '                    <a class="ays_help" data-toggle="tooltip" title="'+ays_img_cat_tooltip+'">'+
                        '                       <i class="fas fa-info-circle"></i>'+
                        '                    </a></label>' +
                        '                   <select class="ays-category form-control" multiple="multiple">';
                        
                            for (var j = 0; j < ays_gpg_admin['categories'].length; j++) {
                                newListImage += '<option value="'+ays_gpg_admin['categories'][j]['id']+'">'+ays_gpg_admin['categories'][j]['title']+'</option>';
                            }

                        newListImage +='</select>' +
                        '<input type="hidden" class="for_select_name" name="ays_gallery_category[]">' +
                        '                </div>' +
                        '           </div>' +
                        '               <input type="hidden" name="ays-image-date[]" class="ays_img_date" value="'+(date)+'"/>' +
                        '               <div class="ays_del_li_div"><input type="checkbox" class="ays_del_li"/></div>'+
                        '               <div class="ays-delete-image_div"><i class="ays-delete-image"></i></div>' +
                        '           </div>' +
                        '         </li>';

                        accordion.prepend(newListImage);
                        $(document).find('.ays-category').select2();
                        $('[data-toggle="tooltip"]').tooltip();
                }
			}).open();
            return;

        }
        if($(document).find('input.ays-view-type:checked').val() == "grid" || 
           $(document).find('input.ays-view-type:checked').val() == "masonry"){
            $(document).find('#ays-columns-count').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
        }else{
            $(document).find('#ays-columns-count').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
            setTimeout(function(){ $(document).find('#ays-columns-count').css({'display': 'none'}); }, 480);

        }

        if($(document).find('input.ays-view-type:checked').val() == "grid"){
            if($(document).find('#gpg_resp_width').prop('checked')){
                $(document).find('#ays_height_width_ratio').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
            }else{
                $(document).find('#ays-thumb-height').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
            }
            
            $(document).find('#ays_gpg_resp_width').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
        }else{
            $(document).find('#ays-thumb-height').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
            $(document).find('#ays_height_width_ratio').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
            $(document).find('#ays_gpg_resp_width').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
            setTimeout(function(){ $(document).find('#ays-thumb-height').css({'display': 'none'}); }, 480);
            setTimeout(function(){ $(document).find('#ays_height_width_ratio').css({'display': 'none'}); }, 480);
            setTimeout(function(){ $(document).find('#ays_gpg_resp_width').css({'display': 'none'}); }, 480);
        }        
        
        if($(document).find('input.ays-view-type:checked').val() == 'masonry'){
            $(document).find('.ays_hover_effect_radio_simple').prop('checked', true);
            $(document).find('.ays_hover_effect_radio_dir_aware').removeProp('checked');
            $(document).find('.ays_effect_simple').show(500);
            $(document).find('.ays_effect_dir_aware').hide(150);                    
            $(document).find('.ays_hover_effect_radio_dir_aware').prop('disabled', true);
            $(document).find('.ays_hover_effect_radio_dir_aware').parent().css('color', '#ccc');
        }
        $(document).find('a[data-tab="tab2"]').on('click', function(){
            if($(this).find('span.badge').length > 0){
                $(this).find('span.badge').remove();
                $(document).find('#ays-columns-count')[0].scrollIntoView({block: "center", behavior: "smooth"});
            }
        });
        
        $(document).find('input.ays-view-type').on('click', function(){
            if($(document).find('input.ays-view-type:checked').val() == "grid" || 
               $(document).find('input.ays-view-type:checked').val() == "masonry"){
                $(document).find('#ays-columns-count').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});                
            }else{
                $(document).find('#ays-columns-count').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
                setTimeout(function(){ $(document).find('#ays-columns-count').css({'display': 'none'}); }, 480);
            }

            if($(document).find('input.ays-view-type:checked').val() == "grid" ){
                if($(document).find('#gpg_resp_width').prop('checked')){
                    $(document).find('#ays_height_width_ratio').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
                }else{
                    $(document).find('#ays-thumb-height').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
                }
                $(document).find('#ays_gpg_resp_width').css({'display': 'flex', 'animation-name': 'fadeIn', 'animation-duration': '.5s'});
                // $(document).find('#ays-columns-count + hr').css({'display': 'block'});
                $(document).find('.hr_pakel').css({'display': 'block'});
            }else{
                $(document).find('#ays-thumb-height').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
                $(document).find('#ays_height_width_ratio').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
                $(document).find('#ays_gpg_resp_width').css({ 'animation-name': 'fadeOut', 'animation-duration': '.5s'});
                setTimeout(function(){ $(document).find('#ays-thumb-height').css({'display': 'none'}); }, 480);
                setTimeout(function(){ $(document).find('#ays_height_width_ratio').css({'display': 'none'}); }, 480);
                setTimeout(function(){ $(document).find('#ays_gpg_resp_width').css({'display': 'none'}); }, 480);
                $(document).find('.hr_pakel').css({'display': 'none'});
            }

            if($(document).find('input.ays-view-type:checked').val() == "mosaic"){
                $(document).find('#ays-columns-count + hr').css({'display': 'none'});
                $(document).find('.pakel').css({'display': 'none'});
            }else{
                $(document).find('#ays-columns-count + hr').css({'display': 'block'});
                $(document).find('.pakel').css({'display': 'block'});            
            }
            
            if($(document).find('input.ays-view-type:checked').val() == "masonry" ){
                $(document).find('.ays_hover_effect_radio_simple').prop('checked', true);
                $(document).find('.ays_hover_effect_radio_dir_aware').removeProp('checked');
                $(document).find('.ays_effect_simple').show(500);
                $(document).find('.ays_effect_dir_aware').hide(150);
                $(document).find('.ays_hover_effect_radio_dir_aware').prop('disabled', true);
                $(document).find('.ays_hover_effect_radio_dir_aware').parent().css('color', '#ccc');
                // $(document).find('#ays-columns-count + hr').css({'display': 'none'});
            }else{
                $(document).find('.ays_hover_effect_radio_dir_aware').prop("disabled", false);
                $(document).find('.ays_hover_effect_radio_dir_aware').parent().css('color', '#000');
            }
        });
        
        $('[data-toggle="tooltip"]').tooltip();
        
        $(document).on('click', '.ays_live_preview_close', function(){
            $(document.body).css('overflow', 'auto');
            $(document).find('div.ays_gallery_live_preview_popup').css({
                animation: 'fadeOut .5s'
            });
            setTimeout(function(){
                $(document).find('div.ays_gallery_live_preview_popup').css({
                    display: 'none'
                });
            },450);
        });
        $(document).on('click', '.ays_gallery_live_preview', function(){
            
            $(document.body).css('overflow', 'hidden');
            var ays_gallery_containers = document.getElementsByClassName('ays_gallery_container');
            var ays_gallery_container;
            
            for(var ays_i = 0; ays_i < ays_gallery_containers.length; ays_i++){
               do{
                    ays_gallery_container = ays_gallery_containers[ays_i].parentElement.parentElement;
                   if(ays_gallery_container.style.position === 'relative'){
                       ays_gallery_container.style.position = 'static';
                   }
                }
                while(ays_gallery_container.tagName == 'body');
                
            }
            
            let popup_view = $(document).find('div.ays_gallery_live_preview_popup .ays_gallery_container'),
                accordion_el = $(document).find('ul.ays-accordion li.ays-accordion_li'),
                accordion_el_length = accordion_el.length,
                ays_admin_url = $(document).find('#ays_gpg_admin_url').val(),
                noimage_path = $(document).find('#noimage_path').val(),
                gallery_title = $(document).find('#gallery_title').val(),
                gallery_desc = $(document).find('#gallery_description').val(),
                gallery_title_show = $(document).find('input[name="ays_gpg_title_show"]').prop('checked'),
                gallery_desc_show = $(document).find('input[name="ays_gpg_desc_show"]').prop('checked');
            let view_type = $(document).find('input.ays-view-type:checked').val(),
                column_count = $(document).find('input[name="ays-columns-count"]').val(),
                type_class, type_column_class, type_mosaic_class, type_masonry_class, $hover_icon, $ays_gpg_lazy_load, $columns, 
                $show_with_date = $(document).find("#show_with_date").prop('checked'), $show_title_in_hover, $ays_show_title,
                $ays_show_with_date, $show_title_on = $(document).find('.ays_gpg_show_title_on:checked').first().val(),
                $show_title = $(document).find('#show_title').prop('checked'),
                $ays_hover_icon = $(document).find('input[name="ays-gpg-image-hover-icon"]:checked').first().val(),
                $images_loading = $(document).find('input[name="ays_images_loading"]:checked').first().val(),
                $images_path = $(document).find('input[name="ays-image-path[]"]'),
                $images_title = $(document).find('input[name="ays-image-title[]"]'),
                $images_desc = $(document).find('input[name="ays-image-description[]"]'),
                $images_alt = $(document).find('input[name="ays-image-alt[]"]'),
                $images_url = $(document).find('input[name="ays-image-url[]"]'),
                $hover_effect = $(document).find('#gallery_img_hover_simple').val(),
                $hover_out_effect, $image_dates = $(document).find('.ays_img_date'),
                $images_distance = $(document).find('input[name="ays-gpg-images-distance"]').val(),
                $hover_zoom = $(document).find('input[name="ays_gpg_hover_zoom"]:checked').first().val(),
                $hover_opacity = $(document).find('.gpg_opacity_demo_val').val(),
                $images_border_radius = $(document).find('input[name="ays-gpg-images-border-radius"]').val(),
                $ays_images_hover_dir_aware = $(document).find('#gallery_img_hover_dir_aware').val(),
                $ays_images_hover_effect = $(document).find('input[name="ays_images_hover_effect"]:checked').val(),
                $ays_gpg_loader = $(document).find('input[name="ays_gpg_loader"]:checked'),
                $gallery_width = $(document).find('#gallery_width').val();
                if($gallery_width == 0 || $gallery_width == NaN || $gallery_width == null || $gallery_width == false){
                    $gallery_width = "90%";
                }
                popup_view.css('width',$gallery_width);
            
                $hover_out_effect = $hover_effect.split('');
                $hover_out_effect.splice($hover_out_effect.indexOf('I'),2,"O",'u','t');
                $hover_out_effect = $hover_out_effect.join('');
            if (column_count == 0) {
                column_count = 3;
            }
            $columns = 100 / column_count;
            if($images_loading == 'all_loaded'){
                let $ays_images_all_loaded;                
                $ays_images_all_loaded = "<div class='gpg_loader'>"+$ays_gpg_loader.next()[0].outerHTML+"</div>";
                $(document).find('.ays_gallery_live_preview_popup').prepend($ays_images_all_loaded);
            }
            switch(view_type){
                case 'grid':
                    type_class = 'ays_grid_row';
                    type_column_class = 'ays_grid_column';
                    break;
                case 'mosaic':                        
                    type_class = 'mosaic';
                    type_mosaic_class = 'item withImage ';
                    type_column_class = 'ays_mosaic_column_item';
                    break;
                case 'masonry':                        
                    type_class = 'ays_masonry_grid';
                    type_masonry_class = 'ays_masonry_grid-item ';
                    type_column_class = 'ays_masonry_item';
                    break;
            }            
            switch($ays_hover_icon){
                case 'none':
                    $hover_icon = "";
                    break;
                case 'search_plus':
                    $hover_icon = "<i class='fas fa-search-plus'></i>";
                    break;
                case 'search':
                    $hover_icon = "<i class='fas fa-search'></i>";
                    break;
                case 'plus':
                    $hover_icon = "<i class='fas fa-plus'></i>";
                    break;
                case 'plus_circle':
                    $hover_icon = "<i class='fas fa-plus-circle'></i>";
                    break;
                case 'plus_square_fas': 
                    $hover_icon = "<i class='fas fa-plus-square'></i>";
                    break;
                case 'plus_square_far':
                    $hover_icon = "<i class='far fa-plus-square'></i>";
                    break;
                case 'expand':
                    $hover_icon = "<i class='fas fa-expand'></i>";
                    break;
                case 'image_fas':
                    $hover_icon = "<i class='fas fa-image'></i>";
                    break;
                case 'image_far':
                    $hover_icon = "<i class='far fa-image'></i>";
                    break;
                case 'images_fas':
                    $hover_icon = "<i class='fas fa-images'></i>";
                    break;
                case 'images_far':
                    $hover_icon = "<i class='far fa-images'></i>";
                    break;
                case 'eye_fas':
                    $hover_icon = "<i class='fas fa-eye'></i>";
                    break;
                case 'eye_far':
                    $hover_icon = "<i class='far fa-eye'></i>";
                    break;
                case 'camera_retro':
                    $hover_icon = "<i class='fas fa-camera-retro'></i>";
                    break;
                case 'camera':
                    $hover_icon = "<i class='fas fa-camera'></i>";
                    break;
                default:
                    $hover_icon = "<i class='fas fa-search-plus'></i>";
                    break;
            }
            if(view_type == 'mosaic'){
                var mosaic_clear = "style='clear:both;'";
            }else{
                var mosaic_clear = "";
            }
            let ays_popup_view = "<div class='"+type_class+"' "+mosaic_clear+">";
            for(let i = 0; i < accordion_el_length; i++){
                if($show_title){
                    if($show_with_date){
                        let iamgeDate = new Date(null);
                        iamgeDate.setTime(parseInt($image_dates[i].value)*1000);
                        $ays_show_with_date = "<span>"+iamgeDate.toLocaleString()+"</span>";
                    }else{
                        $ays_show_with_date = "";
                    }
                    $ays_show_title = "<div class='ays_image_title'><span>"+$images_title[i].value+"</span>"+$ays_show_with_date+"</div>";
                }else{
                    $ays_show_title = '';
                }
                if($images_url[i].value == ""){
                    var $images_url_i = "";
                }else{
                    var $images_url_i = "<button type='button' class='ays_image_url'><i class='fas fa-link'></i></button>";
                }
                
                
                if($show_title_on == 'gallery_image'){
                    $show_title_in_hover = "<div class='ays_hover_mask animated'><div>"+$hover_icon+$images_url_i+"</div></div>"+$ays_show_title;
                }else{
                    if($show_title_on == 'image_hover'){
                        $show_title_in_hover = "<div class='ays_hover_mask animated'><div>"+$hover_icon+$images_url_i+"</div> "+$ays_show_title+"</div>";
                    }
                }
                
                if(view_type == 'grid' || view_type == 'masonry'){
                    var grid_column_width = "width: "+($columns-2)+"%;";
                    var masonry_column_margin = "margin-bottom: "+(parseInt($images_distance))+"px;";
                }else{
                    var grid_column_width = "";
                    var masonry_column_margin = "";
                }

                if ($images_path[i].value === '') {
                    $images_path[i].value = ays_admin_url+"images/no-photo.png";
                }
                
                let newColumn = "<div class='"+type_mosaic_class+" "+type_masonry_class+" "+type_column_class+"' style='border-radius:"+$images_border_radius+"px; "+grid_column_width+"; "+masonry_column_margin+"'><a href='javascript:void(0);'><div class='ays_image_loading_div'><img src='"+ays_admin_url+"images/flower.svg'></div><img src='"+$images_path[i].value+"' alt='"+$images_alt[i].value+"' title='"+$images_title[i].value+"'/>"+$show_title_in_hover+"</a></div>";
                ays_popup_view += newColumn;
            }
            ays_popup_view += "</div>";
            if(gallery_title_show){
                var show_gallery_title = "<h2 class='ays_gallery_title'>"+gallery_title+"</h2>";
            }else{
                var show_gallery_title = '';
            }
            if(gallery_desc_show){
                var show_gallery_desc = "<h4 class='ays_gallery_description'>"+gallery_desc+"</h4>";
            }else{
                var show_gallery_desc = '';
            }
            let ays_gallery_header = "<div class='ays_gallery_header'>"+show_gallery_title+" "+show_gallery_desc+"</div>";
            popup_view.html(ays_gallery_header);
            popup_view.append(ays_popup_view);
            
            if($ays_images_hover_effect == "simple"){
                $(document).find('.'+type_column_class).hover(function(){
                    $(this).find('.ays_hover_mask').css('animation-name', $hover_effect);
                    $(this).find('.ays_hover_mask').css('animation-duration', '.5s');
                    if($hover_zoom == 'yes'){
                        $(this).find('a > img').css('transform', 'scale(1.15)');
                    }
                }, 
                function(){
                    $(this).find('.ays_hover_mask').css('animation-name', $hover_out_effect);
                    $(this).find('.ays_hover_mask').css('animation-duration', '.5s');                
                    if($hover_zoom == 'yes'){
                        $(this).find('a > img').css('transform', 'scale(1)');
                    }
                });
            }else{
            if($ays_images_hover_effect == "dir_aware"){
                if($ays_images_hover_dir_aware == "slide"){
                    $(document).find('.'+type_column_class).hover(function(e){
                        var ays_overlay = $(this).find('.ays_hover_mask');
                        let ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                        switch(parseInt(ays_hover_dir)) {
                             case 0:
                                ays_overlay.css('display', 'flex');
                                ays_overlay.css('animation', 'slideInDown .3s');
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1.15)');
                                }
                             break;
                             case 1:
                                ays_overlay.css('display', 'flex')
                                ays_overlay.css('animation', 'slideInRight .3s');
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1.15)');
                                }
                             break;
                             case 2:
                                ays_overlay.css('display', 'flex')
                                ays_overlay.css('animation', 'slideInUp .3s');
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1.15)');
                                }
                             break;
                             case 3:
                                ays_overlay.css('display', 'flex')
                                ays_overlay.css('animation', 'slideInLeft .3s');
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1.15)');
                                }
                             break;
                        }

                    },
                   function(e){
                        var ays_overlay = $(this).find('.ays_hover_mask');
                        let ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                        switch(parseInt(ays_hover_dir)) {
                             case 0:
                                ays_overlay.css('animation', 'slideOutUp .3s');
                                setTimeout( function(){ ays_overlay.css('display', 'none');}, 250);
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1)');
                                }
                             break;
                             case 1:
                                ays_overlay.css('animation', 'slideOutRight .3s');
                                setTimeout( function(){ ays_overlay.css('display', 'none');}, 250);
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1)');
                                }
                             break;
                             case 2:
                                ays_overlay.css('animation', 'slideOutDown .3s');
                                setTimeout( function(){ ays_overlay.css('display', 'none');}, 250);
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1)');
                                }
                             break;
                             case 3:
                                ays_overlay.css('animation', 'slideOutLeft .3s');
                                setTimeout( function(){ ays_overlay.css('display', 'none'); }, 250)
                                if($hover_zoom == 'yes'){
                                    $(this).find('a > img').css('transform', 'scale(1)');
                                }
                             break;
                        }
                    });
                }else{
                    if($ays_images_hover_dir_aware == "rotate3d"){
                        $(document).find('.'+type_column_class).hover(function(e){
                            let ays_overlay = $(this).find('div.ays_hover_mask');
                            let ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                            switch(parseInt(ays_hover_dir)) {
                                 case 0:
                                    ays_overlay.css('display', 'flex');
                                    ays_overlay.attr('class', 'ays_hover_mask animated in-top');
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1.15)');
                                    }
                                 break;
                                 case 1:
                                    ays_overlay.css('display', 'flex')
                                    ays_overlay.attr('class', 'ays_hover_mask animated in-right');
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1.15)');
                                    }
                                 break;
                                 case 2:
                                    ays_overlay.css('display', 'flex')
                                    ays_overlay.attr('class', 'ays_hover_mask animated in-bottom');
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1.15)');
                                    }
                                 break;
                                 case 3:
                                    ays_overlay.css('display', 'flex')
                                    ays_overlay.attr('class', 'ays_hover_mask animated in-left');
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1.15)');
                                    }
                                 break;
                            }

                        },
                       function(e){
                            let ays_overlay = $(this).find('div.ays_hover_mask');
                            let ays_hover_dir = ays_getDirectionKey(e, e.currentTarget);
                            switch(parseInt(ays_hover_dir)) {
                                 case 0:
                                    ays_overlay.attr('class', 'ays_hover_mask animated out-top');
                                    setTimeout( function(){ ays_overlay.css('opacity', '0');}, 350);
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1)');
                                    }
                                 break;
                                 case 1:
                                    ays_overlay.attr('class', 'ays_hover_mask animated out-right');
                                    setTimeout( function(){ ays_overlay.css('opacity', '0');}, 350);
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1)');
                                    }
                                 break;
                                 case 2:
                                    ays_overlay.attr('class', 'ays_hover_mask animated out-bottom');
                                    setTimeout( function(){ ays_overlay.css('opacity', '0');}, 350);
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1)');
                                    }
                                 break;
                                 case 3:
                                    ays_overlay.attr('class', 'ays_hover_mask animated out-left');
                                    setTimeout( function(){ ays_overlay.css('opacity', '0'); }, 570);
                                    if($hover_zoom == 'yes'){
                                        $(this).find('a > img').css('transform', 'scale(1)');
                                    }
                                 break;
                            }
                        });
                    }
                }
            }
            }
            
            $(document).find('.ays_gallery_container .mosaic').Mosaic({
                innerGap: parseInt($images_distance)
            });
            
            var aysgrid = $(document).find('.ays_masonry_grid').masonry({
                percentPosition: false,
                itemSelector: '.ays_masonry_grid-item',
                columnWidth: '.ays_masonry_item',
                transitionDuration: '1s',
                gutter: parseInt($images_distance)

            });
            
            $(document).find('.ays_hover_mask').css('background-color', 'rgba(0,0,0,'+$hover_opacity+')');
            
            $(document).find('.gpg_loader').css({'display': 'flex', 'animation-name': 'fadeIn'});
            if($images_loading == 'all_loaded'){
                $(document).find('.gpg_loader').css({'display': 'flex', 'animation-name': 'fadeIn'});
                $('.ays_gallery_container').css({'display': 'none'});
                var ays_duration = Math.floor(Math.random()*1000)+700;
                setTimeout(function(){
                    $('.ays_gallery_container').css({'display': 'block', 'animation-name': 'fadeIn'});
                    $(document).find('.gpg_loader').css({'display': 'none', 'animation-name': 'fadeOut'});
                    $(document).find('.ays_gallery_container .mosaic').Mosaic({
                        innerGap: parseInt($images_distance)
                    });
                    aysgrid.masonry('layout');
                },ays_duration);
            }
            if($images_loading == 'current_loaded'){
                $(document).find('.ays_gallery_container a > img').each( function( instance, image ) {
                    var ays_duration = Math.floor(Math.random()*2000)+700;
                    setTimeout(function(){
                        $(image).parent().find('.ays_image_loading_div').css({
                            'opacity': '1',
                            'animation-name': 'fadeOut',
                            'animation-duration': '1.2s',
                        });
                        setTimeout(function(){                                    
                            $(image).parent().find('.ays_image_loading_div').css({
                                'display': 'none'
                            });                                  
                            $(image).parent().find('div.ays_hover_mask').css({
                                'display': 'flex'
                            });
                            $(image).css({
                                'opacity': '1',
                                'display': 'block',
                                'animation': 'fadeInUp .5s',
                                'z-index': 10000,
                            });
                        },400);
                        
                        $(document).find('.ays_gallery_container .mosaic').Mosaic({
                            innerGap: parseInt($images_distance)
                        });
                        aysgrid.masonry('layout');
                    }, ays_duration);
                });
            }else{
                $(document).find('.ays_image_loading_div').css({
                    'display': 'none',
                });
            }
            
            $(document).find('div.ays_gallery_live_preview_popup').css({
                display: 'block',
                animation: 'fadeIn .5s'
            });
            $(document).find('.ays_gallery_container .mosaic').Mosaic({
                innerGap: parseInt($images_distance)
            });
        });

        var toggle_ddmenu = $(document).find('.toggle_ddmenu');
        toggle_ddmenu.on('click', function () {
            var ddmenu = $(this).next();
            var state = ddmenu.attr('data-expanded');
            
            switch (state) {
                case 'true':
                    $(this).find('i.ays_fa_ellipsis_h').css({
                        transform: 'rotate(0deg)'
                    });
                    ddmenu.attr('data-expanded', 'false');
                    break;
                case 'false':
                    $(this).find('i.ays_fa_ellipsis_h').css({
                        transform: 'rotate(90deg)'
                    });
                    ddmenu.attr('data-expanded', 'true');
                    break;
            }
        });

        $(document).keydown(function(event) {
            var editButton = $(document).find("input#ays-button-top-apply , input#ays_apply");
            if (!(event.which == 83 && event.ctrlKey) && !(event.which == 19)){
                return true;  
            }
            editButton.trigger("click");
            event.preventDefault();
            return false;
        });
    
    });

        // Gallery form submit
        // Checking the issues
        $(document).find('#ays-gpg-category-form').on('submit', function(e){
            
            if($(document).find('#ays-gpg-title').val() == ''){
                $(document).find('#ays-gpg-title').val('Gallery').trigger('input');
            }
            var $this = $(this)[0];
            if($(document).find('#ays-gpg-title').val() != ""){
                $this.submit();
            }else{
                e.preventDefault();
                $this.submit();
            }
        });

        var heart_interval = setInterval(function () {
            $(document).find('.ays_heart_beat i.far').toggleClass('pulse');
        }, 1000);

        $(document).find('#ays_filter_cat').on('click',function(){
            var cat_filter_checked = $(document).find('#ays_filter_cat').prop('checked');
            if(cat_filter_checked){
                $(document).find('#ays_gpg_dilter_cat_animation').css({'display':'flex'});
                $(document).find('.ays_gpg_show_hide_anim_hr').css({'display':'block'});
            }else{
                $(document).find('#ays_gpg_dilter_cat_animation').css({'display':'none'});
                $(document).find('.ays_gpg_show_hide_anim_hr').css({'display':'none'});
            }
        });

        $(document).find('strong.ays-gallery-shortcode-box').on('mouseleave', function(){
            var _this = $(this);

            _this.attr( 'data-original-title', galleryLangObj.clickForCopy );
        });

        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function (e) {
            if(! $(this).hasClass('no-js')){
                let elemenetID = $(this).attr('href');
                let active_tab = $(this).attr('data-tab');
                $(document).find('.nav-tab-wrapper a.nav-tab').each(function () {
                    if ($(this).hasClass('nav-tab-active')) {
                        $(this).removeClass('nav-tab-active');
                    }
                });
                $(this).addClass('nav-tab-active');
                $(document).find('.ays-gpg-tab-content').each(function () {
                    if ($(this).hasClass('ays-gpg-tab-content-active'))
                        $(this).removeClass('ays-gpg-tab-content-active');
                });
                $(document).find("[name='ays_gpg_tab']").val(active_tab);
                $('.ays-gpg-tab-content' + elemenetID).addClass('ays-gpg-tab-content-active');
                e.preventDefault();
            }
        });

        $(document).on('click', '#ays-gallery-prev-button', function(e){
            e.preventDefault();
            var confirm = window.confirm( ays_gpg_admin['prevGalleryPage'] );
            if(confirm === true){
                window.location.replace($(this).attr('href'));
            }
        });

        $(document).on('click', '#ays-gallery-next-button', function(e){
            e.preventDefault();
            var confirm = window.confirm( ays_gpg_admin['nextGalleryPage'] );
            if(confirm === true){
                window.location.replace($(this).attr('href'));
            }
        });

        $(document).on('click', '.ays_gpg_toggle_loader_radio', function (e) {
            var dataFlag = $(this).attr('data-flag');
            var dataType = $(this).attr('data-type');
            var state = false;
            if (dataFlag == 'true') {
                state = true;
            }

            var parent = $(this).parents('.ays_gpg_toggle_loader_parent');
            if($(this).hasClass('ays_toggle_loader_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_gpg_toggle_loader_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_gpg_toggle_loader_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        switch( dataType ){
                            case 'text':
                                parent.find('.ays_gpg_toggle_loader_target[data-type="'+ dataType +'"]').show(250);
                                parent.find('.ays_gpg_toggle_loader_target[data-type="gif"]').hide(250);
                            break;
                            case 'gif':
                                parent.find('.ays_gpg_toggle_loader_target[data-type="'+ dataType +'"]').show(250);
                                parent.find('.ays_gpg_toggle_loader_target.ays_gif_loader_width_container[data-type="'+ dataType +'"]').css({
                                    'display': 'flex',
                                    'justify-content': 'center',
                                    'align-items': 'center'
                                });
                                parent.find('.ays_gpg_toggle_loader_target[data-type="text"]').hide(250);
                            break;
                            default:
                                parent.find('.ays_gpg_toggle_loader_target').show(250);
                            break;
                        }
                        break;
                    case false:
                        switch( dataType ){
                            case 'text':
                                parent.find('.ays_gpg_toggle_loader_target[data-type="'+ dataType +'"]').hide(250);
                            break;
                            case 'gif':
                                parent.find('.ays_gpg_toggle_loader_target[data-type="'+ dataType +'"]').hide(250);
                            break;
                            default:
                                parent.find('.ays_gpg_toggle_loader_target').hide(250);
                            break;
                        }
                        break;
                }
            }
        });

         $(document).on('click', 'a.add_gallery_loader_custom_gif, span.ays-edit-img', function (e) {
            openMediaUploaderForImage(e, $(this));
        });
        $(document).on('click', '.ays-remove-gallery-loader-custom-gif', function (e) {
            var parent = $(this).parents('.ays-image-wrap');
            parent.find('img.img_gallery_loader_custom_gif').attr('src', '');
            parent.find('input.ays-image-path').val('');
            parent.find('.ays-gpg-image-container').fadeOut();
            parent.find('a.ays-add-image').text( galleryLangObj.addGif );
            parent.find('a.ays-add-image').show();
        });

        $(document).find('.ays-gallery-open-gpgs-list').on('click', function(e){
            $(this).parents(".ays-gallery-subtitle-main-box").find(".ays-gallery-gpgs-data").toggle('fast');
        });

        $(document).on( "click" , function(e){
            if($(e.target).closest('.ays-gallery-subtitle-main-box').length != 0){
                
            }else{
                $(document).find(".ays-gallery-subtitle-main-box .ays-gallery-gpgs-data").hide('fast');
            }            
        });

        $(document).find(".ays-gallery-go-to-gpgs").on("click" , function(e){
            e.preventDefault();
            var confirmRedirect = window.confirm('Are you sure you want to redirect to another gallery? Note that the changes made in this gallery will not be saved.');
            if(confirmRedirect){
                window.location = $(this).attr("href");
            }
        });

        // Submit buttons disableing with loader
        $(document).find('.ays-gpg-save-comp').on('click', function () {
            var $this = $(this);
            submitOnce($this);
        });


        // Select message vars galleries page | Start
        $(document).find('.ays-gpg-message-vars-icon').on('click', function(e){
            $(this).parents(".ays-gpg-message-vars-box").find(".ays-gpg-message-vars-data").toggle('fast');
        });
        
        $(document).on( "click" , function(e){
            if($(e.target).closest('.ays-gpg-message-vars-box').length != 0){
            } 
            else{
                $(document).find(".ays-gpg-message-vars-box .ays-gpg-message-vars-data").hide('fast');
            }
        });

        $(document).find('.ays-gpg-message-vars-each-data').on('click', function(e){
            var _this  = $(this);
            var parent = _this.parents('.ays-gpg-desc-message-vars-parent');

            var textarea   = parent.find('textarea.ays-textarea');
            var textareaID = textarea.attr('id');

            var messageVar = _this.find(".ays-gpg-message-vars-each-var").val();
            
            if ( parent.find("#wp-"+ textareaID +"-wrap").hasClass("tmce-active") ){
                window.tinyMCE.get(textareaID).setContent( window.tinyMCE.get(textareaID).getContent() + messageVar + " " );
            }else{
                $(document).find('#'+textareaID).append( " " + messageVar + " ");
            }
        });

        /* Select message vars galleries page | End */

         // Pagination type
        if($(document).find('input[name="ays_gpg_pagination"]:checked').val() == "simple" ){
            $(document).find('.ays_hide_hr').show();
            $(document).find('.show_load_effect_simple').show();
            $(document).find('.show_load_effect_load_more').hide();
        } else if ($(document).find('input[name="ays_gpg_pagination"]:checked').val() == "load_more") {
            $(document).find('.ays_hide_hr').show();
            $(document).find('.show_load_effect_simple').hide();
            $(document).find('.show_load_effect_load_mroe').show();
        } else {
            $(document).find('.ays_hide_hr').hide();
            $(document).find('.show_load_effect_simple').hide();
            $(document).find('.show_load_effect_load_more').hide()
        }

        $(document).find('label#gpg_pagination_none').on('click', function(){
            $(document).find('.ays_hide_hr').hide(150);
            $(document).find('.show_load_effect_simple').hide(150);
            $(document).find('.show_load_effect_load_more').hide(150);
        });

        $(document).find('label#gpg_pagination_simple').on('click', function(){
            $(document).find('.ays_hide_hr').show(500);
            $(document).find('.show_load_effect_simple').show(500);
            $(document).find('.show_load_effect_load_more').hide(150);
        });

        $(document).find('label#gpg_pagination_load_more').on('click', function(){
            $(document).find('.ays_hide_hr').show(500);
            $(document).find('.show_load_effect_simple').hide(500);
            $(document).find('.show_load_effect_load_more').show(150);
        });

        $(document).find("label.ays_gpg_hover_zoom").on('click', function(e){
            if ($(this).find('input[type="radio"]').val() == 'yes') {
                $(document).find('.hover_zoom_animation_speed').removeClass('display_none');
            }else{
                $(document).find('.hover_zoom_animation_speed').addClass('display_none');                
            }
        });

        $(document).find("label.ays_gpg_hover_scale").on('click', function(e){
            if ($(this).find('input[type="radio"]').val() == 'yes') {
                $(document).find('.hover_scale_animation_speed').removeClass('display_none');
            }else{
                $(document).find('.hover_scale_animation_speed').addClass('display_none');                
            }
        });        

        $(document).find('.ays-gpg-copy-image').on('click', function(){
            var _this = this;
            var input = $(_this).parent().find('input.ays-gpg-shortcode-input');
            var length = input.val().length;

            input[0].focus();
            input[0].setSelectionRange(0, length);
            document.execCommand('copy');
            // document.getSelection().removeAllRanges();

            $(_this).attr('data-original-title', galleryLangObj.copied);
            $(_this).attr("data-bs-original-title", galleryLangObj.copied);
            $(_this).attr("title", galleryLangObj.copied);
            $(_this).tooltip('show');
        });

        $(document).find('.ays-gpg-copy-image').on('mouseleave', function(){
            var _this = this;

            $(_this).attr('data-original-title', galleryLangObj.clickForCopy);
            $(_this).attr("data-bs-original-title", galleryLangObj.clickForCopy);
            $(_this).attr("title", galleryLangObj.clickForCopy);
        });        

        // Position tables start
        $(document).find('table#ays-gpg-position-table tr td, table#ays-gpg-position-table-mobile tr td').on('click', function(e) {
            var val = $(this).data('value');
            var flag = $(this).parents('table').data('flag');

            if (flag == 'gpg_image_position') {
                $(this).parents('.gpg_position_block').find('.ays-gpg-position-val-class').val(val).trigger('change');
            } else {
                $(this).parents('.gpg_position_block').find('.ays-gpg-position-mobile-val-class').val(val).trigger('change');
            }

            aysGpgImagePosition();
            
        });
        // Position tables end

        aysGpgImagePosition();
        function aysGpgImagePosition() {
            var hiddenVal = $(document).find('.gpg_position_block #ays-gpg-position-val').val();
            var hiddenValMobile = $(document).find('.gpg_position_block #ays-gpg-position-mobile-val').val();

            if (hiddenVal == '') {
                var $this = $(document).find('table#ays-gpg-position-table tr td[data-value="center-center"]');
            }else{
                var $this = $(document).find('table#ays-gpg-position-table tr td[data-value="' + hiddenVal + '"]');
            }

            if (hiddenValMobile == '') {
                var $thisMobile = $(document).find('table#ays-gpg-position-table-mobile tr td[data-value="center-center"]');
            }else{
                var $thisMobile = $(document).find('table#ays-gpg-position-table-mobile tr td[data-value="' + hiddenValMobile + '"]');
            }

            $(document).find('table#ays-gpg-position-table td').removeAttr('style');
            $(document).find('table#ays-gpg-position-table-mobile td').removeAttr('style');
            $this.css('background-color','#3d89e0');
            $thisMobile.css('background-color','#9964b3');
        }

        function submitOnce(subButton){
            var subLoader = subButton.parents('div').find('.ays_gpg_loader_box');
            if ( subLoader.hasClass("display_none") ) {
                subLoader.removeClass("display_none");
            }
            subLoader.css("padding-left" , "8px");
            subLoader.css("display" , "inline-flex");
            setTimeout(function() {
                $(document).find('.ays-gpg-save-comp').attr('disabled', true);
            }, 50);

            setTimeout(function() {
                $(document).find('.ays-gpg-save-comp').attr('disabled', false);
                subButton.parents('div').find('.ays_gpg_loader_box').css('display', 'none');
            }, 5000);
        }

        $(document).on("click", "#ays-gpg-dismiss-buttons-content .ays-button, #ays-gpg-dismiss-buttons-content-black-friday .ays-button-black-friday", function(e){
            e.preventDefault();

            var $this = $(this);
            var thisParent  = $this.parents("#ays-gpg-dismiss-buttons-content");
                        
            var mainParent  = $this.parents("div.ays_gpg_dicount_info");
            var closeButton = mainParent.find("button.notice-dismiss");

            var attr_plugin = $this.attr('data-plugin');
            var wp_nonce    = thisParent.find('#photo-gallery-sale-banner').val();

            if(typeof wp_nonce == 'undefined'){
                wp_nonce    = $(document).find('#photo-gallery-sale-banner').val();
            }

            var data = {
                action: 'ays_gpg_dismiss_button',
                _ajax_nonce: wp_nonce,
            };

            $.ajax({
                url: gallery_ajax.ajax_url,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if( response.status ){
                        closeButton.trigger('click');
                    } else {
                        swal.fire({
                            type: 'info',
                            html: "<h2>"+ galleryLangObj.errorMsg +"</h2><br><h6>"+ galleryLangObj.somethingWentWrong +"</h6>"
                        }).then(function(res) {
                            closeButton.trigger('click');
                        });
                    }
                },
                error: function(){
                    swal.fire({
                        type: 'info',
                        html: "<h2>"+ galleryLangObj.errorMsg +"</h2><br><h6>"+ galleryLangObj.somethingWentWrong +"</h6>"
                    }).then(function(res) {
                        closeButton.trigger('click');
                    });
                }
            });
        });

        $(document).on("click", ".ays-gpg-cards-block .ays-gpg-card__footer button.status-missing", function(e){
            var $this = $(this);
            var thisParent = $this.parents(".ays-gpg-cards-block");

            $this.prop('disabled', true);
            $this.addClass('disabled');

            var loader_html = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';

            $this.html(loader_html);

            var attr_plugin = $this.attr('data-plugin');
            var wp_nonce = thisParent.find('#ays_gpg_ajax_install_plugin_nonce').val();

            var data = {
                action: 'ays_gpg_install_plugin',
                _ajax_nonce: wp_nonce,
                plugin: attr_plugin,
                type: 'plugin'
            };

            $.ajax({
                url: gallery_ajax.ajax_url,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.success) {
                        swal.fire({
                            type: 'success',
                            html: "<h4>"+ response['data']['msg'] +"</h4>"
                        }).then( function(res) {
                            if ( $this.hasClass('status-missing') ) {
                                $this.removeClass('status-missing');
                            }
                            $this.text(gallery_ajax.activated);
                            $this.addClass('status-active');
                        });
                    }
                    else {
                        swal.fire({
                            type: 'info',
                            html: "<h4>"+ response['data'][0]['message'] +"</h4>"
                        }).then( function(res) {
                            $this.text(gallery_ajax.errorMsg);
                        });
                    }
                },
                error: function(){
                    swal.fire({
                        type: 'info',
                        html: "<h2>"+ gallery_ajax.loadResource +"</h2><br><h6>"+ gallery_ajax.somethingWentWrong +"</h6>"
                    }).then( function(res) {
                        $this.text(gallery_ajax.errorMsg);
                    });                
                }
            });
        });

        $(document).on("click", ".ays-gpg-cards-block .ays-gpg-card__footer button.status-installed", function(e){
            var $this = $(this);
            var thisParent = $this.parents(".ays-gpg-cards-block");

            $this.prop('disabled', true);
            $this.addClass('disabled');

            var loader_html = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>';

            $this.html(loader_html);

            var attr_plugin = $this.attr('data-plugin');
            var wp_nonce = thisParent.find('#ays_gpg_ajax_install_plugin_nonce').val();

            var data = {
                action: 'ays_gpg_activate_plugin',
                _ajax_nonce: wp_nonce,
                plugin: attr_plugin,
                type: 'plugin'
            };

            $.ajax({
                url: gallery_ajax.ajax_url,
                method: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if( response.success ){
                        swal.fire({
                            type: 'success',
                            html: "<h4>"+ response['data'] +"</h4>"
                        }).then( function(res) {
                            if ( $this.hasClass('status-installed') ) {
                                $this.removeClass('status-installed');
                            }
                            $this.text(gallery_ajax.activated);
                            $this.addClass('status-active disabled');
                        });
                    } else {
                        swal.fire({
                            type: 'info',
                            html: "<h4>"+ response['data'][0]['message'] +"</h4>"
                        });
                    }
                },
                error: function(){
                    swal.fire({
                        type: 'info',
                        html: "<h2>"+ gallery_ajax.loadResource +"</h2><br><h6>"+ gallery_ajax.somethingWentWrong +"</h6>"
                    }).then( function(res) {
                        $this.text(gallery_ajax.errorMsg);
                    });                
                }
            });
        });

        // Check new added Gallery start
        var createdNewGallery = aysGalleryGetCookie('ays_gallery_created_new');

        if(createdNewGallery && createdNewGallery >= 1){
            var url = new URL(window.location.href);

            var getCustomPostId = aysGalleryGetCookie('ays_gallery_created_new_'+createdNewGallery+'_post_id');

            var link = "#";
            if(getCustomPostId){
                link = getCustomPostId;
            }

            // Get a specific GET parameter by name
            var parameterValue = url.searchParams.get("action");

            var htmlDefaultText = '<p style="margin-top:1rem;">'+ galleryLangObj.formMoreDetailed +' <a href="admin.php?page=gallery-photo-gallery&action=edit&id=' + createdNewGallery + '">'+ galleryLangObj.editGalleryPage +'</a>.</p>';
            var htmlContent = parameterValue && parameterValue == 'edit' ? '' : htmlDefaultText;

            var previewButtonSvgIcon = '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">'+
                '<path d="M11.9999 7.21325C11.8231 7.21325 11.6535 7.28349 11.5285 7.40851C11.4035 7.53354 11.3333 7.70311 11.3333 7.87992V12.6666C11.3333 12.8434 11.263 13.013 11.138 13.138C11.013 13.263 10.8434 13.3333 10.6666 13.3333H3.33325C3.15644 13.3333 2.98687 13.263 2.86185 13.138C2.73682 13.013 2.66659 12.8434 2.66659 12.6666V5.33325C2.66659 5.15644 2.73682 4.98687 2.86185 4.86185C2.98687 4.73682 3.15644 4.66658 3.33325 4.66658H8.11992C8.29673 4.66658 8.4663 4.59635 8.59132 4.47132C8.71635 4.3463 8.78658 4.17673 8.78658 3.99992C8.78658 3.82311 8.71635 3.65354 8.59132 3.52851C8.4663 3.40349 8.29673 3.33325 8.11992 3.33325H3.33325C2.80282 3.33325 2.29411 3.54397 1.91904 3.91904C1.54397 4.29411 1.33325 4.80282 1.33325 5.33325V12.6666C1.33325 13.197 1.54397 13.7057 1.91904 14.0808C2.29411 14.4559 2.80282 14.6666 3.33325 14.6666H10.6666C11.197 14.6666 11.7057 14.4559 12.0808 14.0808C12.4559 13.7057 12.6666 13.197 12.6666 12.6666V7.87992C12.6666 7.70311 12.5963 7.53354 12.4713 7.40851C12.3463 7.28349 12.1767 7.21325 11.9999 7.21325ZM14.6133 1.74659C14.5456 1.58369 14.4162 1.45424 14.2533 1.38659C14.1731 1.35242 14.087 1.33431 13.9999 1.33325H9.99992C9.82311 1.33325 9.65354 1.40349 9.52851 1.52851C9.40349 1.65354 9.33325 1.82311 9.33325 1.99992C9.33325 2.17673 9.40349 2.3463 9.52851 2.47132C9.65354 2.59635 9.82311 2.66659 9.99992 2.66659H12.3933L5.52659 9.52658C5.4641 9.58856 5.4145 9.66229 5.38066 9.74353C5.34681 9.82477 5.32939 9.91191 5.32939 9.99992C5.32939 10.0879 5.34681 10.1751 5.38066 10.2563C5.4145 10.3375 5.4641 10.4113 5.52659 10.4733C5.58856 10.5357 5.66229 10.5853 5.74353 10.6192C5.82477 10.653 5.91191 10.6705 5.99992 10.6705C6.08793 10.6705 6.17506 10.653 6.2563 10.6192C6.33754 10.5853 6.41128 10.5357 6.47325 10.4733L13.3333 3.60659V5.99992C13.3333 6.17673 13.4035 6.3463 13.5285 6.47132C13.6535 6.59635 13.8231 6.66658 13.9999 6.66658C14.1767 6.66658 14.3463 6.59635 14.4713 6.47132C14.5963 6.3463 14.6666 6.17673 14.6666 5.99992V1.99992C14.6655 1.9128 14.6474 1.82673 14.6133 1.74659Z" fill="#007DCB"/>'+
                '</svg>';

            swal({                
                title: '<strong class="ays-gallery-swal2-title">' + galleryLangObj.greateJob + '</strong>',
                type: 'success',            
                html: '<p class="ays-gallery-swal2-created-row">' + galleryLangObj.youGalleriesIsCreated + '</p><p clas="ays-gallery-swal2-content-text-row">' + galleryLangObj.youCanUuseThisShortcode + '</p><input type="text" id="ays-gallery-create-new" onClick="this.setSelectionRange(0, this.value.length)" readonly value="[gallery_p_gallery id=\'' + createdNewGallery + '\']" />' + htmlContent,
                showCancelButton: true,
                showCloseButton: true,
                focusConfirm: false,
                cancelButtonClass: "ays-gpg-preview-popup-cancel-button",
                confirmButtonText: '<i class="ays_fa ays_fa_thumbs_up"></i> '+ galleryLangObj.greate,
                confirmButtonAriaLabel: galleryLangObj.thumbsUpGreat,
                cancelButtonText: '<a href="'+ link +'" target="_blank">'+ galleryLangObj.preivewGallery + ' ' + previewButtonSvgIcon +'</a>',
                cancelButtonAriaLabel: galleryLangObj.thumbsUpGreat,
            });
            aysGalleryDeleteCookie('ays_gallery_created_new');
            aysGalleryDeleteCookie('ays_gallery_created_new_'+createdNewGallery+'_post_id');
        }

        $(document).on('mouseover', '.ays-dashicons', function(){
            var allRateStars = $(document).find('.ays-dashicons');
            var index = allRateStars.index(this);
            allRateStars.removeClass('ays-dashicons-star-filled').addClass('ays-dashicons-star-empty');
            for (var i = 0; i <= index; i++) {
                allRateStars.eq(i).removeClass('ays-dashicons-star-empty').addClass('ays-dashicons-star-filled');
            }
        });
        
        $(document).on('mouseleave', '.ays-rated-link', function(){
            $(document).find('.ays-dashicons').removeClass('ays-dashicons-star-filled').addClass('ays-dashicons-star-empty');                
        });

        $(document).find('#reset_to_default').on('click', function () {

            setTimeout(function(){
                if($(document).find('#gallery_custom_css').length > 0){
                    if(wp.codeEditor){
                        $(document).find('#gallery_custom_css').next('.CodeMirror').remove();
                        $(document).find('#gallery_custom_css').val('');
                        wp.codeEditor.initialize($(document).find('#gallery_custom_css'), cm_gpg_settings);
                    }
                }
            }, 100);

            $(document).find('.ays_hover_effect_radio_dir_aware').prop("disabled", false);
            $(document).find('.ays_hover_effect_radio_dir_aware').parent().css('color', '#000');
            $(document).find('.ays-view-type').prop('checked' , false).change();
            $(document).find('.ays-view-type[value="grid"]').prop('checked' , true).change();

            $(document).find('.ays_hover_effect_radio').prop('checked' , false).change();
            $(document).find('.ays_hover_effect_radio.ays_hover_effect_radio_simple').prop('checked' , true).change();
            $(document).find('.ays_effect_simple').show(500);
            $(document).find('.ays_effect_dir_aware').hide(150);

            $(document).find('#ays_gpg_hover_animation_speed').val('0.5').change();
            $(document).find('#ays_gpg_hover_animation_speed_mobile').val('0.5').change();
            $(document).find("#enable_ays_gpg_hover_animation_speed_mobile").prop('checked', true).change();            

            $(document).find('#ays-gpg-position-val').val('center-center').change();
            $(document).find('#ays-gpg-position-mobile-val').val('center-center').change();
            $(document).find('input#enable_gallery_img_position_mobile').prop('checked', false).change();
            $(document).find('div.ays_gpg_img_position_mobile_container').css('display', 'none').change();
            aysGpgImagePosition();

            $(document).find('#formControlRange').val('0.5').change();
            $(document).find('#formControlRangeMobile').val('0.5').change();
            $(document).find('.gpg_opacity_demo').css('opacity', '0.5');
            $(document).find("#enable_ays_gpg_images_hover_opacity_mobile").prop('checked', true).change();

            $(document).find('#ays-gpg-hover-color').val('#000').change();
            $(document).find('#ays-gpg-hover-color-mobile').val('#000').change();
            $(document).find("#enable_gpg_hover_color_mobile").prop('checked', true).change();

            $(document).find('label.ays_gpg_hover_zoom > input').prop('checked' , false).change();
            $(document).find('label.ays_gpg_hover_zoom > input[value="no"]').prop('checked' , true).change();
            $(document).find('.hover_zoom_animation_speed').addClass('display_none');

            $(document).find('label.ays_gpg_hover_scale > input').prop('checked' , false).change();
            $(document).find('label.ays_gpg_hover_scale > input[value="no"]').prop('checked' , true).change();
            $(document).find('.hover_scale_animation_speed').addClass('display_none');

            $(document).find('#gallery_img_hover_simple').val('fadeIn').change();

            $(document).find('#ays_gpg_filter_thubnail').val('none').change();
            $(document).find('#ays_gpg_filter_thubnail_mobile').val('none').change();
            $(document).find("#enable_ays_gpg_filter_thubnail_opt_mobile").prop('checked', true).change();

            $(document).find('.ays-remove-gallery-loader-custom-gif').trigger('click');
            $(document).find('#ays_gallery_loader_custom_gif_width').val('100').change();
            $(document).find('#ays_gpg_loader_text_value').val('').change();
            $(document).find('.ays_gpg_toggle_loader_radio').prop('checked' , false).change();
            $(document).find('.ays_gpg_toggle_loader_radio[value="flower"]').prop('checked' , true).change();
            $(document).find('.ays_gpg_toggle_loader_target').hide(250);

            $(document).find('label.ays_gpg_image_hover_icon > input[name="ays-gpg-image-hover-icon"]').prop('checked' , false).change();
            $(document).find('label.ays_gpg_image_hover_icon > input[name="ays-gpg-image-hover-icon"][value="search_plus"]').prop('checked' , true).change();

            $(document).find('input[name="ays-gpg-hover-icon-size"]').val('20').change();
            $(document).find('input[name="ays-gpg-images-distance"]').val('5').change();

            $(document).find('#ays_gpg_images_border').prop('checked' , false).change();
            $(document).find('.ays_gpg_border_options').css('display', "none");

            $(document).find('#ays_gpg_images_border_width').val('1').change();
            $(document).find('#ays_gpg_images_border_width_mobile').val('1').change();
            $(document).find("#enable_ays_gpg_images_border_width_mobile").prop('checked', true).change();

            $(document).find('#ays_gpg_images_border_style').val('solid').change();
            $(document).find('#ays_gpg_images_border_style_mobile').val('solid').change();
            $(document).find("#enable_ays_gpg_images_border_style_mobile").prop('checked', true).change();

            $(document).find('#ays_gpg_border_color').val('#000').change();
            $(document).find('#ays_gpg_border_color_mobile').val('#000').change();
            $(document).find('#enable_ays_gpg_border_color_mobile').prop('checked', true).change();

            $(document).find('input[name="ays-gpg-images-border-radius"]').val('0').change();
            $(document).find('input[name="ays-gpg-images-border-radius-mobile"]').val('0').change();
            $(document).find('input[name="enable-ays-gpg-images-border-radius-mobile"]').prop('checked', true).change();

            $(document).find('input[name="ays_gpg_thumbnail_title_size"]').val('12').change();

            $(document).find('#ays_gallery_title_color').val('#000').change();
            $(document).find('#ays_gallery_title_color_mobile').val('#000').change();
            $(document).find("#enable_ays_gallery_title_color_mobile").prop('checked', true).change();

            $(document).find('#ays_gallery_desc_color').val('#000').change();
            $(document).find('#ays_gallery_desc_color_mobile').val('#000').change();
            $(document).find("#enable_ays_gallery_desc_color_mobile").prop('checked', true).change();

            $(document).find('#ays-gpg-lightbox-color').val('rgba(0,0,0,0)').change();
            $(document).find('#ays-gpg-lightbox-color-mobile').val('rgba(0,0,0,0)').change();
            $(document).find("#enable-ays-gpg-lightbox-color-mobile").prop('checked', true).change();

            $(document).find('#ays_gpg_thumbnail_title_color').val('#fff').change();
            $(document).find('#ays_gpg_thumbnail_title_color_mobile').val('#fff').change();
            $(document).find("#enable_ays_gpg_thumbnail_title_color_mobile").prop('checked', true).change();
            
            $(document).find('#custom_class').val('').change();           

            $(document).find("#tab3").goToNormal();
        });

        $(document).find('.ays-gpg-accordion-container').on('click', function(e) {
            var _this = $(this);
            openGpgCloseAccordion( _this );
        });

        function openGpgCloseAccordion( _this ){
            var parent = _this.closest(".ays-gpg-accordion-options-main-container");
            var container = parent.find('.ays-gpg-accordion-options-box');

            if( parent.attr('data-collapsed') === 'true' ){
                setTimeout( function() {
                    container.slideDown();
                    parent.find('.ays-gpg-accordion-arrow-box .ays-gpg-accordion-arrow').removeClass('ays-gpg-accordion-arrow-right').addClass('ays-gpg-accordion-arrow-down');
                    parent.attr('data-collapsed', 'false');
                    parent.find('.ays-gpg-accordion-options-main-container').attr('data-collapsed', 'false');
                }, 150);
            }else{
                setTimeout( function() {
                    container.slideUp();
                    parent.find('.ays-gpg-accordion-arrow-box .ays-gpg-accordion-arrow').removeClass('ays-gpg-accordion-arrow-down').addClass('ays-gpg-accordion-arrow-right');
                    parent.attr('data-collapsed', 'true');
                    parent.find('.ays-gpg-accordion-options-main-container').attr('data-collapsed', 'true');
                }, 150);
            }
        }

        // Toggle mobile settings start
        $(document).find('.ays_gpg_different_settings_for_mobile').on('change', toggleMobileSettings);
        $(document).find('.ays_gpg_option_for_desktop, .ays_gpg_option_for_mobile_device_cb').on('click', toggleMobileSettingsCb);
        // Toggle mobile settings end

        function toggleMobileSettings() {
            var optionDiv = $(this).parents('.ays_gpg_pc_and_mobile_container');
            var deviceNames = optionDiv.find('.ays_gpg_current_device_name');
            var mobileOptionDiv = optionDiv.find('.ays_gpg_option_for_mobile_device');
            var cbLabel = optionDiv.find('.ays_gpg_mobile_settings_container label');

            if ($(this).prop('checked')) {
                deviceNames.addClass('show');
                mobileOptionDiv.addClass('show');
                cbLabel.addClass('active');
            } else {
                deviceNames.removeClass('show');
                mobileOptionDiv.removeClass('show');
                cbLabel.removeClass('active');
            }
        }

        function toggleMobileSettingsCb() {
            var mainContainer = $(this).parent();
            var desktopContainer = mainContainer.find('.ays_gpg_option_for_desktop');
            var mobileContainer = mainContainer.find('.ays_gpg_option_for_mobile_device');
            var desktopCb = desktopContainer.find('.ays-gpg-onoffswitch-checkbox');
            var mobileDeviceCb = mobileContainer.find('.ays-gpg-onoffswitch-checkbox');
            var deviceNames = mainContainer.find('.ays_gpg_current_device_name');

            if (desktopCb.is(':checked')) {
                if (!mobileContainer.hasClass('show')) {
                    mobileContainer.addClass('show');
                    mobileDeviceCb.prop('checked', true);
                    deviceNames.show().fadeIn('300');
                }
            } else {
                if (!mobileDeviceCb.is(':checked')) {
                    mobileContainer.removeClass('show');
                    deviceNames.hide().fadeOut('300');
                }
            }
        }

        // Replace image to YouTube embed video
        $(document).on('click', '.ays-gpg-youtube-placeholder', function() {
            var videoId = $(this).data('video-id');
            var iframe = $('<iframe>', {
                src: 'https://www.youtube.com/embed/' + videoId + '?autoplay=1',
                class: '',
                width: 560,
                height: 315,
                frameborder: 0,
                allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                allowfullscreen: true,
            });
            $(this).replaceWith(iframe);
        });

})( jQuery );

function ays_getDirectionKey(ev, obj) {
    let ays_w = obj.offsetWidth,
        ays_h = obj.offsetHeight,
        ays_x = (ev.pageX - obj.offsetLeft - (ays_w / 2) * (ays_w > ays_h ? (ays_h / ays_w) : 1)),
        ays_y = (ev.pageY - obj.offsetTop - (ays_h / 2) * (ays_h > ays_w ? (ays_w / ays_h) : 1)),
        ays_d = Math.round( Math.atan2(ays_y, ays_x) / 1.57079633 + 5 ) % 4;
    return ays_d;
}

function aysGalleryDeleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function aysGalleryGetCookie(c_name) {
    if (document.cookie.length > 0) {
        var c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            var c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

function selectElementContents(el) {
    if (window.getSelection && document.createRange) {
        var _this = jQuery(document).find('strong.ays-gallery-shortcode-box');
        
        var sel = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(el);
        sel.removeAllRanges();
        sel.addRange(range);

        var text      = el.textContent;
        var textField = document.createElement('textarea');

        textField.innerText = text;
        document.body.appendChild(textField);
        textField.select();
        document.execCommand('copy');
        textField.remove();

        var selection = window.getSelection();
        selection.setBaseAndExtent(el,0,el,1);

        _this.attr( "data-original-title", galleryLangObj.copied );
        _this.attr( "title", galleryLangObj.copied );

        _this.tooltip("show");

    } else if (document.selection && document.body.createTextRange) {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.select();
    }
}

function stripHTML(dirtyString) {
  var container = document.createElement('div');
  var text = document.createTextNode(dirtyString);
  container.appendChild(text);
  return container.innerHTML; // innerHTML will be a xss safe string
}

function ays_closestEdge(x,y,w,h) {
    let ays_topEdgeDist = ays_distMetric(x,y,w/2,0);
    let ays_bottomEdgeDist = ays_distMetric(x,y,w/2,h);
    let ays_leftEdgeDist = ays_distMetric(x,y,0,h/2);
    let ays_rightEdgeDist = ays_distMetric(x,y,w,h/2);
    let ays_min = Math.min(ays_topEdgeDist,ays_bottomEdgeDist,ays_leftEdgeDist,ays_rightEdgeDist);

    switch (ays_min) {
        case ays_leftEdgeDist:
            return 'left';
        case ays_rightEdgeDist:
            return 'right';
        case ays_topEdgeDist:
            return 'top';
        case ays_bottomEdgeDist:
            return 'bottom';
    }
}

//Distance Formula
function ays_distMetric(x,y,x2,y2) {    
    let ays_xDiff = x - x2;
    let ays_yDiff = y - y2;
    return (Math.abs(ays_xDiff) * Math.abs(ays_yDiff))/2;
}

function openMediaUploaderForImage(e, element) {
    e.preventDefault();
    var aysUploader = wp.media({
        title: 'Upload',
        button: {
            text: 'Upload'
        },
        library: {
            type: 'image'
        },
        multiple: false
    }).on('select', function () {
        var attachment = aysUploader.state().get('selection').first().toJSON();
        var wrap = element.parents('.ays-image-wrap');
        wrap.find('.ays-gpg-image-container img').attr('src', attachment.url);
        wrap.find('input.ays-image-path').val(attachment.url);
        wrap.find('.ays-gpg-image-container').fadeIn();
        wrap.find('a.ays-add-image').hide();
    }).open();
    return false;
}

function aysGallerystripHTML( dirtyString ) {
    var container = document.createElement('div');
    var text = document.createTextNode(dirtyString);
    container.appendChild(text);

    return container.innerHTML; // innerHTML will be a xss safe string
}

function selectAndCopyElementContents(el) {
    if (window.getSelection && document.createRange) {
        var _this = jQuery(document).find('.ays-gpg-copy-element-box');

        var text      = el.textContent;
        var textField = document.createElement('textarea');

        textField.innerText = text;
        document.body.appendChild(textField);
        textField.select();
        document.execCommand('copy');
        textField.remove();

        var selection = window.getSelection();
        selection.setBaseAndExtent(el,0,el,1);

        _this.attr( "data-original-title", galleryLangObj.copied );
        _this.attr( "title", galleryLangObj.copied );

        _this.tooltip("show");

    } else if (document.selection && document.body.createTextRange) {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.select();
    }
}