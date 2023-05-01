/////////////////////////////////
// WPJSON Sidebar Web Child
/////////////////////////////////

function wpjs() {
	$limit = 3; // SET UP HERE
	$id_tag_child = 37; // SET UP HERE
	$subdomain_child = 'baa'; // SET UP HERE
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	
	$items = $limit;
	$url_1 = 'https://'.$domain_parent.'/wp-json/wp/v2/posts?tags='.$id_tag_child.'&per_page='.$items.'&_embed';
	$json_1 = file_get_contents($url_1);
	$arr_1 = json_decode($json_1, FALSE);
	$id_category_announcement_child = 1;
	$url_2 = 'https://'.$subdomain_child.'.'.$domain_parent.'/wp-json/wp/v2/posts?categories='.$id_category_announcement_child.'&per_page='.$items.'&_embed';
	$json_2 = file_get_contents($url_2);
	$arr_2 = json_decode($json_2, FALSE);
	$total_items = $items * 2;
	$arr = array_merge($arr_1, $arr_2);
	$arr_sort_date = array_column($arr, 'date');
	array_multisort($arr_sort_date, SORT_DESC, $arr);
	
	$result = '<div class="et_pb_with_border et_pb_module et_pb_blog_0_tb_body et_pb_blog_grid_wrapper et_pb_bg_layout_light">
	<div class="et_pb_blog_grid clearfix">
		<div class="et_pb_ajax_pagination_container">
			<div class="et_pb_salvattore_content" data-columns="1">
				<div class="column size-1of1">';
	for($i=0; $i<$total_items; $i++) {
		$x = $i + 1;
		if(isset($arr[$i]->title->rendered) && $x<=$limit) {
			$j = $i + 1;
			$title = $arr[$i]->title->rendered;
			$link = $arr[$i]->link;
			$date = $arr[$i]->date;
			$date_converted = date("j F Y", strtotime($date));
			$date_converted = wpjs_konversi_tanggal("j F Y", $date_converted, $bahasa="id");
			$image = @$arr[$i]->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->{'et-pb-post-main-image'}->source_url;
			if(!$image) {$image = '/wp-content/featured-400x250.webp';}
      $result .= '<article id="post-'.$i.'" class="et_pb_post clearfix et_pb_blog_item_0_0 post-'.$i.' post type-post status-publish format-standard has-post-thumbnail hentry">
						<div class="et_pb_image_container" style="border:1px solid #d8d8d8;"><a href="'.$link.'" class="entry-featured-image-url"><img decoding="async" loading="lazy" src="'.$image.'" alt="" class="" width="400" height="250"></a></div>
						<h3 class="entry-title"><a href="'.$link.'" style="color:#ff8200;font-size:16px;font-weight:700;">'.$title.'</a></h3>
						<p class="post-meta"><span class="published" style="color:#666;font-size:16px;">'.$date_converted.'</span></p>
						<div class="post-content"><div class="post-content-inner et_multi_view_hidden"></div></div>
					</article>';
		}
	}
	$result .= '</div>
			</div><!-- .et_pb_salvattore_content -->
		</div>
	</div> <!-- .et_pb_posts --> 
</div>';
	return $result;
} 
add_shortcode('wpjson_sidebar', 'wpjs');

function wpjs_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
