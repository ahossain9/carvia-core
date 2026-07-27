<?php

/**
 * carvia core icon manager
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Inc;

defined('ABSPATH') || die();

class Icons_Manager
{

    public static function init()
    {
        add_filter('elementor/icons_manager/additional_tabs', [__CLASS__, 'add_carvia_core_icons_tab']);
    }

    public static function add_carvia_core_icons_tab($tabs)
    {
        $tabs['carvia-core-icons'] = [
            'name' => 'carvia-core-icons',
            'label' => __('Carvia Icons', 'carvia-core'),
            'url' => CARVIA_CORE_ASSETS . 'css/carvia-icons.min.css',
            'prefix' => 'icon-',
            'displayPrefix' => 'icon',
            'labelIcon' => 'icon icon-dashboard-circle',
            'ver' => CARVIA_CORE_VERSION,
            'fetchJson' => CARVIA_CORE_ASSETS . 'js/carvia-icons.js',
            'native' => false,
        ];
        return $tabs;
    }
}

Icons_Manager::init();
