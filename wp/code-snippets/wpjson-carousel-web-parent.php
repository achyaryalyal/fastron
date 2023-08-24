/////////////////////////////////
// WPJSON Carousel Web Parent
/////////////////////////////////

function wpjc() {
	$items = 6; // SET UP HERE
	$domain_parent = 'bbg.ac.id'; // SET UP HERE
	
	$url = 'https://'.$domain_parent.'/wp-json/wp/v2/posts?per_page='.$items.'&_embed';
	$json = file_get_contents($url);
	$arr = json_decode($json, FALSE);
	$result = '<div class="wpjc slider">';
	for($i=0; $i<$items; $i++) {
		$j = $i + 1;
		$title = $arr[$i]->title->rendered;
		$title = preg_replace('/\s+/', ' ', $title); // remove multiple whitespaces
		$link = $arr[$i]->link;
		$date = $arr[$i]->date;
		$date_converted = date("j F Y", strtotime($date));
		$date_converted = wpjc_konversi_tanggal("j F Y", $date_converted, $bahasa="id");
		$image = @$arr[$i]->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->{'et-pb-post-main-image'}->source_url;
		if(!$image) {$image = '/wp-content/featured-400x250.webp';}
		$result .= '<article class="wpjc-single-item">
				<figure class="wpjc-slide-image">
					<a href="'.$link.'"> <img decoding="async" loading="lazy" class="skip-lazy" src="'.$image.'" alt="" width="400" height="250"></a>
				</figure>
				<div class="wpjc-all-captions">
					<h2 class="wpjc-post-title"><a href="'.$link.'">'.$title.'</a></h2>
					<div class="wpjc-post-meta"><i class="fa fa-calendar-alt"></i> <time datetime="'.$date.'">'.$date_converted.'</time></div>
				</div>
			</article>';
	}
	$result .= '</div>';
	return $result;
} 
add_shortcode('wpjson_carousel', 'wpjc');

function wpjc_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
	$en = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","January","February","March","April","May","June","July","August","September","October","November","December");
	$en_singkat = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	$id = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$id_singkat = array("Min","Sen","Sel","Rab","Kam","Jum","Sab","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
	return str_replace($en, $$bahasa, date($format,strtotime($tanggal)));
}

function load_slickcss() {
	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">';
	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">';
	echo '<style>
	.wpjc * {
		word-break: break-word;
		word-wrap: break-word;
		box-sizing: border-box;
	}
	.wpjc .slick-slide {
		flex-shrink: 0;
		width: 100%;
		height: 100%;
		position: relative;
		transition-property: transform;
		margin: 0 15px;
		border-radius: 10px;
	}
	.wpjc-single-item {
		background: #1181bd;
		background: -moz-linear-gradient(left, #1181bd 0%, #2f2a95 100%);
		background: -webkit-linear-gradient(left, #1181bd 0%, #2f2a95 100%);
		background: linear-gradient(to right, #1181bd 0%, #2f2a95 100%);
		border: 1px solid #1181bd;
		overflow: hidden;
		vertical-align: middle;
		float: none;
		max-width: 100%;
		direction: ltr;
	}
	.wpjc-single-item:hover {
		background: #FF8200;
		border: 1px solid #FF8200;
	}
	.wpjc-slide-image {
		line-height: 0;
		text-align: center;
		background: #FF8200;
		opacity: 1;
		-webkit-transition: .3s ease-in-out;
		transition: .3s ease-in-out;
	}
	.wpjc-slide-image:hover {
		opacity: .5;
	}
	.wpjc-slide-image a img {
	    margin: 0 auto;
		max-width: 100%;
		height: auto;
		box-shadow: none;
	}
	.wpjc-all-captions {
		overflow: hidden;
		padding: 1px;
	}
	.wpjc-post-meta {
		margin: 0;
		padding: 0 10px 5px 10px !important;
		color: #EBEBEB;
		font-family: \'Roboto Condensed\',Helvetica,Arial,Lucida,sans-serif;
		font-size: 13px;
	}
	.wpjc-post-meta i {
		padding-right: 2px;
	}
	.wpjc-all-captions li {
		list-style: none;
		margin: 0;
	}
	.wpjc-all-captions h2 {
		font-family: \'Roboto Condensed\',Helvetica,Arial,Lucida,sans-serif;
		font-size: 16px;
		font-weight: 600;
		padding: 10px 10px 5px !important;
	}
	.wpjc-single-item h2 a {
		color: #FFF;
    	text-decoration: none;
		text-shadow: 0 0 3px #111;
	}
	.slick-dots li button:before {
		color: #CCC !important;
		font-size: 12px !important;
		opacity: 0.6 !important;
	}
	.slick-dots li.slick-active button:before {
		color: #FF8200 !important;
		opacity: 0.6 !important;
	}
	</style>';
}
add_action('wp_head', 'load_slickcss');

function load_slickjs() {
    wp_register_script(
        'slickjs',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',
        array('jquery')
    );
    wp_enqueue_script('slickjs');
}
add_action('wp_enqueue_scripts', 'load_slickjs');

function init_slick_footer() {
	echo '<script>
	jQuery(function($){
		$(".wpjc").slick({
			arrows: true,
			dots: false,
			autoplay: true,
			autoplaySpeed: 2000,
			slidesToShow: 3,
			slidesToScroll: 1,
			infinite: true,
			swipeToSlide: true,
			focusOnSelect: true,
			pauseOnHover: true,
			responsive: [{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1
				}
			}]
		});
	});
	</script>';
}
add_action('wp_footer', 'init_slick_footer');
