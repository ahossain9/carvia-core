<?php

/**
 * carvia_core accordian widget for elementor
 * @package Carvia_Core
 * @since 1.0.0
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

defined('ABSPATH') || die();

class Accordian extends Widget_Base
{

	public function get_name()
	{
		return 'carvia-accordian';
	}

	public function get_title()
	{
		return __('Accordian', 'carvia-core');
	}

	public function get_icon()
	{
		return 'carvia-core-icon eicon-accordion';
	}

	public function get_categories()
	{
		return ['carvia_core'];
	}

	public function get_keywords()
	{
		return [
			'accordian',
			'toggle',
			'carvia',
		];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'_section_accordian',
			[
				'label' => __('Accordian', 'carvia-core'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$accordion_lists = new Repeater();

		$accordion_lists->add_control(
			'title',
			[
				'label' => __('Title', 'carvia-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Title', 'carvia-core'),
				'label_block' => true,
			]
		);

		$accordion_lists->add_control(
			'description',
			[
				'label' => __('Description', 'carvia-core'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __('Accordion description text', 'carvia-core')
			]
		);

		$accordion_lists->add_control(
			'status',
			[
				'label' => __('Is Active?', 'carvia-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'carvia-core'),
				'label_off' => __('No', 'carvia-core'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'accordion_lists',
			[
				'label' => __('Accordion Box', 'carvia-core'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $accordion_lists->get_controls(),
				'default' => [
					[
						'title' => __('My Progress', 'carvia-core'),
						'text' => __('Accordion Paragraph text', 'carvia-core'),
						'status' => 'no'
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_global',
			[
				'label' => __('General', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'accordian_global_padding',
			[
				'label' => __('Padding', 'carvia-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'accordian_global_space',
			[
				'label' => __('Spacing', 'carvia-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('accordian_global_tabs');
		$this->start_controls_tab(
			'accordian_global_normal',
			[
				'label' => __('Normal', 'carvia-core'),
			]
		);

		$this->add_control(
			'accordian_global_bg_color',
			[
				'label' => __('Background Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'accordian_global_border',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'accordian_global_box_shadow',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'accordian_global_hover',
			[
				'label' => __('Hover', 'carvia-core'),
			]
		);

		$this->add_control(
			'accordian_global_hover_bg_color',
			[
				'label' => __('Background Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'accordian_global_hover_border',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'accordian_global_hover_box_shadow',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'accordian_global_border_radius',
			[
				'label' => __('Border Radius', 'carvia-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __('Content', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'title_style',
			[
				'label' => __('Title', 'carvia-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => __('Padding', 'carvia-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single .accordion-title',
			]
		);

		$this->start_controls_tabs('accordian_tabs');
		$this->start_controls_tab(
			'title_normal',
			[
				'label' => __('Normal', 'carvia-core'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'title_bg_color',
			[
				'label' => __('Background Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_global_border',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single .accordion-title',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'title_global_box_shadow',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single .accordion-title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_hover',
			[
				'label' => __('Hover', 'carvia-core'),
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => __('Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title:hover' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'title_hover_bg_color',
			[
				'label' => __('Background Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_hover_border',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single .accordion-title:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'title_hover_box_shadow',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single .accordion-title:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_active',
			[
				'label' => __('Active', 'carvia-core'),
			]
		);

		$this->add_control(
			'title_active_color',
			[
				'label' => __('Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title.active' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'title_active_bg_color',
			[
				'label' => __('Background Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_active_border',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single .accordion-title.active',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'title_active_box_shadow',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single .accordion-title.active',
			]
		);

		$this->add_responsive_control(
			'title_border_radius',
			[
				'label' => __('Border Radius', 'carvia-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'icon_style',
			[
				'label' => __('Icon', 'carvia-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'icon_top_position',
			[
				'label' => __('Top', 'carvia-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title:before' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_right_position',
			[
				'label' => __('Right', 'carvia-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title:before' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __('Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title:before' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => __('Hover Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title:hover:before' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label' => __('Active Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title.active:before' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __('Size', 'carvia-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_line_height',
			[
				'label' => __('Line Height', 'carvia-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .accordion-title:before' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desc_style',
			[
				'label' => __('Description', 'carvia-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'desc_padding',
			[
				'label' => __('Padding', 'carvia-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __('Color', 'carvia-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .accordion-list .accordion-single .content .text' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'selector' => '{{WRAPPER}} .accordion-list .accordion-single .content .text',
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display(); ?>
		<div class="accordian-wrap">
			<ul class="accordion-list" id="<?php echo esc_attr(uniqid()); ?>">
				<?php foreach ($settings['accordion_lists'] as $accordion_list) : ?>
					<?php $get_status = $accordion_list['status']; ?>
					<!--Block-->
					<li class="accordion-single <?php echo esc_attr(('yes' == $get_status) ? 'active' : ''); ?>">
						<div class="accordion-title <?php echo esc_attr(('yes' === $get_status) ? 'active' : ''); ?>">
							<?php echo esc_html($accordion_list['title']); ?>
						</div>
						<div class="accordion-content <?php echo esc_attr(('yes' == $get_status) ? 'current' : ''); ?>">
							<div class="content">
								<div class="text"><?php echo esc_html($accordion_list['description']); ?></div>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
<?php
	}
}
