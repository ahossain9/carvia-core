<?php

/**
 * carvia core helper functions
 * @package Carvia_Core
 * @since 1.0.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

function carvia_core_do_shortcode($tag, array $atts = array(), $content = null)
{
	global $shortcode_tags;
	if (! isset($shortcode_tags[$tag])) {
		return false;
	}
	return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
}

/**
 * Escaped title html tags
 *
 * @param string $tag input string of title tag
 * @return string $default default tag will be return during no matches
 */

function carvia_escape_tags($tag, $default = 'span', $extra = [])
{

	$supports = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p'];

	$supports = array_merge($supports, $extra);

	if (! in_array($tag, $supports, true)) {
		return $default;
	}

	return $tag;
}

/**
 * Get a list of all the allowed html tags.
 *
 * @param string $level Allowed levels are basic and intermediate
 * @return array
 */
function carvia_get_allowed_html_tags($level = 'basic')
{
	$allowed_html = [
		'b'      => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'i'      => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'u'      => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		's'      => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'br'     => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'em'     => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'del'    => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'ins'    => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'sub'    => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'sup'    => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'code'   => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'mark'   => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'small'  => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'strike' => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'abbr'   => [
			'title' => [],
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'span'   => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
		'strong' => [
			'class' => [],
			'id'    => [],
			'style' => [],
		],
	];

	if ('intermediate' === $level) {
		$tags = [
			'a'       => [
				'href'  => [],
				'title' => [],
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'q'       => [
				'cite'  => [],
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'img'     => [
				'src'    => [],
				'alt'    => [],
				'height' => [],
				'width'  => [],
				'class'  => [],
				'id'     => [],
				'style'  => [],
			],
			'dfn'     => [
				'title' => [],
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'time'    => [
				'datetime' => [],
				'class'    => [],
				'id'       => [],
				'style'    => [],
			],
			'cite'    => [
				'title' => [],
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'acronym' => [
				'title' => [],
				'class' => [],
				'id'    => [],
				'style' => [],
			],
			'hr'      => [
				'class' => [],
				'id'    => [],
				'style' => [],
			],
		];

		$allowed_html = array_merge($allowed_html, $tags);
	}

	return $allowed_html;
}

/**
 * Strip all the tags except allowed html tags
 *
 * The name is based on inline editing toolbar name
 *
 * @param string $string
 * @return string
 */
function carvia_kses_intermediate($string = '')
{
	return wp_kses($string, carvia_get_allowed_html_tags('intermediate'));
}

/**
 * Strip all the tags except allowed html tags
 *
 * The name is based on inline editing toolbar name
 *
 * @param string $string
 * @return string
 */
function carvia_kses_basic($string = '')
{
	return wp_kses($string, carvia_get_allowed_html_tags('basic'));
}

/**
 * Get a translatable string with allowed html tags.
 *
 * @param string $level Allowed levels are basic and intermediate
 * @return string
 */
function carvia_get_allowed_html_desc($level = 'basic')
{
	if (! in_array($level, ['basic', 'intermediate'])) {
		$level = 'basic';
	}

	$tags_str = '<' . implode('>,<', array_keys(carvia_get_allowed_html_tags($level))) . '>';
	return sprintf(__('This input field has support for the following HTML tags: %1$s', 'carvia-core'), '<code>' . esc_html($tags_str) . '</code>');
}

/**
 * Sanitize html class string
 *
 * @param $class
 * @return string
 */
function carvia_core_sanitize_html_class_param($class)
{
	$classes = ! empty($class) ? explode(' ', $class) : [];
	$sanitized = [];
	if (! empty($classes)) {
		$sanitized = array_map(function ($cls) {
			return sanitize_html_class($cls);
		}, $classes);
	}
	return implode(' ', $sanitized);
}

function carvia_core_get_current_user_display_name()
{
	$user = wp_get_current_user();
	$name = 'user';
	if ($user->exists() && $user->display_name) {
		$name = $user->display_name;
	}
	return $name;
}

/**
 * Check if mailchimp plugin is activated
 *
 * @return bool
 */
function carvia_core_is_mc4wp_activated()
{
	return function_exists('mc4wp');
}

/**
 * Get a list of all CF7 forms
 *
 * @return array
 */
function carvia_core_get_mc4wp_forms()
{
	$forms = [];
	if (carvia_core_is_mc4wp_activated()) {
		$_forms = get_posts([
			'post_type'      => 'mc4wp-form',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		]);

		if (! empty($_forms)) {
			$forms = wp_list_pluck($_forms, 'post_title', 'ID');
		}
	}
	return $forms;
}

/**
 * Render icon html with backward compatibility
 *
 * @param array $settings
 * @param string $old_icon_id
 * @param string $new_icon_id
 * @param array $attributes
 */
function carvia_core_render_icon($settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [])
{
	// Check if its already migrated
	$migrated = isset($settings['__fa4_migrated'][$new_icon_id]);
	// Check if its a new widget without previously selected icon using the old Icon control
	$is_new = empty($settings[$old_icon_id]);

	$attributes['aria-hidden'] = 'true';

	\Elementor\Icons_Manager::render_icon($settings[$new_icon_id], $attributes);
}
