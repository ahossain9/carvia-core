<?php

/**
 * carvia_core car card widget for elementor
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

class Car_Card extends Widget_Base
{
    public function get_name()
    {
        return 'carvia-car-card';
    }

    public function get_title()
    {
        return esc_html__('Car Card', 'carvia-core');
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
        return ['car', 'cars', 'carvia'];
    }

    private function get_car_categories()
    {
        $options    = ['' => esc_html__('All Categories', 'carvia-core')];
        $taxonomies = get_object_taxonomies('cars-category', 'objects');

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
            'car_category',
            [
                'label'   => esc_html__('Filter by Category', 'carvia-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_car_categories(),
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
            'show_model_name',
            [
                'label'        => esc_html__('Show Model Name', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_control(
            'show_specs',
            [
                'label'        => esc_html__('Show Specifications', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Car Card Style
         * ============================================================ */
        $this->start_controls_section(
            'section_card_style',
            [
                'label' => esc_html__('Card', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image',
            [
                'label'     => esc_html__('Image', 'carvia-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .car-card-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'body_heading',
            [
                'label'     => esc_html__('Body Content', 'carvia-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'body_bg_color',
            [
                'label'     => esc_html__('Background Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .car-card-body-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'body_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .car-card-body-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'body_padding',
            [
                'label'      => esc_html__('Padding', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .car-card-body-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'body_box_shadow',
                'label'    => esc_html__('Box Shadow', 'carvia-core'),
                'selector' => '{{WRAPPER}} .car-card-body-content',
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Price Badge Style
         * ============================================================ */
        $this->start_controls_section(
            'section_price_style',
            [
                'label' => esc_html__('Price', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'price_bg_color',
            [
                'label'     => esc_html__('Background Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ff0000',
                'selectors' => [
                    '{{WRAPPER}} .car-card-price' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'price_text_color',
            [
                'label'     => esc_html__('Text Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .car-card-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_size',
            [
                'label'      => esc_html__('Badge Size', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => ['px' => ['min' => 60, 'max' => 200]],
                'default'    => ['size' => 100],
                'selectors'  => [
                    '{{WRAPPER}} .car-card-price' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_position_top',
            [
                'label'     => esc_html__('Position from Top', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => ['px' => ['min' => -50, 'max' => 100]],
                'default'   => ['size' => 20],
                'selectors' => [
                    '{{WRAPPER}} .car-card-price' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_position_left',
            [
                'label'     => esc_html__('Position from Left', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => ['px' => ['min' => -50, 'max' => 100]],
                'default'   => ['size' => 20],
                'selectors' => [
                    '{{WRAPPER}} .car-card-price' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typography',
                'label'    => esc_html__('Price Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .car-rental-price',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'duration_typography',
                'label'    => esc_html__('Duration Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .car-rental-duration',
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Title & Model Style
         * ============================================================ */
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title & Model', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .car-card-title, {{WRAPPER}} .car-card-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__('Title Hover Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .car-card-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .car-card-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'     => esc_html__('Below Spacing', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => ['px' => ['min' => 0, 'max' => 60]],
                'selectors' => [
                    '{{WRAPPER}} .car-card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'model_heading',
            [
                'label'     => esc_html__('Model Name', 'carvia-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'model_color',
            [
                'label'     => esc_html__('Model Name Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .car-model-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'model_typography',
                'selector' => '{{WRAPPER}} .car-model-name',
            ]
        );

        $this->add_responsive_control(
            'model_spacing',
            [
                'label'     => esc_html__('Below Spacing', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => ['px' => ['min' => 0, 'max' => 60]],
                'selectors' => [
                    '{{WRAPPER}} .car-model-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Specifications Style
         * ============================================================ */
        $this->start_controls_section(
            'section_specs_style',
            [
                'label'     => esc_html__('Specifications', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_specs' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'specs_border_color',
            [
                'label'     => esc_html__('Divider Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#dddddd',
                'selectors' => [
                    '{{WRAPPER}} .car-card-spec' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'specs_row_padding',
            [
                'label'     => esc_html__('Spacing', 'carvia-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => ['px' => ['min' => 0, 'max' => 40]],
                'default'   => ['size' => 10],
                'selectors' => [
                    '{{WRAPPER}} .car-card-spec' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'spec_key_heading',
            [
                'label'     => esc_html__('Label', 'carvia-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'spec_key_color',
            [
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .spec-key' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'spec_key_typography',
                'selector' => '{{WRAPPER}} .spec-key',
            ]
        );

        $this->add_control(
            'spec_value_heading',
            [
                'label'     => esc_html__('Value', 'carvia-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'spec_value_color',
            [
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#444444',
                'selectors' => [
                    '{{WRAPPER}} .spec-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'spec_value_typography',
                'selector' => '{{WRAPPER}} .spec-value',
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
            'post_type'      => 'cars',
            'posts_per_page' => absint($settings['posts_per_page']),
            'post_status'    => 'publish',
            'orderby'        => sanitize_key($settings['orderby']),
            'order'          => $settings['order'] === 'ASC' ? 'ASC' : 'DESC',
        ];

        // Category filter
        if (! empty($settings['car_category'])) {
            // Auto-detect the first registered taxonomy for cars-category
            $taxonomies = get_object_taxonomies('cars-category');
            if (! empty($taxonomies)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => $taxonomies[0],
                        'field'    => 'slug',
                        'terms'    => sanitize_text_field($settings['car_category']),
                    ],
                ];
            }
        }

        $query = new \WP_Query($args);

        if (! $query->have_posts()) { ?>
            <h3><?php _e('No cars found', 'carvia-core'); ?></h3>
        <?php
        }

        $columns       = absint($settings['columns']);
        $show_specs    = $settings['show_specs'] === 'yes';
        $show_model    = $settings['show_model_name'] === 'yes';
        ?>
        <!-- start car row -->
        <div class="row">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                $post_id = get_the_ID();
                $title   = get_the_title($post_id);
                // Rental price
                $rental_price = function_exists('rwmb_meta') ? rwmb_meta('carvia_car_rental_price', [], $post_id) : get_post_meta($post_id, 'carvia_car_rental_price', true);
                // Rental duration
                $rental_duration = function_exists('rwmb_meta') ? rwmb_meta('carvia_car_rental_duration', [], $post_id) : get_post_meta($post_id, 'carvia_car_rental_duration', true);
                // Car model
                $car_model = function_exists('rwmb_meta') ? rwmb_meta('carvia_car_model_name', [], $post_id) : get_post_meta($post_id, 'carvia_car_model_name', true);
                // Car image
                $image_field = function_exists('rwmb_meta') ? rwmb_meta('carvia_car_image', ['size' => 'full'], $post_id) : get_post_meta($post_id, 'carvia_car_image', true);
                $image_url = $this->get_image_url($image_field);
                // Car specifications
                $specs = function_exists('rwmb_meta') ? rwmb_meta('carvia_car_specs', [], $post_id) : get_post_meta($post_id, 'carvia_car_specs', true);
                ?>
                <!-- start car card -->
                <div class="col-md-<?php echo esc_attr($columns); ?>">
                    <div class="car-card">
                        <div class="car-card-top-content">
                            <!-- start image -->
                            <?php if (! empty($image_url)) : ?>
                                <div class="car-card-image">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" />
                                </div>
                            <?php endif; ?>
                            <!-- end image -->
                            <!-- start price -->
                            <?php if (! empty($rental_price)) : ?>
                                <div class="car-card-price">
                                    <span class="car-rental-price">
                                        <?php echo esc_html($rental_price); ?>
                                    </span>
                                    <?php if (! empty($rental_duration)) : ?>
                                        <span class="car-rental-duration">
                                            <?php echo esc_html($rental_duration); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <!-- end price -->
                        </div>
                        <!-- start body content -->
                        <div class="car-card-body-content">
                            <!-- star title -->
                            <h3 class="car-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <!-- end title -->
                            <?php if (! empty($car_model) && $show_model) : ?>
                                <p class="car-model-name">
                                    <?php echo esc_html($car_model); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($show_specs && ! empty($specs) && is_array($specs)) : ?>
                                <ul class="car-specs">
                                    <?php foreach ($specs as $pair) : ?>
                                        <?php
                                        // Each $pair is [key, value]
                                        $spec_key   = isset($pair[0]) ? $pair[0] : '';
                                        $spec_value = isset($pair[1]) ? $pair[1] : '';
                                        if ($spec_key === '' && $spec_value === '') {
                                            continue;
                                        }
                                        ?>
                                        <li class="car-card-spec">
                                            <span class="spec-key"><?php echo esc_html($spec_key); ?>:</span>
                                            <span class="spec-value"><?php echo esc_html($spec_value); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <!-- end body content -->
                    </div>
                </div><!-- /.end car-card -->
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div><!-- /.end car row -->
<?php
    }
}
