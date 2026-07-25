<?php

namespace Carvia_Core;

if (! defined('ABSPATH')) exit; // Exit if accessed directly
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin
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

    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */
    public function __construct()
    {
        // Register widgets
        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);

        // Register custom category
        add_action('elementor/elements/categories_registered', [$this, 'add_category'], 1);
        add_action('elementor/elements/categories_registered', [$this, 'add_category_two'], 2);
    }

    /**
     * Add custom category.
     *
     * @param $elements_manager
     */
    public function add_category($elements_manager)
    {
        $elements_manager->add_category(
            'carvia_core',
            [
                'title' => __('Carvia', 'carvia_core-core'),
                'icon' => 'fa fa-smile-o',
            ]
        );
    }

    public function add_category_two($elements_manager)
    {
        $elements_manager->add_category(
            'carvia_core_cat_two',
            [
                'title' => __('Carvia Header & Footer', 'carvia_core-core'),
                'icon' => 'fa fa-smile-o',
            ]
        );
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function init_widgets()
    {
        $widgets = [
            'button',
            'dual-button',
            'service-card',
            'car-card',
            'info-card',
            'video-popup',
            'pricing-table',
            'news-ticker',
            'testimonial-carousel',
            'team-member',
            'testimonial',
            'timeline',
            'spinning-badge',
            'accordian',
            'step-flow',
            'blog-post',
            'nav-menu',
            'site-logo',
            'mini-cart',
            'nav-category',
        ];


        foreach ($widgets as $widget) {
            require(__DIR__ . '/elementor/widgets/' . $widget . '/' . $widget . '.php');

            $class_name = str_replace('-', '_', $widget);
            $class_name = __NAMESPACE__ . '\Widgets\\' . $class_name;
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $class_name());
        }
    }
}

// Instantiate Plugin Class
Plugin::instance();
