<?php
/**
 * Quick Edit
 *
 * @since  1.4.0
 */
if (!function_exists('sseo_change_page_columns')) {
	function sseo_change_page_columns($columns) {
		$columns['seo_title'] = __('SEO Title');
		$columns['seo_description'] = __('Meta Description');
		return $columns;
	}

	add_filter("manage_page_posts_columns", "sseo_change_page_columns");
}


/**
 * Quick Edit
 *
 * @since  1.4.0
 */
if (!function_exists('sseo_posttype_columns')) {
	function sseo_posttype_columns($column, $post_id) {
		switch($column) {
			case 'seo_title':
				$sseo_meta_title = get_post_meta($post_id, 'sseo_meta_title', true);
				echo '<input type="text" class="seo_title" value="'.$sseo_meta_title.'" name="seo_title" />';
				break;
			case 'seo_description':
				$sseo_meta_description = get_post_meta($post_id, 'sseo_meta_description', true);
				echo '<input type="text" class="seo_description" value="'.$sseo_meta_description.'" name="seo_description" />';
				break;
		}
	}
	add_action("manage_posts_custom_column", "sseo_posttype_columns", 10, 2);
}


/**
 * Quick Edit
 *
 * @since  1.4.0
 */
if (!function_exists('sseo_posttype_add_quick_edit')) {
	function sseo_posttype_add_quick_edit($column_name, $post_type) {
		if (!empty($_GET['post_type']) && $_GET['post_type'] != $post_type) {
			return;
		}
		
		static $printNonce = true;
		if ($printNonce) {
			$printNonce = false;
			wp_nonce_field('sseo_nonce', 'sseo_nonce');
		}

		switch($column_name) { 
			case 'seo_title': ?>
		<fieldset class="inline-edit-col-left clear">
			<div class="inline-edit-col">
				<label>
					<span class="title">SEO Title</span>
					<span class="input-text-wrap">
						<input class="seo_title" type="text" name="sseo_meta_title" placeholder="">
						<span><span class="seo_title_count" style="color: rgb(112, 192, 52);">0</span> / 70 recommended characters</span></span>
				</label>
			</div>
		</fieldset>
		<?php break; case 'seo_description': ?>
		<fieldset class="inline-edit-col-left clear">
			<div class="inline-edit-col">
				<label>
					<span class="title">SEO Desc.</span>
					<span class="input-text-wrap">
						<textarea class="seo_description" name="sseo_meta_description"></textarea>
						<span><span class="seo_description_count" style="color: rgb(112, 192, 52);">0</span> / 350 recommended characters</span>
					</span>
				</label>
			</div>
		</fieldset>
		<?php break; }
	}
	
	add_action('quick_edit_custom_box', 'sseo_posttype_add_quick_edit', 10, 2);
}


/**
 * Quick Edit
 *
 * @since  1.4.0
 */
if (!function_exists('quickedit_enqueue_scripts') ) {
	function quickedit_enqueue_scripts($hook) {
		if ('edit.php' === $hook && isset($_GET['post_type']) && 'page' === $_GET['post_type']) {
            wp_enqueue_script('sseo_quickedit', plugins_url('yellow-seo/js/quickedit.js', CDS_SSEO_PATH), false, null, true);

		}
	}

	add_action('admin_enqueue_scripts', 'quickedit_enqueue_scripts');
}

/**
 * Quick Edit
 *
 * @since  1.4.0
 */
add_action('manage_page_posts_custom_column', 'sseo_custom_page_column', 10, 2);

function sseo_custom_page_column($column, $post_id) {
	switch ($column) {
    	case 'seo_title':
			echo get_post_meta($post_id, 'sseo_meta_title', true);
        	break;
    	case 'seo_description':
			echo get_post_meta($post_id, 'sseo_meta_description', true);
        	break;
    }
}