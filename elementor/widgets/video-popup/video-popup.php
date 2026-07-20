<?php

/**
 * carvia_core video popup widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;

defined('ABSPATH') || die();

class Video_Popup extends Widget_Base
{

    public function get_name()
    {
        return 'carvia-video-popup';
    }

    public function get_title()
    {
        return esc_html__('Video PopUp', 'carvia-core');
    }

    public function get_icon()
    {
        return 'carvia-core-icon eicon-video-playlist';
    }

    public function get_categories()
    {
        return ['carvia_core'];
    }

    public function get_keywords()
    {
        return [
            'video',
            'video popup',
            'carvia',
        ];
    }

    public function get_script_depends()
    {
        return ['magnific-popup'];
    }

    public function get_style_depends()
    {
        return ['magnific-popup-style'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_video',
            [
                'label' => __('Video', 'carvia-core'),
            ]
        );

        $this->add_control(
            'video_icon',
            [
                'label' => __('Icon', 'carvia-core'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'hgi-stroke hgi-play-circle',
                    'library' => 'hugeicons',
                ],
            ]
        );

        $this->add_control(
            'video_type',
            [
                'label' => __('Video Type', 'carvia-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'youtube'   => __('Youtube', 'carvia-core'),
                    'vimeo'     => __('Vimeo', 'carvia-core')
                ],
                'default' => 'youtube',
            ]
        );

        $this->add_control(
            'youtube_url',
            [
                'label' => __('Video URL', 'carvia-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Enter your URL', 'carvia-core') . ' (YouTube)',
                'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                'label_block' => true,
                'condition' => [
                    'video_type' => 'youtube',
                ],
            ]
        );

        $this->add_control(
            'vimeo_url',
            [
                'label' => __('Video URL', 'carvia-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Enter your URL', 'carvia-core') . ' (Vimeo)',
                'default' => 'https://vimeo.com/235215203',
                'label_block' => true,
                'condition' => [
                    'video_type' => 'vimeo',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'overlay_section',
            [
                'label' => __('Overlay', 'carvia-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'overlay_img_switcher',
            [
                'label' => __('Show Image Overlay', 'carvia-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'carvia-core'),
                'label_off' => __('Hide', 'carvia-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'overlay_image',
                'label' => __('Choose Image', 'carvia-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .video-popup-wrap',
                'condition' => [
                    'overlay_img_switcher' => 'yes',
                ],
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
            'video_global_padding',
            [
                'label' => __('Padding', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'video_global_border',
                'label' => __('Glow', 'carvia-core'),
                'selector' => '{{WRAPPER}} .video-popup-wrap',
            ]
        );

        $this->add_control(
            'video_global_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __('Icon', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'video_icon_padding',
            [
                'label' => __('Padding', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_icon_width_height',
            [
                'label'      => esc_html__('Width', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_icon_size',
            [
                'label' => __('Icon Size', 'carvia-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap a i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .video-popup-wrap a svg' => 'width: {{SIZE}}{{UNIT}}',
                ]
            ]
        );

        $this->add_responsive_control(
            'video_icon_border_radius',
            [
                'label' => __('Border Radius', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'video_icon_color_tabs'
        );

        $this->start_controls_tab(
            'video_icon_color_normal_tab',
            [
                'label' => __('Normal', 'carvia-core'),
            ]
        );

        $this->add_control(
            'video_icon_color',
            [
                'label' => __('Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'video_icon_background',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FF4400',
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'video_icon_color_hover_tab',
            [
                'label' => __('Hover', 'carvia-core'),
            ]
        );

        $this->add_control(
            'video_icon_hover_color',
            [
                'label' => __('Hover Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'video_icon_hover_background',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .video-popup-wrap a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_overlay_style',
            [
                'label' => __('Overlay Color', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'overlay_img_switcher' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __('Background', 'carvia-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .video-popup-wrap:before',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();

        if ($settings['video_type'] == 'youtube') {
            $this->add_render_attribute('icon', ['href' => esc_url($settings['youtube_url'])]);
        } else {
            $this->add_render_attribute('icon', ['href' => esc_url($settings['vimeo_url'])]);
        }

?>

        <div class="video-popup-wrap text-center">
            <?php
            if (!empty($settings['video_icon']['value'])) :
            ?>
                <a class="video-popup" <?php echo $this->get_render_attribute_string('icon'); ?>>
                    <?php Icons_Manager::render_icon($settings['video_icon'], ['aria-hidden' => 'true']); ?>
                </a>
            <?php
            endif;
            ?>
        </div>
<?php
    }
}
