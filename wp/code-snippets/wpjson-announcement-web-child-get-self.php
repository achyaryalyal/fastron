////////////////////////////////////////////
// WPJSON Announcement Web Child GET_SELF
////////////////////////////////////////////

function wpjan_get_self() {
	$limit = 7; // SET UP HERE
	$subdomain_child = 'baa'; // SET UP HERE
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	
	$items = $limit;
	$id_category_announcement_child = 1;
	$url = 'https://'.$subdomain_child.'.'.$domain_parent.'/wp-json/wp/v2/posts?categories='.$id_category_announcement_child.'&per_page='.$items;
	$json = file_get_contents($url);
	$arr = json_decode($json, FALSE);
	
	$result = '<h2 style="color:#2f2a95;text-align:center;font-family:\'Roboto Condensed\',\'Open Sans Condensed\',sans-serif;font-weight:bold;padding-bottom:20px;margin:0px;">Pengumuman</h2>
		<ul style="border-radius:4px;border:2px solid #eee;padding:0;">';
	for($i=0; $i<$items; $i++) {
		$x = $i + 1;
		if(isset($arr[$i]->title->rendered) && $x<=$limit) {
			$j = $i + 1;
			$title = $arr[$i]->title->rendered;
			$link = $arr[$i]->link;
			$subdomain = parse_url($link); $subdomain = $subdomain['host'];
			$date = $arr[$i]->date;
			$date_converted = date("j F Y", strtotime($date));
			$date_converted = wpjan_get_self_konversi_tanggal("j F Y", $date_converted, $bahasa="id");
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
add_shortcode('wpjson_announcement_get_self', 'wpjan_get_self');

function wpjan_get_self_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
