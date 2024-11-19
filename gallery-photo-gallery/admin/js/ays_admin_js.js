
jQuery(document).ready(function(){
	jQuery('.ays_upload_image').sortable({
	});
	var ays_click_counter = 1;
	var ays_url      = window.location.href;     // Returns full URL
	var ays_path = ays_url.split("/");
	var ays_new_path = "";
	for(var i=0;i<=3;i++){
		ays_new_path +=  ays_path[i]+"/";
	}
	jQuery('.nar_ays').click(function(){
		var ays_erkar = jQuery('.ays_ays_img').length;
		var ays_id = 'ays_ays_img' + ays_erkar;
		jQuery('<div class="col-md-3 nar_set_child"><div class="card"><a class="ays_remove_image" onclick="jQuery(this).parent().parent().remove()"><img src="'+ays_new_path+'wp-content/plugins/gallery_by_ays/admin/images/remove.png" width="50"></a><img class="ays_ays_img" id="ays_ays_img'+ays_erkar+'" alt="" style="width:100%"><input type="hidden" id="path_ays_ays_img'+ays_erkar+'" name="path_ays_ays_img[]"><hr><center><input type="button" value="Upload" onclick="openMediaUploader(event,'+ "'" + ays_id + "'" +');return false;" class="btn btn-success"></center><hr><a class="accordion" onclick="ays_toggle_props()">Image Props</a><div class="panel"><div class="form-group"><label class="control-label">Title</label><input type="text" id="ays_img_title'+ays_erkar+'" name="ays_img_title[]" class="form-control"></div>	<div class="form-group"><label class="control-label">Alt</label><input type="text" id="ays_img_alt'+ays_erkar+'" name="ays_img_alt[]" class="form-control"></div>	<div class="form-group"><label class="control-label">Description</label><textarea id="ays_img_desc'+ays_erkar+'" class="form-control" name="ays_img_desc[]"></textarea></div>	<div class="form-group"><label class="control-label">Url</label><input type="url" id="ays_img_url'+ays_erkar+'" name="ays_img_url[]" class="form-control"></div></div></div></div>').insertBefore(jQuery(".nar_bef"));

	});

});
jQuery(function() {
    // Nav Tab stuff
    jQuery('.nav-tabs > li > a').click(function() {
        if(jQuery(this).hasClass('disabled')) {
            return false;
        } else {
            var linkIndex = jQuery(this).parent().index() - 1;
            jQuery('.nav-tabs > li').each(function(index, item) {
                jQuery(item).attr('rel-index', index - linkIndex);
            });
        }
    });
    jQuery('#step-1-next').click(function() {
        // Check values here
        var isValid = true;
        
        if(isValid) {
            jQuery('.nav-tabs > li:nth-of-type(2) > a').removeClass('disabled').click();
        }
    });
    jQuery('#step-2-next').click(function() {
        // Check values here
        var isValid = true;
        
        if(isValid) {
            jQuery('.nav-tabs > li:nth-of-type(3) > a').removeClass('disabled').click();
        }
    });
    jQuery('#step-3-next').click(function() {
        // Check values here
        var isValid = true;
        
        if(isValid) {
            jQuery('.nav-tabs > li:nth-of-type(4) > a').removeClass('disabled').click();
        }
    });
});