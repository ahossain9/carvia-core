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

class Service_List extends Widget_Base
{
    public function get_name()
    {
        return 'carvia-service-list';
    }

    public function get_title()
    {
        return esc_html__('Service List', 'carvia-core');
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
        return ['service list', 'list', 'carvia'];
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
                    '{{WRAPPER}} .service-list-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_margin',
            [
                'label'      => esc_html__('Margin', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-list-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .service-list-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .service-list-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'label'    => esc_html__('Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-list-wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow',
                'label'    => esc_html__('Box Shadow', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-list-wrap',
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

        $this->add_responsive_control(
            'title_padding',
            [
                'label'      => esc_html__('Padding', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-list-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        
        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-list-title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-list-title a',
            ]
        );

        /* --- Normal state --- */
        $this->start_controls_tabs('title_tabs_style');

        $this->start_controls_tab(
            'title_tab_normal',
            ['label' => esc_html__('Normal', 'carvia-core')]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-list-title a' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'title_bg_color',
            [
                'label'     => esc_html__('Background Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-list-title a' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'title_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-list-title a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'title_border',
                'label'    => esc_html__('Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-list-title a',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'title_box_shadow',
                'label'    => esc_html__('Box Shadow', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-list-title a',
            ]
        );

        $this->end_controls_tab();

        /* --- Hover state --- */
        $this->start_controls_tab(
            'title_tab_hover',
            ['label' => esc_html__('Hover', 'carvia-core')]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-list-title a:hover' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_control(
            'title_hover_bg_color',
            [
                'label'     => esc_html__('Background Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .service-list-title a:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'title_hover_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-list-title a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'title_hover_border',
                'label'    => esc_html__('Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-list-title a:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'title_hover_box_shadow',
                'label'    => esc_html__('Box Shadow', 'carvia-core'),
                'selector' => '{{WRAPPER}} .service-list-title a:hover',
            ]
        );

        $this->end_controls_tab();

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
        $current_service_id = get_queried_object_id();
        $query = new \WP_Query($args);

        if (! $query->have_posts()) { ?>
            <h3><?php _e('No services found', 'carvia-core'); ?></h3>
        <?php
        }
        ?>
        <!-- start service row -->
        <div class="service-list-wrap">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                $service_id = get_the_ID();
                $active_class = '';

                if (is_singular('services') && $service_id === $current_service_id) {
                    $active_class = ' active';
                }
                ?>
                <!-- start service card -->
                <div class="service-list <?php echo esc_attr($active_class); ?>">
                    <h5 class="service-list-title">
                        <a href="<?php the_permalink(); ?>"><span class="service-list-icon"><?php the_title(); ?></span><span class="service-list-icon"><i class="icon-arrow-right-02"></i></span></a>
                    </h5>
                </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div><!-- /.end service row -->
<?php
    }
}
