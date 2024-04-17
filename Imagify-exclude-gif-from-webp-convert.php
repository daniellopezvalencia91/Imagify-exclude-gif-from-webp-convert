<?php
/**
* Plugin Name: Imagify - Exclude Gif from being converted to WebP.  
* Description: This plugin is meant to exclude the Gif from being converted to WebP.
* Plugin URI:  https://github.com/daniellopezvalencia91/Imagify-test
* Version: 0.0.1
* Author: Daniel López Valencia
*/

namespace ImagifyPlugin\Helpers\optimization\skip_gif_webp_convertion;

defined( 'ABSPATH' ) or die();

function no_webp_for_gif( $response, $process, $file, $thumb_size, $optimization_level, $webp, $is_disabled ) {
	if ( ! $webp || $is_disabled || is_wp_error( $response ) ) {
		return $response;
	}

	if ( 'image/gif' !== $file->get_mime_type() ) {
		return $response;
	}

	return new \WP_Error( 'no_webp_for_gif', __( 'Webp version of gif is disabled by filter.' ) );
}
add_filter( 'imagify_before_optimize_size', __NAMESPACE__ . '\no_webp_for_gif', 10, 7 );
