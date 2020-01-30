<script>
    $(window).on('load', (function() {
        $('.twentytwenty-container').twentytwenty({default_offset_pct: 0.3, before_label: 'Damals', after_label: 'Heute'});
    }));

    $(".pico-compare-zoom-icon").on("click", function() {
        if ( !$(this).parent().hasClass("fullscreen") ) {
            enterDivFullscreen($(this).parent());
        }
        else {
            exitDivFullscreen($(this).parent());
        }
    });


    function enterDivFullscreen(my_element) {
        var fse = document.body;
        if (fse.requestFullscreen) {
            fse.requestFullscreen();
        } else if (fse.mozRequestFullScreen) { /* Firefox */
            fse.mozRequestFullScreen();
        } else if (fse.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
            fse.webkitRequestFullscreen();
        } else if (fse.msRequestFullscreen) { /* IE/Edge */
            fse.msRequestFullscreen();
        }
        my_element.addClass("fullscreen");
        document.body.style.overflow = 'hidden';
        $(window).trigger("resize.twentytwenty");
    }
    
    function exitDivFullscreen(my_element) {
        fse = document;
        if (fse.exitFullscreen) {
            fse.exitFullscreen();
        } else if (fse.mozCancelFullScreen) { /* Firefox */
            fse.mozCancelFullScreen();
        } else if (fse.webkitExitFullscreen) { /* Chrome, Safari and Opera */
            fse.webkitExitFullscreen();
        } else if (fse.msExitFullscreen) { /* IE/Edge */
            fse.msExitFullscreen();
        }
        my_element.removeClass("fullscreen");   //minimize
        document.body.style.overflow = 'visible';
        $(window).trigger("resize.twentytwenty");
    }
    

    $(document).on ('mozfullscreenchange webkitfullscreenchange fullscreenchange',function(){
        fullScreenMode = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen; // This will return true or false depending on if it's full screen or not.
        if (!fullScreenMode) {        
           $('.fullscreen').removeClass("fullscreen");
           document.body.style.overflow = 'visible';
         }
     });
</script>

