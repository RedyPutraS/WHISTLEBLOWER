"use strict";
jQuery(document).ready(function () {
    jQuery(".post.cymolthemes-box-blog-classic").each(function (index) {
        var $this = jQuery(this);
        $this.find(".cmt-social-share-title").on("click", function () {
            $this.find(".cmt-social-share-post-wrapper").toggleClass("cmt-show-sharelinks");
            return !1;
        });
    });
    jQuery(".widget_nav_menu li a").each(function () {
        if (!jQuery(this).attr("href")) {
            jQuery(this).closest("li").addClass("empty_link");
        }
    });
    jQuery(".cmt-sboxheader-search-link a").addClass("sclose");
    jQuery(".cmt-sboxheader-search-link a").on("click", function () {
        jQuery(".field.searchform-s").focus();
        if (jQuery(".cmt-sboxheader-search-link a").hasClass("sclose")) {
            jQuery(".cmt-sboxheader-search-link a i").removeClass("cmt-duplexo-icon-search").addClass("cmt-duplexo-icon-close");
            jQuery(this).removeClass("sclose").addClass("open");
            jQuery(".cmt-search-overlay").addClass("st-show");
        } else {
            jQuery(this).removeClass("open").addClass("sclose");
            jQuery(".cmt-sboxheader-search-link i").removeClass("cmt-duplexo-icon-close").addClass("cmt-duplexo-icon-search");
            jQuery(".cmt-search-overlay").removeClass("st-show");
        }
    });
    jQuery(".cymolthemes-fbar-btn > a.cymolthemes-fbar-btn-link").on("click", function () {
        if (jQuery(this).closest(".cymolthemes-fbar-main-w").hasClass("cymolthemes-fbar-position-default")) {
            if (jQuery(".cymolthemes-fbar-box-w").css("display") == "none") {
                jQuery(".cmt-sboxfbar-open-icon", this).fadeOut();
                jQuery(".cmt-fbar-close-icon", this).fadeIn();
                jQuery(".cymolthemes-fbar-box-w").slideDown();
            } else {
                jQuery(".cmt-sboxfbar-open-icon", this).fadeIn();
                jQuery(".cmt-fbar-close-icon", this).fadeOut();
                jQuery(".cymolthemes-fbar-box-w").slideUp();
            }
        } else {
        }
        return !1;
    });
    jQuery(".cmt-fbar-close, .cymolthemes-fbar-btn > a.cymolthemes-fbar-btn-link, .cmt-float-overlay").on("click", function () {
        jQuery(".cymolthemes-fbar-box-w").toggleClass("animated");
        jQuery(".cmt-float-overlay").toggleClass("animated");
        jQuery(".cymolthemes-fbar-btn").toggleClass("animated");
    });
    jQuery(".vc_row-o-equal-height, .cmt-sboxequalheightdiv").each(function () {
        var thisRow = jQuery(this);
        jQuery(".wpb_column", thisRow).each(function () {
            var thisColumn = jQuery(this);
            if (
                ((jQuery(".cmt-col-wrapper-bg-layer", thisColumn).length > 0 && jQuery(".cmt-col-wrapper-bg-layer", thisColumn).css("background-image") != "none") ||
                    (jQuery(".vc_column-inner", thisColumn).length > 0 && jQuery(".vc_column-inner", thisColumn).css("background-image") != "none")) &&
                jQuery(".wpb_wrapper", thisColumn).html().trim() == ""
            ) {
                if (jQuery(".cmt-col-wrapper-bg-layer", thisColumn).length > 0 && jQuery(".cmt-col-wrapper-bg-layer", thisColumn).css("background-image") != "none") {
                    var bgimage = jQuery(".cmt-col-wrapper-bg-layer", thisColumn).css("background-image").replace("url(", "");
                    bgimage = bgimage.replace(")", "");
                } else {
                    var bgimage = jQuery(".vc_column-inner", thisColumn).css("background-image").replace("url(", "");
                    bgimage = bgimage.replace(")", "");
                }
                if (jQuery(".cmt-sboxequal-height-image", thisColumn).length == 0) {
                    jQuery(".vc_column-inner", thisColumn).after("<img src=" + bgimage + ' class="cmt-sboxequal-height-image" />');
                }
                jQuery(thisColumn).addClass("cmt-sboxemtydiv");
            }
        });
    });
});
jQuery("#scroll_up").hide();
jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() >= 100) {
        jQuery("#scroll_up").fadeIn(200);
        jQuery("#scroll_up").addClass("top-visible");
    } else {
        jQuery("#scroll_up").fadeOut(200);
        jQuery("#scroll_up").removeClass("top-visible");
    }
});
jQuery("#scroll_up").on("click", function () {
    jQuery("body,html").animate({ scrollTop: 0 }, 500);
    return !1;
});
var equalheight = function (container) {
    var currentTallest = 0,
        currentRowStart = 0,
        rowDivs = new Array(),
        $el,
        topPosition = 0;
    jQuery(container).each(function () {
        $el = jQuery(this);
        jQuery($el).outerHeight("auto");
        topPostion = $el.position().top;
        if (currentRowStart != topPostion) {
            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
            rowDivs.length = 0;
            currentRowStart = topPostion;
            currentTallest = $el.outerHeight();
            rowDivs.push($el);
        } else {
            rowDivs.push($el);
            currentTallest = currentTallest < $el.outerHeight() ? $el.outerHeight() : currentTallest;
        }
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
            rowDivs[currentDiv].outerHeight(currentTallest);
        }
    });
};
function cymolthemes_sticky() {
    if (typeof jQuery.fn.stick_in_parent == "function") {
        var offset_px = 0;
        if (jQuery("body").hasClass("admin-bar")) {
            offset_px = jQuery("#wpadminbar").height();
        }
        var pageWidth = jQuery(window).width();
        if (parseInt(pageWidth) > parseInt(cmt_breakpoint)) {
            jQuery(".cmt-sboxstickable-header").stick_in_parent({ parent: "body", spacer: !1, offset_top: offset_px });
        } else {
            jQuery(".cmt-sboxstickable-header").trigger("sticky_kit:detach");
        }
    }
}
function cymolthemes_setCookie(c_name, value, exdays) {
    var now = new Date();
    var time = now.getTime();
    time += 3600 * 1000 * 24;
    now.setTime(time);
    var c_value = escape(value) + (exdays == null ? "" : "; expires=" + now.toGMTString());
    document.cookie = c_name + "=" + c_value;
}
function setHeight(column) {
    var maxHeight = 0;
    column = jQuery(column);
    column.css("height", "auto");
    if (jQuery(window).width() > 479) {
        column.each(function () {
            if (jQuery(this).height() > maxHeight) {
                maxHeight = jQuery(this).height();
            }
        });
        column.height(maxHeight);
    }
}
if (jQuery(".cmt-sboxsresult-form-wrapper").length > 0) {
    jQuery(".cmt-sboxsresult-form-wrapper .cmt-sboxsresults-settings-btn").on("click", function () {
        jQuery(".cmt-sboxsresult-form-wrapper .cmt-sboxsresult-form-bottom").slideToggle("400", function () {
            if (jQuery(".cmt-sboxsresult-form-wrapper .cmt-sboxsresult-form-bottom").is(":hidden")) {
                jQuery(".cmt-sboxsresult-form-wrapper .cmt-sboxsresults-settings-btn").removeClass("cmt-sboxsresult-btn-active");
            } else {
                jQuery(".cmt-sboxsresult-form-wrapper .cmt-sboxsresults-settings-btn").addClass("cmt-sboxsresult-btn-active");
            }
        });
        return !1;
    });
    if (jQuery(".cmt-sboxsresult-form-wrapper form.search-form").length > 0) {
        if (jQuery(".cmt-sboxsresult-form-wrapper form.search-form input[name='post_type']").length == 0) {
            jQuery("<input>").attr({ type: "hidden", name: "post_type" }).appendTo(".cmt-sboxsresult-form-wrapper form.search-form");
        }
    }
    jQuery(".cmt-sboxsresult-form-wrapper .cmt-sboxsresult-cpt-select").change(function () {
        jQuery(".cmt-sboxsresult-form-wrapper form.search-form input[name='post_type']").val(jQuery(this).val());
    });
    jQuery(".cmt-sboxsresult-form-wrapper .cmt-sboxsresult-form-sbtbtn").on("click", function () {
        jQuery(".cmt-sboxsresult-form-wrapper form.search-form").submit();
    });
}
function cymolthemes_blogmasonry() {
    if (jQuery().isotope) {
        if (jQuery("#content.cymolthemes-blog-col-page").length > 0) {
            jQuery("#content.cymolthemes-blog-col-page").masonry();
            jQuery("#content.cymolthemes-blog-col-page").isotope({ itemSelector: ".post-box", masonry: {}, sortBy: "original-order" });
        }
    }
}
function cymolthemes_stickyFooter() {
    if (jQuery("body").hasClass("cymolthemes-sticky-footer")) {
        jQuery("div#content-wrapper").css("marginBottom", jQuery("footer#colophon").height());
    }
}
function setEmptySelectBox(element) {
    if (jQuery(element).val() == "") {
        jQuery(element).addClass("empty");
    } else {
        jQuery(element).removeClass("empty");
    }
}
function cymolthemes_hide_togle_link() {
    if (jQuery("#navbar div.mega-menu-wrap ul.mega-menu").length > 0) {
        jQuery("h3.menu-toggle").css("display", "none");
    }
}
function cymolthemes_reset_gmap() {
    jQuery(".cymolthemes-fbar-box-w > div > aside").each(function () {
        var mainthis = jQuery(this);
        jQuery('iframe[src^="https://www.google.com/maps/"], iframe[src^="http://www.google.com/maps/"]', mainthis).each(function () {
            if (!jQuery(this).hasClass("cymolthemes-set-gmap")) {
                jQuery(this).attr("src", jQuery(this).attr("src") + "");
                jQuery(this).load(function () {
                    jQuery(this).addClass("cymolthemes-set-gmap").animate({ opacity: 1 }, 1000);
                });
            }
        });
    });
}
function cymolthemes_hide_gmap() {
    jQuery(".cymolthemes-fbar-box-w > div > aside").each(function () {
        var mainthis = jQuery(this);
        jQuery('iframe[src^="https://www.google.com/maps/"], iframe[src^="http://www.google.com/maps/"]', mainthis).each(function () {
            if (!jQuery(this).hasClass("cymolthemes-set-gmap")) {
                jQuery(this).css({ opacity: 0 });
                jQuery(this).css("display", "block");
            }
        });
    });
}
function cymolthemes_isotope() {
    jQuery(".cymolthemes-boxes-sortable-yes").each(function () {
        var gallery_item = jQuery(".cymolthemes-boxes-row-wrapper", this);
        var filterLinks = jQuery(".cmt-sboxsortable-wrapper a", this);
        gallery_item.isotope({ animationEngine: "best-available" });
        filterLinks.on("click", function (e) {
            var selector = jQuery(this).attr("data-filter");
            gallery_item.isotope({ filter: selector, itemSelector: ".isotope-item" });
            filterLinks.removeClass("selected");
            jQuery("#filter-by li").removeClass("current-cat");
            jQuery(this).addClass("selected");
            e.preventDefault();
        });
    });
}
function duplexo_logMarginPadding() {
    jQuery(".wpb_column").each(function () {
        if (jQuery(this).hasClass("cmt-sboxleft-span")) {
            var margin = jQuery(this).parent().css("padding-left").replace("px", "");
            margin = parseInt(margin);
            var elewidth = jQuery(this).css("width").replace("px", "");
            elewidth = parseInt(elewidth);
            var leftmargin = margin + elewidth;
            var after_inlinecss = "";
            var before_inlinecss = "";
            var randomclass = Math.floor(Math.random() * 1000000 + 1);
            randomclass = "duplexo-random-class-" + randomclass;
            jQuery(this).addClass(randomclass);
            after_inlinecss += "padding-left: " + leftmargin + "px;";
            if (jQuery(".vc_column-inner", this).css("background-image") != "none") {
                var bgimage = jQuery(".vc_column-inner", this).css("background-image");
                jQuery(".vc_column-inner", this).css("background-image", "none", "!important");
                after_inlinecss += "background-image: " + bgimage + ";";
            }
            if (jQuery(".vc_column-inner", this).css("background-color") != "" || jQuery(".vc_column-inner", this).css("background-color") != "inherit") {
                var bgcolor = jQuery(".vc_column-inner", this).css("background-color");
                before_inlinecss += "background-color: " + bgcolor + ";";
            }
            if (after_inlinecss != "" || before_inlinecss != "") {
                jQuery("head").append("<style>." + randomclass + ":after{" + after_inlinecss + "} ." + randomclass + ":before{" + before_inlinecss + "} .cmt-sboxleft-span .vc_column-inner{background-image:none !important;}</style>");
            }
        }
    });
}
function duplexo_logMarginPadding_right() {
    jQuery(".wpb_column").each(function () {
        if (jQuery(this).hasClass("cmt-sboxright-span")) {
            var margin = jQuery(this).parent().css("padding-right").replace("px", "");
            margin = parseInt(margin);
            var elewidth = jQuery(this).css("width").replace("px", "");
            elewidth = parseInt(elewidth);
            var leftmargin = margin + elewidth;
            var after_inlinecss = "";
            var before_inlinecss = "";
            var randomclass = Math.floor(Math.random() * 1000000 + 1);
            randomclass = "duplexo-random-class-" + randomclass;
            jQuery(this).addClass(randomclass);
            after_inlinecss += "padding-right: " + leftmargin + "px;";
            if (jQuery(".vc_column-inner", this).css("background-image") != "none") {
                var bgimage = jQuery(".vc_column-inner", this).css("background-image");
                jQuery(".vc_column-inner", this).css("background-image", "none", "!important");
                after_inlinecss += "background-image: " + bgimage + ";";
            }
            if (jQuery(".vc_column-inner", this).css("background-color") != "" || jQuery(".vc_column-inner", this).css("background-color") != "inherit") {
                var bgcolor = jQuery(".vc_column-inner", this).css("background-color");
                before_inlinecss += "background-color: " + bgcolor + ";";
            }
            if (after_inlinecss != "" || before_inlinecss != "") {
                jQuery("head").append("<style>." + randomclass + ":after{" + after_inlinecss + "} ." + randomclass + ":before{" + before_inlinecss + "} .cmt-sboxright-span .vc_column-inner{background-image:none !important;}</style>");
            }
        }
    });
}
jQuery(document).ready(function ($) {
    "use strict";
    cymolthemes_hide_gmap();
    // jQuery("#site-header-menu #site-navigation div.nav-menu > ul > li:has(ul), .cmt-mmmenu-override-yes #site-header-menu #site-navigation .mega-menu-wrap > ul > li:has(ul)").append(
    //     "<span class='righticon'><i class='fa fa-fw fa-angle-down'></i></span>"
    // );
    jQuery(".cmt-mmmenu-override-yes #site-navigation .mega-menu-wrap > ul > li.menu-item-language ul").addClass("mega-sub-menu");
    jQuery(".cmt-mmmenu-override-yes #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.menu-item-language > a").show();
    jQuery(".cmt-mmmenu-override-yes #site-navigation .mega-menu-wrap > ul > li.menu-item-language").hover(
        function () {
            jQuery(".cmt-mmmenu-override-yes #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-menu-flyout .mega-sub-menu").css("display", "none");
            jQuery(this).find("ul").show();
        },
        function () {
            jQuery(this).find("ul").hide();
        }
    );
    jQuery(".menu li.current-menu-item").parents("li.mega-menu-megamenu").addClass("mega-current-menu-ancestor");
    if (!jQuery("body").hasClass("cmt-header-invert")) {
        jQuery(".nav-menu ul:not(.children,.sub-menu) > li:eq(-2), #site-header-menu #site-navigation div.mega-menu-wrap ul.mega-menu.mega-menu-horizontal > li:eq(-2)").addClass("lastsecond");
        jQuery(".nav-menu ul:not(.children,.sub-menu) > li:eq(-1), #site-header-menu #site-navigation div.mega-menu-wrap ul.mega-menu.mega-menu-horizontal > li:eq(-1)").addClass("last");
    }
    jQuery(".righticon").on("click", function () {
        if (jQuery(this).siblings(".sub-menu, .children, .mega-sub-menu").hasClass("open")) {
            jQuery(this).siblings(".sub-menu, .children, .mega-sub-menu").removeClass("open");
            jQuery("i", jQuery(this)).removeClass("fa fa-fw fa-angle-up").addClass("fa fa-fw fa-angle-down");
        } else {
            jQuery(this).siblings(".sub-menu, .children, .mega-sub-menu").addClass("open");
            jQuery("i", jQuery(this)).removeClass("fa fa-fw fa-angle-down").addClass("fa fa-fw fa-angle-up");
        }
        return !1;
    });
    jQuery("a[data-gal^='prettyPhoto']").prettyPhoto({ hook: "data-gal" });
    jQuery(".cymolthemes-slider-wrapper > div > div > div:contains('Revolution Slider Error')").css("margin-top", "0");
    jQuery(".select2").select2();
    duplexo_logMarginPadding();
    duplexo_logMarginPadding_right();
    jQuery(".cymolthemes-row-fullwidth-true.full-colum-height-widht > .grid_section > .vc_column_container img.vc_single_image-img").each(function () {
        var imgsrc = jQuery(this).attr("src");
        jQuery(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .parent(".vc_column_container")
            .css("background-image", "url(" + imgsrc + ")");
    });
    if (typeof jQuery.fn.prettyPhoto == "function") {
        jQuery('div.gallery a[href*=".jpg"], div.gallery a[href*=".jpeg"], div.gallery a[href*=".png"], div.gallery a[href*=".gif"]').each(function () {
            if (jQuery(this).attr("target") != "_blank") {
                jQuery(this).attr("rel", "prettyPhoto[wp-gallery]");
            }
        });
        jQuery('.gallery-item a[href*=".jpg"], .gallery-item a[href*=".jpeg"], .gallery-item a[href*=".png"], .gallery-item a[href*=".gif"]').each(function () {
            if (jQuery(this).attr("target") != "_blank") {
                jQuery(this).attr("rel", "prettyPhoto[coregallery]");
            }
        });
        jQuery('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"]').each(function () {
            if (jQuery(this).attr("target") != "_blank" && !jQuery(this).hasClass("prettyphoto")) {
                var attr = $(this).attr("rel");
                if (typeof attr !== typeof undefined && attr !== !1 && attr != "prettyPhoto") {
                    jQuery(this).attr("data-rel", "prettyPhoto");
                }
            }
        });
        jQuery('a[data-rel^="prettyPhoto"]').prettyPhoto();
        jQuery("a.cmt_prettyphoto, div.cmt_prettyphoto a").prettyPhoto();
        jQuery('a[rel^="prettyPhoto"]').prettyPhoto();
        jQuery("a.cymolthemes-open-gallery").on("click", function () {
            var id = jQuery(this).data("id");
            var currid = window["api_images_" + id];
            jQuery.prettyPhoto.open(window["api_images_" + id], window["api_titles_" + id], window["api_desc_" + id]);
        });
    }
    $("[data-appear-animation]").each(function () {
        var self = $(this);
        var animation = self.data("appear-animation");
        var delay = self.data("appear-animation-delay") ? self.data("appear-animation-delay") : 0;
        if ($(window).width() > 959) {
            self.html("0");
            self.waypoint(
                function (direction) {
                    if (!self.hasClass("completed")) {
                        var from = self.data("from");
                        var to = self.data("to");
                        var interval = self.data("interval");
                        self.numinate({
                            format: "%counter%",
                            from: from,
                            to: to,
                            runningInterval: 2000,
                            stepUnit: interval,
                            onComplete: function (elem) {
                                self.addClass("completed");
                            },
                        });
                    }
                },
                { offset: "85%" }
            );
        } else {
            if (animation == "animateWidth") {
                self.css("width", self.data("width"));
            }
        }
    });
    if (jQuery(".cymolthemes-testimonial-box").length > 0) {
        setHeight(".cymolthemes-testimonial-box.col-lg-6.col-sm-6.col-md-6");
        setHeight(".cymolthemes-testimonial-box.col-lg-4.col-sm-6.col-md-4");
        setHeight(".cymolthemes-testimonial-box.col-lg-3.col-sm-6.col-md-3");
    }
    if (jQuery(".cmt-sboxstickable-header").length > 0) {
        cymolthemes_sticky();
    }
    $('#site-navigation a[href="#"]').on("click", function () {
        return !1;
    });
    $(".cymolthemes-close-icon").on("click", function () {
        $("#page").css("padding-top", parseInt($("#page").css("padding-top")) - parseInt($(".cymolthemes-wbar").height()) + "px");
        $(".cymolthemes-wbar").slideUp();
        cymolthemes_setCookie("kw_hidewbar", "1", 1);
    });
    var galleryHTML = jQuery(".gallery-size-full br").each(function () {
        jQuery(this).remove();
    });
    jQuery("a.cymolthemes-open-gallery").on("click", function () {
        var href = jQuery(this).attr("href");
        var id = href.replace("#cymolthemes-embed-code-", "");
        var currid = window["api_images_" + id];
        jQuery.prettyPhoto.open(window["api_images_" + id], window["api_titles_" + id], window["api_desc_" + id]);
    });
    if (jQuery().isotope) {
        jQuery(window).load(function () {
            "use strict";
            cymolthemes_isotope();
        });
        jQuery(window).resize(function () {
            cymolthemes_isotope();
        });
    }
    jQuery("footer#colophon").resize(function () {
        cymolthemes_stickyFooter();
    });
    cymolthemes_stickyFooter();
    equalheight(".cmt-sboxequalheightdiv  .wpb_column.vc_column_container");
    cymolthemes_hide_togle_link();
    jQuery("#cmt-sboxheader-slider > div > div:contains('Revolution Slider Error')").css("margin", "auto");
    $.fn.smTimeline = function (option, value) {
        jQuery(this).each(function () {
            var $sm_timeline = jQuery(this);
            var is_mobile_view = jQuery(window).width() < 768;
            $sm_timeline.find(".timeline-element").each(function () {
                var $this = jQuery(this);
                var $timeline_spine = $this.find(".cmt-sboxtimeline-spine");
                if (is_mobile_view) {
                    $this.addClass("wow fadeInUp");
                    $timeline_spine.attr("style", "");
                } else {
                    if ($this.hasClass("left-side")) {
                        $this.find(".cmt-sboxanimation-wrap").addClass("wow fadeInLeft");
                    } else if ($this.hasClass("right-side")) {
                        $this.find(".cmt-sboxanimation-wrap").addClass("wow fadeInRight");
                    }
                    if ($this.next().length == 0) return;
                    var $next = $this.next();
                    var $next_tl_spine = $next.find(".cmt-sboxtimeline-spine");
                    if ($next.hasClass("cmt-sboxdate-separator")) {
                        $timeline_spine.height($next.offset().top - $timeline_spine.offset().top - 5);
                    } else if ($next_tl_spine.length) {
                        $timeline_spine.height($next_tl_spine.offset().top - $timeline_spine.offset().top - 25);
                    }
                }
            });
        });
    };
    jQuery(".cymolthemes-boxes-view-carousel").each(function () {
        var thisElement = jQuery(this);
        var cmt_column = 3;
        var cmt_slidestoscroll = 3;
        var cmt_slidestoscroll_1200 = 3;
        var cmt_slidestoscroll_992 = 2;
        var cmt_slidestoscroll_768 = 2;
        var cmt_slidestoscroll_574 = 1;
        var cmt_slidestoscroll_0 = 1;
        if (jQuery(this).data("cmt-sboxslidestoscroll") == "1") {
            var cmt_slidestoscroll = 1;
            var cmt_slidestoscroll_1200 = 1;
            var cmt_slidestoscroll_992 = 1;
            var cmt_slidestoscroll_768 = 1;
            var cmt_slidestoscroll_574 = 1;
            var cmt_slidestoscroll_0 = 1;
        }
        var cmt_responsive = [
            { breakpoint: 1200, settings: { slidesToShow: 3, slidesToScroll: cmt_slidestoscroll_1200 } },
            { breakpoint: 992, settings: { slidesToShow: 2, slidesToScroll: cmt_slidestoscroll_992 } },
            { breakpoint: 768, settings: { slidesToShow: 2, slidesToScroll: cmt_slidestoscroll_768 } },
            { breakpoint: 574, settings: { slidesToShow: 1, slidesToScroll: cmt_slidestoscroll_574 } },
            { breakpoint: 0, settings: { slidesToShow: 1, slidesToScroll: cmt_slidestoscroll_0 } },
        ];
        if (jQuery(this).hasClass("cymolthemes-boxes-col-three")) {
            cmt_column = 3;
            cmt_slidestoscroll = 3;
            var cmt_slidestoscroll_1200 = 3;
            var cmt_slidestoscroll_992 = 2;
            var cmt_slidestoscroll_768 = 2;
            var cmt_slidestoscroll_574 = 1;
            var cmt_slidestoscroll_0 = 1;
            if (jQuery(this).data("cmt-sboxslidestoscroll") == "1") {
                var cmt_slidestoscroll = 1;
                var cmt_slidestoscroll_1200 = 1;
                var cmt_slidestoscroll_992 = 1;
                var cmt_slidestoscroll_768 = 1;
                var cmt_slidestoscroll_574 = 1;
                var cmt_slidestoscroll_0 = 1;
            }
            cmt_responsive = [
                { breakpoint: 1200, settings: { slidesToShow: 3, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_1200 } },
                { breakpoint: 992, settings: { slidesToShow: 2, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_992 } },
                { breakpoint: 768, settings: { slidesToShow: 2, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_768 } },
                { breakpoint: 574, settings: { slidesToShow: 1, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_574 } },
                { breakpoint: 0, settings: { slidesToShow: 1, slidesToScroll: cmt_slidestoscroll_0 } },
            ];
        } else if (jQuery(this).hasClass("cymolthemes-boxes-col-one")) {
            cmt_column = 1;
            cmt_slidestoscroll = 1;
            cmt_responsive = [
                { breakpoint: 1200, settings: { slidesToShow: 1, slidesToScroll: 1, centerMode: !1, centerPadding: "0px", arrows: !0 } },
                { breakpoint: 768, settings: { slidesToShow: 1, slidesToScroll: 1, centerMode: !1, centerPadding: "0px", arrows: !0 } },
                { breakpoint: 574, settings: { slidesToShow: 1, centerMode: !1, centerPadding: "0px", slidesToScroll: 1 } },
                { breakpoint: 0, settings: { slidesToShow: 1, slidesToScroll: 1 } },
            ];
        } else if (jQuery(this).hasClass("cymolthemes-boxes-col-two")) {
            cmt_column = 2;
            cmt_slidestoscroll = 2;
            var cmt_slidestoscroll_1200 = 2;
            var cmt_slidestoscroll_768 = 2;
            var cmt_slidestoscroll_574 = 1;
            var cmt_slidestoscroll_0 = 1;
            if (jQuery(this).data("cmt-sboxslidestoscroll") == "1") {
                var cmt_slidestoscroll = 1;
                var cmt_slidestoscroll_1200 = 1;
                var cmt_slidestoscroll_768 = 1;
                var cmt_slidestoscroll_574 = 1;
                var cmt_slidestoscroll_0 = 1;
            }
            cmt_responsive = [
                { breakpoint: 1200, settings: { slidesToShow: 2, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_1200 } },
                { breakpoint: 768, settings: { slidesToShow: 2, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_768 } },
                { breakpoint: 574, settings: { slidesToShow: 1, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_574 } },
                { breakpoint: 0, settings: { slidesToShow: 1, slidesToScroll: cmt_slidestoscroll_0 } },
            ];
        } else if (jQuery(this).hasClass("cymolthemes-boxes-col-four")) {
            cmt_column = 4;
            cmt_slidestoscroll = 4;
            var cmt_slidestoscroll_1200 = 4;
            var cmt_slidestoscroll_992 = 3;
            var cmt_slidestoscroll_768 = 2;
            var cmt_slidestoscroll_574 = 1;
            var cmt_slidestoscroll_0 = 1;
            if (jQuery(this).data("cmt-sboxslidestoscroll") == "1") {
                var cmt_slidestoscroll = 1;
                var cmt_slidestoscroll_1200 = 1;
                var cmt_slidestoscroll_992 = 1;
                var cmt_slidestoscroll_768 = 1;
                var cmt_slidestoscroll_574 = 1;
                var cmt_slidestoscroll_0 = 1;
            }
            cmt_responsive = [
                { breakpoint: 1200, settings: { slidesToShow: 4, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_1200 } },
                { breakpoint: 992, settings: { slidesToShow: 3, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_992 } },
                { breakpoint: 768, settings: { slidesToShow: 2, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_768 } },
                { breakpoint: 574, settings: { slidesToShow: 1, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_574 } },
                { breakpoint: 0, settings: { slidesToShow: 1, slidesToScroll: cmt_slidestoscroll_0 } },
            ];
        } else if (jQuery(this).hasClass("cymolthemes-boxes-col-five")) {
            cmt_column = 5;
            cmt_slidestoscroll = 5;
            var cmt_slidestoscroll_1200 = 5;
            var cmt_slidestoscroll_768 = 3;
            var cmt_slidestoscroll_574 = 1;
            var cmt_slidestoscroll_0 = 1;
            if (jQuery(this).data("cmt-sboxslidestoscroll") == "1") {
                var cmt_slidestoscroll = 1;
                var cmt_slidestoscroll_1200 = 1;
                var cmt_slidestoscroll_768 = 1;
                var cmt_slidestoscroll_574 = 1;
                var cmt_slidestoscroll_0 = 1;
            }
            cmt_responsive = [
                { breakpoint: 1200, settings: { slidesToShow: 5, slidesToScroll: cmt_slidestoscroll_1200, centerMode: !1, centerPadding: "0px" } },
                { breakpoint: 768, settings: { slidesToShow: 3, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_768 } },
                { breakpoint: 574, settings: { slidesToShow: 1, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_574 } },
                { breakpoint: 0, settings: { slidesToShow: 1, slidesToScroll: cmt_slidestoscroll_0 } },
            ];
        } else if (jQuery(this).hasClass("cymolthemes-boxes-col-six")) {
            cmt_column = 6;
            cmt_slidestoscroll = 6;
            var cmt_slidestoscroll_1200 = 6;
            var cmt_slidestoscroll_768 = 3;
            var cmt_slidestoscroll_574 = 1;
            var cmt_slidestoscroll_0 = 1;
            if (jQuery(this).data("cmt-sboxslidestoscroll") == "1") {
                var cmt_slidestoscroll = 1;
                var cmt_slidestoscroll_1200 = 1;
                var cmt_slidestoscroll_768 = 1;
                var cmt_slidestoscroll_574 = 1;
                var cmt_slidestoscroll_0 = 1;
            }
            cmt_responsive = [
                { breakpoint: 1200, settings: { slidesToShow: 6, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_1200 } },
                { breakpoint: 768, settings: { slidesToShow: 3, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_768 } },
                { breakpoint: 574, settings: { slidesToShow: 1, centerMode: !1, centerPadding: "0px", slidesToScroll: cmt_slidestoscroll_574 } },
                { breakpoint: 0, settings: { slidesToShow: 1, slidesToScroll: cmt_slidestoscroll_0 } },
            ];
        }
        var cmt_fade = !1;
        if (jQuery(this).data("cmt-sboxeffecttype") == "fade") {
            cmt_fade = !0;
        }
        var cmt_speed = 800;
        if (jQuery.trim(jQuery(this).data("cmt-sboxspeed")) != "") {
            cmt_speed = jQuery.trim(jQuery(this).data("cmt-sboxspeed"));
        }
        var cmt_autoplay = !1;
        if (jQuery(this).data("cmt-sboxautoplay") == "1") {
            cmt_autoplay = !0;
        }
        var cmt_autoplayspeed = 2000;
        if (jQuery.trim(jQuery(this).data("cmt-sboxautoplayspeed")) != "") {
            cmt_autoplayspeed = jQuery.trim(jQuery(this).data("cmt-sboxautoplayspeed"));
        }
        var cmt_loop = !1;
        if (jQuery.trim(jQuery(this).data("cmt-sboxloop")) == "1") {
            cmt_loop = !0;
        }
        var cmt_dots = !1;
        if (jQuery.trim(jQuery(this).data("cmt-sboxdots")) == "1") {
            cmt_dots = !0;
        }
        var cmt_nav = !1;
        if (jQuery.trim(jQuery(this).data("cmt-sboxnav")) == "1" || jQuery.trim(jQuery(this).data("cmt-sboxnav")) == "above" || jQuery.trim(jQuery(this).data("cmt-sboxnav")) == "below") {
            cmt_nav = !0;
        }
        var cmt_centermode = !1;
        if (jQuery.trim(jQuery(this).data("cmt-sboxcentermode")) == "1") {
            cmt_centermode = !0;
        }
        var cmt_centerpadding = 800;
        if (jQuery.trim(jQuery(this).data("cmt-sboxcenterpadding")) != "") {
            var cmt_centerpadding = jQuery.trim(jQuery(this).data("cmt-sboxcenterpadding"));
        }
        var cmt_pauseonfocus = !1;
        if (jQuery.trim(jQuery(this).data("cmt-sboxpauseonfocus")) == "1") {
            cmt_pauseonfocus = !0;
        }
        var cmt_pauseonhover = !1;
        if (jQuery.trim(jQuery(this).data("cmt-pauseonhover")) == "1") {
            cmt_pauseonhover = !0;
        }
        var cmt_rtl = !1;
        if (jQuery("body").hasClass("rtl")) {
            cmt_rtl = !0;
        }
        jQuery(".cymolthemes-boxes-row-wrapper > div", this).removeClass(function (index, css) {
            return (css.match(/(^|\s)col-\S+/g) || []).join(" ");
        });
        jQuery(".cymolthemes-boxes-row-wrapper", this).slick({
            fade: cmt_fade,
            speed: cmt_speed,
            centerMode: cmt_centermode,
            centerPadding: cmt_centerpadding + "px",
            pauseOnFocus: cmt_pauseonfocus,
            pauseOnHover: cmt_pauseonhover,
            slidesToShow: cmt_column,
            slidesToScroll: cmt_slidestoscroll,
            autoplay: cmt_autoplay,
            autoplaySpeed: cmt_autoplayspeed,
            rtl: cmt_rtl,
            dots: cmt_dots,
            pauseOnDotsHover: !1,
            arrows: cmt_nav,
            adaptiveHeight: !1,
            infinite: cmt_loop,
            responsive: cmt_responsive,
        });
    });
    jQuery(".cymolthemes-boxes-row-wrapper", this).on("setPosition", function (event, slick) {
        jQuery(this)
            .find(".cmt-sboxflexslider")
            .each(function () {
                jQuery(this).resize();
            });
    });
    jQuery(".cmt-slick-arrow.cmt-slick-next", this).on("click", function () {
        jQuery(".cymolthemes-boxes-row-wrapper", jQuery(this).closest(".cymolthemes-boxes-view-carousel")).slick("slickNext");
    });
    jQuery(".cmt-slick-arrow.cmt-sboxslick-prev", this).on("click", function () {
        jQuery(".cymolthemes-boxes-row-wrapper", jQuery(this).closest(".cymolthemes-boxes-view-carousel")).slick("slickPrev");
    });
    jQuery(".cymolthemes-boxes-view-slickview,.cymolthemes-boxes-view-slickview-leftimg").each(function () {
        var cmt_fade = !1;
        if (jQuery(this).data("cmt-sboxeffecttype") == "fade") {
            cmt_fade = !0;
        }
        var cmt_speed = 800;
        if (jQuery.trim(jQuery(this).data("cmt-sboxspeed")) != "") {
            cmt_speed = jQuery.trim(jQuery(this).data("cmt-sboxspeed"));
        }
        var cmt_autoplay = !1;
        if (jQuery(this).data("cmt-sboxautoplay") == "1") {
            cmt_autoplay = !0;
        }
        var cmt_autoplayspeed = 2000;
        if (jQuery.trim(jQuery(this).data("cmt-autoplayspeed")) != "") {
            cmt_autoplayspeed = jQuery.trim(jQuery(this).data("cmt-autoplayspeed"));
        }
        var cmt_loop = !1;
        if (jQuery.trim(jQuery(this).data("cmt-loop")) == "1") {
            cmt_loop = !0;
        }
        var cmt_dots = !1;
        if (jQuery.trim(jQuery(this).data("cmt-dots")) == "1") {
            cmt_dots = !0;
        }
        var cmt_nav = !1;
        if (jQuery.trim(jQuery(this).data("cmt-nav")) == "1") {
            cmt_nav = !0;
        }
        var testinav = jQuery(".testimonials-nav", this);
        var testiinfo = jQuery(".testimonials-info", this);
        var rtloption = !1;
        if (jQuery("body").hasClass("rtl")) {
            rtloption = !0;
        }
        jQuery(".testimonials-info", this).slick({ fade: cmt_fade, arrows: !0, asNavFor: testinav, adaptiveHeight: !0, speed: cmt_speed, autoplay: cmt_autoplay, autoplaySpeed: cmt_autoplayspeed, infinite: cmt_loop, rtl: rtloption });
        jQuery(".testimonials-nav", this).slick({
            slidesToShow: 1,
            asNavFor: testiinfo,
            centerMode: !0,
            centerPadding: 0,
            focusOnSelect: !0,
            autoplay: cmt_autoplay,
            autoplaySpeed: cmt_autoplayspeed,
            speed: cmt_speed,
            arrows: cmt_nav,
            dots: cmt_dots,
            variableWidth: !0,
            infinite: cmt_loop,
            rtl: rtloption,
        });
    });
    if (jQuery("body").hasClass("cymolthemes-one-page-site")) {
        var sections = jQuery(".cmt-row, #cmt-sboxheader-slider"),
            nav = jQuery(".mega-menu-wrap, div.nav-menu"),
            nav_height = jQuery("#site-navigation").data("sticky-height") - 1;
        jQuery(window).on("scroll", function () {
            if (jQuery("body").scrollTop() < 5) {
                nav.find("a").parent().removeClass("mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item");
                nav.find('a[href="#cmt-home"]').parent().addClass("mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item");
            }
            var cur_pos = jQuery(this).scrollTop();
            sections.each(function () {
                var top = jQuery(this).offset().top - (nav_height + 2),
                    bottom = top + jQuery(this).outerHeight();
                if (cur_pos >= top && cur_pos <= bottom) {
                    if (typeof jQuery(this) != "undefined" && typeof jQuery(this).attr("id") != "undefined" && jQuery(this).attr("id") != "") {
                        var mainThis = jQuery(this);
                        nav.find("a").removeClass("mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item");
                        jQuery(this).addClass("mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item");
                        var arr = mainThis.attr("id");
                        nav.find("a").parent().removeClass("mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item");
                        nav.find("a").each(function () {
                            var menuAttr = jQuery(this).attr("href").split("#")[1];
                            if (menuAttr == arr) {
                                jQuery(this).parent().addClass("mega-current-menu-item mega-current_page_item current-menu-ancestor current-menu-item current_page_item");
                            }
                        });
                    }
                }
            });
        });
        nav.find("a").on("click", function () {
            var $el = jQuery(this),
                id = $el.attr("href");
            var arr = id.split("#")[1];
            jQuery("html, body").animate({ scrollTop: jQuery("#" + arr).offset().top - nav_height }, 500);
            return !1;
        });
    }
});
jQuery(window).load(function () {
    "use strict";
    if (jQuery(".cmt-sboxflexslider").length > 0) {
        jQuery(".cmt-sboxflexslider").flexslider({
            animation: "slide",
            controlNav: !0,
            directionNav: !1,
            start: function () {
                if (jQuery(".cmt-sboxtimeline").length > 0) {
                    jQuery(".cmt-sboxtimeline").smTimeline();
                }
            },
        });
    }
    function cymolthemes_preloader_fade_out() {
        jQuery(".cmt-sboxpage-loader-wrapper").fadeOut(1000);
    }
    if (jQuery(".cmt-sboxpage-loader-wrapper").length > 0) {
        setTimeout(cymolthemes_preloader_fade_out, 100);
    }
    jQuery("#pageoverlay").fadeOut(500);
    var $container = jQuery(".portfolio-wrapper");
    $container.isotope({ filter: "*", animationOptions: { duration: 750, easing: "linear", queue: !1 } });
    jQuery("nav.portfolio-sortable-list ul li a").on("click", function () {
        var selector = jQuery(this).attr("data-filter");
        $container.isotope({ filter: selector, animationOptions: { duration: 750, easing: "linear", queue: !1 } });
        jQuery("nav.portfolio-sortable-list").find("a.selected").removeClass("selected");
        jQuery(this).addClass("selected");
        return !1;
    });
    if (jQuery(".cymolthemes-slider-wrapper .nivoSlider").length > 0) {
        jQuery(".cymolthemes-slider-wrapper .nivoSlider").nivoSlider();
    }
    var rtloption = !1;
    if (jQuery("body").hasClass("rtl")) {
        rtloption = !0;
    }
    jQuery(".cmt-sboxslick-carousel").slick({ autoplay: !0, arrows: !1, dots: !0, rtl: rtloption });
    (function () {
        var nav = jQuery("#site-navigation"),
            button,
            menu;
        if (!nav) return;
        button = nav.find(".menu-toggle");
        if (!button) return;
        menu = nav.find(".nav-menu");
        if (!menu || !menu.children().length) {
            button.hide();
            return;
        }
        jQuery(".menu-toggle").on("click.duplexo", function () {
            nav.toggleClass("toggled-on");
        });
    })();
    jQuery(".righticon").each(function () {
        var mainele = this;
        if (jQuery(mainele).prev().prev().length > 0) {
            if (jQuery(mainele).prev().prev().attr("href") == "#") {
                jQuery(mainele)
                    .prev()
                    .prev()
                    .on("click", function () {
                        jQuery(mainele).trigger("click");
                    });
            }
        }
    });
    cymolthemes_blogmasonry();
    jQuery(".cymolthemes-fbar-content-wrapper").perfectScrollbar({ suppressScrollX: !0, includePadding: !0 });
    jQuery(".header-style-one-vertical .cmt-header-box").perfectScrollbar({ suppressScrollX: !0, includePadding: !0 });
});
jQuery(window).resize(function () {
    "use strict";
    equalheight(".cmt-sboxequalheightdiv  .wpb_column.vc_column_container");
    setTimeout(function () {
        jQuery(".cmt-sboxtimeline").smTimeline();
    }, 100);
    if (jQuery(".cymolthemes-testimonial-box").length > 0) {
        setHeight(".cymolthemes-testimonial-box.col-lg-4.col-sm-6.col-md-4");
        setHeight(".cymolthemes-testimonial-box.col-lg-6.col-sm-6.col-md-6");
        setHeight(".cymolthemes-testimonial-box.col-lg-3.col-sm-6.col-md-3");
    }
    cymolthemes_sticky();
});
