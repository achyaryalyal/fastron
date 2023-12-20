/////////////////////////////////
// WPJSON Homepage PENGUMUMAN
/////////////////////////////////

function wpjhpe() {
	$start_time = microtime(true);
	//////////////////////////
	$limit = 5; // SET UP HERE
	//////////////////////////
	
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	$subdomain_file_lembaga = 'file.'.$domain_parent; // SET UP HERE
	$more_url = 'https://'.$domain_parent.'/pengumuman';
	$header_mode = 'text'; // SET UP HERE: text or image
	$header_text = 'Pengumuman'; // SET UP HERE
	$header_image = 'https://bbg.ac.id/wp-content/uploads/2023/08/BBG-ANNOUNCEMENTS-100.png'; // SET UP HERE
	$header_image_width = 158; // SET UP HERE
	$header_image_height = 20; // SET UP HERE
	
	$items = 3; // SET UP HERE
	$id_category_announcement_parent = 70;
	$id_category_announcement_child = 1;
	$url_1 = 'https://'.$domain_parent.'/wp-json/wp/v2/posts?categories='.$id_category_announcement_parent.'&per_page='.$items;
	
	$subdomain_child = 'baa'; // SET UP HERE
	$url_2 = 'https://'.$subdomain_child.'.'.$domain_parent.'/wp-json/wp/v2/posts?categories='.$id_category_announcement_child.'&per_page='.$items;
	
	$subdomain_child = 'buk'; // SET UP HERE
	$url_3 = 'https://'.$subdomain_child.'.'.$domain_parent.'/wp-json/wp/v2/posts?categories='.$id_category_announcement_child.'&per_page='.$items;
	
	$subdomain_child = 'btik'; // SET UP HERE
	$url_4 = 'https://'.$subdomain_child.'.'.$domain_parent.'/wp-json/wp/v2/posts?categories='.$id_category_announcement_child.'&per_page='.$items;
	
	$subdomain_child = 'birmas'; // SET UP HERE
	$url_5 = 'https://'.$subdomain_child.'.'.$domain_parent.'/wp-json/wp/v2/posts?categories='.$id_category_announcement_child.'&per_page='.$items;
	
	// Multi handle asynchronously
	$urls = [$url_1, $url_2, $url_3, $url_4, $url_5];
	$mh = curl_multi_init();
	$requests = [];
	foreach($urls as $i => $url) {
		$requests[$i] = curl_init($url);
		curl_setopt($requests[$i], CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($requests[$i], CURLOPT_TIMEOUT, 10);
		curl_setopt($requests[$i], CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($requests[$i], CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($requests[$i], CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_multi_add_handle($mh, $requests[$i]);
	}
	$active = NULL;
	do {curl_multi_exec($mh, $active);}
	while($active);
	$response = [];
	foreach($requests as $request) {
		$response[] = curl_multi_getcontent($request);
		curl_multi_remove_handle($mh, $request);
		curl_close($request);
	}
	curl_multi_close($mh);
	$total_items = 0;
	$arr = array();
	foreach($response as $k => $v) {
		$json = json_decode($v, FALSE);
		$total_items += count($json);
		$arr = array_merge($arr, $json);
	}
	$arr_sort_date = array_column($arr, 'date');
	array_multisort($arr_sort_date, SORT_DESC, $arr);
	
	if($header_mode=='text') {
		$result = '<div class="wpjhpe-title">
						<div class="wpjhpe-title-left">
							<div class="wpjhpe-section-title">
								<h2><span>'.$header_text.'</span></h2>
							</div>
						</div>
						<div class="wpjhpe-title-right">
							<a href="'.$more_url.'">LIHAT '.strtoupper($header_text).' LAINNYA <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#0F5D9B" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><line x1="40" y1="128" x2="216" y2="128" fill="none" stroke="#0F5D9B" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><polyline points="144 56 216 128 144 200" fill="none" stroke="#0F5D9B" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline></svg></a>
						</div>
					</div>';
	}
	else {
		$result = '<h2 style="margin:0px;padding-bottom:20px;text-align:center;"><img width="'.$header_image_width.'" height="'.$header_image_height.'" src="'.$header_image.'" alt="'.$header_text.'" class="wp-image-12694"></h2>';
	}
	$result .= '<ul class="wpjhpe-content">';
	$date_today = date('Y-m-d');
	for($i=0; $i<$total_items; $i++) {
		$x = $i + 1;
		if(isset($arr[$i]->title->rendered) && $x<=$limit) {
			$j = $i + 1;
			$title = strtoupper($arr[$i]->title->rendered);
			$title = str_replace(array('&nbsp; ', ' &nbsp;'), ' ', $title);
			$title = preg_replace('/\s+/', ' ', $title); // remove multiple whitespaces
			$link = $arr[$i]->link;
			$subdomain = parse_url($link); $subdomain = $subdomain['host'];
			if($subdomain==$domain_parent) {
				$print_user = 'Rektorat';
			}
			else {
				$user = explode('.', $subdomain);
				$print_user = strtoupper($user[0]);
			}
			$date = $arr[$i]->date;
			$date_strtotime = strtotime($date);
			if($date_strtotime >= $date_today) {
				$print_title = $title.' <span class="wpjhpe-new">NEW</span>';
			}
			else {
				$print_title = $title;
			}
			$date_converted = date("j F Y", $date_strtotime);
			$date_converted = wpjhpe_konversi_tanggal("j F Y", $date_converted, $bahasa="id");
			$result .= '<li class="wpjhpe-list"><h3><a href="'.$link.'" target="_blank">'.$print_title.'</a></h3><p><i class="fas fa-calendar-alt"></i> '.$date_converted.' <i class="fas fa-bullhorn pl-6"></i> '.$print_user.' <i class="fas fa-globe pl-6"></i> '.$subdomain.'</p></li>';
		}
	}
	$result .= '</ul>
	<style>
	.wpjhpe-title{margin-bottom:20px}
	.wpjhpe-title .wpjhpe-title-right{float:right}
	.wpjhpe-title .wpjhpe-title-left,.wpjhpe-title .wpjhpe-title-right{width:50%;position:relative;display:inline-block}
	.wpjhpe-title .wpjhpe-title-left .wpjhpe-section-title h2{font-size:38px;margin-bottom:0;line-height:1.3;position:relative;font-weight:700;margin-top:0;color:#0a528b;letter-spacing:.15px;padding-bottom:0}
	.wpjhpe-title .wpjhpe-title-left .wpjhpe-section-title h2:after{content:"";display:block;width:100%;height:2px;background-color:#ecd53c;position:absolute;top:50%;left:0;transform:translateY(-50%);z-index:0}
	.wpjhpe-title .wpjhpe-title-left .wpjhpe-section-title h2 span{display:inline;padding-right:8px;position:relative;z-index:3;background-color:#e5f4ff}
	.wpjhpe-title .wpjhpe-title-right{text-align:right}
	.wpjhpe-title .wpjhpe-title-right a{margin-top:0;background-color:transparent;color:#0a528b;padding:4px 0 0;border:0;border-bottom:10px solid #ecd53c;display:inline-flex;align-items:center;gap:7px;font-size:13px;font-weight:500}
	.wpjhpe-title .wpjhpe-title-right a:hover{color:orange!important;}
	.wpjhpe-title .wpjhpe-title-right a svg{color:#0a528b;width:16px;height:16px}
	@media only screen and (max-width:570px){
		.wpjhpe-title-left{width:100%!important;}
		.wpjhpe-title-right{display:none!important;}
	}
	.wpjhpe-content{border:1px solid #c3ced9;margin-bottom:20px;padding:0 !important;}
	.wpjhpe-content .wpjhpe-list{background:#fff;border-bottom:1px solid #c3ced9;overflow:hidden;padding:8px 10px;text-align:left;}
	.wpjhpe-content .wpjhpe-list h3{color:#0F5D9B;font-size:17px;font-weight:600;line-height:1.2!important;margin:0;padding:10px 10px 5px!important;}
	.wpjhpe-content .wpjhpe-list h3 a:hover{color:orange!important;}
	.wpjhpe-content .wpjhpe-list h3 a .wpjhpe-new{background:orange;color:#fff;font-size:13px;font-weight:400;padding:1px 3px;margin-left:3px;}
	.wpjhpe-content .wpjhpe-list p{color:#7a8a99;font-size:13px;line-height:1.6!important;margin:0;padding:0 10px 5px!important;}
	.wpjhpe-content .wpjhpe-list p i{padding-right:2px;}
	.wpjhpe-content .wpjhpe-list p i.pl-6{padding-left:6px;}
	</style>';
	//$result .= '<span style="color:#E5F4FF;">'.number_format(microtime(true) - $start_time, 2).'sec</span>';
	return $result;
} 
add_shortcode('wpjson_homepage_pengumuman', 'wpjhpe');

function wpjhpe_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
