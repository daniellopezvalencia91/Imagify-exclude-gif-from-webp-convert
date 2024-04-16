<?php
/**
* Plugin Name: Imagify - Exclude Gif from being converted to WebP.  
* Description: This plugin is meant to exclude the Gif from being converted to WebP.
* Plugin URI:  https://github.com/daniellopezvalencia91/Imagify-test
* Version: 0.0.1
* Author: Daniel López Valencia
*/
namespace ImagifyPlugin\Helpers\exclude_gif_webp;

defined( 'ABSPATH' ) or die();

function no_webp_for_gif( $response, $process, $file, $thumb_size, $optimization_level, $webp, $is_disabled ) {

  // Check if the WebP is not possible or if it is disabled, or if there is an error, if one or more conditions are true it returns the value $response without changes.
  if ( ! $webp || $is_disabled || is_wp_error( $response ) ) {
    return $response;
  }

  // Check if the file is not a Gif, if it's not a Gif just return the value $response without changes.
  if ( 'image/gif' !== $file->get_mime_type() ) {
    return $response;
  }

  // If none of the previous conditions were met, it will return error to prevent WebP conversion
  return new \WP_Error( 'no_webp_for_gif', __( 'Webp version of gif is disabled by filter.' ) );
}

// Hook into Imagify's filter
add_filter( 'imagify_pre_can_create_next_gen_version', 'no_webp_for_gif' );
