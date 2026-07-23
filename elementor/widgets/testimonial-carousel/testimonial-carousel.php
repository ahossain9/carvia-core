<?php

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

if (! defined('ABSPATH')) {
	exit;
}

class Testimonial_Carousel extends Widget_Base
{

	public function get_name()
	{
		return 'carvia_testimonial_carousel';
	}

	public function get_title()
	{
		return esc_html__('Testimonial Carousel', 'carvia-core');
	}

	public function get_icon()
	{
		return 'carvia-core-icon eicon-testimonial-carousel';
	}

	public function get_categories()
	{
		return ['carvia_core'];
	}

	public function get_keywords()
	{
		return ['testimonial', 'carousel', 'review', 'slider', 'carvia'];
	}

	public function get_script_depends()
	{
		return ['swiper-slider', 'swiper-activation'];
	}

	public function get_style_depends()
	{
		return ['swiper-style'];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section_testimonials',
			[
				'label' => esc_html__('Testimonials', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		// Rating
		$repeater->add_control(
			'rating',
			[
				'label'   => esc_html__('Rating', 'carvia-core'),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 5,
						'step' => 0.5,
					],
				],
				'default' => ['size' => 5],
			]
		);

		// Title
		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__('Title', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__('Amazing Service!', 'carvia-core'),
			]
		);

		// Content
		$repeater->add_control(
			'content',
			[
				'label'   => esc_html__('Testimonial Content', 'carvia-core'),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 5,
				'default' => esc_html__('This is an amazing testimonial. The service was outstanding and exceeded all of our expectations.', 'carvia-core'),
			]
		);

		// Client Image
		$repeater->add_control(
			'client_image',
			[
				'label'   => esc_html__('Client Image', 'carvia-core'),
				'type'    => Controls_Manager::MEDIA,
				'default' => ['url' => Utils::get_placeholder_image_src()],
			]
		);

		// Client Name
		$repeater->add_control(
			'client_name',
			[
				'label'   => esc_html__('Client Name', 'carvia-core'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('John Doe', 'carvia-core'),
			]
		);

		// Client Designation
		$repeater->add_control(
			'client_designation',
			[
				'label'   => esc_html__('Designation', 'carvia-core'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('CEO, Company', 'carvia-core'),
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => esc_html__('Testimonials', 'carvia-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'rating'             => ['size' => 5],
						'title'              => esc_html__('Outstanding Experience!', 'carvia-core'),
						'content'            => esc_html__('The team delivered beyond expectations. Truly professional and dedicated.', 'carvia-core'),
						'client_name'        => esc_html__('Sarah Johnson', 'carvia-core'),
						'client_designation' => esc_html__('Marketing Director', 'carvia-core'),
					],
					[
						'rating'             => ['size' => 5],
						'title'              => esc_html__('Highly Recommended!', 'carvia-core'),
						'content'            => esc_html__('Exceptional quality and support. Will definitely work with them again.', 'carvia-core'),
						'client_name'        => esc_html__('Michael Chen', 'carvia-core'),
						'client_designation' => esc_html__('Product Manager', 'carvia-core'),
					],
					[
						'rating'             => ['size' => 5],
						'title'              => '',
						'content'            => esc_html__('Incredible results delivered on time. The attention to detail was remarkable.', 'carvia-core'),
						'client_name'        => esc_html__('Emily Davis', 'carvia-core'),
						'client_designation' => esc_html__('Creative Director', 'carvia-core'),
					],
				],
				'title_field' => '{{{ client_name }}}',
			]
		);

		$this->end_controls_section();

		//-------------------------------------------------------------
		// SECTION: Carousel Settings
		// -------------------------------------------------------------
		$this->start_controls_section(
			'section_carousel_settings',
			[
				'label' => esc_html__('Carousel Settings', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slides_to_show',
			[
				'label'   => esc_html__('Slides To Show', 'carvia-core'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'default' => '3',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__('Autoplay', 'carvia-core'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'carvia-core'),
				'label_off'    => esc_html__('No', 'carvia-core'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__('Autoplay Speed (ms)', 'carvia-core'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 10000,
				'step'      => 500,
				'default'   => 3000,
				'condition' => ['autoplay' => 'yes'],
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label'        => esc_html__('Show Navigation', 'carvia-core'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'carvia-core'),
				'label_off'    => esc_html__('No', 'carvia-core'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'show_pagination',
			[
				'label'        => esc_html__('Show Pagination', 'carvia-core'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'carvia-core'),
				'label_off'    => esc_html__('No', 'carvia-core'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'space_between',
			[
				'label'   => esc_html__('Space Between Slides (px)', 'carvia-core'),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'default' => 30,
			]
		);

		$this->end_controls_section();

		//-------------------------------------------------------------
		// STYLE: Card
		// -------------------------------------------------------------
		$this->start_controls_section(
			'section_style_card',
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
				'default'   => '#FFFFFF',
				'selector' => '{{WRAPPER}} .testimonial-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'label'    => esc_html__('Border', 'carvia-core'),
				'selector' => '{{WRAPPER}} .testimonial-card',
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '30',
					'right'    => '30',
					'bottom'   => '30',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'label'    => esc_html__('Box Shadow', 'carvia-core'),
				'selector' => '{{WRAPPER}} .testimonial-card',
			]
		);

		$this->add_control(
			'card_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '32',
					'right'    => '32',
					'bottom'   => '32',
					'left'     => '32',
					'unit'     => 'px',
					'isLinked' => true,
				],
			]
		);

		$this->end_controls_section();

		// -------------------------------------------------------------
		// STYLE: Star Rating
		// -------------------------------------------------------------
		$this->start_controls_section(
			'section_style_star',
			[
				'label' => esc_html__('Star Rating', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'star_icon_color',
			[
				'label'     => esc_html__('Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFB800',
				'selectors' => [
					'{{WRAPPER}} .testimonial-star-rating .testimonial-star-icon'      => 'color: {{VALUE}};',
					'{{WRAPPER}} .testimonial-star-rating .testimonial-star-icon.empty' => 'color: #d0d0d0;',
				],
			]
		);

		$this->add_control(
			'star_icon_size',
			[
				'label'      => esc_html__('Icon Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => ['min' => 10, 'max' => 60],
				],
				'default'    => ['unit' => 'px', 'size' => 18],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-star-rating .testimonial-star-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'star_icon_spacing',
			[
				'label'      => esc_html__('Icon Spacing', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => ['min' => 0, 'max' => 20],
				],
				'default'    => ['unit' => 'px', 'size' => 3],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-star-rating .testimonial-star-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'star_wrap_spacing',
			[
				'label'      => esc_html__('Icon Wrap Spacing (Bottom)', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => ['min' => 0, 'max' => 60],
				],
				'default'    => ['unit' => 'px', 'size' => 16],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-star-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// -------------------------------------------------------------
		// STYLE: Title
		// -------------------------------------------------------------
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
				'default'   => '#1a1a2e',
				'selectors' => [
					'{{WRAPPER}} .testimonial-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__('Typography', 'carvia-core'),
				'selector' => '{{WRAPPER}} .testimonial-title',
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label'      => esc_html__('Spacing (Bottom)', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => ['min' => 0, 'max' => 60],
				],
				'default'    => ['unit' => 'px', 'size' => 12],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// -------------------------------------------------------------
		// STYLE: Testimonial Content
		// -------------------------------------------------------------
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Testimonial Content', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#555577',
				'selectors' => [
					'{{WRAPPER}} .testimonial-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => esc_html__('Typography', 'carvia-core'),
				'selector' => '{{WRAPPER}} .testimonial-content',
			]
		);

		$this->add_control(
			'content_spacing',
			[
				'label'      => esc_html__('Spacing (Bottom)', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => ['min' => 0, 'max' => 200],
				],
				'default'    => ['unit' => 'px', 'size' => 24],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// -------------------------------------------------------------
		// STYLE: Client Image
		// -------------------------------------------------------------
		$this->start_controls_section(
			'section_style_client_image',
			[
				'label' => esc_html__('Client Image', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'client_image_size',
			[
				'label'      => esc_html__('Image Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => ['min' => 30, 'max' => 150],
				],
				'default'    => ['unit' => 'px', 'size' => 56],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-client-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'client_image_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-client-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'client_image_border',
				'label'    => esc_html__('Border', 'carvia-core'),
				'selector' => '{{WRAPPER}} .testimonial-client-image img',
			]
		);

		$this->add_control(
			'client_image_info_spacing',
			[
				'label'      => esc_html__('Spacing Between Image & Info', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => ['min' => 0, 'max' => 40],
				],
				'default'    => ['unit' => 'px', 'size' => 14],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-client-image' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// -------------------------------------------------------------
		// STYLE: Client Name
		// -------------------------------------------------------------
		$this->start_controls_section(
			'section_style_client_name',
			[
				'label' => esc_html__('Client Name', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'client_name_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a1a2e',
				'selectors' => [
					'{{WRAPPER}} .testimonial-client-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'client_name_typography',
				'label'    => esc_html__('Typography', 'carvia-core'),
				'selector' => '{{WRAPPER}} .testimonial-client-name',
			]
		);

		$this->add_control(
			'client_name_spacing',
			[
				'label'      => esc_html__('Spacing (Bottom)', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => ['min' => 0, 'max' => 30],
				],
				'default'    => ['unit' => 'px', 'size' => 4],
				'selectors'  => [
					'{{WRAPPER}} .testimonial-client-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// -------------------------------------------------------------
		// STYLE: Client Designation
		// -------------------------------------------------------------
		$this->start_controls_section(
			'section_style_client_designation',
			[
				'label' => esc_html__('Client Designation', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'client_designation_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#888899',
				'selectors' => [
					'{{WRAPPER}} .testimonial-client-designation' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'client_designation_typography',
				'label'    => esc_html__('Typography', 'carvia-core'),
				'selector' => '{{WRAPPER}} .testimonial-client-designation',
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings      = $this->get_settings_for_display();
		$testimonials  = $settings['testimonials'];
		$widget_id     = $this->get_id();
		$autoplay      = $settings['autoplay'] === 'yes' ? 'true' : 'false';
		$autoplay_speed = isset($settings['autoplay_speed']) ? (int) $settings['autoplay_speed'] : 3000;
		$slides_to_show = (int) $settings['slides_to_show'];
		$space_between  = isset($settings['space_between']) ? (int) $settings['space_between'] : 30;
		$show_nav      = $settings['show_navigation'] === 'yes';
		$show_pag      = $settings['show_pagination'] === 'yes';

		if (empty($testimonials)) {
			return;
		}
?>
		<div class="testimonial-carousel-wrapper">
			<div class="swiper testimonial-swiper" id="carvia-swiper-<?php echo esc_attr($widget_id); ?>"
				data-autoplay="<?php echo esc_attr($autoplay); ?>"
				data-autoplay-speed="<?php echo esc_attr($autoplay_speed); ?>"
				data-slides="<?php echo esc_attr($slides_to_show); ?>"
				data-space="<?php echo esc_attr($space_between); ?>">
				<div class="swiper-wrapper">
					<?php foreach ($testimonials as $item) :
						$rating     = isset($item['rating']['size']) ? floatval($item['rating']['size']) : 5;
						$full_stars = floor($rating);
						$half_star  = ($rating - $full_stars) >= 0.5;
						$empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
					?>
						<div class="swiper-slide">
							<div class="testimonial-card elementor-repeater-item-<?php echo esc_attr($item['_id']); ?>">

								<!-- Star Rating -->
								<div class="testimonial-star-rating" aria-label="<?php echo esc_attr($rating); ?> out of 5 stars">
									<?php
									// Full stars
									for ($i = 0; $i < $full_stars; $i++) {
										echo '<span class="testimonial-star-icon">';
										Icons_Manager::render_icon(
											['value' => 'fas fa-star', 'library' => 'fa-solid'],
											['aria-hidden' => 'true']
										);
										echo '</span>';
									}

									// Half star
									if ($half_star) {
										echo '<span class="testimonial-star-icon">';
										Icons_Manager::render_icon(
											['value' => 'fas fa-star-half-alt', 'library' => 'fa-solid'],
											['aria-hidden' => 'true']
										);
										echo '</span>';
									}

									// Empty stars
									for ($i = 0; $i < $empty_stars; $i++) {
										echo '<span class="testimonial-star-icon empty">';
										Icons_Manager::render_icon(
											['value' => 'far fa-star', 'library' => 'fa-regular'],
											['aria-hidden' => 'true']
										);
										echo '</span>';
									}
									?>
								</div>

								<!-- Title -->
								<?php if (! empty($item['title'])) : ?>
									<h4 class="testimonial-title"><?php echo esc_html($item['title']); ?></h4>
								<?php endif; ?>

								<!-- Content -->
								<p class="testimonial-content"><?php echo esc_html($item['content']); ?></p>

								<!-- Client Info -->
								<div class="testimonial-client-info">
									<?php if (! empty($item['client_image']['url'])) : ?>
										<div class="testimonial-client-image">
											<img src="<?php echo esc_url($item['client_image']['url']); ?>"
												alt="<?php echo esc_attr($item['client_name']); ?>">
										</div>
									<?php endif; ?>
									<div class="testimonial-client-details">
										<?php if (! empty($item['client_name'])) : ?>
											<div class="testimonial-client-name"><?php echo esc_html($item['client_name']); ?></div>
										<?php endif; ?>
										<?php if (! empty($item['client_designation'])) : ?>
											<div class="testimonial-client-designation"><?php echo esc_html($item['client_designation']); ?></div>
										<?php endif; ?>
									</div>
								</div>

							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ($show_pag) : ?>
					<div class="swiper-pagination testimonial-pagination"></div>
				<?php endif; ?>
			</div>

			<?php if ($show_nav) : ?>
				<div class="testimonial-swiper-btn testimonial-swiper-prev" tabindex="0" role="button" aria-label="<?php esc_attr_e('Previous Slide', 'carvia-core'); ?>">
					<?php
					Icons_Manager::render_icon(
						['value' => 'fas fa-chevron-left', 'library' => 'fa-solid'],
						['aria-hidden' => 'true']
					);
					?>
				</div>
				<div class="testimonial-swiper-btn testimonial-swiper-next" tabindex="0" role="button" aria-label="<?php esc_attr_e('Next Slide', 'carvia-core'); ?>">
					<?php
					Icons_Manager::render_icon(
						['value' => 'fas fa-chevron-right', 'library' => 'fa-solid'],
						['aria-hidden' => 'true']
					);
					?>
				</div>
			<?php endif; ?>
		</div>
<?php
	}
}
