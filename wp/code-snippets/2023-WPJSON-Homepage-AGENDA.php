/////////////////////////////////
// WPJSON Homepage AGENDA
/////////////////////////////////

function wpjhag() {
	$start_time = microtime(true);
	//////////////////////////
	$limit = 4; // SET UP HERE
	//////////////////////////
	
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	$subdomain_file_lembaga = 'file.'.$domain_parent;
	$json_call_object = 'event'; // SET UP HERE
	$json_url = 'https://opensimka.'.$domain_parent.'/json/'.$json_call_object.'/'.$limit; // SET UP HERE
	$more_url = 'https://'.$domain_parent.'/event';
	$header_mode = 'text'; // SET UP HERE: text or image
	$header_text = 'Agenda'; // SET UP HERE
	$header_image = 'https://bbg.ac.id/wp-content/uploads/2023/08/BBG-EVENTS-100.png'; // SET UP HERE
	$header_image_width = 117; // SET UP HERE
	$header_image_height = 20; // SET UP HERE
	
	$json = file_get_contents($json_url);
	$arr = json_decode($json, TRUE);
	$tgl_today = date('Y-m-d');
	
	if($header_mode=='text') {
		$result = '<div class="wpjhag-title">
						<div class="wpjhag-title-left">
							<div class="wpjhag-section-title">
								<h2><span>'.$header_text.'</span></h2>
							</div>
						</div>
						<div class="wpjhag-title-right">
							<a href="'.$more_url.'" onclick="lolay()">LIHAT '.strtoupper($header_text).' LAINNYA <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#0F5D9B" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><line x1="40" y1="128" x2="216" y2="128" fill="none" stroke="#0F5D9B" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><polyline points="144 56 216 128 144 200" fill="none" stroke="#0F5D9B" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline></svg></a>
						</div>
					</div>';
	}
	else {
		$result = '<h2 style="margin:0px;padding-bottom:20px;text-align:center;"><img width="'.$header_image_width.'" height="'.$header_image_height.'" src="'.$header_image.'" alt="'.$header_text.'" class="wp-image-12694"></h2>';
	}
	$result .= '<ul class="wpjhag-content">';
	foreach($arr['event'] as $key => $value) {
	    $id_event = $value['id_event'];
		$nm_event = $value['nm_event'];
		$tgl_start = $value['tgl_start'];
        $tgl_start_date_only = substr($tgl_start, 0, 10);
		$tgl_start_date_only_angka_tanggal = substr($tgl_start_date_only, 8, 2);
		$print_bulan_singkat = wpjhag_konversi_tanggal($format='F', $tgl_start, $bahasa="id_singkat");
        $print_tgl_start = wpjhag_konversi_tanggal($format='l, j F Y | H:i', $tgl_start, $bahasa="id");
		$print_tgl_start = '<i class="fa fa-calendar-alt"></i> '.str_replace('|', '<i class="fa fa-clock pl-6"></i> ', $print_tgl_start).' WIB';
		$tgl_stop = $value['tgl_stop'];
        $print_tgl_stop = wpjhag_konversi_tanggal($format='l, j F Y', $tgl_stop, $bahasa="id");
        $tempat = $value['tempat'];
        $penyelenggara = $value['penyelenggara'];
		
		$link = $more_url;
		
        $result .= '<li class="wpjhag-list">';
		$result .= '<span class="wpjhag-date-left">
                        <span class="wpjhag-date-left-date">'.$tgl_start_date_only_angka_tanggal.'</span>
						<span class="wpjhag-date-left-month">'.$print_bulan_singkat.'</span>
        </span>
		<span class="wpjhag-info"><h3><a href="'.$link.'" onclick="lolay()">'.strtoupper($nm_event);
        if($tgl_start_date_only >= $tgl_today) {$result .= ' <span class="wpjhag-new">NEW</span>';}
        $result .= '</a></h3></span>';
		$result .= '<span class="wpjhag-info"><p>';
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
        //$result .= '<i class="fas fa-map-marker-alt pl-6"></i> '.$tempat.' <i class="fas fa-id-card-alt pl-6"></i> Diselenggarakan oleh '.$penyelenggara.'</p><span></li>';
		$result .= ' <br> <i class="fas fa-map-marker-alt pl-1"></i> '.$tempat.'</p><span></li>';
	}
	$result .= '</ul>
	<style>
	.wpjhag-title{margin-bottom:20px}
	.wpjhag-title .wpjhag-title-right{float:right}
	.wpjhag-title .wpjhag-title-left,.wpjhag-title .wpjhag-title-right{width:50%;position:relative;display:inline-block}
	.wpjhag-title .wpjhag-title-left .wpjhag-section-title h2{font-size:38px;margin-bottom:0;line-height:1.3;position:relative;font-weight:700;margin-top:0;color:#0a528b;letter-spacing:.15px;padding-bottom:0}
	.wpjhag-title .wpjhag-title-left .wpjhag-section-title h2:after{content:"";display:block;width:100%;height:2px;background-color:#ecd53c;position:absolute;top:50%;left:0;transform:translateY(-50%);z-index:0}
	.wpjhag-title .wpjhag-title-left .wpjhag-section-title h2 span{display:inline;padding-right:8px;position:relative;z-index:3;background-color:#e5f4ff}
	.wpjhag-title .wpjhag-title-right{text-align:right}
	.wpjhag-title .wpjhag-title-right a{margin-top:0;background-color:transparent;color:#0a528b;padding:4px 0 0;border:0;border-bottom:10px solid #ecd53c;display:inline-flex;align-items:center;gap:7px;font-size:13px;font-weight:500}
	.wpjhag-title .wpjhag-title-right a:hover{color:orange!important;}
	.wpjhag-title .wpjhag-title-right a svg{color:#0a528b;width:16px;height:16px}
	@media only screen and (max-width:400px){
		.wpjhag-title-left{width:100%!important;}
		.wpjhag-title-right{display:none!important;}
	}
	.wpjhag-content{border:1px solid #c3ced9;margin-bottom:20px;padding:0!important;}
	.wpjhag-content .wpjhag-list{background:#fff;border-bottom:1px solid #c3ced9;overflow:hidden;padding:8px 10px;text-align:left;}
	.wpjhag-content .wpjhag-list .wpjhag-date-left{position:relative;background-color:#0A528B;width:70px;height:70px;top:-8px;left:-10px;display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;float:left;}
	.wpjhag-content .wpjhag-list .wpjhag-date-left .wpjhag-date-left-date{font-weight:700;font-size:28px;line-height:30px;text-align:center;letter-spacing:0.15px;}
	.wpjhag-content .wpjhag-list .wpjhag-date-left wpjhag-date-left-month{}
	.wpjhag-content .wpjhag-list .wpjhag-info{padding:0 0 0 0;display:flex;}
	.wpjhag-content .wpjhag-list .wpjhag-info h3 a:hover{color:orange!important;}
	.wpjhag-content .wpjhag-list h3{color:#0F5D9B;font-size:17px;font-weight:600;line-height:1.2!important;margin:0;padding:10px 10px 5px!important;}
	.wpjhag-content .wpjhag-list h3 .wpjhag-new{background:orange;color:#fff;font-size:13px;font-weight:400;padding:1px 3px;margin-left:3px;}
	.wpjhag-content .wpjhag-list p{color:#7a8a99;font-size:13px;line-height:1.6!important;margin:0;padding:0 10px 5px!important;}
	.wpjhag-content .wpjhag-list p i{padding-right:2px;}
	.wpjhag-content .wpjhag-list p i.pl-1{padding-left:1px;}
	.wpjhag-content .wpjhag-list p i.pl-6{padding-left:6px;}
    </style>';
	//$result .= '<span style="color:#E5F4FF;">'.number_format(microtime(true) - $start_time, 2).'sec</span>';
	return $result;
}
add_shortcode('wpjson_homepage_agenda', 'wpjhag');

function wpjhag_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}
