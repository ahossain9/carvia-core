<?php

/**
 * Animation Effects extension class.
 */

namespace Carvia_Core\Modules;

use Elementor\Element_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Repeater;

defined('ABSPATH') || die();

class WCF_Animation_Effects
{

	public static function init()
	{

		//animation controls
		add_action('elementor/element/common/_section_style/after_section_end', [
			__CLASS__,
			'register_animation_controls',
		], 1);

		add_action('elementor/element/container/section_layout/after_section_end', [
			__CLASS__,
			'register_animation_controls'
		], 1);

		add_action('elementor/element/common/_section_style/after_section_end', [
			__CLASS__,
			'register_parallax',
		], 2);

		add_action('elementor/element/container/section_layout/after_section_end', [
			__CLASS__,
			'register_parallax'
		], 2);

		add_action('elementor/frontend/widget/before_render', [__CLASS__, 'wcf_attributes']);
		add_action('elementor/frontend/container/before_render', [__CLASS__, 'wcf_attributes']);

		add_action('elementor/preview/enqueue_scripts', [__CLASS__, 'enqueue_scripts']);

		add_action('elementor/frontend/before_render', [__CLASS__, 'remove_transition_from_container']);
	}

	public static function remove_transition_from_container($element)
	{

		if ('container' !== $element->get_name()) return;

		$settings = $element->get_settings_for_display();

		if (isset($settings['wcf-animation']) && $settings['wcf-animation'] !== 'none') {
			$element->add_render_attribute('_wrapper', 'class', 'aae-disable-transition');
		}
	}

	public static function enqueue_scripts() {}

	/**
	 * Set attributes based extension settings
	 *
	 * @param Element_Base $section
	 *
	 * @return void
	 */
	public static function wcf_attributes($element)
	{
		if (! empty($element->get_settings('wcf_enable_scroll_smoother'))) {
			$attributes = [];

			if (! empty($element->get_settings('data-speed'))) {
				$attributes['data-speed'] = $element->get_settings('data-speed');
			}
			if (! empty($element->get_settings('data-lag'))) {
				$attributes['data-lag'] = $element->get_settings('data-lag');
			}

			$element->add_render_attribute('_wrapper', $attributes);
		}
	}

	public static function register_parallax($element)
	{

		$element->start_controls_section(
			'_section_wcf_parallax',
			[
				'label' => sprintf('<i class="wcf-logo"></i> %s <span class="wcfpro_text">%s<span>', __('Parallax Effect', 'carvia-core'), __('Pro', 'carvia-core')),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);
		//smooth scroll animation
		$element->add_control(
			'wcf_enable_scroll_smoother',
			[
				'label'        => esc_html__('Enable Scroll Smoother', 'carvia-core'),
				'description'  => esc_html__('If you want to use scroll smooth, please enable global settings first', 'carvia-core'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'carvia-core'),
				'label_off'    => esc_html__('No', 'carvia-core'),
				'return_value' => 'yes',
				'render_type'        => 'none', // template
				'separator'    => 'before',
			]
		);

		$element->add_control(
			'data-speed',
			[
				'label'     => esc_html__('Speed', 'carvia-core'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0.9,
				'render_type'        => 'none', // template
				'condition' => ['wcf_enable_scroll_smoother' => 'yes'],
			]
		);

		$element->add_control(
			'data-lag',
			[
				'label'     => esc_html__('Lag', 'carvia-core'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 0,
				'render_type'        => 'none', // template
				'condition' => ['wcf_enable_scroll_smoother' => 'yes'],
			]
		);
		// enable if container background image is set	

		$element->end_controls_section();
	}
	public static function register_animation_controls($element)
	{
		$element->start_controls_section(
			'_section_wcf_animation',
			[
				'label' => sprintf('<i class="wcf-logo"></i> %s <span class="wcfpro_text">%s<span>', __('Animation', 'carvia-core'), __('Pro', 'carvia-core')),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'wcf-animation',
			[
				'label'              => esc_html__('Animation', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'separator'          => 'before',
				'options'            => [
					'none'   => esc_html__('None', 'carvia-core'),
					'fade'   => esc_html__('Fade animation', 'carvia-core'),
					'move'   => esc_html__('3D Move', 'carvia-core'),
					'custom' => esc_html__('Custom', 'carvia-core'),
				],
				'render_type'        => 'template', // template
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'aae_method',
			[
				'label'              => esc_html__('Method', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'from',
				'render_type'        => 'none', // template
				'options'            => [
					'from' => esc_html__('From', 'carvia-core'),
					'to'     => esc_html__('To', 'carvia-core'),
				],
				'condition'          => [
					'wcf-animation' => ['custom', 'fade', "move"],

				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'aae_trigger',
			[
				'label'              => esc_html__('Trigger', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'on_scroll',
				'render_type'        => 'none', // template
				'options'            => [
					'on_scroll'        => esc_html__('On Scroll', 'carvia-core'),
					'on_page_load'     => esc_html__('On Page Load', 'carvia-core'),
					'play_with_scroll' => esc_html__('Play With Scroll', 'carvia-core'),
					'mouseover'        => esc_html__('On Hover', 'carvia-core'),
					'click'            => esc_html__('On Click', 'carvia-core'),
				],
				'condition'          => [
					'wcf-animation' => ['custom', 'fade', 'move'],
				],
				'frontend_available' => true,
			]
		);
		// text control
		$element->add_control(
			'aae_trigger_selector',
			[
				'label'              => esc_html__('Trigger Selector', 'carvia-core'),
				'description'        => esc_html__('Selector for trigger element. Example: .my-class, #my-id', 'carvia-core'),
				'type'               => Controls_Manager::TEXT,
				'placeholder'        => ".my-class",
				'default'            => '',
				'render_type'        => 'none', // template
				'condition'          => [
					'wcf-animation' => ['custom', 'fade', 'move'],
					'aae_trigger' => ['mouseover', 'click'],
				],
				'frontend_available' => true,
			]
		);

		// on scroll

		$element->add_control(
			'aae_anim_wrapper',
			[
				'label'       => esc_html__('Wrapper', 'carvia-core'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => [
					''       => esc_html__('Default', 'carvia-core'),
					'custom' => esc_html__('Custom', 'carvia-core'),
				],
				'condition'   => [
					'aae_trigger' => ['on_scroll', 'play_with_scroll'],
					'wcf-animation' => ['custom', 'fade', 'move'],
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);




		$element->add_control(
			'aae_anim_s_t',
			[
				'label'              => esc_html__('Start Trigger', 'carvia-core'),
				'description'        => esc_html__('Add the section class where the element will be pin. please use the parent section or container class.', 'carvia-core'),
				'type'               => Controls_Manager::TEXT,
				'ai'                 => false,
				'placeholder'        => esc_html__('.start_area', 'carvia-core'),
				'frontend_available' => true,
				'render_type'        => 'none',
				'condition'          => [
					'aae_trigger' => ['on_scroll', 'play_with_scroll'],
					'wcf-animation' => ['custom', 'fade', 'move'],
					'aae_anim_wrapper' => 'custom'
				],
			]
		);

		$element->add_control(
			'aae_anim_e_t',
			[
				'label'              => esc_html__('End Trigger', 'carvia-core'),
				'description'        => esc_html__('Add the section class where the element will be pin. please use the parent section or container class.', 'carvia-core'),
				'type'               => Controls_Manager::TEXT,
				'ai'                 => false,
				'placeholder'        => esc_html__('.end_area', 'carvia-core'),
				'frontend_available' => true,
				'render_type'        => 'none',
				'condition'          => [
					'aae_trigger' => ['on_scroll', 'play_with_scroll'],
					'wcf-animation' => ['custom', 'fade', 'move'],
					'aae_anim_wrapper' => 'custom'
				],
			]
		);


		$element->add_control(
			'aae_anim_s',
			[
				'label'              => esc_html__('Start', 'carvia-core'),
				'description'        => esc_html__('First value is element position, Second value is display position', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'separator'          => 'before',
				'default'            => 'top top',
				'frontend_available' => true,
				'options'            => [
					'top top'       => esc_html__('Top Top', 'carvia-core'),
					'top center'    => esc_html__('Top Center', 'carvia-core'),
					'top bottom'    => esc_html__('Top Bottom', 'carvia-core'),
					'center top'    => esc_html__('Center Top', 'carvia-core'),
					'center center' => esc_html__('Center Center', 'carvia-core'),
					'center bottom' => esc_html__('Center Bottom', 'carvia-core'),
					'bottom top'    => esc_html__('Bottom Top', 'carvia-core'),
					'bottom center' => esc_html__('Bottom Center', 'carvia-core'),
					'bottom bottom' => esc_html__('Bottom Bottom', 'carvia-core'),
					'custom'        => esc_html__('custom', 'carvia-core'),
				],
				'render_type'        => 'none',
				'condition'          => [
					'aae_trigger' => ['on_scroll', 'play_with_scroll'],
					'wcf-animation' => ['custom', 'fade', 'move'],
					'aae_anim_wrapper' => 'custom'
				],

			]
		);



		$element->add_control(
			'aae_anim_s_cus',
			[
				'label'              => esc_html__('Custom', 'carvia-core'),
				'type'               => Controls_Manager::TEXT,
				'default'            => esc_html__('top top', 'carvia-core'),
				'placeholder'        => esc_html__('top top+=100', 'carvia-core'),
				'frontend_available' => true,
				'render_type'        => 'none',
				'condition'          => [
					'aae_trigger' => ['on_scroll', 'play_with_scroll'],
					'wcf-animation' => ['custom', 'fade', 'move'],
					'aae_anim_s'   => 'custom',
					'aae_anim_wrapper' => 'custom'
				],
			]
		);

		$element->add_control(
			'aae_anim_e',
			[
				'label'              => esc_html__('End', 'carvia-core'),
				'description'        => esc_html__('First value is element position, Second value is display position', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'separator'          => 'before',
				'default'            => 'bottom top',
				'frontend_available' => true,
				'render_type'        => 'none',
				'options'            => [
					'top top'       => esc_html__('Top Top', 'carvia-core'),
					'top center'    => esc_html__('Top Center', 'carvia-core'),
					'top bottom'    => esc_html__('Top Bottom', 'carvia-core'),
					'center top'    => esc_html__('Center Top', 'carvia-core'),
					'center center' => esc_html__('Center Center', 'carvia-core'),
					'center bottom' => esc_html__('Center Bottom', 'carvia-core'),
					'bottom top'    => esc_html__('Bottom Top', 'carvia-core'),
					'bottom center' => esc_html__('Bottom Center', 'carvia-core'),
					'bottom bottom' => esc_html__('Bottom Bottom', 'carvia-core'),
					'custom'        => esc_html__('custom', 'carvia-core'),
				],
				'condition'          => [
					'aae_trigger' => ['on_scroll', 'play_with_scroll'],
					'wcf-animation' => ['custom', 'fade', 'move'],
					'aae_anim_wrapper' => 'custom'
				],
			]
		);

		$element->add_control(
			'aae_anim_e_cus',
			[
				'label'              => esc_html__('Custom', 'carvia-core'),
				'type'               => Controls_Manager::TEXT,
				'frontend_available' => true,
				'render_type'        => 'none',
				'default'            => esc_html__('bottom top', 'carvia-core'),
				'placeholder'        => esc_html__('bottom top+=100', 'carvia-core'),
				'condition'          => [
					'aae_trigger' => ['on_scroll', 'play_with_scroll'],
					'wcf-animation' => ['custom', 'fade', 'move'],
					'aae_anim_e'     => 'custom',
					'aae_anim_wrapper' => 'custom'
				],
			]
		);

		$element->add_control(
			'aae_anim_markers',
			[
				'label'     => esc_html__('Markers', 'carvia-core'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'false',
				'options'   => [
					'true'   => esc_html__('True', 'carvia-core'),
					'false'  => esc_html__('False', 'carvia-core'),
				],
				'frontend_available' => true,
				'render_type' => 'none',
				'condition'          => [
					'aae_trigger' => ['on_scroll', 'play_with_scroll'],
					'wcf-animation' => ['custom', 'fade', 'move'],
					'aae_anim_wrapper' => 'custom'
				],
			]
		);

		// end on scroll


		$element->add_control(
			'delay',
			[
				'label'              => esc_html__('Delay', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 10,
				'step'               => 0.1,
				'default'            => .15,
				'render_type'        => 'none', // template
				'condition'          => [
					'wcf-animation!' => ['custom', 'none'],
				],
				'frontend_available' => true,
			]
		);

		// $element->add_control(
		// 	'on-scroll',
		// 	[
		// 		'label'              => esc_html__('Animation on scroll', 'carvia-core'),
		// 		'type'               => Controls_Manager::SWITCHER,
		// 		'label_on'           => esc_html__('Yes', 'carvia-core'),
		// 		'label_off'          => esc_html__('No', 'carvia-core'),
		// 		'return_value'       => 1,
		// 		'default'            => 1,
		// 		'render_type'        => 'none', // template
		// 		'frontend_available' => true,
		// 		'condition'          => [				
		// 			'wcf-animation' => ['custom', 'fade', 'move'],
		// 		],
		// 		'description' => esc_html__('This settings will be remove in future , Use new Trigger settings','carvia-core')
		// 	]
		// );

		$element->add_control(
			'fade-from',
			[
				'label'              => esc_html__('Fade from', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'bottom',
				'render_type'        => 'none', // template
				'options'            => [
					'top'    => esc_html__('Top', 'carvia-core'),
					'bottom' => esc_html__('Bottom', 'carvia-core'),
					'left'   => esc_html__('Left', 'carvia-core'),
					'right'  => esc_html__('Right', 'carvia-core'),
					'in'     => esc_html__('In', 'carvia-core'),
					'scale'  => esc_html__('Zoom', 'carvia-core'),
				],
				'frontend_available' => true,
				'condition'          => [
					'wcf-animation' => 'fade',
				],
			]
		);

		$element->add_control(
			'data-duration',
			[
				'label'              => esc_html__('Duration', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 1.5,
				'render_type'        => 'none', // template
				'condition'          => [
					'wcf-animation!' => ['custom', 'none']

				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'ease',
			[
				'label'              => esc_html__('Ease', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'power2.out',
				'render_type'        => 'none', // template
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
				'condition'          => [
					'wcf-animation!' => 'none',
				],
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'fade-offset',
			[
				'label'              => esc_html__('Fade offset', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 50,
				'render_type'        => 'none', // template
				'condition'          => [
					'fade-from!' => ['in', 'scale'],
					'wcf-animation' => 'fade',
				],
				'frontend_available' => true,
			]
		);

		//scale
		$element->add_control(
			'wcf-a-scale',
			[
				'label'              => esc_html__('Start Scale', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 0.7,
				'condition'          => [
					'fade-from' => 'scale',
					'wcf-animation' => 'fade',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		//move
		$element->add_control(
			'wcf_a_rotation_di',
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
					'wcf-animation' => 'move',
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'wcf_a_rotation',
			[
				'label'              => esc_html__('Rotation Value', 'carvia-core'),
				'type'               => Controls_Manager::NUMBER,
				'default'            => '-80',
				'condition'          => [
					'wcf-animation' => 'move',
				],
				'frontend_available' => true,
				'render_type'        => 'none',
			]
		);

		$element->add_control(
			'wcf_a_transform_origin',
			[
				'label'              => esc_html__('TransformOrigin', 'carvia-core'),
				'type'               => Controls_Manager::TEXT,
				'frontend_available' => true,
				'default'            => esc_html__('top center -50', 'carvia-core'),
				'placeholder'        => esc_html__('top center', 'carvia-core'),
				'condition'          => [
					'wcf-animation' => 'move',
				],
				'render_type'        => 'none',
			]
		);

		// custom 
		$repeater = new Repeater();

		$repeater->add_control(
			'property',
			[
				'label'   => __('Property', 'carvia-core'),
				'type'    => Controls_Manager::SELECT2,
				'multiple' => false,
				'options' => [
					'none'   => __('None', 'carvia-core'),
					'opacity'   => __('Opacity', 'carvia-core'),
					'x'  => __('X', 'carvia-core'),
					'y'  => __('Y', 'carvia-core'),
					'width'   => __('Width', 'carvia-core'),
					'height' => __('Height', 'carvia-core'),
					'scale' => __('Scale', 'carvia-core'),
					'repeat' => __('Repeat', 'carvia-core'),
					'rotate' => __('Rotate', 'carvia-core'),
					'rotateX' => __('RotateX', 'carvia-core'),
					'rotateY' => __('RotateY', 'carvia-core'),
					'transformOrigin' => __('TransformOrigin', 'carvia-core'),
					'color' => __('Color', 'carvia-core'),
					'background' => __('Background', 'carvia-core'),
					'border' => __('Border', 'carvia-core'),
					'boxShadow' => __('BoxShadow', 'carvia-core'),
					'force3D' => __('Force3D', 'carvia-core'),
					'delay' => __('Delay', 'carvia-core'),
					'duration' => __('Duration', 'carvia-core'),
					'maxWidth' => __('Max Width', 'carvia-core'),
					'maxHeight' => __('Max Height', 'carvia-core'),
					'minWidth' => __('Min Width', 'carvia-core'),
					'minHeight' => __('Min Height', 'carvia-core'),
					'mixBlendMode' => __('Mix Blend Mode', 'carvia-core'),
					'padding' => __('Padding', 'carvia-core'),
					'borderRadius' => __('Border Radius', 'carvia-core'),
					'repeatDelay' => __('Repeat Delay', 'carvia-core'),
					'scaleX' => __('ScaleX', 'carvia-core'),
					'scaleY' => __('ScaleY', 'carvia-core'),
					'xPercent' => __('XPercent', 'carvia-core'),
					'yPercent' => __('YPercent', 'carvia-core'),
					'autoAlpha' => __('Auto Alpha', 'carvia-core'),
					'yoyo' => __('YoYo', 'carvia-core'),
				],
				'default' => 'Porperty',
				'render_type'        => 'ui',
				'frontend_available' => true,
			]
		);

		$repeater->add_control(
			'value',
			[
				'label'   => __('Value', 'carvia-core'),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'render_type'        => 'ui',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'aae_ani_custom_props',
			[
				'label'        => __('Custom Properties', 'carvia-core'),
				'type'         => Controls_Manager::REPEATER,
				'fields'       => $repeater->get_controls(),
				'condition' => ['wcf-animation' => 'custom'],
				'label_block' => true,
				'title_field'  => '{{{ property }}}',
				'separator'    => 'before',
				'render_type'        => 'ui',
				'frontend_available' => true,
			]
		);

		$dropdown_options = [
			'' => esc_html__('All', 'carvia-core'),
		];

		foreach (Plugin::$instance->breakpoints->get_active_breakpoints() as $breakpoint_key => $breakpoint_instance) {

			$dropdown_options[$breakpoint_key] = sprintf(
				/* translators: 1: Breakpoint label, 2: `>` character, 3: Breakpoint value. */
				esc_html__('%1$s (%2$dpx)', 'carvia-core'),
				$breakpoint_instance->get_label(),
				$breakpoint_instance->get_value()
			);
		}

		$element->add_control(
			'fade_animation_breakpoint',
			[
				'label'              => esc_html__('Breakpoint', 'carvia-core'),
				'type'               => Controls_Manager::SELECT,
				'description'        => esc_html__('Note: Choose at which breakpoint animation will work.', 'carvia-core'),
				'options'            => $dropdown_options,
				'frontend_available' => true,
				'render_type'        => 'none', // template
				'default'            => '',
				'condition'          => [
					'wcf-animation!' => 'none',
				],
			]
		);

		$element->add_control(
			'fade_breakpoint_min_max',
			[
				'label'     => esc_html__('Breakpoint Min/Max', 'carvia-core'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'min',
				'render_type'        => 'none', // template
				'options'   => [
					'min' => esc_html__('Min(>)', 'carvia-core'),
					'max' => esc_html__('Max(<)', 'carvia-core'),
				],
				'frontend_available' => true,
				'condition' => [
					'wcf-animation!'        => 'none',
					'fade_animation_breakpoint!' => '',
				],
			]
		);


		$element->add_control(
			'wcf_enable_animation_editor',
			[
				'label'              => esc_html__('Enable On Editor', 'carvia-core'),
				'description'        => esc_html__('For better performance in editor mode, keep the setting turned off.', 'carvia-core'),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'return_value'       => 'yes',
				'condition'          => [
					'wcf-animation!' => 'none',
				],
			]
		);

		$element->add_control(
			'play_animation_content',
			[
				'label' => esc_html__('Play Animation', 'carvia-core'),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'button_type' => 'success',
				'text' => esc_html__('Play', 'carvia-core'),
				'event' => 'wcf:editor:play_animation',
				'condition'          => [
					'wcf-animation!' => 'none',
					'wcf_enable_animation_editor' => 'yes'
				],
			]
		);

		$element->end_controls_section();
	}
}

WCF_Animation_Effects::init();
