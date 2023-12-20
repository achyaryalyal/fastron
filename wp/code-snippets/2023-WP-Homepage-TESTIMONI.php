/////////////////////////////////
// WP Homepage TESTIMONI
/////////////////////////////////

function wpht() {
	$arr = array(
		array(
			"name"=>"Mulyadi Syahputra, M.Pd", 
			"whois"=>"S1 Pendidikan Bahasa Inggris, Pelatih Debat SMA dan Perguruan Tinggi Tingkat Nasional", 
			"quote"=>"Keterampilan bahasa Inggris yang saya peroleh di UBBG mengantarkan saya menjadi juara debat tingkat nasional. Prestasi yang luar biasa ini membuat saya dipercaya menjadi pelatih debat di sekolah dan kampus ternama di Aceh dan berhasil memenangkan kompetisi tingkat regional dan nasional.", 
			"image"=>"https://bbg.ac.id/wp-content/uploads/2023/09/testi-mulyadi.webp"
		),
		array(
			"name"=>"Fuad Ramadhan, S.Pd", 
			"whois"=>"S1 Pendidikan Jasmani, Atlet Lari Peraih Medali Emas PON 2016 & 2021", 
			"quote"=>"UBBG memberi ruang yang begitu besar dalam berkreativitas dan pengembangan diri sehingga banyak menghasilkan talenta-talenta muda yang berprestasi. Terima kasih untuk semua dosen UBBG yang telah membimbing saya dalam menggapai impian.", 
			"image"=>"https://bbg.ac.id/wp-content/uploads/2023/09/testi-fuad.webp"
		),
		array(
			"name"=>"Ners Irma Maiyati, S.Kep", 
			"whois"=>"Pendidikan Profesi Ners, Peraih Awards Inspiratif 2022", 
			"quote"=>"Dunia medis Indonesia sangat membutuhkan SDM unggul. Bagi saya, UBBG adalah kampus yang tepat dalam mencetak lulusan handal untuk meningkatkan pelayanan kesehatan modern. Bangga saya menjadi alumni UBBG.", 
			"image"=>"https://bbg.ac.id/wp-content/uploads/2023/09/testi-irma.webp"
		),
		array(
			"name"=>"Intan Makfirah, S.Pd", 
			"whois"=>"S1 Pendidikan Bahasa Indonesia, Pengajar di SMA Fatih Bilingual School Banda Aceh", 
			"quote"=>"Selama kuliah di UBBG, saya mendapatkan  banyak ilmu dan pengalaman tentang bagaimana menjadi seorang guru milenial yang kreatif, inovatif, dan  mampu menyesuaikan diri dengan  proses pembelajaran di zaman modern.", 
			"image"=>"https://bbg.ac.id/wp-content/uploads/2023/09/testi-intan.webp"
		)
	);
	
	$result = '<div class="wpht-content slider">';
	$i=0;
	foreach($arr as $testimoni) {
		$j = $i + 1;
		$name = $arr[$i]['name'];
		$whois = $arr[$i]['whois'];
		$quote = $arr[$i]['quote'];
		$image = $arr[$i]['image'];
		$result .= '<article class="wpht-single-item">
						<div class="wpht-slide-body">
							<div class="wpht-testimoni">
								<i class="fa fa-quote-left"></i>
								<p class="quote">'.$quote.'</p>
								<p class="overview"><img src="'.$image.'" width="80" height="80" alt="alumni-'.$j.'"> <span>'.$name.'</span> <br> '.$whois.'</p>
							</div>
						</div>
					</article>';
		$i++;
	}
	$result .= '</div>
	<style>
	#apa-kata-mereka h2{font-size:38px;margin-bottom:0;line-height:1.3;position:relative;font-weight:700;margin-top:0;color:#0A528B;letter-spacing:.15px;padding-bottom:0;display:inline;padding-bottom:8px;padding-right:8px;position:relative;z-index:3;}
	#apa-kata-mereka p{border-top:10px solid #ECD53C;padding-top:20px;}
	.wpht-content *{word-break:break-word;word-wrap:break-word;box-sizing:border-box;}
	.wpht-content .slick-slide{flex-shrink:0;width:100%;height:100%;position:relative;transition-property:transform;margin:0 15px;border-radius:0;padding:15px;}
	.wpht-single-item{background:#0A528B;border:1px solid #c3ced9;overflow:hidden;vertical-align:middle;float:none;max-width:100%;direction:ltr;margin-bottom:20px;}
	.wpht-slide-body{display:table-cell;vertical-align:top;}
	.wpht-testimoni{color:#FFF;padding:0 15px 0 55px;position:relative;line-height:22px;}
	.wpht-testimoni i{color:#FFF;font-weight:900;font-size:38px;line-height:54px;position:absolute;left:5px;top:-7px;}
	.wpht-testimoni p.quote{font-family:"Noto Serif",Georgia,"Times New Roman",serif;font-style:italic;}
	.wpht-testimoni p.overview{font-size:13px;line-height:18px;}
	.wpht-testimoni p.overview img{display:block;border-radius:50%;float:left;width:80px;margin-right:10px;}
	.wpht-testimoni p.overview span{color:#ECD53C;font-size:15px;font-weight:700;}
	.wpht-content .slick-dots{position:absolute;bottom:auto !important;display:block;width:100%;padding:10px 0 0 0 !important;margin:0 !important;list-style:none;text-align:center;}
	.wpht-content .slick-dots li button:before{color:#ccc!important;font-size:12px!important;opacity:.6!important;}
	.wpht-content .slick-dots li.slick-active button:before{color:#0A528B!important;opacity:.6!important;}
	.wpht-content .slick-prev:before, .wpht-content .slick-next:before{color:#0A528B;}
	</style>
	<script>
	$(document).ready(function(){
		if($.fn.slick) {
			$(".wpht-content").slick({
				arrows: false, dots: false, autoplay: true, autoplaySpeed: 5000, slidesToShow: 2, slidesToScroll: 1, infinite: true, swipeToSlide: true, focusOnSelect: true, pauseOnHover: true, responsive: [
					{breakpoint: 800, settings: {slidesToShow:1}}
				]
			});
		} else {
			//$("#section-testimoni").hide();
			//$("html").hide();
			location.reload();
		}
	});
	</script>';
	return $result;
}
add_shortcode('wp_homepage_testimoni', 'wpht');

function wpht_konversi_tanggal($format, $tanggal="now", $bahasa="id") {
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
