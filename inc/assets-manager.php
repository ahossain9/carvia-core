<?php

/**
 * carvia core assets manager
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Inc;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Assets
{
    /**
     * Instance
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.2.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        // get_style_depends() / get_script_depends() on pages that use the widget.
        add_action('elementor/frontend/after_register_styles',   [$this, 'register_frontend_styles']);
        add_action('elementor/frontend/after_register_scripts',  [$this, 'register_frontend_scripts']);
        // Always load the editor-only stylesheet inside the Elementor editor.
        add_action('elementor/editor/after_enqueue_styles', [$this, 'carvia_core_editor_styles']);
        // Load globally ( every page ).
        add_action('elementor/frontend/after_enqueue_styles',   [$this, 'enqueue_global_styles']);
        add_action('elementor/frontend/after_enqueue_scripts',  [$this, 'enqueue_global_scripts']);
    }

    /**
     * Enqueue the Elementor editor stylesheet.
     */
    public function carvia_core_editor_styles()
    {
        wp_enqueue_style(
            'carvia-core-elementor-editor',
            CARVIA_CORE_ASSETS . 'css/elementor-editor.css',
            [],
            CARVIA_CORE_VERSION
        );
    }

    /**
     * Register all frontend styles.
     */
    public function register_frontend_styles()
    {
        wp_register_style('swiper-style', CARVIA_CORE_ASSETS . 'css/swiper.min.css', [], CARVIA_CORE_VERSION);
        wp_register_style('magnific-popup-style', CARVIA_CORE_ASSETS . 'css/magnific-popup.css', [], CARVIA_CORE_VERSION);
        wp_register_style('carvia-core-styles', CARVIA_CORE_ASSETS . 'css/style.min.css', [], CARVIA_CORE_VERSION);
    }

    /**
     * Enqueue global styles.
     */
    public function enqueue_global_styles()
    {
        wp_enqueue_style('carvia-core-styles');
    }

    /**
     * Register all frontend scripts.
     */
    public function register_frontend_scripts()
    {
        wp_register_script('swiper-slider', CARVIA_CORE_ASSETS . 'js/swiper.min.js', ['jquery'], CARVIA_CORE_VERSION, true);
        wp_register_script('swiper-activation', CARVIA_CORE_ASSETS . 'js/swiper-active.js', ['jquery', 'swiper-slider'], CARVIA_CORE_VERSION, true);
        wp_register_script('gsap', CARVIA_CORE_ASSETS . 'js/gsap.min.js', ['jquery'], CARVIA_CORE_VERSION, true);
        wp_register_script('gsap-scrolltrigger', CARVIA_CORE_ASSETS . 'js/ScrollTrigger.min.js', ['jquery', 'gsap'], CARVIA_CORE_VERSION, true);
        wp_register_script('gsap-splittext', CARVIA_CORE_ASSETS . 'js/SplitText.min.js', ['jquery', 'gsap'], CARVIA_CORE_VERSION, true);
        wp_register_script('gsap-animation', CARVIA_CORE_ASSETS . 'js/animation-effect.js', ['jquery', 'gsap', 'gsap-scrolltrigger', 'gsap-splittext'], CARVIA_CORE_VERSION, true);
        wp_register_script('magnific-popup', CARVIA_CORE_ASSETS . 'js/magnific-popup.min.js', ['jquery'], CARVIA_CORE_VERSION, true);
        wp_register_script('countdown', CARVIA_CORE_ASSETS . 'js/countdown.js', ['jquery'], CARVIA_CORE_VERSION, true);
        wp_register_script('typed-js', CARVIA_CORE_ASSETS . 'js/typed.js', ['jquery'], CARVIA_CORE_VERSION, true);
        wp_register_script('carvia-main-js', CARVIA_CORE_ASSETS . 'js/main.min.js', ['jquery'], CARVIA_CORE_VERSION, true);
    }

    /**
     * Enqueue global scripts
     */
    public function enqueue_global_scripts()
    {
        wp_enqueue_script('carvia-main-js');
        wp_enqueue_script('gsap-animation');
    }
}

// Assets Plugin Class
Assets::instance();
