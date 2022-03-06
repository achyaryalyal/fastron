/////////////////////////////////
// Manual Show Announcement
/////////////////////////////////

function manual_show_announcement($atts = [], $content = null, $tag = '') {
	// normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
	
	// override default attributes with user attributes
    $my_atts = shortcode_atts(
        array(
            'subdomain' => 'WordPress.org',
        ), $atts, $tag
    );
	
	// set limit
	$limit = 4;
	
	$subdomain = esc_html__( $my_atts['subdomain'], 'pengumuman' ); // library or baa,bauk,bakal
	$subdomain = str_replace(' ', '', $subdomain);
	$print_empty = '<h2 style="color:#2f2a95;text-align:center;font-family:\'Open Sans Condensed\',sans-serif;font-weight:bold;padding-bottom:20px;margin:0px;">Pengumuman '.strtoupper($subdomain).'</h2>
		<ul style="border-radius:4px;border:2px solid #eee;padding:0;">
			<li class="list_pengumuman"><h3 class="font-osc" style="color:#666;font-size:14px;font-weight:600;line-height:18px;margin:0;padding:4px 0;">Belum ada pengumuman</h3></li>';
	
	if(strpos($subdomain, ',') !== false) {
		// ada delimiter koma		
		$rss = new DOMDocument();
		$feed = array();
		$urlarray = array();		
		$explode = explode(',', $subdomain);
		foreach($explode as $key => $sub) {
			$urlarray[] = array(
				'subdomain' => $sub.'.bbg.ac.id',
				'feed_url' => 'https://'.$sub.'.bbg.ac.id/category/pengumuman/feed/',
				'more_url' => 'https://'.$sub.'.bbg.ac.id/category/pengumuman/'
			);
		}
		foreach($urlarray as $url) {
			$rss->load($url['feed_url']);
			foreach($rss->getElementsByTagName('item') as $node) {
				$item = array(
					'subdomain' => $url['subdomain'],
					'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
					'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
					'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
				);
				array_push($feed, $item);
			}
		}
		usort($feed, function($a, $b) {
			return strtotime($b['date']) - strtotime($a['date']);
		});
		$count_items = count($feed);
		if($count_items>0) {
			for($i=0; $i<$limit; $i++ ) {
				$title = $feed[$i]['title'];
				$link = $feed[$i]['link'];
				$subdomain = $feed[$i]['subdomain'];
				$date = $feed[$i]['date'];
				$date = date("j F Y", strtotime($date));
				$date = konversi_tanggal_8355("j F Y", $date, $bahasa="id");
				if($i==0) {
					$result = '<h2 style="color:#2f2a95;text-align:center;font-family:\'Open Sans Condensed\',sans-serif;font-weight:bold;padding-bottom:20px;margin:0px;">Pengumuman Institusi</h2>
				<ul style="border-radius:4px;border:2px solid #eee;padding:0;">';
				}
				if($date!='1 Januari 1970') {
					$result .= '<li class="list_pengumuman"><h3 class="font-osc" style="color:#337ab7;font-size:14px;font-weight:600;line-height:18px;margin:0;padding:4px 0;"><a href="'.$link.'" target="_blank">'.$title.'</a></h3><p class="post-meta" style="font-family:Arimo,sans-serif;font-size:10px;margin:1px;padding:0;"><span class="tie-date" style="color:#444;font-size:11px;"><i class="fa fa-calendar-alt"></i> '.$date.' <i class="fa fa-id-card-alt" style="padding-left:6px;"></i> '.$subdomain.'</span></p></li>';
				}
			}
		}
		else {
			$result = $print_empty;
		}
	}
	else {
		// tidak ada delimiter koma
		$feed_url = 'https://'.$subdomain.'.bbg.ac.id/category/pengumuman/feed/';
		$more_url = 'https://'.$subdomain.'.bbg.ac.id/category/pengumuman/';
		$content = file_get_contents($feed_url);
		$rss = new SimpleXMLElement($content);
		$count_items = count($rss->channel->item);
		if($count_items>0) {
			$result = '<h2 style="color:#2f2a95;text-align:center;font-family:\'Open Sans Condensed\',sans-serif;font-weight:bold;padding-bottom:20px;margin:0px;">Pengumuman '.strtoupper($subdomain).'</h2>
			<ul style="border-radius:4px;border:2px solid #eee;padding:0;">';
			for($i=0; $i<$limit; $i++) {
				$title = $rss->channel->item[$i]->title;
				$link = $rss->channel->item[$i]->link;
				$subdomain = parse_url($link, PHP_URL_HOST);
				$date = $rss->channel->item[$i]->pubDate;
				$date = date("j F Y", strtotime($date));
				$date = konversi_tanggal_8355("j F Y", $date, $bahasa="id");
				$desc = $rss->channel->item[$i]->description;
				if($date!='1 Januari 1970') {
					$result .= '<li class="list_pengumuman"><h3 class="font-osc" style="color:#337ab7;font-size:14px;font-weight:600;line-height:18px;margin:0;padding:4px 0;"><a href="'.$link.'" target="_blank">'.$title.'</a></h3><p class="post-meta" style="font-family:Arimo,sans-serif;font-size:10px;margin:1px;padding:0;"><span class="tie-date" style="color:#444;font-size:11px;"><i class="fa fa-calendar-alt"></i> '.$date.' <i class="fa fa-id-card-alt" style="padding-left:6px;"></i> '.$subdomain.'</span></p></li>';
				}
			}
		}
		else {
			$result = $print_empty;
		}
	}
	$result .= '</ul>
	<style>
	.widget-top-pengumuman {
		background: #00b9ff;
		color: #FFF;
		padding: 7px 10px;
		font-size: 16px;
		font-family: Oswald,serif,arial,Georgia;
		text-transform: uppercase;
		line-height: 1;
		text-shadow: 0px 0px 2px #999;
	}
	.list_pengumuman {
		background: linear-gradient(140deg, #fafdfd 0%, #98f4fe 51%, #79d5f8 75%);
		background: #fafdfd; /* Old browsers */
		background: -moz-linear-gradient(-50deg, #fafdfd 0%, #98f4fe 51%, #79d5f8 75%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#fafdfd), color-stop(51%,#98f4fe), color-stop(75%,#79d5f8)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%); /* Opera 11.10+ */
		background: -ms-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%); /* IE10+ */
		background: linear-gradient(135deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#fafdfd\', endColorstr=\'#79d5f8\',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
		text-align:left;border-bottom:1px solid #eaeaea;padding:3px 0 10px 5px;line-height:18px;overflow:hidden;
	}
	</style>';
	return $result;
}
add_shortcode('pengumuman', 'manual_show_announcement'); // [pengumuman subdomain="library"] or [pengumuman subdomain="baa,bauk,bakal"]

function konversi_tanggal_8355($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
