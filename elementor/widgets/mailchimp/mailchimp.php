<?php

/**
 * carvia_core newsletter widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

defined('ABSPATH') || die();

class Mailchimp extends Widget_Base
{

    public function get_name()
    {
        return 'carvia-mailchimp';
    }

    public function get_title()
    {
        return __('Mailchimp', 'carvia-core');
    }

    public function get_icon()
    {
        return 'carvia-core-icon eicon-mailchimp';
    }

    public function get_categories()
    {
        return ['carvia_core'];
    }

    public function get_keywords()
    {
        return [
            'mailchimp',
            'mailchimp newsletter',
            'newsletter form',
            'newsletter',
            'from',
            'subscribe from',
            'carvia',
        ];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'mailchimp_section',
            [
                'label' => carvia_core_is_mc4wp_activated() ? __('Mailchimp', 'carvia-core') : __('Missing Notice', 'carvia-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        if (! carvia_core_is_mc4wp_activated()) {
            $this->add_control(
                'mailchimp_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        __('Hello %2$s, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'carvia-core'),
                        '<a href="' . esc_url(admin_url('plugin-install.php?s=mailchimp+for+wordpress&tab=search&type=term'))
                            . '" target="_blank" rel="noopener">Mailchimp for WordPress</a>',
                        carvia_core_get_current_user_display_name()
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );

            $this->add_control(
                'mailchimp_install',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<a href="' . esc_url(admin_url('plugin-install.php?s=mailchimp+for+wordpress&tab=search&type=term')) . '" target="_blank" rel="noopener">Click to install or activate Mailchimp for WordPress</a>',
                ]
            );

            $this->end_controls_section();
            return;
        }

        $this->add_control(
            'mc_form_id',
            [
                'label' => __('Select Your Form', 'carvia-core'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => \carvia_core_get_mc4wp_forms(),
            ]
        );

        $this->add_control(
            'mc_html_class',
            [
                'label' => __('HTML Class', 'carvia-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => __('Add CSS custom class to the form.', 'carvia-core'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mc_section_fields_style',
            [
                'label' => __('Form Fields', 'carvia-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mc_field_width',
            [
                'label' => __('Width', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p:first-child' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mc4wp-form-fields div:first-child' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            '_mc_field_height',
            [
                'label' => __('Height', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mc_field_margin',
            [
                'label' => __('Spacing Bottom', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mc_field_padding',
            [
                'label' => __('Padding', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mc_field_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mc_hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mc_field_typography',
                'label' => __('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .mc4wp-form-fields input[type="email"]'
            ]
        );

        $this->add_control(
            'mc_field_color',
            [
                'label' => __('Text Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'mc_field_placeholder_color',
            [
                'label' => __('Placeholder Text Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form-fields ::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form-fields ::-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_field_state');

        $this->start_controls_tab(
            'mc_tab_field_normal',
            [
                'label' => __('Normal', 'carvia-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mc_field_border',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields input[type="email"]',
            ]
        );

        $this->add_control(
            'mc_field_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mc_field_box_shadow',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields input[type="email"]',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mc_tab_field_focus',
            [
                'label' => __('Focus', 'carvia-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mc_field_focus_border',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields input[type="email"]:focus',
            ]
        );

        $this->add_control(
            'mc_field_focus_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mc_field_focus_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .mc4wp-form-fields input[type="email"]:focus',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mc_submit',
            [
                'label' => __('Submit Button', 'carvia-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mc_submit_margin',
            [
                'label' => __('Margin', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"], {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mc_submit_padding',
            [
                'label' => __('Padding', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"], .mc4wp-form-fields div input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mc_submit_typography',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"], {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]',
            ]
        );

        $this->add_control(
            'mc_hr4',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'mc_tab_button_normal',
            [
                'label' => __('Normal', 'carvia-core'),
            ]
        );

        $this->add_control(
            'mc_submit_color',
            [
                'label' => __('Text Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"], {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mc_submit_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"], {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mc_submit_border',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"],{{WRAPPER}} .mc4wp-form-fields p input[type="submit"]',
            ]
        );

        $this->add_responsive_control(
            'mc_submit_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"], {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mc_submit_box_shadow',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"], {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mc_tab_button_hover',
            [
                'label' => __('Hover', 'carvia-core'),
            ]
        );

        $this->add_control(
            'mc_submit_hover_color',
            [
                'label' => __('Text Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"]:hover, {{WRAPPER}} .mc4wp-form-fields p input[type="submit"]:focus, .mc4wp-form-fields div input[type="submit"]:hover, {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mc_submit_hover_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"]:hover, {{WRAPPER}} .mc4wp-form-fields p input[type="submit"]:focus,{{WRAPPER}} .mc4wp-form-fields div input[type="submit"]:hover, {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mc_submit_hover_border',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"]:hover,{{WRAPPER}} .mc4wp-form-fields div input[type="submit"]:hover',
            ]
        );

        $this->add_responsive_control(
            'mc_submit_hover_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"]:hover, {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mc_submit_hover_box_shadow',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields p input[type="submit"], {{WRAPPER}} .mc4wp-form-fields div input[type="submit"]:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        if (! carvia_core_is_mc4wp_activated()) {
            return;
        }

        $settings = $this->get_settings_for_display();

        if (! empty($settings['mc_form_id'])) {
            echo carvia_core_do_shortcode('mc4wp_form', [
                'id' => $settings['mc_form_id'],
                'html_class' => 'carvia-mc4wp-form ' . carvia_core_sanitize_html_class_param($settings['mc_html_class']),
            ]);
        }
    }
}
