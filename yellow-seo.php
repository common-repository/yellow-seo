<?php

/*
Plugin Name: Yellow SEO
Description: A great plugin to add META Tags in your website, includes Google Analytics, Google Webmaster Tools, and social meta tags
Version: 1.0.0
Author: Yellowme
Author URI: http://yellowme.mx
License: GPL2
*/

/*

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/* No direct access. No, no, no... */
defined('ABSPATH') or die('Cheatin\' uh?');

define('CDS_SSEO_VERSION', '1.0.0');
define('CDS_SSEO_PATH', plugin_dir_path( __FILE__ ) );

require(CDS_SSEO_PATH.'/inc/class-cds-seo-form.php');
include('admin/menu.php');
include('inc/quick-edit.php');
include('inc/analytics/analytics.php');


/*
 * Tell WP what to do when plugin is loaded
 *
 * @since 1.0
 */
function yellow_seo_load() {
	register_setting('sseo-settings-group', 'sseo_default_meta_title');
	register_setting('sseo-settings-group', 'sseo_default_meta_description');
	register_setting('sseo-settings-group', 'sseo_default_meta_keywords');
	register_setting('sseo-settings-group', 'sseo_default_meta_image');
	register_setting('sseo-settings-group', 'sseo_default__title');
	register_setting('sseo-settings-group', 'sseo_baindu_site_verification');
	register_setting('sseo-settings-group', 'sseo_bing_site_verification');
	register_setting('sseo-settings-group', 'sseo_gsite_verification');
	register_setting('sseo-settings-group', 'sseo_yandex_site_verification');
	register_setting('sseo-settings-group', 'sseo_ganalytics');
	register_setting('sseo-settings-group', 'sseo_robot_noindex');
	register_setting('sseo-settings-group', 'sseo_robot_nofollow');
		
	simpleseo_register();
}

add_action('admin_init', 'yellow_seo_load');


/**
 * Registers JS and CSS.
 *
 * @since  1.0.0
 */
function simpleseo_register() {
	wp_register_style('sseo_style', plugins_url('css/style.css', __FILE__), false, CDS_SSEO_VERSION);
	wp_register_script('sseo_script', plugins_url('js/script.js', __FILE__), array('jquery'), CDS_SSEO_VERSION, true);
}


/**
 * Enqueues the CSS and JS files.
 *
 * @since  1.0.0
 */
function simpleseo_enqueue() {		
	wp_enqueue_style('sseo_style', plugins_url('css/style.css', __FILE__), false, CDS_SSEO_VERSION);
	wp_enqueue_script('sseo_script', plugins_url('js/script.js', __FILE__), array('jquery'), CDS_SSEO_VERSION, true);
}

add_action('admin_enqueue_scripts', 'simpleseo_enqueue');


/**
 * Description
 *
 * @since  1.0.0
 */
function simpleseo_meta_boxes() {
    add_meta_box( 
        'simple-seo',
        __('Yellow SEO'),
        'simpleseo_show_meta_boxes'
    );
}


/**
 * Description
 *
 * @since  1.3.0
 */
function cds_sseo_description_limit($str, $n = 160) {
	if (strlen($str) < $n) {
		return $str;
	}

	$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

	if (strlen($str) <= $n) {
		return $str;
	}

	$out = "";
	foreach (explode(' ', trim($str)) as $val) {
		$out .= $val.' ';

		if (strlen($out) >= $n) {
			$out = trim($out);
			return (strlen($out) == strlen($str)) ? $out : $out;
		}       
	}
}




/**
 * Description
 *
 * @since  1.0.0
 */
function simpleseo_show_meta_boxes($post, $params) {
	global $wp;
	
    /* Use nonce for verification */
	wp_nonce_field('sseo_nonce', 'sseo_nonce');

	$content .= '<div class="cds-seo-metabox-tabs">';
	$content .= '<input id="cds-seo-tab1" type="radio" name="tab-group" checked="checked" />';
	$content .= '<label class="tab" for="cds-seo-tab1" class="active">SEO</label>';
	$content .= '<input id="cds-seo-tab2" type="radio" name="tab-group" />';
	$content .= '<label class="tab" for="cds-seo-tab2">Keywords</label>';
	$content .= '<input id="cds-seo-tab3" type="radio" name="tab-group" />';
	$content .= '<label class="tab" for="cds-seo-tab3">Robots</label>';
	
	$content .= '<div id="cds-seo-preview" class="cds-seo-tab">';
	
	$sseo_meta_title = get_post_meta($post->ID, 'sseo_meta_title', true);
	$sseo_meta_description = get_post_meta($post->ID, 'sseo_meta_description', true);
	$sseo_meta_keywords = get_post_meta($post->ID, 'sseo_meta_keywords', true);
	$sseo_robot_noindex = get_post_meta($post->ID, 'sseo_robot_noindex', true);
	$sseo_robot_nofollow = get_post_meta($post->ID, 'sseo_robot_nofollow', true);
	$current_url = get_permalink($post->ID);
	
	if (empty($sseo_meta_description)) {
		$post_content = strip_tags($post->post_content);
		$preview_meta_description = cds_sseo_description_limit($post_content);
	} else {
		$preview_meta_description = $sseo_meta_description;
	}
	
	$content .= '<div class="cds-seo-section">';
	$content .= '<h3>Vista Previa</h3>';
	$content .= '<div class="preview_snippet">';
	$content .= '<div id="sseo_snippet">';
	$content .= '<img src="" id="sseo_snippet_img" >';
	$content .= '<a><span id="sseo_snippet_title">'.$sseo_meta_title.'</span></a>';
	$content .= '<div class="cds-seo-current-url">';
	$content .= '<cite id="sseo_snippet_link">'.$current_url.'</cite>';
	$content .= '</div>'; /* cds-seo-current-url */
	$content .= '<span id="sseo_snippet_description">'.$preview_meta_description.'</span>';
	$content .= '</div>'; /* sseo_snippet */
	$content .= '</div>'; /* preview_snippet */
	$content .= '</div>'; /* cds-seo-section */

	$content .= '<div class="cds-seo-section">';
	$content .= '<h3>SEO</h3>';
	
	/* SSEO Input Fields */						
	$sseoForm = new cds_sseo_form_helper();
	$content .= $sseoForm->input('sseo_meta_title', array(
		'label' => 'Título',
		'value' => $sseo_meta_title,
	));

	$content .= '<p><span id="sseo_title_count">0</span> caracteres. La mayoría de los motores de búsqueda usan un máximo de 60 caracteres para el título.</p>';

	$content .= $sseoForm->textarea('sseo_meta_description', array(
		'label' => 'Descripción',
		'value' => $sseo_meta_description,
	));

	$content .= '<p><span id="sseo_desc_count">0</span> caracteres. La mayoría de los motores de búsqueda usan un máximo de 60 caracteres para la descripción.</p>';
	
	$content .= '</div>'; /* .cds-seo-section */
	$content .= '</div>'; /* #cds-seo-preview */
	
	$content .= '<div id="cds-seo-keywords" class="cds-seo-tab">';
	$content .= '<div class="cds-seo-section">';

	$content .= $sseoForm->textarea('sseo_meta_keywords', array(
		'label' => 'Keywords',
		'value' => $sseo_meta_keywords,
	));

	$content .= '<p>Una lista de tus palabras clave (keywords) separadas por comas que serán colocadas en META keywords.</p>';
	
	$content .= '</div>'; /* .cds-seo-section */
	$content .= '</div>'; /* cds-seo-keywords */
	
	$content .= '<div id="cds-seo-robots" class="cds-seo-tab">';
	$content .= '<div class="cds-seo-section">';
	$content .= '<h3>Robots</h3>';

	$content .= $sseoForm->input('sseo_robot_noindex', array(
		'type' => 'checkbox',
		'label' => 'Robots Meta NOINDEX',
		'checked' => $sseo_robot_noindex,
	));
	
	$content .= $sseoForm->input('sseo_robot_nofollow', array(
		'type' => 'checkbox',
		'label' => 'Robots Meta NOFOLLOW',
		'checked' => $sseo_robot_nofollow,
	));

	$content .= '</div>'; /* .cds-seo-section */
	$content .= '</div>'; /* #cds-seo-robots */
	$content .= '<div class="clearfix">&nbsp;</div>'; 
	$content .= '</div>'; /* .cds-seo-metabox-tabs */
	
	echo $content;
}

add_action('add_meta_boxes', 'simpleseo_meta_boxes');



/**
 * Description
 *
 * @since  1.0.0
 */
function simepleseo_save_postdata($post_id) {
	/* verify nonce */
	if (!wp_verify_nonce($_POST['sseo_nonce'], 'sseo_nonce' )) {
		return $post_id;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return $post_id;
	}

	/* check autosave */
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	/* Check permissions */
	if ($_POST['post_type'] == 'page') {
		if (!current_user_can('edit_page', $post_id)) {
        	return $post_id;
        }
	} elseif (!current_user_can('edit_post', $post_id)) {
    	return $post_id;
	}

	if (!wp_is_post_revision($post_id)) {
		$old_meta_title = get_post_meta($post_id, 'sseo_meta_title', true);
		$new_meta_title = null;
		if (isset($_POST['sseo_meta_title'])) {
			$new_meta_title = sanitize_text_field($_POST['sseo_meta_title']);
		}

		if ($new_meta_title && $new_meta_title != $old_meta_title) {
			update_post_meta($post_id, 'sseo_meta_title', $new_meta_title);
		} elseif (empty($new_meta_title) && $old_meta_title) {
			delete_post_meta($post_id, 'sseo_meta_title', $old_meta_title);
		}
		
		$old_meta_description = get_post_meta($post_id, 'sseo_meta_description', true);
		$new_meta_description = null;
		if (isset($_POST['sseo_meta_description'])) {
			$new_meta_description = sanitize_text_field($_POST['sseo_meta_description']);
		}
		
		if ($new_meta_description && $new_meta_description != $old_meta_description) {
			update_post_meta($post_id, 'sseo_meta_description', $new_meta_description);
		} elseif (empty($new_meta_description) && $old_meta_description) {
			delete_post_meta($post_id, 'sseo_meta_description', $old_meta_description);
		}
		
		$old_meta_keywords = get_post_meta($post_id, 'sseo_meta_keywords', true);
		$new_meta_keywords = null;
		if (isset($_POST['sseo_meta_keywords'])) {
			$new_meta_keywords = sanitize_text_field($_POST['sseo_meta_keywords']);
		}
		
		if ($new_meta_keywords && $new_meta_keywords != $old_meta_keywords) {
			update_post_meta($post_id, 'sseo_meta_keywords', $new_meta_keywords);
		} elseif (empty($new_meta_keywords) && $old_meta_keywords) {
			delete_post_meta($post_id, 'sseo_meta_keywords', $old_meta_keywords);
		}
		
		$old_sseo_gsite_verification = get_post_meta($post_id, 'sseo_gsite_verification', true);
		$new_sseo_gsite_verification = null;
		if (isset($_POST['sseo_gsite_verification'])) {
			$new_sseo_gsite_verification = sanitize_text_field($_POST['sseo_gsite_verification']);
		}
		
		if ($new_sseo_gsite_verification && $new_sseo_gsite_verification != $old_sseo_gsite_verification) {
			update_post_meta($post_id, 'sseo_gsite_verification', $new_sseo_gsite_verification);
		} elseif (empty($new_sseo_gsite_verification) && $old_sseo_gsite_verification) {
			delete_post_meta($post_id, 'sseo_gsite_verification', $old_sseo_gsite_verification);
		}
		
		$old_sseo_ganalytics = get_post_meta($post_id, 'sseo_ganalytics', true);
		$new_sseo_ganalytics = null;
		if (isset($_POST['sseo_ganalytics'])) {
			$new_sseo_ganalytics = sanitize_text_field($_POST['sseo_ganalytics']);
		}
		
		if ($new_sseo_ganalytics && $new_sseo_ganalytics != $old_sseo_ganalytics) {
			update_post_meta($post_id, 'sseo_ganalytics', $new_sseo_ganalytics);
		} elseif (empty($new_sseo_ganalytics) && $old_sseo_ganalytics) {
			delete_post_meta($post_id, 'sseo_ganalytics', $old_sseo_ganalytics);
		}
		
		if (!empty($_POST['sseo_robot_noindex'])) {
			update_post_meta($post_id, 'sseo_robot_noindex', $_POST['sseo_robot_noindex']);
		} else {
			delete_post_meta($post_id, 'sseo_robot_noindex');
		}
		
		if (!empty($_POST['sseo_robot_nofollow'])) {
			update_post_meta($post_id, 'sseo_robot_nofollow', $_POST['sseo_robot_nofollow']);
		} else {
			delete_post_meta($post_id, 'sseo_robot_nofollow');
		}
	}
}

add_action('save_post', 'simepleseo_save_postdata');

/**
 * Description
 *
 * @since  1.0.0
 */
function simpleseo_meta() {
	global $post;


	if (is_archive()) {
		return;
	}
	
		
	$keywords = null;
	if (is_front_page()) {
		$keywords = esc_attr(get_option('sseo_default_meta_keywords'));
		$keywords = apply_filters('sseo_default_meta_keywords', $keywords);
	}
	
	if (empty($keywords)) {
		$keywords = get_post_meta($post->ID, 'sseo_meta_keywords', true);
		$keywords = apply_filters('sseo_meta_keywords', $keywords);
	}
	
	if ($keywords) {
		echo '<meta name="keywords" content="'.$keywords.'" />' . "\n";
	}

	$description = null;
	if (is_front_page()) {
		$description = esc_attr(get_option('sseo_default_meta_description'));
		$description = apply_filters('sseo_default_meta_description', $description);
	}
	
	if (empty($description)) {
		$description = get_post_meta($post->ID, 'sseo_meta_description', true);
		$description = apply_filters('sseo_meta_description', $description);
	}
	
	if ($description) {
		generate_seo_meta_description( $description );	
	}
	
	
	
	echo '<!-- / Simple SEO plugin. -->' . "\n";
}

add_action('wp_head', 'simpleseo_meta');

/**
 * Description
 *
 * @since  1.0.0
 */
function simpleseo_title() {
	global $post;


	if (is_archive()) {
		return;
	}
	
	$meta_title = null;
	
	/* default */
	$default_title = esc_attr(get_option('sseo_default_meta_title'));
	$default_title = apply_filters('sseo_default_meta_title', $default_title);
	/* static page */
	$meta_title = get_post_meta($post->ID, 'sseo_meta_title', true);
	$meta_title = apply_filters('sseo_meta_title', $meta_title);
		
	if (is_front_page() && is_home()) {
		// Default homepage
		if (empty($meta_title)) {
			$meta_title = $default_title;
		}
	} elseif ( is_front_page() ) {
		// static homepage
		if (empty($meta_title)) {
			$meta_title = $default_title;
		}
	} elseif ( is_home() ) {
	  	// blog page
		if (empty($meta_title)) {
			$meta_title = $default_title;
		}
	}

	if (empty($meta_title)) {
		$site_name = get_bloginfo('name');
		generate_seo_meta_tags_title( $post->post_title.' | '.$site_name );
		return;
	}

	generate_seo_meta_tags_title( $meta_title );

}

add_action('wp_head', 'simpleseo_title');

function generate_seo_meta_tags_title( $title ){
	echo '<meta property="og:title" content="' . $title . '"/>';
	//Twitter title
	echo '<meta name="twitter:title" content=" ' . $title . ' "/>';
	
}

function generate_seo_meta_description( $description ){
	echo '<meta name="description" content="'.$description.'" />';
	echo '<meta property="og:description" content="' . $description . '"/>';
	echo '<meta name="twitter:description" content="' . $description . '"/> ';
}

function generate_thumbnail_seo_tag(){
	global $post;

	if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
		//Create a default image on your server or an image in your media library, and insert it's URL here
		$default_image= get_option('sseo_default_meta_image'); 
		echo '<meta property="og:image" content="' . $default_image . '"/>';
		echo '<meta name="twitter:image" content="' . $default_image . '">';
	} else {
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
		echo '<meta name="twitter:image" content="' . esc_attr( $thumbnail_src[0] ) . '">';
	}


}

add_action('wp_head', 'generate_thumbnail_seo_tag');

function generate_robots_tag(){
	global $post;
	
	$sseo_robot_noindex = get_post_meta($post->ID, 'sseo_robot_noindex', true);
	$sseo_robot_nofollow = get_post_meta($post->ID, 'sseo_robot_nofollow', true);

	if (!empty($sseo_robot_noindex) && !empty($sseo_robot_nofollow)) {
		echo '<meta name="robots" content="noindex, nofollow" />' . "\n";
	} elseif (empty($sseo_robot_noindex) && !empty($sseo_robot_nofollow)) {
		echo '<meta name="robots" content="nofollow" />' . "\n";
	}
	if (!empty($sseo_robot_noindex) && empty($sseo_robot_nofollow)) {
		echo '<meta name="robots" content="noindex" />' . "\n";
	}
}

add_action('wp_head', 'generate_robots_tag');

function generate_complement_seo_tags(){
	//You'll need to find you Facebook profile Id and add it as the admin
	echo '<meta property="fb:admins" content="XXXXXXXXX-fb-admin-id"/>';
	echo '<meta property="og:type" content="article"/>';
	
	if( is_front_page() || is_home() ){
		echo '<meta property="og:url" content="' . get_site_url() . '"/>';
	}else{
		echo '<meta property="og:url" content="' . get_permalink() . '"/>';
	}
	

	//Let's also add some Twitter related meta data
	echo '<meta name="twitter:card" content="summary" />';
	//Twitter description
	
			//This is the site Twitter @username to be used at the footer of the card
	echo '<meta name="twitter:site" content="@site_user_name" />';
	//This the Twitter @username which is the creator / author of the article
	echo '<meta name="twitter:creator" content="@username_author" />';
	// Customize the below with the name of your site
	echo '<meta property="og:site_name" content=" ' . get_bloginfo('name') . ' "/>';
}

add_action('wp_head', 'generate_complement_seo_tags');




/**
 * Description
 *
 * @since  1.0.0
 */
function yellow_seo_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=simepleseo_options">'.__('Settings').'</a>';
    array_push($links, $settings_link);
  	return $links;
}

$plugin = plugin_basename(__FILE__);

add_filter("plugin_action_links_$plugin", 'yellow_seo_settings_link');
