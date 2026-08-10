<?php

/**
 * Elementor Pricing Table Widget.
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use	Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Repeater;

class Pricing_Table extends Widget_Base
{

	public function get_name()
	{
		return 'carvia_pricing_table';
	}

	public function get_title()
	{
		return esc_html__('Pricing Table', 'carvia-core');
	}

	public function get_icon()
	{
		return 'carvia-core-icon eicon-price-table';
	}

	public function get_categories()
	{
		return ['carvia_core'];
	}

	public function get_keywords()
	{
		return ['pricing', 'table', 'price', 'carvia-core'];
	}

	protected function register_controls()
	{

		// ─── CONTENT ───────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Information', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__('Title', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Starter Plan',
				'label_block' => true,
			]
		);

		$this->add_control(
			'price',
			[
				'label'   => esc_html__('Price', 'carvia-core'),
				'type'    => Controls_Manager::TEXT,
				'default' => '$29',
			]
		);

		$this->add_control(
			'price_period',
			[
				'label'   => esc_html__('Period', 'carvia-core'),
				'type'    => Controls_Manager::TEXT,
				'default' => '/month',
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__('Description', 'carvia-core'),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Perfect for small teams and startups getting started.',
				'rows'    => 4,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__('Button Text', 'carvia-core'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Get Started',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__('Button Link', 'carvia-core'),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'default'     => ['url' => '#'],
			]
		);

		$this->end_controls_section();

		// ─── FEATURE CONTENT ──────────────────────────────────────
		$this->start_controls_section(
			'features_content',
			[
				'label' => esc_html__('Features', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'feature_icon',
			[
				'label'   => esc_html__('Icon', 'carvia-core'),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'feature_text',
			[
				'label'       => esc_html__('Feature Text', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Unlimited Projects',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'feature_icon_color',
			[
				'label'     => esc_html__('Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FF4400',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .pricing-feature-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .pricing-feature-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'feature_text_color',
			[
				'label'     => esc_html__('Text Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .pricing-feature-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'features_list',
			[
				'label'       => esc_html__('Features', 'carvia-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					['feature_text' => 'Unlimited Projects', 'feature_icon' => ['value' => 'fas fa-check', 'library' => 'fa-solid']],
					['feature_text' => 'Priority Support', 'feature_icon' => ['value' => 'fas fa-check', 'library' => 'fa-solid']],
					['feature_text' => 'Advanced Analytics', 'feature_icon' => ['value' => 'fas fa-check', 'library' => 'fa-solid']],
					['feature_text' => 'Custom Integrations', 'feature_icon' => ['value' => 'fas fa-check', 'library' => 'fa-solid']],
				],
				'title_field' => '{{{ feature_text }}}',
			]
		);

		$this->end_controls_section();

		// ─── STYLE: CARD ──────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__('Card', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_background_color',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .pricing-card',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'    => '30',
					'right'  => '30',
					'bottom' => '30',
					'left'   => '30',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .pricing-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .pricing-card',
			]
		);

		$this->add_control(
			'card_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top'    => '50',
					'right'  => '50',
					'bottom' => '50',
					'left'   => '50',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .pricing-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ─── STYLE: TITLE ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_title',
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
					'{{WRAPPER}} .pricing-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .pricing-title',
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 0, 'max' => 100]],
				'default'    => ['unit' => 'px', 'size' => 12],
				'selectors'  => [
					'{{WRAPPER}} .pricing-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ─── STYLE: PRICE ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__('Price', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .price-content',
			]
		);

		$this->add_control(
			'price_period_color',
			[
				'label'     => esc_html__('Period Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.5)',
				'selectors' => [
					'{{WRAPPER}} .price-content-period' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 0, 'max' => 100]],
				'default'    => ['unit' => 'px', 'size' => 16],
				'selectors'  => [
					'{{WRAPPER}} .price-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ─── STYLE: DESCRIPTION ──────────────────────────────────
		$this->start_controls_section(
			'section_style_description',
			[
				'label' => esc_html__('Description', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .content-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .content-desc',
			]
		);

		$this->add_control(
			'desc_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 0, 'max' => 100]],
				'default'    => ['unit' => 'px', 'size' => 32],
				'selectors'  => [
					'{{WRAPPER}} .content-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ─── STYLE: FEATURES ──────────────────────────────────────────
		$this->start_controls_section(
			'section_style_features',
			[
				'label' => esc_html__('Features', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'feature_icon_size',
			[
				'label'      => esc_html__('Icon Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 8, 'max' => 40]],
				'default'    => ['unit' => 'px', 'size' => 14],
				'selectors'  => [
					'{{WRAPPER}} .pricing-feature-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pricing-feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'feature_icon_default_color',
			[
				'label'     => esc_html__('Icon Default Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-feature-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .pricing-feature-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'feature_text_color',
			[
				'label'     => esc_html__('Text Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-feature-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'feature_typography',
				'selector' => '{{WRAPPER}} .pricing-feature-text',
			]
		);

		$this->add_control(
			'feature_item_spacing',
			[
				'label'      => esc_html__('Item Spacing', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 0, 'max' => 40]],
				'default'    => ['unit' => 'px', 'size' => 14],
				'selectors'  => [
					'{{WRAPPER}} .pricing-feature-item + .pricing-feature-item' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'feature_icon_gap',
			[
				'label'      => esc_html__('Icon Gap', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 4, 'max' => 30]],
				'default'    => ['unit' => 'px', 'size' => 12],
				'selectors'  => [
					'{{WRAPPER}} .pricing-feature-item' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// ─── STYLE: BUTTON ────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__('Button', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('button_style_tabs');

		// Normal tab
		$this->start_controls_tab(
			'button_tab_normal',
			['label' => esc_html__('Normal', 'carvia-core')]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__('Text Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pricing-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label'     => esc_html__('Arrow Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button-wrapper.pricing .btn-fill__icon i.arrow-out i'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_icon_bg_color',
			[
				'label'     => esc_html__('Arrow Icon Background', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button-wrapper.pricing .btn-fill__icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .pricing-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .pricing-btn',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .pricing-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .pricing-btn',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .pricing-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab
		$this->start_controls_tab(
			'button_tab_hover',
			['label' => esc_html__('Hover', 'carvia-core')]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__('Text Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button-wrapper.pricing .btn-fill.pricing-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button-wrapper.pricing .btn-fill:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_icon_color',
			[
				'label'     => esc_html__('Arrow Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button-wrapper.pricing .btn-fill:hover .btn-fill__icon i.arrow-in' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_icon_bg_color',
			[
				'label'     => esc_html__('Arrow Icon Background', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button-wrapper.pricing .pricing-btn:hover .btn-fill__icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_hover_border',
				'selector' => '{{WRAPPER}} .pricing-btn:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .pricing-btn:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$button_url  = $settings['button_link']['url'] ?? '#';
		$button_target = ! empty($settings['button_link']['is_external']) ? ' target="_blank"' : '';
		$button_rel    = ! empty($settings['button_link']['nofollow']) ? ' rel="nofollow"' : '';

?>
		<div class="pricing-card">
			<div class="pricing-inner">
				<div class="pricing-header">
					<h4 class="pricing-title"><?php echo esc_html($settings['title']); ?></h4>

					<div class="price-wrap">
						<h2 class="price-content"><?php echo esc_html($settings['price']); ?></h2>
						<?php if (! empty($settings['price_period'])) : ?>
							<span class="price-content-period"><?php echo esc_html($settings['price_period']); ?></span>
						<?php endif; ?>
					</div>

					<?php if (! empty($settings['description'])) : ?>
						<p class="content-desc"><?php echo esc_html($settings['description']); ?></p>
					<?php endif; ?>
					<div class="button-wrapper pricing">
						<a href="<?php echo esc_url($button_url); ?>" <?php echo $button_target . $button_rel; ?> class="btn-fill pricing-btn">
							<span class="btn-fill__text"><?php echo esc_html($settings['button_text']); ?></span>
							<span class="rpl-btn__label">
								<span class="btn-fill__icon">
									<i aria-hidden="true" class="arrow-out icon icon-arrow-right-02"></i>
									<i aria-hidden="true" class="arrow-in icon icon-arrow-right-02"></i>
								</span>
							</span>
						</a>
					</div>
				</div>

				<div class="pricing-features">
					<?php if (! empty($settings['features_list'])) : ?>
						<ul class="pricing-features-list">
							<?php foreach ($settings['features_list'] as $index => $item) : ?>
								<li class="pricing-feature-item elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">
									<span class="pricing-feature-icon">
										<?php Icons_Manager::render_icon($item['feature_icon'], ['aria-hidden' => 'true']); ?>
									</span>
									<span class="pricing-feature-text"><?php echo esc_html($item['feature_text']); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
<?php
	}
}
