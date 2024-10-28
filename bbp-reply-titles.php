<?php
/*
Plugin Name: bbPress Reply Titles
Version: 1.0
Description: Add titles to bbPress replies
Author: Boone B Gorges
Author URI: http://boone.gorg.es
Text Domain: bbpress-reply-titles
Domain Path: /languages
*/

/**
 * Markup for the Reply form.
 *
 * @since 1.0
 */
function bbprt_form_markup() {
	?>
	<p class="form-title">
		<label for="bbp-reply-title"><?php _e( 'Title:', 'bbp-reply-titles' ) ?></label>
		<input name="bbp_reply_title" placeholder="<?php _e( 'Optional: Provide a title for your reply', 'bbp-reply-titles' ) ?>" id="bbp-reply-title" />
	</p>
	<?php
}
add_action( 'bbp_theme_before_reply_form_content', 'bbprt_form_markup' );

/**
 * Markup for the display of the title.
 *
 * @since 1.0
 */
function bbprt_display_markup() {
	// bbPress will supply a "Reply To:" fallback. We don't want this
	remove_filter( 'the_title', 'bbp_get_reply_title_fallback', 2, 2 );
	$topic_title = bbp_get_reply_title();
	add_filter( 'the_title', 'bbp_get_reply_title_fallback', 2, 2 );

	// Don't display if the topic title is the same as the reply title
	// (as in the case of the first item in the thread)
	if ( $topic_title && $topic_title !== bbp_get_topic_title() ) {
		echo '<h4 class="bbp-reply-title">' . $topic_title . '</h4>';
	}
}
add_action( 'bbp_theme_before_reply_content', 'bbprt_display_markup' );

/**
 * Enqueue styles
 *
 * @since 1.0
 */
function bbprt_enqueue_styles() {
	wp_enqueue_style( 'bbpress-reply-titles', plugins_url( 'bbpress-reply-titles/css/bbp-reply-titles.css' ) );
}
add_action( 'bbp_enqueue_scripts', 'bbprt_enqueue_styles' );
