function add_mpdf_pdfbutton($content) {
    if(is_single()) {
		if(function_exists('mpdf_pdfbutton')) {
			return $content . mpdf_pdfbutton(false, '<i class="far fa-file-pdf"></i> PDF version');
		}
		else {
			return $content;
		}
	}
	else {
		return $content;
	}
}
add_filter('the_content', 'add_mpdf_pdfbutton');

function style_mpdf_pdfbutton(){
?>
  <script>
  (function($){
    $(document).ready(function(){
		if($(".et_pb_title_container h1").is(':contains("BBG TV:"), :contains("Video:")')) {
			$(".pdfbutton").css({"display":"none"});
		}
		else {
			$(".pdfbutton").css({"color":"#222"});
			$(".pdfbutton").css({"background-color":"#fff"});
			$(".pdfbutton").css({"border":"1px solid #E6E6E6"});
			$(".pdfbutton").css({"display":"block"});
			$(".pdfbutton").css({"font-size":"10px"});
			$(".pdfbutton").css({"font-family":"'Open Sans',Arial,sans-serif"});
			$(".pdfbutton").css({"font-weight":"600"});
			$(".pdfbutton").css({"margin-bottom":"15px"});
			$(".pdfbutton").css({"width":"100px"});
			$(".pdfbutton i").css({"background-color":"#e74c3c"});
			$(".pdfbutton i").css({"color":"#fff"});
			$(".pdfbutton i").css({"line-height":"24px"});
			$(".pdfbutton i").css({"margin-right":"3px"});
			$(".pdfbutton i").css({"height":"24px"});
			$(".pdfbutton i").css({"padding-left":"8px"});
			$(".pdfbutton i").css({"width":"24px"});
		}
    });
  })(jQuery);
  </script>
<?php
}
add_action('wp_footer', 'style_mpdf_pdfbutton');
