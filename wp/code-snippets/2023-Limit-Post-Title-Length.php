function limit_post_title_length($title) {
	global $post;
	$max = 120; // max 120 good for SEO
	$title = $post->post_title;
	if(strlen($title) >= $max) {
		wp_die( __('Error: Kalau ketik judul jangan lebih dari '.$max.' karakter ya ! Tidak bagus untuk Score SEO kita hehe. Silakan <a href="javascript:history.back()"><strong>COBA LAGI</strong></a>') );
	}
}
add_action('publish_post', 'limit_post_title_length');
