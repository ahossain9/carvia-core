<?php

/**
 * carvia_core service card widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

if (! defined('ABSPATH')) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;

class Service_Card extends Widget_Base
{
    public function get_name()
    {
        return 'carvia-service-card';
    }

    public function get_title()
    {
        return esc_html__('Service Card', 'carvia-core');
    }

    public function get_icon()
    {
        return 'carvia-core-icon eicon-post-list';
    }

    public function get_categories()
    {
        return ['carvia_core'];
    }

    public function get_keywords()
    {
        return ['service', 'card', 'carvia'];
    }

    private function get_service_categories()
    {
        $options    = ['' => esc_html__('All Categories', 'carvia-core')];
        $taxonomies = get_object_taxonomies('service-category', 'objects');

        if (empty($taxonomies)) {
            return $options;
        }

        $tax  = array_key_first($taxonomies);
        $terms = get_terms([
            'taxonomy'   => $tax,
            'hide_empty' => false,
        ]);

        if (! is_wp_error($terms) && ! empty($terms)) {
            foreach ($terms as $term) {
                $options[$term->slug] = $term->name;
            }
        }

        return $options;
    }

    /* ------------------------------------------------------------------ */
    /*  Controls                                                            */
    /* ------------------------------------------------------------------ */

    protected function register_controls()
    {

        /* ============================================================
         *  SECTION: Query Settings
         * ============================================================ */
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Query Settings', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => esc_html__('Number of Services', 'carvia-core'),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 50,
                'step'    => 1,
                'default' => 3,
            ]
        );

        $this->add_control(
            'service_category',
            [
                'label'   => esc_html__('Filter by Category', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_service_categories(),
                'default' => '',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order By', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'date'          => esc_html__('Date', 'carvia-core'),
                    'title'         => esc_html__('Title', 'carvia-core'),
                    'menu_order'    => esc_html__('Menu Order', 'carvia-core'),
                    'rand'          => esc_html__('Random', 'carvia-core'),
                ],
                'default' => 'date',
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'DESC' => esc_html__('Descending', 'carvia-core'),
                    'ASC'  => esc_html__('Ascending', 'carvia-core'),
                ],
                'default' => 'DESC',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'   => esc_html__('Columns', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    '12' => '1',
                    '6' => '2',
                    '4' => '3',
                    '3' => '4',
                ],
                'default' => '4',
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label'        => esc_html__('Show Icon', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            'show_image',
            [
                'label'        => esc_html__('Show Image', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_readmore',
            [
                'label'        => esc_html__('Read More Button', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label'     => esc_html__('Read More Text', 'carvia-core'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Read More', 'carvia-core'),
                'condition' => ['show_readmore' => 'yes'],
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Card Style
         * ============================================================ */
        $this->start_controls_section(
            'section_card_style',
            [
                'label' => esc_html__('Card', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label'     => esc_html__('Background Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-card' => 'background-color: {{VALUE}};',
                ],
                'default'   => '#ffffff',
            ]
        );

        $this->add_responsive_control(
            'card_margin',
            [
                'label'      => esc_html__('Margin', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'      => esc_html__('Padding', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'label'    => esc_html__('Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow',
                'label'    => esc_html__('Box Shadow', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-card',
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Title Style
         * ============================================================ */
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-card-title a' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-card-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 80, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .service-card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Description Style
         * ============================================================ */
        $this->start_controls_section(
            'section_desc_style',
            [
                'label'     => esc_html__('Description', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-card-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'desc_typography',
                'label'    => esc_html__('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-card-desc',
            ]
        );

        $this->add_responsive_control(
            'desc_margin_bottom',
            [
                'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 80, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .service-card-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Image Style
         * ============================================================ */
        $this->start_controls_section(
            'section_image_style',
            [
                'label'     => esc_html__('Image', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['show_image' => 'yes'],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin_bottom',
            [
                'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 80, 'step' => 1],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .service-card-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Read More Button Style
         * ============================================================ */
        $this->start_controls_section(
            'section_btn_style',
            [
                'label'     => esc_html__('Button', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['show_readmore' => 'yes'],
            ]
        );

        /* --- Normal state --- */
        $this->start_controls_tabs('btn_tabs_style');

        $this->start_controls_tab(
            'btn_tab_normal',
            ['label' => esc_html__('Normal', 'carvia-core')]
        );

        $this->add_control(
            'btn_color',
            [
                'label'     => esc_html__('Text Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-card-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_background',
            [
                'label'     => esc_html__('Background Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-card-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'btn_border',
                'label'    => esc_html__('Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-card-btn',
            ]
        );

        $this->end_controls_tab();

        /* --- Hover state --- */
        $this->start_controls_tab(
            'btn_tab_hover',
            ['label' => esc_html__('Hover', 'carvia-core')]
        );

        $this->add_control(
            'btn_hover_color',
            [
                'label'     => esc_html__('Hover Text Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-card-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_hover_background',
            [
                'label'     => esc_html__('Hover Background', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-card-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_hover_border_color',
            [
                'label'     => esc_html__('Hover Border Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-card-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        /* --- Shared button style --- */
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typography',
                'label'     => esc_html__('Typography', 'carvia-core'),
                'selector'  => '{{WRAPPER}} .service-card-btn',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label'      => esc_html__('Padding', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .service-card-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'btn_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-card-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
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
    /* ------------------------------------------------------------------ */
    /*  Render                                                              */
    /* ------------------------------------------------------------------ */

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        /* --- Build WP_Query args --- */
        $args = [
            'post_type'      => 'services',
            'posts_per_page' => absint($settings['posts_per_page']),
            'post_status'    => 'publish',
            'orderby'        => sanitize_key($settings['orderby']),
            'order'          => $settings['order'] === 'ASC' ? 'ASC' : 'DESC',
        ];

        // Category filter
        if (! empty($settings['service_category'])) {
            // Auto-detect the first registered taxonomy for service-category
            $taxonomies = get_object_taxonomies('service-category');
            if (! empty($taxonomies)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => $taxonomies[0],
                        'field'    => 'slug',
                        'terms'    => sanitize_text_field($settings['service_category']),
                    ],
                ];
            }
        }

        $query = new \WP_Query($args);

        if (! $query->have_posts()) { ?>
            <h3><?php _e('No services found', 'carvia-core'); ?></h3>
        <?php
        }

        $columns       = absint($settings['columns']);
        $show_image    = $settings['show_image']   === 'yes';
        $show_icon     = $settings['show_icon']    === 'yes';
        $show_readmore = $settings['show_readmore']   === 'yes';
        $btn_text      = ! empty($settings['readmore_text']) ? $settings['readmore_text'] : __('Read More', 'carvia-core');
        ?>
        <!-- start service row -->
        <div class="row">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                $post_id = get_the_ID();
                $title   = get_the_title($post_id);
                $short_description = '';
                if (function_exists('rwmb_meta')) {
                    $short_description = rwmb_meta('carvia_service_short_description', array(), $post_id);
                } else {
                    $short_description = get_post_meta($post_id, 'carvia_service_short_description', true);
                }
                $icon_field  = function_exists('rwmb_meta') ? rwmb_meta('carvia_service_icon', [], $post_id) : get_post_meta($post_id, 'carvia_service_icon', true);
                $image_field = function_exists('rwmb_meta') ? rwmb_meta('carvia_service_image', ['size' => 'full'], $post_id) : get_post_meta($post_id, 'carvia_service_image', true);

                $icon_url  = $this->get_image_url($icon_field);
                $image_url = $this->get_image_url($image_field);
                ?>
                <!-- start service card -->
                <div class="col-md-<?php echo esc_attr($columns); ?>">
                    <div class="service-card">
                        <?php if (! empty($icon_url) && $show_icon) : ?>
                            <div class="service-icon">
                                <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($title); ?>" />
                            </div>
                        <?php endif; ?>

                        <h3 class="service-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <?php if (! empty($short_description)) : ?>
                            <p class="service-card-desc">
                                <?php echo esc_html($short_description); ?>
                            </p>
                        <?php endif; ?>
                        <?php if (! empty($image_url) && $show_image) : ?>
                            <div class="service-card-image">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" />
                            </div>
                        <?php endif; ?>

                        <?php if ($show_readmore) : ?>
                            <a class="service-card-btn" href="<?php the_permalink(); ?>">
                                <span class="btn-text"><?php echo esc_html($btn_text); ?> </span><span class="btn-icon"><i class="icon icon-arrow-right-02"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div><!-- /.end service-card -->
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div><!-- /.end service row -->
<?php
    }
}
