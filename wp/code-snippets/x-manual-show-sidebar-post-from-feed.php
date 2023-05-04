/////////////////////////////////
// Manual Show Sidebar Post From Feed
/////////////////////////////////

function manual_show_sidebar_post() {
	
	$subdomain = explode('.', $_SERVER['HTTP_HOST'])[0];
	
	$feed_url = 'https://bbg.ac.id/tag/'.$subdomain.'/feed/';
	$more_url = 'https://bbg.ac.id/tag/'.$subdomain.'/';

	$content = file_get_contents($feed_url);
	$a = new SimpleXMLElement($content);	
	
	$items = 3; // set limit HERE
	//$items = count($a->channel->item);
	
	$result = '<div class="et_pb_with_border et_pb_module et_pb_blog_0_tb_body et_pb_blog_grid_wrapper">
	<div class="et_pb_blog_grid clearfix ">
		<div class="et_pb_ajax_pagination_container">
			<div class="et_pb_salvattore_content" data-columns="1">
				<div class="column size-1of1">';
	for($i=0; $i<$items; $i++) {
		$title = $a->channel->item[$i]->title;
		$link = $a->channel->item[$i]->link;
		$date = $a->channel->item[$i]->pubDate;
		$date = date("j F Y", strtotime($date));
		$date = konversi_tanggal_sidebar("j F Y", $date, $bahasa="id");
		$desc = $a->channel->item[$i]->description;
		if(preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $desc, $m)) {$image = $m['src'];}
		else {$image = '/wp-content/placeholder.png';}
		$result .= '<article id="post-'.$i.'" class="et_pb_post clearfix et_pb_blog_item_0_0 post-'.$i.' post type-post status-publish format-standard has-post-thumbnail hentry category-bbg-news">
						<div class="et_pb_image_container"><a href="'.$link.'" class="entry-featured-image-url"><img src="'.$image.'" alt="" class="" width="400" height="250"></a></div> <!-- .et_pb_image_container -->
						<h3 class="entry-title"><a href="'.$link.'" style=" font-family: \'Open Sans Condensed\',Helvetica,Arial,Lucida,sans-serif!important; font-weight: 700!important; color: #ff8200!important; ">'.$title.'</a></h3>
						<p class="post-meta" style=" font-family: \'Open Sans Condensed\',Helvetica,Arial,Lucida,sans-serif; font-size: 16px; "><span class="published">'.$date.'</span></p>
						<div class="post-content"><div class="post-content-inner et_multi_view_hidden"></div></div>
					</article>';
	}
	$result .= '</div>
			</div><!-- .et_pb_salvattore_content -->
		</div>
	</div> <!-- .et_pb_posts --> 
</div>';
	return $result;
} 
add_shortcode('newsfeedsidebar', 'manual_show_sidebar_post');

function konversi_tanggal_sidebar($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
