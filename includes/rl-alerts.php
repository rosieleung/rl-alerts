<?php

// register ACF options page
acf_add_options_page( array(
	'page_title' => 'Alerts',
	'menu_title' => 'Alerts',
	'menu_slug'  => 'alerts',
	'icon_url'   => 'dashicons-warning',
	'capability' => 'manage_options',
	'position'   => '5.5',
) );

// shortcode to output the maximized alert content

function rl_alerts_fun( $atts ) {
	ob_start();
	if ( have_rows( "rl_alerts", "options" ) ):
		?>
		<div id="rl-alerts" class="rl-alerts">
			<div class="inside rl-alerts-inside">
				<div class="rl-alerts-wrapper">
					<?php while( have_rows( "rl_alerts", "options" ) ): the_row(); ?>
						<div class="rl-alert-item" data-id="<?php echo get_row_index(); ?>">
							<?php the_sub_field( 'alert' ); ?>
						</div>
					<?php endwhile; ?>
				</div>
				<div id="rl-alerts-close" class="rl-alerts-close" title="Close">
					×
					<div class="rl-alerts-close-text">Close</div>
				</div>
			</div>
		</div>
	<?php
	endif;
	
	return ob_get_clean();
}

add_shortcode( 'rl_alerts', 'rl_alerts_fun' );


// shortcode to output the minimized alert tag

function rl_alert_tag_fun( $atts ) {
	ob_start();
	if ( $options = get_field( "rl_alerts", "options" ) ):
		?>
		<div id="rl-alerts-tag" class="rl-alerts-tag" title="Show alerts">
			<div class="rl-alerts-tag-total"><?php echo count( $options ); ?></div>
			!
		</div>
	<?php
	endif;
	
	return ob_get_clean();
}

add_shortcode( 'rl_alert_tag', 'rl_alert_tag_fun' );



// register field group

if( function_exists('acf_add_local_field_group') ):
	
	acf_add_local_field_group(array(
		'key' => 'group_5bf480854eb8d',
		'title' => 'Alerts',
		'fields' => array(
			array(
				'key' => 'field_5bf48197c76c4',
				'label' => 'Alerts',
				'name' => 'rl_alerts',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => '',
				'sub_fields' => array(
					array(
						'key' => 'field_5bf481a2c76c5',
						'label' => 'Alert',
						'name' => 'alert',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 0,
						'delay' => 0,
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'alerts',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

endif;