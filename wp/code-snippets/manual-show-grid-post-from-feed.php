/////////////////////////////////
// Manual Show Grid Post From Feed
/////////////////////////////////

function manual_show_grid_post() {
	
	$subdomain = explode('.', $_SERVER['HTTP_HOST'])[0];
	
	$feed_url = 'https://bbg.ac.id/tag/'.$subdomain.'/feed/';
	$more_url = 'https://bbg.ac.id/tag/'.$subdomain.'/';

	$content = file_get_contents($feed_url);
	$a = new SimpleXMLElement($content);	
	
	$items = 4; // set limit HERE
	//$items = count($a->channel->item);
	
	$result = '<div id="pcp_wrapper-91" class="sp-pcp-section sp-pcp-container pcp-wrapper-91">
	<div class="sp-pcp-row">';
	for($i=0; $i<$items; $i++) {
		$title = $a->channel->item[$i]->title;
		$link = $a->channel->item[$i]->link;
		$date = $a->channel->item[$i]->pubDate;
		$date = date("j F Y", strtotime($date));
		$date = konversi_tanggal("j F Y", $date, $bahasa="id");
		$desc = $a->channel->item[$i]->description;
		if(preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $desc, $m)) {$image = $m['src'];}
		else {$image = '/wp-content/placeholder.png';}
		$result .= '<div class=" sp-pcp-col-xs-2 sp-pcp-col-sm-2 sp-pcp-col-md-4 sp-pcp-col-lg-4 sp-pcp-col-xl-4">
			<div class="sp-pcp-post pcp-item-88" data-id="88">
				<div class="pcp-post-thumb-wrapper">
					<div class="sp-pcp-post-thumb-area">
						<a class="sp-pcp-thumb" href="'.$link.'" target="_blank">
							<img src="'.$image.'" width="400" height="250" alt="">
						</a>
					</div>
				</div>
				<h2 class="sp-pcp-title"><a href="'.$link.'" target="_blank">'.$title.'</a></h2>
				<div class="sp-pcp-post-meta">
					<ul><li><i class="fa fa-calendar"></i> <time class="entry-date published updated">'.$date.'</time></li></ul>
				</div>
			</div>
		</div>';
	}
	$result .= '</div>
	<span class="sp-pcp-pagination-data" style="display:none;" data-loadmoretext="" data-endingtext=""></span>
	<nav class="pcp-post-pagination pcp-on-desktop "></nav>
	<nav class="pcp-post-pagination pcp-on-mobile "></nav>
	</div>
	<div class="et_pb_button_module_wrapper et_pb_button_0_tb_body_wrapper et_pb_button_alignment_center et_pb_button_alignment_tablet_center et_pb_button_alignment_phone_center et_pb_module" style="margin-top:-40px !important;text-align:center;">
				<a class="et_pb_button et_pb_button_0_tb_body et_pb_bg_layout_dark" href="'.$more_url.'" target="_blank" style="background:#ff8200;font-size:16px;">Berita Lainnya</a>
			</div>';
	return $result;
} 
add_shortcode('newsfeed', 'manual_show_grid_post');

function konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
