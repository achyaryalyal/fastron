/////////////////////////////////
// WPJSON Sidebar AGENDA
/////////////////////////////////

function wpjsa() {
	//////////////////////////
	$limit = 5; // SET UP HERE
	//////////////////////////
	
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	$sidebar_title = 'Agenda Terbaru'; // SET UP HERE
	$json_call_object = 'event'; // SET UP HERE
	$json_url = 'https://opensimka.'.$domain_parent.'/json/'.$json_call_object.'/'.$limit; // SET UP HERE
	$more_url = 'https://'.$domain_parent.'/event';
	
	$json = file_get_contents($json_url);
	$arr = json_decode($json, TRUE);
	$tgl_today = date('Y-m-d');
	
	$result = '<div class="wpjsa">
		<div class="wpjsa-header">
			<h3 class="wpjsa-title">'.$sidebar_title.'</h3>
		</div>
		<ul class="wpjsa-post-content">';
	foreach($arr['event'] as $key => $value) {
		$id_event = $value['id_event'];
		$nm_event = $value['nm_event'];
		$tgl_start = $value['tgl_start'];
        $tgl_start_date_only = substr($tgl_start, 0, 10);
		$tgl_start_date_only_angka_tanggal = substr($tgl_start_date_only, 8, 2);
		$print_bulan_singkat = wpjsa_konversi_tanggal($format='F', $tgl_start, $bahasa="id_singkat");
		if($tgl_start_date_only >= $tgl_today) {
			$nm_event = $nm_event.' <span class="wpjsa-new">NEW</span>';
		}
		
        $link = $more_url;
		
		$result .= '<li>
			<a class="wpjsa-post-link" href="'.$link.'" onclick="lolay()">
				<span class="event-date">'.$tgl_start_date_only_angka_tanggal.'<strong>'.$print_bulan_singkat.'</strong></span>
				<span class="event-title">'.$nm_event.'</span>
			</a>
		</li>';
	}
	$result .= '</ul>
	</div>
	<style>
	.wpjsa{margin-bottom:40px;position:relative;}
	.wpjsa-header{border-bottom:1px solid #E6E6E6;margin-bottom:20px;}
	.wpjsa-title{font-size:24px !important;font-weight:700;color:#0A528B;margin-top:0;margin-bottom:-1px!important;border-bottom:1px solid #ECD53C;padding-bottom:12px;display:inline-block;line-height:1.2;}
	.wpjsa-post-content{padding:0!important;margin-bottom:0;list-style:none!important;}
	.wpjsa-post-content li{border-bottom:1px solid #E6E6E6;padding-bottom:10px;margin-bottom:10px;}
	.wpjsa-post-link{text-decoration:none;font-size:15px;display:block;line-height:1.4;margin-bottom:0;}
	.wpjsa-post-link span.event-date{display:table-cell;vertical-align:middle;font-size:40px;font-weight:700;color:#0F5D9B;text-align:center;width:50px!important;line-height:1.2;}
	.wpjsa-post-link span.event-date strong{display:block;font-size:14px;color:#666;font-weight:700;text-transform:uppercase;}
	.wpjsa-post-link span.event-title{display:table-cell;vertical-align:middle;padding-left:8px;border-left:1px solid #E6E6E6;color:#0F5D9B;font-weight:600;}
	.wpjsa-post-link span.event-title:hover{color:orange!important;}
	.wpjsa-post-link span.event-title .wpjsa-new{background:orange;color:#fff;font-size:13px;font-weight:400;padding:1px 3px;margin-left:3px;}
	</style>';
	return $result;
}
add_shortcode('wpjson_sidebar_agenda', 'wpjsa');

function wpjsa_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
