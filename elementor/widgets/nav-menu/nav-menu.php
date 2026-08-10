<?php

/**
 * carvia_core nav menu widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

defined('ABSPATH') || die();

class Nav_Menu extends Widget_Base
{
    private function get_available_menus()
    {

        $menus   = wp_get_nav_menus();
        $options = [];
        foreach ($menus as $menu) :
            $options[$menu->slug] = $menu->name;
        endforeach;
        return $options;
    }

    protected $nav_menu_index = 1;

    protected function get_nav_menu_index()
    {
        return $this->nav_menu_index++;
    }

    public function get_name()
    {
        return 'carvia-nav-menu';
    }

    public function get_title()
    {
        return __('Nav Menu', 'carvia-core');
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
            'nav menu',
            'menu',
            'carvia',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __('Menu', 'carvia-core'),
            ]
        );

        $menus = $this->get_available_menus();

        if (!empty($menus)) :
            $this->add_control(
                'menu',
                [
                    'label'        => __('Choose Menu', 'carvia-core'),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys($menus)[0],
                    'save_default' => true,
                ]
            );
        else :
            $this->add_control(
                'menu_alert',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>No menu is available. Please .</strong><br>Go to the <a href="%s" target="_blank">Menus Settings</a> to create a menu.', 'carvia-core'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info'
                ]
            );
        endif;

        $this->end_controls_section();

        $this->start_controls_section(
            'responsive_menu',
            [
                'label' => __('Responsive Menu', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'tablet_responsive_menu',
            [
                'label' => __('Tablet', 'carvia-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'carvia-core'),
                'label_off' => __('Hide', 'carvia-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_menu_style',
            [
                'label' => __('Menu', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'menu_global_align',
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
                    '{{WRAPPER}} .nav-menu-area' => 'text-align: {{VALUE}};',
                ],
                'default' => 'right',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'label' => __('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-nav-menu-wrap > ul > li > a',
            ]
        );
        $this->add_responsive_control(
            'menu_spacing',
            [
                'label' => __('Spacing', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap > ul > li' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'menu_icon_size',
            [
                'label' => __('Arrow Icon Size', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap ul li.menu-item-has-children > a:after' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'menu_active_color',
            [
                'label' => __('Active Menu Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap ul li.current-menu-item > a, .carvia-nav-menu-wrap ul .sub-menu .current-menu-item > a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->start_controls_tabs(
            'menu_color_tabs'
        );
        $this->start_controls_tab(
            'menu_color_normal_tab',
            [
                'label' => __('Normal', 'carvia-core'),
            ]
        );
        $this->add_control(
            'menu_normal_color',
            [
                'label' => __('Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap ul li a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'menu_color_hover_tab',
            [
                'label' => __('Hover', 'carvia-core'),
            ]
        );
        $this->add_control(
            'menu_hover_color',
            [
                'label' => __('Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap ul li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_dropdown_style',
            [
                'label' => __('Dropdown Menu', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'dropdown_menu_global_heading',
            [
                'label' => __('Global', 'carvia-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_responsive_control(
            'dropdown_menu_width',
            [
                'label' => __('Width', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap ul .sub-menu' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'dropdown_menu_global_bg',
            [
                'label' => __('Background', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap .sub-menu' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'dropdown_menu_global_box_shadow',
                'label' => __('Area Box Shadow', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-nav-menu-wrap ul .sub-menu',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_menu_global_border',
                'label' => __('Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-nav-menu-wrap ul .sub-menu',
            ]
        );

        $this->add_responsive_control(
            'dropdown_menu_global_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap ul .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'dropdown_menu_item_heading',
            [
                'label' => __('Menu Item', 'carvia-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'dropdown_menu_typography',
                'label' => __('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-nav-menu-wrap ul .sub-menu a',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_menu_item_border',
                'label' => __('Dropdown Item Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-nav-menu-wrap ul .sub-menu a',
            ]
        );
        $this->add_responsive_control(
            'dropdown_menu_item_padding',
            [
                'label' => __('Padding', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .carvia-nav-menu-wrap ul .sub-menu a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_responsive_style',
            [
                'label' => __('Responsive Menu', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'responsive_menu_color',
            [
                'label' => __('Background', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nav-menu-area .slicknav_menu .slicknav_icon-bar' => 'background-color: {{VALUE}}!important',
                    '{{WRAPPER}} .nav-menu-area .slicknav_btn' => 'border-color: {{VALUE}}!important',
                ],
            ]
        );
        $this->add_responsive_control(
            'responsive_menu_position',
            [
                'label' => __('Position', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .nav-menu-area .mobile-menu-wrap' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $args = [
            'echo'        => false,
            'menu'        => $settings['menu'],
            'menu_class'  => 'nav-menu',
            'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'container'   => '',
        ];

        $menu_align = !empty($settings['menu_global_align']) ? $settings['menu_global_align'] : 'left';
        $menu_html = wp_nav_menu($args);
?>
        <div class="nav-menu-area tablet-menu-<?php echo esc_attr($settings['tablet_responsive_menu']); ?> <?php echo esc_attr($menu_align); ?>">
            <nav id="nav-menu" class="carvia-nav-menu-wrap">
                <?php echo trim($menu_html); ?>
            </nav>
            <!-- start mobile menu wrap -->
            <div class="mobile-menu-wrap">
                <a class="header-menu-bar"><i class="icon icon-dashboard-circle"></i></a>
            </div>
            <!-- end mobile menu wrap -->
        </div>
<?php

    }
}
