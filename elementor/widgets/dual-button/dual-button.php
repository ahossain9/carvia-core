<?php

/**
 * carvia_core pricing table widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Typography;

defined('ABSPATH') || die();

class Dual_Button extends Widget_Base
{

    public function get_name()
    {
        return 'carvia-dual-button';
    }

    public function get_title()
    {
        return esc_html__('Dual Button', 'carvia-core');
    }

    public function get_icon()
    {
        return 'carvia-core-icon eicon-dual-button';
    }

    public function get_categories()
    {
        return ['carvia_core'];
    }

    public function get_keywords()
    {
        return [
            'button',
            'dual button',
            'carvia',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            '_section_button',
            [
                'label' => __('Dual Buttons', 'carvia-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->start_controls_tabs('tabs_buttons');

        $this->start_controls_tab(
            'tab_button_primary',
            [
                'label' => __('Primary', 'carvia-core'),
            ]
        );

        $this->add_control(
            'left_button_text',
            [
                'label' => __('Text', 'carvia-core'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => 'Button Text',
            ]
        );

        $this->add_control(
            'left_button_link',
            [
                'label' => __('Link', 'carvia-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://example.com',
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'left_button_selected_icon',
            [
                'label' => __('Icon', 'carvia-core'),
                'type' => Controls_Manager::ICONS,
                'default'          => [
                    'value'   => 'icon icon-arrow-right-02',
                    'library' => 'carvia-core-icons',
                ],
            ]
        );

        $condition = ['left_button_selected_icon[value]!' => ''];

        $this->add_control(
            'left_button_icon_position',
            [
                'label' => __('Icon Position', 'carvia-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'before' => [
                        'title' => __('Before', 'carvia-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'after' => [
                        'title' => __('After', 'carvia-core'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'toggle' => false,
                'default' => 'before',
                'condition' => $condition,
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_secondary',
            [
                'label' => __('Secondary', 'carvia-core'),
            ]
        );

        $this->add_control(
            'right_button_text',
            [
                'label' => __('Text', 'carvia-core'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'default' => 'Button Text',
            ]
        );

        $this->add_control(
            'right_button_link',
            [
                'label' => __('Link', 'carvia-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://example.com',
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'right_button_selected_icon',
            [
                'label' => __('Icon', 'carvia-core'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'icon icon-arrow-right-02',
                    'library' => 'carvia-core-icons',
                ]
            ]
        );
        $condition = ['right_button_selected_icon[value]!' => ''];

        $this->add_control(
            'right_button_icon_position',
            [
                'label' => __('Icon Position', 'carvia-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'before' => [
                        'title' => __('Before', 'carvia-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'after' => [
                        'title' => __('After', 'carvia-core'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'toggle' => false,
                'default' => 'after',
                'condition' => $condition,
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'buttons_layout',
            [
                'label' => esc_html__('Layout', 'carvia-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Horizontal', 'carvia-core'),
                        'icon' => 'eicon-navigation-horizontal',
                    ],
                    'column' => [
                        'title' => esc_html__('Vertical', 'carvia-core'),
                        'icon' => 'eicon-navigation-vertical',
                    ],
                ],
                'default' => 'row',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_global_style',
            [
                'label' => __('General', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label'   => esc_html__('Alignment', 'carvia-core'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'carvia-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'carvia-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'carvia-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'condition' => [
                    'buttons_layout' => 'row',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper' => 'display: flex; justify-content: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'button_align_vertical',
            [
                'label'   => esc_html__('Alignment', 'carvia-core'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'carvia-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'carvia-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'carvia-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'condition' => [
                    'buttons_layout' => 'column',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper' => 'display: flex; align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_gap',
            [
                'label'      => esc_html__('Space Between Buttons', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .dual-btn-wrapper.horizontal' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn a',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn a'
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn a'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'left_button_style',
            [
                'label' => __('Primary Button', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'left_button_padding',
            [
                'label' => __('Padding', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'left_button_border',
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a'
            ]
        );

        $this->add_responsive_control(
            'left_button_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'left_button_icon_spacing',
            [
                'label' => __('Icon Spacing', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => $condition,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'left_button_typography',
                'label' => __('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'left_button_box_shadow',
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a'
            ]
        );

        $this->start_controls_tabs('_tabs_left_button');

        $this->start_controls_tab(
            'tab_left_button_normal',
            [
                'label' => __('Normal', 'carvia-core'),
            ]
        );

        $this->add_control(
            'left_button_text_color',
            [
                'label' => __('Text Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'left_button_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_left_button_hover',
            [
                'label' => __('Hover', 'carvia-core'),
            ]
        );

        $this->add_control(
            'left_button_hover_text_color',
            [
                'label' => __('Text Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'left_button_hover_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .btn-fill:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'left_button_hover_border_color',
            [
                'label' => __('Border Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'left_button_border_border!' => ''
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* =============================================
         * SECTION: Primary Button Icon Style
         * ============================================= */
        $this->start_controls_section(
            'section_primary_button_icon_style',
            [
                'label'     => esc_html__('Secondary Button Icon Style', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'selected_icon[value]!' => '',
                    'show_icon_box'         => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('left_icon_style_tabs');

        // --- Normal ---
        $this->start_controls_tab(
            'left_icon_style_normal',
            ['label' => esc_html__('Normal', 'carvia-core')]
        );

        $this->add_control(
            'left_icon_color',
            [
                'label'     => esc_html__('Icon Color (arrow-out)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon i.arrow-out'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon i.arrow-out svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'left_icon_color_in',
            [
                'label'     => esc_html__('Icon Color (arrow-in)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon i.arrow-in'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon i.arrow-in svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'left_icon_background',
                'label'    => esc_html__('Icon Box Background', 'carvia-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon',
            ]
        );

        $this->add_responsive_control(
            'left_icon_size',
            [
                'label'      => esc_html__('Icon Size', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 6, 'max' => 100],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'left_icon_box_size',
            [
                'label'      => esc_html__('Icon Box Size', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => ['min' => 20, 'max' => 120],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'left_icon_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // --- Hover ---
        $this->start_controls_tab(
            'left_icon_style_hover',
            ['label' => esc_html__('Hover', 'carvia-core')]
        );

        $this->add_control(
            'left_icon_color_hover',
            [
                'label'     => esc_html__('Icon Color (arrow-in on hover)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill:hover .btn-fill__icon i.arrow-in'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill:hover .btn-fill__icon i.arrow-in svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'left_icon_background_hover',
                'label'    => esc_html__('Icon Box Background', 'carvia-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .btn-fill:hover .btn-fill__icon',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_right_button_style',
            [
                'label' => __('Secondary Button', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'right_button_padding',
            [
                'label' => __('Padding', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'right_button_border',
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a'
            ]
        );

        $this->add_responsive_control(
            'right_button_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'right_button_icon_spacing',
            [
                'label' => __('Icon Spacing', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => $condition,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'right_button_typography',
                'label' => __('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'right_button_box_shadow',
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a'
            ]
        );

        $this->start_controls_tabs('tabs_right_button');

        $this->start_controls_tab(
            'tab_right_button_normal',
            [
                'label' => __('Normal', 'carvia-core'),
            ]
        );

        $this->add_control(
            'right_button_text_color',
            [
                'label' => __('Text Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'right_button_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_right_button_hover',
            [
                'label' => __('Hover', 'carvia-core'),
            ]
        );

        $this->add_control(
            'right_button_hover_text_color',
            [
                'label' => __('Text Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'right_button_hover_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'right_button_hover_border_color',
            [
                'label' => __('Border Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'right_button_border_border!' => ''
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* =============================================
         * SECTION: Secondary Button Icon Style
         * ============================================= */
        $this->start_controls_section(
            'section_secondary_icon_style',
            [
                'label'     => esc_html__('Icon Style', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'selected_icon[value]!' => '',
                    'show_icon_box'         => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('right_icon_style_tabs');

        // --- Normal ---
        $this->start_controls_tab(
            'right_icon_style_normal',
            ['label' => esc_html__('Normal', 'carvia-core')]
        );

        $this->add_control(
            'right_icon_color',
            [
                'label'     => esc_html__('Icon Color (arrow-out)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon i.arrow-out'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon i.arrow-out svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'right_icon_color_in',
            [
                'label'     => esc_html__('Icon Color (arrow-in)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon i.arrow-in'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon i.arrow-in svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'right_icon_background',
                'label'    => esc_html__('Icon Box Background', 'carvia-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon',
            ]
        );

        $this->add_responsive_control(
            'right_icon_size',
            [
                'label'      => esc_html__('Icon Size', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 6, 'max' => 100],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_icon_box_size',
            [
                'label'      => esc_html__('Icon Box Size', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => ['min' => 20, 'max' => 120],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_icon_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // --- Hover ---
        $this->start_controls_tab(
            'right_icon_style_hover',
            ['label' => esc_html__('Hover', 'carvia-core')]
        );

        $this->add_control(
            'right_icon_color_hover',
            [
                'label'     => esc_html__('Icon Color (arrow-in on hover)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill:hover .btn-fill__icon i.arrow-in'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill:hover .btn-fill__icon i.arrow-in svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'right_icon_background_hover',
                'label'    => esc_html__('Icon Box Background', 'carvia-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .btn-fill:hover .btn-fill__icon',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
?>
        <div class="dual-btn-wrapper">
            <div class="dual-btn dual-btn-left">
                <?php
                $target = $settings['left_button_link']['is_external'] ? ' target=_blank' : '';
                $nofollow = $settings['left_button_link']['nofollow'] ? ' rel=nofollow' : '';
                ?>
                <a class="btn-fill" href="<?php echo esc_url($settings['left_button_link']['url']); ?>" <?php echo esc_attr($target . $nofollow); ?>>
                    <?php if ($settings['left_button_icon_position'] === 'before' && (! empty($settings['left_button_selected_icon']))) : ?>
                        <span class="rpl-btn__label">
                            <span class="btn-fill__icon">
                                <i aria-hidden="true" class="arrow-out <?php echo esc_attr($settings['left_button_selected_icon']['value']); ?>"></i>
                                <i aria-hidden="true" class="arrow-in <?php echo esc_attr($settings['left_button_selected_icon']['value']); ?>"></i>
                            </span>
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($settings['left_button_text'])) : ?>
                        <span class="btn-fill__text"><?php echo esc_html($settings['left_button_text']); ?></span>
                    <?php endif; ?>

                    <?php if ($settings['left_button_icon_position'] === 'after' && (! empty($settings['left_button_selected_icon']))) : ?>
                        <span class="rpl-btn__label">
                            <span class="btn-fill__icon">
                                <i aria-hidden="true" class="arrow-out <?php echo esc_attr($settings['left_button_selected_icon']['value']); ?>"></i>
                                <i aria-hidden="true" class="arrow-in <?php echo esc_attr($settings['left_button_selected_icon']['value']); ?>"></i>
                            </span>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
            <div class="dual-btn dual-btn-right">
                <?php
                $target = $settings['right_button_link']['is_external'] ? ' target=_blank' : '';
                $nofollow = $settings['right_button_link']['nofollow'] ? ' rel=nofollow' : '';
                ?>
                <a class="btn-fill" href="<?php echo esc_url($settings['right_button_link']['url']); ?>" <?php echo esc_attr($target . $nofollow) ?>>
                    <?php if ($settings['right_button_icon_position'] === 'before' && (! empty($settings['right_button_selected_icon']))) : ?>
                        <span class="rpl-btn__label">
                            <span class="btn-fill__icon">
                                <i aria-hidden="true" class="arrow-out <?php echo esc_attr($settings['right_button_selected_icon']['value']); ?>"></i>
                                <i aria-hidden="true" class="arrow-in <?php echo esc_attr($settings['right_button_selected_icon']['value']); ?>"></i>
                            </span>
                        </span>
                        <span class="right-btn-icon-before"><?php Icons_Manager::render_icon($settings['right_button_selected_icon'], ['aria-hidden' => 'true']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($settings['right_button_text'])) : ?>
                        <span class="btn-fill__text"><?php echo esc_html($settings['right_button_text']); ?></span>
                    <?php endif; ?>
                    <?php if ($settings['right_button_icon_position'] === 'after' && (! empty($settings['right_button_selected_icon']))) : ?>
                        <span class="rpl-btn__label">
                            <span class="btn-fill__icon">
                                <i aria-hidden="true" class="arrow-out <?php echo esc_attr($settings['right_button_selected_icon']['value']); ?>"></i>
                                <i aria-hidden="true" class="arrow-in <?php echo esc_attr($settings['right_button_selected_icon']['value']); ?>"></i>
                            </span>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
<?php
    }
}
