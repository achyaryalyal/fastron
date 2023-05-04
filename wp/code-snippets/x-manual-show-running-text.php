function manual_show_running_text(){
	echo '<style>
	#running-text{
		width: 100%;
		position: fixed;
		bottom: 0px;
		height: 28px;
		padding: 5px;
		background: #2F2A95;
		color: #fff;
		border-top: 1px solid #2F2A95;
		cursor: pointer;
		text-transform: uppercase;
		z-index: 99;
		overflow: hidden;
	}
	.pengumuman-logo-run {
		margin: 0 20px;
		border: 1px solid #ccc;
		font-family: Arimo,sans-serif;
		border-radius: 4px;
	}
	.pengumuman-run-item a, .news-run-item a {
		color:#fff;
	}
	.pengumuman-run-item a:hover, .news-run-item a:hover {
		text-decoration: none;
	}
	.logo-run-bbg {
		background: #fff;
		color: #FF8200;
		border-radius: 4px 0 0 4px;
	}
	.logo-run-news {
		background: #FF8200;
		color: #fff;
		border-radius: 0 4px 4px 0;
	}
	marquee{
		border: none;
		margin-top: -4px;
		font-weight: 600;
	}
	</style>

	<div id="running-text">
	<marquee behavior="scroll" direction="left" scrolldelay="20" onmouseover="this.stop();" onmouseout="this.start();">';

	$logo_run = '<strong class="pengumuman-logo-run"><span class="logo-run-bbg">&nbsp;BBG&nbsp;</span><span class="logo-run-news">&nbsp;NEWS&nbsp;</span></strong>';
	
	for($i=1;$i<=3;$i++) { // 3 kali duplicate biar gak cepat kali habis break-nya
		// MASUKKAN 1 PENGUMUMAN
		/*
		$catquery = new WP_Query( 'cat=2&posts_per_page=1' );
		while($catquery->have_posts()) : $catquery->the_post();
			$get_content = get_the_content();
			$content = str_replace("<li>"," &bull; ",$get_content);
			//echo $logo_run_kiri.'<span class="pengumuman-run-item"><a href="'.get_the_permalink().'">'.wp_filter_nohtml_kses($content).'</a></span>';
			echo $logo_run.'<span class="pengumuman-run-item"><a href="'.get_the_permalink().'">'.wp_filter_nohtml_kses($content).'</a></span>';
		endwhile;
		*/

		// MASUKKAN 10 BBG NEWS
		$catquery = new WP_Query( 'cat=4&posts_per_page=10' );
		while($catquery->have_posts()) : $catquery->the_post();
			$get_content = get_the_title();
			$content = str_replace("<li>"," &bull; ",$get_content);
			//echo $logo_news_kiri.'<span class="news-run-item"><a href="'.get_the_permalink().'">'.wp_filter_nohtml_kses($content).'</a></span>';
			echo $logo_run.'<span class="news-run-item"><a href="'.get_the_permalink().'">'.wp_filter_nohtml_kses($content).'</a></span>';
		endwhile;
	}

	echo '</marquee></div>';
}
add_action('wp_footer', 'manual_show_running_text');
