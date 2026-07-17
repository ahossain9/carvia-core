<?php

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Utils;

if (! defined('ABSPATH')) exit;

class Team_Member extends Widget_Base
{

	public function get_name()
	{
		return 'carvia-team-member';
	}

	public function get_title()
	{
		return esc_html__('Team Member', 'carvia');
	}

	public function get_icon()
	{
		return 'carvia-core-icon eicon-person';
	}

	public function get_categories()
	{
		return ['carvia_core'];
	}

	public function get_keywords()
	{
		return ['team', 'member', 'person', 'staff', 'social', 'carvia'];
	}

	protected function register_controls()
	{

		/* ─── CONTENT: MEMBER ─── */
		$this->start_controls_section(
			'section_member',
			[
				'label' => esc_html__('Team Member', 'carvia'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__('Photo', 'carvia'),
				'type'    => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src()],
				'dynamic' => ['active' => true],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',
				'default' => 'large',
			]
		);

		$this->add_control(
			'name',
			[
				'label'       => esc_html__('Name', 'carvia'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'John Smith',
				'label_block' => true,
				'dynamic'     => ['active' => true],
			]
		);

		$this->add_control(
			'designation',
			[
				'label'       => esc_html__('Designation', 'carvia'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Pest Control Specialist',
				'label_block' => true,
				'dynamic'     => ['active' => true],
			]
		);

		$this->add_control(
			'name_tag',
			[
				'label'   => esc_html__('Name HTML Tag', 'carvia'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'p',
				],
			]
		);

		$this->end_controls_section();

		/* ─── CONTENT: SOCIAL ICONS ─── */
		$this->start_controls_section(
			'section_social',
			[
				'label' => esc_html__('Social Icons', 'carvia'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_icon',
			[
				'label'   => esc_html__('Icon', 'carvia'),
				'type'    => Controls_Manager::ICONS,
				'default' => ['value' => 'fab fa-facebook-f', 'library' => 'fa-brands'],
			]
		);

		$repeater->add_control(
			'social_url',
			[
				'label'         => esc_html__('URL', 'carvia'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => 'https://',
				'default'       => ['url' => '#'],
				'show_external' => true,
				'dynamic'       => ['active' => true],
			]
		);

		$this->add_control(
			'social_icons',
			[
				'label'       => esc_html__('Icons', 'carvia'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					['social_icon' => ['value' => 'fab fa-facebook-f',  'library' => 'fa-brands'], 'social_url' => ['url' => '#']],
					['social_icon' => ['value' => 'fab fa-twitter',     'library' => 'fa-brands'], 'social_url' => ['url' => '#']],
					['social_icon' => ['value' => 'fab fa-instagram',   'library' => 'fa-brands'], 'social_url' => ['url' => '#']],
					['social_icon' => ['value' => 'fab fa-linkedin-in', 'library' => 'fa-brands'], 'social_url' => ['url' => '#']],
				],
				'title_field' => '<i class="{{ social_icon.value }}"></i>',
			]
		);

		$this->end_controls_section();

		/* ─── STYLE: IMAGE ─── */
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__('Image', 'carvia'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .carvia-team-image img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-team-image'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .carvia-team-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_enabled',
			[
				'label'        => esc_html__('Gradient Overlay', 'carvia'),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'overlay_bg',
				'types'     => ['gradient'],
				'selector'  => '{{WRAPPER}} .carvia-team-overlay',
				'condition' => ['overlay_enabled' => 'yes'],
				'fields_options' => [
					'background'       => ['default' => 'gradient'],
					'color'            => ['default' => 'rgba(0,0,0,0)'],
					'color_b'          => ['default' => 'rgba(0,0,0,0.65)'],
					'gradient_type'    => ['default' => 'linear'],
					'gradient_angle'   => ['default' => ['size' => 180]],
				],
			]
		);

		$this->end_controls_section();

		/* ─── STYLE: Info Box ─── */
		$this->start_controls_section(
			'section_info_box_style',
			[
				'label' => esc_html__('Member Info', 'carvia'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'info_box_bg',
			[
				'label'     => esc_html__('Box Background', 'carvia'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carvia-team-info' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_box_padding',
			[
				'label'      => esc_html__('Box Padding', 'carvia'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-team-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'info_box_position',
			[
				'label'     => esc_html__('Position from Bottom', 'carvia'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => ['px' => ['min' => 0, 'max' => 200]],
				'selectors' => ['{{WRAPPER}} .carvia-team-info' => 'bottom: {{SIZE}}{{UNIT}};'],
			]
		);

		// NAME
		$this->add_control(
			'heading_name',
			[
				'label'     => esc_html__('Name', 'carvia'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .carvia-team-name',
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => esc_html__('Color', 'carvia'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => ['{{WRAPPER}} .carvia-team-name' => 'color: {{VALUE}};'],
			]
		);

		$this->add_control(
			'name_spacing',
			[
				'label'     => esc_html__('Spacing Between', 'carvia'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => ['px' => ['min' => 0, 'max' => 40]],
				'selectors' => ['{{WRAPPER}} .carvia-team-name' => 'margin-bottom: {{SIZE}}{{UNIT}};'],
			]
		);

		// DESIGNATION
		$this->add_control(
			'heading_designation',
			[
				'label'     => esc_html__('Designation', 'carvia'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'designation_typography',
				'selector' => '{{WRAPPER}} .carvia-team-designation',
			]
		);

		$this->add_control(
			'designation_color',
			[
				'label'     => esc_html__('Color', 'carvia'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => ['{{WRAPPER}} .carvia-team-designation' => 'color: {{VALUE}};'],
			]
		);

		$this->end_controls_section();

		/* ─── STYLE: SOCIAL ─── */
		$this->start_controls_section(
			'section_social_style',
			[
				'label' => esc_html__('Social Icons', 'carvia'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'social_icon_size',
			[
				'label'     => esc_html__('Icon Size', 'carvia'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => ['size' => 14, 'unit' => 'px'],
				'range'     => ['px' => ['min' => 8, 'max' => 40]],
				'selectors' => [
					'{{WRAPPER}} .carvia-team-social-link i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carvia-team-social-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_btn_width',
			[
				'label'     => esc_html__('Button Width', 'carvia'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => ['size' => 36, 'unit' => 'px'],
				'range'     => ['px' => ['min' => 20, 'max' => 80]],
				'selectors' => ['{{WRAPPER}} .carvia-team-social-link' => 'width: {{SIZE}}{{UNIT}};'],
			]
		);

		$this->add_control(
			'social_btn_height',
			[
				'label'     => esc_html__('Button Height', 'carvia'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => ['size' => 36, 'unit' => 'px'],
				'range'     => ['px' => ['min' => 20, 'max' => 80]],
				'selectors' => ['{{WRAPPER}} .carvia-team-social-link' => 'height: {{SIZE}}{{UNIT}};'],
			]
		);

		$this->add_control(
			'social_icon_color',
			[
				'label'     => esc_html__('Icon Color', 'carvia'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .carvia-team-social-link'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .carvia-team-social-link svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_bg_color',
			[
				'label'     => esc_html__('Background Color', 'carvia'),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.18)',
				'selectors' => ['{{WRAPPER}} .carvia-team-social-link' => 'background-color: {{VALUE}};'],
			]
		);

		$this->add_control(
			'social_hover_color',
			[
				'label'     => esc_html__('Hover Background', 'carvia'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7DC242',
				'selectors' => ['{{WRAPPER}} .carvia-team-social-link:hover' => 'background-color: {{VALUE}};'],
			]
		);

		$this->add_control(
			'social_icon_hover_color',
			[
				'label'     => esc_html__('Hover Icon Color', 'carvia'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .carvia-team-social-link:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .carvia-team-social-link:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_gap',
			[
				'label'     => esc_html__('Gap Between Icons', 'carvia'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => ['size' => 8, 'unit' => 'px'],
				'range'     => ['px' => ['min' => 0, 'max' => 30]],
				'selectors' => ['{{WRAPPER}} .carvia-team-social' => 'gap: {{SIZE}}{{UNIT}};'],
			]
		);

		$this->add_control(
			'social_border_radius',
			[
				'label'      => esc_html__('Button Radius', 'carvia'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-team-social-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$name_tag = ! empty($settings['name_tag']) ? $settings['name_tag'] : 'h3';

		echo '<div class="carvia-team-card">';

		/* ── Image wrapper ── */
		echo '<div class="carvia-team-image">';

		// Image
		if (! empty($settings['image']['url'])) {
			$image_url = Group_Control_Image_Size::get_attachment_image_src($settings['image']['id'], 'image', $settings);
			if (! $image_url) $image_url = $settings['image']['url'];
			echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($settings['name']) . '" loading="lazy">';
		}

		// Overlay
		if ('yes' === $settings['overlay_enabled']) {
			echo '<div class="carvia-team-overlay"></div>';
		}

		/* ── Social – left side, vertical slide on hover ── */
		if (! empty($settings['social_icons'])) {
			echo '<div class="carvia-team-social" role="list">';
			foreach ($settings['social_icons'] as $item) {
				$url    = ! empty($item['social_url']['url']) ? $item['social_url']['url'] : '#';
				$target = ! empty($item['social_url']['is_external']) ? ' target="_blank"' : '';
				$norel  = ! empty($item['social_url']['nofollow'])    ? ' rel="nofollow"'  : '';
				echo '<a href="' . esc_url($url) . '" class="carvia-team-social-link elementor-repeater-item-' . esc_attr($item['_id']) . '" role="listitem"' . $target . $norel . ' aria-label="social link">';
				Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true']);
				echo '</a>';
			}
			echo '</div>';
		}

		/* ── Info box – 50% over image from bottom ── */
		echo '<div class="carvia-team-info">';
		echo '<' . esc_attr($name_tag) . ' class="carvia-team-name">' . esc_html($settings['name']) . '</' . esc_attr($name_tag) . '>';
		if (! empty($settings['designation'])) {
			echo '<p class="carvia-team-designation">' . esc_html($settings['designation']) . '</p>';
		}
		echo '</div>'; // .carvia-team-info

		echo '</div>'; // .carvia-team-image
		echo '</div>'; // .carvia-team-card
	}

	protected function content_template()
	{
?>
		<div class="carvia-team-card">
			<div class="carvia-team-image">
				<# if ( settings.image.url ) { #>
					<img src="{{ settings.image.url }}" alt="{{ settings.name }}" loading="lazy">
					<# } #>
						<# if ( settings.overlay_enabled==='yes' ) { #>
							<div class="carvia-team-overlay"></div>
							<# } #>
								<# if ( settings.social_icons.length ) { #>
									<div class="carvia-team-social">
										<# _.each( settings.social_icons, function( item ) { #>
											<a href="{{ item.social_url.url }}" class="carvia-team-social-link elementor-repeater-item-{{ item._id }}" aria-label="social link">
												<i class="{{ item.social_icon.value }}" aria-hidden="true"></i>
											</a>
											<# }); #>
									</div>
									<# } #>
										<div class="carvia-team-info">
											<{{{ settings.name_tag }}} class="carvia-team-name">{{{ settings.name }}}</{{{ settings.name_tag }}}>
											<# if ( settings.designation ) { #>
												<span class="carvia-team-designation">{{{ settings.designation }}}</span>
												<# } #>
										</div>
			</div>
		</div>
<?php
	}
}
