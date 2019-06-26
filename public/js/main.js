$(function () {
    //BEGIN MENU SIDEBAR
    $('#sidebar').css('min-height', '100%');
    $('#side-menu').metisMenu();
    $(window).on("load resize", function () {
        if ($(this).width() < 768) {
            $('body').removeClass();
            $('div.sidebar-collapse').addClass('collapse');
        } else {
            $('div.sidebar-collapse').removeClass('collapse');
            $('div.sidebar-collapse').css('height', 'auto');
        }

        if($('#sidebar').height() > $('#page-wrapper').height()){
            $('#wrapper').css('height', $('#sidebar').height());
        }
    });

    $('#news-ticker-close').click(function(e){
        $('.news-ticker').remove();
        $('.quick-sidebar').css('top', '50px');
    });
    //END NEWS TICKER TOPBAR

    //BEGIN TOPBAR DROPDOWN
    $('.dropdown-slimscroll').slimScroll({
        "height": '250px',
        "wheelStep": 30
    });
    //END TOPBAR DROPDOWN

    //BEGIN TOOTLIP
    $("[data-toggle='tooltip'], [data-hover='tooltip']").tooltip();
    //END TOOLTIP

    //BEGIN POPOVER
    $("[data-toggle='popover'], [data-hover='popover']").popover();
    //END POPOVER

    //BEGIN PORTLET
    $(".portlet").each(function(index, element) {
        var me = $(this);
        $(">.portlet-header>.tools>i", me).click(function(e){
            if($(this).hasClass('fa-chevron-up')){
                $(">.portlet-body", me).slideUp('fast');
                $(this).removeClass('fa-chevron-up').addClass('fa-chevron-down');
            }
            else if($(this).hasClass('fa-chevron-down')){
                $(">.portlet-body", me).slideDown('fast');
                $(this).removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
            else if($(this).hasClass('fa-cog')){
                //Show modal
            }
            else if($(this).hasClass('fa-refresh')){
                //$(">.portlet-body", me).hide();
                $(">.portlet-body", me).addClass('wait');

                setTimeout(function(){
                    //$(">.portlet-body>div", me).show();
                    $(">.portlet-body", me).removeClass('wait');
                }, 1000);
            }
            else if($(this).hasClass('fa-times')){
                me.remove();
            }
        });
    });
    //END PORTLET

    //BEGIN BACK TO TOP
    $(window).scroll(function(){
        if ($(this).scrollTop() < 200) {
            $('#totop') .fadeOut();
        } else {
            $('#totop') .fadeIn();
        }
    });
    $('#totop').on('click', function(){
        $('html, body').animate({scrollTop:0}, 'fast');
        return false;
    });
    //END BACK TO TOP
    // CALL FUNCTION RESPONSIVE TABS
    fakewaffle.responsiveTabs(['xs', 'sm']);

    // BEGIN SEARCH FORM ON TOPBAR
    $('#topbar-search').on('click', function (e) {
        $(this).addClass('open');
        $(this).find('.form-control').focus();

        $('#topbar-search .form-control').on('blur', function (e) {
            $(this).closest('#topbar-search').removeClass('open');
            $(this).unbind('blur');
        });
    });
    // END SEARCH FORM ON TOPBAR

});
