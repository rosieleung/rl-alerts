<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rl_alerts_enqueue_scripts() {
	wp_enqueue_style( 'rl-alerts', RL_ALERTS_URL . '/assets/rl-alerts.css', array(), RL_ALERTS_VERSION );
	wp_enqueue_script( 'rl-alerts', RL_ALERTS_URL . '/assets/rl-alerts.js', array( 'jquery' ), RL_ALERTS_VERSION );
}

add_action( 'wp_enqueue_scripts', 'rl_alerts_enqueue_scripts' );
