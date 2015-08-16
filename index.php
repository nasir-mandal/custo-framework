<?php

include_once 'framework/custo.php';

$custo_options = new Custo();
$custo_options->hooks();


/**
 * Wrapper function around custo_get_option
 * @since  1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function custo_get_option( $key = '' ) {
	global $custo_options;

	if( function_exists( 'cmb2_get_option' ) ) {
		return cmb2_get_option( $custo_options->key, $key );
	} else {
		$options = get_option( $custo_options->key );
		return isset( $options[ $key ] ) ? $options[ $key ] : false;
	}

}