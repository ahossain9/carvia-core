<?php

/**
 * carvia_core logo widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

defined('ABSPATH') || die();

class Site_Logo extends Widget_Base
{

    public function get_name()
    {
        return 'carvia-site-logo';
    }

    public function get_title()
    {
        return __('Site Logo', 'carvia-core');
    }

    public function get_icon()
    {
        return 'carvia-core-icon eicon-gallery-grid';
    }

    public function get_categories()
    {
        return ['carvia_core_cat_two'];
    }

    public function get_keywords()
    {
        return [
            'site logo',
            'logo',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __('Layout', 'carvia-core'),
            ]
        );

        $this->add_control(
            'logo_type',
            [
                'label' => __('Logo', 'carvia-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default-logo' => __('Default', 'carvia-core'),
                    'custom-logo' => __('Custom', 'carvia-core')
                ],
                'default' => 'default-logo',
            ]
        );

        $this->add_control(
            'custom_logo_image',
            [
                'label' => esc_html__('Choose Image', 'carvia-core'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'logo_type' => 'custom-logo',
                ]
            ]
        );

        $this->add_control(
            'custom_logo_link',
            [
                'label'       => __('Link', 'carvia-core'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'default',
                'options'     => [
                    'default' => __('Default', 'carvia-core'),
                    'custom'  => __('Custom URL', 'carvia-core')
                ],
                'condition' => [
                    'logo_type' => 'custom-logo',
                ]
            ]
        );

        $this->add_control(
            'custom_logo_link_url',
            [
                'label'       => __('Link', 'carvia-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active'  => true
                ],
                'placeholder' => __('https://your-link.com', 'carvia-core'),
                'condition'   => [
                    'custom_logo_link' => 'custom'
                ],
                'show_label'  => false
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_general_style',
            [
                'label' => __('General', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'logo_align',
            [
                'label' => __('Alignment', 'carvia-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __('Left', 'carvia-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'carvia-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'carvia-core'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .site-main-logo' => 'text-align: {{VALUE}}!important;',
                ],
                'default' => 'left',
            ]
        );
        $this->add_responsive_control(
            'width',
            [
                'label'          => __('Width', 'carvia-core'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => ['%', 'px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .site-main-logo img' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'max_width',
            [
                'label'      => __('Max Width', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                ],
                'selectors'      => [
                    '{{WRAPPER}} .site-main-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="site-main-logo">
            <?php
            if ($settings['logo_type'] == 'default-logo'):
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
            ?>
                    <h4 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')) ?>" rel="home"><?php bloginfo('name'); ?></a>
                    </h4>
                <?php }
            endif;
            if ($settings['logo_type'] == 'custom-logo'):
                if ($settings['custom_logo_link'] == 'default'):
                ?>
                    <a href="<?php echo esc_url(home_url('/')) ?>">
                        <img src="<?php echo esc_url($settings['custom_logo_image']['url']); ?>" alt="<?php echo esc_attr__('logo', 'carvia-core'); ?>">
                    </a>
                <?php endif; ?>
                <?php if ($settings['custom_logo_link'] == 'custom'): ?>
                    <a href="<?php echo esc_url($settings['custom_logo_link_url']['url']); ?>">
                        <img src="<?php echo esc_url($settings['custom_logo_image']['url']); ?>" alt="<?php echo esc_attr__('logo', 'carvia-core'); ?>"></a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
<?php

    }
}
