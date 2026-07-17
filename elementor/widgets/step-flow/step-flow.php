<?php

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (! defined('ABSPATH')) exit;

class Step_Flow extends Widget_Base
{

	public function get_name()
	{
		return 'carvia-step-flow';
	}

	public function get_title()
	{
		return esc_html__('Step Flow', 'carvia-core');
	}

	public function get_icon()
	{
		return 'carvia-core-icon eicon-flow';
	}

	public function get_categories()
	{
		return ['carvia_core'];
	}

	public function get_keywords()
	{
		return ['step', 'flow', 'process', 'steps', 'carvia-core'];
	}

	protected function register_controls()
	{

		/* ─── CONTENT ─── */
		$this->start_controls_section(
			'section_steps',
			[
				'label' => esc_html__('Steps', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'step_label',
			[
				'label'   => esc_html__('Step Label', 'carvia-core'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Step: 1', 'carvia-core'),
			]
		);

		$repeater->add_control(
			'step_title',
			[
				'label'       => esc_html__('Title', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Inspection', 'carvia-core'),
				'label_block' => true,
				'dynamic'     => ['active' => true],
			]
		);

		$repeater->add_control(
			'step_description',
			[
				'label'      => esc_html__('Description', 'carvia-core'),
				'type'       => Controls_Manager::TEXTAREA,
				'default'    => esc_html__('We carefully inspect your property to identify the pest type, infestation level, and potential risk areas.', 'carvia-core'),
				'rows'       => 4,
				'dynamic'    => ['active' => true],
			]
		);

		$repeater->add_control(
			'badge_color',
			[
				'label'   => esc_html__('Badge Color', 'carvia-core'),
				'type'    => Controls_Manager::COLOR,
				'default' => '#7DC242',
			]
		);

		$repeater->add_control(
			'badge_text_color',
			[
				'label'   => esc_html__('Badge Text Color', 'carvia-core'),
				'type'    => Controls_Manager::COLOR,
				'default' => '#1a3a1a',
			]
		);

		$this->add_control(
			'steps',
			[
				'label'       => esc_html__('Steps', 'carvia-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'step_label'       => 'Step: 1',
						'step_title'       => 'Inspection',
						'step_description' => 'We carefully inspect your property to identify the pest type, infestation level, and potential risk areas.',
						'badge_color'      => '#7DC242',
						'badge_text_color' => '#1a3a1a',
					],
					[
						'step_label'       => 'Step: 2',
						'step_title'       => 'Treatment Plan',
						'step_description' => 'We develop a customized treatment plan tailored to the specific pest problem and your property needs.',
						'badge_color'      => '#7DC242',
						'badge_text_color' => '#1a3a1a',
					],
					[
						'step_label'       => 'Step: 3',
						'step_title'       => 'Treatment',
						'step_description' => 'Our certified technicians apply the most effective and safe treatments to eliminate pests from your property.',
						'badge_color'      => '#7DC242',
						'badge_text_color' => '#1a3a1a',
					],
					[
						'step_label'       => 'Step: 4',
						'step_title'       => 'Follow-Up',
						'step_description' => 'We schedule follow-up visits to ensure the treatment was successful and provide ongoing prevention tips.',
						'badge_color'      => '#7DC242',
						'badge_text_color' => '#1a3a1a',
					],
				],
				'title_field' => '{{{ step_label }}} – {{{ step_title }}}',
			]
		);

		$this->end_controls_section();

		/* ─── LAYOUT SETTINGS ─── */
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__('Layout', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__('Columns', 'carvia-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
			]
		);

		$this->add_control(
			'column_gap',
			[
				'label'     => esc_html__('Column Gap', 'carvia-core'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => ['size' => 24, 'unit' => 'px'],
				'range'     => ['px' => ['min' => 0, 'max' => 80]],
				'selectors' => [
					'{{WRAPPER}} .carvia-step-flow-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ─── STYLE: CARD ─── */
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__('Card', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg_color',
			[
				'label'     => esc_html__('Background', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .carvia-step-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default'    => [
					'top'    => 20,
					'right'  => 20,
					'bottom' => 20,
					'left'   => 20,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .carvia-step-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'default'    => [
					'top'    => 32,
					'right'  => 28,
					'bottom' => 32,
					'left'   => 28,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .carvia-step-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .carvia-step-card',
				'fields_options' => [
					'box_shadow_type' => ['default' => 'yes'],
					'box_shadow'      => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 8,
							'blur'       => 32,
							'spread'     => 0,
							'color'      => 'rgba(0,0,0,0.08)',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		/* ─── STYLE: BADGE ─── */
		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => esc_html__('Badge', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'badge_margin',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-step-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .carvia-step-badge',
			]
		);

		$this->add_control(
			'badge_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default'    => [
					'top'    => 30,
					'right'  => 30,
					'bottom' => 30,
					'left'   => 30,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .carvia-step-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badge_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'default'    => [
					'top'    => 6,
					'right'  => 14,
					'bottom' => 6,
					'left'   => 14,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .carvia-step-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badge_margin_bottom',
			[
				'label'     => esc_html__('Bottom Spacing', 'carvia-core'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => ['size' => 20, 'unit' => 'px'],
				'range'     => ['px' => ['min' => 0, 'max' => 60]],
				'selectors' => [
					'{{WRAPPER}} .carvia-step-badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ─── STYLE: TITLE ─── */
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__('Title', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .carvia-step-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a3a1a',
				'selectors' => [
					'{{WRAPPER}} .carvia-step-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_margin_bottom',
			[
				'label'     => esc_html__('Bottom Spacing', 'carvia-core'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => ['size' => 12, 'unit' => 'px'],
				'range'     => ['px' => ['min' => 0, 'max' => 60]],
				'selectors' => [
					'{{WRAPPER}} .carvia-step-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__('HTML Tag', 'carvia-core'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h1' => 'H1',
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

		/* ─── STYLE: DESCRIPTION ─── */
		$this->start_controls_section(
			'section_desc_style',
			[
				'label' => esc_html__('Description', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .carvia-step-description',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#555555',
				'selectors' => [
					'{{WRAPPER}} .carvia-step-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$steps    = $settings['steps'];
		$columns  = (int) $settings['columns'];

		if (empty($steps)) return;

		echo '<div class="carvia-step-flow-grid" style="--carvia-cols:' . $columns . ';">';

		foreach ($steps as $step) {
			$badge_bg    = ! empty($step['badge_color'])      ? $step['badge_color']      : '#7DC242';
			$badge_color = ! empty($step['badge_text_color']) ? $step['badge_text_color'] : '#1a3a1a';
			$title_tag   = ! empty($settings['title_tag'])    ? $settings['title_tag']    : 'h3';

			echo '<div class="carvia-step-card elementor-repeater-item-' . esc_attr($step['_id']) . '">';

			// Badge
			if (! empty($step['step_label'])) {
				echo '<span class="carvia-step-badge" style="background-color:' . esc_attr($badge_bg) . ';color:' . esc_attr($badge_color) . ';">';
				echo esc_html($step['step_label']);
				echo '</span>';
			}

			// Title
			if (! empty($step['step_title'])) {
				echo '<' . esc_attr($title_tag) . ' class="carvia-step-title">' . esc_html($step['step_title']) . '</' . esc_attr($title_tag) . '>';
			}

			// Description
			if (! empty($step['step_description'])) {
				echo '<p class="carvia-step-description">' . esc_html($step['step_description']) . '</p>';
			}

			echo '</div>'; // .carvia-step-card
		}

		echo '</div>'; // .carvia-step-flow-grid
	}

	protected function content_template()
	{
?>
		<# if ( settings.steps.length ) { #>
			<div class="carvia-step-flow-grid" style="--carvia-cols:{{ settings.columns }};">
				<# _.each( settings.steps, function( step ) { #>
					<div class="carvia-step-card elementor-repeater-item-{{ step._id }}">
						<# if ( step.step_label ) { #>
							<span class="carvia-step-badge" style="background-color:{{ step.badge_color }};color:{{ step.badge_text_color }};">
								{{{ step.step_label }}}
							</span>
							<# } #>
								<# if ( step.step_title ) { #>
									<{{{ settings.title_tag }}} class="carvia-step-title">{{{ step.step_title }}}</{{{ settings.title_tag }}}>
									<# } #>
										<# if ( step.step_description ) { #>
											<p class="carvia-step-description">{{{ step.step_description }}}</p>
											<# } #>
					</div>
					<# }); #>
			</div>
			<# } #>
		<?php
	}
}
