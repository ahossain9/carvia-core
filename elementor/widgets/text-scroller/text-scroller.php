<?php

/**
 * carvia_core testimonial carousel widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

defined('ABSPATH') || die();

class Text_Scroller extends Widget_Base
{

	public function get_name()
	{
		return 'carvia-text-scroller';
	}

	public function get_title()
	{
		return __('Text Scroller', 'carvia-core');
	}

	public function get_icon()
	{
		return 'carvia-core-icon eicon-slider-3d';
	}

	public function get_categories()
	{
		return ['carvia_core'];
	}

	public function get_keywords()
	{
		return [
			'scroller',
			'text scroller',
			'carvia text scroller image',
			'carvia',
		];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'content_section',
			[
				'label' => __('Content', 'carvia-core'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => __('Title', 'carvia-core'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __('Expert Instructors', 'carvia-core'),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__('Icon', 'carvia-core'),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'fas fa-circle',
					'library' => 'fa-solid',
				],
			]
		);
		$this->add_control(
			'list_item',
			[
				'label' => __('Text List', 'carvia-core'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __('Title 1', 'carvia-core'),
					],
					[
						'title' => __('Title 2', 'carvia-core'),
					],
					[
						'title' => __('Title 3', 'carvia-core'),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);
		$this->end_controls_section();

		// Options
		$this->start_controls_section(
			'options',
			[
				'label' => esc_html__('Options', 'carvia-core'),
			]
		);
		$this->add_control(
			'animation_speed',
			[
				'label' => __('Scroll Speed ( Second )', 'carvia-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => 20,
			]
		);
		$this->end_controls_section();

		// Style tab
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __('Content', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'item_spacing',
			[
				'label' => __('Item Spacing', 'carvia-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .scroller-content' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .scroller-content' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'title_heading',
			[
				'label' => __('Title', 'carvia-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => __('Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .scroller-content .scroller-text' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .scroller-content .scroller-text',
			]
		);
		$this->add_control(
			'icon_heading',
			[
				'label' => __('Icon', 'carvia-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__('Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .scroller-content .scroller-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .scroller-content .scroller-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__('Size', 'carvia-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'em'],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .scroller-content .scroller-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .scroller-content .scroller-icon svg' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => __('Spacing', 'carvia-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .scroller-content .scroller-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

?>
		<?php
		if ($settings['list_item']) : ?>
			<div class="text-scroller-wrap">
				<div class="text-scroller-inner">
					<?php foreach ($settings['list_item'] as $item) : ?>
						<div class="scroller-content">
							<?php if (!empty($item['title'])) : ?>
								<span class="scroller-text">
									<?php echo esc_html__($item['title']); ?>
								</span>
							<?php endif; ?>
							<span class="scroller-icon">
								<?php Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
							</span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		<style>
			.text-scroller-inner {
				animation: marquee <?php echo $settings['animation_speed']; ?>s linear infinite;
			}

			@keyframes marquee {
				0% {
					transform: translateX(0%);
				}

				100% {
					transform: translateX(-100%);
				}
			}
		</style>
<?php

	}
}
