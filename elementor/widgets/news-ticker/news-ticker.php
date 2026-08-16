<?php

/**
 * News Ticker Widget
 *
 * @package Carvia
 */

namespace Carvia_Core\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Class Carvia_Scrolling_Marquee_Widget
 */
class News_Ticker extends Widget_Base
{

	/**
	 * Get widget name.
	 */
	public function get_name()
	{
		return 'carvia-news-ticker';
	}

	/**
	 * Get widget title.
	 */
	public function get_title()
	{
		return esc_html__('News Ticker', 'carvia-core');
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon()
	{
		return 'carvia-core-icon eicon-slider-push';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories()
	{
		return ['carvia_core'];
	}

	/**
	 * Get widget keywords.
	 */
	public function get_keywords()
	{
		return ['marquee', 'ticker', 'news', 'scroll', 'text', 'announcement', 'carvia-core'];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls()
	{

		/* ── Ticker Items ─────────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__('Ticker Items', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			[
				'label'       => esc_html__('Text', 'carvia-core'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Add your news or announcement here.', 'carvia-core'),
				'placeholder' => esc_html__('Type your text here', 'carvia-core'),
				'rows'        => 2,
			]
		);

		$repeater->add_control(
			'item_link',
			[
				'label'       => esc_html__('Link', 'carvia-core'),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'carvia-core'),
				'options'     => ['url', 'is_external', 'nofollow'],
				'default'     => ['url' => ''],
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label' => esc_html__('Item Icon', 'carvia-core'),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$repeater->add_control(
			'item_text_color',
			[
				'label'     => esc_html__('Text Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .carvia-marquee-item-text' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .carvia-marquee-item-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => esc_html__('Items', 'carvia-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					['item_text' => esc_html__('New Luxury Cars Just Arrived', 'carvia-core')],
					['item_text' => esc_html__('Exclusive Rental Offers', 'carvia-core')],
					['item_text' => esc_html__('Premium Fleet, Exceptional Journeys', 'carvia-core')],
					['item_text' => esc_html__('Special Weekend Rental Deals', 'carvia-core')],
				],
				'title_field' => '{{{ item_text }}}',
			]
		);

		$this->end_controls_section();

		/* ── Marquee Settings ─────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__('Settings', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'direction',
			[
				'label'   => esc_html__('Direction', 'carvia-core'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'  => [
						'title' => esc_html__('Left', 'carvia-core'),
						'icon'  => 'eicon-arrow-left',
					],
					'right' => [
						'title' => esc_html__('Right', 'carvia-core'),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'default' => 'left',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__('Speed (seconds for full cycle)', 'carvia-core'),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 5,
						'max'  => 300,
						'step' => 1,
					],
				],
				'default' => ['size' => 30],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'        => esc_html__('Pause on Hover', 'carvia-core'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'carvia-core'),
				'label_off'    => esc_html__('No', 'carvia-core'),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'separator_type',
			[
				'label'   => esc_html__('Separator Type', 'carvia-core'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'text' => [
						'title' => esc_html__('Text', 'carvia-core'),
						'icon'  => 'eicon-t-letter',
					],
					'icon' => [
						'title' => esc_html__('Icon', 'carvia-core'),
						'icon'  => 'eicon-star',
					],
					'none' => [
						'title' => esc_html__('None', 'carvia-core'),
						'icon'  => 'eicon-ban',
					],
				],
				'default' => 'text',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'separator',
			[
				'label'       => esc_html__('Separator Text', 'carvia-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '///',
				'placeholder' => '|',
				'condition'   => ['separator_type' => 'text'],
			]
		);

		$this->add_control(
			'separator_icon',
			[
				'label'     => esc_html__('Separator Icon', 'carvia-core'),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-circle',
					'library' => 'fa-solid',
				],
				'condition' => ['separator_type' => 'icon'],
			]
		);

		$this->add_control(
			'separator_gap',
			[
				'label'   => esc_html__('Item Gap (px)', 'carvia-core'),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min'  => 10,
						'max'  => 200,
						'step' => 5,
					],
				],
				'default' => ['size' => 60],
			]
		);

		$this->end_controls_section();

		/* ── Controls (Play/Pause Buttons) ──────────────────────────────────────*/
		$this->start_controls_section(
			'section_controls',
			[
				'label' => esc_html__('Controls', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_controls',
			[
				'label'        => esc_html__('Show Play/Pause Controls', 'carvia-core'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'carvia-core'),
				'label_off'    => esc_html__('No', 'carvia-core'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		// ─── STYLE TAB ──────────────────────────────────────────────────────────

		/* ── Wrapper ──────────────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_wrapper',
			[
				'label' => esc_html__('Wrapper', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'wrapper_background',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carvia-marquee-wrapper' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__('Padding', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'default'    => [
					'top'    => '12',
					'right'  => '0',
					'bottom' => '12',
					'left'   => '0',
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .carvia-marquee-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'wrapper_border',
				'selector' => '{{WRAPPER}} .carvia-marquee-wrapper',
			]
		);

		$this->add_responsive_control(
			'wrapper_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'carvia-core'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-marquee-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'wrapper_box_shadow',
				'selector' => '{{WRAPPER}} .carvia-marquee-wrapper',
			]
		);

		$this->end_controls_section();

		/* ── Items ────────────────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_items',
			[
				'label' => esc_html__('Items', 'carvia-core'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_color',
			[
				'label'     => esc_html__('Text Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carvia-marquee-item-text'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .carvia-marquee-item-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_hover_color',
			[
				'label'     => esc_html__('Hover Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carvia-marquee-item:hover .carvia-marquee-item-text'   => 'color: {{VALUE}}',
					'{{WRAPPER}} .carvia-marquee-item:hover .carvia-marquee-item-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'item_typography',
				'selector' => '{{WRAPPER}} .carvia-marquee-item-text',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'item_stroke',
				'selector' => '{{WRAPPER}} .carvia-marquee-item-text',
			]
		);

		$this->add_control(
			'item_icon_color',
			[
				'label'     => esc_html__('Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carvia-marquee-item-icon'     => 'color: {{VALUE}}',
					'{{WRAPPER}} .carvia-marquee-item-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_icon_size',
			[
				'label'      => esc_html__('Icon Size (px)', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 8, 'max' => 40]],
				'selectors'  => [
					'{{WRAPPER}} .carvia-marquee-item-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carvia-marquee-item-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ── Separator ────────────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_separator',
			[
				'label'     => esc_html__('Separator', 'carvia-core'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => ['separator_type!' => 'none'],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label'     => esc_html__('Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#aaaaaa',
				'selectors' => [
					'{{WRAPPER}} .carvia-marquee-separator'     => 'color: {{VALUE}}',
					'{{WRAPPER}} .carvia-marquee-separator svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'separator_size',
			[
				'label'      => esc_html__('Size', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range'      => ['px' => ['min' => 8, 'max' => 60]],
				'default'    => ['size' => 14, 'unit' => 'px'],
				'selectors'  => [
					'{{WRAPPER}} .carvia-marquee-separator'     => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carvia-marquee-separator i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carvia-marquee-separator svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ── Controls Button ──────────────────────────────────────────────────── */
		$this->start_controls_section(
			'section_style_controls',
			[
				'label'     => esc_html__('Controls Button', 'carvia-core'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => ['show_controls' => 'yes'],
			]
		);

		$this->add_control(
			'controls_color',
			[
				'label'     => esc_html__('Icon Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => [
					'{{WRAPPER}} .carvia-marquee-controls button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'controls_bg_color',
			[
				'label'     => esc_html__('Background Color', 'carvia-core'),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .carvia-marquee-controls button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'controls_size',
			[
				'label'      => esc_html__('Size (px)', 'carvia-core'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => ['px' => ['min' => 10, 'max' => 40]],
				'default'    => ['size' => 20],
				'selectors'  => [
					'{{WRAPPER}} .carvia-marquee-controls button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 *
	 * Zero JavaScript. Everything — speed, gap, direction, pause-on-hover,
	 * and the play/pause toggle — is driven by CSS custom properties and
	 * CSS selectors alone.
	 *
	 * Technique overview
	 * ──────────────────
	 * • Speed  → --carvia-speed custom property on the track element.
	 * • Gap    → --carvia-gap custom property, used in margin via CSS var().
	 * • Dir    → .carvia-dir-left / .carvia-dir-right class on the track;
	 *            each class references a different @keyframes block in CSS.
	 * • Hover  → .carvia-pause-hover class on the wrapper triggers
	 *            animation-play-state:paused on :hover in CSS.
	 * • Toggle → A hidden <input type="checkbox"> before the wrapper.
	 *            The CSS sibling selector :checked ~ .wrapper targets the track
	 *            and sets animation-play-state:paused. The <label> acts as the
	 *            visible button — it shows a ▶ icon when checked, ⏸ otherwise.
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$items    = $settings['items'] ?? [];

		if (empty($items)) {
			return;
		}

		$widget_id      = $this->get_id();
		$direction      = $settings['direction'] ?? 'left';
		$speed          = ! empty($settings['speed']['size']) ? (int) $settings['speed']['size'] : 30;
		$gap            = ! empty($settings['separator_gap']['size']) ? (int) $settings['separator_gap']['size'] : 60;
		$sep_type       = $settings['separator_type'] ?? 'text';
		$separator      = ($sep_type === 'text' && ! empty($settings['separator'])) ? esc_html($settings['separator']) : '';
		$separator_icon = ($sep_type === 'icon') ? ($settings['separator_icon'] ?? []) : [];
		$pause_hover    = $settings['pause_on_hover'] === 'yes';
		$show_ctrl      = $settings['show_controls'] === 'yes';

		// CSS custom properties for speed and gap — no JS required.
		$track_style = sprintf(
			'--carvia-speed:%ds;--carvia-gap:%dpx;',
			$speed,
			$gap
		);

		$track_class = 'carvia-marquee-track carvia-dir-' . esc_attr($direction);

		$wrapper_class = 'carvia-marquee-wrapper';
		if ($pause_hover) {
			$wrapper_class .= ' carvia-pause-hover';
		}

		// Unique checkbox ID for the CSS toggle trick.
		$chk_id = 'carvia-chk-' . esc_attr($widget_id);
?>

		<?php if ($show_ctrl) : ?>
			<input type="checkbox"
				id="<?php echo esc_attr($chk_id); ?>"
				class="carvia-marquee-toggle"
				aria-label="<?php esc_attr_e('Pause / Play marquee', 'carvia-core'); ?>"
				hidden>
		<?php endif; ?>

		<div class="<?php echo esc_attr($wrapper_class); ?>"
			id="carvia-marquee-<?php echo esc_attr($widget_id); ?>"
			<?php if ($show_ctrl) : ?>data-ctrl="<?php echo esc_attr($chk_id); ?>" <?php endif; ?>>

			<div class="carvia-marquee-track-wrapper">
				<div class="<?php echo esc_attr($track_class); ?>"
					style="<?php echo esc_attr($track_style); ?>">

					<?php
					// Duplicate items once for a seamless infinite loop —
					// translateX(-50%) brings the track back to start invisibly.
					for ($clone = 0; $clone < 2; $clone++) :
						foreach ($items as $index => $item) :
							$item_class = 'carvia-marquee-item elementor-repeater-item-' . esc_attr($item['_id']);
					?>
							<span class="<?php echo esc_attr($item_class); ?>">
								<?php if (! empty($item['item_icon']['value'])) : ?>
									<span class="carvia-marquee-item-icon">
										<?php \Elementor\Icons_Manager::render_icon($item['item_icon'], ['aria-hidden' => 'true']); ?>
									</span>
								<?php endif; ?>

								<span class="carvia-marquee-item-text">
									<?php
									$has_link = ! empty($item['item_link']['url']);
									if ($has_link) :
										$link_attrs = 'href="' . esc_url($item['item_link']['url']) . '"';
										if (! empty($item['item_link']['is_external'])) {
											$link_attrs .= ' target="_blank"';
										}
										if (! empty($item['item_link']['nofollow'])) {
											$link_attrs .= ' rel="nofollow"';
										}
										echo '<a ' . $link_attrs . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									endif;
									echo esc_html($item['item_text']);
									if ($has_link) {
										echo '</a>';
									}
									?>
								</span>

								<?php
								$show_sep = $sep_type !== 'none' && ($clone === 0 || $index < count($items) - 1);
								if ($show_sep) : ?>
									<span class="carvia-marquee-separator" aria-hidden="true">
										<?php if ($sep_type === 'icon' && ! empty($separator_icon['value'])) : ?>
											<?php \Elementor\Icons_Manager::render_icon($separator_icon, ['aria-hidden' => 'true']); ?>
										<?php else : ?>
											<?php echo esc_html($separator); ?>
										<?php endif; ?>
									</span>
								<?php endif; ?>
							</span>
						<?php endforeach; ?>
					<?php endfor; ?>

				</div><!-- .carvia-marquee-track -->
			</div><!-- .carvia-marquee-track-wrapper -->

			<?php if ($show_ctrl) : ?>
				<div class="carvia-marquee-controls">
					<?php /* Label acts as the visual button; the hidden checkbox does the state. */ ?>
					<label for="<?php echo esc_attr($chk_id); ?>"
						class="carvia-marquee-ctrl-label"
						title="<?php esc_attr_e('Play / Pause', 'carvia-core'); ?>"
						aria-label="<?php esc_attr_e('Play / Pause marquee', 'carvia-core'); ?>">
						<span class="carvia-ctrl-pause"><i class="fas fa-pause" aria-hidden="true"></i></span>
						<span class="carvia-ctrl-play"><i class="fas fa-play" aria-hidden="true"></i></span>
					</label>
				</div>
			<?php endif; ?>

		</div><!-- .carvia-marquee-wrapper -->

	<?php
	}

	/**
	 * Elementor live-preview template (Backbone / Underscore).
	 */
	protected function content_template()
	{
	?>
		<#
			var items=settings.items;
			if ( ! items || ! items.length ) { return; }

			var direction=settings.direction || 'left' ;
			var speed=settings.speed.size || 30;
			var gap=settings.separator_gap.size || 60;
			var sepType=settings.separator_type || 'text' ;
			var separator=( sepType==='text' ) ? ( settings.separator || '' ) : '' ;
			var sepIcon=( sepType==='icon' && settings.separator_icon ) ? settings.separator_icon.value : '' ;
			var showCtrl=settings.show_controls==='yes' ;
			var pauseHover=settings.pause_on_hover==='yes' ;

			var trackStyle='--carvia-speed:' + speed + 's;--carvia-gap:' + gap + 'px;' ;
			var trackClass='carvia-marquee-track carvia-dir-' + direction;
			var wrapClass='carvia-marquee-wrapper' + ( pauseHover ? ' carvia-pause-hover' : '' );
			var chkId='carvia-chk-preview' ;
			#>

			<# if ( showCtrl ) { #>
				<input type="checkbox" id="{{ chkId }}" class="carvia-marquee-toggle" hidden>
				<# } #>

					<div class="{{ wrapClass }}">
						<div class="carvia-marquee-track-wrapper">
							<div class="{{ trackClass }}" style="{{ trackStyle }}">
								<# _.each( items, function( item ) { #>
									<span class="carvia-marquee-item elementor-repeater-item-{{ item._id }}">
										<# if ( item.item_icon && item.item_icon.value ) { #>
											<span class="carvia-marquee-item-icon"><i class="{{ item.item_icon.value }}"></i></span>
											<# } #>
												<span class="carvia-marquee-item-text">
													<# if ( item.item_link && item.item_link.url ) { #>
														<a href="{{ item.item_link.url }}">{{ item.item_text }}</a>
														<# } else { #>
															{{ item.item_text }}
															<# } #>
												</span>
												<# if ( sepType !=='none' ) { #>
													<span class="carvia-marquee-separator" aria-hidden="true">
														<# if ( sepType==='icon' && sepIcon ) { #><i class="{{ sepIcon }}"></i>
															<# } else { #>{{ separator }}
																<# } #>
													</span>
													<# } #>
									</span>
									<# }); #>
										<%/* second clone for seamless loop */%>
										<# _.each( items, function( item ) { #>
											<span class="carvia-marquee-item elementor-repeater-item-{{ item._id }}">
												<# if ( item.item_icon && item.item_icon.value ) { #>
													<span class="carvia-marquee-item-icon"><i class="{{ item.item_icon.value }}"></i></span>
													<# } #>
														<span class="carvia-marquee-item-text">{{ item.item_text }}</span>
														<# if ( sepType !=='none' ) { #>
															<span class="carvia-marquee-separator" aria-hidden="true">
																<# if ( sepType==='icon' && sepIcon ) { #><i class="{{ sepIcon }}"></i>
																	<# } else { #>{{ separator }}
																		<# } #>
															</span>
															<# } #>
											</span>
											<# }); #>
							</div>
						</div>

						<# if ( showCtrl ) { #>
							<div class="carvia-marquee-controls">
								<label for="{{ chkId }}" class="carvia-marquee-ctrl-label">
									<span class="carvia-ctrl-pause"><i class="fas fa-pause"></i></span>
									<span class="carvia-ctrl-play"><i class="fas fa-play"></i></span>
								</label>
							</div>
							<# } #>
					</div>
			<?php
		}
	}
