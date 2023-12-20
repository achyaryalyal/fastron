/////////////////////////////////
// WP Carousel Logo Partner
/////////////////////////////////

function wpclp() {
	$url_onclick = 'https://simkerma.bbg.ac.id';
	
	$logo = array(
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-geodrive.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-huawei.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-icaios.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-iconplus.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-rsudza.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-srinakharinwirot.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-upsi.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-usk.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-ukm.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-disbudpar-bna.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-esa-unggul.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-koni-aceh.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-perpusnas.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-rsud-meuraxa.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-telkom.webp',
		'https://bbg.ac.id/wp-content/uploads/2023/08/partner-uncen.webp'
	);
	$result = '<div class="wpclp slider">';
	$i=0;
	foreach($logo as $image) {
		$i++;
		if($url_onclick!='') {
			$result .= '<div class="wpclp-slide-image"><a href="'.$url_onclick.'" target="_blank"><img loading="lazy" src="'.$image.'" alt="partner-'.$i.'"></a></div>';
		}
		else {
			$result .= '<div class="wpclp-slide-image"><img loading="lazy" src="'.$image.'" alt="partner-'.$i.'"></div>';
		}
	}
	$result .= '</div>
	<style>
	/*.wpclp{background:#fff;background:-moz-linear-gradient(top,#fff 0,#e5f4ff 95%);background:-webkit-linear-gradient(top,#fff 0,#e5f4ff 95%);background:linear-gradient(to bottom,#fff 0,#e5f4ff 95%);border-radius:20px;margin:0 auto;padding:15px;width:90%}*/
	.wpclp{background:#E5F4FF;margin:0 auto;padding:15px;width:100%}
	.wpclp .slick-slide{flex-shrink:0;width:100%;height:100%;position:relative;transition-property:transform;margin:0 15px;border-radius:3px}
	.wpclp-slide-image{line-height:0;text-align:center;opacity:1;-webkit-transition:.3s ease-in-out;transition:.3s ease-in-out}
	.wpclp-slide-image a img{margin:0 auto;max-width:100%;height:auto;box-shadow:none}
	.wpclp-slide-image a img:hover{opacity:0.5}
	.wpclp .slick-dots li button:before{color:#ccc!important;font-size:12px!important;opacity:.6!important}
	.wpclp .slick-dots li.slick-active button:before{color:#ff8200!important;opacity:.6!important}
	</style>
	<script>
	//$(document).ready(function() {
	$(window).on("load",function() {
		if($.fn.slick) {
			$(".wpclp").slick({
				arrows: false, dots: false, autoplay: true, autoplaySpeed: 0, speed: 5000, slidesToShow: 8, slidesToScroll: 1, infinite: true, swipeToSlide: true, focusOnSelect: true, pauseOnHover: true, responsive: [
				{breakpoint: 1920, settings: {slidesToShow:8}},
				{breakpoint: 1600, settings: {slidesToShow:7}},
				{breakpoint: 1024, settings: {slidesToShow:6}},
				{breakpoint: 600, settings: {slidesToShow:5}},
				{breakpoint: 480, settings: {slidesToShow:4}}]
			});
		} else {
			//$("#section-partnership").hide();
			//$("html").hide();
			location.reload();
		}
	});
	</script>';
	return $result;
}
add_shortcode('wpc_logo_partner', 'wpclp');

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
