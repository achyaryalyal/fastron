/////////////////////////////////
// WP Homepage SLIDER
/////////////////////////////////

function wphs() {
	$url_onclick = '';
	$image_width = 1920;
	$image_height = 640;
	$play_duration = 4000;
	$play_duration_minus_1_second = $play_duration - 1000;
	
	$logo = array(
		'https://bbg.ac.id/wp-content/uploads/2023/12/slider-1b-m6-q50.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/09/slider-2-m6-q50.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/09/slider-4-m6-q50.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/09/slider-3-m6-q50.webp'
	);
	$result = '<div class="wphs slider">';
	$i=0;
	foreach($logo as $image) {
		$i++;
		if($i>1) {
			$print_loading_lazy = 'style="display:none;"';
		}
		else {
			$print_loading_lazy = '';
		}
		if($url_onclick!='') {
			$result .= '<div class="wphs-slide-image"><a href="'.$url_onclick.'" target="_blank"><img class="wphs-slide-image-file" src="'.$image.'" '.$print_loading_lazy.' width="1920" height="640" alt="slider-'.$i.'"></a></div>';
		}
		else {
			$result .= '<div class="wphs-slide-image"><img class="wphs-slide-image-file" src="'.$image.'" '.$print_loading_lazy.' width="'.$image_width.'" height="'.$image_height.'" alt="slider-'.$i.'"></div>';
		}
	}
	$result .= '</div>
	<style>
	.wphs{background:#E5F4FF;margin:0 auto;padding:0;width:100%;}
	.wphs .slick-slide{flex-shrink:0;width:100%;height:100%;position:relative;transition-property:transform;margin:0;border-radius:3px}
	.wphs.slick-dotted.slick-slider{margin-bottom:0;}
	.wphs-slide-image{line-height:0;text-align:center;opacity:1;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out}
	.wphs-slide-image img, .wphs-slide-image a img{margin:0 auto;max-width:100%;height:auto;box-shadow:none;filter:blur(0);-webkit-filter:blur(0);}
	.wphs .slick-prev{left:15px;top:49%;z-index:1;}
	.wphs .slick-prev:before{content:"\f104";font-size:30px;font-family:"FontAwesome";opacity:.6;}
	.wphs .slick-next{right:15px;top:49%;}
	.wphs .slick-next:before{content:"\f105";font-size:30px;font-family:"FontAwesome";opacity:.6;}
	@media (max-width:980px){
		.wphs .slick-prev:before, .wphs .slick-next:before{font-size:14px;}
	}
	.wphs .slick-dots{bottom:0!important;padding:0!important;margin:0!important;}
	.wphs .slick-dots li{margin:0 5px 5px 5px;}
	.wphs .slick-dots li button:before{color:#ccc!important;font-size:12px!important;opacity:.6!important}
	.wphs .slick-dots li.slick-active button:before{color:#ff8200!important;opacity:.6!important}
	</style>
	<script>
	//$(document).ready(function() {
	$(window).on("load",function() {
		if($.fn.slick) {
			$(".wphs").slick({
			  arrows: true, dots: false, autoplay: true, autoplaySpeed: '.$play_duration.', speed: 1000, fade: true, cssEase: "linear", slidesToShow: 1, infinite: true, swipeToSlide: true, focusOnSelect: true, pauseOnHover: false
			});
			setTimeout(function(){
				$(".wphs-slide-image-file").css("display","block");
			},'.$play_duration_minus_1_second.')
		} else {
			//$("#section-home-slider").hide();
			//$("html").hide();
			location.reload();
		}
	});
	</script>';
	return $result;
}
add_shortcode('wp_homepage_slider', 'wphs');

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
