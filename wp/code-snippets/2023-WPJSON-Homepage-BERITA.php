/////////////////////////////////
// WPJSON Homepage BERITA
/////////////////////////////////

function wpjhb() {
	$start_time = microtime(true);
	//////////////////////////
	$limit = 6; // SET UP HERE
	$force_webp_thumbnail = TRUE; // SET UP HERE
	//////////////////////////
	
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	$durasi_new = 2880; // 2880 minutes = 2 days
	$more_url = 'https://'.$domain_parent.'/category/bbg-news';
	$header_mode = 'text'; // SET UP HERE: text or image
	$header_text = 'Berita'; // SET UP HERE
	$header_image = 'https://bbg.ac.id/wp-content/uploads/2023/08/BBG-NEWS-100.png'; // SET UP HERE
	$header_image_width = 100; // SET UP HERE
	$header_image_height = 20; // SET UP HERE
	$alternative_featured_image = '/wp-content/featured-400x250.webp'; // SET UP HERE
	
	$url = 'https://'.$domain_parent.'/wp-json/wp/v2/posts?per_page='.$limit.'&_embed';
	$json = file_get_contents($url);
	$arr = json_decode($json, FALSE);
	
	if($header_mode=='text') {
		$result = '<div class="wpjhb-title">
						<div class="wpjhb-title-left">
							<div class="wpjhb-section-title">
								<h2><span>'.$header_text.'</span></h2>
							</div>
						</div>
						<div class="wpjhb-title-right">
							<a href="'.$more_url.'" onclick="lolay()">LIHAT '.strtoupper($header_text).' LAINNYA <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="#0F5D9B" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"></rect><line x1="40" y1="128" x2="216" y2="128" fill="none" stroke="#0F5D9B" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><polyline points="144 56 216 128 144 200" fill="none" stroke="#0F5D9B" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline></svg></a>
						</div>
					</div>';
	}
	else {
		$result = '<h2 style="margin:0px;padding-bottom:20px;text-align:center;"><img loading="lazy" width="'.$header_image_width.'" height="'.$header_image_height.'" src="'.$header_image.'" alt="'.$header_text.'"></h2>';
	}
	$result .= '<div class="wpjhb-content slider">';
	$now = date('Y-m-d H:i:s');
	$now_strtotime = strtotime($now);
	for($i=0; $i<$limit; $i++) {
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
		$date_converted = wpjhb_konversi_tanggal("j F Y", $date_converted, $bahasa="id");
		if($interval < $durasi_new) {
			$print_date_converted = $date_converted.' <span class="wpjhb-new">NEW</span>';
		}
		else {
			$print_date_converted = $date_converted;
		}
		$image = @$arr[$i]->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->{'et-pb-post-main-image'}->source_url;
		if($force_webp_thumbnail==TRUE) {
			$image = substr($image, 0, -strlen(pathinfo($image, PATHINFO_EXTENSION))).'webp';
		}
		if(!$image) {$image = $alternative_featured_image;}
		$result .= '<article class="wpjhb-single-item">
				<figure class="wpjhb-slide-image">
					<a href="'.$link.'" onclick="lolay()"><img loading="lazy" src="'.$image.'" width="400" height="250" alt="berita-'.$j.'" onerror="this.onerror=null;this.src=\''.$alternative_featured_image.'\';"></a>
				</figure>
				<div class="wpjhb-caption">
					<h2><a href="'.$link.'" onclick="lolay()">'.$title.'</a></h2>
					<div class="wpjhb-post-meta"><i class="fas fa-calendar-alt"></i> <time datetime="'.$date.'">'.$print_date_converted.'</time></div>
				</div>
			</article>';
	}
	$result .= '</div>
	<style>
	.wpjhb-title{margin-bottom:20px}
	.wpjhb-title .wpjhb-title-right{float:right}
	.wpjhb-title .wpjhb-title-left,.wpjhb-title .wpjhb-title-right{width:50%;position:relative;display:inline-block}
	.wpjhb-title .wpjhb-title-left .wpjhb-section-title h2{font-size:38px;margin-bottom:0;line-height:1.3;position:relative;font-weight:700;margin-top:0;color:#0a528b;letter-spacing:.15px;padding-bottom:0}
	.wpjhb-title .wpjhb-title-left .wpjhb-section-title h2:after{content:"";display:block;width:100%;height:2px;background-color:#ecd53c;position:absolute;top:50%;left:0;transform:translateY(-50%);z-index:0}
	.wpjhb-title .wpjhb-title-left .wpjhb-section-title h2 span{display:inline;padding-right:8px;position:relative;z-index:3;background-color:#E5F4FF}
	.wpjhb-title .wpjhb-title-right{text-align:right}
	.wpjhb-title .wpjhb-title-right a{margin-top:0;background-color:transparent;color:#0a528b;padding:4px 0 0;border:0;border-bottom:10px solid #ecd53c;display:inline-flex;align-items:center;gap:7px;font-size:13px;font-weight:500}
	.wpjhb-title .wpjhb-title-right a:hover{color:orange!important;}
	.wpjhb-title .wpjhb-title-right a svg{color:#0a528b;width:16px;height:16px}
	@media only screen and (max-width:390px){
		.wpjhb-title-left{width:100%!important;}
		.wpjhb-title-right{display:none!important;}
	}
	.wpjhb-content *{word-break:break-word;word-wrap:break-word;box-sizing:border-box}
	.wpjhb-content .slick-slide{flex-shrink:0;width:100%;height:100%;position:relative;transition-property:transform;margin:0 15px;border-radius:0;}
	.wpjhb-single-item{background:#fff;border:1px solid #c3ced9;overflow:hidden;vertical-align:middle;float:none;max-width:100%;direction:ltr}
	.wpjhb-slide-image{line-height:0;text-align:center;background:#C3CED9;opacity:1;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out;}
	.wpjhb-slide-image a img{margin:0 auto;max-width:100%;height:auto;box-shadow:none;object-fit:cover;object-position:center;transform:scale(1);transition:transform 0.3s ease-in-out;filter:blur(0);-webkit-filter:blur(0);}
	.wpjhb-slide-image a img:hover{transform:scale(1.05);}
	.wpjhb-caption{overflow:hidden;padding:1px;}
	.wpjhb-caption h2{font-size:17px;font-weight:600;line-height:1.2!important;padding:10px 10px 5px!important;}
	.wpjhb-caption h2 a{color:#0F5D9B;text-decoration:none;}
	.wpjhb-caption h2 a:hover{color:orange !important;}
	.wpjhb-caption .wpjhb-post-meta{margin:0;padding:0 10px 5px!important;color:#7a8a99;font-size:13px;}
	.wpjhb-caption .wpjhb-post-meta i{padding-right:2px;}
	.wpjhb-caption .wpjhb-post-meta .wpjhb-new{background:orange;color:#fff;font-size:13px;font-weight:400;padding:1px 3px;margin-left:3px;}
	.wpjhb-content .slick-dots{position:absolute;bottom:auto !important;display:block;width:100%;padding:10px 0 0 0 !important;margin:0 !important;list-style:none;text-align:center;}
	.wpjhb-content .slick-dots li button:before{color:#ccc!important;font-size:40px!important;opacity:.6!important;}
	.wpjhb-content .slick-dots li.slick-active button:before{color:#0A528B!important;opacity:.6!important;}
	.wpjhb-content .slick-prev:before, .wpjhb-content .slick-next:before {color:#0A528B;}
	</style>
	<script>
	//$(document).ready(function(){
	$(window).on("load",function() {
		if($.fn.slick) {
			$(".wpjhb-content").slick({
				arrows: false, dots: true, autoplay: true, autoplaySpeed: 2000, slidesToShow: 4, slidesToScroll: 1, infinite: true, swipeToSlide: true, focusOnSelect: true, pauseOnHover: true, responsive: [
				{breakpoint: 1600, settings: {slidesToShow:4}},
				{breakpoint: 1024, settings: {slidesToShow:3}},
				{breakpoint: 600, settings: {slidesToShow:2}},
				{breakpoint: 480, settings: {slidesToShow:1}}]
			});
		} else {
			//$("#section-berita").hide();
			//$("html").hide();
			location.reload();
		}
	});
	</script>';
	//$result .= '<span style="color:#E5F4FF;">'.number_format(microtime(true) - $start_time, 2).'sec</span>';
	return $result;
}
add_shortcode('wpjson_homepage_berita', 'wpjhb');

function wpjhb_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}

// HAS LOADED AT DIVI MENU INTEGRATION
// function load_slickcss() {
// 	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">';
// 	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">';
// }
// add_action('wp_head', 'load_slickcss');

// HAS LOADED AT DIVI MENU INTEGRATION
// function load_slickjs() {
//     wp_register_script(
//         'slickjs',
//         'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',
//         array('jquery')
//     );
//     wp_enqueue_script('slickjs');
// }
// add_action('wp_enqueue_scripts', 'load_slickjs');
