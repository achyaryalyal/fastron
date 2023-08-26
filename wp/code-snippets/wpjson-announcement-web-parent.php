////////////////////////////////////////////
// WPJSON Announcement Web Parent (Multi Handle Asynchronously)
////////////////////////////////////////////

function wpjan() {
	$limit = 5; // SET UP HERE
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	$subdomain_file_lembaga = 'file.'.$domain_parent; // SET UP HERE
	$link_image_title = 'https://bbg.ac.id/wp-content/uploads/2023/08/BBG-ANNOUNCEMENTS-100.png'; // SET UP HERE
	$image_width = 158; // SET UP HERE
	$image_height = 20; // SET UP HERE
	
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
	
	/* $result = '<h2 style="color:#2f2a95;text-align:center;font-family:\'Roboto Condensed\',\'Open Sans Condensed\',sans-serif;font-weight:bold;padding-bottom:20px;margin:0px;">Pengumuman</h2> */
	$result = '<h2 style="margin:0px;padding-bottom:20px;text-align:center;"><img decoding="async" loading="lazy" width="'.$image_width.'" height="'.$image_height.'" src="'.$link_image_title.'" alt="Pengumuman" title="Pengumuman" class="wp-image-12694"></h2>
		<ul style="border-radius:4px;border:2px solid #eee;padding:0;">';
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
			$date = $arr[$i]->date;
			$date_strtotime = strtotime($date);
			if($date_strtotime >= $date_today) {
				$print_title = $title.' <img src="https://'.$subdomain_file_lembaga.'/assets/img/icon/new.gif" alt="new">';
			}
			else {
				$print_title = $title;
			}
			$date_converted = date("j F Y", $date_strtotime);
			$date_converted = wpjan_konversi_tanggal("j F Y", $date_converted, $bahasa="id");
			$result .= '<li class="list_pengumuman"><h3 class="font-osc"><a href="'.$link.'" target="_blank">'.$print_title.'</a></h3><p><span><i class="fa fa-calendar-alt"></i> '.$date_converted.' <i class="fa fa-id-card-alt p-l-6"></i> '.$subdomain.'</span></p></li>';
		}
	}
	$result .= '</ul>
<style>
.list_pengumuman {
	background: linear-gradient(140deg, #fafdfd 0%, #98f4fe 51%, #79d5f8 75%);
	background: #fafdfd;
	background: -moz-linear-gradient(-50deg, #fafdfd 0%, #98f4fe 51%, #79d5f8 75%);
	background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#fafdfd), color-stop(51%,#98f4fe), color-stop(75%,#79d5f8));
	background: -webkit-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%);
	background: -o-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%);
	background: -ms-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%);
	background: linear-gradient(135deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%);
	text-align:left;border-bottom:1px solid #eaeaea;padding:3px 0 10px 5px;line-height:18px;overflow:hidden;
}
.list_pengumuman h3 {color:#337ab7;font-size:14px;font-weight:600;line-height:18px;margin:0;padding:4px 0;}
.list_pengumuman p {font-family:Arimo,sans-serif;font-size:10px;margin:1px;padding:0;}
.list_pengumuman p span {color:#444;font-size:11px;}
.list_pengumuman p span i.p-l-6 {padding-left:6px;}
</style>';
	return $result;
} 
add_shortcode('wpjson_announcement', 'wpjan');

function wpjan_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
