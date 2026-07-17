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
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'solid',
                ]
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
                    'value' => 'fas fa-angle-right',
                    'library' => 'solid',
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
                'label' => __('Layout', 'carvia-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'horizontal' => [
                        'title' => __('Horizontal', 'carvia-core'),
                        'icon' => 'eicon-navigation-horizontal',
                    ],
                    'vertical' => [
                        'title' => __('Vertical', 'carvia-core'),
                        'icon' => 'eicon-navigation-vertical',
                    ]
                ],
                'toggle' => false,
                'desktop_default' => 'horizontal',
                'tablet_default' => 'horizontal',
                'mobile_default' => 'horizontal',
                'separator' => 'before',
                'prefix_class' => 'dual-button-%s-layout-',
                'style_transfer' => true,
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
            'button_align_x',
            [
                'label' => __('Alignment', 'carvia-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'carvia-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'carvia-core'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'carvia-core'),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'toggle' => true,
                'prefix_class' => 'dual-button-%s-align-'
            ]
        );

        $this->add_responsive_control(
            'button_gap',
            [
                'label' => __('Space Between Buttons', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '(desktop+){{WRAPPER}}.dual-button--layout-horizontal .dual-btn-left' => 'margin-right: calc({{button_gap.SIZE}}{{UNIT}}/2);',
                    '(desktop+){{WRAPPER}}.dual-button--layout-vertical .dual-btn-left' => 'margin-bottom: calc({{button_gap.SIZE}}{{UNIT}}/2);',
                    '(desktop+){{WRAPPER}}.dual-button--layout-horizontal .dual-btn-right' => 'margin-left: calc({{button_gap.SIZE}}{{UNIT}}/2);',
                    '(desktop+){{WRAPPER}}.dual-button--layout-vertical .dual-btn-right' => 'margin-top: calc({{button_gap.SIZE}}{{UNIT}}/2);',

                    '(tablet){{WRAPPER}}.dual-button--tablet-layout-horizontal .dual-btn-left' => 'margin-right: calc({{button_gap_tablet.SIZE || button_gap.SIZE}}{{UNIT}}/2); margin-bottom: 0;',
                    '(tablet){{WRAPPER}}.dual-button--tablet-layout-vertical .dual-btn-left' => 'margin-bottom: calc({{button_gap_tablet.SIZE || button_gap.SIZE}}{{UNIT}}/2); margin-right: 0;',
                    '(tablet){{WRAPPER}}.dual-button--tablet-layout-horizontal .dual-btn-right' => 'margin-left: calc({{button_gap_tablet.SIZE || button_gap.SIZE}}{{UNIT}}/2); margin-top: 0;',
                    '(tablet){{WRAPPER}}.dual-button--tablet-layout-vertical .dual-btn-right' => 'margin-top: calc({{button_gap_tablet.SIZE || button_gap.SIZE}}{{UNIT}}/2); margin-left: 0;',

                    '(mobile){{WRAPPER}}.dual-button--mobile-layout-horizontal .dual-btn-left' => 'margin-right: calc({{button_gap_mobile.SIZE || button_gap_tablet.SIZE || button_gap.SIZE}}{{UNIT}}/2); margin-bottom: 0;',
                    '(mobile){{WRAPPER}}.dual-button--mobile-layout-vertical .dual-btn-left' => 'margin-bottom: calc({{button_gap_mobile.SIZE || button_gap_tablet.SIZE || button_gap.SIZE}}{{UNIT}}/2); margin-right: 0;',
                    '(mobile){{WRAPPER}}.dual-button--mobile-layout-horizontal .dual-btn-right' => 'margin-left: calc({{button_gap_mobile.SIZE || button_gap_tablet.SIZE || button_gap.SIZE}}{{UNIT}}/2); margin-top: 0;',
                    '(mobile){{WRAPPER}}.dual-button--mobile-layout-vertical .dual-btn-right' => 'margin-top: calc({{button_gap_mobile.SIZE || button_gap_tablet.SIZE || button_gap.SIZE}}{{UNIT}}/2); margin-left: 0;',
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
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .left-btn-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .left-btn-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'left_button_icon_size',
            [
                'label' => __('Icon Size', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .left-btn-icon-before i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .left-btn-icon-after i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .left-btn-icon-before svg' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left .left-btn-icon-after svg' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-left a:hover' => 'background-color: {{VALUE}}',
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
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .right-btn-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .right-btn-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'right_button_icon_size',
            [
                'label' => __('Icon Size', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .right-btn-icon-before i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .right-btn-icon-after i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .right-btn-icon-before svg' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right .right-btn-icon-after svg' => 'width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .dual-btn-wrapper .dual-btn.dual-btn-right a:hover' => 'background-color: {{VALUE}}',
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
                <a href="<?php echo esc_url($settings['left_button_link']['url']); ?>" <?php echo esc_attr($target . $nofollow); ?>>
                    <?php if ($settings['left_button_icon_position'] === 'before' && (! empty($settings['left_button_selected_icon']))) : ?>
                        <span class="left-btn-icon-before"><?php Icons_Manager::render_icon($settings['left_button_selected_icon'], ['aria-hidden' => 'true']); ?> </span>
                    <?php endif; ?>
                    <?php if (!empty($settings['left_button_text'])) : ?>
                        <?php echo esc_html($settings['left_button_text']); ?>
                    <?php endif; ?>
                    <?php if ($settings['left_button_icon_position'] === 'after' && (! empty($settings['left_button_selected_icon']))) : ?>
                        <span class="left-btn-icon-after"><?php Icons_Manager::render_icon($settings['left_button_selected_icon'], ['aria-hidden' => 'true']); ?></span>
                    <?php endif; ?>
                </a>
            </div>
            <div class="dual-btn dual-btn-right">
                <?php
                $target = $settings['right_button_link']['is_external'] ? ' target=_blank' : '';
                $nofollow = $settings['right_button_link']['nofollow'] ? ' rel=nofollow' : '';
                ?>
                <a href="<?php echo esc_url($settings['right_button_link']['url']); ?>" <?php echo esc_attr($target . $nofollow) ?>>
                    <?php if ($settings['right_button_icon_position'] === 'before' && (! empty($settings['right_button_selected_icon']))) : ?>
                        <span class="right-btn-icon-before"><?php Icons_Manager::render_icon($settings['right_button_selected_icon'], ['aria-hidden' => 'true']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($settings['right_button_text'])) : ?>
                        <?php echo esc_html($settings['right_button_text']); ?>
                    <?php endif; ?>
                    <?php if ($settings['right_button_icon_position'] === 'after' && (! empty($settings['right_button_selected_icon']))) : ?>
                        <span class="right-btn-icon-after"><?php Icons_Manager::render_icon($settings['right_button_selected_icon'], ['aria-hidden' => 'true']); ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
<?php
    }
}
