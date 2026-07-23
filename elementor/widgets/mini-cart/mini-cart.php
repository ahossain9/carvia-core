<?php

/**
 * carvia_core mini cart widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

defined('ABSPATH') || die();

class Mini_Cart extends Widget_Base
{

    public function get_name()
    {
        return 'carvia-mini-cart';
    }

    public function get_title()
    {
        return __('Mini Cart', 'carvia-core');
    }

    public function get_icon()
    {
        return 'carvia-core-icon eicon-cart-medium';
    }

    public function get_categories()
    {
        return ['carvia_core_cat_two'];
    }

    public function get_keywords()
    {
        return [
            'cart',
            'mini cart',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __('Layout', 'carvia-core'),
            ]
        );

        $this->add_control(
            'styles',
            [
                'label' => __('Styles', 'carvia-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-one' => __('Style One', 'carvia-core')
                ],
                'default' => 'style-one'
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
            'cart_align',
            [
                'label' => __('Alignment', 'carvia-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __('Left', 'carvia-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'carvia-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'carvia-core'),
                        'icon' => 'eicon-text-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart' => 'text-align: {{VALUE}}!important;',
                ],
                'default' => 'left',
            ]
        );
        $this->add_control(
            'icon_size_heading',
            [
                'label' => __('Cart Icon', 'carvia-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label'          => __('Size', 'carvia-core'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .mini-cart .cart-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .cart-icon i' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'quantity_heading',
            [
                'label' => __('Quantity Number', 'carvia-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'quantity_size',
            [
                'label'          => __('Size', 'carvia-core'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .mini-cart .cart-icon .cart-total-number' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'quantity_color',
            [
                'label' => __('Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .cart-icon .cart-total-number' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'quantity_bg_color',
            [
                'label' => __('Background Color', 'carvia-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .cart-icon .cart-total-number' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'quantity_position',
            [
                'label' => __('Position', 'carvia-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .cart-icon .cart-total-number' => 'position: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'quantity_width',
            [
                'label'          => __('Width', 'carvia-core'),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .mini-cart .cart-icon .cart-total-number' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="mini-cart">
            <?php global $woocommerce;
            ?>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-icon">
                <i class="eicon-cart-medium"></i>
                <span class="cart-total-number"><?php echo esc_html(WC()->cart->cart_contents_count); ?></span>
            </a>
        </div>
<?php

    }
}
