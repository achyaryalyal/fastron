/////////////////////////////////
// Redirect to WP-Statistics After Login
/////////////////////////////////

function admin_default_page() {
	if(is_plugin_active('wp-statistics/wp-statistics.php')) {
		//plugin is activated
		return '/wp-admin/admin.php?page=wps_overview_page';
	}
	else {
		return '/wp-admin/index.php';
	}
}
add_filter('login_redirect', 'admin_default_page');
