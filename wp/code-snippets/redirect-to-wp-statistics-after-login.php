/////////////////////////////////
// Redirect to WP-Statistics After Login
// (for administrator role)
/////////////////////////////////

function admin_default_page() {
	if(is_plugin_active('wp-statistics/wp-statistics.php') && is_admin()==TRUE) {
		return '/wp-admin/admin.php?page=wps_overview_page';
	}
	else {
		return '/wp-admin/index.php';
	}
}
add_filter('login_redirect', 'admin_default_page');
