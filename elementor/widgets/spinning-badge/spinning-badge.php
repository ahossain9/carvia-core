<?php

/**
 * Spinning Badge Widget
 *
 * @package Carvia_Core
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Spinning_Badge extends Widget_Base
{

	public function get_name()
	{
		return 'carvia_spinning_badge';
	}

	public function get_title()
	{
		return esc_html__('Spinning Badge', 'carvia-core');
	}

	public function get_icon()
	{
		return 'carvia-core-icon eicon-loading';
	}

	public function get_categories()
	{
		return ['carvia_core'];
	}

	public function get_keywords()
	{
		return ['spinning', 'badge', 'rotate', 'circle', 'carvia'];
	}

	protected function register_controls()
	{

		/* ------------------------------------------------------------
		 * SECTION: Spinning Image
		 * ------------------------------------------------------------ */
		$this->start_controls_section(
			'section_spinning_image',
			[
				'label' => esc_html__('Spinning Image', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'spinning_image',
			[
				'label'   => esc_html__('Spinning Image', 'carvia-core'),
				'type'    => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src()],
				'description' => esc_html__('Upload a circular text/transparent image that will spin.', 'carvia-core'),
			]
		);

		$this->add_control(
			'spin_duration',
			[
				'label'      => esc_html__('Spin Duration (s)', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['s'],
				'range'      => [
					's' => [
						'min'  => 1,
						'max'  => 30,
						'step' => 0.5,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .spinning-badge__image' => 'animation-duration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'spin_direction',
			[
				'label'   => esc_html__('Spin Direction', 'carvia-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => esc_html__('Clockwise', 'carvia-core'),
					'reverse' => esc_html__('Counter Clockwise', 'carvia-core'),
				],
				'selectors' => [
					'{{WRAPPER}} .spinning-badge__image' => 'animation-direction: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------ */
		/* SECTION: Center Icon */
		/* ------------------------------------------------------------ */
		$this->start_controls_section(
			'section_center_icon',
			[
				'label' => esc_html__('Center Icon', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon_type',
			[
				'label'   => esc_html__('Icon Type', 'carvia-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon'  => esc_html__('Icon Library', 'carvia-core'),
					'image' => esc_html__('Custom Image', 'carvia-core'),
				],
			]
		);

		$this->add_control(
			'center_icon',
			[
				'label'     => esc_html__('Choose Icon', 'carvia-core'),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-bug',
					'library' => 'fa-solid',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'center_image',
			[
				'label'     => esc_html__('Upload Icon Image', 'carvia-core'),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => '',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_control(
			'center_image_alt',
			[
				'label'       => esc_html__('Image Alt Text', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__('Enter alt text', 'carvia-core'),
				'condition'   => [
					'icon_type' => 'image',
				],
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------ */
		/* SECTION: Wrapper Style */
		/* ------------------------------------------------------------ */
		$this->start_controls_section(
			'section_wrapper_style',
			[
				'label' => esc_html__('Wrapper', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'default'    => [
					'top'    => 15,
					'right'  => 15,
					'bottom' => 15,
					'left'   => 15,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .spinning-badge__image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_width_height',
			[
				'label'      => esc_html__('Width', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem', 'vw'],
				'range'      => [
					'px' => [
						'min' => 50,
						'max' => 800,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 220,
				],
				'selectors' => [
					'{{WRAPPER}} .spinning-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'wrapper_background',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FF4400',
				'selectors' => [
					'{{WRAPPER}} .spinning-badge'   => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'wrapper_border',
				'label'    => esc_html__('Border', 'carvia-core'),
				'selector' => '{{WRAPPER}} .spinning-badge',
			]
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => 50,
					'right'    => 50,
					'bottom'   => 50,
					'left'     => 50,
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .spinning-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'wrapper_box_shadow',
				'label'    => esc_html__('Box Shadow', 'carvia-core'),
				'selector' => '{{WRAPPER}} .spinning-badge',
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------ */
		/* SECTION: Center Circle Style */
		/* ------------------------------------------------------------ */
		$this->start_controls_section(
			'section_center_style',
			[
				'label' => esc_html__('Center Circle', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'center_width_height',
			[
				'label'      => esc_html__('Width', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em', 'rem'],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 400,
					],
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 90,
				],
				'selectors' => [
					'{{WRAPPER}} .spinning-badge__center' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'center_background',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#052B13',
				'selectors' => [
					'{{WRAPPER}} .spinning-badge__center'   => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'center_border',
				'label'    => esc_html__('Border', 'carvia-core'),
				'selector' => '{{WRAPPER}} .spinning-badge__center',
			]
		);

		$this->add_responsive_control(
			'center_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'default'    => [
					'top'      => 50,
					'right'    => 50,
					'bottom'   => 50,
					'left'     => 50,
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .spinning-badge__center' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'center_box_shadow',
				'label'    => esc_html__('Box Shadow', 'carvia-core'),
				'selector' => '{{WRAPPER}} .spinning-badge__center',
			]
		);

		$this->end_controls_section();

		/* ------------------------------------------------------------ */
		/* SECTION: Icon / Image Style */
		/* ------------------------------------------------------------ */
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__('Icon / Image Style', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => esc_html__('Icon Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', 'rem'],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 32,
				],
				'selectors' => [
					'{{WRAPPER}} .spinning-badge__center i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .spinning-badge__center svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__('Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .spinning-badge__center i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .spinning-badge__center svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'icon_type' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'center_image_size',
			[
				'label'      => esc_html__('Image Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
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
				'default' => [
					'unit' => '%',
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .spinning-badge__center-image' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'center_image_border_radius',
			[
				'label'      => esc_html__('Image Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .spinning-badge__center-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$spinning_image_url = ! empty($settings['spinning_image']['url']) ? esc_url($settings['spinning_image']['url']) : '';
		$spinning_image_alt = ! empty($settings['spinning_image']['alt']) ? esc_attr($settings['spinning_image']['alt']) : '';

		$icon_type    = ! empty($settings['icon_type']) ? $settings['icon_type'] : 'icon';
		$center_image = ! empty($settings['center_image']['url']) ? esc_url($settings['center_image']['url']) : '';
		$center_alt   = ! empty($settings['center_image_alt']) ? esc_attr($settings['center_image_alt']) : '';
?>
		<div class="spinning-badge">

			<?php if ($spinning_image_url) : ?>
				<img
					class="spinning-badge__image"
					src="<?php echo $spinning_image_url; ?>"
					alt="<?php echo $spinning_image_alt; ?>" />
			<?php endif; ?>

			<div class="spinning-badge__center">
				<?php if ('icon' === $icon_type) : ?>
					<?php
					Icons_Manager::render_icon(
						$settings['center_icon'],
						['aria-hidden' => 'true']
					);
					?>
				<?php elseif ('image' === $icon_type && $center_image) : ?>
					<img
						class="spinning-badge__center-image"
						src="<?php echo $center_image; ?>"
						alt="<?php echo $center_alt; ?>" />
				<?php endif; ?>
			</div>

		</div>
	<?php
	}

	protected function content_template()
	{
	?>
		<#
			var spinningImageUrl=settings.spinning_image.url ? settings.spinning_image.url : '' ;
			var iconType=settings.icon_type ? settings.icon_type : 'icon' ;
			var centerImageUrl=settings.center_image.url ? settings.center_image.url : '' ;
			var centerAlt=settings.center_image_alt ? settings.center_image_alt : '' ;
			var iconHTML=elementor.helpers.renderIcon( view, settings.center_icon, { 'aria-hidden' : 'true' }, 'i' , 'object' );
			#>
			<div class="spinning-badge">

				<# if ( spinningImageUrl ) { #>
					<img
						class="spinning-badge__image"
						src="{{ spinningImageUrl }}"
						alt="" />
					<# } #>

						<div class="spinning-badge__center">
							<# if ( 'icon'===iconType ) { #>
								{{{ iconHTML.value }}}
								<# } else if ( 'image'===iconType && centerImageUrl ) { #>
									<img
										class="spinning-badge__center-image"
										src="{{ centerImageUrl }}"
										alt="{{ centerAlt }}" />
									<# } #>
						</div>

			</div>
	<?php
	}
}
