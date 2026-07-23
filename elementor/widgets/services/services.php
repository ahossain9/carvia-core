<?php

/**
 * Carvia Services Elementor Widget
 *
 * @package Carvia_Core
 */

namespace Carvia_Core\Widgets;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

class Services extends Widget_Base
{

    public function get_name()
    {
        return 'carvia-services';
    }

    public function get_title()
    {
        return esc_html__('Carvia Services', 'carvia-core');
    }

    public function get_icon()
    {
        return 'carvia-core-icon eicon-posts-grid';
    }

    public function get_categories()
    {
        return array('carvia_core');
    }

    public function get_keywords()
    {
        return array('services', 'carvia', 'icon box', 'grid');
    }

    protected function register_controls()
    {

        /* =====================================================
		 * CONTENT TAB — LAYOUT
		 * ===================================================== */
        $this->start_controls_section(
            'section_layout',
            array(
                'label' => esc_html__('Layout', 'carvia-core'),
            )
        );

        $this->add_control(
            'layout_style',
            array(
                'label'   => esc_html__('Layout Style', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'icon_layout',
                'options' => array(
                    'icon_layout'  => esc_html__('Icon, Title, Short Description', 'carvia-core'),
                    'image_layout' => esc_html__('Title, Short Description, Image', 'carvia-core'),
                ),
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label'   => esc_html__('Columns', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '6' => '6',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .carvia-services-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ),
            )
        );

        $this->end_controls_section();

        /* =====================================================
		 * CONTENT TAB — QUERY
		 * ===================================================== */
        $this->start_controls_section(
            'section_query',
            array(
                'label' => esc_html__('Query', 'carvia-core'),
            )
        );

        $this->add_control(
            'posts_per_page',
            array(
                'label'   => esc_html__('Number of Services', 'carvia-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => -1,
            )
        );

        $this->add_control(
            'order_by',
            array(
                'label'   => esc_html__('Order By', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => array(
                    'date'       => esc_html__('Date', 'carvia-core'),
                    'title'      => esc_html__('Title', 'carvia-core'),
                    'menu_order' => esc_html__('Menu Order', 'carvia-core'),
                    'rand'       => esc_html__('Random', 'carvia-core'),
                ),
            )
        );

        $this->add_control(
            'order',
            array(
                'label'   => esc_html__('Order', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => array(
                    'ASC'  => esc_html__('Ascending', 'carvia-core'),
                    'DESC' => esc_html__('Descending', 'carvia-core'),
                ),
            )
        );

        $this->add_control(
            'include_ids',
            array(
                'label'       => esc_html__('Include Specific Services (IDs, comma separated)', 'carvia-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'placeholder' => esc_html__('e.g. 12,15,20', 'carvia-core'),
            )
        );

        $this->add_control(
            'description_length',
            array(
                'label'   => esc_html__('Short Description Length (words)', 'carvia-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 20,
                'min'     => 0,
            )
        );

        $this->add_control(
            'link_wrapper',
            array(
                'label'   => esc_html__('Make Item Clickable', 'carvia-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->end_controls_section();

        /* =====================================================
		 * STYLE TAB — BOX
		 * ===================================================== */
        $this->start_controls_section(
            'section_style_box',
            array(
                'label' => esc_html__('Box', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'box_gap',
            array(
                'label'      => esc_html__('Grid Gap', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 30,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .carvia-services-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'box_background',
                'types'    => array('classic', 'gradient'),
                'selector' => '{{WRAPPER}} .carvia-service-item',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'box_border',
                'selector' => '{{WRAPPER}} .carvia-service-item',
            )
        );

        $this->add_responsive_control(
            'box_radius',
            array(
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors'  => array(
                    '{{WRAPPER}} .carvia-service-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'box_padding',
            array(
                'label'      => esc_html__('Padding', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors'  => array(
                    '{{WRAPPER}} .carvia-service-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'box_shadow',
                'selector' => '{{WRAPPER}} .carvia-service-item',
            )
        );

        $this->end_controls_section();

        /* =====================================================
		 * STYLE TAB — ICON (icon layout only)
		 * ===================================================== */
        $this->start_controls_section(
            'section_style_icon',
            array(
                'label'     => esc_html__('Icon', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'layout_style' => 'icon_layout',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_size',
            array(
                'label'      => esc_html__('Icon Size', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 200,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 60,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .carvia-service-icon img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_spacing',
            array(
                'label'     => esc_html__('Spacing', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 80,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .carvia-service-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        /* =====================================================
		 * STYLE TAB — IMAGE (image layout only)
		 * ===================================================== */
        $this->start_controls_section(
            'section_style_image',
            array(
                'label'     => esc_html__('Image', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'layout_style' => 'image_layout',
                ),
            )
        );

        $this->add_responsive_control(
            'image_height',
            array(
                'label'      => esc_html__('Image Height', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => array(
                    'px' => array(
                        'min' => 50,
                        'max' => 600,
                    ),
                ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 220,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .carvia-service-image img' => 'width: 100%; height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ),
            )
        );

        $this->add_responsive_control(
            'image_radius',
            array(
                'label'      => esc_html__('Image Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors'  => array(
                    '{{WRAPPER}} .carvia-service-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'image_spacing',
            array(
                'label'     => esc_html__('Spacing', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 80,
                    ),
                ),
                'default'   => array(
                    'unit' => 'px',
                    'size' => 20,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .carvia-service-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        /* =====================================================
		 * STYLE TAB — TITLE
		 * ===================================================== */
        $this->start_controls_section(
            'section_style_title',
            array(
                'label' => esc_html__('Title', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .carvia-service-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .carvia-service-title',
            )
        );

        $this->add_responsive_control(
            'title_spacing',
            array(
                'label'     => esc_html__('Spacing', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 80,
                    ),
                ),
                'default'   => array(
                    'unit' => 'px',
                    'size' => 15,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .carvia-service-title' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: 0;',
                ),
            )
        );

        $this->end_controls_section();

        /* =====================================================
		 * STYLE TAB — DESCRIPTION
		 * ===================================================== */
        $this->start_controls_section(
            'section_style_description',
            array(
                'label' => esc_html__('Short Description', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'description_color',
            array(
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .carvia-service-description' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .carvia-service-description',
            )
        );

        $this->end_controls_section();
    }

    /**
     * Helper: get an image URL from a Meta Box single_image field.
     *
     * @param mixed $field Raw field value from rwmb_meta().
     * @return string
     */
    private function get_image_url($field)
    {
        if (empty($field)) {
            return '';
        }

        // Meta Box single_image (with 'field_type' => 'image_advanced'/'single_image')
        // typically returns an associative array with a 'url' key,
        // or a plain attachment ID depending on configuration.
        if (is_array($field)) {
            if (isset($field['url'])) {
                return $field['url'];
            }
            if (isset($field['ID'])) {
                return wp_get_attachment_image_url($field['ID'], 'full');
            }
            $field = reset($field);
        }

        if (is_numeric($field)) {
            return wp_get_attachment_image_url((int) $field, 'full');
        }

        if (is_string($field)) {
            return $field;
        }

        return '';
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $query_args = array(
            'post_type'      => 'services',
            'post_status'    => 'publish',
            'posts_per_page' => $settings['posts_per_page'],
            'orderby'        => $settings['order_by'],
            'order'          => $settings['order'],
        );

        if (! empty($settings['include_ids'])) {
            $ids = array_map('trim', explode(',', $settings['include_ids']));
            $ids = array_filter(array_map('intval', $ids));
            if (! empty($ids)) {
                $query_args['post__in'] = $ids;
                $query_args['orderby']  = 'post__in';
            }
        }

        $services_query = new \WP_Query($query_args);

        if (! $services_query->have_posts()) {
            echo '<p class="carvia-services-empty">' . esc_html__('No services found.', 'carvia-core') . '</p>';
            return;
        }

        $is_icon_layout = ('icon_layout' === $settings['layout_style']);
        $is_clickable   = ('yes' === $settings['link_wrapper']);
        $desc_length    = absint($settings['description_length']);
?>
        <div class="carvia-services-widget carvia-layout-<?php echo esc_attr($settings['layout_style']); ?>">
            <div class="carvia-services-grid">
                <?php
                while ($services_query->have_posts()) :
                    $services_query->the_post();
                    $post_id = get_the_ID();
                    $link    = get_permalink($post_id);
                    $title   = get_the_title($post_id);

                    $short_description = '';
                    if (function_exists('rwmb_meta')) {
                        $short_description = rwmb_meta('carvia_service_short_description', array(), $post_id);
                    } else {
                        $short_description = get_post_meta($post_id, 'carvia_service_short_description', true);
                    }

                    if ($desc_length > 0 && ! empty($short_description)) {
                        $short_description = wp_trim_words($short_description, $desc_length, '&hellip;');
                    }

                    $icon_field  = function_exists('rwmb_meta') ? rwmb_meta('carvia_service_icon', array(), $post_id) : get_post_meta($post_id, 'carvia_service_icon', true);
                    $image_field = function_exists('rwmb_meta') ? rwmb_meta('carvia_service_image', array(), $post_id) : get_post_meta($post_id, 'carvia_service_image', true);

                    $icon_url  = $this->get_image_url($icon_field);
                    $image_url = $this->get_image_url($image_field);

                    $wrapper_tag = $is_clickable ? 'a' : 'div';
                ?>
                    <<?php echo esc_html($wrapper_tag); ?>
                        class="carvia-service-item"
                        <?php echo $is_clickable ? 'href="' . esc_url($link) . '"' : ''; ?>>
                        <?php if ($is_icon_layout) : ?>

                            <?php if (! empty($icon_url)) : ?>
                                <div class="carvia-service-icon">
                                    <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($title); ?>" />
                                </div>
                            <?php endif; ?>

                            <h3 class="carvia-service-title"><?php echo esc_html($title); ?></h3>

                            <?php if (! empty($short_description)) : ?>
                                <div class="carvia-service-description"><?php echo wp_kses_post($short_description); ?></div>
                            <?php endif; ?>

                        <?php else : ?>

                            <h3 class="carvia-service-title"><?php echo esc_html($title); ?></h3>

                            <?php if (! empty($short_description)) : ?>
                                <div class="carvia-service-description"><?php echo wp_kses_post($short_description); ?></div>
                            <?php endif; ?>

                            <?php if (! empty($image_url)) : ?>
                                <div class="carvia-service-image">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" />
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                    </<?php echo esc_html($wrapper_tag); ?>>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    <?php
    }

    protected function content_template()
    {
    ?>
        <#
            var layoutClass='carvia-layout-' + settings.layout_style;
            #>
            <div class="carvia-services-widget {{ layoutClass }}">
                <div class="carvia-services-grid">
                    <div class="carvia-service-item">
                        <# if ( settings.layout_style==='icon_layout' ) { #>
                            <div class="carvia-service-icon">
                                <img src="{{ elementor.config.default_image_placeholder || '' }}" alt="" />
                            </div>
                            <h3 class="carvia-service-title"><?php echo esc_js(__('Service Title', 'carvia-core')); ?></h3>
                            <div class="carvia-service-description"><?php echo esc_js(__('Short description of the service goes here.', 'carvia-core')); ?></div>
                            <# } else { #>
                                <h3 class="carvia-service-title"><?php echo esc_js(__('Service Title', 'carvia-core')); ?></h3>
                                <div class="carvia-service-description"><?php echo esc_js(__('Short description of the service goes here.', 'carvia-core')); ?></div>
                                <div class="carvia-service-image"></div>
                                <# } #>
                    </div>
                </div>
            </div>
    <?php
    }
}
