(function ($) {
    $(function () {
        var flag = true;
        var tapped = false;
        var touchStartCoords;
        $(document).on('touchstart', function (e){
            touchStartCoords = e.originalEvent.touches[0].clientY;
         });
        $(document).on("touchend" , ".lg-image",function(e){
            var touchEndCoords = e.originalEvent.changedTouches[0].clientY;
            if(touchStartCoords == touchEndCoords){
                if(!tapped){
                    tapped=setTimeout(function(){
                        if(flag){
                            $(document).find(".lg-icon,.lg-sub-html,.lg-toolbar").fadeOut("fast");
                            flag = false;
                        }
                        else{
                            $(document).find(".lg-icon,.lg-sub-html,.lg-toolbar").fadeOut().toggle("fast");
                            flag = true;
                        }
                        tapped = null;
                        
                    },200);  
                }
                else{
                    clearTimeout(tapped); 
                    tapped = null;
                }                    
                e.preventDefault();

            }
        }); 

        $(document).on('click',".lg-image",function(e){
            if(!tapped){
                tapped=setTimeout(function(){
                    if(flag){
                        $(document).find(".lg-icon,.lg-sub-html,.lg-toolbar").fadeOut("fast");
                        flag = false;
                    }
                    else{
                        $(document).find(".lg-icon,.lg-sub-html,.lg-toolbar").fadeOut().toggle("fast");
                        flag = true;
                    }
                    tapped = null;
                    
                },200);  
            }
            else{
                clearTimeout(tapped); 
                tapped = null;
            }                    
            e.preventDefault();
        })

        $(document).on('click', '.elementor-tab-title', function() {
            $(window).trigger('resize');
        });

        $(document).ready(function () {
            // for details
            // ays-all-galleries-table-generic
            $(document).find('table.ays-all-galleries-table-generic').DataTable({
                "language": {
                    "sEmptyTable":     galleryLangDataTableObj.sEmptyTable,
                    "sInfo":           galleryLangDataTableObj.sInfo,
                    "sInfoEmpty":      galleryLangDataTableObj.sInfoEmpty,
                    "sInfoFiltered":   galleryLangDataTableObj.sInfoFiltered,
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ",",
                    "sLengthMenu":     galleryLangDataTableObj.sLengthMenu,
                    "sLoadingRecords": galleryLangDataTableObj.sLoadingRecords,
                    "sProcessing":     galleryLangDataTableObj.sProcessing,
                    "sSearch":         galleryLangDataTableObj.sSearch,
                    "sUrl":            "",
                    "sZeroRecords":    galleryLangDataTableObj.sZeroRecords,
                    "oPaginate": {
                        "sFirst":    galleryLangDataTableObj.sFirst,
                        "sLast":     galleryLangDataTableObj.sLast,
                        "sNext":     galleryLangDataTableObj.sNext,
                        "sPrevious": galleryLangDataTableObj.sPrevious,
                    },
                    "oAria": {
                        "sSortAscending":  galleryLangDataTableObj.sSortAscending,
                        "sSortDescending": galleryLangDataTableObj.sSortDescending
                    }
                }
            });
        });
    })
})(jQuery)

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

function ays_getDirectionKey(ev, obj) {
    let ays_w = obj.offsetWidth,
        ays_h = obj.offsetHeight,
        ays_x = (ev.pageX - obj.offsetLeft - (ays_w / 2) * (ays_w > ays_h ? (ays_h / ays_w) : 1)),
        ays_y = (ev.pageY - obj.offsetTop - (ays_h / 2) * (ays_h > ays_w ? (ays_w / ays_h) : 1)),
        ays_d = Math.round( Math.atan2(ays_y, ays_x) / 1.57079633 + 5 ) % 4;
    return ays_d;
}