(function ($) {
    "use strict";

    var BaseHandler = elementorModules.frontend.handlers.Base;

    var Handler = BaseHandler.extend({

        onInit: function () {
            BaseHandler.prototype.onInit.apply(this, arguments);

            if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined") {
                gsap.registerPlugin(ScrollTrigger);
            }
            if (typeof gsap !== "undefined" && typeof SplitText !== "undefined") {
                gsap.registerPlugin(SplitText) 
            }
            
            /* TEXT SETTINGS */
            this.textAnimation       = this.getElementSettings("text_animation_type");
            this.textPreview        = this.getElementSettings("text_animation_builder_preview");
            this.imageAnimation      = this.getElementSettings("image_animation");
            this.duration            = this.getElementSettings("text_duration") || 1;
            this.delay               = this.getElementSettings("text_delay") || 0;
            this.stagger             = this.getElementSettings("text_stagger") || 0.03;
            this.translateX          = this.getElementSettings("text_translate_x") || 0;
            this.translateY          = this.getElementSettings("text_translate_y") || 40;
            this.ease                = this.getElementSettings("animation_ease") || "power2.out";
            this.onScroll            = this.getElementSettings("text_on_scroll");
            this.rotationDirection   = this.getElementSettings("text_rotation_direction");
            this.rotationAmount      = this.getElementSettings("text_rotation");
            this.moveScrub           = this.getElementSettings("spin_text_scrub");
            this.transformOrigin     = this.getElementSettings("text_transform_origin");
            this.scaleValue          = this.getElementSettings("text_scale_value");
            this.rotationValue       = this.getElementSettings("text_rotation_value");

            /* IMAGE SETTINGS */
            this.imageDirection      = this.getElementSettings("image_direction");
            this.imageScaleStar      = this.getElementSettings("image_scale_start");
            this.imageScaleEnd       = this.getElementSettings("image_scale_end");
            this.imageEaseType       = this.getElementSettings("image_ease");
            this.imagePreview        = this.getElementSettings("image_animation_builder_preview");

            /*------------------------------
             ELEMENT TARGETS
            ------------------------------*/
            this.$heading = this.$element.find(".elementor-heading-title");
            this.$image   = this.$element.find("img");

            this.animateText();
            this.animateImage();
        },

        onElementChange: function (propertyName) {

            if (!elementorFrontend.isEditMode()) return;

            if (propertyName.startsWith("image_")) {

                this.updateSettings();
                this.resetAnimations();

                if (this.imagePreview === "yes") {
                    this.animateImage();
                }

                if (typeof ScrollTrigger !== "undefined") {
                    ScrollTrigger.refresh();
                }
            }

            if (propertyName.startsWith("text_") || propertyName.startsWith("animation_")) {
                this.updateTextSettings();
                this.resetTextAnimation();

                if (this.textPreview === "yes") {
                    this.animateText();
                }

                if (typeof ScrollTrigger !== "undefined") {
                    ScrollTrigger.refresh();
                }
            }

        },

        updateSettings: function () {
            this.imageAnimation  = this.getElementSettings("image_animation");
            this.imageDirection  = this.getElementSettings("image_direction");
            this.imageScaleStar  = this.getElementSettings("image_scale_start");
            this.imageEaseType   = this.getElementSettings("image_ease");
            this.imagePreview    = this.getElementSettings("image_animation_builder_preview");
        },

        updateTextSettings: function () {
            this.textAnimation     = this.getElementSettings("text_animation_type");
            this.textPreview       = this.getElementSettings("text_animation_builder_preview");
            this.duration          = this.getElementSettings("text_duration") || 1;
            this.delay             = this.getElementSettings("text_delay") || 0;
            this.stagger           = this.getElementSettings("text_stagger") || 0.03;
            this.translateX        = this.getElementSettings("text_translate_x") || 0;
            this.translateY        = this.getElementSettings("text_translate_y") || 40;
            this.ease              = this.getElementSettings("animation_ease") || "power2.out";
            this.onScroll          = this.getElementSettings("text_on_scroll");
            this.rotationDirection = this.getElementSettings("text_rotation_direction");
            this.rotationValue     = this.getElementSettings("text_rotation_value");
            this.scaleValue        = this.getElementSettings("text_scale_value");
        },


        /*---------------------------------
         RESET ANIMATIONS
        ----------------------------------*/
        resetAnimations: function () {
            if (!this.$image || !this.$image.length) return;
            gsap.killTweensOf(this.$image);
            gsap.set(this.$image, {
                clearProps: "all"
            });
        },
        resetTextAnimation: function () {
            if (!this.$heading || !this.$heading.length) return;

            gsap.killTweensOf(this.$heading.find("*"));
            gsap.killTweensOf(this.$heading);

            // Restore original text safely
            if (this.$heading.data("original-html")) {
                this.$heading.html(this.$heading.data("original-html"));
            } else {
                this.$heading.data("original-html", this.$heading.html());
            }
        },


        /*---------------------------------
         TEXT ANIMATION
        ----------------------------------*/
        animateText: function () {
            if (!this.$heading.length || !this.textAnimation) return;

            if (elementorFrontend.isEditMode() && this.textPreview !== "yes") {
                return;
            }

            var self = this;
            var scrollConfig = null;

            /*------------------------------
            BASE SCROLL CONFIG
            ------------------------------*/
            if (self.onScroll === "yes") {
                scrollConfig = {
                    trigger: self.$element[0],
                    start: "top 80%",
                    toggleActions: "play none none none"
                };
            }

            /* SPLIT TEXT */
            if (self.textAnimation === "char" || self.textAnimation === "word") {

                 var animationParams = {
                    opacity: 0,
                    x: self.translateX,
                    y: self.translateY,
                    duration: self.duration,
                    delay: self.delay,
                    stagger: self.stagger,
                    ease: self.ease,
                    scrollTrigger: scrollConfig
                };

                document.fonts.ready.then(function () {
                    var split = new SplitText(self.$heading[0], {
                        type: "chars,words"
                    });
                    var targets =
                        self.textAnimation === "word"
                            ? split.words
                            : split.chars;
                    gsap.from(targets, animationParams);
                });
            }

            else if (self.textAnimation === "text_move") {
                var split = new SplitText(self.$heading[0], {type: "lines"});
                    gsap.set(self.$heading[0], {
                    perspective: 600,
                    transformStyle: "preserve-3d",
                });

                var params = {
                    opacity: 0,
                    delay: self.delay,
                    force3D: true,
                    duration: self.duration, 
                    autoAlpha: 0, 
                    stagger: self.stagger,
                    transformOrigin: "50% 50% -50px",
                    scrollTrigger: scrollConfig
                };

                if (self.rotationDirection === "x") {
                    params.rotationX = self.rotationValue;
                }
                if (self.rotationDirection === "y") {
                    params.rotationY = self.rotationValue;
                }

                gsap.from(split.lines, params);
                
            }
            else if (self.textAnimation === "text_scale") {
                var split = new SplitText(self.$heading[0], {
                    type: "lines"
                });
                gsap.from(split.lines, {
                    duration: self.duration,
                    autoAlpha: 0,
                    scale: self.scaleValue,
                    stagger: self.stagger,
                    transformOrigin: "50% 0%",
                    ease: self.ease,
                    delay:self.delay,
                    scrollTrigger: scrollConfig
                });
            }
        },

        /*---------------------------------
         IMAGE ANIMATION
        ----------------------------------*/
        animateImage: function () {

            if (!elementorFrontend.isEditMode() && this.imagePreview !== "yes") return;

            var self  = this;
            var $img  = this.$image;

            if (!$img.length || !self.imageAnimation) return;
            var $wrapper = $img.parent();
            $wrapper.css({ overflow: "hidden" });

            /* IMAGE REVEAL */
            if (self.imageAnimation === "reveal") {
                var params = {
                    scale: self.imageScaleStar || 1.3,
                    autoAlpha: 0,
                    duration: self.duration,
                    ease: self.imageEaseType || "power2.out"
                };

                switch (self.imageDirection) {
                    case "left":   params.xPercent = -100; break;
                    case "right":  params.xPercent = 100;  break;
                    case "top":    params.yPercent = -100; break;
                    case "bottom": params.yPercent = 100;  break;
                }

                gsap.from($img, params);
            }

            /* IMAGE SCALE */
            else if (self.imageAnimation === "scale") {
                gsap.from($img, {
                    scale: self.imageScaleStar || 1.3,
                    autoAlpha: 0,
                    duration: self.duration,
                    ease: self.imageEaseType || "power2.out",
                });
            }
        }
    });

    /* REGISTER */
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/global",
            function ($scope) {
                elementorFrontend.elementsHandler.addHandler(Handler, {
                    $element: $scope
                });
            }
        );
    });


})(jQuery);
