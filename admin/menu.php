<?php

include('yellow-seo-options.php');

/**
 * Description
 *
 * @since  1.0.0
 */
function yellow_seo_admin_menu() {
	add_options_page('SEO Options', 'Yellow SEO', 'manage_options', 'yellow_seo_options', 'yellow_seo_options');
}

add_action('admin_menu', 'yellow_seo_admin_menu');