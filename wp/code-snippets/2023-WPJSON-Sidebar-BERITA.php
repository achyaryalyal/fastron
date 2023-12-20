/////////////////////////////////
// WPJSON Sidebar BERITA
/////////////////////////////////

function wpjsb() {
	$items = 5; // SET UP HERE
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	$sidebar_title = 'Berita Terbaru'; // SET UP HERE
	$durasi_new = 2880; // 2880 minutes = 2 days
	
	$url = 'https://'.$domain_parent.'/wp-json/wp/v2/posts?per_page='.$items.'&_embed';
	$json = file_get_contents($url);
	$arr = json_decode($json, FALSE);
	$result = '<div class="wpjsb">
		<div class="wpjsb-header">
			<h3 class="wpjsb-title">'.$sidebar_title.'</h3>
		</div>
		<ul class="wpjsb-post-content">';
	$now = date('Y-m-d H:i:s');
	$now_strtotime = strtotime($now);
	for($i=0; $i<$items; $i++) {
		$j = $i + 1;
		$title = $arr[$i]->title->rendered;
		$title = str_replace(array('&nbsp; ', ' &nbsp;'), ' ', $title);
		$title = preg_replace('/\s+/', ' ', $title); // remove multiple whitespaces
		$link = $arr[$i]->link;
		$date = $arr[$i]->date;
		$date_strtotime = strtotime($date);
		$interval = abs($now_strtotime - $date_strtotime);
		$interval = round($interval / 60);
		$date_converted = date("j F Y", $date_strtotime);
		$date_converted = wpjsb_konversi_tanggal("j F Y", $date_converted, $bahasa="id");
		if($interval < $durasi_new) {
			$print_date_converted = $date_converted.' <span class="wpjsb-new">NEW</span>';
		}
		else {
			$print_date_converted = $date_converted;
		}
		$result .= '<li>
			<a class="wpjsb-post-title" href="'.$link.'" onclick="lolay()">'.$title.'</a>
				<div class="wpjsb-entry-meta">
					<span class="meta-date"><i class="fas fa-calendar-alt"></i> <time datetime="'.$date.'">'.$print_date_converted.'</time></span>
				</div>
		</li>';
	}
	$result .= '</ul>
	</div>
	<style>
	.wpjsb{margin-bottom:40px;position:relative;}
	.wpjsb-header{border-bottom:1px solid #e6e6e6;margin-bottom:20px;}
	.wpjsb-title{font-size:24px !important;font-weight:700;color:#0a528b;margin-top:0;margin-bottom:-1px!important;border-bottom:1px solid #ecd53c;padding-bottom:12px;display:inline-block;line-height:1.2;}
	.wpjsb-post-content{padding:0!important;margin-bottom:0;list-style:none!important;}
	.wpjsb-post-content li{border-bottom:1px solid #e6e6e6;padding-bottom:10px;margin-bottom:10px;}
	.wpjsb-new{background:orange;color:#fff;font-size:13px;font-weight:400;padding:1px 3px;margin-left:3px;}
	.wpjsb-post-title{color:#0F5D9B;font-weight:600;text-decoration:none;font-size:15px;display:block;line-height:1.4;margin-bottom:0;}
	.wpjsb-post-title:hover{color:orange !important;}
	.wpjsb-entry-meta .meta-date{font-size:12px;font-weight:500;color:#a6a6a6;display:inline-block;margin-right:6px;}
	</style>';
	return $result;
}
add_shortcode('wpjson_sidebar_berita', 'wpjsb');

function wpjsb_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
