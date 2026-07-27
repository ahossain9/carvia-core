<?php

/**
 * Carvia Button Widget
 *
 * @package Carvia
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) exit;

class Button extends Widget_Base
{

    public function get_name()
    {
        return 'carvia-button';
    }

    public function get_title()
    {
        return esc_html__('Button', 'carvia-core');
    }

    public function get_icon()
    {
        return 'carvia-core-icon eicon-button';
    }

    public function get_categories()
    {
        return ['carvia_core'];
    }

    public function get_keywords()
    {
        return ['button', 'btn', 'carvia-core'];
    }

    protected function register_controls()
    {

        /* =============================================
         * SECTION: Button Content
         * ============================================= */
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Button', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__('Button Text', 'carvia-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Click Here', 'carvia-core'),
                'placeholder' => esc_html__('Enter button text...', 'carvia-core'),
                'label_block' => true,
                'dynamic'     => ['active' => true],
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'       => esc_html__('Link', 'carvia-core'),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default'     => ['url' => '#'],
                'dynamic'     => ['active' => true],
            ]
        );

        $this->add_responsive_control(
            'button_align',
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
                'default'   => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .button-wrapper' => 'display: flex; justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* =============================================
         * SECTION: Icon
         * ============================================= */
        $this->start_controls_section(
            'section_icon',
            [
                'label' => esc_html__('Icon', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label'            => esc_html__('Icon', 'carvia-core'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'   => 'icon icon-arrow-right-02',
                    'library' => 'carvia-core-icons',
                ],
            ]
        );

        $this->add_control(
            'show_icon_box',
            [
                'label'        => esc_html__('Show Icon Box', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'selected_icon[value]!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        /* =============================================
         * SECTION: Button Style
         * ============================================= */
        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__('Button Style', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('button_style_tabs');

        // --- Normal ---
        $this->start_controls_tab(
            'button_style_normal',
            ['label' => esc_html__('Normal', 'carvia-core')]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Text Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-fill' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .btn-fill',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_background',
                'label'    => esc_html__('Background', 'carvia-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .btn-fill',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'selector' => '{{WRAPPER}} .btn-fill',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .btn-fill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => esc_html__('Padding', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .btn-fill' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_gap',
            [
                'label'      => esc_html__('Gap (Text & Icon)', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 60],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .btn-fill' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .btn-fill',
            ]
        );

        $this->end_controls_tab();

        // --- Hover ---
        $this->start_controls_tab(
            'button_style_hover',
            ['label' => esc_html__('Hover', 'carvia-core')]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'     => esc_html__('Text Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-fill:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_background_hover',
                'label'    => esc_html__('Hover Fill Background', 'carvia-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .btn-fill::before',
                'description' => esc_html__('This is the slide-fill overlay applied on hover.', 'carvia-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border_hover',
                'selector' => '{{WRAPPER}} .btn-fill:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow_hover',
                'selector' => '{{WRAPPER}} .btn-fill:hover',
            ]
        );

        $this->add_control(
            'hover_transition_duration',
            [
                'label'     => esc_html__('Transition Duration (ms)', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => ['min' => 100, 'max' => 1000, 'step' => 50],
                ],
                'default'   => ['size' => 500],
                'selectors' => [
                    '{{WRAPPER}} .btn-fill'              => 'transition-duration: {{SIZE}}ms;',
                    '{{WRAPPER}} .btn-fill::before'      => 'transition-duration: {{SIZE}}ms;',
                    '{{WRAPPER}} .btn-fill__icon'        => 'transition-duration: {{SIZE}}ms;',
                    '{{WRAPPER}} .btn-fill__icon i'      => 'transition-duration: {{SIZE}}ms;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /* =============================================
         * SECTION: Icon Style
         * ============================================= */
        $this->start_controls_section(
            'section_icon_style',
            [
                'label'     => esc_html__('Icon Style', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'selected_icon[value]!' => '',
                    'show_icon_box'         => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('icon_style_tabs');

        // --- Normal ---
        $this->start_controls_tab(
            'icon_style_normal',
            ['label' => esc_html__('Normal', 'carvia-core')]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Icon Color (arrow-out)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-fill__icon i.arrow-out'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-fill__icon i.arrow-out svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_in',
            [
                'label'     => esc_html__('Icon Color (arrow-in)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-fill__icon i.arrow-in'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-fill__icon i.arrow-in svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'icon_background',
                'label'    => esc_html__('Icon Box Background', 'carvia-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .btn-fill__icon',
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => esc_html__('Icon Size', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range'      => [
                    'px' => ['min' => 6, 'max' => 100],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .btn-fill__icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .btn-fill__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_box_size',
            [
                'label'      => esc_html__('Icon Box Size', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => [
                    'px' => ['min' => 20, 'max' => 120],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .btn-fill__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .btn-fill__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // --- Hover ---
        $this->start_controls_tab(
            'icon_style_hover',
            ['label' => esc_html__('Hover', 'carvia-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => esc_html__('Icon Color (arrow-in on hover)', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-fill:hover .btn-fill__icon i.arrow-in'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-fill:hover .btn-fill__icon i.arrow-in svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'icon_background_hover',
                'label'    => esc_html__('Icon Box Background', 'carvia-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .btn-fill:hover .btn-fill__icon',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $button_text  = ! empty($settings['button_text']) ? $settings['button_text'] : '';
        $has_icon     = ! empty($settings['selected_icon']['value']);
        $show_icon_box = ($has_icon && ! empty($settings['show_icon_box']) && 'yes' === $settings['show_icon_box']);

        // Build link attributes on the <a> tag
        $this->add_render_attribute('button', 'class', 'btn-fill');

        if (! empty($settings['button_link']['url'])) {
            $this->add_link_attributes('button', $settings['button_link']);
        }

        // Capture icon inner HTML for reuse in both arrow-out and arrow-in
        $icon_inner = '';
        if ($has_icon) {
            ob_start();
            Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
            $icon_inner = ob_get_clean();
        }
?>
        <div class="button-wrapper">
            <a <?php echo $this->get_render_attribute_string('button'); ?>>

                <?php if ($button_text) : ?>
                    <span class="btn-fill__text"><?php echo esc_html($button_text); ?></span>
                <?php endif; ?>

                <?php if ($show_icon_box) : ?>
                    <span class="rpl-btn__label">
                        <span class="btn-fill__icon">
                            <i aria-hidden="true" class="arrow-out <?php echo esc_attr($settings['selected_icon']['value']); ?>"></i>
                            <i aria-hidden="true" class="arrow-in <?php echo esc_attr($settings['selected_icon']['value']); ?>"></i>
                        </span>
                    </span>
                <?php elseif ($has_icon) : ?>
                    <?php echo $icon_inner; ?>
                <?php endif; ?>

            </a>
        </div>
    <?php
    }

    protected function content_template()
    {
    ?>
        <#
            var hasIcon=settings.selected_icon && settings.selected_icon.value;
            var showIconBox=hasIcon && settings.show_icon_box==='yes' ;
            var iconClass=hasIcon ? settings.selected_icon.value : '' ;
            #>
            <div class="button-wrapper">
                <a class="btn-fill" role="button">

                    <# if ( settings.button_text ) { #>
                        <span class="btn-fill__text">{{{ settings.button_text }}}</span>
                        <# } #>

                            <# if ( showIconBox ) { #>
                                <span class="rpl-btn__label">
                                    <span class="btn-fill__icon">
                                        <i aria-hidden="true" class="arrow-out {{ iconClass }}"></i>
                                        <i aria-hidden="true" class="arrow-in {{ iconClass }}"></i>
                                    </span>
                                </span>
                                <# } else if ( hasIcon ) { #>
                                    <i aria-hidden="true" class="{{ iconClass }}"></i>
                                    <# } #>

                </a>
            </div>
    <?php
    }
}
