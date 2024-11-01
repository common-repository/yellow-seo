<?php

/**
 * Adds Google analytics
 *
 * @since  1.0.2
 */
function simpleseo_analytics() {
	global $post;

	if (!is_object($post)) {
		return;
	}

	if (is_archive()) {
		return;
	}
	
	$version = CDS_SSEO_VERSION;
	$acode = esc_attr(get_option('sseo_ganalytics'));
	
	if(!empty($acode)) {
echo <<<END
<script type="text/javascript" src="https://www.google-analytics.com/analytics.js"></script>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', '$acode', 'auto');
ga('send', 'pageview');
</script>

END;
	}
}

add_filter('wp_head', 'simpleseo_analytics', 22);

/**
 * Adds Google analytics
 *
 * @since  1.0.2
 */
function simpleseo_webmasterTools() {
	global $post;

	if (!is_object($post)) {
		return;
	}

	if (is_archive()) {
		return;
	}
	
	$version = CDS_SSEO_VERSION;
	$acode = esc_attr(get_option('sseo_gsite_verification'));

	if (!empty($acode)) {
echo <<<END
<meta name="google-site-verification" content="$acode" />
END;
	}
}

add_filter('wp_head', 'simpleseo_webmasterTools', 22);