<?php

/**
 * Hugeicons Manager
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Inc;

defined('ABSPATH') || die();

class Icons_Manager
{

    public static function init()
    {
        add_filter('elementor/icons_manager/additional_tabs', [__CLASS__, 'add_hugeicons_tab']);
    }

    public static function add_hugeicons_tab($tabs)
    {
        $tabs['hugeicons'] = [
            'name' => 'hugeicons',
            'label' => __('Hugeicons', 'carvia-core'),
            'url' => CARVIA_CORE_ASSETS . 'css/hugeicons.min.css',
            'enqueue' => [CARVIA_CORE_ASSETS . 'css/hugeicons.min.css'],
            'prefix' => '',
            'displayPrefix' => '',
            'labelIcon' => 'hgi hgi-stroke hgi-home-01',
            'ver' => CARVIA_CORE_VERSION,
            'fetchJson' => CARVIA_CORE_ASSETS . 'js/hugeicons.js',
            'native' => false,
        ];
        return $tabs;
    }
}

Icons_Manager::init();
