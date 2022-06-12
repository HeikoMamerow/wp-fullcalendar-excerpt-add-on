<?php
/*
Plugin Name: WP FullCalendar Excerpt Add-On
Version: 1.4.1
Text Domain: wp-fullcalendar-excerpt-add-on
Plugin URI: https://github.com/HeikoMamerow/wp-fullcalendar-excerpt-add-on
Description: This is an Add-On for the WP FullCalendar plugin. It adds the ability to display an excerpt - instead of the full content - for the event description in the event list.
Author: Heiko Mamerow
Author URI: https://heikomamerow.dev
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Overrides the original qtip_content function with an excerpt instead of the full content.
 *
 * The origin function is here: wp-content/plugins/wp-fullcalendar/wp-fullcalendar.php line 235 ff.
 */
function wpfc_qtip_content_excerpt() {
	if ( ! empty( $_REQUEST['post_id'] ) ) {
		$post = get_post( $_REQUEST['post_id'] );
		if ( $post->post_type === 'attachment' ) {
			$content = wp_get_attachment_image( $post->ID, 'thumbnail' );
		} else {
			$content = ( ! empty( $post ) ) ? $post->post_excerpt : '';
			if ( get_option( 'wpfc_qtips_image', 1 ) ) {
				$post_image = get_the_post_thumbnail( $post->ID, [
					get_option( 'wpfc_qtip_image_w', 75 ),
					get_option( 'wpfc_qtip_image_h', 75 )
				] );
				if ( ! empty( $post_image ) ) {
					$content = '<div class="tharpaland-flexbox"><div>' . $post_image . '</div><div>' . $content .'</div></div>';
				}
			}
		}
	}

	return $content;
}

add_filter( 'wpfc_qtip_content', 'wpfc_qtip_content_excerpt', 20 );
