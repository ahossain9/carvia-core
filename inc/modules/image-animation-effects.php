<?php

/**
 * Animation Effects extension class.
 */

namespace Carvia_Core\Modules;

use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

defined('ABSPATH') || die();

class Carvia_Core_Image_Animation_Effects
{

	public static function init()
	{

		$image_elements = [
			[
				'name'    => 'image',
				'section' => 'section_image',
			]
		];
		foreach ($image_elements as $element) {
			add_action('elementor/element/' . $element['name'] . '/' . $element['section'] . '/after_section_end', [
				__CLASS__,
				'register_image_animation_controls',
			], 10, 2);
		}
	}

	public static function register_image_animation_controls($element)
	{
		$element->start_controls_section(
			'_section_image_animation',
			[
				'label' => sprintf('<i class="carvia-core-logo"></i> %s <span class="wkpro_text">%s<span>', __('Image Animation', 'carvia-core'), __('', 'carvia-core')),
			]
		);

		$element->add_control(
			'image_animation',
			[
				'label'              => esc_html__('Animation', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'separator'          => 'before',
				'options'            => [
					'none'    => esc_html__('None', 'carvia-core'),
					'reveal'  => esc_html__('Reveal', 'carvia-core'),
					'scale'   => esc_html__('Scale', 'carvia-core'),
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'image_animation_builder_preview',
			[
				'label'              => esc_html__('Preview On Builder', 'carvia-core'),
				'description'        => esc_html__('For better performance in builder mode, keep the setting turned off.', 'carvia-core'),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
				'condition'          => [
					'image_animation!' => 'none',
				],
			]
		);

		$element->add_control(
			'image_direction',
			[
				'label'              => esc_html__('Animation To', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'right',
				'frontend_available' => true,
				'render_type'        => 'none',
				'options'            => [
					'left'   => esc_html__('Left', 'carvia-core'),
					'right'  => esc_html__('Right', 'carvia-core'),
					'top'    => esc_html__('Top', 'carvia-core'),
					'bottom' => esc_html__('Bottom', 'carvia-core'),
				],
				'condition'          => ['image_animation' => 'reveal'],
			]
		);

		$element->add_control(
			'image_scale_start',
			[
				'label'              => esc_html__('Start Scale', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 0.7,
				'condition'          => ['image_animation' => 'scale'],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'image_scale_end',
			[
				'label'              => esc_html__('End Scale', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 1,
				'condition'          => ['image_animation' => 'scale'],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'image_ease',
			[
				'label'              => esc_html__('Data ease', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'power2.out',
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
				'condition'          => ['image_animation' => 'reveal'],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->end_controls_section();
	}
}

Carvia_Core_Image_Animation_Effects::init();
