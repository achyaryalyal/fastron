////////////////////////////////////////////
// WPJSON Announcement Web Parent
////////////////////////////////////////////

function wpjan($atts = [], $content = null, $tag = '') {
	// normalize attribute keys, lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
	
	// override default attributes with user attributes
    $my_atts = shortcode_atts(
		array(
			'limit' => 'WordPress.org',
		), $atts, $tag
	);
	$limit = esc_html__($my_atts['limit'], 'wpjson_announcement');
	$limit = str_replace(' ', '', $limit);
	
	$items = 3; // set limit HERE
	$id_category_announcement_parent = 70;
	$id_category_announcement_child = 1;
	
	$url_1 = "https://bbg.ac.id/wp-json/wp/v2/posts?categories=".$id_category_announcement_parent."&per_page=".$items;
	$json_1 = file_get_contents($url_1);
	$arr_1 = json_decode($json_1, FALSE);
	
	$url_2 = "https://baa.bbg.ac.id/wp-json/wp/v2/posts?categories=".$id_category_announcement_child."&per_page=".$items;
	$json_2 = file_get_contents($url_2);
	$arr_2 = json_decode($json_2, FALSE);
	
	$url_3 = "https://buk.bbg.ac.id/wp-json/wp/v2/posts?categories=".$id_category_announcement_child."&per_page=".$items;
	$json_3 = file_get_contents($url_3);
	$arr_3 = json_decode($json_3, FALSE);
	
	$url_4 = "https://btik.bbg.ac.id/wp-json/wp/v2/posts?categories=".$id_category_announcement_child."&per_page=".$items;
	$json_4 = file_get_contents($url_4);
	$arr_4 = json_decode($json_4, FALSE);
	
	$url_5 = "https://birmas.bbg.ac.id/wp-json/wp/v2/posts?categories=".$id_category_announcement_child."&per_page=".$items;
	$json_5 = file_get_contents($url_5);
	$arr_5 = json_decode($json_5, FALSE);
	
	$total_items = $items * 5;
	$arr = array_merge($arr_1, $arr_2, $arr_3, $arr_4, $arr_5);
	
	$arr_sort_date = array_column($arr, 'date');
	array_multisort($arr_sort_date, SORT_DESC, $arr);
	
	$result = '<h2 style="color:#2f2a95;text-align:center;font-family:\'Open Sans Condensed\',sans-serif;font-weight:bold;padding-bottom:20px;margin:0px;">Pengumuman</h2>
		<ul style="border-radius:4px;border:2px solid #eee;padding:0;">';
	for($i=0; $i<$total_items; $i++) {
		$x = $i + 1;
		if(isset($arr[$i]->title->rendered) && $x<=$limit) {
			$j = $i + 1;
			$title = $arr[$i]->title->rendered;
			$link = $arr[$i]->link;
			$subdomain = parse_url($link); $subdomain = $subdomain['host'];
			$date = $arr[$i]->date;
			$date_converted = date("j F Y", strtotime($date));
			$date_converted = wpjcan_konversi_tanggal("j F Y", $date_converted, $bahasa="id");
			$result .= '<li class="list_pengumuman"><h3 class="font-osc" style="color:#337ab7;font-size:14px;font-weight:600;line-height:18px;margin:0;padding:4px 0;"><a href="'.$link.'" target="_blank">'.$title.'</a></h3><p class="post-meta" style="font-family:Arimo,sans-serif;font-size:10px;margin:1px;padding:0;"><span class="tie-date" style="color:#444;font-size:11px;"><i class="fa fa-calendar-alt"></i> '.$date_converted.' <i class="fa fa-id-card-alt" style="padding-left:6px;"></i> '.$subdomain.'</span></p></li>';
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
	background: #fafdfd;
	background: -moz-linear-gradient(-50deg, #fafdfd 0%, #98f4fe 51%, #79d5f8 75%);
	background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#fafdfd), color-stop(51%,#98f4fe), color-stop(75%,#79d5f8));
	background: -webkit-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%);
	background: -o-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%);
	background: -ms-linear-gradient(-50deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%);
	background: linear-gradient(135deg, #fafdfd 0%,#98f4fe 51%,#79d5f8 75%);
	text-align:left;border-bottom:1px solid #eaeaea;padding:3px 0 10px 5px;line-height:18px;overflow:hidden;
}
</style>';
	return $result;
} 
add_shortcode('wpjson_announcement', 'wpjan'); // [wpjson_announcement limit="5"]

function wpjcan_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
