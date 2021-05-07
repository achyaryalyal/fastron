function hide_featured_image(){
?>
  <script>
  (function($){
    $(document).ready(function(){
		if($(".et_pb_title_container h1").is(':contains("BBG TV:"), :contains("Video:")')) {
			$(".et_pb_title_featured_container img").css({"display":"none"});
			$(".et_pb_title_container h1").css({"margin-top":"0"});
		}
    });
  })(jQuery);
  </script>
<?php
}
add_action('wp_footer', 'hide_featured_image');
