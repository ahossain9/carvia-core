<?php

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

class Info_Card extends Widget_Base
{

	public function get_name()
	{
		return 'carvia_info_card';
	}

	public function get_title()
	{
		return esc_html__('Info Card', 'carvia-core');
	}

	public function get_icon()
	{
		return 'carvia-core-icon eicon-info-box';
	}

	public function get_categories()
	{
		return ['carvia_core'];
	}

	public function get_keywords()
	{
		return ['info', 'card', 'icon', 'button', 'carvia-core'];
	}

	protected function register_controls()
	{

		// ---------------------------------------------------------
		// SECTION: Content
		// ---------------------------------------------------------
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__('Content', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// Icon
		$this->add_control(
			'icon_type',
			[
				'label'   => esc_html__('Icon Type', 'carvia-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'library',
				'options' => [
					'library' => esc_html__('Icon Library', 'carvia-core'),
					'custom'  => esc_html__('Custom Image/SVG', 'carvia-core'),
				],
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'     => esc_html__('Icon', 'carvia-core'),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => 'library',
				],
			]
		);

		$this->add_control(
			'custom_icon',
			[
				'label'      => esc_html__('Upload Icon', 'carvia-core'),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => ['image', 'svg'],
				'condition'  => [
					'icon_type' => 'custom',
				],
			]
		);

		// Title
		$this->add_control(
			'title',
			[
				'label'       => esc_html__('Title', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Info Card Title', 'carvia-core'),
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__('Title HTML Tag', 'carvia-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		// Description
		$this->add_control(
			'description',
			[
				'label'     => esc_html__('Description', 'carvia-core'),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => esc_html__('Add a short description for this info card. Explain what makes this card special.', 'carvia-core'),
				'rows'      => 5,
				'separator' => 'before',
			]
		);

		// Button
		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__('Button Text', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Learn More', 'carvia-core'),
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'         => esc_html__('Button Link', 'carvia-core'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__('https://your-link.com', 'carvia-core'),
				'options'       => ['url', 'is_external', 'nofollow'],
				'default'       => ['url' => '#'],
				'label_block'   => true,
			]
		);

		$this->end_controls_section();

		// ---------------------------------------------------------
		// STYLE TAB: Card
		// ---------------------------------------------------------
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__('Card', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => '30',
					'right'  => '30',
					'bottom' => '30',
					'left'   => '30',
					'unit'   => 'px',
				],
			]
		);

		$this->add_control(
			'card_background',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'card_border',
				'label'     => esc_html__('Border', 'carvia-core'),
				'selector'  => '{{WRAPPER}} .carvia-info-card',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'card_box_shadow',
				'label'     => esc_html__('Box Shadow', 'carvia-core'),
				'selector'  => '{{WRAPPER}} .carvia-info-card',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'card_text_align',
			[
				'label'     => esc_html__('Text Align', 'carvia-core'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => ['title' => esc_html__('Left', 'carvia-core'),   'icon' => 'eicon-text-align-left'],
					'center' => ['title' => esc_html__('Center', 'carvia-core'), 'icon' => 'eicon-text-align-center'],
					'right'  => ['title' => esc_html__('Right', 'carvia-core'),  'icon' => 'eicon-text-align-right'],
				],
				'default'   => 'left',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ---------------------------------------------------------
		// STYLE TAB: Icon
		// ---------------------------------------------------------
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__('Icon', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label'      => esc_html__('Width', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%'],
				'range'      => [
					'px' => ['min' => 20, 'max' => 200],
					'em' => ['min' => 1,  'max' => 15],
					'%'  => ['min' => 5,  'max' => 100],
				],
				'default'    => ['unit' => 'px', 'size' => 70],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__icon-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
			[
				'label'      => esc_html__('Height', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => [
					'px' => ['min' => 20, 'max' => 200],
					'em' => ['min' => 1,  'max' => 15],
				],
				'default'    => ['unit' => 'px', 'size' => 70],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__icon-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__('Icon Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => [
					'px' => ['min' => 10, 'max' => 100],
					'em' => ['min' => 1,  'max' => 10],
				],
				'default'    => ['unit' => 'px', 'size' => 35],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__icon'          => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carvia-info-card__icon img'      => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carvia-info-card__icon svg'      => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__('Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#D1FF6D',
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card__icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .carvia-info-card__icon svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'icon_type' => 'library',
				],
			]
		);
		$this->add_control(
			'icon_background',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#052B13',
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card__icon-wrapper' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__icon-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => '15',
					'right'  => '15',
					'bottom' => '15',
					'left'   => '15',
					'unit'   => 'px',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => ['px' => ['min' => 0, 'max' => 80]],
				'default'    => ['unit' => 'px', 'size' => 20],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// ---------------------------------------------------------
		// STYLE TAB: Title
		// ---------------------------------------------------------
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__('Title', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__('Typography', 'carvia-core'),
				'selector' => '{{WRAPPER}} .carvia-info-card__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => ['px' => ['min' => 0, 'max' => 60]],
				'default'    => ['unit' => 'px', 'size' => 12],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// ---------------------------------------------------------
		// STYLE TAB: Description
		// ---------------------------------------------------------
		$this->start_controls_section(
			'section_style_description',
			[
				'label' => esc_html__('Description', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__('Typography', 'carvia-core'),
				'selector' => '{{WRAPPER}} .carvia-info-card__description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'description_spacing',
			[
				'label'      => esc_html__('Bottom Spacing', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => ['px' => ['min' => 0, 'max' => 60]],
				'default'    => ['unit' => 'px', 'size' => 24],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		// ---------------------------------------------------------
		// STYLE TAB: Button
		// ---------------------------------------------------------
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__('Button', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__('Typography', 'carvia-core'),
				'selector' => '{{WRAPPER}} .carvia-info-card__button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => '12',
					'right'  => '28',
					'bottom' => '12',
					'left'   => '28',
					'unit'   => 'px',
				],
				'separator'  => 'before',
			]
		);

		$this->start_controls_tabs('button_style_tabs');

		// Normal State
		$this->start_controls_tab(
			'button_tab_normal',
			['label' => esc_html__('Normal', 'carvia-core')]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__('Text Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0B311E',
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#D1FF6D',
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'button_border',
				'label'     => esc_html__('Border', 'carvia-core'),
				'selector'  => '{{WRAPPER}} .carvia-info-card__button',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => '4',
					'right'  => '4',
					'bottom' => '4',
					'left'   => '4',
					'unit'   => 'px',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow',
				'label'     => esc_html__('Box Shadow', 'carvia-core'),
				'selector'  => '{{WRAPPER}} .carvia-info-card__button',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'button_tab_hover',
			['label' => esc_html__('Hover', 'carvia-core')]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'     => esc_html__('Text Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card__button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#052B13',
				'selectors' => [
					'{{WRAPPER}} .carvia-info-card__button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'button_border_hover',
				'label'     => esc_html__('Border', 'carvia-core'),
				'selector'  => '{{WRAPPER}} .carvia-info-card__button:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'button_border_radius_hover',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-info-card__button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'button_box_shadow_hover',
				'label'     => esc_html__('Box Shadow', 'carvia-core'),
				'selector'  => '{{WRAPPER}} .carvia-info-card__button:hover',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$has_button_link = ! empty($settings['button_link']['url']);

		if ($has_button_link) {
			$this->add_link_attributes('button', $settings['button_link']);
		}

		$this->add_render_attribute('button', 'class', 'carvia-info-card__button');

?>
		<div class="carvia-info-card">

			<?php // Icon 
			?>
			<div class="carvia-info-card__icon-wrapper">
				<div class="carvia-info-card__icon">
					<?php if ('library' === $settings['icon_type'] && ! empty($settings['selected_icon']['value'])) : ?>
						<?php Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); ?>
					<?php elseif ('custom' === $settings['icon_type'] && ! empty($settings['custom_icon']['url'])) : ?>
						<?php
						$is_svg = isset($settings['custom_icon']['id']) && 'svg' === pathinfo(get_attached_file($settings['custom_icon']['id']), PATHINFO_EXTENSION);
						if ($is_svg && ! empty($settings['custom_icon']['id'])) {
							echo wp_get_attachment_image($settings['custom_icon']['id'], 'full', true);
						} else {
							echo '<img src="' . esc_url($settings['custom_icon']['url']) . '" alt="' . esc_attr($settings['title']) . '" />';
						}
						?>
					<?php endif; ?>
				</div>
			</div>

			<?php // Title 
			?>
			<?php if (! empty($settings['title'])) : ?>
				<<?php echo esc_html($settings['title_tag']); ?> class="carvia-info-card__title">
					<?php echo esc_html($settings['title']); ?>
				</<?php echo esc_html($settings['title_tag']); ?>>
			<?php endif; ?>

			<?php // Description 
			?>
			<?php if (! empty($settings['description'])) : ?>
				<p class="carvia-info-card__description">
					<?php echo wp_kses_post($settings['description']); ?>
				</p>
			<?php endif; ?>

			<?php // Button 
			?>
			<?php if (! empty($settings['button_text'])) : ?>
				<?php if ($has_button_link) : ?>
					<a <?php $this->print_render_attribute_string('button'); ?>>
						<?php echo esc_html($settings['button_text']); ?>
					</a>
				<?php else : ?>
					<button <?php $this->print_render_attribute_string('button'); ?>>
						<?php echo esc_html($settings['button_text']); ?>
					</button>
				<?php endif; ?>
			<?php endif; ?>

		</div>
	<?php
	}

	protected function content_template()
	{
	?>
		<#
			var iconHTML=elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden' : true }, 'i' , 'object' );
			var titleTag=settings.title_tag || 'h3' ;
			#>
			<div class="carvia-info-card">

				<div class="carvia-info-card__icon-wrapper">
					<div class="carvia-info-card__icon">
						<# if ( 'library'===settings.icon_type && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
							<# } else if ( 'custom'===settings.icon_type && settings.custom_icon.url ) { #>
								<img src="{{ settings.custom_icon.url }}" alt="{{ settings.title }}" />
								<# } #>
					</div>
				</div>

				<# if ( settings.title ) { #>
					<{{{ titleTag }}} class="carvia-info-card__title">{{{ settings.title }}}</{{{ titleTag }}}>
					<# } #>

						<# if ( settings.description ) { #>
							<p class="carvia-info-card__description">{{{ settings.description }}}</p>
							<# } #>

								<# if ( settings.button_text ) { #>
									<a class="carvia-info-card__button" href="{{ settings.button_link.url }}">{{{ settings.button_text }}}</a>
									<# } #>

			</div>
	<?php
	}
}
