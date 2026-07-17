(function($) {
    "use strict";
    /*-----------------------------------------------------
        Video PopUp
    -------------------------------------------------------*/
    var VideoPopupHandler = function( $scope, $ ) {
        $scope.find('.video-popup').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false,
            disableOn: 300
        });
    };

    /*-----------------------------------------------------
       Accordian
    -------------------------------------------------------*/
    var AccordionHandler = function () {
        //Accordion Box
        if ($(".accordion-list").length) {
            var accrodionList = $(".accordion-list");
            accrodionList.each(function () {
                var accrodionName = $(this).attr("id");
                var Self = $(this);
                var accordion = Self.find(".accordion-single");
                Self.addClass(accrodionName);
                Self.find(".accordion-single .accordion-content").hide();
                Self.find(".accordion-single.active").find(".accordion-content").show();
                accordion.each(function () {
                    $(this)
                        .find(".accordion-title")
                        .on("click", function () {
                            if ($(this).parent().hasClass("active") === false) {
                                $(".accordion-list." + accrodionName)
                                    .find(".accordion-single")
                                    .removeClass("active");
                                $(".accordion-list." + accrodionName)
                                    .find(".accordion-single")
                                    .find(".accordion-content")
                                    .slideUp();
                                $(this).parent().addClass("active");
                                $(this)
                                    .parent()
                                    .find(".accordion-content")
                                    .slideDown();
                            }
                        });
                });
            });
        }

    }

    /*---------------------------------------------------
         Mobile Menu
    ----------------------------------------------------*/
    var ResponsiveMenu = function () {
        $(".carvia-nav-menu-wrap .nav-menu").slicknav({
            allowParentLinks: true,
            prependTo: '#responsive-menu-wrap',
            label: '',
            closedSymbol: '',
            openedSymbol:''
        });
    }

    // Run this code under Elementor.
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/carvia-accordian.default', AccordionHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/carvia-video-popup.default', VideoPopupHandler);   
        elementorFrontend.hooks.addAction('frontend/element_ready/carvia-nav-menu.default', ResponsiveMenu); 
    });
})(jQuery);