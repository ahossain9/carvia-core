<?php

/**
 * Carvia Core - Timeline Widget
 *
 * @package Carvia_Core
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Class Timeline
 */
class Timeline extends Widget_Base
{

	/**
	 * Widget name.
	 */
	public function get_name()
	{
		return 'timeline';
	}

	/**
	 * Widget title.
	 */
	public function get_title()
	{
		return esc_html__('Timeline', 'carvia-core');
	}

	/**
	 * Widget icon.
	 */
	public function get_icon()
	{
		return 'carvia-core-icon eicon-time-line';
	}

	/**
	 * Widget categories.
	 */
	public function get_categories()
	{
		return array('carvia_core');
	}

	/**
	 * Widget keywords.
	 */
	public function get_keywords()
	{
		return array('timeline', 'history', 'process', 'steps', 'carvia');
	}

	/**
	 * Script dependencies (none needed, pure CSS).
	 */
	public function get_script_depends()
	{
		return array();
	}

	/**
	 * Style dependencies.
	 */
	public function get_style_depends()
	{
		return array('carvia-core-timeline');
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls()
	{

		/* ==========================================================
		 * CONTENT TAB — LAYOUT
		 * ======================================================== */
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__('Layout', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__('Layout', 'carvia-core'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'vertical'   => array(
						'title' => esc_html__('Vertical', 'carvia-core'),
						'icon'  => 'eicon-navigation-vertical',
					),
					'horizontal' => array(
						'title' => esc_html__('Horizontal', 'carvia-core'),
						'icon'  => 'eicon-navigation-horizontal',
					),
				),
				'default' => 'vertical',
				'toggle'  => false,
			)
		);

		$this->add_responsive_control(
			'horizontal_columns',
			array(
				'label'     => esc_html__('Items Per Row', 'carvia-core'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4',
				'options'   => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'condition' => array(
					'layout' => 'horizontal',
				),
				'selectors' => array(
					'{{WRAPPER}} .timeline--horizontal' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				),
			)
		);

		$this->add_control(
			'connector_type',
			array(
				'label'     => esc_html__('Connector Type', 'carvia-core'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'circle' => array(
						'title' => esc_html__('Border + Circle', 'carvia-core'),
						'icon'  => 'eicon-dot-circle-o',
					),
					'arrow'  => array(
						'title' => esc_html__('Arrow', 'carvia-core'),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'default'   => 'circle',
				'toggle'    => false,
				'condition' => array(
					'layout' => 'horizontal',
				),
				'description' => esc_html__('The vertical layout always uses the border + circle connector.', 'carvia-core'),
			)
		);

		$this->add_control(
			'connector_line_style',
			array(
				'label'     => esc_html__('Connector Line Style', 'carvia-core'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'solid'  => esc_html__('Solid', 'carvia-core'),
					'dashed' => esc_html__('Dashed', 'carvia-core'),
					'dotted' => esc_html__('Dotted', 'carvia-core'),
				),
				'selectors' => array(
					'{{WRAPPER}} .timeline' => '--carvia-connector-style: {{VALUE}};',
				),
				'condition' => array(
					'connector_type!' => 'arrow',
				),
			)
		);

		$this->end_controls_section();

		/* ==========================================================
		 * CONTENT TAB — TIMELINE ITEMS (REPEATER)
		 * ======================================================== */
		$this->start_controls_section(
			'section_items',
			array(
				'label' => esc_html__('Timeline Items', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__('Icon', 'carvia-core'),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-flag',
					'library' => 'fa-solid',
				),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__('Title', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Timeline Title', 'carvia-core'),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'date',
			array(
				'label'       => esc_html__('Date / Label', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__('e.g. 2024', 'carvia-core'),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'       => esc_html__('Description', 'carvia-core'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Write a short description of this timeline step.', 'carvia-core'),
				'label_block' => true,
				'rows'        => 4,
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__('Link', 'carvia-core'),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'carvia-core'),
				'default'     => array(
					'url' => '',
				),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__('Items', 'carvia-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title'       => esc_html__('Research & Planning', 'carvia-core'),
						'date'        => esc_html__('Step 01', 'carvia-core'),
						'description' => esc_html__('We start by understanding your goals and researching the best approach.', 'carvia-core'),
						'icon'        => array(
							'value'   => 'fas fa-search',
							'library' => 'fa-solid',
						),
					),
					array(
						'title'       => esc_html__('Design & Prototype', 'carvia-core'),
						'date'        => esc_html__('Step 02', 'carvia-core'),
						'description' => esc_html__('We craft wireframes and prototypes to visualize the final outcome.', 'carvia-core'),
						'icon'        => array(
							'value'   => 'fas fa-pencil-ruler',
							'library' => 'fa-solid',
						),
					),
					array(
						'title'       => esc_html__('Development', 'carvia-core'),
						'date'        => esc_html__('Step 03', 'carvia-core'),
						'description' => esc_html__('Our team builds and tests every feature with quality in mind.', 'carvia-core'),
						'icon'        => array(
							'value'   => 'fas fa-code',
							'library' => 'fa-solid',
						),
					),
					array(
						'title'       => esc_html__('Launch', 'carvia-core'),
						'date'        => esc_html__('Step 04', 'carvia-core'),
						'description' => esc_html__('We deploy the final product and monitor its performance closely.', 'carvia-core'),
						'icon'        => array(
							'value'   => 'fas fa-rocket',
							'library' => 'fa-solid',
						),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();

		/* ==========================================================
		 * STYLE TAB — BOX
		 * ======================================================== */
		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => esc_html__('Box', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'box_gap',
			array(
				'label'      => esc_html__('Items Gap', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em'),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .timeline--vertical'   => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .timeline--horizontal' => 'row-gap: {{SIZE}}{{UNIT}}; column-gap: 0;',
				),
			)
		);

		$this->add_responsive_control(
			'box_spacing_horizontal',
			array(
				'label'       => esc_html__('Box Spacing (Horizontal)', 'carvia-core'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array('px', 'em'),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 80,
					),
				),
				'default'     => array(
					'unit' => 'px',
					'size' => 15,
				),
				'description' => esc_html__('Space between item boxes. The connector border always runs the full width of the items, unaffected by this spacing.', 'carvia-core'),
				'condition'   => array(
					'layout' => 'horizontal',
				),
				'selectors'   => array(
					'{{WRAPPER}} .timeline--horizontal .timeline__box' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'box_background',
				'types'    => array('classic', 'gradient'),
				'selector' => '{{WRAPPER}} .timeline__box',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'box_border',
				'selector' => '{{WRAPPER}} .timeline__box',
			)
		);

		$this->add_responsive_control(
			'box_radius',
			array(
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .timeline__box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'box_padding',
			array(
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'default'    => array(
					'top'      => 25,
					'right'    => 25,
					'bottom'   => 25,
					'left'     => 25,
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .timeline__box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .timeline__box',
			)
		);

		$this->end_controls_section();

		/* ==========================================================
		 * STYLE TAB — ICON
		 * ======================================================== */
		$this->start_controls_section(
			'section_style_icon',
			array(
				'label' => esc_html__('Icon', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__('Icon Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 80,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 26,
				),
				'selectors'  => array(
					'{{WRAPPER}} .timeline__icon-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .timeline__icon-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_box_size',
			array(
				'label'      => esc_html__('Icon Box Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array(
					'px' => array(
						'min' => 30,
						'max' => 160,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 64,
				),
				'selectors'  => array(
					'{{WRAPPER}} .timeline__icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs('icon_colors_tabs');

		$this->start_controls_tab(
			'icon_colors_normal',
			array(
				'label' => esc_html__('Normal', 'carvia-core'),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__('Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .timeline__icon-box i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .timeline__icon-box svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'icon_background',
				'types'    => array('classic', 'gradient'),
				'selector' => '{{WRAPPER}} .timeline__icon-box',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			array(
				'label' => esc_html__('Hover', 'carvia-core'),
			)
		);

		$this->add_control(
			'icon_color_hover',
			array(
				'label'     => esc_html__('Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .timeline__item:hover .timeline__icon-box i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .timeline__item:hover .timeline__icon-box svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'icon_background_hover',
				'types'    => array('classic', 'gradient'),
				'selector' => '{{WRAPPER}} .timeline__item:hover .timeline__icon-box',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'icon_border',
				'selector' => '{{WRAPPER}} .timeline__icon-box',
			)
		);

		$this->add_control(
			'icon_border_radius',
			array(
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'default'    => array(
					'top'      => 50,
					'right'    => 50,
					'bottom'   => 50,
					'left'     => 50,
					'unit'     => '%',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .timeline__icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/* ==========================================================
		 * STYLE TAB — CONNECTOR (BORDER, CIRCLE NODE & ARROW)
		 * ======================================================== */
		$this->start_controls_section(
			'section_style_connector',
			array(
				'label' => esc_html__('Connector', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'connector_color',
			array(
				'label'     => esc_html__('Border Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#dcdfe6',
				'selectors' => array(
					'{{WRAPPER}} .timeline' => '--carvia-connector-color: {{VALUE}};',
				),
				'condition' => array(
					'connector_type!' => 'arrow',
				),
			)
		);

		$this->add_control(
			'connector_width',
			array(
				'label'      => esc_html__('Border Thickness', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .timeline' => '--carvia-connector-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'connector_type!' => 'arrow',
				),
			)
		);

		$this->add_control(
			'node_heading',
			array(
				'label'     => esc_html__('Circle Node', 'carvia-core'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'connector_type!' => 'arrow',
				),
			)
		);

		$this->add_control(
			'node_size',
			array(
				'label'      => esc_html__('Circle Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array(
					'px' => array(
						'min' => 6,
						'max' => 40,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} .timeline' => '--carvia-node-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'connector_type!' => 'arrow',
				),
			)
		);

		$this->add_control(
			'node_color',
			array(
				'label'     => esc_html__('Circle Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6b46f5',
				'selectors' => array(
					'{{WRAPPER}} .timeline' => '--carvia-node-color: {{VALUE}};',
				),
				'condition' => array(
					'connector_type!' => 'arrow',
				),
			)
		);

		$this->add_control(
			'node_border_color',
			array(
				'label'     => esc_html__('Circle Ring Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .timeline' => '--carvia-node-border-color: {{VALUE}};',
				),
				'condition' => array(
					'connector_type!' => 'arrow',
				),
			)
		);

		$this->add_control(
			'arrow_heading',
			array(
				'label'     => esc_html__('Arrow', 'carvia-core'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'connector_type' => 'arrow',
				),
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => esc_html__('Arrow Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6b46f5',
				'selectors' => array(
					'{{WRAPPER}} .timeline' => '--carvia-arrow-color: {{VALUE}};',
				),
				'condition' => array(
					'connector_type' => 'arrow',
				),
			)
		);

		$this->add_control(
			'arrow_size',
			array(
				'label'      => esc_html__('Arrow Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 60,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .timeline' => '--carvia-arrow-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'connector_type' => 'arrow',
				),
			)
		);

		$this->end_controls_section();

		/* ==========================================================
		 * STYLE TAB — TITLE
		 * ======================================================== */
		$this->start_controls_section(
			'section_style_title',
			array(
				'label' => esc_html__('Title', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a1a1a',
				'selectors' => array(
					'{{WRAPPER}} .timeline__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .timeline__title',
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'     => esc_html__('Spacing Bottom', 'carvia-core'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors' => array(
					'{{WRAPPER}} .timeline__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/* ==========================================================
		 * STYLE TAB — DATE / LABEL
		 * ======================================================== */
		$this->start_controls_section(
			'section_style_date',
			array(
				'label' => esc_html__('Date / Label', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'date_color',
			array(
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6b46f5',
				'selectors' => array(
					'{{WRAPPER}} .timeline__date' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'date_typography',
				'selector' => '{{WRAPPER}} .timeline__date',
			)
		);

		$this->end_controls_section();

		/* ==========================================================
		 * STYLE TAB — DESCRIPTION
		 * ======================================================== */
		$this->start_controls_section(
			'section_style_description',
			array(
				'label' => esc_html__('Description', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => array(
					'{{WRAPPER}} .timeline__description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .timeline__description',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Helper: render a single timeline item.
	 *
	 * @param array  $item           Repeater item data.
	 * @param int    $index          Item index (0-based).
	 * @param string $layout         'vertical' or 'horizontal'.
	 * @param string $connector_type 'circle' or 'arrow'.
	 */
	protected function render_item($item, $index, $layout, $connector_type)
	{
		$has_link   = ! empty($item['link']['url']);
		$tag        = $has_link ? 'a' : 'div';
		$item_class = array('timeline__item');

		if ('vertical' === $layout) {
			$item_class[] = (0 === $index % 2) ? 'timeline__item--left' : 'timeline__item--right';
		}

		if ($has_link) {
			$this->add_link_attributes('item_link_' . $index, $item['link']);
		}
?>
		<div class="<?php echo esc_attr(implode(' ', $item_class)); ?>">
			<?php if ('circle' === $connector_type) : ?>
				<span class="timeline__node" aria-hidden="true"></span>
			<?php endif; ?>
			<<?php echo esc_attr($tag); ?> class="timeline__box" <?php echo $has_link ? $this->get_render_attribute_string('item_link_' . $index) : ''; ?>>
				<div class="timeline__icon-box">
					<?php \Elementor\Icons_Manager::render_icon($item['icon'], array('aria-hidden' => 'true')); ?>
				</div>
				<div class="timeline__content">
					<i class="icon-search-01"></i>
					<?php if (! empty($item['date'])) : ?>
						<div class="timeline__date"><?php echo esc_html($item['date']); ?></div>
					<?php endif; ?>
					<?php if (! empty($item['title'])) : ?>
						<h3 class="timeline__title"><?php echo esc_html($item['title']); ?></h3>
					<?php endif; ?>
					<?php if (! empty($item['description'])) : ?>
						<div class="timeline__description"><?php echo wp_kses_post($item['description']); ?></div>
					<?php endif; ?>
				</div>
			</<?php echo esc_attr($tag); ?>>
		</div>
	<?php
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if (empty($settings['items'])) {
			return;
		}

		$layout = ! empty($settings['layout']) ? $settings['layout'] : 'vertical';

		// Vertical layout always uses the border + circle connector; arrow only applies to horizontal.
		$connector_type = 'vertical' === $layout ? 'circle' : (! empty($settings['connector_type']) ? $settings['connector_type'] : 'circle');

		$wrapper_class = array(
			'timeline',
			'timeline--' . $layout,
			'timeline--connector-' . $connector_type,
		);

		$this->add_render_attribute('wrapper', 'class', $wrapper_class);
	?>
		<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
			<?php foreach ($settings['items'] as $index => $item) : ?>
				<?php $this->render_item($item, $index, $layout, $connector_type); ?>
			<?php endforeach; ?>
		</div>
<?php
	}
}
