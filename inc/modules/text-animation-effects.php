<?php

namespace Carvia_Core\Modules;

use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

defined('ABSPATH') || die();

class Carvia_Core_Text_Animation_Effects
{
	private static function get_text_elements()
	{
		return [
			['name' => 'heading', 'section' => 'section_title'],
			['name' => 'text-editor', 'section' => 'section_editor']
		];
	}

	public static function init()
	{

		foreach (self::get_text_elements() as $element) {
			add_action('elementor/element/' . $element['name'] . '/' . $element['section'] . '/after_section_end', [
				__CLASS__,
				'register_text_animation_controls',
			], 10, 2);
		}
		// fix optimize markup issue
		add_filter('elementor/widget/render_content', [
			__CLASS__,
			'render_content'
		], 10, 2);
	}

	public static function render_content($content, $element)
	{

		if ($element->get_type() === 'widget' && in_array($element->get_name(), array_column(self::get_text_elements(), 'name'))) {
			if (Plugin::$instance->experiments->is_feature_active('e_optimized_markup')) {
				$content = '<div class="elementor-widget-container">' . $content . '</div>';
			}
		}

		return $content;
	}

	public static function register_text_animation_controls($element)
	{
		$element->start_controls_section(
			'_section_text_animation',
			[
				'label' => sprintf('<i class="carvia-core-logo"></i> %s <span class="wkpro_text">%s<span>', __('Text Animation', 'carvia-core'), __('', 'carvia-core')),
			]
		);

		$animation = [
			'none'        => esc_html__('None', 'carvia-core'),
			'char'        => esc_html__('Character', 'carvia-core'),
			'word'        => esc_html__('Word', 'carvia-core'),
			'text_move'   => esc_html__('Text Move', 'carvia-core'),
			'text_scale'  => esc_html__('Text Scale', 'carvia-core'),
		];

		$element->add_control(
			'text_animation_type',
			[
				'label'              => esc_html__('Animation', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'separator'          => 'before',
				'options'            => $animation,
				'render_type'        => 'template', // template
				'prefix_class'       => 'carvia-core-animation-',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'text_animation_builder_preview',
			[
				'label'              => esc_html__('Preview On Builder', 'carvia-core'),
				'description'        => esc_html__('For better performance in builder mode, keep the setting turned off.', 'carvia-core'),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
				'condition'          => [
					'text_animation_type!' => 'none',
				],
			]
		);

		$element->add_control(
			'text_delay',
			[
				'label'              => esc_html__('Delay', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 10,
				'step'               => 0.1,
				'default'            => 0.15,
				'condition'          => [
					'text_animation_type' => ['char', 'word', 'text_move', 'text_scale'],
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'text_duration',
			[
				'label'              => esc_html__('Duration', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 10,
				'step'               => 0.1,
				'default'            => 1,
				'condition'          => [
					'text_animation_type' => ['char', 'word', 'text_move', 'text_scale'],
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'text_stagger',
			[
				'label'              => esc_html__('Stagger', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 10,
				'step'               => 0.01,
				'default'            => 0.02,
				'condition'          => [
					'text_animation_type' => ['char', 'word', 'text_move', 'text_scale'],
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'text_on_scroll',
			[
				'label'              => esc_html__('Animation on scroll', 'carvia-core'),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__('Yes', 'carvia-core'),
				'label_off'          => esc_html__('No', 'carvia-core'),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'condition'          => [
					'text_animation_type' => ['char', 'word', 'text_move', 'text_scale'],
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'text_translate_x',
			[
				'label'              => esc_html__('Transform-X', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 20,
				'condition'          => [
					'text_animation_type' => ['char', 'word'],
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'text_translate_y',
			[
				'label'              => esc_html__('Transform-Y', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 0,
				'condition'          => [
					'text_animation_type' => ['char', 'word'],
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'text_rotation_direction',
			[
				'label'              => esc_html__('Rotation Direction', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'x',
				'separator'          => 'before',
				'options'            => [
					'x' => esc_html__('X', 'carvia-core'),
					'y' => esc_html__('Y', 'carvia-core'),
				],
				'condition'          => [
					'text_animation_type' => ['text_move'],
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'text_rotation_value',
			[
				'label'              => esc_html__('Rotation Value', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => '-80',
				'condition'          => [
					'text_animation_type' => ['text_move'],
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'scale_text_ease',
			[
				'label'              => esc_html__('Ease', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'back',
				'options'            => [
					'power2.out' => esc_html__('Power2.out', 'carvia-core'),
					'bounce'     => esc_html__('Bounce', 'carvia-core'),
					'back'       => esc_html__('Back', 'carvia-core'),
					'elastic'    => esc_html__('Elastic', 'carvia-core'),
					'slowmo'     => esc_html__('Slowmo', 'carvia-core'),
					'stepped'    => esc_html__('Stepped', 'carvia-core'),
					'sine'       => esc_html__('Sine', 'carvia-core'),
					'expo'       => esc_html__('Expo', 'carvia-core'),
				],
				'condition'          => ['text_animation_type' => 'text_scale'],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'text_scale_value',
			[
				'label'     => esc_html__('Scale', 'carvia-core'),
				'type'      => Controls_Manager::NUMBER,
				'frontend_available' => true,
				'render_type'        => 'none',
				'min'       => 0,
				'max'       => 10,
				'default'   => 1.5,
				'condition' => [
					'text_animation_type' => 'text_scale',
				],
			]
		);

		$element->end_controls_section();
	}
}

Carvia_Core_Text_Animation_Effects::init();
