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

    /* ------------------------------------------------------------------ */
    /*  Identity                                                            */
    /* ------------------------------------------------------------------ */

    public function get_name()
    {
        return 'carvia_service_card';
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
        return ['service', 'card', 'carvia', 'pest', 'portfolio'];
    }

    /* ------------------------------------------------------------------ */
    /*  Helper: get carvia_service categories                              */
    /* ------------------------------------------------------------------ */

    private function get_service_categories()
    {
        $options    = ['' => esc_html__('All Categories', 'carvia-core')];
        $taxonomies = get_object_taxonomies('carvia_service', 'objects');

        if (empty($taxonomies)) {
            return $options;
        }

        // Use the first registered taxonomy; adjust the slug if needed.
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
                'default' => 6,
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
            'show_thumbnail',
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
            'show_description',
            [
                'label'        => esc_html__('Show Description', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_feature',
            [
                'label'        => esc_html__('Show Feature', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'     => esc_html__('Description Word Limit', 'carvia-core'),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 5,
                'max'       => 200,
                'step'      => 1,
                'default'   => 20,
                'condition' => ['show_description' => 'yes'],
            ]
        );

        $this->add_control(
            'show_readmore',
            [
                'label'        => esc_html__('Show Read More Button', 'carvia-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'carvia-core'),
                'label_off'    => esc_html__('No', 'carvia-core'),
                'return_value' => 'yes',
                'default'      => 'yes',
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
                'label' => esc_html__('Card Style', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label'     => esc_html__('Background Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-service-card' => 'background-color: {{VALUE}};',
                ],
                'default'   => '#ffffff',
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'      => esc_html__('Card Padding', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .carvia-service-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'    => '30',
                    'right'  => '25',
                    'bottom' => '30',
                    'left'   => '25',
                    'unit'   => 'px',
                ],
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .carvia-service-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'    => '12',
                    'right'  => '12',
                    'bottom' => '12',
                    'left'   => '12',
                    'unit'   => 'px',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'label'    => esc_html__('Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-service-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow',
                'label'    => esc_html__('Box Shadow', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-service-card',
            ]
        );

        $this->add_responsive_control(
            'card_gap',
            [
                'label'      => esc_html__('Gap Between Cards', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 60, 'step' => 1],
                ],
                'default'    => ['unit' => 'px', 'size' => 24],
                'selectors'  => [
                    '{{WRAPPER}} .carvia-service-cards-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Thumbnail Style
         * ============================================================ */
        $this->start_controls_section(
            'section_thumbnail_style',
            [
                'label'     => esc_html__('Thumbnail Style', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['show_thumbnail' => 'yes'],
            ]
        );

        $this->add_control(
            'thumbnail_border_radius',
            [
                'label'      => esc_html__('Thumbnail Border Radius', 'carvia-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .carvia-service-card__thumb'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .carvia-service-card__thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumbnail_margin_bottom',
            [
                'label'      => esc_html__('Spacing Below Thumbnail', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 80, 'step' => 1],
                ],
                'default'    => ['unit' => 'px', 'size' => 20],
                'selectors'  => [
                    '{{WRAPPER}} .carvia-service-card__thumb' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Title Style
         * ============================================================ */
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title Style', 'carvia-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Title Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-service-card__title' => 'color: {{VALUE}};',
                ],
                'default'   => '#1a1a2e',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Title Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-service-card__title',
            ]
        );

        $this->add_responsive_control(
            'title_margin_bottom',
            [
                'label'      => esc_html__('Spacing Below Title', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 80, 'step' => 1],
                ],
                'default'    => ['unit' => 'px', 'size' => 12],
                'selectors'  => [
                    '{{WRAPPER}} .carvia-service-card__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'label'     => esc_html__('Description Style', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['show_description' => 'yes'],
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__('Description Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-service-card__desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'desc_typography',
                'label'    => esc_html__('Description Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-service-card__desc',
            ]
        );

        $this->add_responsive_control(
            'desc_margin_bottom',
            [
                'label'      => esc_html__('Spacing Below Description', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 80, 'step' => 1],
                ],
                'default'    => ['unit' => 'px', 'size' => 20],
                'selectors'  => [
                    '{{WRAPPER}} .carvia-service-card__desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ============================================================
         *  SECTION: Feature Style
         * ============================================================ */
        $this->start_controls_section(
            'section_feature_style',
            [
                'label'     => esc_html__('Feature Style', 'carvia-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['show_feature' => 'yes'],
            ]
        );

        $this->add_control(
            'feature_color',
            [
                'label'     => esc_html__('Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-service-card li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'feature_typography',
                'label'    => esc_html__('Typography', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-service-card li',
            ]
        );

        $this->add_responsive_control(
            'feature_margin_bottom',
            [
                'label'      => esc_html__('Spacing', 'carvia-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 80, 'step' => 1],
                ],
                'default'    => ['unit' => 'px', 'size' => 20],
                'selectors'  => [
                    '{{WRAPPER}} .carvia-service-card li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'label'     => esc_html__('Read More Button Style', 'carvia-core'),
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
                    '{{WRAPPER}} .carvia-service-card__btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_background',
            [
                'label'     => esc_html__('Background Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-service-card__btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'btn_border',
                'label'    => esc_html__('Border', 'carvia-core'),
                'selector' => '{{WRAPPER}} .carvia-service-card__btn',
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
                    '{{WRAPPER}} .carvia-service-card__btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_hover_background',
            [
                'label'     => esc_html__('Hover Background', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-service-card__btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_hover_border_color',
            [
                'label'     => esc_html__('Hover Border Color', 'carvia-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .carvia-service-card__btn:hover' => 'border-color: {{VALUE}};',
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
                'selector'  => '{{WRAPPER}} .carvia-service-card__btn',
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
                    '{{WRAPPER}} .carvia-service-card__btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .carvia-service-card__btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'    => '6',
                    'right'  => '6',
                    'bottom' => '6',
                    'left'   => '6',
                    'unit'   => 'px',
                ],
            ]
        );

        $this->end_controls_section();
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
            // Auto-detect the first registered taxonomy for carvia_service
            $taxonomies = get_object_taxonomies('carvia_service');
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

        $columns      = absint($settings['columns']);
        $show_thumb   = $settings['show_thumbnail']   === 'yes';
        $show_desc    = $settings['show_description'] === 'yes';
        $show_feature    = $settings['show_feature'] === 'yes';
        $show_readmore = $settings['show_readmore']   === 'yes';
        $excerpt_len  = absint($settings['excerpt_length']);
        $btn_text     = ! empty($settings['readmore_text']) ? $settings['readmore_text'] : __('Read More', 'carvia-core');


        ?>
        <div class="row">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="col-lg-<?php echo esc_attr($columns); ?>">
                    <div class="carvia-service-card">
                        <div class="service-icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <h3 class="carvia-service-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <?php if ($show_desc) : ?>
                            <p class="carvia-service-card__desc">
                                <?php
                                if (has_excerpt()) {
                                    echo wp_trim_words(get_the_excerpt(), $excerpt_len, '&hellip;');
                                } else {
                                    echo wp_trim_words(get_the_content(), $excerpt_len, '&hellip;');
                                }
                                ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($show_thumb) : ?>
                            <div class="carvia-service-card__thumb">
                                <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                    <?php the_post_thumbnail('large', ['loading' => 'lazy', 'decoding' => 'async']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_readmore) : ?>
                            <a class="carvia-service-card__btn" href="<?php the_permalink(); ?>">
                                <span class="btn-text"><?php echo esc_html($btn_text); ?> </span><span class="btn-icon"><i class="hgi-stroke hgi-arrow-right-02"></i></span>
                            </a>
                        <?php endif; ?>

                    </div><!-- /.carvia-service-card -->
                </div><!-- /.carvia-service-card -->
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div><!-- /.carvia-service-cards-grid -->
<?php
    }
}
