/////////////////////////////////
// WPJSON Event
/////////////////////////////////

function wpjev() {
	$limit = 4; // SET UP HERE
	$domain = 'bbg.ac.id'; // SET UP HERE
	$subdomain_file_lembaga = 'file.'.$domain;
	$object = 'event'; // SET UP HERE
	$url = 'https://opensimka.bbg.ac.id/json/'.$object.'/'.$limit; // SET UP HERE
	
	$json = file_get_contents($url);
	$arr = json_decode($json, TRUE);
	$tgl_today = date('Y-m-d');
	$result = '<ul class="wpjev">';
	foreach($arr['event'] as $key => $value) {
	    $id_event = $value['id_event'];
		$nm_event = $value['nm_event'];
		$tgl_start = $value['tgl_start'];
        $tgl_start_date_only = substr($tgl_start, 0, 10);
        $print_tgl_start = wpjev_konversi_tanggal($format='l, j F Y | H:i', $tgl_start, $bahasa="id");
		$print_tgl_start = '<i class="fa fa-calendar-alt"></i> '.str_replace('|', '<i class="fa fa-clock"></i> ', $print_tgl_start).' WIB';
		$tgl_stop = $value['tgl_stop'];
        $print_tgl_stop = wpjev_konversi_tanggal($format='l, j F Y', $tgl_stop, $bahasa="id");
        $tempat = $value['tempat'];
        $penyelenggara = $value['penyelenggara'];
		
        $result .= '<li class="wpjev-list">';
        $result .= '<h3>'.strtoupper($nm_event);
        if($tgl_start_date_only >= $tgl_today) {$result .= ' <img src="https://'.$subdomain_file_lembaga.'/assets/img/icon/new.gif" alt="new">';}
        $result .= '</h3>';
        $result .= '<p>';
        if($tgl_start_date_only==$tgl_stop) {
            $result .= $print_tgl_start;
        }
        else {
            if($tgl_stop=='0000-00-00' || $tgl_stop=='1970-01-01') {
                $result .= $print_tgl_start;
            }
            else {
                $result .= $print_tgl_start.' <small class="font-boldest text-muted">s.d.</small> '.$print_tgl_stop;
            }
        }
        $result .= '&nbsp; <i class="fa fa-map-marker-alt wpjev-p-r-2"></i> '.$tempat.'&nbsp; <i class="fa fa-id-card-alt p-r-2"></i> Diselenggarakan oleh '.$penyelenggara.'</p></li>';
	}
	$result .= '</ul>
	<style>
	.wpjev {border-radius:4px;border:2px solid #eee;padding:0 !important;}
	.wpjev-list {
		background:#fef5c8;
		background:linear-gradient(140deg, #fef5c8 0%, #fcefc7 51%, #ffd983 75%);
		background:-moz-linear-gradient(-50deg, #fef5c8 0%, #fcefc7 51%, #ffd983 75%);
		background:-webkit-gradient(linear, left top, right bottom, color-stop(0%,#fef5c8), color-stop(51%,#fcefc7), color-stop(75%,#ffd983));
		background:-webkit-linear-gradient(-50deg, #fef5c8 0%,#fcefc7 51%,#ffd983 75%);
		background:-o-linear-gradient(-50deg, #fef5c8 0%,#fcefc7 51%,#ffd983 75%);
		background:-ms-linear-gradient(-50deg, #fef5c8 0%,#fcefc7 51%,#ffd983 75%);
		background:linear-gradient(135deg, #fef5c8 0%,#fcefc7 51%,#ffd983 75%);
		filter:progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#fef5c8\', endColorstr=\'#ffd983\',GradientType=1 );
		border-bottom:1px solid #eaeaea;line-height:16px;overflow:hidden;padding:3px 5px;text-align:left;
    }
	.wpjev-list h3 {color:#b77633;font-size:14px;font-weight:600;line-height:18px;margin:0;}
	.wpjev-list p {font-size:10px;margin:1px;padding:0;color:#444;font-size:11px;}
	.wpjev-list p i.p-r-2 {padding-right:2px;}
    </style>';
	return $result;
}
add_shortcode('wpjson_event', 'wpjev');

function wpjev_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
